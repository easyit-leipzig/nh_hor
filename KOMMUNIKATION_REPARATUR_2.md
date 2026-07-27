# Kommunikationsmodul – Reparatur 2

Behoben wurde der Laufzeitfehler:

`Call to undefined method PHPMailer\PHPMailer\PHPMailer::isMail()`

Der im Projekt enthaltene schlanke PHPMailer-kompatible Adapter stellt jetzt die von `InformUser` verwendeten Transportmethoden bereit:

- `isMail()`
- `isSendmail()`
- `isSMTP()`

Für `transport = mail` wird die PHP-Funktion `mail()` verwendet. Für `transport = sendmail` wird der in `sendmail_path` konfigurierte Befehl ausgeführt. Der schlanke Adapter unterstützt keinen direkten SMTP-Dialog; für Mailpit unter XAMPP ist daher die PHP-Mail-Konfiguration oder ein Sendmail-Aufruf zu verwenden.

Die lokale Konfiguration liegt in `config/communication.local.php`. Ohne lokale Datei gelten die Werte aus `config/communication.php`.
