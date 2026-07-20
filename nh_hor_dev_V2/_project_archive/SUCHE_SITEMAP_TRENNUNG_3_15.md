# 3.15 Suchfunktion und Sitemap-Seite trennen

## Umsetzung

- `suche.php` ist der einzige Endpunkt für Suchanfragen.
- Die Suche funktioniert serverseitig und damit auch ohne JavaScript.
- JavaScript ergänzt lediglich Vorschläge im Kopfbereich.
- `sitemap.php` bleibt eine eigenständige, statische Seitenübersicht und wertet keinen Suchparameter aus.
- Suchergebnisse tragen `noindex,follow`.
- Der Canonical der Suche lautet immer `/suche.php`; `q` wird nicht übernommen.
- Die XML-Sitemap enthält die Suchseite nicht.
- Die Suchdaten werden aus `config/search-pages.php` erzeugt.

## Tests

```bash
php -l suche.php
php -l config/search-pages.php
php -l includes/search-functions.php
```

Im Browser zusätzlich prüfen:

1. `/suche.php?q=mathe` mit aktiviertem JavaScript.
2. Dieselbe URL mit deaktiviertem JavaScript.
3. Quelltext auf `noindex,follow` und Canonical ohne `q` prüfen.
4. `/sitemap.php?q=mathe` muss weiterhin nur die Sitemap anzeigen.
