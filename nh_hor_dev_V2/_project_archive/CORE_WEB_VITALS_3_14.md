# 3.14 Core Web Vitals

## Umgesetzt
- Die ungenutzte 2,26-MB-PNG-Datei wurde entfernt.
- Das 798-KB-Logo-SVG wurde durch ein 5-KB-Vektorlogo ersetzt.
- Die nicht verwendete Legacy-Datei `nojquery_3.1.1.js` wird nicht mehr global geladen.
- LCP-relevante Bilder besitzen feste Breite/Höhe; das Startseiten-Hero bleibt `fetchpriority="high"`.
- Lighthouse-CI misst lokal drei Durchläufe und prüft Performance, LCP, CLS und Total Blocking Time.

## Reale Felddaten
Die produktive Domain muss nach Deployment mit PageSpeed Insights und Search Console/CrUX geprüft werden. Labordaten aus Lighthouse ersetzen keine 28-Tage-Felddaten.

## Ausführung
```bash
cd _project_archive/quality
./run-lighthouse.sh
```
