# Pfadkorrektur – einheitlicher Projektpfad `/nh_hor`

## Durchgeführte Änderungen

- Sämtliche Vorkommen von `nh_seo` wurden aus Code, SQL-Dateien und Dokumentation entfernt.
- Alle internen Webpfade verwenden ausschließlich `/nh_hor/...`.
- Admin-Weiterleitungen wurden von `/admin/...` auf `/nh_hor/admin/...` korrigiert.
- Weiterleitungen des Kontaktformulars wurden auf `/nh_hor/...` korrigiert.
- Dynamisch erzeugte Links für Fächer, Stadtteile, Schulformen und Werkzeuge wurden auf `/nh_hor/...` korrigiert.
- Fehlerseiten und `ErrorDocument` verwenden `/nh_hor/errors/...`.
- `robots.txt`, `sitemap.xml`, Manifest und Service Worker verwenden ausschließlich `/nh_hor`.
- Canonical-URLs der Template-Seiten wurden korrigiert und enthalten nun genau einmal `/nh_hor/`.
- Der fehlerhafte Speicherpfad `nh_hor/nh_hor/storage` des Kontaktformulars wurde auf den tatsächlichen lokalen Ordner `storage` korrigiert.
- Dokument- und Dateinamen mit der alten Projektbezeichnung wurden auf `nh_hor` umbenannt.

## Zentrale Konfiguration

In `config/site.php` ist jetzt zusätzlich definiert:

```php
'base_path' => '/nh_hor',
```

## Prüfung

- Keine verbliebenen Zeichenketten `nh_seo`.
- Keine doppelten Webpfade `/nh_hor/nh_hor`.
- Alle PHP-Dateien bestehen die Syntaxprüfung mit `php -l`.
