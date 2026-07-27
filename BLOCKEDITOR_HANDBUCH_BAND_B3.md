# Blockeditor-Handbuch – Band B, Phase 3

## Professionelle Typografie und responsive Textgestaltung

Diese Projektphase erweitert die integrierte Hilfeseite des Homepage-Blockeditors um zehn Kapitel:

1. Typografische Hierarchie
2. Schriftwahl
3. Schriftkombinationen
4. Responsive Schriftgrößen
5. Zeilenhöhe
6. Zeichenabstand
7. Schriftgewichte
8. Buttons und Mikrotexte
9. Typografie-Vorlagen
10. Abschlussprüfung

## Geänderte Dateien

- `admin/homepage_blocks_help.php`
- `assets/css/homepage-block-help.css`

## Bedienung

Die Hilfeseite wird im Adminbereich aus der Blockverwaltung oder direkt über `admin/homepage_blocks_help.php` geöffnet. Alle neuen Kapitel sind über die linke Navigation und die Volltextsuche erreichbar.

## Technische Leitlinien

- Systemschriften werden als robuste Standardlösung empfohlen.
- Fließtext bleibt auf Smartphones mindestens 16 px groß.
- Responsive Größen können mit `clamp()` umgesetzt werden.
- Die Beispiele berücksichtigen Zeilenhöhe, Zeichenabstand, Schriftgewicht und eindeutige Buttontexte.
