-- ============================================================
-- nh_hor – Adminbereich / Homepage-Blöcke
-- Vollständige, direkt importierbare SQL-Datei
-- Erstellt für MariaDB/MySQL, Zeichensatz utf8mb4
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `homepage_blocks` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `block_type` VARCHAR(50) NOT NULL DEFAULT 'neu',
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NULL,
    `image` VARCHAR(1000) NULL,
    `button_text` VARCHAR(255) NULL,
    `button_url` VARCHAR(1000) NULL,
    `position` INT NOT NULL DEFAULT 0,
    `active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_homepage_blocks_active_position` (`active`, `position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `homepage_blocks`
(`block_type`,`title`,`content`,`image`,`button_text`,`button_url`,`position`,`active`)
SELECT
'neu','NEU: Prüfungsvorbereitung',
'Gezielte Vorbereitung auf Klassenarbeiten und Prüfungen.',
'/nh_hor/assets/img/stud-lern.png','Mehr erfahren','/nh_hor/kontakt.php',1,1
WHERE NOT EXISTS (
    SELECT 1 FROM `homepage_blocks`
    WHERE `title` = 'NEU: Prüfungsvorbereitung'
);

INSERT INTO `homepage_blocks`
(`block_type`,`title`,`content`,`image`,`button_text`,`button_url`,`position`,`active`)
SELECT
'veranstaltung','Mathe Workshop',
'Intensiver Workshop für Schülerinnen und Schüler.',
'/nh_hor/assets/img/subjects/mathe.svg','Anmelden','/nh_hor/kontakt.php',2,1
WHERE NOT EXISTS (
    SELECT 1 FROM `homepage_blocks`
    WHERE `title` = 'Mathe Workshop'
);

INSERT INTO `homepage_blocks`
(`block_type`,`title`,`content`,`image`,`button_text`,`button_url`,`position`,`active`)
SELECT
'veranstaltung','Ferienkurs Sommer',
'Lernen in den Ferien mit klarer Struktur.',
'/nh_hor/assets/img/lern-stud.svg','Infos','/nh_hor/kontakt.php',3,1
WHERE NOT EXISTS (
    SELECT 1 FROM `homepage_blocks`
    WHERE `title` = 'Ferienkurs Sommer'
);

INSERT INTO `homepage_blocks`
(`block_type`,`title`,`content`,`image`,`button_text`,`button_url`,`position`,`active`)
SELECT
'gutschein','Nachhilfe verschenken',
'Ein Gutschein für individuelle Unterstützung.',
'/nh_hor/assets/img/gutschein.png','Gutschein anfragen','/nh_hor/kontakt.php',4,1
WHERE NOT EXISTS (
    SELECT 1 FROM `homepage_blocks`
    WHERE `title` = 'Nachhilfe verschenken'
);

INSERT INTO `homepage_blocks`
(`block_type`,`title`,`content`,`image`,`button_text`,`button_url`,`position`,`active`)
SELECT
'neu','Neue Lernwerkzeuge',
'Digitale Hilfen für besseres Lernen.',
'/nh_hor/assets/img/lern-stud.svg','Entdecken','/nh_hor/lernwerkzeuge.php',5,1
WHERE NOT EXISTS (
    SELECT 1 FROM `homepage_blocks`
    WHERE `title` = 'Neue Lernwerkzeuge'
);

SET FOREIGN_KEY_CHECKS = 1;
