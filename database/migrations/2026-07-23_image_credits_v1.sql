/* ============================================================
   easyIT Nachhilfe Leipzig / nh_hor
   Migration: datenbankgestützter Bildnachweis
   Version: 1.0
   ============================================================ */

START TRANSACTION;

CREATE TABLE IF NOT EXISTS image_credits
(
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    image_name VARCHAR(255) NOT NULL,
    image_path VARCHAR(500) DEFAULT NULL,

    /* Pflichtfelder laut Anforderung */
    credit_from VARCHAR(255) DEFAULT NULL COMMENT 'Von / Beginn / Herkunft',
    credit_to VARCHAR(255) DEFAULT NULL COMMENT 'Bis / Ende / Ziel',
    page_name VARCHAR(255) NOT NULL COMMENT 'Bezeichnung der verwendenden Seite',
    page_url VARCHAR(500) DEFAULT NULL,
    index_nr INT UNSIGNED DEFAULT NULL,

    author_name VARCHAR(255) DEFAULT NULL,
    author_url VARCHAR(500) DEFAULT NULL,

    source_name VARCHAR(255) DEFAULT NULL,
    source_url VARCHAR(500) DEFAULT NULL,

    license_name VARCHAR(255) DEFAULT NULL,
    license_url VARCHAR(500) DEFAULT NULL,

    note TEXT DEFAULT NULL,

    valid_from DATE DEFAULT NULL,
    valid_until DATE DEFAULT NULL,

    active TINYINT(1) NOT NULL DEFAULT 1,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY idx_image_credits_active (active),
    KEY idx_image_credits_page (page_name),
    KEY idx_image_credits_index_nr (index_nr),
    KEY idx_image_credits_validity (valid_from, valid_until)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


/* ------------------------------------------------------------
   Menüpunkt unter bestehendem Hauptpunkt „Sonstiges“ anlegen.
   Unterstützt das bekannte Schema:
   menu_items(id,parent_id,title,url,target,css_class,sort_order,is_active)
   ------------------------------------------------------------ */

SET @sonstiges_id =
(
    SELECT id
    FROM menu_items
    WHERE title = 'Sonstiges'
      AND is_active = 1
    ORDER BY id
    LIMIT 1
);

INSERT INTO menu_items
(
    parent_id,
    title,
    url,
    target,
    css_class,
    sort_order,
    is_active
)
SELECT
    @sonstiges_id,
    'Bildnachweis',
    '/nh_hor/bildnachweis.php',
    '_self',
    NULL,
    90,
    1
WHERE @sonstiges_id IS NOT NULL
  AND NOT EXISTS
  (
      SELECT 1
      FROM menu_items
      WHERE title = 'Bildnachweis'
         OR url IN ('/nh_hor/bildnachweis.php', '/bildnachweis.php')
  );


/* ------------------------------------------------------------
   Beispiel-Datensatz – bewusst inaktiv.
   Nach dem Ergänzen der echten Daten active auf 1 setzen.
   ------------------------------------------------------------ */

INSERT INTO image_credits
(
    image_name,
    image_path,
    credit_from,
    credit_to,
    page_name,
    page_url,
    index_nr,
    author_name,
    author_url,
    source_name,
    source_url,
    license_name,
    license_url,
    note,
    active
)
SELECT
    'beispielbild.jpg',
    'assets/img/beispielbild.jpg',
    'Start des Bildbereichs',
    'Ende des Bildbereichs',
    'Startseite',
    '/nh_hor/index.php',
    1,
    'Name des Urhebers',
    NULL,
    'Name der Quelle',
    NULL,
    'Lizenzbezeichnung',
    NULL,
    'Beispieldatensatz – vor Veröffentlichung ersetzen oder löschen.',
    0
WHERE NOT EXISTS
(
    SELECT 1
    FROM image_credits
    WHERE image_name = 'beispielbild.jpg'
      AND page_name = 'Startseite'
);


/* ------------------------------------------------------------
   Optionale Migrationsregistrierung.
   Nur ausführen, wenn schema_migrations die Spalte migration besitzt.
   Im nh_hor-Dump vom 22.07.2026 ist dieses Schema dokumentiert.
   ------------------------------------------------------------ */

SET @migration_name = '2026-07-23_image_credits_v1';

INSERT INTO schema_migrations
(
    migration,
    checksum,
    status,
    finished_at
)
SELECT
    @migration_name,
    SHA2(@migration_name, 256),
    'completed',
    NOW()
WHERE EXISTS
(
    SELECT 1
    FROM information_schema.columns
    WHERE table_schema = DATABASE()
      AND table_name = 'schema_migrations'
      AND column_name = 'migration'
)
AND NOT EXISTS
(
    SELECT 1
    FROM schema_migrations
    WHERE migration = @migration_name
);

COMMIT;
