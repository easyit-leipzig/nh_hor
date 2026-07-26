# Adminbereich – Reparaturstand

## Behoben

- Syntaxfehler in `admin/homepage_blocks_save.php` entfernt.
- Anlegen und Bearbeiten von Homepage-Blöcken getrennt und korrekt umgesetzt.
- Beim Bearbeiten wird nun ein vorhandener Datensatz aktualisiert statt erneut eingefügt.
- Formularwerte werden vollständig geladen und gespeichert.
- Aktiv-Status und vorhandenes Bild bleiben beim Bearbeiten erhalten.
- Bild-Uploads werden anhand des tatsächlichen MIME-Typs geprüft.
- Zulässige Formate: JPEG, PNG und WebP; maximale Größe: 5 MB.
- Upload-Dateien erhalten zufällige Dateinamen.
- Datenbank- und Uploadfehler werden kontrolliert behandelt.
- Alle Admin-Links verwenden den konfigurierten Projektpfad.
- Dashboard und Admin-Navigation enthalten beide Startseitenverwaltungen eindeutig getrennt.
- Sämtliche PHP-Dateien im Adminbereich bestehen den Syntaxcheck.

## Datenbank

Vor Verwendung der Homepage-Blöcke ausführen:

1. `database/migrations/2026-07-21_homepage_blocks.sql`
2. optional `database/migrations/2026-07-21_homepage_blocks_seed.sql`

Das Seed-Skript ist idempotent und erzeugt bei erneutem Import keine identischen Beispieldatensätze.
