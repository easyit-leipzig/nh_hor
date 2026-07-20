# Deep-Research-Auswertung – nh_hor Revision V2

**Analysierter Stand:** `nh_hor_stand_19.07.26.zip`  
**Datum:** 19.07.2026  
**Umfang:** 180 Dateien; PHP, CSS, JavaScript, Apache-Konfiguration, Datenbank-/Migrationsdateien, SEO-Struktur, Adminbereich, Formulare und Dokumentation.

## 1. Gesamturteil

Revision V2 ist gegenüber dem vorherigen Migrationsstand deutlich konsistenter. Der produktive PHP-/CSS-/JS-Code verwendet nahezu durchgehend `/nh_hor/`; sämtliche geprüften PHP-Dateien bestehen den Syntaxcheck. Das horizontale Menü, die modularen Seitentemplates, die fachbezogenen Landingpages, die Stadtteilseiten, die Schulformseiten, der Blog, die Werkzeuge und der Adminbereich bilden bereits eine tragfähige technische Gesamtstruktur.

Der Stand ist jedoch noch nicht produktionsreif. Die wichtigsten Blocker sind:

1. Die Website ist zugleich für `https://easyit-leipzig.de` und den Unterpfad `/nh_hor` konfiguriert. Es fehlt eine endgültige Entscheidung, ob `/nh_hor` nur Entwicklungsverzeichnis oder dauerhafter öffentlicher URL-Bestandteil sein soll.
2. In `config/site.php` und `config/database.php` stehen weiterhin Platzhalterwerte.
3. `admin/delete.php` verändert den Datenbestand über einen GET-Aufruf und besitzt keinen CSRF-Schutz.
4. Die automatisch gebildete Canonical-URL übernimmt ungefiltert den kompletten `REQUEST_URI`, einschließlich möglicher Query-Parameter.
5. Die statische XML-Sitemap enthält URLs, die laut `robots.txt` nicht indexiert werden sollen, insbesondere `offline.php`.
6. Die globale LocalBusiness-Auszeichnung ist inhaltlich unvollständig und enthält Platzhalterdaten.
7. Eine echte Laufzeit-, Browser-, Mobil-, Lighthouse-, Datenbank- und Mailprüfung war ausschließlich anhand des ZIP-Archivs nicht möglich.

## 2. Nachgewiesene Stärken

### 2.1 Technische Struktur

- Alle geprüften PHP-Dateien sind syntaktisch fehlerfrei.
- Wiederverwendbare Includes für Header, Footer, Metadaten, Navigation, Sicherheit, Datenbank und Inhalt sind vorhanden.
- Fach-, Schulform-, Stadtteil- und Werkzeugseiten werden zentral aus Konfigurationsdaten aufgebaut; das reduziert redundanten Code.
- PDO ist mit Exceptions, nativen Prepared Statements und UTF-8 konfiguriert.
- Passwortprüfung erfolgt mit `password_verify()`.
- Nach erfolgreicher Anmeldung wird die Session-ID erneuert.
- Kontaktformular und Login enthalten CSRF-Prüfungen.
- Das Kontaktformular besitzt Honeypot, Längenprüfung, E-Mail-Validierung und einfache Rate-Limitierung.
- Apache deaktiviert Directory Listing und sperrt `database`, `storage` und `cache`.
- Sicherheitsheader wie `nosniff`, Referrer-Policy, Permissions-Policy, HSTS und Frame-Schutz sind vorgesehen.

### 2.2 SEO- und Inhaltsarchitektur

- Für die wesentlichen Seitentypen existieren individuelle Titel, Beschreibungen und Canonicals über zentrale Templates.
- Eine XML-Sitemap mit 53 URLs und ein `robots.txt` sind vorhanden.
- Fach-, Schulform- und Stadtteilseiten bilden eine nachvollziehbare lokale Themenarchitektur.
- Breadcrumbs, interne Querverweise, FAQ-Bereiche und strukturierte Daten sind vorbereitet.
- Open-Graph- und Twitter-Metadaten sind zentral umgesetzt.

### 2.3 Frontend

- Das horizontale, mehrstufige Menü ist als zentrale Navigation umgesetzt.
- Skip-Link, semantische Navigation, Suchformular und mobile Menüschaltfläche sind vorhanden.
- Bilder besitzen überwiegend feste Breiten- und Höhenattribute; das reduziert Layoutverschiebungen.
- Nichtkritische Bilder werden lazy geladen, das Hero-Bild erhält hohe Ladepriorität.
- Die CSS-Struktur ist auf einzelne Verantwortungsbereiche verteilt.

