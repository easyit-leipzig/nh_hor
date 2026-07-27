<?php
declare(strict_types=1);

$application = require __DIR__ . '/config.php';
$mail = isset($application['mail']) && is_array($application['mail']) ? $application['mail'] : [];

return [
    'transport' => (string)($mail['transport'] ?? 'mail'),
    'from_email' => (string)($mail['sender_email'] ?? ''),
    'from_name' => (string)($mail['sender_name'] ?? 'easyIT Nachhilfe Leipzig'),
    'sendmail_path' => (string)($mail['sendmail_path'] ?? '/usr/sbin/sendmail -bs'),
    'smtp' => [
        'host' => (string)($mail['smtp_host'] ?? ''),
        'port' => (int)($mail['smtp_port'] ?? 587),
        'auth' => (bool)($mail['smtp_auth'] ?? ((string)($mail['smtp_username'] ?? '') !== '')),
        'username' => (string)($mail['smtp_username'] ?? ''),
        'password' => (string)($mail['smtp_password'] ?? ''),
        'secure' => (string)($mail['smtp_encryption'] ?? 'tls'),
    ],
];
