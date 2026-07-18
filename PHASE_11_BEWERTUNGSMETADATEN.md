# Phase 11 – Bewertungsmetadaten

Die Bewertungsseite zeigt am unteren Rand jeder Bewertungskachel:

- Datum
- Name
- Alter
- Schulform

Die Werte werden im Adminbereich bei Inhalten vom Typ `review` gepflegt.

## Bestehende Installation aktualisieren

1. Dateien nach `C:\xampp\htdocs\nh_seo\` entpacken.
2. In der XAMPP-Shell ausführen: `php C:\xampp\htdocs\nh_seo\database\migrate.php`.
3. Bestehende Bewertungen im Adminbereich öffnen und die vier Angaben ergänzen.
4. Browser mit `Strg + F5` neu laden.

Leere Angaben werden auf der öffentlichen Seite mit einem Gedankenstrich dargestellt.
