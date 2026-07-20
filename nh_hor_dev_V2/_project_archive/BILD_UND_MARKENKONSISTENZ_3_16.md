# 3.16 Bild- und Markenkonsistenz

## Verbindliche Markenquelle

Im produktiven Webroot existiert nur noch eine Logoquelle:

- `assets/img/brand-logo.svg`
- ViewBox: `0 0 1200 900`
- Seitenverhältnis: 4:3

Der Header verwendet intrinsische Maße von `160 × 120` Pixeln. CSS darf die Darstellungsgröße verändern, das Seitenverhältnis bleibt jedoch unverändert.

## Social Preview

Für Open Graph und Twitter/X wird ausschließlich folgende Rasterdatei verwendet:

- `assets/img/social-preview-1200x630.png`
- Format: PNG
- Abmessungen: 1200 × 630 Pixel

Dadurch hängt die Vorschau nicht von der SVG-Unterstützung externer Plattformen ab.

## Bildsprache nach Seitentyp

- Startseite: Lern- und Tutorsituation im easyIT-Illustrationsstil.
- Fachseiten: ausschließlich die einheitlichen Fachillustrationen unter `assets/img/subjects/`.
- Tutorprofile und Bewertungen: ausschließlich die zugehörigen Tutorabbildungen unter `assets/img/tutors/`.
- Header, strukturierte Daten und Markenkommunikation: ausschließlich `brand-logo.svg`.
- Social Preview: ausschließlich `social-preview-1200x630.png`.

Generische oder alternative Logo-Varianten werden nicht parallel im Webroot geführt.
