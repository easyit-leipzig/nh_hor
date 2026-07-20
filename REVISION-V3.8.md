# Revision V3.8 – Internationale Adressen

## Neue Tabelle

`addresses` verknüpft jede Anschrift über `to_person` mit `imprint_persons`.

Die Migration liegt unter:

`database/migrations/2026-07-20_imprint_addresses.sql`

## Adminbereich

`/admin/imprint-addresses.php`

Dort können internationale Adressen angelegt, bearbeitet, einer Person zugeordnet, als Primäradresse markiert und gelöscht werden.

Die öffentliche Ausgabe im Impressum oder Footer wird in diesem Schritt weiterhin nicht geändert.
