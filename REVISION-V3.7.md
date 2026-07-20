# Revision V3.7 – Rollen und Personen (Schritt 1)

## Neu

- Tabelle `imprint_roles`: `id`, `role`
- Tabelle `imprint_persons`: `id`, `to_role`, `saturation`, `title`, `firstname`, `lastname`
- Rollen: `admin`, `company`, `personal`, `tutor`, `other`
- Adminseiten `/admin/imprint-roles.php` und `/admin/imprint-persons.php`
- CSRF-geschützte CRUD-Aktionen und Audit-Protokollierung
- Startdatensätze für Herr Dipl.-Ing. Olaf Thiele sowie Herr Olaf Thiele

## Migration

`database/migrations/2026-07-20_imprint_roles_persons.sql` importieren.

## Abgrenzung

Die öffentliche Ausgabe in Impressum, Footer und strukturierte Daten wird erst in Schritt 2 auf diese Tabellen umgestellt.
