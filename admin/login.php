<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';
header('Location: ' . app_path('/intern/login.php'), true, 303);
exit;
