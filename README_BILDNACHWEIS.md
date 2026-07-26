# nh_hor – Bildnachweis V2

## Korrektur

Diese Fassung verwendet die tatsächlich vorhandene Tabelle `navigation_items` mit den Feldern:

- `id`
- `parent_id`
- `title`
- `url`
- `sort_order`
- `is_active`

Die nicht vorhandenen Felder `target`, `css_class` und die nicht vorhandene Tabelle `menu_items` werden nicht mehr verwendet.

## Dateien

- `bildnachweis.php` – öffentliche DB-Seite
- `assets/css/bildnachweis.css` – responsive Darstellung
- `admin/image-credits.php` – Anlegen, Bearbeiten und Löschen
- `database/migrations/2026-07-23_image_credits_v2.sql` – Tabelle und Menüeintrag

## Installation

1. Inhalt dieses ZIP in `C:\xampp\htdocs\nh_hor` kopieren.
2. In phpMyAdmin die Datenbank `easyit` auswählen.
3. `database/migrations/2026-07-23_image_credits_v2.sql` importieren.
4. Öffentliche Seite testen:
   `http://localhost/nh_hor/bildnachweis.php`
5. Adminseite testen:
   `http://localhost/nh_hor/admin/image-credits.php`

## URL-Hinweis

In `navigation_items` wird `/bildnachweis.php` gespeichert. Die bestehende Navigation sollte den konfigurierten lokalen `base_path` `/nh_hor` davorsetzen. Dadurch entsteht lokal `/nh_hor/bildnachweis.php`, während die Domain später im Root ohne Projektverzeichnis betrieben werden kann.
