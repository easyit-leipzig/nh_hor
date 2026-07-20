---
title: "ChatGPT - Webseite"
source: "https://chatgpt.com/g/g-p-6a47d4721c548191933c72984f9fd931-webseite/c/6a5b8225-854c-83eb-b453-177498e76397"
---

**You:**

stand_18.07.26.zipZIP-Archivdas ist der aktuelle stand. führe ein deep research über die webseite durch und analysiere diese

* * *

**ChatGPT:**

# Deep-Research-Analyse der Website

**Analysierter Stand:** `stand_18.07.26.zip`

Ich habe die vollständige ZIP-Datei entpackt und den PHP-, CSS-, JavaScript-, SQL-, CMS-, SEO- und Administrationsaufbau statisch untersucht. Zusätzlich habe ich die Umsetzung mit aktuellen Vorgaben von Google Search Central, web.dev, OWASP und W3C/WCAG 2.2 abgeglichen.

## 1. Gesamturteil

Die Website ist **kein früher Prototyp mehr**, sondern bereits ein umfangreiches, grundsätzlich tragfähiges Websystem:

* 96 PHP-Dateien
* rund 8.300 Code- und Dokumentationszeilen
* horizontale Navigation und ergänzende Seitenleiste
* Fach-, Schulform- und Stadtteilseiten
* Blogsystem
* Administrationsbereich
* Datenbankmigrationen
* Inhaltsrepository und Cache
* Kontaktformular
* Bewertungen und Tutorprofile
* Lernwerkzeuge
* PWA-Grundlagen mit Manifest und Service Worker
* strukturierte Daten
* Sitemap und robots.txt
* responsive CSS-Struktur
* vorbereitete Sicherheitsfunktionen

**Technischer Reifegrad:** etwa **70 %**

**Veröffentlichungsreife:** derzeit nur etwa **45–50 %**

Die Differenz entsteht nicht durch fehlenden Umfang, sondern durch mehrere zentrale Pfad-, Canonical-, Rechts-, Inhalts- und Konfigurationsfehler. In der aktuellen Form sollte die Website **noch nicht unter der produktiven Domain veröffentlicht werden**.

* * *

# 2. Wichtigste Ergebnisse

## Kritisch: Vor Veröffentlichung zwingend korrigieren

### 2.1 Das Pfadsystem ist nicht konsistent

Die Seite verwendet gleichzeitig vier unterschiedliche URL-Modelle:

* `/nh_hor/...`
* `/nh_seo/...`
* `/admin/...`
* `/dateiname.php`

Das ist derzeit die größte technische Schwachstelle.

Beispiele:

```PHP
header('Location: /admin/login.php');
```

Bei einer Installation unter:

```
https://localhost/nh_hor/
```

führt das zu:

```
https://localhost/admin/login.php
```

statt zu:

```
https://localhost/nh_hor/admin/login.php
```

Betroffen sind unter anderem:

* Admin-Login
* Admin-Logout
* Admin-Weiterleitungen
* Kontaktformular
* Erfolgsseite
* Fehlerseiten
* Fachverlinkungen
* Stadtteilverlinkungen
* Schulformseiten
* Lernwerkzeuge
* HTML-Sitemap

In der `.htaccess` stehen sogar noch die alten Fehlerpfade:

```apache
ErrorDocument 404 /nh_seo/errors/404.php
ErrorDocument 500 /nh_seo/errors/500.php
```

Damit wird die Migration von `nh_seo` nach `nh_hor` technisch nicht vollständig abgeschlossen.

### Bewertung

**Schweregrad: kritisch**

Die Website funktioniert abhängig vom Aufrufpfad teilweise, aber nicht zuverlässig als geschlossenes System.

### Empfohlene Lösung

Es sollte genau eine zentrale Konfiguration geben:

```PHP
'base_path' => '/nh_hor',
'base_url'  => 'https://easyit-leipzig.de',
```

und eine URL-Hilfsfunktion:

```PHP
function site_url(string $path = ''): string
{
    $site = require __DIR__ . '/../config/site.php';

    return rtrim($site['base_path'], '/')
        . '/'
        . ltrim($path, '/');
}
```

Danach:

```PHP
header('Location: ' . site_url('admin/login.php'));
```

Für die produktive Domain sollte `base_path` später vermutlich leer sein:

```PHP
'base_path' => '',
```

Dadurch muss beim Umzug nichts mehr in Dutzenden Dateien geändert werden.

* * *

## 2.2 Mehrere Canonical-URLs sind objektiv falsch

Besonders kritisch sind die Template-Dateien:

```PHP
$pageCanonical = $site['base_url'] . '/index.php' . $subject['file'];
```

Bei einem Fach entsteht daraus beispielsweise:

