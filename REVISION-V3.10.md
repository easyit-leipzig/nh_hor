# Revision V3.10 – dynamische Startseitenblöcke

## Migration

`database/migrations/2026-07-20_add_index_content.sql`

## Verwaltung

`/admin/index-content.php`

Die Startseite besitzt nummerierte Positionen:

1. Hero / Startbereich
2. Fächer
3. easyIT kennenlernen
4. Häufige Fragen
5. Kontakt-CTA
6. nach dem letzten Bereich

Ein Datensatz kann vor oder nach einer Position erscheinen oder den ursprünglichen Bereich ersetzen. Mehrere Einträge werden über `sort_order` geordnet. `valid_from` und `valid_until` ermöglichen automatisch zeitgesteuerte Aktionen.

HTML wird als Inhaltsstruktur ausgegeben. CSS und JavaScript werden getrennt gespeichert und mit dem aktuellen CSP-Nonce eingebunden. Die Pflege ist ausschließlich Administratoren erlaubt.
