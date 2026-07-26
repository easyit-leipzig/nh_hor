# Sicherheitsumsetzung

Der Projektstand enthält unter anderem sichere Session-Cookies, Session-Zeitgrenzen, CSRF-Prüfungen, Login-Limitierung, Sicherheitsheader, CSP, geschützte Konfigurations- und Speicherverzeichnisse sowie blockierte PHP-Ausführung in Uploadverzeichnissen.

## Admin-Ersteinrichtung

Die Admin-Ersteinrichtung benötigt keinen separaten Schlüssel und keine Datei `admin.local.php` mehr.

- Ist die Tabelle `admin_users` leer, kann über `/admin/setup.php` genau das erste Administratorkonto angelegt werden.
- Sobald mindestens ein Administrator vorhanden ist, sperrt sich die Einrichtungsseite automatisch mit HTTP 403.
- Auf der Anmeldeseite wird der Einrichtungslink nur angezeigt, solange noch kein Administratorkonto existiert.
- Die Passwörter müssen standardmäßig mindestens 12 Zeichen lang sein. Die Mindestlänge kann bei Bedarf über `ADMIN_PASSWORD_MIN_LENGTH` erhöht werden.

Damit entfällt das Kopieren, Bearbeiten und spätere Löschen einer lokalen Schlüsseldatei vollständig.
