<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/database.php';

function internal_session_start(): bool
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return true;
    }

    if (headers_sent($file, $line)) {
        error_log(sprintf(
            '[easyIT session] Session konnte nicht gestartet werden; Ausgabe bereits in %s:%d.',
            $file,
            $line
        ));
        return false;
    }

    ensure_session_started();
    return session_status() === PHP_SESSION_ACTIVE;
}

function internal_user(bool $startSession = true): ?array
{
    if ($startSession) {
        if (!internal_session_start()) {
            return null;
        }
    } elseif (session_status() !== PHP_SESSION_ACTIVE) {
        return null;
    }

    $user = $_SESSION['internal_user'] ?? null;
    return is_array($user) ? $user : null;
}

function internal_login(string $username, string $password): bool
{
    if (!db_available() || !internal_session_start()) {
        return false;
    }

    $stmt = db()->prepare(
        'SELECT u.id, u.username, u.display_name, u.email, u.password_hash,
                u.is_active, r.id AS role_id, r.role_key, r.role_name,
                r.is_active AS role_is_active
         FROM internal_users u
         INNER JOIN internal_roles r ON r.id = u.role_id
         WHERE u.username = :username
         LIMIT 1'
    );
    $stmt->execute(['username' => trim($username)]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row
        || (int)$row['is_active'] !== 1
        || (int)$row['role_is_active'] !== 1
        || !password_verify($password, (string)$row['password_hash'])) {
        return false;
    }

    session_regenerate_id(true);

    $_SESSION['internal_user'] = [
        'id' => (int)$row['id'],
        'username' => (string)$row['username'],
        'display_name' => (string)$row['display_name'],
        'email' => (string)($row['email'] ?? ''),
        'role_id' => (int)$row['role_id'],
        'role_key' => (string)$row['role_key'],
        'role_name' => (string)$row['role_name'],
    ];
    $_SESSION['internal_validated_at'] = time();

    if ((string)$row['role_key'] === 'admin') {
        $_SESSION['admin_user'] = [
            'id' => (int)$row['id'],
            'username' => (string)$row['username'],
            'email' => (string)($row['email'] ?? ''),
            'role' => 'admin',
        ];
        $_SESSION['admin_validated_at'] = time();
    } else {
        unset($_SESSION['admin_user'], $_SESSION['admin_validated_at']);
    }

    db()->prepare('UPDATE internal_users SET last_login_at = NOW() WHERE id = :id')
        ->execute(['id' => (int)$row['id']]);

    return true;
}

function internal_logout(bool $destroySession = true): void
{
    if (!internal_session_start()) {
        return;
    }

    unset(
        $_SESSION['internal_user'],
        $_SESSION['internal_validated_at'],
        $_SESSION['admin_user'],
        $_SESSION['admin_validated_at'],
        $_SESSION['csrf_token']
    );

    if ($destroySession) {
        $_SESSION = [];
        session_destroy();
    }
}

function internal_require_login(): void
{
    if (!internal_user(true)) {
        header('Location: ' . app_path('/intern/login.php'), true, 303);
        exit;
    }
}

function internal_has_role(string ...$roles): bool
{
    $user = internal_user(true);
    return $user !== null
        && in_array((string)($user['role_key'] ?? ''), $roles, true);
}

function internal_require_role(string ...$roles): void
{
    internal_require_login();
    if (!internal_has_role(...$roles)) {
        http_response_code(403);
        exit('Keine Berechtigung für diese Aktion.');
    }
}

function internal_start_path(?array $user = null): string
{
    $user ??= internal_user(true);
    $role = (string)($user['role_key'] ?? '');

    return match ($role) {
        'admin' => app_path('/admin.php'),
        'mitarbeiter' => app_path('/intern/mitarbeiter/index.php'),
        'lehrer' => app_path('/intern/lehrer/index.php'),
        'schueler' => app_path('/intern/schueler/index.php'),
        'eltern' => app_path('/intern/eltern/index.php'),
        'viewer' => app_path('/intern/viewer/index.php'),
        default => app_path('/intern/logout.php'),
    };
}
