<?php
declare(strict_types=1);
require __DIR__ . '/includes/auth.php';
admin_require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
    http_response_code(405);
    exit('Ungültige Abmeldeanfrage.');
}
admin_logout();
header('Location: ' . app_path('/admin/login.php?logged_out=1'), true, 303);
exit;
