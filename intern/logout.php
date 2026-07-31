<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/internal-auth.php';
internal_logout();
header('Location: ' . app_path('/intern/login.php?logged_out=1'), true, 303);
exit;
