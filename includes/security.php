<?php
declare(strict_types=1);

const EASYIT_SESSION_ABSOLUTE_TIMEOUT = 28800; // 8 hours
const EASYIT_SESSION_INACTIVITY_TIMEOUT = 1800; // 30 minutes
const EASYIT_LOGIN_WINDOW = 900; // 15 minutes
const EASYIT_LOGIN_MAX_ATTEMPTS = 5;
const EASYIT_LOGIN_LOCKOUT = 900; // 15 minutes
const EASYIT_SESSION_REGENERATE_INTERVAL = 900; // 15 minutes

function request_is_https(): bool
{
    if (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off') {
        return true;
    }
    return strtolower((string)($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https';
}

function ensure_session_started(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        enforce_session_timeouts();
        return;
    }

    session_name('easyit_session');
    session_start([
        'cookie_lifetime' => 0,
        'cookie_path' => '/',
        'cookie_secure' => request_is_https(),
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true,
        'use_only_cookies' => true,
        'use_trans_sid' => false,
        'gc_maxlifetime' => EASYIT_SESSION_ABSOLUTE_TIMEOUT,
        'cache_limiter' => 'nocache',
    ]);

    $now = time();
    $_SESSION['created_at'] = (int)($_SESSION['created_at'] ?? $now);
    $_SESSION['last_activity_at'] = (int)($_SESSION['last_activity_at'] ?? $now);
    $_SESSION['regenerated_at'] = (int)($_SESSION['regenerated_at'] ?? $now);
    $_SESSION['user_agent_hash'] = (string)($_SESSION['user_agent_hash'] ?? hash('sha256', (string)($_SERVER['HTTP_USER_AGENT'] ?? '')));
    enforce_session_timeouts();
}

function enforce_session_timeouts(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        return;
    }

    $now = time();
    $created = (int)($_SESSION['created_at'] ?? $now);
    $lastActivity = (int)($_SESSION['last_activity_at'] ?? $now);

    $expectedAgent = (string)($_SESSION['user_agent_hash'] ?? '');
    $currentAgent = hash('sha256', (string)($_SERVER['HTTP_USER_AGENT'] ?? ''));
    $fingerprintMismatch = $expectedAgent !== '' && !hash_equals($expectedAgent, $currentAgent);

    if ($fingerprintMismatch || ($now - $created) > EASYIT_SESSION_ABSOLUTE_TIMEOUT || ($now - $lastActivity) > EASYIT_SESSION_INACTIVITY_TIMEOUT) {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires' => $now - 42000,
                'path' => $params['path'] ?: '/',
                'domain' => $params['domain'] ?? '',
                'secure' => (bool)$params['secure'],
                'httponly' => (bool)$params['httponly'],
                'samesite' => $params['samesite'] ?? 'Lax',
            ]);
        }
        session_destroy();
        session_start();
        session_regenerate_id(true);
        $_SESSION['created_at'] = $now;
        $_SESSION['regenerated_at'] = $now;
        $_SESSION['user_agent_hash'] = $currentAgent;
    } elseif (($now - (int)($_SESSION['regenerated_at'] ?? $now)) >= EASYIT_SESSION_REGENERATE_INTERVAL) {
        session_regenerate_id(true);
        $_SESSION['regenerated_at'] = $now;
    }

    $_SESSION['last_activity_at'] = $now;
}

