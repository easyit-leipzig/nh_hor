<?php
declare(strict_types=1);
require __DIR__ . '/includes/auth.php';
admin_logout();
header('Location: /nh_hor/admin/login.php', true, 303);
exit;
