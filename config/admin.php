<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

return [
    'password_min_length' => max(
        12,
        (int)(config_env('ADMIN_PASSWORD_MIN_LENGTH', '12') ?? 12)
    ),
];
