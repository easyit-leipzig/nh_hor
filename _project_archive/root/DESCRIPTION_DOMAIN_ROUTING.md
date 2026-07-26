# Domain- und Verzeichnisrouting

## Zielstruktur

- `easyit-leipzig.de` bleibt das Wurzelverzeichnis und wird nicht pauschal nach `/nh_hor/` umgeleitet.
- `easyit-nachhilfe.de` ist die öffentliche Hauptdomain der Nachhilfeseite.
- `https://easyit-nachhilfe.de/` leitet mit HTTP 301 auf `https://easyit-nachhilfe.de/nh_hor/` weiter.
- `thiele-nachhilfe.de` ist eine Weiterleitungsdomain und führt mit HTTP 301 auf die entsprechende URL unter `https://easyit-nachhilfe.de/nh_hor/`.
- Canonical-URLs, Sitemap-URLs und strukturierte Daten werden über `base_url = https://easyit-nachhilfe.de` erzeugt.

## Installation

1. Den Inhalt dieses Pakets in das vorhandene Serververzeichnis `/nh_hor/` laden.
2. Den Inhalt von `ROOT_HTACCESS_EASYIT_LEIPZIG.txt` in die `.htaccess` des Wurzelverzeichnisses von `easyit-leipzig.de` übernehmen.
3. Prüfen, dass `mod_rewrite` aktiv ist und die Domain-Aliase auf dasselbe Webspace-Wurzelverzeichnis zeigen.
4. Für `easyit-nachhilfe.de`, `www.easyit-nachhilfe.de`, `thiele-nachhilfe.de` und `www.thiele-nachhilfe.de` gültige TLS-Zertifikate hinterlegen.

## Erwartete Weiterleitungen

- `http://easyit-nachhilfe.de/` → `https://easyit-nachhilfe.de/nh_hor/`
- `https://www.easyit-nachhilfe.de/` → `https://easyit-nachhilfe.de/nh_hor/`
- `https://thiele-nachhilfe.de/` → `https://easyit-nachhilfe.de/nh_hor/`
- `https://thiele-nachhilfe.de/mathe-nachhilfe-leipzig.php` → `https://easyit-nachhilfe.de/nh_hor/mathe-nachhilfe-leipzig.php`
- `https://easyit-leipzig.de/` bleibt unverändert.
