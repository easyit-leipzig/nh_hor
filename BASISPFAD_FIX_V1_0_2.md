# Basis-Pfad-Korrektur 1.0.2

- Lokal wird `app.base_path = /nh_hor` aus `config/config.local.php` verwendet.
- Auf dem Server wird `app.base_path = ""` aus `config/config.server.php` verwendet.
- `app_path()` hängt nicht mehr von einer eventuell abweichenden Apache-Variable `SCRIPT_NAME` ab.
- Formularziel und Weiterleitungen von `kontakt-senden.php` verwenden denselben zentralen Basis-Pfad.
