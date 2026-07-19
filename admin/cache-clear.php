<?php
declare(strict_types=1);

require __DIR__ . '/includes/admin-functions.php';
require __DIR__ . '/../includes/cache.php';
admin_require_login();

$count = cache_clear_all();
admin_log('cache_clear', 'system', null, ['files' => $count]);

header('Location: /admin/index.php?cache=' . $count, true, 303);
exit;
