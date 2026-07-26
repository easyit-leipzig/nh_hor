# easyIT Kontaktformular – Backend V1

## Enthalten

- Speicherung jeder gültigen Anfrage in `contact_requests`
- serverseitige Validierung
- CSRF-Schutz
- Honeypot-Prüfung
- Mindest-Ausfüllzeit
- Session-basiertes Rate-Limit
- HMAC-Hash der IP-Adresse statt Speicherung der Klartext-IP
- automatische Eingangsbestätigung an die anfragende Person
- interne E-Mail-Benachrichtigung mit Reply-To
- getrennte Protokollierung, ob beide E-Mails erfolgreich versandt wurden
- Mailfehler verhindern nicht die Speicherung der Anfrage

## 1. SQL importieren

`database/2026-07-23_contact_requests.sql`

## 2. PHPMailer installieren

Im Projektverzeichnis:

```bash
composer require phpmailer/phpmailer
```

## 3. Konfiguration anlegen

Kopieren:

```text
assets/php/config/mail.example.php    -> assets/php/config/mail.php
assets/php/config/contact.example.php -> assets/php/config/contact.php
```

Die echten SMTP-Zugangsdaten möglichst als Umgebungsvariablen setzen.

## 4. Datenbankverbindung

`assets/php/config/database.php` muss `$pdo` bereitstellen:

```php
<?php
declare(strict_types=1);

$pdo = new PDO(
    'mysql:host=127.0.0.1;dbname=easyit;charset=utf8mb4',
    'root',
    '',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);
```

## 5. kontakt.php anbinden

Direkt nach `declare(strict_types=1);`:

```php
require __DIR__ . '/assets/php/contact/process.php';
```

Im Formular muss das CSRF-Feld ergänzt werden:

```php
<input
    type="hidden"
    name="csrf_token"
    value="<?= e($_SESSION['contact_csrf_token']) ?>"
>
```

Die bisher verwendeten Variablen können auf `$contactData` umgestellt werden:

```php
value="<?= e($contactData['name']) ?>"
```

Fehler und Erfolg vor dem Formular ausgeben:

```php
<?php if ($contactSuccess): ?>
<div class="notice notice--success">
    Ihre Anfrage wurde gespeichert. Eine Eingangsbestätigung wurde versandt.
</div>
<?php endif; ?>

<?php if ($contactErrors !== []): ?>
<div class="notice notice--error">
    <strong>Bitte prüfen Sie Ihre Angaben.</strong>
    <ul>
        <?php foreach ($contactErrors as $error): ?>
            <li><?= e($error) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>
```

Der vorhandene Honeypot `website` bleibt unverändert erhalten.

## 6. Lokal mit Mailpit testen

Mailpit:

```text
SMTP: 127.0.0.1:1025
Weboberfläche: http://127.0.0.1:8025
```

Die Beispielkonfiguration ist bereits auf diesen lokalen SMTP-Port eingestellt.
Für Mailpit gilt:

```php
'auth' => false,
'encryption' => '',
```

## 7. Wichtige Funktionsregel

Die Datenbanktransaktion endet vor dem Mailversand. Dadurch bleibt die Anfrage auch dann gespeichert, wenn SMTP vorübergehend nicht erreichbar ist. Die Felder `response_mail_sent`, `notification_mail_sent` und `mail_error` zeigen den Versandstatus.
