<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/security.php';
require_once __DIR__ . '/../../includes/database.php';

function admin_user(): ?array
{
    ensure_session_started();
    return $_SESSION['admin_user'] ?? null;
}

function admin_require_login(): void
{
    if (!admin_user()) {
        header('Location: /admin/login.php', true, 303);
        exit;
    }
}

function admin_login(string $username, string $password): bool
{
    if (!db_available()) {
        return false;
    }

    $stmt = db()->prepare(
        'SELECT id, username, email, password_hash, role
         FROM admin_users
         WHERE username = :username AND is_active = 1
         LIMIT 1'
    );
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return false;
    }

    ensure_session_started();
    session_regenerate_id(true);
    $_SESSION['admin_user'] = [
        'id' => (int)$user['id'],
        'username' => $user['username'],
        'email' => $user['email'],
        'role' => $user['role'],
    ];

    $update = db()->prepare('UPDATE admin_users SET last_login_at = NOW() WHERE id = :id');
    $update->execute(['id' => $user['id']]);

    return true;
}

function admin_logout(): void
{
    ensure_session_started();
    unset($_SESSION['admin_user']);
    session_regenerate_id(true);
}
