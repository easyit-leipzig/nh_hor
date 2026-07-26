# Karriere-Modul – Phase 1

## Umgesetzt

- zentrale Karriereseite `karriere.php`
- einheitliches Arbeitgeberversprechen und easyIT-Werte
- vorbereitete Stellenprofile für Deutsch (DEU), Französisch (FRA), Spanisch (SPAN) und soziale/verwandte Fächer (SOZ)
- je Profil eine funktionsfähige, horizontal scrollbare Bildserie mit vorhandenen Projektbildern
- Werte, Anforderungen, passende Profile und Fächer je Stellenangebot
- responsive Darstellung für Desktop, Tablet und Smartphone
- zentrale Datenhaltung in `config/jobs.php`
- ausführliche Fotobeschreibungsliste `FOTOBESCHREIBUNGEN_JOBS_PHASE_1.md`
- idempotentes SQL für den Navigationspunkt `Karriere`

## Installation

1. Gesamtordner nach `C:\xampp\htdocs\nh_hor` kopieren und vorhandene Dateien ersetzen.
2. `sql/phase_1_karriere_navigation.sql` in der verwendeten Datenbank importieren.
3. `http://localhost/nh_hor/karriere.php` öffnen.
4. Browsercache mit `Strg + F5` aktualisieren.

## Nächste Phase

Phase 2 erstellt eigenständige Detailseiten für DEU, FRA, SPAN und SOZ, jeweils mit erweitertem Stellenprofil, FAQ, Bewerbungsablauf und vollständiger Bildstrecke.
