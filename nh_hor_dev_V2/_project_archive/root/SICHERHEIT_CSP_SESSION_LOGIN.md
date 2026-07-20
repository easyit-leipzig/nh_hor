# Punkt 3.7 – CSP, Session-Cookies und Login-Härtung

## Content Security Policy

Standardmäßig wird die CSP über `CSP_MODE=report-only` als `Content-Security-Policy-Report-Only` ausgeliefert. Nach Prüfung der Browser-Konsole wird sie mit `CSP_MODE=enforce` aktiviert. `CSP_MODE=off` deaktiviert sie nur für die Fehlersuche.

Die Policy beschränkt Ressourcen grundsätzlich auf dieselbe Herkunft, verbietet Plugins und fremde Frames und verwendet für notwendige Inline-Skripte einen pro Request erzeugten Nonce. Inline-CSS bleibt wegen vorhandener Style-Attribute vorerst erlaubt.

## Session-Sicherheit

- `HttpOnly`: aktiv
- `SameSite=Lax`: aktiv
- `Secure`: bei HTTPS aktiv, auf localhost ohne HTTPS bewusst aus
- ausschließlich Cookies, keine Session-ID in URLs
- Strict Mode aktiv
- Inaktivitäts-Timeout: 30 Minuten
- absolute Laufzeit: 8 Stunden
- Session-ID wird nach erfolgreichem Login erneuert

## Loginbegrenzung

Pro Kombination aus Client-Fingerabdruck und normalisiertem Benutzernamen sind höchstens fünf Fehlversuche innerhalb von 15 Minuten möglich. Danach gilt eine Sperre von 15 Minuten. Die Zustände liegen serverseitig unter `storage/security/login-attempts.json`; das Verzeichnis ist über Apache bereits öffentlich gesperrt.

Erfolgreiche, fehlgeschlagene und begrenzte Loginversuche werden im bestehenden `audit_log` protokolliert. Benutzername und IP-Adresse werden bei Fehlschlägen nur gehasht gespeichert.
