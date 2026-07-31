# 3D-Menüfähnchen

## Verhalten

- Header und Hauptnavigation besitzen keine Sticky-Position mehr und scrollen mit der Seite nach oben.
- Sobald der Header vollständig oberhalb des sichtbaren Bereichs liegt, erscheint rechts oben ein plastisches 3D-Fähnchen.
- Ein Klick auf das Fähnchen lässt den Headerbereich mit der Hauptnavigation von oben in das Browserfenster gleiten.
- Schließen ist über das X, einen Klick auf den abgedunkelten Hintergrund oder die Escape-Taste möglich.
- Bei Rückkehr an den Seitenanfang verschwindet das Fähnchen automatisch.
- Die Animation respektiert `prefers-reduced-motion`.

## Geänderte Dateien

- `includes/meta.php`
- `includes/footer.php`
- `assets/css/menu-flag.css`
- `assets/js/menu-flag.js`
- `config/asset-manifest.php`

Zusätzlich wurden die zugehörigen versionierten Asset-Dateien erzeugt.


## Anpassung ohne Fahnenstange

Das 3D-Menüfähnchen wird frei schwebend ohne Fahnenstange dargestellt. Schatten, Wölbung, Glanz und Animation bleiben erhalten.
