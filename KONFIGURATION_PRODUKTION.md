# Produktionskonfiguration

Die produktiven und sensiblen Serverwerte werden nicht mehr in `config/site.php` oder `config/database.php` gespeichert.

## Website-Daten

1. `config/site.local.example.php` nach `config/site.local.php` kopieren.
2. In `site.local.php` die reale Telefonnummer, E-Mail-Adresse und Anschrift eintragen.
3. Eine leere Telefonnummer wird weder auf der Kontaktseite noch in den strukturierten Daten ausgegeben.

## Datenbank

1. `config/database.local.example.php` nach `config/database.local.php` kopieren.
2. DSN, Benutzername und Passwort des Webhostings eintragen.
3. Ohne vollständige lokale Datenbankkonfiguration wird keine Verbindung aufgebaut und eine klare Fehlermeldung erzeugt.

Die Dateien `*.local.php` sind durch `.gitignore` von der Versionierung ausgeschlossen. Das Verzeichnis `config` ist zusätzlich per `.htaccess` vor direkten Webaufrufen geschützt.
