<?php
declare(strict_types=1);

return [
    'dsn' => 'mysql:host=localhost;dbname=easyit;charset=utf8mb4',
    'user' => 'easyit_user',
    'password' => 'CHANGE_ME',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];
