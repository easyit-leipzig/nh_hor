<?php
declare(strict_types=1);

$config = [
    'transport' => 'mail', // smtp, sendmail oder mail
    'from_email' => '',
    'from_name' => 'easyIT Nachhilfe Leipzig',
    'sendmail_path' => '/usr/sbin/sendmail -bs',
    'smtp' => [
        'host' => '127.0.0.1',
        'port' => 1025,
        'auth' => false,
        'username' => '',
        'password' => '',
        'secure' => '',
    ],
];

$local = __DIR__ . '/communication.local.php';
if (is_file($local)) {
    $localConfig = require $local;
    if (is_array($localConfig)) {
        $config = array_replace_recursive($config, $localConfig);
    }
}
return $config;
