<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
require __DIR__ . '/../includes/cache.php';
admin_require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
    http_response_code(405);
    exit('Ungültige Anfrage.');
}
$count = cache_clear_all();
admin_log('cache_clear', 'system', null, ['files' => $count]);
header('Location: ' . app_path('/admin/index.php?cache=' . $count), true, 303);
exit;
