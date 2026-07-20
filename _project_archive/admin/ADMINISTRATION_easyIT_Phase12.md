# easyIT-Nachhilfe Leipzig – Administrationshandbuch

**Projektstand:** Phase 12  
**Lokale Installation:** `https://localhost/nh_hor/`  
**Adminbereich:** `https://localhost/nh_hor/admin/`  
**Datenbank:** `easyit`  
**Dokumentstand:** 17. Juli 2026

---

## 1. Zweck dieses Handbuchs

Dieses Handbuch beschreibt die Bedienung und technische Administration der easyIT-Nachhilfe-Webseite im aktuellen Entwicklungsstand bis einschließlich Phase 12.

Der vorhandene Adminbereich ermöglicht die zentrale Verwaltung folgender datenbankgestützter Inhaltstypen:

- FAQ-Einträge
- Bewertungen
- Stellenangebote beziehungsweise Jobs
- Blogbeiträge

Darüber hinaus beschreibt dieses Handbuch:

- die erstmalige Einrichtung der Datenbank,
- das Anlegen eines Administratorkontos,
- die Anmeldung und Abmeldung,
- das Erstellen, Bearbeiten, Vorschauen, Veröffentlichen und Archivieren von Inhalten,
- die besonderen Felder für Bewertungen,
- die Cache-Leerung,
- Datenbanksicherung und Wiederherstellung,
- Migrationen bei späteren Phasen,
- die wichtigsten Sicherheits- und Wartungsregeln,
- bekannte Grenzen des derzeitigen Adminsystems.

> **Wichtig:** Statische PHP-Seiten, Navigation, Bilder, Unterrichtsregeln, Fächerseiten, Stadtteilseiten und Schulformseiten werden im aktuellen Stand noch nicht über eine eigene Adminmaske gepflegt. Änderungen an diesen Bereichen müssen derzeit direkt in den jeweiligen Projektdateien vorgenommen werden.

---

## 2. Systemvoraussetzungen

Für den lokalen Betrieb werden benötigt:

- XAMPP mit Apache, PHP und MySQL/MariaDB
- aktiviertes PHP-Modul `pdo_mysql`
- ein moderner Webbrowser
- Schreibrechte für den Cache-Ordner, sofern ein Cache-Verzeichnis genutzt wird
- Kommandozeilenzugriff für Migrationen und die Anlage des Administratorkontos

Empfohlene Projektablage:

```text
C:\xampp\htdocs\nh_hor\
```

Lokaler Aufruf der Webseite:

```text
https://localhost/nh_hor/
```

Lokaler Aufruf der Administration:

```text
https://localhost/nh_hor/admin/
```

---

## 3. Relevante Projektstruktur

```text
nh_hor/
├── admin/
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── content.php
│   ├── edit.php
│   ├── delete.php
│   ├── cache-clear.php
│   ├── preview/
│   │   └── content.php
│   └── includes/
│       ├── admin-functions.php
│       ├── auth.php
│       ├── header.php
│       └── footer.php
├── assets/
│   └── css/
│       └── admin.css
├── config/
│   └── database.php
├── database/
│   ├── schema.sql
│   ├── migrate.php
│   ├── create-admin.php
│   └── migrations/
├── includes/
│   ├── database.php
│   ├── security.php
│   ├── content-repository.php
│   ├── migrations.php
│   └── cache.php
├── bewertungen.php
├── faq.php
├── jobs.php
├── blog.php
└── warum-easyit.php
```

---

## 4. Datenbank einrichten

### 4.1 Datenbank und Tabellen importieren

Für eine Neuinstallation kann der vollständige SQL-Dump verwendet werden:

```text
easyit_phase12_gesamtstand.sql
```

Alternativ kann das im Projekt enthaltene Schema importiert werden:

```text
database/schema.sql
```

Import über phpMyAdmin:

1. `https://localhost/phpmyadmin/` aufrufen.
2. Den Menüpunkt **Importieren** öffnen.
3. Die SQL-Datei auswählen.
4. Zeichensatz `utf8mb4` beibehalten.
5. Import starten.
6. Prüfen, ob die Datenbank `easyit` angelegt wurde.

Die wichtigsten Tabellen sind:

| Tabelle | Aufgabe |
|---|---|
| `admin_users` | Administrationskonten |
| `content_items` | Aktuelle FAQ-, Bewertungs-, Job- und Blogeinträge |
| `content_revisions` | Vorherige Fassungen bearbeiteter Inhalte |
| `audit_log` | Protokoll administrativer Aktionen |
| `schema_migrations` | Bereits ausgeführte Datenbankmigrationen, sofern angelegt |

---

### 4.2 Datenbankbenutzer anlegen

Die Datei `config/database.php` erwartet standardmäßig:

```php
return [
    'dsn' => 'mysql:host=localhost;dbname=easyit;charset=utf8mb4',
    'user' => 'easyit_user',
    'password' => 'CHANGE_ME',
];
```

Für eine saubere Installation sollte ein eigener Datenbankbenutzer verwendet werden.

Beispiel in phpMyAdmin oder MySQL:

```sql
CREATE USER IF NOT EXISTS 'easyit_user'@'localhost'
IDENTIFIED BY 'EIN_SEHR_SICHERES_PASSWORT';

GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX, REFERENCES
ON easyit.*
TO 'easyit_user'@'localhost';

FLUSH PRIVILEGES;
```

Anschließend `config/database.php` anpassen:

