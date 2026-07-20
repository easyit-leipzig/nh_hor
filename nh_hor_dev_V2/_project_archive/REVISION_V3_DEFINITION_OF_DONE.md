# Revision V3 – Definition of Done

## Automatisch prüfbarer Projektstand

Die statische Freigabeprüfung wird mit folgendem Befehl ausgeführt:

```bash
python3 _project_archive/quality/tests/v3_definition_of_done.py
```

Für eine erreichbare Staging-Installation:

```bash
python3 _project_archive/quality/tests/v3_definition_of_done.py \
  --base-url=https://staging.example.org/
```

Die Prüfung umfasst Platzhalter, URL-Strategie, Admin-POST/CSRF, Canonicals, Robots/Sitemap, Deployment-Hygiene, Session-Härtung, Menü-Tastaturbedienung, InnoDB und SMTP.

## Vor Staging-Freigabe zwingend real durchzuführen

Die folgenden Punkte können nicht allein aus einem ZIP bestätigt werden und müssen auf dem realen Staging-System protokolliert werden:

1. Datenbankmigration `up`, `status` und `check` erfolgreich.
2. SMTP-Testnachricht erfolgreich an den Mailserver übergeben; Fehlerfall getestet.
3. Adminlogin, Sperre nach Fehlversuchen, Bearbeitung und Archivierung geprüft.
4. CSRF-Ablehnung mit ungültigem Token geprüft.
5. Cookie-Flags im Browser kontrolliert: `Secure`, `HttpOnly`, `SameSite=Lax` oder strenger.
6. Lighthouse je Hauptseitentyp ohne kritische Fehler.
7. Axe-/Accessibility-Lauf ohne kritische oder schwerwiegende Verstöße.
8. Tastatur-only und Screenreader-Kurztest.
9. PageSpeed Insights, Rich Results Test, Schema Markup Validator und HTML-Validator.
10. Search Console URL-Prüfung, XML-Sitemap-Test und Linkcrawler.

## Freigabestatus

Der Projektstand ist **statisch staging-vorbereitet**, sobald der V3-Audit ohne Fehler endet. Er ist erst **staging-abgenommen**, wenn alle externen und interaktiven Prüfpunkte dokumentiert erfolgreich abgeschlossen wurden.
