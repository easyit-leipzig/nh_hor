# Sicherheitsumsetzung

## Umgesetzt

- CSP wird in Produktion standardmäßig erzwungen; lokal läuft sie zunächst im Report-only-Modus.
- Sichere Session-Cookies, strikter Cookie-Modus, Zeitüberschreitung, regelmäßige Session-ID-Erneuerung und User-Agent-Bindung.
- Adminstatus wird regelmäßig gegen den aktiven Datenbankbenutzer geprüft.
- Login-Limitierung, CSRF-Schutz und rollenbasierte Adminaktionen bleiben aktiv.
- Die Admin-Ersteinrichtung ist in Produktion standardmäßig deaktiviert und enthält keinen fest eingebauten Schlüssel mehr.
- Konfiguration, Datenbank, Storage, Projektarchive und interne Arbeitsstände sind per Webserver-Regeln gesperrt.
- In Uploadverzeichnissen ist die Ausführung von PHP und anderen Skriptdateien gesperrt.
- Zusätzliche Browser-Sicherheitsheader und No-Store für dynamische PHP-Antworten.

## Einrichtung

Für eine einmalige lokale Admin-Ersteinrichtung `config/admin.local.php.example` nach `config/admin.local.php` kopieren und einen zufälligen Schlüssel mit mindestens 32 Zeichen einsetzen. In Produktion bevorzugt Umgebungsvariablen verwenden:

- `ADMIN_SETUP_TOKEN`
- `ENABLE_ADMIN_SETUP=false`
- `CSP_MODE=enforce`
- `APP_ENV=production`

Nach der ersten Adminanlage `ENABLE_ADMIN_SETUP=false` setzen beziehungsweise `admin.local.php` entfernen.
