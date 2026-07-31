<?php

declare(strict_types=1);

return [
    'app' => [
        'name' => 'Nachhilfe Multi-Domain',
        'base_url' => 'http://localhost/nh_hor',
        'base_path' => '/nh_hor',
        'debug' => true,
        'timezone' => 'Europe/Berlin',
    ],

    'brands' => [
        'easyit' => [
            'name' => 'easyIT Nachhilfe Leipzig',
            'domain' => 'easyit-nachhilfe.de',
            'logo' => 'assets/img/logo_easyit.png',
            'email' => 'kontakt@easyit-nachhilfe.de',
        ],

        'thiele' => [
            'name' => 'Thiele Nachhilfe',
            'domain' => 'thiele-nachhilfe.de',
            'logo' => 'assets/img/logo_thiele.png',
            'email' => 'kontakt@thiele-nachhilfe.de',
        ],
    ],

    'mail' => [
        // Lokale Entwicklung: Nachricht wird unter storage/contact-outbox gespeichert.
        'enabled' => true,
        'transport' => 'log',
        'recipient_email' => 'kontakt@easyit-nachhilfe.de',
        'sender_email' => 'website@localhost.test',
        'sender_name' => 'easyIT Website lokal',
        'smtp_host' => '',
        'smtp_port' => 1025,
        'smtp_encryption' => 'none',
        'smtp_username' => '',
        'smtp_password' => '',
        'smtp_timeout' => 15,
    ],

    'database' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'easyit',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ],
];
