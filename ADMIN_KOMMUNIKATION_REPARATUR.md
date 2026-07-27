# Reparatur der Admin-Kommunikation

## Behobener Fehler

Der Aufruf `admin_verify_csrf_or_abort()` in `admin/communication-test.php` und `admin/career-job-edit.php` führte zu einem Fatal Error, weil die zentrale Funktion im aktuellen Stand von `admin/includes/admin-functions.php` fehlte.

Die Funktion wurde zentral ergänzt. Sie prüft:

- dass die Anfrage per POST erfolgt,
- dass das übermittelte CSRF-Token gültig ist,
- und beendet ungültige Anfragen mit HTTP 403.

Zusätzlich legt die Kommunikations-Testseite `storage/communication` bei Bedarf an und prüft dessen Schreibbarkeit.

## Test

1. Im Adminbereich anmelden.
2. `admin/communication-test.php` öffnen.
3. Zunächst den Modus **Nur interne Nachricht speichern** testen.
4. Danach Mailpit oder den produktiven Transport in `config/communication.local.php` konfigurieren.
5. E-Mail-Versand testen.
6. `admin/communication-log.php` aufrufen und das Protokoll prüfen.

## Datenbank

Die Tabellen `communication_messages` und `communication_delivery_log` sind im mitgelieferten SQL-Stand bereits vorhanden. Alternativ kann nur die Migration `database/migrations/2026-07-27_communication_module.sql` importiert werden.
