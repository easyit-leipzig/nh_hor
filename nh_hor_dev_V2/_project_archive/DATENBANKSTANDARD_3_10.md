# Datenbankstandard 3.10

## Verbindlicher Zielstand

Produktiv wird ausschließlich **InnoDB** mit `utf8mb4_unicode_ci` verwendet. Das einzige Basisschema für Neuinstallationen ist:

```text
database/schema.sql
```

Die lineare Upgrade-Kette liegt unter:

```text
database/migrations/
```

Reihenfolge:

1. `20260716_001_content_indexes.sql`
2. `20260717_002_review_metadata.sql`
3. `20260718_003_tutoren.sql`
4. `20260718_004_tutor_bewertungen.sql`
5. `20260720_005_innodb_normalisierung.sql`

MyISAM-Schemas, alte Gesamtstandsarchive und parallele Installationsvarianten wurden entfernt.

## Neuinstallation

1. `database/schema.sql` mit einem Datenbankkonto ausführen, das Tabellen und Fremdschlüssel anlegen darf.
2. Konfiguration außerhalb des Webroots bereitstellen.
3. Optional den Status prüfen:

```bash
php database/migrate.php status
php database/check.php
```

## Bestehende Installation aktualisieren

Vorher ein geprüftes Backup erstellen. Danach außerhalb des Webroots ausführen:

```bash
php database/migrate.php up
php database/migrate.php status
php database/check.php
```

Der Runner:

- sortiert Migrationen lexikografisch und führt sie genau einmal aus;
- verwendet eine Datenbanksperre gegen parallele Ausführung;
- speichert SHA-256-Prüfsumme, Status, Beginn, Ende, Laufzeit und Fehlertext;
- verweigert nachträglich veränderte, bereits ausgeführte Migrationen;
- markiert Fehler dauerhaft mit `failed`;
- prüft vor dem Ergänzen der Tutor-Fremdschlüssel auf verwaiste Datensätze.

MariaDB/MySQL können bei DDL-Anweisungen implizit committen. Deshalb werden reine DDL-Migrationen ausdrücklich als nicht vollständig transaktional geführt. Transaktionen werden nur bei Migrationen aktiviert, die mit `-- @transactional true` gekennzeichnet und dafür geeignet sind. Der Statusdatensatz macht auch DDL-Fehler nachvollziehbar und wiederholbar.

## Deployment

Der komplette Ordner `_project_archive/database/` ist **kein Bestandteil des öffentlichen Webroots**. Auf den Webserver-Webroot gehört ausschließlich `nh_hor/`. SQL-Dateien und Installationswerkzeuge dürfen nur in einem nicht öffentlich erreichbaren Administrations-/Deploymentbereich liegen.
