<?php
declare(strict_types=1);

$localFile = __DIR__ . '/database.local.php';

if (!is_file($localFile)) {
    throw new RuntimeException(
        'Datenbankkonfiguration fehlt. Kopieren Sie config/database.local.example.php nach config/database.local.php und tragen Sie dort die Serverzugangsdaten ein.'
    );
}

$config = require $localFile;

if (!is_array($config)) {
    throw new RuntimeException('config/database.local.php muss ein PHP-Array zurückgeben.');
}

foreach (['dsn', 'user', 'password'] as $requiredKey) {
    if (!array_key_exists($requiredKey, $config) || !is_string($config[$requiredKey]) || trim($config[$requiredKey]) === '') {
        throw new RuntimeException('Ungültige Datenbankkonfiguration: Wert "' . $requiredKey . '" fehlt.');
    }
}

$config['options'] = array_replace([
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
], isset($config['options']) && is_array($config['options']) ? $config['options'] : []);

return $config;
