<?php
declare(strict_types=1);

/**
 * config/config.php
 * Eindeutige Auswahl zwischen lokaler und Server-Konfiguration.
 */

$rawHost = (string)($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '');
$host = strtolower(trim($rawHost));

if (str_starts_with($host, '[')) {
    $end = strpos($host, ']');
    if ($end !== false) {
        $host = substr($host, 1, $end - 1);
    }
} else {
    $host = preg_replace('/:\d+$/', '', $host);
}

$isLocal = PHP_SAPI === 'cli' || in_array($host, [
    'localhost',
    '127.0.0.1',
    '::1',
], true);

$configFile = __DIR__ . ($isLocal ? '/config.local.php' : '/config.server.php');

if (!is_file($configFile)) {
    throw new RuntimeException(
        'Konfigurationsdatei fehlt: ' . basename($configFile)
    );
}

$config = require $configFile;

if (!is_array($config)) {
    throw new RuntimeException(
        'Konfigurationsdatei liefert kein Array: ' . basename($configFile)
    );
}

$config['environment'] = $isLocal ? 'local' : 'server';
$config['detected_host'] = $host;
$config['loaded_config_file'] = basename($configFile);

$brandKey = 'easyit';

if (in_array($host, ['thiele-nachhilfe.de', 'www.thiele-nachhilfe.de'], true)) {
    $brandKey = 'thiele';
} elseif (in_array($host, ['easyit-nachhilfe.de', 'www.easyit-nachhilfe.de'], true)) {
    $brandKey = 'easyit';
}

$config['brand_key'] = $brandKey;

if (isset($config['brands'][$brandKey]) && is_array($config['brands'][$brandKey])) {
    $config['brand'] = $config['brands'][$brandKey];
}

return $config;
