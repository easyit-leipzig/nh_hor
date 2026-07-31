# Angebote und Preise – Datenbank- und Adminmodul

## 1. Datenbank installieren

In phpMyAdmin die Datenbank des Projekts auswählen und folgende Datei importieren:

`database/migrations/2026-07-28_offers.sql`

Die Migration erzeugt die Tabelle `offers` und übernimmt die drei bisher statisch eingetragenen Angebote als Startdaten.

## 2. Adminbereich öffnen

Nach der Anmeldung:

`http://localhost/nh_hor/admin/offers.php`

Alternativ über den neuen Menüpunkt **Angebote & Preise**.

## 3. Angebot anlegen

- Kennzeichnung, Titel und Beschreibung eintragen.
- Entweder einen numerischen Preis, beispielsweise `25,00`, oder einen freien Preistext wie `kostenfrei` eintragen.
- Die Preiseinheit kann beispielsweise `/ 60 Minuten` lauten.
- Leistungsmerkmale werden zeilenweise eingegeben.
- Mit **Auf der Preisseite veröffentlichen** wird das Angebot sichtbar.
- Die Sortiernummer bestimmt die Reihenfolge.

## 4. Öffentliche Ausgabe

`preise.php` liest ausschließlich aktive Angebote aus der Datenbank. Neue Angebote und Preisänderungen erscheinen nach dem Speichern unmittelbar auf der Seite.

## Enthaltene Dateien

- `admin/offers.php`
- `includes/offer-repository.php`
- `preise.php`
- `database/migrations/2026-07-28_offers.sql`
- Ergänzungen in `admin/includes/header.php` und `admin/index.php`
- Wiederherstellung des vollständigen öffentlichen Headers
