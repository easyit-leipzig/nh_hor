# Korrektur lokaler Weiterleitungen

Die serverseitigen HTTP-Weiterleitungen verwenden jetzt `app_path()`.
Dadurch wird bei einer lokalen Installation unter `/nh_hor` korrekt nach
`/nh_hor/kontakt.php` statt nach `/kontakt.php` weitergeleitet.

Geänderte Dateien:
- `kontakt-senden.php`
- `anfrage-erfolgreich.php`
- `admin/image-credits.php`
