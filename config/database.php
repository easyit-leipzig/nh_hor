<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

try {
    $local = config_load_local('database.local.php');
    $isProduction = config_is_production();

    // Für die lokale XAMPP-/MariaDB-Entwicklung sind die üblichen Werte
    // sofort nutzbar. In Produktion bleiben DSN, Benutzer und Passwort
    // weiterhin vollständig explizit zu konfigurieren.
    $hostDefault = isset($local['host']) ? (string)$local['host'] : '127.0.0.1';
    $portDefault = isset($local['port']) ? (string)$local['port'] : '3306';
    $nameDefault = isset($local['name'])
        ? (string)$local['name']
        : ($isProduction ? null : 'easyit');
    $userDefault = isset($local['user'])
        ? (string)$local['user']
        : ($isProduction ? null : 'root');
    $passwordDefault = array_key_exists('password', $local)
        ? (string)$local['password']
        : ($isProduction ? null : '');

    $host = config_env('DB_HOST', $hostDefault);
    $port = config_env('DB_PORT', $portDefault);
    $name = config_env('DB_NAME', $nameDefault);
    $charset = config_env('DB_CHARSET', isset($local['charset']) ? (string)$local['charset'] : 'utf8mb4');

    $config = [
        'dsn' => config_env('DB_DSN', isset($local['dsn']) ? (string)$local['dsn'] : null),
        'user' => config_env('DB_USER', $userDefault),
        // Ein leeres Passwort ist lokal zulässig und darf nicht durch
        // config_env() auf null zurückfallen.
        'password' => getenv('DB_PASSWORD') !== false
            ? (string)getenv('DB_PASSWORD')
            : (array_key_exists('DB_PASSWORD', $_ENV)
                ? (string)$_ENV['DB_PASSWORD']
                : (array_key_exists('DB_PASSWORD', $_SERVER)
                    ? (string)$_SERVER['DB_PASSWORD']
                    : $passwordDefault)),
        'options' => isset($local['options']) && is_array($local['options']) ? $local['options'] : [],
    ];

    if ($config['dsn'] === null && $name !== null) {
        $config['dsn'] = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $host, $port, $name, $charset);
    }

    // Das Passwort darf leer sein. DSN und Benutzer müssen vorhanden sein.
    config_require_nonempty($config, ['dsn', 'user'], 'Datenbankkonfiguration');
    if ($isProduction && $config['password'] === null) {
        throw new ConfigurationException('Datenbankkonfiguration: Pflichtwert "password" fehlt. Ein bewusst leeres Passwort muss explizit gesetzt werden.');
    }
    if ($config['password'] === null) {
        $config['password'] = '';
    }

    $config['options'] = array_replace([
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ], $config['options']);

    return $config;
} catch (Throwable $exception) {
    throw new ConfigurationException('Datenbankkonfiguration ungültig: ' . $exception->getMessage(), 0, $exception);
}
