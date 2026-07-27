# Kontaktformular-Versand

Die Mailkonfiguration wird URL-abhängig aus `config/config.local.php` oder `config/config.server.php` geladen.

## Lokal

`transport => log` speichert Testnachrichten in `storage/contact-outbox/`. Damit ist kein lokaler Mailserver erforderlich.

## Server

`transport => mail` verwendet die PHP-Funktion `mail()`. Der Webhoster muss diese freigeschaltet haben.

Alternativ kann `transport => smtp` gesetzt werden. Dann sind Host, Port, Verschlüsselung, Benutzername und Passwort in `config.server.php` einzutragen.


## Lokale Absenderadresse

Für den lokalen Log-Transport wird `website@localhost.test` verwendet. Diese Adresse ist syntaktisch gültig und wird nicht tatsächlich versendet.
