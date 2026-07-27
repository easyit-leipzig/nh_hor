<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

try {
    /*
     * Die Datenbankdaten stammen ausschließlich aus der durch die URL
     * ausgewählten Datei:
     *   localhost/127.0.0.1/.local/.test -> config.local.php
     *   jede öffentliche Domain          -> config.server.php
     *
     * DB_* Umgebungsvariablen dürfen Werte gezielt überschreiben.
     */
    $applicationConfig = require __DIR__ . '/config.php';
    $database = $applicationConfig['database'] ?? null;

    if (!is_array($database)) {
        throw new ConfigurationException(
            ($applicationConfig['loaded_config_file'] ?? 'Konfiguration')
            . ': Der Abschnitt "database" fehlt.'
        );
    }

    $hostDefault = (string) ($database['host'] ?? '');
    $portDefault = (string) ($database['port'] ?? '3306');
    $nameDefault = $database['name'] ?? $database['database'] ?? null;
    $userDefault = $database['username'] ?? $database['user'] ?? null;
    $charsetDefault = (string) ($database['charset'] ?? 'utf8mb4');

    $host = config_env('DB_HOST', $hostDefault);
    $port = config_env('DB_PORT', $portDefault);
    $name = config_env('DB_NAME', is_string($nameDefault) ? $nameDefault : null);
    $user = config_env('DB_USER', is_string($userDefault) ? $userDefault : null);
    $charset = config_env('DB_CHARSET', $charsetDefault);

    $dsnDefault = isset($database['dsn']) && is_string($database['dsn'])
        ? $database['dsn']
        : null;
    $dsn = config_env('DB_DSN', $dsnDefault);
    if ($dsn === null && $host !== null && $name !== null) {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $host,
            $port,
            $name,
            $charset
        );
    }

    // Ein absichtlich leeres lokales Passwort ist zulässig.
    $password = getenv('DB_PASSWORD');
    if ($password === false && array_key_exists('DB_PASSWORD', $_ENV)) {
        $password = (string) $_ENV['DB_PASSWORD'];
    }
    if ($password === false && array_key_exists('DB_PASSWORD', $_SERVER)) {
        $password = (string) $_SERVER['DB_PASSWORD'];
    }
    if ($password === false) {
        $password = array_key_exists('password', $database)
            ? (string) $database['password']
            : null;
    }

    $config = [
        'dsn' => $dsn,
        'user' => $user,
        'password' => $password,
        'options' => isset($database['options']) && is_array($database['options'])
            ? $database['options']
            : [],
    ];

    config_require_nonempty($config, ['dsn', 'user'], 'Datenbankkonfiguration');
    if ($config['password'] === null) {
        throw new ConfigurationException(
            'Datenbankkonfiguration: "password" fehlt. Ein leeres Passwort muss als leere Zeichenkette eingetragen sein.'
        );
    }

    $config['options'] = array_replace([
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ], $config['options']);

    return $config;
} catch (Throwable $exception) {
    throw new ConfigurationException(
        'Datenbankkonfiguration ungültig: ' . $exception->getMessage(),
        0,
        $exception
    );
}
