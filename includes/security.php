<?php
declare(strict_types=1);

function ensure_session_started(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_name('easyit_session');
        session_start([
            'cookie_httponly' => true,
            'cookie_samesite' => 'Lax',
            'cookie_secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'use_strict_mode' => true,
        ]);
    }
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

function rate_limit_ok(int $seconds): bool
{
    ensure_session_started();
    $now = time();
    $last = (int)($_SESSION['contact_last_submit'] ?? 0);
    if ($last > 0 && ($now - $last) < $seconds) {
        return false;
    }
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
