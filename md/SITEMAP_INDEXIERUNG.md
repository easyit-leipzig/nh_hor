# Sitemap- und Indexierungsregeln

Stand: 19.07.2026

## Umgesetzte Korrekturen

- `offline.php` wurde aus `sitemap.xml` entfernt.
- Nicht indexierbare Erfolgs-, Fehler-, Admin-, Formular- und Systemendpunkte werden nicht in der Sitemap geführt.
- `offline.php`, `anfrage-erfolgreich.php` sowie die Fehlerseiten besitzen weiterhin ein ausdrückliches `noindex`.
- `robots.txt` und `sitemap.xml` verwenden die öffentliche Hauptdomain `https://easyit-nachhilfe.de/nh_hor/`.
- Die Tutor-URLs bleiben als kanonische, indexierbare Parameter-URLs in der Sitemap enthalten.
- XML-Sonderzeichen in URL-Parametern werden korrekt escaped.

## Grundregel

In die XML-Sitemap gehören ausschließlich öffentlich erreichbare, kanonische und indexierbare Seiten. Seiten mit `noindex`, interne Systempfade, Adminseiten, Fehlerseiten und Formular-Endpunkte dürfen nicht aufgenommen werden.
