# Canonical-URL-Normalisierung

Die automatische Canonical-URL wird zentral mit `canonical_url()` erzeugt.

- Der Host stammt ausschließlich aus `config/site.php` (`base_url`).
- Aus `REQUEST_URI` wird nur der Pfad übernommen.
- Query-Parameter und Fragmente werden standardmäßig entfernt.
- Doppelte Schrägstriche und Punktsegmente werden normalisiert.
- Dynamische Inhaltsparameter werden ausschließlich explizit freigegeben.

Aktuell freigegebene dynamische Canonicals:

- `blog-artikel.php?slug=...`
- `tutor-bewertungen.php?tutor=...`

Such-, Tracking-, Formular- und sonstige Parameter werden nicht in Canonicals übernommen.
