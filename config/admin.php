<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

$local = config_load_local('admin.local.php');

return [
    // In Produktion ausschließlich über ADMIN_SETUP_TOKEN oder admin.local.php setzen.
    // Ein leerer Schlüssel deaktiviert die öffentliche Ersteinrichtung vollständig.
    'setup_token' => config_env('ADMIN_SETUP_TOKEN', (string)($local['setup_token'] ?? '')) ?? '',
    'setup_enabled' => config_bool(
        config_env('ENABLE_ADMIN_SETUP'),
        !config_is_production() && (bool)($local['setup_enabled'] ?? true)
    ),
    'password_min_length' => max(12, (int)(config_env('ADMIN_PASSWORD_MIN_LENGTH', (string)($local['password_min_length'] ?? 12)) ?? 12)),
];
