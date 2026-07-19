# Admin-Archivierung – Sicherheitsumstellung

Die Archivierung von Inhalten ist ausschließlich per HTTP-POST möglich.

## Umgesetzte Schutzmaßnahmen

- `admin/delete.php` akzeptiert ausschließlich `POST`; andere Methoden erhalten HTTP 405.
- Jede Anfrage muss ein gültiges sitzungsgebundenes CSRF-Token enthalten.
- Die Datensatz-ID und der Inhaltstyp werden als verborgene Formularfelder übertragen.
- Vor dem Absenden erscheint ein JavaScript-Bestätigungsdialog.
- Nur Benutzer mit der Rolle `admin` dürfen archivieren.
- Für Benutzer mit der Rolle `editor` wird die Archivierungsschaltfläche nicht angezeigt.
- Serverseitig wird die Rolle unabhängig von der Oberfläche erneut geprüft.
- Erfolgreiche, übersprungene und fehlgeschlagene Archivierungsversuche werden im `audit_log` protokolliert.
- Technische Ausnahmen werden zusätzlich über `error_log()` protokolliert, ohne interne Details im Browser auszugeben.
- Nach POST-Anfragen erfolgt ein Redirect mit HTTP 303, wodurch ein erneutes Archivieren beim Neuladen verhindert wird.

## Protokollierte Aktionen

- `archive`
- `archive_skipped`
- `archive_failed`
- `archive_denied_method`
- `archive_denied_csrf`
- `archive_denied_role`
