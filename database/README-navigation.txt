DATENBANKGESTÜTZTE HAUPTNAVIGATION – REVISION V3.4

Die Navigation wird ausschließlich aus `navigation_items` geladen.
Der geprüfte Dump `easyit.sql` enthält 35 aktive Datensätze und ist strukturell korrekt.

Behobener Fehler aus V3.3:
Die Datenbankkonfiguration verlangte ein nicht leeres Passwort. Lokale XAMPP-/MariaDB-
Installationen verwenden häufig Benutzer `root` mit leerem Passwort. Dadurch wurde die
Verbindung abgelehnt und die Navigation blieb ohne sichtbare Fehlermeldung leer.

Lokaler Standard:
- Host: 127.0.0.1
- Port: 3306
- Datenbank: easyit
- Benutzer: root
- Passwort: leer

Alternativ `config/database.local.php.example` nach `config/database.local.php` kopieren
und die Werte anpassen.

In Produktion müssen die Zugangsdaten weiterhin explizit über Umgebungsvariablen oder
`database.local.php` gesetzt werden.
