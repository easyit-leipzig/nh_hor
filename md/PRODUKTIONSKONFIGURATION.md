# Produktionskonfiguration

Produktive Zugangsdaten und persönliche Kontaktdaten werden nicht im Repository gespeichert.

## Empfohlene Variante: Konfigurationsverzeichnis außerhalb des Webroots

1. Außerhalb des öffentlich erreichbaren Verzeichnisses ein Verzeichnis anlegen, beispielsweise:
   `/home/<konto>/private/easyit-config/`
2. `config/database.example.php` als `database.local.php`, `config/site.example.php` als `site.local.php` und bei Bedarf `config/forms.example.php` als `forms.local.php` dorthin kopieren.
3. Die echten Werte ausschließlich in diesen lokalen Dateien eintragen.
4. In der Serverkonfiguration die Umgebungsvariable setzen:
   `EASYIT_CONFIG_DIR=/home/<konto>/private/easyit-config`
5. `APP_ENV=production` setzen.

## Alternative: Umgebungsvariablen

Die unterstützten Variablen stehen in `.env.example`. Eine `.env`-Datei wird von PHP nicht automatisch geladen; die Werte müssen über Hosting-Panel, Apache, PHP-FPM oder den Systemdienst bereitgestellt werden.

## Pflichtprüfung

Im Produktionsmodus beendet die Website die Ausgabe kontrolliert mit HTTP 503, wenn Telefonnummer, E-Mail, Inhaber oder vollständige Geschäftsadresse fehlen. Datenbankzugriffe schlagen mit einer klaren Konfigurationsausnahme fehl, wenn DSN beziehungsweise Datenbankname, Benutzer oder Passwort fehlen. Besuchern werden keine Zugangsdaten oder internen Pfade angezeigt; Details werden nur im PHP-Fehlerprotokoll erfasst.

## Nicht versionieren

Folgende Dateien bleiben lokal und sind über `.gitignore` ausgeschlossen:

- `config/database.local.php`
- `config/site.local.php`
- `config/forms.local.php`
- `.env`
