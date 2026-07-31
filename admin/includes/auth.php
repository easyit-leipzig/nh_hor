<?php
declare(strict_types=1);

require_once __DIR__ . '/../../includes/internal-auth.php';

function admin_user(): ?array
{
    $user = internal_user();
    if (!$user || ($user['role_key'] ?? '') !== 'admin') {
        return null;
    }

    return [
        'id' => (int)$user['id'],
        'username' => (string)$user['username'],
        'email' => (string)($user['email'] ?? ''),
        'role' => 'admin',
    ];
}

function admin_require_login(): void
{
    if (!admin_user()) {
        header('Location: ' . app_path('/intern/login.php'), true, 303);
        exit;
    }
}

function admin_has_role(string ...$roles): bool
{
    return admin_user() !== null && in_array('admin', $roles, true);
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
    return internal_login($username, $password)
        && internal_has_role('admin');
}

function admin_logout(): void
{
    internal_logout();
}
