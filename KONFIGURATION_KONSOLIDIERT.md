# nh_hor – konsolidierte Konfiguration

## Zentrale Auswahl

`config/config.php` wählt anhand des Hosts automatisch aus:

- `localhost`, `127.0.0.1`, `::1`, `*.local`, `*.test` → `config/config.local.php`
- öffentliche Domains → `config/config.server.php`

Die Datei ist idempotent und kann innerhalb derselben PHP-Anfrage mehrfach geladen werden. Dadurch tritt der Fehler `Cannot redeclare app_detect_host()` nicht mehr auf.

## Datenbank

Die Datenbankwerte stehen ausschließlich im Abschnitt `database` der jeweils gewählten Datei. `config/database.php` erzeugt daraus die PDO-Konfiguration.

## Mail und Kontaktformular

Die Mailwerte stehen ausschließlich im Abschnitt `mail` der jeweils gewählten Datei. `config/forms.php` und `config/communication.php` greifen auf dieselben Werte zu.

Lokal ist `transport => log` vorgesehen. Testnachrichten werden unter `storage/contact-outbox/` gespeichert. Auf dem Server kann `mail` oder `smtp` verwendet werden.

## Optionale Umgebungsvariablen

`APP_ENV=development` erzwingt die lokale Konfiguration, `APP_ENV=production` die Serverkonfiguration. Datenbank- und Mailwerte können weiterhin gezielt über die vorhandenen Umgebungsvariablen überschrieben werden.

## Veraltete Dateien

`config/database.local.php` bleibt aus Gründen der Rückwärtskompatibilität im Paket, wird von der konsolidierten Datenbankanbindung aber nicht mehr verwendet.