```php
'user' => 'easyit_user',
'password' => 'EIN_SEHR_SICHERES_PASSWORT',
```

> Die Datei `config/database.php` darf auf einem öffentlich erreichbaren Server niemals herunterladbar oder öffentlich einsehbar sein.

---

## 5. Administratorkonto anlegen

Das Administratorkonto wird aus Sicherheitsgründen über die Kommandozeile angelegt.

### 5.1 XAMPP-Shell verwenden

In der XAMPP-Shell:

```bat
cd C:\xampp\htdocs\nh_hor
php database\create-admin.php BENUTZERNAME EMAIL PASSWORT
```

Beispiel:

```bat
php database\create-admin.php admin admin@example.de "EinSehrSicheresPasswort2026!"
```

Das Passwort muss mindestens zwölf Zeichen lang sein.

Bei Erfolg erscheint:

```text
Admin wurde angelegt.
```

### 5.2 Sicherheitsregeln für das Passwort

Das Passwort sollte:

- mindestens 16 Zeichen lang sein,
- Groß- und Kleinbuchstaben enthalten,
- Zahlen enthalten,
- Sonderzeichen enthalten,
- nicht mit dem E-Mail-, Webseiten- oder Firmennamen übereinstimmen,
- ausschließlich für diese Administration verwendet werden.

---

## 6. Anmeldung

Adminbereich öffnen:

```text
https://localhost/nh_hor/admin/
```

Direkte Anmeldeseite:

```text
https://localhost/nh_hor/admin/login.php
```

Anmeldedaten:

- **Benutzername:** der beim Anlegen gewählte Benutzername
- **Passwort:** das beim Anlegen gewählte Passwort

Nach erfolgreicher Anmeldung wird eine PHP-Sitzung erzeugt. Die Sitzungs-ID wird dabei erneuert, um Session-Fixation zu erschweren.

### 6.1 Anmeldung schlägt fehl

Mögliche Ursachen:

1. Datenbankverbindung ist nicht eingerichtet.
2. Benutzername oder Passwort ist falsch.
3. Das Konto ist in `admin_users.is_active` deaktiviert.
4. Die PHP-Sitzung kann nicht gespeichert werden.
5. Die Pfade der lokalen Unterverzeichnisinstallation sind nicht vollständig auf `/nh_hor/` abgestimmt.

Kontrolle in der Datenbank:

```sql
SELECT id, username, email, role, is_active, last_login_at
FROM admin_users;
```

Ein aktiver Benutzer benötigt:

```text
is_active = 1
```

---

## 7. Dashboard

Nach der Anmeldung öffnet sich das Dashboard.

Das Dashboard zeigt die Anzahl der vorhandenen Einträge für:

- FAQ
- Bewertungen
- Jobs
- Blog

Jede Kachel enthält:

- den Inhaltstyp,
- die Anzahl der vorhandenen Einträge,
- die Schaltfläche **Verwalten**.

Oben befindet sich außerdem die Funktion:

```text
Cache leeren
```

Das Dashboard zeigt derzeit keine Besucherstatistik, keine offenen Kontaktanfragen und keine grafische Auswertung.

---

## 8. Hauptnavigation der Administration

Im angemeldeten Zustand enthält der Adminbereich diese Menüpunkte:

| Menüpunkt | Funktion |
|---|---|
| Dashboard | Übersicht der Inhalte |
| FAQ | FAQ-Einträge verwalten |
| Bewertungen | Bewertungskacheln verwalten |
| Jobs | Stellenangebote verwalten |
| Blog | Blogeinträge verwalten |
| Abmelden | Sitzung beenden |

---

## 9. Grundprinzip der Inhaltsverwaltung

Alle vier Inhaltstypen werden in derselben Tabelle `content_items` gespeichert.

Unterschieden werden sie über `content_type`:

```text
faq
review
job
blog
```

Jeder Eintrag verfügt grundsätzlich über:

- Titel
- Slug
- Kurztext
- Inhalt
- SEO-Titel
- Meta-Beschreibung
- Status
- Sortierwert
- Kennzeichnung „Hervorheben“

Bewertungen besitzen zusätzlich:

- Datum
- Name
- Alter
- Schulform

---

## 10. Inhaltsübersicht verwenden

Über **FAQ**, **Bewertungen**, **Jobs** oder **Blog** wird die jeweilige Inhaltsliste geöffnet.

Die Tabelle zeigt:

- Titel
- Slug
- Status
- Änderungsdatum
- Aktionen

Verfügbare Aktionen:

- **Bearbeiten**
- **Vorschau**
- **Archivieren**

Mit **Neuer Eintrag** wird ein neuer Datensatz des ausgewählten Inhaltstyps angelegt.

---

## 11. Neuen Inhalt anlegen

### 11.1 Allgemeiner Ablauf

1. Gewünschten Inhaltstyp öffnen.
2. **Neuer Eintrag** wählen.
3. Pflichtfelder ausfüllen.
4. Status festlegen.
5. Bei Bedarf Sortierung und Hervorhebung einstellen.
6. **Speichern** wählen.
7. Vorschau prüfen.
8. Erst danach veröffentlichen.

### 11.2 Pflichtfelder

Diese Felder sind technisch erforderlich:

- Titel
- Slug
- Inhalt

Bleibt der Slug leer, wird er automatisch aus dem Titel erzeugt.

Beispiel:

```text
Titel: Mathematik verstehen statt auswendig lernen
Slug: mathematik-verstehen-statt-auswendig-lernen
```

