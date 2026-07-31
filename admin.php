<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/internal-auth.php';
internal_require_role('admin');
header('Location: ' . app_path('/admin/index.php'), true, 303);
exit;
