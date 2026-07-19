<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

try {
    $local = config_load_local('database.local.php');

    $host = config_env('DB_HOST', isset($local['host']) ? (string)$local['host'] : 'localhost');
    $port = config_env('DB_PORT', isset($local['port']) ? (string)$local['port'] : '3306');
    $name = config_env('DB_NAME', isset($local['name']) ? (string)$local['name'] : null);
    $charset = config_env('DB_CHARSET', isset($local['charset']) ? (string)$local['charset'] : 'utf8mb4');

    $config = [
        'dsn' => config_env('DB_DSN', isset($local['dsn']) ? (string)$local['dsn'] : null),
        'user' => config_env('DB_USER', isset($local['user']) ? (string)$local['user'] : null),
        'password' => config_env('DB_PASSWORD', isset($local['password']) ? (string)$local['password'] : null),
        'options' => isset($local['options']) && is_array($local['options']) ? $local['options'] : [],
    ];

    if ($config['dsn'] === null && $name !== null) {
        $config['dsn'] = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $host, $port, $name, $charset);
    }

    config_require_nonempty($config, ['dsn', 'user', 'password'], 'Datenbankkonfiguration');

    $config['options'] = array_replace([
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ], $config['options']);

    return $config;
} catch (Throwable $exception) {
    throw new ConfigurationException('Datenbankkonfiguration ungültig: ' . $exception->getMessage(), 0, $exception);
}
