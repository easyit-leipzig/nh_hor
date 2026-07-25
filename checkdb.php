<?php
declare(strict_types=1);

header('Content-Type: text/plain; charset=utf-8');
header('X-Content-Type-Options: nosniff');

echo "=== NEUE Konfigurationsprüfung V2 ===\n\n";

echo "Ausgeführte Datei: " . __FILE__ . "\n";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? '') . "\n";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? '') . "\n";
echo "PATH_INFO: " . ($_SERVER['PATH_INFO'] ?? '(leer)') . "\n\n";

$loader = __DIR__ . '/config/config.php';

if (!is_file($loader)) {
    exit("❌ Loader fehlt: config/config.php\n");
}

echo "✔ Loader vorhanden\n";

try {
    $config = require $loader;
} catch (Throwable $e) {
    exit("❌ Loaderfehler: " . $e->getMessage() . "\n");
}

if (!is_array($config)) {
    exit("❌ Loader liefert kein Array.\n");
}

echo "✔ Konfiguration geladen\n\n";

foreach (['app', 'brands', 'database'] as $section) {
    if (!isset($config[$section]) || !is_array($config[$section])) {
        exit("❌ Bereich '{$section}' fehlt oder ist ungültig.\n");
    }
}

echo "✔ Pflichtbereiche vorhanden\n\n";

echo "Erkannter Host: " . ($config['detected_host'] ?? 'unbekannt') . "\n";
echo "Umgebung: " . ($config['environment'] ?? 'unbekannt') . "\n";
echo "Geladene Datei: " . ($config['loaded_config_file'] ?? 'unbekannt') . "\n\n";

echo "App-Name: " . ($config['app']['name'] ?? '') . "\n";
echo "Base URL: " . ($config['app']['base_url'] ?? '') . "\n";
echo "Debug: " . (($config['app']['debug'] ?? false) ? 'true' : 'false') . "\n";
echo "Timezone: " . ($config['app']['timezone'] ?? '') . "\n\n";

echo "Aktive Marke: " . ($config['brand_key'] ?? 'nicht erkannt') . "\n";
echo "Markenname: " . ($config['brand']['name'] ?? '') . "\n";
echo "Domain: " . ($config['brand']['domain'] ?? '') . "\n";
echo "E-Mail: " . ($config['brand']['email'] ?? '') . "\n";
echo "Logo: " . ($config['brand']['logo'] ?? '') . "\n\n";

$db = $config['database'];

foreach (['host', 'port', 'name', 'username', 'password', 'charset'] as $field) {
    if (!array_key_exists($field, $db)) {
        exit("❌ Datenbankfeld '{$field}' fehlt.\n");
    }
}

echo "DB-Host: " . $db['host'] . "\n";
echo "DB-Port: " . $db['port'] . "\n";
echo "DB-Name: " . $db['name'] . "\n";
echo "DB-Benutzer: " . $db['username'] . "\n";
echo "DB-Passwort: " . ($db['password'] === '' ? '(leer)' : str_repeat('*', 12)) . "\n";
echo "DB-Charset: " . $db['charset'] . "\n\n";

try {
    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $db['host'],
        (int)$db['port'],
        $db['name'],
        $db['charset']
    );

    $pdo = new PDO(
        $dsn,
        (string)$db['username'],
        (string)$db['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 5,
        ]
    );

    echo "✔ Datenbankverbindung erfolgreich\n";
    echo "Serverversion: " . $pdo->query('SELECT VERSION()')->fetchColumn() . "\n";
    echo "Aktive Datenbank: " . $pdo->query('SELECT DATABASE()')->fetchColumn() . "\n";
    echo "Tabellenanzahl: " . count($pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN)) . "\n";
} catch (Throwable $e) {
    echo "❌ Datenbankverbindung fehlgeschlagen\n";
    echo $e->getMessage() . "\n";
}

echo "\n=== Prüfung abgeschlossen ===\n";
