# Karriere-Modul – Phase 3

## Ziel
Phase 3 überführt die bisher dateibasierte Karriere-Darstellung in eine datenbankgestützte, über den geschützten Adminbereich pflegbare Struktur. `config/jobs.php` bleibt als ausfallsichere Rückfallebene bestehen.

## Neu
- Tabellen `career_jobs`, `career_job_items`, `career_images`, `career_faq`
- Repository `includes/career-repository.php`
- Adminübersicht `admin/career-jobs.php`
- Editor `admin/career-job-edit.php`
- Pflege von Status, Reihenfolge, Texten, Fächern, Werten, Anforderungen, Profilen, Bildern und FAQ
- Entwurf/Veröffentlicht/Archiviert
- automatische Nutzung der Datenbank auf `karriere.php` und allen Detailseiten
- Konfigurationsfallback bei fehlender Datenbank oder fehlenden Tabellen

## Installation
1. Projektordner nach `C:\xampp\htdocs\nh_hor` kopieren.
2. `database/migrations/2026-07-26_career_module_phase3.sql` importieren.
3. Adminbereich öffnen: `http://localhost/nh_hor/admin/career-jobs.php`
4. Bestehende Profile öffnen und einmal speichern. Dadurch werden auch Listen, Bilder und FAQ aus der Konfiguration in die neuen Detailtabellen übernommen.
5. Frontend mit `Strg + F5` prüfen.

## Sicherheit
- Adminlogin und Adminrolle erforderlich
- CSRF-Prüfung
- Prepared Statements
- Transaktion für jedes vollständige Stellenprofil
- serverseitige Status- und URL-Validierung
- Audit-Log beim Speichern

## Weiter-Verfahren
Phase 4: echte Bild-Uploads mit Dateityp-/Größenprüfung, Drag-and-drop-Reihenfolge, Bildvorschau und weitere Fachrichtungen (Mathematik, Physik, Chemie, Informatik, Englisch und Grundschule).


## RC.1.0 – Admin-Konsolidierung

- Fehlerhaften Aufruf `verify_csrf_or_abort()` entfernt.
- Karriere-Editor verwendet nun `admin_verify_csrf_or_abort()` aus der gemeinsamen Admin-Infrastruktur.
- Die Funktion prüft POST-Methode und das bestehende `csrf_is_valid()` aus `includes/security.php`.
- Login-, Session-, Datenbank- und Audit-Funktionen bleiben vollständig an die vorhandene Adminstruktur angebunden.
