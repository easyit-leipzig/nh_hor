# Aktualisierungsfix für Angebote und Preise

Behoben wurden:

- Zahlenpreis hat Vorrang vor einem alten freien Preistext.
- Bei Eingabe eines Zahlenpreises wird ein vorhandener Platzhaltertext beim Speichern geleert.
- `preise.php` wird mit No-Cache-Headern ausgeliefert.
- Der Admin-Link zur Preisseite enthält einen Cache-Buster.
- Im Adminbereich wird die letzte Änderungszeit angezeigt.

Nach dem Ersetzen der Dateien Apache neu starten und die Seite einmal mit `Strg + F5` laden.
