# Migration von nh_seo nach nh_hor

Die vollständige Seiten-, SEO-, Admin-, Blog-, Werkzeug- und Datenbankstruktur aus `nh_seo` wurde übernommen. Die vertikale Seitenleiste wurde durch ein responsives horizontales Hauptmenü mit bis zu drei Ebenen ersetzt.

## Installation

1. Ordner als `htdocs/nh_hor` ablegen.
2. Datenbankzugang in `config/database.php` prüfen.
3. Bestehendes Schema aus `database/schema_myisam.sql` importieren.
4. Optional `database/menu_horizontal_myisam.sql` importieren, wenn die Menüeinträge auch in der Datenbank gepflegt werden sollen.
5. Aufruf: `http://localhost/nh_hor/`.

Kontakt und Anmelden bleiben als farbige Kopfzeilenaktionen außerhalb des Hauptmenüs.
