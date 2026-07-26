# Karriere-Modul RC 1.0 – Fehlerkorrektur

## Behobener Fehler

`admin/career-job-edit.php` rief die nicht vorhandene Funktion `verify_csrf_or_abort()` auf.

## Korrektur

Der Karriere-Editor nutzt nun die gemeinsame Admin-Funktion `admin_verify_csrf_or_abort()`. Diese greift auf die bereits bestehende Sicherheitsfunktion `csrf_is_valid()` zurück.

## Test

1. Als Administrator anmelden.
2. `/nh_hor/admin/career-jobs.php` öffnen.
3. Ein Profil über **Bearbeiten** öffnen.
4. Profil unverändert speichern.
5. Danach Titel oder Slogan ändern und erneut speichern.
6. Seite neu öffnen und die gespeicherten Werte kontrollieren.

Bei einem abgelaufenen oder ungültigen CSRF-Token wird nun eine verständliche HTTP-403-Meldung ausgegeben, statt eines PHP-Fatal-Errors.
