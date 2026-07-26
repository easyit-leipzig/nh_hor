# SEO-Umsetzung – easyIT Nachhilfe Leipzig

## Zentral umgesetzt

- einheitliche, normalisierte Canonical-URLs ohne lokalen `/nh_hor`-Pfad, `/index.php` oder Trackingparameter
- individuelle Seitentitel und Beschreibungen aus den vorhandenen Seitendateien bzw. Seitentemplates
- Open-Graph- und Twitter-Metadaten mit vorhandenem 1200×630-Vorschaubild
- `hreflang` für `de-DE` und `x-default`
- strukturierte Daten für `EducationalOrganization`, `WebSite`, `WebPage`, Breadcrumbs sowie vorhandene Service- und FAQ-Daten
- interne Suchfunktion als `SearchAction`
- dynamische XML-Sitemap mit `lastmod`, `changefreq` und `priority`
- bereinigte `robots.txt`
- 301-Weiterleitung von `/index.php` auf `/` ausschließlich auf der Produktionsdomain
- Admin-, Konfigurations-, Datenbank-, Speicher- und Fehlerbereiche bleiben von der Indexierung ausgeschlossen

## Vor der Liveschaltung prüfen

1. In `config/site.local.php` bzw. über Umgebungsvariablen müssen die endgültige Domain, Telefonnummer, E-Mail-Adresse und Anschrift gesetzt sein.
2. `https://easyit-leipzig.de/sitemap.xml` muss nach dem Upload XML ausliefern.
3. `https://easyit-leipzig.de/robots.txt` muss erreichbar sein.
4. Das Vorschaubild `assets/img/social-preview-1200x630.png` muss öffentlich abrufbar sein.
5. Nach der Veröffentlichung Sitemap in Google Search Console und Bing Webmaster Tools einreichen.

Es wurden keine erfundenen Bewertungen, Sterne, Öffnungszeiten, Preise oder sozialen Profile als strukturierte Daten ergänzt. Solche Angaben dürfen erst ausgezeichnet werden, wenn sie real und öffentlich nachvollziehbar sind.
