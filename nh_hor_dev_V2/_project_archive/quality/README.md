# HTML- und Accessibility-Prüfungen

Die Prüfungen laufen außerhalb des öffentlichen Webroots. Vor dem ersten Lauf:

```bash
npm install
npx playwright install chromium
```

Bei lokal laufender Website:

```bash
python3 tests/html-headings.py http://localhost/nh_hor/ http://localhost/nh_hor/tutor-bewertungen.php
node tests/accessibility.mjs http://localhost/nh_hor/ http://localhost/nh_hor/tutor-bewertungen.php
```

Der HTML-Test verlangt genau ein `h1`, ein `main`, ein gesetztes `lang`, einen nicht leeren Seitentitel, keine doppelten IDs und keine übersprungenen Überschriftenebenen. Der Axe-Test schlägt bei schwerwiegenden oder kritischen WCAG-Verstößen fehl.