## 3. Kritische Befunde und Lösungsschritte

## P0 – Vor Veröffentlichung zwingend lösen

### 3.1 Endgültige URL- und Pfadstrategie festlegen

**Befund:**  
`base_url` ist `https://easyit-leipzig.de`, während `base_path` und nahezu alle internen Links `/nh_hor` enthalten. Dadurch lautet die öffentliche Zieladresse derzeit beispielsweise:

`https://easyit-leipzig.de/nh_hor/mathe-nachhilfe-leipzig.php`

Falls `nh_hor` nur das lokale oder serverseitige Projektverzeichnis ist, wäre diese URL-Struktur falsch. Sie würde Entwicklungsnamen dauerhaft in Index, Sitemap, Canonicals, strukturierten Daten und internen Links veröffentlichen.

**Lösung:**

- Zielvariante A – Website im Domain-Root:
  - `base_path` auf leere Zeichenkette setzen.
  - alle hart codierten `/nh_hor/...`-Links durch eine zentrale URL-Hilfsfunktion ersetzen.
  - Apache DocumentRoot direkt auf das Projektverzeichnis legen.
  - Canonicals und Sitemap auf `https://easyit-leipzig.de/...` umstellen.
- Zielvariante B – Website dauerhaft unter `/nh_hor/`:
  - Konfiguration beibehalten, aber bewusst dokumentieren.
  - Root-URL sauber auf `/nh_hor/` umleiten.
  - alle früheren URLs per 301 weiterleiten.

**Empfehlung:** Variante A. Der technische Projektname sollte nicht Teil der öffentlichen Marken- und SEO-URL werden.

### 3.2 Produktionskonfiguration von Quellcode trennen

**Befund:**

- `config/database.php`: Passwort `CHANGE_ME`
- `config/site.php`: Telefonnummer `+49 000 0000000`
- DB-Zugangsdaten sind direkt im Repository abgelegt.

**Risiko:** Ausfall, fehlerhafte strukturierte Daten, falsche Kontaktdaten und unnötige Offenlegung von Infrastrukturinformationen.

**Lösung:**

1. Umgebungsvariablen oder eine außerhalb des Webroots liegende lokale Konfigurationsdatei verwenden.
2. Beim Start fehlende Pflichtwerte erkennen und mit kontrollierter Fehlermeldung abbrechen.
3. Echte Telefonnummer, vollständige Geschäftsadresse und produktive E-Mail-Adresse eintragen.
4. Beispielkonfiguration als `config/database.example.php` behalten; echte Zugangsdaten nicht versionieren.

### 3.3 Admin-Archivierung von GET auf POST umstellen

**Befund:**  
`admin/delete.php?id=...` archiviert einen Datensatz über GET. Ein eingeloggter Administrator kann dadurch über einen fremden Link oder eingebettete Ressource zu einer unbeabsichtigten Aktion gebracht werden. CSRF-Token und Methodenkontrolle fehlen.

**Lösung:**

- ausschließlich `POST` akzeptieren;
- CSRF-Token prüfen;
- Datensatz-ID als verborgenes Formularfeld übertragen;
- optional Bestätigungsdialog einsetzen;
- fehlgeschlagene Aktionen protokollieren;
- Berechtigungsprüfung nach Rolle ergänzen.

### 3.4 Canonical-URL normalisieren

**Befund:**  
Die Standard-Canonical wird aus dem vollständigen `$_SERVER['REQUEST_URI']` erzeugt. Damit können Such-, Tracking- oder beliebige Query-Parameter in Canonicals gelangen. Bei Seiten wie `sitemap.php?q=...` kann so eine Parameter-URL als kanonisch ausgezeichnet werden.

**Lösung:**

- nur den URL-Pfad übernehmen;
- bekannte kanonische Parameter ausdrücklich zulassen, etwa `slug` bei Blogartikeln oder `tutor` bei Tutorbewertungen;
- Tracking-, Such- und Formularparameter entfernen;
- Host niemals ungeprüft aus dem Request übernehmen;
- Startseite einheitlich entweder mit `/` oder `/index.php` kanonisieren, nicht gemischt.

### 3.5 Sitemap und Robots-Regeln synchronisieren

**Befund:**  
`offline.php` steht in der XML-Sitemap, wird aber in `robots.txt` ausgeschlossen. Eine Sitemap sollte indexierbare kanonische URLs enthalten. Zudem ist eine statische Sitemap bei datenbankgestützten Blog- oder Inhaltsseiten wartungsanfällig.

