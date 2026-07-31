# Kontaktformular – Datenbankspeicherung

Der Formularhandler `kontakt-senden.php` speichert jede validierte Anfrage jetzt zuerst in `contact_requests`.

Ablauf:

1. Eingaben validieren.
2. Datensatz in `contact_requests` anlegen.
3. Benachrichtigungsmail versenden.
4. Mailstatus im gespeicherten Datensatz aktualisieren.
5. Auch bei einem Mailfehler bleibt die Anfrage erhalten.

Benötigte Tabelle:

`database/2026-07-23_contact_requests.sql`

Die Felder `school_type` und `location` des Formulars werden gemeinsam im vorhandenen Datenbankfeld `level` gespeichert.
