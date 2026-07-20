# 3.9 Asset-Bereinigung

## Produktive Struktur

CSS und JavaScript liegen ausschließlich unter `nh_hor/assets/css/` und
`nh_hor/assets/js/`. Die historischen Parallelverzeichnisse `nh_hor/css/`
und `nh_hor/js/` wurden entfernt, nachdem keine produktiven Includes darauf
verwiesen.

## Content-Hashes

Alle produktiven CSS- und JavaScript-Dateien tragen einen zwölfstelligen
SHA-256-Hash im Dateinamen. Die Zuordnung von logischem Namen zu ausgelieferter
Datei steht in `nh_hor/config/asset-manifest.php`. PHP-Templates verwenden
`asset_url()`, sodass bei einer Änderung nur die Datei neu gehasht und das
Manifest angepasst werden muss.

## Cache-Regeln

Nur Dateien nach dem Muster `name.<12-hex>.css` oder `name.<12-hex>.js`
erhalten `Cache-Control: public, max-age=31536000, immutable`.
Nicht versionierte CSS-/JavaScript-Dateien, insbesondere `service-worker.js`,
erhalten `no-cache, max-age=0, must-revalidate`. Bilder werden nur kurzzeitig
zwischengespeichert.

## Service Worker

Der Cache-Name und die Core-Asset-Liste wurden auf die gehashten Dateinamen
aktualisiert. Relative Pfade sorgen dafür, dass der Service Worker sowohl in
der Produktionswurzel als auch lokal unter `/nh_hor/` funktioniert.