**Lösung:**

- `offline.php` aus der Sitemap entfernen und mit `noindex` versehen;
- Erfolgs-, Fehler-, Admin-, Vorschau- und Formular-Endpunkte nicht aufnehmen;
- dynamisch veröffentlichte Blogartikel in die XML-Sitemap aufnehmen;
- nur URLs mit HTTP 200, indexierbarem Robots-Meta und selbstreferenzierendem Canonical ausgeben;
- `lastmod` aus tatsächlichen Änderungsdaten erzeugen.

### 3.6 Strukturierte LocalBusiness-Daten vervollständigen

**Befund:**  
Auf jeder Seite wird eine kombinierte `EducationalOrganization`-/`LocalBusiness`-Auszeichnung ausgegeben. Die Telefonnummer ist ein Platzhalter; vollständige Anschrift, Bild-URL, gegebenenfalls Öffnungszeiten, Preisbereich und eindeutige Unternehmenskennung fehlen.

**Lösung:**

- ausschließlich reale, sichtbare und konsistente Geschäftsdaten auszeichnen;
- vollständige `PostalAddress` ergänzen;
- reale Telefonnummer verwenden;
- Logo und repräsentatives Bild als absolute URLs angeben;
- `sameAs` nur bei vorhandenen offiziellen Profilen ergänzen;
- Seitentyp-spezifische Schemas getrennt aufbauen: Organization global, BreadcrumbList pro Seite, FAQPage nur bei sichtbaren FAQ, Article bei Blogartikeln.

## P1 – Hohe Priorität

### 3.7 Content Security Policy und Session-Cookie-Härtung ergänzen

**Befund:**  
Mehrere Sicherheitsheader sind vorhanden, eine Content Security Policy fehlt. Aus dem geprüften Code ist nicht ersichtlich, ob Session-Cookies zentral mit `Secure`, `HttpOnly` und `SameSite` gesetzt werden.

**Lösung:**

- zunächst CSP im Report-Only-Modus testen;
- anschließend restriktive CSP aktivieren;
- Session-Cookies vor `session_start()` mit `secure`, `httponly`, `samesite=Lax` oder strenger konfigurieren;
- Session-Laufzeit und Inaktivitäts-Timeout definieren;
- Loginversuche serverseitig begrenzen und protokollieren.

### 3.8 Historische Dateien und Entwicklungsartefakte aus dem Webroot entfernen

**Befund:**  
Im Paket liegen alte Installations-, Migrations- und Analyseunterlagen sowie SQL-Dateien und ZIP-Dateien. Apache sperrt einige Verzeichnisse, aber unnötige Dateien im Webroot erhöhen Komplexität und Fehlkonfigurationsrisiko. Alte Namen `NH_SEO` finden sich noch in historischen Dokumenten.

**Lösung:**

- produktives Deployment auf tatsächlich benötigte Laufzeitdateien begrenzen;
- Dokumentation, SQL-Dumps, Projektdateien und ZIP-Archive außerhalb des Webroots ablegen;
- alte `INSTALLATION_NH_SEO.md`, `README_NH_SEO.txt` und ähnliche Altdateien archivieren;
- Webserver-Regeln zusätzlich gegen `.sql`, `.zip`, `.md`, `.ppj`, Backups und temporäre Dateien härten.

### 3.9 Alte oder doppelte Asset-Strukturen bereinigen

**Befund:**

- aktive Styles liegen in `assets/css/`;
- daneben existiert `css/main.css` mit 8 KB;
- daneben existiert `js/menu.js`, während das aktive Frontend Skripte aus `assets/js/` lädt.

**Risiko:** Unklarheit, versehentliche Regressionen und unnötige Altlasten.

**Lösung:**

- anhand der tatsächlichen Includes unbenutzte Dateien entfernen;
- nur eine Asset-Struktur behalten;
- Dateinamen bei Änderungen versionieren oder Content-Hashes verwenden;
- Cache-Control langfristig nur für versionierte Dateien setzen.

### 3.10 Datenbankmigrationen und MyISAM-Varianten vereinheitlichen

**Befund:**  
Es existieren parallele Schemas und Migrationsdateien, darunter MyISAM-Varianten. MyISAM unterstützt keine Transaktionen und keine echten Fremdschlüssel. Für Admin-, Inhalts- und Bewertungsdaten ist InnoDB die robustere Basis.

**Lösung:**