### 11.3 Slug-Regeln

Ein Slug sollte:

- ausschließlich Kleinbuchstaben verwenden,
- Wörter mit Bindestrichen trennen,
- keine Umlaute oder Sonderzeichen enthalten,
- innerhalb desselben Inhaltstyps eindeutig sein,
- nach Veröffentlichung möglichst nicht mehr geändert werden.

Beispiele:

```text
pruefungsangst-ueberwinden
nachhilfe-mathematik-leipzig
erfahrungsbericht-gymnasium
```

Nicht empfohlen:

```text
Mein neuer Artikel!
Artikel 01
prüfung_2026
```

---

## 12. Bedeutung der Eingabefelder

### 12.1 Titel

Der interne und sichtbare Titel des Eintrags.

Empfehlung:

- konkret formulieren,
- keine reinen Schlagwortketten,
- zentrale Aussage an den Anfang setzen.

### 12.2 Kurztext

Eine kurze Zusammenfassung des Inhalts. Je nach Seitendarstellung kann dieser Text als Einleitung oder Vorschautext erscheinen.

Empfohlene Länge:

```text
120 bis 300 Zeichen
```

### 12.3 Inhalt

Der vollständige Haupttext.

Die Ausgabe erfolgt über die Funktion `cms_content_html()`. Vor dem Einfügen komplexer HTML-Strukturen sollte geprüft werden, welche Formatierungen diese Funktion zulässt beziehungsweise wie sie Inhalte umwandelt.

Empfehlungen:

- Absätze klar trennen,
- keine Texte direkt aus Word mit versteckten Formatierungen kopieren,
- keine Skripte oder eingebetteten Formulare einfügen,
- Vorschau vor Veröffentlichung prüfen.

### 12.4 SEO-Titel

Der Suchmaschinentitel des Eintrags.

Empfohlene Länge:

```text
etwa 45 bis 60 Zeichen
```

Beispiel:

```text
Mathe-Nachhilfe in Leipzig | easyIT-Nachhilfe
```

### 12.5 Meta-Beschreibung

Kurze Beschreibung für Suchmaschinenergebnisse.

Empfohlene Länge:

```text
etwa 140 bis 160 Zeichen
```

Die Datenbank erlaubt technisch bis zu 320 Zeichen. Dennoch sollte der wichtigste Inhalt in den ersten etwa 150 Zeichen stehen.

### 12.6 Status

Verfügbare Statuswerte:

| Status | Bedeutung |
|---|---|
| Entwurf | gespeichert, aber nicht öffentlich vorgesehen |
| Veröffentlicht | für die öffentliche Ausgabe freigegeben |
| Archiviert | nicht mehr aktiv, bleibt aber in der Datenbank erhalten |

### 12.7 Sortierung

Ein numerischer Wert zur Reihenfolge von Einträgen.

Empfohlenes Schema:

```text
10, 20, 30, 40 ...
```

Dadurch können später neue Einträge zwischen bestehenden Positionen eingefügt werden.

### 12.8 Hervorheben

Markiert einen Datensatz mit `featured = 1`.

Diese Kennzeichnung kann von der öffentlichen Seitendarstellung genutzt werden, sofern die jeweilige Seite hervorgehobene Inhalte gesondert abfragt oder gestaltet.

---

## 13. FAQ verwalten

FAQ-Einträge werden über folgenden Bereich verwaltet:

```text
Admin → FAQ
```

Empfohlene Feldverwendung:

| Feld | Inhalt |
|---|---|
| Titel | vollständige Frage |
| Slug | kurze technische Bezeichnung |
| Kurztext | optionaler Kurzhinweis |
| Inhalt | vollständige Antwort |
| Sortierung | Reihenfolge in der FAQ |
| Status | Entwurf oder Veröffentlicht |

Beispiel:

```text
Titel:
Wie läuft eine erste Nachhilfestunde ab?

Slug:
erste-nachhilfestunde

Inhalt:
In der ersten Stunde klären wir zunächst den aktuellen Lernstand ...
```

Qualitätsregeln:

- eine Frage pro Eintrag,
- direkte Antwort im ersten Absatz,
- keine unnötigen Wiederholungen,
- sachliche und verständliche Sprache,
- veraltete Antworten archivieren statt sofort zu löschen.

---

## 14. Bewertungen verwalten

Bewertungen werden über folgenden Bereich verwaltet:

```text
Admin → Bewertungen
```

Jede Bewertung besitzt zusätzlich die Felder:

```text
Datum
Name
Alter
Schulform
```

Diese Angaben erscheinen unter dem Bewertungstext in der Bewertungskachel.

### 14.1 Empfohlene Feldverwendung

| Feld | Inhalt |
|---|---|
| Titel | kurze interne Überschrift |
| Kurztext | optional |
| Inhalt | eigentlicher Bewertungstext |
| Datum | Datum der Bewertung |
| Name | Vorname oder anonymisierte Form |
| Alter | Alter zum Zeitpunkt der Bewertung |
| Schulform | z. B. Gymnasium oder Oberschule |
| Sortierung | Reihenfolge der Kacheln |
| Hervorheben | besonders aussagekräftige Bewertung |

Beispiel:

```text
Datum: 15.06.2026
Name: Lisa M.
Alter: 15
Schulform: Gymnasium
```

Öffentliche Darstellung:

```text
15.06.2026 | Lisa M. | 15 Jahre | Gymnasium
```

