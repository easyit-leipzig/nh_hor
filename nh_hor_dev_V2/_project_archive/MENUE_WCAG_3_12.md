# 3.12 Menüinteraktion nach WCAG 2.2

- Reine Untermenüpunkte verwenden `button` statt `href="#"`.
- Navigierbare Elternpunkte besitzen getrennte Link- und Schalterelemente.
- Untermenüschalter pflegen `aria-expanded` und `aria-controls`.
- Escape schließt das aktuelle Untermenü und führt den Fokus zum Schalter zurück.
- Pfeil hoch/runter, Home und Ende bewegen den Fokus durch sichtbare Navigationselemente.
- Pfeil rechts öffnet auf Desktop ein Untermenü; Pfeil links schließt es.
- Fokusverlust und Zeigerbetätigung außerhalb der Kopfzeile schließen offene Untermenüs.
- Alle interaktiven Ziele sind mindestens 44 × 44 CSS-Pixel groß.
- `:focus-visible` ist kontrastreich und deutlich erkennbar.
- Hover-Untermenüs bleiben überfahrbar und persistent; bei Touch wird nur der explizite Schalter verwendet.