- produktiv ausschließlich InnoDB einsetzen;
- ein kanonisches Basisschema und eine lineare Migrationskette definieren;
- Migrationen in Transaktionen ausführen, soweit DDL/DB-Version dies unterstützt;
- Migrationsstatus und Fehlerfälle testen;
- Datenbankinstallationsarchive nicht öffentlich deployen.

### 3.11 Fehler- und Datenschutzbehandlung des Kontaktformulars verbessern

**Befund:**  
Das Formular schreibt ein Ereignisprotokoll mit Fingerprint in `storage/contact-events.log`. Die genaue Fingerprintbildung, Löschfrist und datenschutzrechtliche Erforderlichkeit müssen transparent geprüft werden. `mail()` liefert nur einen booleschen Übergabestatus, keine verlässliche Zustellbestätigung.

**Lösung:**

- nur minimal erforderliche Logdaten speichern;
- Fingerprint salzen, begrenzen oder entfernen, falls nicht zwingend erforderlich;
- automatische Löschfrist einführen;
- Datenschutzerklärung konkret anpassen;
- SMTP-Bibliothek mit authentifiziertem Versand und sauberem Fehlerlogging einsetzen;
- SPF, DKIM und DMARC für die Absenderdomain konfigurieren.

## P2 – Qualität, Barrierefreiheit und Performance

### 3.12 Menüinteraktion nach WCAG 2.2 testen

**Befund:**  
Das Menü ist mehrstufig und verwendet Links mit `href="#"` zugleich als Untermenüschalter. Dies kann bei Tastatur-, Touch- und Screenreader-Nutzung problematisch sein. Die statische Codeprüfung ersetzt keinen Interaktionstest.

**Lösung:**

- reine Untermenüschalter als echte Buttons umsetzen oder Link und Schalter trennen;
- Escape-Schließen, Fokusführung, Pfeiltastenlogik und Fokusverlust testen;
- sichtbare `:focus-visible`-Darstellung sicherstellen;
- Touch-Ziele und Abstände gemäß WCAG 2.2 prüfen;
- Hover-Inhalte müssen schließbar, überfahrbar und persistent sein.

### 3.13 Überschriftenstruktur prüfen

**Befund:**  
`tutor-bewertungen.php` enthält statisch zwei `<h1>`-Elemente. Bei templatebasierten Seiten ist die tatsächliche Laufzeitausgabe zusätzlich zu prüfen.

**Lösung:**

- pro Seite einen klaren Haupttitel verwenden;
- weitere Hauptbereiche mit `<h2>` strukturieren;
- automatisierten HTML-Validator und Accessibility-Test in den Workflow aufnehmen.

### 3.14 Core Web Vitals messen, nicht nur ableiten

**Befund:**  
Die Architektur enthält sinnvolle Grundlagen, aber aus dem ZIP lassen sich LCP, INP und CLS nicht belastbar bestimmen. Das 793-KB-Logo-SVG und die 2,26-MB-PNG-Datei sind auffällig groß, auch wenn aktuell überwiegend SVG verwendet wird.

**Lösung:**

- Lighthouse und PageSpeed Insights auf der realen HTTPS-Seite ausführen;
- LCP-Hero-Bild, CSS-Kaskade und JS-Ausführung messen;
- große oder unbenutzte Bilddateien entfernen/optimieren;
- kritisches CSS klein halten;
- Suchindex und nicht benötigte Skripte nur dort laden, wo erforderlich;
- reale Felddaten über Search Console/CrUX beobachten.

### 3.15 Suchfunktion und Sitemap-Seite trennen

**Befund:**  
Das Suchformular sendet an `sitemap.php`, während JavaScript offenbar clientseitige Vorschläge liefert. Ohne JavaScript entsteht semantisch eher eine Sitemap mit Suchparameter als eine echte Suche.

**Lösung:**

- eigene `suche.php` mit serverseitigem Fallback anlegen;
- Suchergebnisse mit `noindex,follow` auszeichnen;
- Suchparameter aus Canonicals entfernen;
- die statische Sitemap-Seite unabhängig halten.

### 3.16 Bild- und Markenkonsistenz verbessern

**Befund:**  
Mehrere Logo-Varianten und generische SVG-Illustrationen liegen parallel vor. Die Headerdatei deklariert das Logo mit `width="300" height="200"`; die reale Darstellung wird per CSS korrigiert. Das Seitenverhältnis sollte zur tatsächlichen SVG-ViewBox passen.

**Lösung:**

