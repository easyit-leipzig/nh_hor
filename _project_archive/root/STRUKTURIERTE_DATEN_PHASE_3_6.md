# Phase 3.6 – Strukturierte Geschäftsdaten

## Umsetzung

- Es wird global genau eine `EducationalOrganization` mit stabiler `@id` ausgegeben.
- Die Organisation enthält ausschließlich konfigurierte reale Daten: Name, Inhaber, Telefon, E-Mail, vollständige Postanschrift, Servicegebiet, Logo und repräsentatives Bild.
- Logo und Bild werden immer als absolute URLs erzeugt.
- `sameAs`, `priceRange`, Öffnungszeiten und Geokoordinaten erscheinen nur, wenn valide Werte konfiguriert sind.
- Seitenspezifische Service- und Article-Schemas referenzieren die globale Organisation über `@id`, statt widersprüchliche Organisationen zu duplizieren.
- `BreadcrumbList` wird für jede indexierbare Unterseite ergänzt; vorhandene detaillierte Breadcrumbs bleiben erhalten.
- `FAQPage` wird ausschließlich dort ausgegeben, wo dieselben Fragen und Antworten sichtbar gerendert werden.
- Blogartikel verwenden `BlogPosting` mit Autor, Publisher-Referenz, Veröffentlichungs-/Änderungsdatum, Bild und `mainEntityOfPage`.
- Seiten mit `noindex` erhalten keinerlei JSON-LD-Auszeichnung.

## Konfigurationsfelder

Die produktiven Werte werden in `config/site.local.php` oder über Umgebungsvariablen gepflegt. Offizielle Profile dürfen nur als vollständige URLs in `same_as` eingetragen werden.
