<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../includes/functions.php';

function internal_user(): ?array
{
    $user = $_SESSION['internal_user'] ?? null;
    return is_array($user) ? $user : null;
}

function internal_is_logged_in(): bool
{
    return internal_user() !== null;
}

function internal_require_login(): void
{
    if (!internal_is_logged_in()) {
        header('Location: ' . app_path('/intern/login.php'), true, 303);
        exit;
    }
}

function internal_require_role(string|array $roles): void
{
    internal_require_login();

    $roles = is_array($roles) ? $roles : [$roles];
    $role = (string)(internal_user()['role_key'] ?? '');

    if (!in_array($role, $roles, true)) {
        http_response_code(403);
        require __DIR__ . '/../zugriff-verweigert.php';
        exit;
    }
}
