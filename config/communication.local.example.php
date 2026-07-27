<?php
declare(strict_types=1);

return [
    // Lokal mit Mailpit:
    'transport' => 'smtp',
    'from_email' => 'info@easyit-nachhilfe.de',
    'from_name' => 'easyIT Nachhilfe Leipzig',
    'smtp' => [
        'host' => '127.0.0.1',
        'port' => 1025,
        'auth' => false,
        'username' => '',
        'password' => '',
        'secure' => '',
    ],

    // Auf Alfahosting alternativ:
    // 'transport' => 'sendmail',
    // 'sendmail_path' => '/usr/sbin/sendmail -bs',
];