### 14.2 Datenschutz bei Bewertungen

Vor einer Veröffentlichung sollte eine nachweisbare Zustimmung vorliegen.

Bei Minderjährigen wird empfohlen:

- nur den Vornamen oder Vornamen mit abgekürztem Nachnamen zu verwenden,
- keine Schule, Klasse oder Wohnadresse zu nennen,
- keine Kombination von Angaben zu veröffentlichen, die eine eindeutige Identifikation ermöglicht,
- bei Bedarf die Zustimmung der Erziehungsberechtigten einzuholen.

Nicht veröffentlichen:

- vollständige Namen Minderjähriger ohne ausdrückliche Einwilligung,
- Telefonnummern,
- E-Mail-Adressen,
- konkrete Schulklassen mit eindeutigem Schulnamen,
- Gesundheits- oder Diagnosedaten,
- vertrauliche familiäre Informationen.

### 14.3 Fehlende Metadaten

Sind einzelne Angaben nicht vorhanden, kann das Feld leer bleiben. Die aktuelle Darstellung verwendet dafür gegebenenfalls einen Platzhalter.

Keine Daten erfinden. Ein fehlendes Alter ist besser als eine geschätzte Angabe.

---

## 15. Jobs verwalten

Stellenangebote werden über folgenden Bereich verwaltet:

```text
Admin → Jobs
```

Empfohlene Struktur:

| Feld | Inhalt |
|---|---|
| Titel | genaue Stellenbezeichnung |
| Kurztext | kurze Zusammenfassung |
| Inhalt | Aufgaben, Voraussetzungen und Kontaktweg |
| SEO-Titel | suchmaschinengeeigneter Stellentitel |
| Meta-Beschreibung | kompakte Stellenbeschreibung |
| Status | Entwurf, Veröffentlicht oder Archiviert |

Beispiele für Stellenbezeichnungen:

- Honorarkraft Mathematik
- Honorarkraft Physik
- Honorarkraft Deutsch und Englisch
- Honorarkraft Französisch, Spanisch oder Latein
- Honorarkraft Ethik, Philosophie oder Religion

Ein Stellenangebot sollte enthalten:

1. gesuchtes Fach oder Fachgebiet,
2. Zielgruppen beziehungsweise Klassenstufen,
3. Aufgaben,
4. gewünschte Qualifikation,
5. Art der Zusammenarbeit,
6. Einsatzort,
7. Bewerbungsweg,
8. Datenschutzhinweis.

Nach Besetzung sollte der Eintrag archiviert werden.

---

## 16. Blog verwalten

Blogbeiträge werden über folgenden Bereich verwaltet:

```text
Admin → Blog
```

Empfohlene Arbeitsweise:

1. Beitrag als Entwurf anlegen.
2. Titel und Slug festlegen.
3. Kurztext verfassen.
4. Haupttext schreiben.
5. SEO-Titel und Meta-Beschreibung ergänzen.
6. Vorschau prüfen.
7. Rechtschreibung und Links kontrollieren.
8. Status auf **Veröffentlicht** setzen.

Empfohlene Blogstruktur:

```text
Einleitung
Ausgangsproblem
Erklärung
konkrete Lernhinweise
Zusammenfassung
Handlungsaufforderung
```

Ein Beitrag sollte einen klaren Nutzen besitzen und nicht nur für Suchmaschinen geschrieben sein.

---

## 17. Vorschau verwenden

Zu jedem Eintrag steht die Aktion **Vorschau** zur Verfügung.

Die Vorschau zeigt:

- Inhaltstyp,
- Status,
- Titel,
- Kurztext,
- formatierten Hauptinhalt,
- bei Bewertungen zusätzlich Datum, Name, Alter und Schulform.

Vor jeder Veröffentlichung prüfen:

- vollständiger Text,
- richtige Absatzstruktur,
- korrekte Sonderzeichen,
- keine internen Notizen,
- keine personenbezogenen Daten ohne Freigabe,
- korrekter Status,
- richtige Bewertungsmetadaten,
- keine versehentlich eingefügten HTML- oder Skriptfragmente.

> Die Adminvorschau ist keine vollständig pixelgenaue Vorschau der öffentlichen Seite. Nach Veröffentlichung sollte deshalb zusätzlich die entsprechende öffentliche Seite geprüft werden.

---

## 18. Bestehenden Inhalt bearbeiten

1. Inhaltstyp öffnen.
2. Beim gewünschten Eintrag **Bearbeiten** auswählen.
3. Änderungen vornehmen.
4. **Speichern** wählen.
5. Vorschau kontrollieren.
6. Öffentliche Seite prüfen.

Bei einer Bearbeitung wird die vorherige Fassung automatisch in `content_revisions` gespeichert.

Gespeichert werden unter anderem:

- Titel,
- Kurztext,
- Inhalt,
- SEO-Titel,
- Meta-Beschreibung,
- Bewertungsdaten,
- Status,
- bearbeitender Benutzer,
- Zeitpunkt.

### 18.1 Aktuelle Grenze der Revisionen

Die Datenbank speichert vorherige Fassungen. Im derzeitigen Adminbereich existiert jedoch noch keine sichtbare Oberfläche zum:

- Anzeigen der Revisionsliste,
- Vergleichen zweier Fassungen,
- Wiederherstellen einer älteren Fassung.

Eine Wiederherstellung muss aktuell direkt über die Datenbank oder durch eine spätere Erweiterung erfolgen.

