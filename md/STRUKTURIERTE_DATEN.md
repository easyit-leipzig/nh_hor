# Strukturierte Daten

Die globale Auszeichnung wird zentral in `includes/structured-data.php` erzeugt.

## Grundsatz

- Ohne vollständige ladungsfähige Anschrift wird ausschließlich `EducationalOrganization` ausgegeben.
- `LocalBusiness` wird nur ergänzt, wenn Straße, Postleitzahl, Ort und Land vollständig in `config/site.local.php` vorliegen.
- Leere Telefonnummern, Adressen, Öffnungszeiten, Geo-Koordinaten, Preisangaben und Social-Profile werden nicht ausgegeben.
- Logo und Unternehmensbild werden als absolute URLs erzeugt.
- Bewertungen oder AggregateRating werden nicht automatisch ausgezeichnet. Solche Angaben dürfen nur aus realen, sichtbaren Daten ergänzt werden.

## Produktive Angaben

`config/site.local.example.php` nach `config/site.local.php` kopieren und mit den tatsächlichen Unternehmensdaten befüllen. Die lokale Datei bleibt durch `.gitignore` vom Repository ausgeschlossen.
