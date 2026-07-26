-- nh_hor: WYSIWYG-CSS-Editor für Homepage-Block-Kacheln
-- Einmalig in der bestehenden Datenbank ausführen.
SET NAMES utf8mb4;

ALTER TABLE `homepage_blocks`
    ADD COLUMN IF NOT EXISTS `style_json` LONGTEXT NULL AFTER `valid_until`,
    ADD COLUMN IF NOT EXISTS `custom_css` TEXT NULL AFTER `style_json`;
