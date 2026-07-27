<?php
declare(strict_types=1);

/**
 * Zentrale URL-abhängige Anwendungskonfiguration.
 *
 * Diese Datei darf innerhalb einer Anfrage mehrfach mit require geladen werden.
 * Sie deklariert deshalb keine Funktionen und hält den ermittelten Wert in
 * einer globalen Laufzeitablage vor.
 */

if (isset($GLOBALS['EASYIT_APPLICATION_CONFIG']) && is_array($GLOBALS['EASYIT_APPLICATION_CONFIG'])) {
    return $GLOBALS['EASYIT_APPLICATION_CONFIG'];
}

$rawHost = (string)($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '');
$host = strtolower(trim($rawHost));

if (str_starts_with($host, '[')) {
    $closingBracket = strpos($host, ']');
    if ($closingBracket !== false) {
        $host = substr($host, 1, $closingBracket - 1);
    }
} else {
    $host = (string)preg_replace('/:\d+$/', '', $host);
}

$forcedEnvironment = strtolower(trim((string)(getenv('APP_ENV') ?: '')));
$isLocal = in_array($forcedEnvironment, ['local', 'development', 'dev'], true)
    || ($forcedEnvironment === '' && (
        PHP_SAPI === 'cli'
        || in_array($host, ['localhost', '127.0.0.1', '::1'], true)
        || str_ends_with($host, '.local')
        || str_ends_with($host, '.test')
    ));

$configFilename = $isLocal ? 'config.local.php' : 'config.server.php';
$configPath = __DIR__ . DIRECTORY_SEPARATOR . $configFilename;

if (!is_file($configPath) || !is_readable($configPath)) {
    throw new RuntimeException('Konfigurationsdatei fehlt oder ist nicht lesbar: ' . $configFilename);
}

$config = require $configPath;
if (!is_array($config)) {
    throw new RuntimeException($configFilename . ' muss ein PHP-Array zurückgeben.');
}

$config['environment'] = $isLocal ? 'local' : 'server';
$config['detected_host'] = $host;
$config['loaded_config_file'] = $configFilename;

$brandKey = 'easyit';
if (in_array($host, ['thiele-nachhilfe.de', 'www.thiele-nachhilfe.de'], true)) {
    $brandKey = 'thiele';
}
$config['brand_key'] = $brandKey;
if (isset($config['brands'][$brandKey]) && is_array($config['brands'][$brandKey])) {
    $config['brand'] = $config['brands'][$brandKey];
}

$GLOBALS['EASYIT_APPLICATION_CONFIG'] = $config;
return $config;
