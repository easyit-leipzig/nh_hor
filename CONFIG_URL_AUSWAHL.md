# URL-abhängige Konfiguration

Die Anwendung lädt automatisch genau eine der beiden Dateien:

- `config/config.local.php` bei `localhost`, `127.0.0.1`, `::1` sowie Hosts mit `.local` oder `.test`
- `config/config.server.php` bei jeder öffentlichen Domain

Die Auswahl erfolgt zentral in `config/config.php`. Die Datenbankanbindung in
`config/database.php` verwendet anschließend ausschließlich den Abschnitt
`database` aus der ausgewählten Datei.

## Lokale Datenbank

Datei: `config/config.local.php`

```php
'database' => [
    'host' => '127.0.0.1',
    'port' => 3306,
    'name' => 'easyit',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
],
```

## Serverdatenbank

Datei: `config/config.server.php`

```php
'database' => [
    'host' => 'HOST_DES_ANBIETERS',
    'port' => 3306,
    'name' => 'DATENBANKNAME',
    'username' => 'DATENBANKBENUTZER',
    'password' => 'DATENBANKPASSWORT',
    'charset' => 'utf8mb4',
],
```

`config/database.local.php` wird nicht mehr zur automatischen Auswahl verwendet,
damit lokale Daten niemals versehentlich die Serverkonfiguration überschreiben.
