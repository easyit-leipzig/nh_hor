# Deployment nach Punkt 3.8

Auf den Webserver gehört ausschließlich der Inhalt des Ordners `nh_hor/`.
Der Ordner `_project_archive/` enthält Dokumentation, SQL-Dateien, Migrationswerkzeuge,
Blog-Quelldateien, Projektdateien und Konfigurationsbeispiele und darf nicht innerhalb
des öffentlich erreichbaren Webroots bereitgestellt werden.

Die in Stand 3.7 reparierte localhost-Erkennung und `base_path`-Logik wurde unverändert
beibehalten. Dadurch funktionieren CSS, JavaScript, Bilder und interne Links weiterhin
unter `http://localhost/nh_hor/`.

Vor dem produktiven Deployment ist `.htaccess.server` entsprechend der Hosting-Umgebung
als aktive Root-`.htaccess` einzusetzen, falls dies noch nicht erfolgt ist.