```
https://easyit-leipzig.de/index.phpmathe-nachhilfe-leipzig.php
```

Entsprechende Fehler befinden sich in:

* `includes/subject-page.php`
* `includes/area-page.php`
* `includes/school-type-page.php`
* `includes/tool-page.php`

Die Startseite verwendet:

```PHP
https://easyit-leipzig.de/index.php
```

Die XML-Sitemap verwendet hingegen:

```
https://easyit-leipzig.de/
```

Auch bei den Tutorbewertungen enthält die Sitemap URLs mit `/nh_hor/`, obwohl fast alle anderen Sitemap-Adressen ohne diesen Ordner eingetragen sind.

Canonical-Angaben sollen Google eine konsistente bevorzugte URL nennen. Widersprüchliche oder nicht existierende Canonicals erschweren die Zusammenführung gleicher Inhalte und können dazu führen, dass Google andere URLs auswählt. [![](https://www.google.com/s2/favicons?domain=https://developers.google.com&sz=128)Google for Developers](https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls?utm_source=chatgpt.com)

### Bewertung

**Schweregrad: kritisch für SEO**

### Korrekte Form

```PHP
$pageCanonical = $site['base_url'] . '/' . $subject['file'];
```

Für die Startseite:

```PHP
$pageCanonical = $site['base_url'] . '/';
```

Alle folgenden Elemente müssen dieselbe URL-Logik verwenden:

* Canonical
* Open Graph URL
* JSON-LD
* Breadcrumbs
* interne Links
* XML-Sitemap
* HTML-Sitemap
* Service Worker
* Manifest

* * *

## 2.3 Das Kontaktformular besitzt einen fehlerhaften Speicherpfad

In `kontakt-senden.php` steht:

```PHP
__DIR__ . '/nh_hor/storage/contact-events.log'
```

`__DIR__` verweist bereits auf das Stammverzeichnis der Website. Dadurch wird effektiv versucht, hier zu speichern:

```
.../nh_hor/nh_hor/storage/contact-events.log
```

Der Fehler wird durch `@file_put_contents()` verborgen. Das Formular kann daher scheinbar erfolgreich reagieren, obwohl das Ereignisprotokoll nicht geschrieben wurde.

### Bewertung

**Schweregrad: hoch**

### Korrektur

```PHP
__DIR__ . '/storage/contact-events.log'
```

Außerdem sollte der Fehler nicht vollständig unterdrückt werden. Sinnvoll wäre ein kontrolliertes internes Logging.

* * *

## 2.4 Impressum und Preisangaben sind nicht veröffentlichungsfähig

Im Impressum stehen ausdrücklich noch:

* `[vollständige ladungsfähige Anschrift]`
* `[Telefonnummer]`
* `[E-Mail-Adresse]`
* offene steuerliche Angaben
* offene Angaben zur Verantwortlichkeit
* ungeklärte Verbraucherstreitbeilegung

Die Seite enthält sogar den Hinweis:

> Nicht unverändert veröffentlichen.

Auch `preise.php` enthält noch keine verbindlichen Preise.

In `config/site.php` steht:

```PHP
'phone' => '+49 000 0000000'
```

### Bewertung

**Schweregrad: Veröffentlichungssperre**

Vor dem Livegang müssen mindestens ergänzt beziehungsweise geprüft werden:

* ladungsfähige Anschrift
* echte Telefonnummer
* gültige E-Mail-Adresse
* Unternehmens- beziehungsweise Anbieterbezeichnung
* steuerlicher Status
* Angaben nach DDG
* Datenschutzinformationen
* tatsächliche Verarbeitungswege des Kontaktformulars
* Hostinganbieter
* Löschfristen
* Cookie- und Analysekonzept
* konkrete Preise beziehungsweise transparente Preisermittlung

Eine abschließende rechtliche Prüfung kann eine technische Analyse nicht ersetzen.

* * *

# 3. SEO-Analyse

## 3.1 Positive SEO-Grundlage

Die Website besitzt bereits viele sinnvolle Elemente:

* individuelle Seitentitel
* individuelle Meta-Descriptions
* semantische Überschriften
* Breadcrumbs
* interne Verlinkung
* lokale Fachseiten
* Stadtteilseiten
* Schulformseiten
* strukturierte Daten
* FAQ-Inhalte
* Blogvorbereitung
* XML-Sitemap
* HTML-Sitemap
* robots.txt
* Open-Graph-Metadaten
* sprechende Dateinamen

Die fachliche Seitenstruktur ist grundsätzlich stark:

```
Startseite
├── Fächer
│   ├── Mathematik
│   ├── Physik
│   ├── Chemie
│   └── Informatik
├── Schulformen
├── Stadtteile
├── Methodik
├── Warum easyIT
├── Über mich
├── Bewertungen
├── Lernwerkzeuge
└── Blog
```

Google empfiehlt klar strukturierte, crawlbare Links, aussagekräftige Titel und Inhalte, die den tatsächlichen Suchbegriffen der Nutzer entsprechen. [![](https://www.google.com/s2/favicons?domain=https://developers.google.com&sz=128)Google for Developers+1](https://developers.google.com/search/docs/essentials?utm_source=chatgpt.com)

## 3.2 Risiko der Stadtteilseiten

Es existieren elf Stadtteilseiten, die alle dasselbe Template verwenden. Die Konfigurationsinhalte unterscheiden sich zwar, der überwiegende Seitenaufbau bleibt jedoch identisch.

Das ist nicht automatisch problematisch. Es wird aber kritisch, wenn die Seiten nur regionale Suchbegriffe austauschen und alle zum gleichen Angebot führen.

Google bezeichnet regionale, stark ähnliche Seiten, die Besucher lediglich zu derselben Leistung weiterleiten, als mögliches „Doorway Abuse“. [![](https://www.google.com/s2/favicons?domain=https://developers.google.com&sz=128)Google for Developers](https://developers.google.com/search/docs/essentials/spam-policies?utm_source=chatgpt.com)

### Aktueller Zustand

Die Stadtteilseiten besitzen bereits individuelle:

* Einleitungen
* Schwerpunkte
* Nutzenargumente
* Meta-Titel
* Beschreibungen

Das ist positiv. Die lokale Substanz reicht jedoch noch nicht vollständig aus.

### Jede Stadtteilseite sollte zusätzlich besitzen

* konkrete Erreichbarkeit oder Unterrichtsform
* tatsächliche lokale Besonderheiten
* relevante Schulen oder Bildungswege, ohne bloße Keywordlisten
* Anfahrt oder ÖPNV-Bezug, sofern zutreffend
* individuelle häufige Fragen
* ortsspezifische Unterrichtsorganisation
* echte Beispiele oder Erfahrungen
* nachvollziehbare Aussage, weshalb eine eigene Seite nützlich ist

Google empfiehlt „people-first content“, das echte Erfahrung, Tiefe und eigenständigen Nutzen bietet, statt primär für Suchmaschinen erzeugt zu sein. [![](https://www.google.com/s2/favicons?domain=https://developers.google.com&sz=128)Google for Developers+1](https://developers.google.com/search/docs/fundamentals/creating-helpful-content?utm_source=chatgpt.com)

## 3.3 Falsche und widersprüchliche Sitemap

Die Sitemap enthält derzeit drei unterschiedliche URL-Logiken:

```
https://easyit-leipzig.de/
https://easyit-leipzig.de/mathe-nachhilfe-leipzig.php
https://easyit-leipzig.de/nh_hor/tutor-bewertungen.php?... 
```

Zusätzlich wird `offline.php` in der Sitemap genannt, aber in `robots.txt` gesperrt.

Das ist widersprüchlich:

```
Sitemap: offline.php
robots.txt: Disallow: /offline.php
```

Die Offline-Seite sollte normalerweise:

* nicht indexiert werden,
* nicht in der Sitemap erscheinen,
* gegebenenfalls `noindex` erhalten.

Google weist darauf hin, dass eine Sitemap nur die kanonischen URLs enthalten sollte, die tatsächlich indexiert werden sollen. [![](https://www.google.com/s2/favicons?domain=https://developers.google.com&sz=128)Google for Developers](https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap?utm_source=chatgpt.com)

## 3.4 robots.txt ist keine Sicherheitsmaßnahme

Die Datei sperrt unter anderem:

* `/config/`
* `/database/`
* `/admin/`
* `/storage/`

Das ist als Crawlingsteuerung sinnvoll, ersetzt aber keine serverseitige Zugriffssperre. Google weist ausdrücklich darauf hin, dass `robots.txt` nicht dazu dient, vertrauliche Inhalte zu schützen oder zuverlässig aus dem Index zu halten. [![](https://www.google.com/s2/favicons?domain=https://developers.google.com&sz=128)Google for Developers](https://developers.google.com/search/docs/crawling-indexing/robots/intro?utm_source=chatgpt.com)

Positiv ist, dass die `.htaccess` zusätzlich Verzeichnisse sperrt. Diese Regeln müssen jedoch auf dem tatsächlichen Hosting getestet werden.

## 3.5 Strukturierte Daten

Die Grundidee ist gut. Verwendet werden unter anderem:

* `EducationalOrganization`
* `LocalBusiness`
* `Service`
* `BreadcrumbList`
* `FAQPage`
* `WebApplication`
* `BlogPosting`

Google kann Organisation- und LocalBusiness-Daten verwenden, um Unternehmen, Logo, Kontaktdaten und lokale Eigenschaften besser zu verstehen. [![](https://www.google.com/s2/favicons?domain=https://developers.google.com&sz=128)Google for Developers+1](https://developers.google.com/search/docs/appearance/structured-data/local-business?utm_source=chatgpt.com)

Problematisch sind jedoch:

* ungültige Telefonnummer
* unvollständige Anschrift
* teilweise falsche URLs
* fehlendes echtes Logo-Fallback
* fehlende eindeutige Identifikatoren
* möglicherweise nicht vollständig sichtbare CMS-Inhalte
* Open-Graph-Bild als SVG

### Ergänzt werden sollten

```JSON
{
  "@type": "LocalBusiness",
  "name": "easyIT Nachhilfe Leipzig",
  "url": "https://easyit-leipzig.de/",
  "logo": "https://easyit-leipzig.de/assets/img/logo.png",
  "image": "https://easyit-leipzig.de/assets/img/og-easyit.jpg",
  "telephone": "...",
  "email": "...",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "...",
    "postalCode": "...",
    "addressLocality": "Leipzig",
    "addressCountry": "DE"
  }
}
```

Strukturierte Daten müssen mit dem sichtbaren Inhalt übereinstimmen und dürfen keine nur technisch eingetragenen, aber tatsächlich nicht zutreffenden Aussagen enthalten. [![](https://www.google.com/s2/favicons?domain=https://developers.google.com&sz=128)Google for Developers](https://developers.google.com/search/docs/appearance/structured-data/sd-policies?utm_source=chatgpt.com)

* * *

# 4. Inhaltliche Analyse

## 4.1 Die stärkste Positionierung ist bereits vorhanden

Der beste inhaltliche Kern der Website lautet:

> Verstehen statt auswendig lernen.

Dieser Satz passt sehr gut zu:

* Ihrer Unterrichtsmethodik
* Ihrer fachübergreifenden Kompetenz
* dem Prinzip des bildhaften Erkennens
* der Fragenmethode
* dem schriftlichen Lösungsweg
* dem Übergang von Unterstützung zu Selbstständigkeit
* der Regel „Tafelwerk → Recherche → Tutor“

Die Website sollte diese Differenzierung noch stärker zur zentralen Markenbotschaft machen.

Derzeit liest sich ein Teil der Startseite noch wie eine gute, aber austauschbare Nachhilfewebsite:

* individuell
* strukturiert
* persönlich
* gezielt
* verständlich

Diese Aussagen sind richtig, werden aber von sehr vielen Wettbewerbern verwendet.

## 4.2 Das eigentliche Alleinstellungsmerkmal ist noch nicht sichtbar genug

Ihre tatsächlichen Unterschiede sind konkreter:

* Mathematik, Physik, Chemie und Informatik aus einer Hand
* Zusammenhänge zwischen den Fächern
* technische und ingenieurwissenschaftliche Denkweise
* Lernende sollen Lösungswege selbst erkennen
* Recherche ist ausdrücklich Bestandteil des Lernens
* Unwissen darf offen benannt werden
* Erklärungen werden bildhaft und systematisch aufgebaut
* Lösungsblätter bleiben als Arbeitsgrundlage erhalten
* Fortschritt wird nicht nur an Noten gemessen
* Unterricht auf Augenhöhe
* fachliche Breite bis Ausbildung und Studium

Diese Punkte sollten auf der Startseite nicht erst über Unterseiten erschlossen werden.

## 4.3 Empfohlene neue Startseitenlogik

1. **Hauptversprechen**  
    Verstehen statt auswendig lernen.
2. **Für wen?**  
    Schüler, Auszubildende und Studierende.
3. **Was ist anders?**  
    Zusammenhänge erkennen, statt Aufgaben nur vorzurechnen.
4. **Wie funktioniert es?**  
    Standort bestimmen → Ursache erkennen → Lösungsweg aufbauen → übertragen → selbst kontrollieren.
5. **Wer unterrichtet?**  
    Konkretes Tutorprofil mit Fächern, Erfahrung und persönlicher Haltung.
6. **Nachweise**  
    Echte Bewertungen und konkrete Lernerfolge.
7. **Organisation**  
    Ort, online/präsent, Dauer, Verfügbarkeit, Preise.
8. **Kontakt**  
    Niedrigschwellige Anfrage.

## 4.4 Sprachliche Konsistenz

Die Website wechselt zwischen:

* „du“
* „Schülerinnen und Schüler“
* „Lernende“
* „Eltern und Lernende“
* sachlicher Distanz

Das ist nicht grundsätzlich falsch, sollte aber strategisch entschieden werden.

Empfehlung:

* Haupttexte: direkte, respektvolle Du-Ansprache
* Elterninformationen: neutrale oder explizit an Eltern gerichtete Form
* rechtliche Seiten: sachlich
* Studium und Erwachsene: nicht zu schulisch formulieren

* * *

# 5. UX- und Designanalyse

## 5.1 Gute Grundlagen

Positiv sind:

* deutlich erkennbarer Hero-Bereich
* klare Handlungsaufforderungen
* Kartenlogik
* Fächernavigation
* Breadcrumbs
* responsive CSS-Dateien
* semantische Bereiche
* `<details>` für FAQs
* Lazy Loading bei vielen Bildern
* Bildgrößen sind überwiegend angegeben
* Skip-Ziel über `id="hauptinhalt"` vorbereitet
* horizontales Hauptmenü
* Mobilmenü-Logik
* Sidebar als Schnellnavigation

## 5.2 Zu viele parallele Navigationsebenen

Die Website besitzt gleichzeitig:

* Kopfbereich
* horizontales Hauptmenü
* Dropdownmenüs
* Suchfeld
* Seitenleiste
* Breadcrumbs
* zahlreiche Kartenlinks
* Footer-Navigation

Auf einem großen Bildschirm kann dies funktionieren. Auf kleineren Geräten besteht aber die Gefahr, dass die Navigation mehr Aufmerksamkeit erhält als der eigentliche Inhalt.

### Empfehlung

Die Sidebar sollte auf Unterseiten reduziert werden oder nur kontextbezogene Ziele enthalten.

Beispielsweise:

* Startseite: Fach-Schnellzugriff
* Fachseiten: Themen und verwandte Fächer
* Stadtteilseiten: Orte und Kontakt
* Blogseiten: Kategorien und neueste Beiträge

Eine überall identische Sidebar mit allgemeinen Links kann schnell redundant wirken.

## 5.3 Kontakt und Vertrauen

Für eine lokale Nachhilfewebsite fehlen oberhalb des ersten langen Scrollbereichs noch wichtige Vertrauenssignale:

* echtes Foto oder authentische Illustration des Tutors
* Name
* Qualifikation
* Unterrichtsort
* präsent/online
* Reaktionszeit
* Telefonnummer
* echte Bewertung
* transparente Preisorientierung

Der aktuelle Hero erklärt gut, **was** angeboten wird, aber noch nicht ausreichend, **warum gerade dieser Anbieter vertrauenswürdig ist**.

* * *

# 6. Barrierefreiheit

## Positive Punkte

* `lang="de"`
* Alternativtexte bei Bildern
* semantische Überschriften
* sichtbare Linktexte
* Breadcrumb-ARIA
* Navigationselemente
* Formularlabels
* FAQ über native `<details>`
* keine erkennbare Abhängigkeit von jQuery
* responsive Grundstruktur

## Noch zu prüfen oder zu verbessern

### 6.1 Skip-Link

Das Ziel `id="hauptinhalt"` existiert. Es muss kontrolliert werden, ob im Header tatsächlich ein sichtbarer beziehungsweise bei Fokus sichtbarer Skip-Link vorhanden ist.

### 6.2 Tastaturnavigation der Dropdowns

Dropdowns dürfen nicht ausschließlich auf Hover reagieren. Geprüft werden müssen:

* Tab-Reihenfolge
* Escape-Taste
* Pfeiltasten
* Fokus bleibt sichtbar
* Menü schließt kontrolliert
* `aria-expanded`
* `aria-controls`

WCAG 2.2 verlangt unter anderem, dass fokussierte Elemente nicht durch feststehende Bereiche verdeckt werden. [![](https://www.google.com/s2/favicons?domain=https://www.w3.org&sz=128)W3C](https://www.w3.org/WAI/WCAG22/Understanding/focus-not-obscured-minimum.html?utm_source=chatgpt.com)

### 6.3 Kontrast

Die tatsächlichen Farbkontraste konnten ohne gerenderte Browserprüfung nicht abschließend bewertet werden. Für normalen Text gilt im Regelfall mindestens ein Verhältnis von 4,5:1. [![](https://www.google.com/s2/favicons?domain=https://www.w3.org&sz=128)W3C](https://www.w3.org/WAI/WCAG22/Understanding/contrast-minimum.html?utm_source=chatgpt.com)

Besonders zu prüfen sind:

* Gold auf Weiß
* helle Texte auf Leipzig-Blau
* graue Beschreibungen
* Placeholder-Texte
* Hover- und Fokuszustände
* Footerlinks
* deaktivierte Elemente

### 6.4 Formulare

Formulare brauchen zusätzlich:

* verständliche Inline-Fehler
* Verknüpfung über `aria-describedby`
* Fokus auf die Fehlerzusammenfassung
* Markierung erforderlicher Felder
* keine ausschließliche Farbcodierung
* Autocomplete-Attribute

W3C empfiehlt klar zugeordnete Labels, verständliches Feedback und konsistente Navigation. [![](https://www.google.com/s2/favicons?domain=https://www.w3.org&sz=128)W3C](https://www.w3.org/WAI/tips/designing/?utm_source=chatgpt.com)

* * *

# 7. Sicherheitsanalyse

## 7.1 Bereits gut umgesetzt

Die Sicherheitsbasis ist erfreulich solide:

* `declare(strict_types=1)`
* PDO und Prepared Statements
* Passwort-Hashing über `password_hash()`
* Prüfung über `password_verify()`
* Session-ID-Regeneration nach Login
* `HttpOnly`-Cookie
* `SameSite=Lax`
* Secure-Cookie bei HTTPS
* strikter Sessionmodus
* CSRF-Funktionen
* CSRF-Prüfung beim Kontaktformular
* Honeypot-Feld
* Eingabelängen
* E-Mail-Validierung
* Output-Escaping über `e()`
* Sicherheitsheader
* Verzeichnisschutz
* kein Directory Listing

Prepared Statements gehören zu den zentralen Schutzmaßnahmen gegen SQL-Injection. [![](https://www.google.com/s2/favicons?domain=https://cheatsheetseries.owasp.org&sz=128)cheatsheetseries.owasp.org](https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html?utm_source=chatgpt.com)

CSRF-Tokens sind insbesondere bei zustandsverändernden Aktionen notwendig. [![](https://www.google.com/s2/favicons?domain=https://cheatsheetseries.owasp.org&sz=128)cheatsheetseries.owasp.org+1](https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html?utm_source=chatgpt.com)

## 7.2 Noch vorhandene Sicherheitsrisiken

### Adminpfade

Die falschen Admin-Weiterleitungen können Authentifizierung und Logout faktisch beschädigen.

### Rate Limiting nur über Session

```PHP
$_SESSION['contact_last_submit']
```

Das lässt sich leicht umgehen:

* neuer Browser
* gelöschtes Cookie
* parallele Sessions
* automatisierte Anfragen ohne persistente Sitzung

Für ein öffentliches Formular sollte die Begrenzung zusätzlich serverseitig erfolgen, beispielsweise über:

* IP-Hash
* Datenbank
* Cache
* Zeitfenster
* wiederholte Inhaltsmuster

### Keine erkennbare Login-Sperre

Beim Adminlogin sollte geprüft beziehungsweise ergänzt werden:

* fehlgeschlagene Loginversuche
* Verzögerung
* zeitweise Sperre
* Protokollierung
* Benachrichtigung bei auffälligen Zugriffen

### Session-Fingerprint

Die Funktion `client_fingerprint()` wird nur beim Kontaktlogging genutzt. Eine Bindung der Adminsitzung an User-Agent oder andere stabile Merkmale ist nicht erkennbar.

### Content Security Policy

Es existiert noch keine `Content-Security-Policy`.

Empfohlener Ausgangspunkt:

```apache
Content-Security-Policy:
default-src 'self';
img-src 'self' data:;
style-src 'self';
script-src 'self';
font-src 'self';
form-action 'self';
frame-ancestors 'self';
base-uri 'self';
```

Dies muss wegen eventuell vorhandener Inline-Ausgaben und JSON-LD gezielt getestet werden.

### Standard-Datenbankkennwort

```PHP
'password' => 'CHANGE_ME'
```

Das ist als Vorlage akzeptabel, sollte aber niemals in der produktiven Konfiguration verbleiben. Besser wäre:

* `.env`
* Serverumgebungsvariablen
* Konfigurationsdatei außerhalb des Webroots

* * *

# 8. Performance und Core Web Vitals

## Positive Punkte

* lokale Assets
* keine großen externen Frameworks
* kein jQuery
* SVG-Bilder
* `loading="lazy"`
* Breiten- und Höhenangaben
* CSS-Aufteilung
* Deflate
* Expires-Header
* Cache-Control
* Service Worker

Die aktuellen Core Web Vitals sind:

* LCP für Ladeleistung
* INP für Reaktionsfähigkeit
* CLS für visuelle Stabilität. [![](https://www.google.com/s2/favicons?domain=https://web.dev&sz=128)web.dev+1](https://web.dev/articles/vitals?utm_source=chatgpt.com)

Als guter LCP-Zielwert gelten 2,5 Sekunden oder weniger am 75. Perzentil. [![](https://www.google.com/s2/favicons?domain=https://web.dev&sz=128)web.dev](https://web.dev/articles/vitals?utm_source=chatgpt.com)

## Problemstellen

### 8.1 Fünf CSS-Dateien je Seite

Geladen werden:

* `main.css`
* `header.css`
* `sidebar.css`
* `content.css`
* `footer.css`

Bei HTTP/2 ist das nicht dramatisch. Trotzdem sollte geprüft werden, ob:

* viele Regeln doppelt sind,
* nicht benötigte Seitentypen global geladen werden,
* CSS minimiert werden kann.

### 8.2 Unnötiges Preload

```HTML
<link rel="preload" href="/nh_hor/assets/css/main.css" as="style">
<link rel="stylesheet" href="/nh_hor/assets/css/main.css">
```

Das bringt nur dann einen Vorteil, wenn es korrekt in die Ladepriorisierung eingebunden ist. Andernfalls kann es redundant sein.

### 8.3 Service Worker ist nicht installationsneutral

Der Cache enthält gleichzeitig:

```JavaScript
'/'
```

und:

```JavaScript
'/nh_hor/...'
```

Die produktive Domain-Sitemap verwendet hingegen überwiegend Pfade ohne `/nh_hor/`.

Dadurch kann der Service Worker:

* falsche Ressourcen cachen,
* bei Installation scheitern,
* alte Versionen ausliefern,
* beim Domainumzug unbrauchbar werden.

### 8.4 Cache-Strategie

Aktuell wird für alle GET-Anfragen „network first“ verwendet und jede erfolgreiche Antwort gecacht:

```JavaScript
cache.put(event.request, clone)
```

Damit können auch dynamische Seiten, Query-URLs oder ungeeignete Antworten gespeichert werden.

Besser:

* HTML: Network First
* CSS/JS/Fonts: Stale While Revalidate
* Bilder: Cache First
* Admin: niemals cachen
* Kontakt und personalisierte Seiten: niemals cachen
* nur erfolgreiche `200`-Antworten aus derselben Origin speichern

* * *

# 9. CMS- und Datenbankarchitektur

## Positive Punkte

Die CMS-Struktur ist für ein individuelles PHP-Projekt bemerkenswert umfangreich:

* Adminbenutzer
* Inhaltsarten
* Inhaltsstatus
* Revisionssystem
* Auditvorbereitung
* Cache
* Migrationen
* Tutorentitäten
* Bewertungen
* Metadaten
* Canonical- und Open-Graph-Felder
* Fallback-Inhalte bei nicht verfügbarer Datenbank

Das ist eine gute Grundlage für langfristige Pflege.

## Probleme

### 9.1 Mehrere konkurrierende SQL-Stände

Vorhanden sind unter anderem:

* `config/easyit.sql`
* `database/schema.sql`
* `database/schema_myisam.sql`
* `menu_horizontal_myisam.sql`
* Gesamtdump
* Migrationsdateien
* ZIP eines SQL-Stands

Dadurch ist nicht eindeutig:

> Welche Datei ist die verbindliche Quelle für eine Neuinstallation?

Außerdem enthält `config/easyit.sql` weiterhin zahlreiche `/nh_seo/`-URLs.

### Empfehlung

Ein einziges verbindliches Modell:

```
database/
├── schema.sql
├── migrations/
├── seeds/
│   ├── navigation.sql
│   └── initial-content.sql
└── backups/
```

Dabei sollte gelten:

1. `schema.sql` = aktuelles Basisschema
2. Migrationen = alle Änderungen ab Basisschema
3. Seeds = optionale Startdaten
4. Backups = nicht Teil der Installation

MyISAM sollte nicht parallel als gleichwertiger Hauptstand geführt werden, sofern keine zwingende Hostinganforderung besteht.

* * *

# 10. Fehler- und Qualitätsliste nach Priorität

## Priorität 0 – Veröffentlichung verhindern

1. Impressum vervollständigen
2. Datenschutzerklärung anhand des tatsächlichen Betriebs prüfen
3. Telefonnummer und Kontaktdaten ersetzen
4. Preise oder transparente Preislogik ergänzen
5. sämtliche `/nh_seo/`-Reste entfernen
6. zentrale URL-/Basispfadlogik einführen
7. falsche Canonicals korrigieren
8. Adminweiterleitungen korrigieren
9. Kontaktformularpfade korrigieren
10. Sitemap konsistent neu generieren

## Priorität 1 – technisch sehr wichtig

11. interne Root-Links wie `href="/datei.php"` korrigieren
12. Fehlerseiten auf korrekte Startseite führen
13. Service Worker auf produktive URL-Struktur umstellen
14. Offline-Seite aus Sitemap entfernen und `noindex` setzen
15. Datenbankkonfiguration aus dem Webprojekt auslagern
16. Login-Rate-Limit ergänzen
17. serverseitiges Kontakt-Rate-Limit ergänzen
18. CSP vorbereiten
19. Adminbereich vollständig auf CSRF-Schutz prüfen
20. alte SQL-Navigationsdaten migrieren

## Priorität 2 – SEO und Inhalte

21. Stadtteilseiten mit echter lokaler Substanz erweitern
22. Alleinstellungsmerkmal stärker auf der Startseite darstellen
23. Tutorprofil oberhalb des ersten Scrollendes sichtbar machen
24. echte Bewertungen veröffentlichen
25. Blogbeiträge aus Markdown tatsächlich zugänglich machen
26. Organisation- und LocalBusiness-Schema vervollständigen
27. echtes JPG/WebP-Open-Graph-Bild ergänzen
28. Breadcrumb- und Canonical-URLs vereinheitlichen
29. Sitemap automatisch aus Konfiguration beziehungsweise Datenbank erzeugen
30. fachliche Autorität durch persönliche Erfahrung und konkrete Beispiele zeigen

## Priorität 3 – UX, Barrierefreiheit und Performance

31. Tastaturbedienung der Menüs testen
32. Fokusdarstellung prüfen
33. Kontraste messen
34. Kontaktformularfehler barrierefrei ausgeben
35. Sidebar je Seitentyp reduzieren
36. Navigation mobil praktisch testen
37. CSS-Dopplungen bereinigen
38. Service-Worker-Cache nach Ressourcentyp trennen
39. Lighthouse und PageSpeed nach Deployment durchführen
40. Tests mit 320, 375, 768, 1024 und 1440 Pixel Breite durchführen

* * *

# 11. Bewertung nach Bereichen

| Bereich | Bewertung | Kommentar |
| --- | --- | --- |
| Informationsarchitektur | 8/10 | Umfangreich und sinnvoll gegliedert |
| Inhaltliche Positionierung | 6/10 | Gute Basis, Alleinstellungsmerkmal noch zu wenig sichtbar |
| Gestaltungssystem | 7/10 | Klarer Aufbau, tatsächliche Browserprüfung noch nötig |
| Mobile Konzeption | 6/10 | vorbereitet, aber Navigation vermutlich noch zu komplex |
| Technische Architektur | 7/10 | gute Modularisierung, Pfadkonzept inkonsistent |
| PHP-Codequalität | 7/10 | strikt typisiert, modular, syntaktisch fehlerfrei |
| Sicherheit | 7/10 | gute Grundlage, Rate Limits und CSP fehlen |
| SEO-Grundlage | 7/10 | viel vorbereitet, Canonicals und URL-System derzeit kritisch |
| Lokale SEO-Inhalte | 6/10 | individuelle Ansätze vorhanden, Doorway-Risiko vermeiden |
| Barrierefreiheit | 6/10 | gute Semantik, praktische WCAG-Prüfung offen |
| Rechtliche Veröffentlichung | 2/10 | Platzhalter verhindern Livegang |
| Wartbarkeit | 6/10 | Konfiguration gut, aber zu viele harte Pfade und SQL-Stände |
| Live-Reife insgesamt | **5/10** | nach Korrektur der Kernprobleme gute Ausgangsbasis |

* * *

# 12. Strategische Schlussfolgerung

Der bisherige Aufbau sollte **nicht verworfen und nicht erneut komplett neu entwickelt** werden.

Die Architektur ist grundsätzlich brauchbar. Die Website braucht jetzt keine weitere Vergrößerung, sondern eine konsequente Konsolidierungsphase.

Die richtige nächste Phase wäre:

## Phase 14 – Technische Konsolidierung und Veröffentlichungsreife

Sie sollte ausschließlich folgende Ziele verfolgen:

1. einheitliches URL- und Pfadsystem
2. vollständige Migration von `nh_seo` nach `nh_hor`
3. korrekte Canonicals und interne Links
4. rechtlich vollständige Pflichtseiten
5. reale Kontaktdaten und Preise
6. geprüfter Kontakt- und Adminworkflow
7. bereinigte Sitemap und strukturierte Daten
8. verbindlicher Datenbankstand
9. echte Inhalte und Vertrauenssignale
10. abschließender Browser-, Mobil-, SEO- und Sicherheitstest

**Mein wesentliches Urteil lautet:**  
Die Website besitzt bereits eine gute technische und inhaltliche Grundlage. Ihr größtes Risiko ist derzeit nicht mangelnder Inhalt, sondern dass alte und neue Installationslogiken gleichzeitig im Projekt vorhanden sind. Sobald das Pfadsystem, die Canonicals und die rechtlichen Inhalte bereinigt sind, kann aus dem Stand eine überzeugende lokale Nachhilfewebsite entstehen.