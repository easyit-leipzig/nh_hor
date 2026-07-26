/* ============================================================
   easyIT / nh_hor – Bildnachweis V2
   Angepasst an die vorhandene Tabelle navigation_items:
   id, parent_id, title, url, sort_order, is_active,
   created_at, updated_at
   ============================================================ */

START TRANSACTION;

CREATE TABLE IF NOT EXISTS image_credits
(
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    image_name VARCHAR(255) NOT NULL,
    image_path VARCHAR(500) DEFAULT NULL,

    credit_from VARCHAR(255) DEFAULT NULL COMMENT 'von',
    credit_to VARCHAR(255) DEFAULT NULL COMMENT 'bis',
    page_name VARCHAR(255) NOT NULL COMMENT 'Seite',
    page_url VARCHAR(500) DEFAULT NULL,
    index_nr INT UNSIGNED DEFAULT NULL COMMENT 'Indexnummer oder Position',

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

/* Hauptpunkt Sonstiges ermitteln. */
SET @nav_sonstiges := NULL;
SELECT id INTO @nav_sonstiges
FROM navigation_items
WHERE parent_id IS NULL
  AND title = 'Sonstiges'
  AND is_active = 1
ORDER BY id
LIMIT 1;

/* Bildnachweis nur einfügen, wenn Sonstiges existiert. */
INSERT INTO navigation_items
(
    parent_id,
    title,
    url,
    sort_order,
    is_active
)
SELECT
    @nav_sonstiges,
    'Bildnachweis',
    '/bildnachweis.php',
    80,
    1
WHERE @nav_sonstiges IS NOT NULL
  AND NOT EXISTS
  (
      SELECT 1
      FROM navigation_items
      WHERE parent_id = @nav_sonstiges
        AND (title = 'Bildnachweis' OR url = '/bildnachweis.php')
  );

/* Vorhandenen Eintrag korrigieren/aktivieren. */
UPDATE navigation_items
SET
    parent_id = @nav_sonstiges,
    title = 'Bildnachweis',
    url = '/bildnachweis.php',
    sort_order = 80,
    is_active = 1
WHERE @nav_sonstiges IS NOT NULL
  AND (title = 'Bildnachweis'
       OR url IN ('/bildnachweis.php', '/nh_hor/bildnachweis.php'));

/* Inaktiver Musterdatensatz. */
INSERT INTO image_credits
(
    image_name, image_path, credit_from, credit_to,
    page_name, page_url, index_nr,
    author_name, source_name, license_name, note, active
)
SELECT
    'beispielbild.jpg',
    'assets/img/beispielbild.jpg',
    'Bildanfang',
    'Bildende',
    'Startseite',
    '/index.php',
    1,
    'Urheber eintragen',
    'Quelle eintragen',
    'Lizenz eintragen',
    'Musterdatensatz vor Veröffentlichung bearbeiten oder löschen.',
    0
WHERE NOT EXISTS
(
    SELECT 1 FROM image_credits
    WHERE image_name = 'beispielbild.jpg'
      AND page_name = 'Startseite'
);

/* Migration registrieren – Schema ist im aktuellen easyit-Dump vorhanden. */
INSERT INTO schema_migrations
(
    migration,
    checksum,
    status,
    finished_at
)
SELECT
    '2026-07-23_image_credits_v2',
    SHA2('2026-07-23_image_credits_v2', 256),
    'completed',
    NOW()
WHERE NOT EXISTS
(
    SELECT 1 FROM schema_migrations
    WHERE migration = '2026-07-23_image_credits_v2'
);

COMMIT;

SELECT id, parent_id, title, url, sort_order, is_active
FROM navigation_items
WHERE title = 'Bildnachweis';

SELECT COUNT(*) AS image_credits_count
FROM image_credits;
