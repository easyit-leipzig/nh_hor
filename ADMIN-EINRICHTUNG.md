# Admin-Ersteinrichtung

Die Ersteinrichtung benötigt keine lokale Schlüsseldatei mehr.

1. Datenbank und Admin-Tabellen einrichten.
2. `/nh_hor/admin/login.php` aufrufen.
3. Solange die Tabelle `admin_users` leer ist, erscheint der Link **Ersteinrichtung öffnen**.
4. Benutzername, E-Mail-Adresse und ein Passwort mit mindestens 12 Zeichen eingeben.
5. Nach dem Anlegen des ersten Administrators sperrt sich `/admin/setup.php` automatisch.

Die Sperre basiert auf dem Datenbankinhalt: Sobald mindestens ein Datensatz in `admin_users` vorhanden ist, antwortet die Einrichtungsseite mit HTTP 403. Es muss keine Datei kopiert, umbenannt oder anschließend gelöscht werden.
