# Vollintegration des rollenbasierten Anmeldebereichs

## Grundlage

Dieses Paket ist als Überschreib-/Ergänzungspaket für den aktuellen `nh_hor`-Stand aufgebaut. Der vorhandene Adminbereich bleibt erhalten, verwendet danach aber dieselbe Benutzer- und Sessionverwaltung wie alle übrigen Rollen.

## Installation

1. Vorher eine Sicherung des Projektordners und der Datenbank erstellen.
2. Den Inhalt dieses ZIP direkt nach `C:\xampp\htdocs\nh_hor\` kopieren und vorhandene Dateien ersetzen.
3. In phpMyAdmin die Datenbank von `nh_hor` auswählen.
4. `database/migrations/2026-07-29_unified_internal_login.sql` importieren.
5. Optional prüfen:
   `http://localhost/nh_hor/diagnose_rollenlogin.php`
6. Anmelden:
   `http://localhost/nh_hor/intern/login.php`

## Ergebnis

- Der Anmeldebutton der öffentlichen Webseite führt auf `/intern/login.php`.
- Es existiert nur noch ein Loginformular.
- Alle Benutzer werden aus `internal_users` gelesen.
- Die Rolle wird über den Anmeldenamen aus der Datenbank bestimmt.
- Administratoren werden über `/admin.php` auf `/admin/index.php` weitergeleitet.
- Der bestehende Adminbereich akzeptiert die neue zentrale Session.
- `/admin/login.php` leitet auf `/intern/login.php` um.
- `/admin/logout.php` und `/intern/logout.php` melden vollständig ab.
- Menüpunkte der internen Portale werden anhand von Berechtigungen angezeigt.
- Direkte Seitenaufrufe werden serverseitig mit Rollen- und Berechtigungsprüfungen geschützt.
- `othiele` wird aus `admin_users` nach `internal_users` übernommen und behält sein bisheriges Passwort.

## Testfolge

1. `othiele` anmelden → Weiterleitung auf `admin.php` → `admin/index.php`.
2. `eltern.fischer` anmelden → Elternportal.
3. `lehrer.thiele` anmelden → Lehrerportal.
4. Abmelden → Rückkehr zu `intern/login.php`.
5. Geschützte URL einer anderen Rolle direkt aufrufen → HTTP 403.

Die Datei `diagnose_rollenlogin.php` nach erfolgreicher Prüfung löschen.
