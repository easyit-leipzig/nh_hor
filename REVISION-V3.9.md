# Revision V3.9 – Kontakte

## Neu

- Tabelle `contacts` mit Personenbezug über `to_person`
- flexible Kontakttypen wie `phone`, `email`, `http`, Messenger und soziale Netzwerke
- Kontaktwert als Text, Bezeichnung, Aktivstatus, Primärkennzeichnung und Sortierung
- Gültigkeitszeitraum und interne Notiz
- vollständige CRUD-Verwaltung unter `/admin/imprint-contacts.php`
- Verlinkung in Adminnavigation, Dashboard, Personen- und Adressverwaltung
- CSRF-Schutz, Rollenprüfung, POST-Aktionen, Transaktion und Audit-Logging

## Migration

`database/migrations/2026-07-20_imprint_contacts.sql`

Die öffentliche Ausgabe wird in diesem Schritt noch nicht auf die neue Tabelle umgestellt.
