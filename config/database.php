<?php
declare(strict_types=1);

/**
 * Einheitliche PDO-Konfiguration für den zentralen Datenbank-Loader.
 *
 * Wichtig: Diese Datei liefert absichtlich kein PDO-Objekt zurück.
 * includes/database.php erzeugt und verwaltet die gemeinsame PDO-Instanz.
 */
$config = require __DIR__ . '/config.php';
$db = $config['database'] ?? null;

if (!is_array($db)) {
    throw new RuntimeException('Der Konfigurationsbereich "database" fehlt oder ist ungültig.');
}

foreach (['host', 'port', 'name', 'username', 'password', 'charset'] as $requiredKey) {
    if (!array_key_exists($requiredKey, $db)) {
        throw new RuntimeException('Datenbank-Konfiguration unvollständig: ' . $requiredKey . ' fehlt.');
    }
}

$dsn = sprintf(
    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
    (string)$db['host'],
    (int)$db['port'],
    (string)$db['name'],
    (string)$db['charset']
);

return [
    'dsn' => $dsn,
    'user' => (string)$db['username'],
    'password' => (string)$db['password'],
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];
