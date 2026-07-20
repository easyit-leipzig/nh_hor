# Konsolidierte Umsetzungs- und Abnahmefolge

## Verbindliches Produktionsziel

Öffentliche kanonische Adresse ist ausschließlich `https://easyit-leipzig.de/`. Der Serverordner `nh_hor` ist kein Bestandteil öffentlicher URLs. Alternative Domains leiten dauerhaft auf die kanonische Domain um.

Auf den Webserver wird ausschließlich der Inhalt von `nh_hor/` übertragen. `_project_archive/` bleibt außerhalb des Webroots.

## Vor dem Deployment

1. Produktive Konfiguration und Zugangsdaten außerhalb des Webroots bereitstellen.
2. SMTP-Zugang und Absenderdomain prüfen.
3. Datenbank sichern und InnoDB-Migrationen ausführen.
4. `CSP_MODE=report-only` verwenden und Berichte beziehungsweise Browserkonsole prüfen.
5. `python3 _project_archive/quality/tests/release-audit.py` ausführen.

## Browser- und Accessibility-Abnahme

Automatisierte Basisprüfung:

```bash
cd _project_archive/quality
npm ci
npx playwright install --with-deps chromium firefox webkit
TEST_BASE_URL=https://staging.example.org npm run test:browsers
node tests/accessibility.mjs https://staging.example.org/ https://staging.example.org/kontakt.php https://staging.example.org/suche.php?q=mathe
```

Manuell zusätzlich prüfen:

- Chrome, Firefox und Edge auf Desktop;
- Chrome Android und Safari iOS auf realen Geräten;
- Tastatur-only und Screenreader-Kurztest;
- Breiten 320, 375, 768, 1024 und mindestens 1440 Pixel;
- alle Menüebenen, Suche ohne JavaScript, Kontaktformular, Adminlogin, Adminbearbeitung und Fehlerseiten;
- Fokusführung, Escape, Pfeiltasten, Fokusverlust, Touch und Hover-Persistenz.

## Live-/Staging-Abnahme

- Lighthouse je Hauptseitentyp, mindestens drei Durchläufe;
- PageSpeed Insights für Mobil und Desktop;
- Rich Results Test und Schema Markup Validator;
- Search-Console-URL-Prüfung und XML-Sitemap-Einreichung;
- Linkcrawler einschließlich Statuscodes, Redirectketten, Canonicals und verwaister Seiten;
- HTML-Validator;
- Felddaten in Search Console/CrUX für LCP, INP und CLS beobachten.

## Freigabekriterien

- keine kritischen oder schwerwiegenden Axe-Verstöße;
- genau ein H1 pro Seite;
- keine 5xx-Antworten und keine internen defekten Links;
- keine indexierbaren Admin-, Such-, Erfolgs-, Offline- oder Fehlerseiten;
- genau eine dynamische XML-Sitemap;
- keine SQL-, ZIP-, Markdown-, Backup- oder Projektdateien im Webroot;
- ausschließlich InnoDB;
- CSP-Berichte ohne erforderliche blockierte Ressourcen, danach Umschaltung auf `enforce`;
- SPF, DKIM und DMARC beim Mailanbieter erfolgreich validiert.