function csrf_token(): string
{
    ensure_session_started();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_is_valid(?string $token): bool
{
    ensure_session_started();
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

function client_fingerprint(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    return hash('sha256', $ip . '|' . $ua);
}

function login_rate_key(string $username): string
{
    $normalized = mb_strtolower(trim($username));
    return hash('sha256', client_fingerprint() . '|' . $normalized);
}

function login_rate_file(): string
{
    $directory = dirname(__DIR__) . '/storage/security';
    if (!is_dir($directory) && !mkdir($directory, 0700, true) && !is_dir($directory)) {
        throw new RuntimeException('Sicherheitsverzeichnis konnte nicht angelegt werden.');
    }
    return $directory . '/login-attempts.json';
}

function login_rate_read_locked($handle): array
{
    rewind($handle);
    $json = stream_get_contents($handle);
    $data = is_string($json) && $json !== '' ? json_decode($json, true) : [];
    return is_array($data) ? $data : [];
}

function login_rate_status(string $username): array
{
    $file = login_rate_file();
    $handle = fopen($file, 'c+');
    if ($handle === false) {
        return ['allowed' => false, 'retry_after' => EASYIT_LOGIN_LOCKOUT, 'attempts' => 0];
    }
    try {
        flock($handle, LOCK_EX);
        $data = login_rate_read_locked($handle);
        $now = time();
        $key = login_rate_key($username);
        $record = is_array($data[$key] ?? null) ? $data[$key] : ['attempts' => [], 'locked_until' => 0];
        $attempts = array_values(array_filter((array)($record['attempts'] ?? []), static fn($t): bool => is_int($t) && $t >= $now - EASYIT_LOGIN_WINDOW));
        $lockedUntil = (int)($record['locked_until'] ?? 0);
        if ($lockedUntil <= $now) {
            $lockedUntil = 0;
        }
        $data[$key] = ['attempts' => $attempts, 'locked_until' => $lockedUntil, 'updated_at' => $now];
        ftruncate($handle, 0); rewind($handle);
        fwrite($handle, json_encode($data, JSON_UNESCAPED_SLASHES));
        fflush($handle);
        return ['allowed' => $lockedUntil === 0 && count($attempts) < EASYIT_LOGIN_MAX_ATTEMPTS, 'retry_after' => max(0, $lockedUntil - $now), 'attempts' => count($attempts)];
    } finally {
        flock($handle, LOCK_UN); fclose($handle);
    }
}

function login_rate_record_failure(string $username): array
{
    $file = login_rate_file();
    $handle = fopen($file, 'c+');
    if ($handle === false) {
        return ['allowed' => false, 'retry_after' => EASYIT_LOGIN_LOCKOUT, 'attempts' => EASYIT_LOGIN_MAX_ATTEMPTS];
    }
    try {
        flock($handle, LOCK_EX);
        $data = login_rate_read_locked($handle);
        $now = time();
        $key = login_rate_key($username);
        $record = is_array($data[$key] ?? null) ? $data[$key] : ['attempts' => [], 'locked_until' => 0];
        $attempts = array_values(array_filter((array)($record['attempts'] ?? []), static fn($t): bool => is_int($t) && $t >= $now - EASYIT_LOGIN_WINDOW));
        $attempts[] = $now;
        $lockedUntil = count($attempts) >= EASYIT_LOGIN_MAX_ATTEMPTS ? $now + EASYIT_LOGIN_LOCKOUT : 0;
        $data[$key] = ['attempts' => $attempts, 'locked_until' => $lockedUntil, 'updated_at' => $now];
        ftruncate($handle, 0); rewind($handle);
        fwrite($handle, json_encode($data, JSON_UNESCAPED_SLASHES));
        fflush($handle);
        return ['allowed' => $lockedUntil === 0, 'retry_after' => max(0, $lockedUntil - $now), 'attempts' => count($attempts)];
    } finally {
        flock($handle, LOCK_UN); fclose($handle);
    }
}

function login_rate_clear(string $username): void
{
    $file = login_rate_file();
    $handle = fopen($file, 'c+');
    if ($handle === false) return;
    try {
        flock($handle, LOCK_EX);
        $data = login_rate_read_locked($handle);
        unset($data[login_rate_key($username)]);
        ftruncate($handle, 0); rewind($handle);
        fwrite($handle, json_encode($data, JSON_UNESCAPED_SLASHES));
        fflush($handle);
    } finally {
        flock($handle, LOCK_UN); fclose($handle);
    }
}

function rate_limit_ok(int $seconds): bool
{
    ensure_session_started();
    $now = time();
    $last = (int)($_SESSION['contact_last_submit'] ?? 0);
    if ($last > 0 && ($now - $last) < $seconds) return false;
    $_SESSION['contact_last_submit'] = $now;
    return true;
}

function sanitize_line(string $value): string
{
    $value = trim($value);
    return preg_replace('/[\r\n]+/', ' ', $value) ?? '';
}

function validate_email_address(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
