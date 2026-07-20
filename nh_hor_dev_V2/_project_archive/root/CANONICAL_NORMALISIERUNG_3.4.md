# 3.4 Canonical-URL-Normalisierung

Die Canonical-Erzeugung erfolgt zentral in `includes/functions.php` über `canonical_url()`.

## Regeln

- Der Host stammt ausschließlich aus `config/site.php` (`base_url`), niemals aus `HTTP_HOST`.
- Aus `REQUEST_URI` wird ausschließlich der Pfad übernommen.
- Der technische lokale Pfad `/nh_hor` wird aus Canonicals entfernt.
- Query-Parameter aus dem Request werden vollständig verworfen.
- Kanonische Parameter werden nur ausdrücklich durch die jeweilige Seite übergeben.
- Erlaubt sind ausschließlich `slug` und `tutor`.
- Beide Werte müssen dem Slug-Format `a-z`, `0-9` und Bindestrich entsprechen.
- `/index.php` und `/` werden einheitlich als `https://easyit-leipzig.de/` ausgegeben.

## Beispiele

- `/nh_hor/?utm_source=test` → `https://easyit-leipzig.de/`
- `/nh_hor/sitemap.php?q=test` → `https://easyit-leipzig.de/sitemap.php`
- `/nh_hor/blog-artikel.php?slug=x&utm_source=test` wird nur durch den von der Anwendung validierten Artikel-Slug kanonisiert.
- `/nh_hor/tutor-bewertungen.php?tutor=x` wird nur durch den von der Anwendung validierten Tutor-Slug kanonisiert.
