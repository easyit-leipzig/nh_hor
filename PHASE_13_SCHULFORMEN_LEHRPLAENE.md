# Phase 13 – Schulformseiten nach Bildungsstandards und Lehrplänen

## Ziel

Die sechs Karten auf `schulformen.php` führen jetzt auf ausführliche Seiten für:

- Grundschule
- Oberschule
- Gymnasium
- Berufsschule
- Abitur
- Studium

## Umsetzung

Die bestehende Logik wurde beibehalten:

- Die sechs PHP-Zielseiten setzen weiterhin nur `$schoolTypeKey`.
- Alle Inhalte werden zentral in `config/school-types.php` gepflegt.
- Die gemeinsame Darstellung erfolgt über `includes/school-type-page.php`.
- Bestehende Header-, Sidebar-, Footer- und Fachkonfigurationen bleiben erhalten.

## Neue Inhaltsbereiche

Jede Seite enthält:

1. Einordnung der Lernphase
2. Anforderungen aus Lehrplänen bzw. Bildungsstandards
3. Kompetenzbereiche
4. thematische Schwerpunkte
5. konkrete easyIT-Unterstützung
6. vierstufigen Lernweg
7. passende Fachseiten
8. Links zu offiziellen Grundlagen
9. Kontaktaufruf

## Wichtiger Hinweis zum Studium

Für Hochschulstudiengänge existiert kein einheitlicher schulischer Lehrplan. Maßgeblich sind Modulhandbücher, Studien- und Prüfungsordnungen sowie die konkreten Unterlagen des Moduls.

## Installation

Das Paket nach `C:\xampp\htdocs\nh_seo\` entpacken und vorhandene Dateien überschreiben. Danach mit `Strg + F5` neu laden.