---

## 19. Inhalte archivieren

Die Aktion **Archivieren** setzt den Status des Eintrags auf:

```text
archived
```

Der Datensatz wird nicht physisch gelöscht.

Vorteile:

- Inhalt bleibt nachvollziehbar,
- Beziehungen und Protokolle bleiben erhalten,
- versehentlich archivierte Inhalte können wieder bearbeitet und veröffentlicht werden.

### 19.1 Archivierung rückgängig machen

1. Den archivierten Eintrag in der Inhaltsliste suchen.
2. **Bearbeiten** öffnen.
3. Status auf **Entwurf** oder **Veröffentlicht** ändern.
4. Speichern.

> Die aktuelle Archivierungsaktion wird über einen Link ausgelöst. Vor administrativen Änderungen sollte deshalb immer ein Datenbankbackup vorhanden sein.

---

## 20. Cache leeren

Im Dashboard befindet sich die Schaltfläche:

```text
Cache leeren
```

Sie löscht die serverseitigen Cache-Dateien über `cache_clear_all()`.

Das ist sinnvoll nach:

- Veröffentlichung eines Inhalts,
- Änderung eines bestehenden Inhalts,
- Datenbankmigration,
- Update einer Phase,
- Änderung an Templates oder Seitenausgabe,
- unerwartet alten Inhalten auf der Webseite.

Nach dem Leeren erscheint im Dashboard die Anzahl der entfernten Cache-Dateien.

### 20.1 Browser- und Service-Worker-Cache

Der Admin-Cache ist nicht identisch mit dem Browser- oder Service-Worker-Cache.

Falls weiterhin alte Inhalte erscheinen:

1. `Strg + F5` drücken.
2. Browser-Entwicklertools öffnen.
3. Unter **Application** beziehungsweise **Anwendung** den Service Worker entfernen.
4. Cache Storage leeren.
5. Seite neu laden.

---

## 21. Abmelden

Nach Abschluss der Arbeit immer **Abmelden** auswählen.

Dadurch wird die Admin-Sitzung aus der Session entfernt und die Sitzungs-ID erneuert.

Besonders wichtig bei:

- gemeinsam genutzten Rechnern,
- Schul- oder Büroräumen,
- mobilen Geräten,
- Wartungszugängen durch Dritte.

Das reine Schließen des Browserfensters ersetzt die Abmeldung nicht zuverlässig.

---

## 22. Audit-Protokoll

Administrative Aktionen werden in `audit_log` gespeichert.

Protokolliert werden unter anderem:

- Benutzer-ID,
- Aktion,
- Inhaltstyp,
- Datensatz-ID,
- Zusatzinformationen als JSON,
- Hash der IP-Adresse,
- Zeitpunkt.

Typische Aktionen:

```text
create
update
archive
cache_clear
```

Beispielabfrage:

```sql
SELECT
    a.id,
    u.username,
    a.action,
    a.entity_type,
    a.entity_id,
    a.details,
    a.created_at
FROM audit_log a
LEFT JOIN admin_users u ON u.id = a.user_id
ORDER BY a.created_at DESC;
```

Im aktuellen Adminbereich gibt es noch keine sichtbare Audit-Log-Seite. Die Kontrolle erfolgt derzeit über phpMyAdmin oder ein Datenbankwerkzeug.

---

## 23. Benutzer und Rollen

Die Datenbank kennt derzeit die Rollen:

```text
admin
editor
```

Der aktuelle Adminbereich prüft vor allem, ob ein Benutzer angemeldet ist. Eine feingranulare Rechteprüfung zwischen `admin` und `editor` ist im aktuellen Stand noch nicht vollständig umgesetzt.

Daher gilt:

- Nur vertrauenswürdige Personen erhalten ein Konto.
- Redaktionskonten sollten erst genutzt werden, wenn die Rechteprüfung erweitert wurde.
- Nicht mehr benötigte Konten werden deaktiviert.

Benutzer deaktivieren:

```sql
UPDATE admin_users
SET is_active = 0
WHERE username = 'BENUTZERNAME';
```

Benutzer reaktivieren:

```sql
UPDATE admin_users
SET is_active = 1
WHERE username = 'BENUTZERNAME';
```

### 23.1 Passwort ändern

Eine sichtbare Passwortänderungsfunktion existiert derzeit nicht.

Ein neues Passwort kann mit PHP erzeugt und anschließend in der Datenbank gesetzt werden. Sicherer ist eine spätere eigene Passwort-zurücksetzen-Funktion.

Beispiel zur Erzeugung eines Hashes:

```bat
php -r "echo password_hash('NEUES_SICHERES_PASSWORT', PASSWORD_DEFAULT), PHP_EOL;"
```

Dann in phpMyAdmin:

```sql
UPDATE admin_users
SET password_hash = 'HIER_DEN_NEUEN_HASH_EINTRAGEN'
WHERE username = 'admin';
```

Niemals ein Klartextpasswort in `password_hash` speichern.

---

## 24. Datenbankmigrationen ausführen

Nach Phasen mit Schemaänderungen müssen Migrationen ausgeführt werden.

In der XAMPP-Shell:

```bat
cd C:\xampp\htdocs\nh_hor
php database\migrate.php
```

Mögliche Ausgabe:

```text
Ausgeführt: 20260717_002_review_metadata.sql
```

oder:

```text
Keine neuen Migrationen.
```

### 24.1 Vor jeder Migration

