# 3.11 Kontaktformular: SMTP, Protokollierung und Datenschutz

## SMTP-Konfiguration

Die Zugangsdaten gehören außerhalb des Webroots in `forms.local.php` oder in Umgebungsvariablen:

- `MAIL_ENABLED=true`
- `MAIL_RECIPIENT=...`
- `MAIL_SENDER=...`
- `MAIL_SENDER_NAME=easyIT Website`
- `SMTP_HOST=...`
- `SMTP_PORT=587`
- `SMTP_ENCRYPTION=tls`
- `SMTP_USERNAME=...`
- `SMTP_PASSWORD=...`
- `SMTP_TIMEOUT=15`
- `CONTACT_LOG_RETENTION_DAYS=30`

Der SMTP-Absender muss zur authentifizierten Domain passen. Die Adresse des Formularabsenders wird ausschließlich als `Reply-To` gesetzt.

## Ereignisprotokoll

`storage/contact-events.log` enthält ausschließlich Zeitpunkt, Ereignistyp, Erfolgsstatus und einen begrenzten technischen Fehlercode. Personenbezogene Formularfelder, IP-Adresse, User-Agent und Fingerprints werden nicht protokolliert. Bei jedem Formularversand werden Einträge gelöscht, die älter als die konfigurierte Frist sind.

## DNS-Einstellungen

SPF, DKIM und DMARC können nicht im PHP-Projekt gesetzt werden. Sie müssen beim DNS- beziehungsweise Mailanbieter eingerichtet werden:

- SPF: nur tatsächlich versendende SMTP-Systeme autorisieren; nur einen SPF-TXT-Record je Domain verwenden.
- DKIM: öffentlichen Schlüssel des Mailanbieters unter dessen Selector veröffentlichen und Signierung aktivieren.
- DMARC: zunächst Berichtsmodus (`p=none`) mit einer kontrollierten Berichtadresse; nach erfolgreicher Prüfung schrittweise `quarantine` oder `reject`.

Die konkreten Recordwerte müssen vom eingesetzten Mailanbieter stammen und dürfen nicht erfunden werden.

## Zustellstatus

Die Anwendung bestätigt nur die erfolgreiche SMTP-Übergabe. Eine endgültige Zustellung kann erst durch spätere Bounce-/Feedback-Verarbeitung festgestellt werden.
