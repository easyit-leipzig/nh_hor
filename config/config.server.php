<?php
declare(strict_types=1);

return [
    'app' => [
        'name' => 'Nachhilfe Multi-Domain',
        'base_url' => 'https://www.easyit-nachhilfe.de',
        'base_path' => '',
        'debug' => false,
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
        // Produktivbetrieb: PHP mail(). Alternativ transport auf smtp stellen.
        'enabled' => true,
        'transport' => 'mail',
        'recipient_email' => 'kontakt@easyit-nachhilfe.de',
        'sender_email' => 'kontakt@easyit-nachhilfe.de',
        'sender_name' => 'easyIT Website',
        'smtp_host' => '',
        'smtp_port' => 587,
        'smtp_encryption' => 'tls',
        'smtp_username' => '',
        'smtp_password' => '',
        'smtp_timeout' => 15,
    ],

    'database' => [
        'host' => 'localhost',
        'port' => 3306,
        'name' => 'h135683_easyit_nachhilfe',
        'username' => 'web411',
        'password' => '9km0m7aE',
        'charset' => 'utf8mb4',
    ],
];