1. Datenbank sichern.
2. Projektdateien sichern.
3. Wartungszeit wählen.
4. Migration ausführen.
5. Fehlermeldungen vollständig dokumentieren.
6. Admin-Anmeldung testen.
7. Bestehende Inhalte prüfen.
8. Cache leeren.

Migrationen niemals mehrfach manuell ausführen, wenn nicht sichergestellt ist, dass sie idempotent sind.

---

## 25. Datenbank sichern

### 25.1 Sicherung mit phpMyAdmin

1. phpMyAdmin öffnen.
2. Datenbank `easyit` auswählen.
3. **Exportieren** öffnen.
4. Exportmethode **Angepasst** wählen.
5. Alle Tabellen markieren.
6. Format **SQL** wählen.
7. Struktur und Daten exportieren.
8. Option für `DROP TABLE` nur bewusst verwenden.
9. Datei herunterladen.

Empfohlener Dateiname:

```text
easyit_backup_2026-07-17_1200.sql
```

### 25.2 Sicherung mit mysqldump

```bat
C:\xampp\mysql\bin\mysqldump.exe ^
  -u easyit_user -p ^
  --default-character-set=utf8mb4 ^
  --single-transaction ^
  --routines ^
  --triggers ^
  easyit > C:\Backups\easyit_backup_2026-07-17.sql
```

### 25.3 Was muss gesichert werden?

Ein vollständiges Backup besteht aus:

1. Datenbankdump,
2. vollständigem Projektordner,
3. gegebenenfalls hochgeladenen Dateien,
4. Konfigurationsdateien,
5. `.htaccess`,
6. Service Worker und Manifest,
7. Dokumentation und Migrationsdateien.

---

## 26. Datenbank wiederherstellen

> Eine Wiederherstellung kann vorhandene Daten überschreiben. Vorher immer den aktuellen Zustand sichern.

### 26.1 Wiederherstellung über phpMyAdmin

1. Bestehende Datenbank sichern.
2. Datenbank `easyit` auswählen.
3. Bei einem vollständigen Dump gegebenenfalls vorhandene Tabellen entfernen.
4. **Importieren** öffnen.
5. Sicherungsdatei auswählen.
6. Import starten.
7. Admin-Anmeldung testen.
8. Inhalte und Bewertungsmetadaten prüfen.
9. Cache leeren.

### 26.2 Wiederherstellung über Kommandozeile

```bat
C:\xampp\mysql\bin\mysql.exe -u easyit_user -p easyit < C:\Backups\easyit_backup.sql
```

---

## 27. Update auf eine neue Phase

Empfohlener Ablauf:

1. Vollständiges Datenbankbackup erstellen.
2. Projektordner als ZIP sichern.
3. Neue Phase in einen separaten Testordner entpacken.
4. Dateistruktur vergleichen.
5. Prüfen, ob die Basis-URL `/nh_hor/` erhalten bleibt.
6. Prüfen, ob `require`- und `include`-Pfade unverändert bleiben.
7. Neue Dateien in den Produktivordner übernehmen.
8. Migrationen ausführen.
9. Servercache leeren.
10. Browser- und Service-Worker-Cache leeren.
11. Adminbereich testen.
12. Öffentliche Seiten testen.

### 27.1 Kritische Pfadregel

Browser-URLs dürfen bei der lokalen Installation mit `/nh_hor/` beginnen:

```html
<link rel="stylesheet" href="/nh_hor/assets/css/main.css">
<a href="/nh_hor/kontakt.php">Kontakt</a>
```

PHP-Dateisystempfade dürfen nicht pauschal um `/nh_hor/` erweitert werden:

```php
require __DIR__ . '/includes/functions.php';
```

Nicht korrekt:

```php
require __DIR__ . '/nh_hor/includes/functions.php';
```

Dies würde zu einem doppelten Pfad wie diesem führen:

```text
C:\xampp\htdocs\nh_hor\nh_hor\includes\functions.php
```

---

## 28. Bekannter Pfadhinweis im aktuellen Admincode

Einige Weiterleitungen im aktuellen Projektstand verwenden noch Pfade wie:

```php
header('Location: /nh_hor/admin/index.php');
```

Bei einer Installation im Unterverzeichnis `/nh_hor/` sollte der Pfad lauten:

```php
header('Location: /nh_hor/admin/index.php');
```

Betroffen sein können insbesondere Weiterleitungen in:

- `admin/login.php`
- `admin/delete.php`
- `admin/cache-clear.php`
- `admin/includes/auth.php`
- `admin/edit.php`

Falls nach Anmeldung, Speichern, Archivieren oder Cache-Leerung eine 404-Seite unter `https://localhost/admin/...` erscheint, liegt die Ursache sehr wahrscheinlich in einer solchen Weiterleitung.

Die Dateisystempfade mit `__DIR__` dürfen dabei nicht verändert werden.

---

## 29. Fehlerbehebung

### 29.1 „Die Datenbankverbindung ist noch nicht eingerichtet“

Prüfen:

- läuft MySQL in XAMPP?
- existiert die Datenbank `easyit`?
- stimmen Benutzer und Passwort in `config/database.php`?
- besitzt der Benutzer Rechte auf `easyit.*`?
- ist `pdo_mysql` aktiv?

### 29.2 Anmeldung führt zu `/admin/index.php` statt `/nh_hor/admin/index.php`

Weiterleitung auf `/nh_hor/admin/...` korrigieren. Siehe Abschnitt 28.