- eine verbindliche Logoquelle definieren;
- korrekte intrinsische Maße beziehungsweise ein korrektes Seitenverhältnis verwenden;
- Social Preview als PNG/JPEG in geeigneter Größe ergänzen, da externe Plattformen SVG nicht überall zuverlässig darstellen;
- Bildsprache pro Seitentyp vereinheitlichen.

## 4. Empfohlene Umsetzungsreihenfolge

### Schritt 1 – Produktionsziel festlegen

- Domain-Root oder `/nh_hor/` verbindlich entscheiden.
- zentrale URL-Funktion einführen.
- Canonicals, Sitemap, Robots, Schema und interne Links auf dieselbe Strategie bringen.

### Schritt 2 – Sicherheitsblocker beheben

- Admin-Archivierung auf POST + CSRF umstellen.
- Session-Cookies härten.
- CSP zunächst im Report-Only-Modus ergänzen.
- Konfiguration und Zugangsdaten aus dem Webroot/Repository lösen.

### Schritt 3 – reale Unternehmensdaten eintragen

- Telefonnummer, Adresse, E-Mail, Absenderdaten und Rechtstexte prüfen.
- LocalBusiness-/Organization-Schema auf echte Angaben begrenzen.
- Impressum und Datenschutz gegen tatsächliche Verarbeitungsvorgänge abgleichen.

### Schritt 4 – Indexierungslogik konsolidieren

- Canonical-Normalisierung implementieren.
- Sitemap dynamisch aus veröffentlichbaren Seiten erzeugen.
- Offline-/Erfolgs-/Such-/Adminseiten auf `noindex` setzen und aus Sitemap entfernen.
- Blogartikel und dynamische Tutorprofile korrekt aufnehmen.

### Schritt 5 – Deployment-Paket bereinigen

- SQL-Dumps, ZIPs, historische Dokumentation, Projektdateien und Altassets entfernen.
- nur Laufzeitdateien deployen.
- InnoDB als einzige produktive Engine festlegen.

### Schritt 6 – Browser- und Accessibility-Test

Mindestens testen:

- Desktop: Chrome, Firefox, Edge
- Mobil: Chrome Android, Safari iOS
- Tastatur-only
- Screenreader-Kurztest
- 320 px, 375 px, 768 px, 1024 px und große Desktopbreiten
- Menüebenen, Suche, Kontaktformular, Adminlogin, Adminbearbeitung, Fehlerseiten

### Schritt 7 – Performance- und SEO-Abnahme auf Live-/Staging-System

- Lighthouse je Hauptseitentyp
- PageSpeed Insights
- Rich Results Test
- Schema Markup Validator
- Search Console URL-Prüfung
- XML-Sitemap-Test
- Linkcrawler
- HTML-Validator

## 5. Konkrete Definition of Done für Revision V3

Revision V3 kann als staging-reif gelten, wenn:

- keine Platzhalterwerte mehr produktiv vorhanden sind;
- die öffentliche URL-Strategie eindeutig ist;
- keine zustandsändernde Adminaktion per GET erfolgt;
- sämtliche Canonicals parameterbereinigt und selbstreferenzierend sind;
- Sitemap, Robots und Meta-Robots widerspruchsfrei sind;
- dynamische veröffentlichte Inhalte in der Sitemap erscheinen;
- sensible Entwicklungsdateien nicht im Deployment liegen;
- Session-Cookies und CSRF-Schutz vollständig geprüft sind;
- Menü und Formulare tastaturbedienbar sind;
- keine kritischen Lighthouse-/Accessibility-Fehler bestehen;
- Datenbankmigration, Kontaktversand und Adminabläufe auf einem Staging-System erfolgreich durchlaufen wurden.

## 6. Grenzen dieser Analyse

Die Analyse basiert auf dem gelieferten ZIP-Archiv. Nicht geprüft werden konnten:

- tatsächliche HTTP-Statuscodes und Weiterleitungen auf dem Zielserver;
- Apache-Modulverfügbarkeit und Hostkonfiguration;
- reale Datenbankstruktur und Migrationserfolg;
- SMTP-/Mailzustellung;
- serverseitige Dateiberechtigungen;
- reale Browserdarstellung und responsive Interaktion;
- Lighthouse-/Core-Web-Vitals-Messwerte;
- Google-Indexierungsstatus und Search-Console-Daten;
- rechtliche Vollständigkeit von Impressum und Datenschutzerklärung.

Diese Punkte müssen nach den P0-Korrekturen auf einem Staging-System geprüft werden.
