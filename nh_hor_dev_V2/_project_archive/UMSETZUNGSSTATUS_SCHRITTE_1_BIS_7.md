# Umsetzungsstatus der empfohlenen Reihenfolge

## Schritt 1 – Produktionsziel

Erledigt. Kanonisches Ziel ist `https://easyit-leipzig.de/`; `/nh_hor` bleibt ausschließlich ein interner Serverordner. Canonicals, interne Links, Robots, strukturierte Daten und Sitemap verwenden dieselbe Strategie.

## Schritt 2 – Sicherheitsblocker

Erledigt. Adminarchivierung arbeitet mit POST, CSRF und Rollenprüfung. Sessions sind gehärtet und zeitlich begrenzt. CSP ist standardmäßig Report-Only und kann nach der Auswertung aktiviert werden. Produktive Geheimnisse werden über externe Konfiguration beziehungsweise Umgebungsvariablen geladen.

## Schritt 3 – Unternehmensdaten

Technisch erledigt. PostalAddress, Telefonnummer, E-Mail, Logo, Social Preview und Organization-Schema werden zentral erzeugt. `sameAs`, Öffnungszeiten, Preisbereich und Geodaten werden nur ausgegeben, wenn reale Werte konfiguriert wurden. Vor Livegang müssen alle Angaben nochmals sachlich bestätigt werden.

## Schritt 4 – Indexierung

Erledigt. Canonicals sind normalisiert. Es existiert nur noch eine dynamische XML-Sitemap. Suche, Admin, Offline-, Erfolgs- und Fehlerseiten sind `noindex`; veröffentlichte Blogartikel und Tutorprofile werden dynamisch behandelt.

## Schritt 5 – Deployment

Erledigt. Der Webroot enthält nur Laufzeitdateien. SQL, Archive, Dokumentation, Tests und Migrationen liegen in `_project_archive`. Datenbankziel ist ausschließlich InnoDB. Die produktive Apache-Konfiguration liegt als echte `nh_hor/.htaccess` vor.

## Schritt 6 – Browser und Accessibility

Automatisierbarer Workflow ergänzt. Playwright prüft Chromium, Firefox und WebKit bei 320, 375, 768, 1024 und 1440 Pixeln. Axe-, Überschriften- und Release-Audits sind enthalten. Reale Android-/iOS-Geräte und ein manueller Screenreader-Kurztest bleiben vor Freigabe erforderlich.

## Schritt 7 – Live-/Staging-Abnahme

Lighthouse-CI, Accessibility-Tests und eine Abnahmeanleitung sind enthalten. PageSpeed Insights, Rich Results Test, Schema Markup Validator, Search Console, CrUX und Linkcrawler müssen gegen die tatsächlich bereitgestellte HTTPS-Fassung ausgeführt werden, weil sie reale Server- und Nutzungsdaten benötigen.