### 29.3 Nach dem Speichern erscheint eine 404-Seite

Der Datensatz kann trotzdem gespeichert worden sein. Zuerst in phpMyAdmin oder über die Inhaltsliste prüfen. Anschließend die Weiterleitung in `admin/edit.php` korrigieren.

### 29.4 „Speichern fehlgeschlagen. Prüfe, ob der Slug bereits vergeben ist.“

Mögliche Ursachen:

- derselbe Slug existiert bereits beim gleichen Inhaltstyp,
- Datenbankverbindung wurde unterbrochen,
- Spalten fehlen, weil Migrationen nicht ausgeführt wurden,
- Fremdschlüssel verweist auf einen nicht mehr vorhandenen Benutzer.

Slug prüfen:

```sql
SELECT id, content_type, title, slug
FROM content_items
WHERE content_type = 'blog'
  AND slug = 'GEWUENSCHTER-SLUG';
```

### 29.5 Bewertungsfelder fehlen

Migration ausführen:

```bat
php database\migrate.php
```

Danach prüfen:

```sql
SHOW COLUMNS FROM content_items;
SHOW COLUMNS FROM content_revisions;
```

Erwartete Felder:

```text
review_date
reviewer_name
reviewer_age
reviewer_school_type
```

### 29.6 Änderungen erscheinen nicht öffentlich

1. Status auf **Veröffentlicht** prüfen.
2. Cache im Dashboard leeren.
3. `Strg + F5` ausführen.
4. Service Worker löschen.
5. Prüfen, ob die öffentliche Seite den Inhaltstyp tatsächlich aus der Datenbank lädt.

### 29.7 CSS des Adminbereichs fehlt

Prüfen, ob diese Datei erreichbar ist:

```text
https://localhost/nh_hor/assets/css/admin.css
```

Im Admin-Header muss stehen:

```html
<link rel="stylesheet" href="/nh_hor/assets/css/admin.css">
```

### 29.8 Fatal Error mit `nh_hor/nh_hor`

Ursache: Browserpfad wurde fälschlich in einen PHP-Dateisystempfad eingesetzt.

Korrekt:

```php
require __DIR__ . '/../includes/database.php';
```

Nicht korrekt:

```php
require __DIR__ . '/nh_hor/../includes/database.php';
```

### 29.9 Archivierter Inhalt ist weiterhin sichtbar

Prüfen:

- Filtert die öffentliche Abfrage auf `status = 'published'`?
- wurde der Cache geleert?
- existiert zusätzlich ein statischer Inhalt in einer PHP-Datei?

### 29.10 Serverfehler 500

Prüfen:

```text
C:\xampp\apache\logs\error.log
```

Zusätzlich PHP-Syntax prüfen:

```bat
php -l admin\edit.php
php -l admin\content.php
php -l admin\login.php
```

---

## 30. Sicherheitsregeln für Administratoren

- Adminbereich niemals auf einem fremden Gerät geöffnet lassen.
- Nach jeder Sitzung abmelden.
- Keine Passwörter im Browser eines gemeinsam genutzten Computers speichern.
- Vor jedem Update ein Backup erstellen.
- Datenbankpasswort nicht in Dokumentationen veröffentlichen.
- Keine vollständigen Namen Minderjähriger ohne ausdrückliche Einwilligung veröffentlichen.
- Keine HTML- oder JavaScript-Fragmente aus unbekannten Quellen einfügen.
- Adminzugang im Produktivbetrieb nur über HTTPS verwenden.
- Standardbenutzernamen wie `admin` möglichst vermeiden.
- Nicht benötigte Konten deaktivieren.
- PHP, Apache und MySQL regelmäßig aktualisieren.
- Fehlerausgabe im Produktivbetrieb nicht öffentlich anzeigen.

---

## 31. Redaktionsworkflow

Empfohlener Ablauf für jeden neuen Inhalt:

### Stufe 1 – Entwurf

- Inhalt anlegen,
- Status **Entwurf**,
- sachliche Vollständigkeit prüfen,
- Rechtschreibung prüfen.

### Stufe 2 – Vorschau

- Darstellung kontrollieren,
- personenbezogene Daten prüfen,
- SEO-Titel und Meta-Beschreibung kontrollieren,
- Slug kontrollieren.

### Stufe 3 – Veröffentlichung

- Status **Veröffentlicht**,
- speichern,
- Cache leeren,
- öffentliche Seite öffnen.

### Stufe 4 – Nachkontrolle

- Mobilansicht prüfen,
- Desktopansicht prüfen,
- Links testen,
- Datum und Metadaten kontrollieren.

### Stufe 5 – Pflege

- veraltete Inhalte aktualisieren,
- nicht mehr relevante Inhalte archivieren,
- mindestens vierteljährlich prüfen.

---

## 32. Regelmäßige Wartung

### Wöchentlich

- neue Inhalte prüfen,
- veröffentlichte Bewertungen kontrollieren,
- Fehlermeldungen prüfen,
- Backup der Datenbank erstellen.

### Monatlich

- vollständiges Projektbackup,
- archivierte Inhalte prüfen,
- Benutzerkonten prüfen,
- Audit-Log stichprobenartig kontrollieren,
- defekte Links kontrollieren.

### Vierteljährlich

- SEO-Titel und Meta-Beschreibungen prüfen,
- veraltete Jobs archivieren,
- FAQ aktualisieren,
- Datenschutzhinweise kontrollieren,
- verwendete PHP- und MySQL-Versionen prüfen.

