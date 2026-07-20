# easyIT-Adminbereich

1. Datenbankverbindung in `config/database.local.php` einrichten.
2. Falls `admin_users` und `audit_log` fehlen: `database/migrations/2026-07-20_admin_complete.sql` importieren.
3. `/admin/setup.php` aufrufen.
4. Den Einrichtungsschlüssel aus `config/admin.php` eingeben.
5. Einen eigenen Administrator mit sicherem Passwort anlegen.
6. Danach über `/admin/login.php` anmelden.

Die Ersteinrichtung sperrt sich automatisch, sobald mindestens ein Admin-Benutzer existiert.

## Rollen

- `admin`: Inhalte, Navigation und Benutzer verwalten.
- `editor`: Inhalte verwalten und eigenes Passwort ändern.

## Sicherheit

- Login mit Rate-Limit und Session-Regeneration
- CSRF-Schutz für alle schreibenden Aktionen
- Logout ausschließlich per POST
- Cache-Löschung ausschließlich per POST
- Passwörter über `password_hash()` gespeichert
- Audit-Protokoll für Adminaktionen

Einrichtungsschlüssel dieser Revision: `1aedc9d0fb6ae6d01bf6a0f3d07c4dd7`
