# Sichere Admin-Archivierung

Die Archivierung von Inhalten wurde von einem zustandsändernden GET-Aufruf auf eine geschützte POST-Aktion umgestellt.

## Umgesetzte Schutzmaßnahmen

- `admin/delete.php` akzeptiert ausschließlich `POST`.
- Andere HTTP-Methoden werden mit Status `405 Method Not Allowed` abgewiesen.
- Jede Archivierungsanfrage benötigt ein gültiges CSRF-Token.
- Ungültige oder abgelaufene Token werden mit Status `403 Forbidden` abgewiesen.
- Die Datensatz-ID wird serverseitig als positive Ganzzahl validiert.
- Der tatsächliche Inhaltstyp wird aus der Datenbank gelesen und nicht ungeprüft aus dem Formular übernommen.
- Bereits archivierte Datensätze werden nicht erneut verändert.
- Die vorherige Statusangabe wird im Audit-Log dokumentiert.
- Nach erfolgreicher Verarbeitung erfolgt eine `303 See Other`-Weiterleitung.
- Die Admin-Oberfläche verwendet ein POST-Formular mit Bestätigungsdialog.

Damit kann ein eingeloggter Administrator nicht mehr allein durch das Öffnen eines Links oder das Laden einer fremden Ressource eine Archivierung auslösen.
