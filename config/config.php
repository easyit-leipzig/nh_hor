<?php
declare(strict_types=1);

/**
 * Zentrale, URL-abhängige Konfigurationsauswahl.
 *
 * Lokal:
 *   - localhost
 *   - 127.0.0.1
 *   - ::1
 *   - Hosts mit .local oder .test
 *
 * Alle anderen Hosts verwenden config.server.php.
 */

function app_detect_host(): string
{
    $rawHost = (string) ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '');
    $host = strtolower(trim($rawHost));

    // IPv6 mit Port, z. B. [::1]:8080
    if (str_starts_with($host, '[')) {
        $closingBracket = strpos($host, ']');
        if ($closingBracket !== false) {
            return substr($host, 1, $closingBracket - 1);
        }
    }

    // Port bei IPv4/Domain entfernen.
    return (string) preg_replace('/:\d+$/', '', $host);
}

function app_is_local_host(string $host): bool
{
    if (PHP_SAPI === 'cli') {
        return true;
    }

    if (in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
        return true;
    }

    return str_ends_with($host, '.local') || str_ends_with($host, '.test');
}

$detectedHost = app_detect_host();
$isLocal = app_is_local_host($detectedHost);
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
$config['detected_host'] = $detectedHost;
$config['loaded_config_file'] = $configFilename;

// Domainabhängige Marke innerhalb derselben Serverkonfiguration.
$brandKey = 'easyit';
if (in_array($detectedHost, ['thiele-nachhilfe.de', 'www.thiele-nachhilfe.de'], true)) {
    $brandKey = 'thiele';
} elseif (in_array($detectedHost, ['easyit-nachhilfe.de', 'www.easyit-nachhilfe.de'], true)) {
    $brandKey = 'easyit';
}

$config['brand_key'] = $brandKey;
if (isset($config['brands'][$brandKey]) && is_array($config['brands'][$brandKey])) {
    $config['brand'] = $config['brands'][$brandKey];
}

return $config;