### Vor jeder Phase

- Datenbankdump,
- Projekt-ZIP,
- Importtest,
- Migrationsprüfung,
- Pfadprüfung `/nh_hor/`,
- Funktionstest des Adminbereichs.

---

## 33. Inhalte, die derzeit nicht über den Adminbereich verwaltet werden

Folgende Bereiche sind im Projekt vorhanden, besitzen jedoch im aktuellen Stand keine eigene Adminmaske:

- Startseite
- Fächerseiten
- Schulformseiten
- Stadtteilseiten
- Seite „Warum easyIT“
- Unterrichtsregeln als Akkordeons
- Methodikseite
- Preisseite
- Kontaktseite
- Navigation und Footer
- Bilder und SVG-Dateien
- Downloads
- Lernwerkzeuge
- Sitemap
- Robots-Datei
- Manifest und Service Worker
- Benutzerverwaltung
- Audit-Log-Anzeige
- Revisionen wiederherstellen
- Medienupload
- Kontaktanfragen verwalten

Diese Funktionen dürfen im Handbuch nicht als bereits vorhandene Adminfunktionen missverstanden werden.

---

## 34. Sinnvolle spätere Erweiterungen

Für eine zukünftige Adminphase sind besonders sinnvoll:

1. zentrale Pflege der Unterrichtsregeln,
2. Medienbibliothek mit Bild-Upload,
3. sichtbare Revisionshistorie mit Wiederherstellung,
4. Rollen- und Rechteverwaltung,
5. Passwortänderung und Passwort-zurücksetzen,
6. Audit-Log-Oberfläche,
7. Bearbeitung statischer Seiten,
8. Menü- und Footerverwaltung,
9. Verwaltung der Fächer, Schulformen und Stadtteile,
10. Kontaktanfragen im Adminbereich,
11. Vorschau im echten Seitendesign,
12. Löschbestätigung mit POST statt direktem Aktionslink,
13. zentrale Konstante für die Basis-URL,
14. Dashboard mit Wartungs- und Inhaltswarnungen,
15. automatische Datenbanksicherung.

---

## 35. Schnellreferenz

### Admin öffnen

```text
https://localhost/nh_hor/admin/
```

### Migration ausführen

```bat
cd C:\xampp\htdocs\nh_hor
php database\migrate.php
```

### Admin anlegen

```bat
php database\create-admin.php BENUTZER EMAIL PASSWORT
```

### PHP-Datei prüfen

```bat
php -l admin\edit.php
```

### Datenbanktabellen anzeigen

```sql
SHOW TABLES FROM easyit;
```

### Letzte Inhalte anzeigen

```sql
SELECT id, content_type, title, slug, status, updated_at
FROM content_items
ORDER BY updated_at DESC;
```

### Letzte Adminaktionen anzeigen

```sql
SELECT action, entity_type, entity_id, created_at
FROM audit_log
ORDER BY created_at DESC
LIMIT 50;
```

### Cache leeren

```text
Admin → Dashboard → Cache leeren
```

---

## 36. Checkliste vor Veröffentlichung eines Eintrags

- [ ] Titel ist verständlich.
- [ ] Slug ist eindeutig und korrekt.
- [ ] Inhalt ist vollständig.
- [ ] Rechtschreibung wurde geprüft.
- [ ] Keine internen Notizen sind enthalten.
- [ ] SEO-Titel wurde eingetragen.
- [ ] Meta-Beschreibung wurde eingetragen.
- [ ] Status ist korrekt.
- [ ] Sortierung ist sinnvoll.
- [ ] Bewertungsdaten sind vollständig oder bewusst leer.
- [ ] Datenschutz wurde geprüft.
- [ ] Vorschau wurde geöffnet.
- [ ] Cache wurde nach Veröffentlichung geleert.
- [ ] Öffentliche Seite wurde kontrolliert.

---

## 37. Checkliste vor einem Update

- [ ] Datenbank wurde vollständig exportiert.
- [ ] Projektordner wurde gesichert.
- [ ] Neue Phase wurde separat entpackt.
- [ ] Browserpfade wurden auf `/nh_hor/` geprüft.
- [ ] PHP-Dateisystempfade wurden nicht verändert.
- [ ] Migrationen wurden geprüft.
- [ ] Admin-Anmeldung funktioniert.
- [ ] Inhalte können gespeichert werden.
- [ ] Bewertungsfelder funktionieren.
- [ ] Cache kann geleert werden.
- [ ] Öffentliche Seiten funktionieren.
- [ ] Service Worker wurde aktualisiert beziehungsweise geleert.

---

## 38. Abschluss

Der Adminbereich von easyIT-Nachhilfe Leipzig bildet im aktuellen Stand ein kompaktes CMS für FAQ, Bewertungen, Jobs und Blogbeiträge. Er bietet bereits:

- geschützte Anmeldung,
- datenbankgestützte Inhalte,
- Entwurf, Veröffentlichung und Archivierung,
- Vorschau,
- Bewertungsmetadaten,
- Revisionsspeicherung,
- Audit-Protokollierung,
- Cache-Leerung,
- Datenbankmigrationen.

Für einen zuverlässigen Betrieb sind regelmäßige Backups, sorgfältige Datenschutzprüfung und die konsequente Trennung zwischen Browser-URLs und PHP-Dateisystempfaden entscheidend.
