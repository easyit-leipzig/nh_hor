<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

return [
    // Die Ersteinrichtung wird nicht mehr über einen Schlüssel freigeschaltet.
    // admin/setup.php ist nur erreichbar, solange admin_users leer ist.
    'password_min_length' => max(
        12,
        (int)(config_env('ADMIN_PASSWORD_MIN_LENGTH', '12') ?? 12)
    ),
];
