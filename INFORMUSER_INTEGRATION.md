# InformUser-/Message-Modul für nh_hor

## Einbau

Den Inhalt des Ordners `nh_hor/` aus diesem Paket in den vorhandenen Projektordner `C:\xampp\htdocs\nh_hor\` kopieren und vorhandene `admin/index.php` überschreiben.

## Datenbank

In phpMyAdmin die für `nh_hor` verwendete Datenbank auswählen und folgende Migration importieren:

`database/migrations/2026-07-27_communication_module.sql`

Sie legt ausschließlich die Tabellen `communication_messages` und `communication_delivery_log` an.

## Transport konfigurieren

1. `config/communication.local.example.php` kopieren.
2. Die Kopie als `config/communication.local.php` speichern.
3. Lokal mit Mailpit ist vorgesehen:
   - Transport `smtp`
   - Host `127.0.0.1`
   - Port `1025`
   - keine Anmeldung
4. Auf Alfahosting kann `sendmail` mit `/usr/sbin/sendmail -bs` verwendet werden.

`communication.local.php` enthält Serverdaten und gehört nicht in Git. Die bestehende `.gitignore` sollte deshalb um `/config/communication.local.php` ergänzt werden, falls `config/*.local.php` noch nicht allgemein ausgeschlossen ist.

## Test

1. Im vorhandenen Adminbereich anmelden.
2. Dashboard öffnen.
3. Karte **Kommunikation** aufrufen.
4. Empfänger, Betreff und Nachricht eintragen.
5. Modus auswählen:
   - nur E-Mail,
   - nur interne Nachricht,
   - E-Mail und interne Protokollierung.
6. Optional bis zu 20 Anhänge hinzufügen.
7. Test ausführen.
8. Ergebnis unter **Versandprotokoll** kontrollieren.

## Eingliederung

- Klassen: `classes/Communication/`
- mitgelieferte PHPMailer-Basis: `classes/PHPMailer/`
- Konfiguration: `config/communication.php`
- lokale Konfiguration: `config/communication.local.php`
- Admin-Test: `admin/communication-test.php`
- Protokoll: `admin/communication-log.php`
- Migration: `database/migrations/2026-07-27_communication_module.sql`
- temporäre Anhänge: `storage/communication/`

Das Modul verwendet die bestehende `nh_hor`-Adminanmeldung, Rollenprüfung, CSRF-Funktion, PDO-Datenbankverbindung, URL-Hilfsfunktion und das vorhandene Adminlayout.
