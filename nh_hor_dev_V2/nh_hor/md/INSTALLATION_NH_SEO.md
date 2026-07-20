# Phase 6 – korrigiert für XAMPP-Unterverzeichnis

Zielverzeichnis:

`C:\xampp\htdocs\nh_seo\`

Aufruf:

`https://localhost/nh_hor/`

## Wichtige Pfadregel

- Browser-URLs beginnen mit `/nh_hor/`.
- PHP-Dateisystempfade verwenden unverändert `__DIR__` und `dirname()`.
- An `require`, `require_once`, `include` und `include_once` wird kein `/nh_hor/` angehängt.

Das ZIP besitzt kein zusätzliches Oberverzeichnis. Sein Inhalt wird direkt nach `htdocs/nh_hor/` entpackt.
