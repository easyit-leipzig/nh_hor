# easyIT Nachhilfe Leipzig – Phase 10

Phase 10 ist die Integrationsphase zwischen CMS und öffentlicher Website.

## Neu enthalten

- CMS-Inhalte werden im Frontend ausgegeben
- dynamische FAQ-Seite
- dynamische Bewertungsseite
- dynamische Jobs-Seite
- Lernblog mit Übersichts- und Artikelseite
- statische Fallback-Inhalte bei nicht verfügbarer Datenbank
- JSON-Dateicache für veröffentlichte Inhalte
- Cache-Leerung im Adminbereich
- Admin-Vorschau
- Datenbankmigrationen
- CLI-Migrationsrunner
- Schema-Erweiterung um Canonical-URL und Open-Graph-Bild
- Revisions- und Audit-System bleiben erhalten
- aktualisierte Sidebar, Sitemap und robots.txt

## Installation

1. Phase-9-Schema importieren:

```bash
mysql -u USER -p < database/schema.sql
```

2. Datenbankzugang in `config/database.php` eintragen.

3. Migrationen ausführen:

```bash
php database/migrate.php
```

4. Administrator anlegen:

```bash
php database/create-admin.php admin admin@example.de "SEHR_SICHERES_PASSWORT"
```

5. Inhalte unter `/admin/` anlegen und veröffentlichen.

## Fallback-Verhalten

Wenn MySQL nicht verfügbar ist:

- FAQ nutzt vorbereitete Standardfragen
- Jobs nutzt vorbereitete Stellengruppen
- Bewertungen zeigen transparent an, dass noch keine Originalstimmen veröffentlicht sind
- Blog zeigt einen redaktionellen Vorbereitungshinweis

## Cache

Veröffentlichte Inhalte werden für fünf Minuten als JSON zwischengespeichert. Nach Änderungen löscht das CMS automatisch den Cache des betroffenen Inhaltstyps.


## Lokale Installation
Diese korrigierte Fassung ist für `https://localhost/nh_hor/` vorbereitet. Browser-URLs verwenden `/nh_hor/`; PHP-Dateisystempfade mit `__DIR__`, `require` und `include` bleiben unverändert.
