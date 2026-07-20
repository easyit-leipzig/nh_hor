<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/bootstrap.php';
require_once __DIR__ . '/../../includes/security.php';
require_once __DIR__ . '/../../includes/functions.php';
security_send_headers();
require_once __DIR__ . '/../../includes/database.php';

function admin_user(): ?array
{
    ensure_session_started();
    $user = $_SESSION['admin_user'] ?? null;
    return is_array($user) ? $user : null;
}

function admin_require_login(): void
{
    if (!admin_user()) {
        header('Location: ' . app_path('/admin/login.php'), true, 303);
        exit;
    }
}

function admin_has_role(string ...$roles): bool
{
    $user = admin_user();
    return $user !== null && in_array((string)($user['role'] ?? ''), $roles, true);
}

function admin_require_role(string ...$roles): void
{
    admin_require_login();
    if (!admin_has_role(...$roles)) {
        http_response_code(403);
        exit('Keine Berechtigung für diese Aktion.');
    }
}

function admin_login(string $username, string $password): bool
{
    if (!db_available()) return false;

    $stmt = db()->prepare(
        'SELECT id, username, email, password_hash, role
         FROM admin_users
         WHERE username = :username AND is_active = 1
         LIMIT 1'
    );
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, (string)$user['password_hash'])) return false;

    if (password_needs_rehash((string)$user['password_hash'], PASSWORD_DEFAULT)) {
        $rehash = db()->prepare('UPDATE admin_users SET password_hash = :hash WHERE id = :id');
        $rehash->execute(['hash' => password_hash($password, PASSWORD_DEFAULT), 'id' => $user['id']]);
    }

    ensure_session_started();
    session_regenerate_id(true);
    $_SESSION['admin_user'] = [
        'id' => (int)$user['id'],
        'username' => (string)$user['username'],
        'email' => (string)$user['email'],
        'role' => (string)$user['role'],
    ];
    unset($_SESSION['csrf_token']);

    $update = db()->prepare('UPDATE admin_users SET last_login_at = NOW() WHERE id = :id');
    $update->execute(['id' => $user['id']]);
    return true;
}

function admin_logout(): void
{
    ensure_session_started();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
