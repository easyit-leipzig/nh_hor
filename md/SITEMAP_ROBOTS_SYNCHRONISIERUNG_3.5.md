# 3.5 Sitemap und Robots-Regeln synchronisiert

- `sitemap.xml` wird dynamisch über `sitemap-xml.php` erzeugt.
- `offline.php`, Erfolgs-, Fehler-, Admin-, Formular-, Vorschau- und technische Endpunkte werden nicht ausgegeben.
- `offline.php`, Erfolgs- und Fehlerseiten besitzen `noindex`.
- Blogartikel werden nur bei CMS-Status `published` aufgenommen.
- Blog-`lastmod` stammt aus `updated_at`, ersatzweise `published_at`.
- Statische Seiten erhalten `lastmod` aus dem tatsächlichen Dateiänderungsdatum.
- Alle URLs werden aus der konfigurierten `base_url` und der zentralen Canonical-Funktion erzeugt.
- Die Startseite erscheint ausschließlich als `/`.
- Die frühere statische `sitemap.xml` wurde entfernt, damit keine veraltete Parallelfassung ausgeliefert wird.
