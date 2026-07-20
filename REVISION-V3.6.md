# Revision V3.6 – lokaler Basispfad `/nh_hor`

Lokal werden alle Admin-URLs, Weiterleitungen, Formulare und Assets über den erkannten Anwendungsbasispfad erzeugt.

- lokal: `http://localhost/nh_hor/admin/`
- Produktion: `https://easyit-leipzig.de/admin/`

Die zentrale Funktion `app_path()` erkennt unter `localhost` bzw. `127.0.0.1` den ersten Verzeichnisabschnitt aus `SCRIPT_NAME`. Fehlt diese Information, wird lokal `/nh_hor` verwendet. Der produktive Betrieb bleibt am Domain-Root.
