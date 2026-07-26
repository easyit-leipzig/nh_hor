# Bereinigter Produktionsstand

Dieser Stand wurde nach abgeschlossener Einrichtung bereinigt.

Entfernt wurden:

- abgeschlossene Einrichtungs-, Import-, Reparatur-, Phasen- und Revisionsanleitungen,
- alte Diagnose-Seiten (`check_db.php`, `checkdb.php`),
- die nach erfolgter Einrichtung nicht mehr benötigte Admin-Ersteinrichtung,
- das interne Projektarchiv,
- ein separater alter Relaunch-Entwurf,
- veraltete SQL-Einrichtungs- und Korrekturskripte.

Erhalten blieben:

- alle produktiven öffentlichen Seiten,
- der vollständige Adminbereich ohne Ersteinrichtungsfunktion,
- die Blockeditor-Hilfe,
- sämtliche benötigten Includes, Konfigurationen und Assets,
- der aktuelle Datenbank-Gesamtstand unter `database/`.

Prüfung:

- alle PHP-Dateien wurden mit `php -l` geprüft,
- keine PHP-Syntaxfehler festgestellt.
