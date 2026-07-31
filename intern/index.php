<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/internal-auth.php';
internal_require_login();
header('Location: ' . internal_start_path(), true, 303);
exit;
