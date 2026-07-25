# Korrektur für check_db.php/checkdb.php

## Ursache

Die Adresse

https://www.easyit-nachhilfe.de/check_db.php/checkdb.php

ruft nicht die Datei `checkdb.php` auf.

Sie ruft die alte Datei `check_db.php` auf und übergibt `/checkdb.php`
nur als sogenanntes PATH_INFO. Deshalb erscheint weiterhin die alte Ausgabe:

- Datei vorhanden
- Datei lesbar
- Konfiguration geladen
- Bereich app fehlt

## Richtige Adresse

https://www.easyit-nachhilfe.de/checkdb.php

Zwischen Domain und `checkdb.php` darf nur ein einzelner Schrägstrich stehen.

## Installation

1. `checkdb.php` ins echte Web-Root kopieren.
2. Die alte `check_db.php` löschen oder durch die mitgelieferte neue Datei ersetzen.
3. `config/config.php` ersetzen.
4. Die Regeln aus `htaccess_Zusatz.txt` in die Root-`.htaccess` übernehmen.
5. Danach exakt aufrufen:

   https://www.easyit-nachhilfe.de/checkdb.php

## Kontrollmerkmal

Die neue Datei beginnt immer mit:

=== NEUE Konfigurationsprüfung V2 ===

Fehlt dieser Text, wird weiterhin eine alte Datei oder ein anderes Web-Root aufgerufen.

## Wichtig

Wenn weiterhin die alte Ausgabe erscheint, liegt die hochgeladene Datei nicht im
Document-Root der Domain. Dann im Hosting kontrollieren, auf welches Verzeichnis
`www.easyit-nachhilfe.de` tatsächlich zeigt.
