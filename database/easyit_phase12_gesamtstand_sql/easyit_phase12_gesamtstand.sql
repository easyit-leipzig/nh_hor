-- ============================================================
-- easyIT Nachhilfe Leipzig
-- Konsolidierter SQL-Gesamtdump nach Phase 12
-- Zielsystem: MySQL 8.x / MariaDB (XAMPP)
-- Datenbank: easyit
-- Erstellt: 2026-07-17
-- ============================================================

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET time_zone = '+00:00';
SET FOREIGN_KEY_CHECKS = 0;
SET UNIQUE_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `easyit`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `easyit`;

-- Bestehende Tabellen vollständig ersetzen.
DROP TABLE IF EXISTS `audit_log`;
DROP TABLE IF EXISTS `content_revisions`;
DROP TABLE IF EXISTS `content_items`;
DROP TABLE IF EXISTS `schema_migrations`;
DROP TABLE IF EXISTS `admin_users`;

-- ------------------------------------------------------------
-- Administratoren und Redakteure
-- ------------------------------------------------------------
CREATE TABLE `admin_users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(80) NOT NULL,
    `email` VARCHAR(190) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('admin','editor') NOT NULL DEFAULT 'editor',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `last_login_at` DATETIME NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_admin_users_username` (`username`),
    UNIQUE KEY `uq_admin_users_email` (`email`),
    KEY `idx_admin_users_active_role` (`is_active`,`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- CMS-Inhalte: FAQ, Bewertungen, Jobs und Blog
-- ------------------------------------------------------------
CREATE TABLE `content_items` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `content_type` ENUM('faq','review','job','blog') NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(190) NOT NULL,
    `excerpt` TEXT NULL,
    `body` LONGTEXT NOT NULL,
    `meta_title` VARCHAR(255) NULL,
    `meta_description` VARCHAR(320) NULL,
    `canonical_url` VARCHAR(255) NULL,
    `og_image` VARCHAR(255) NULL,
    `review_date` DATE NULL,
    `reviewer_name` VARCHAR(120) NULL,
    `reviewer_age` SMALLINT UNSIGNED NULL,
    `reviewer_school_type` VARCHAR(120) NULL,
    `status` ENUM('draft','published','archived') NOT NULL DEFAULT 'draft',
    `sort_order` INT NOT NULL DEFAULT 0,
    `featured` TINYINT(1) NOT NULL DEFAULT 0,
    `published_at` DATETIME NULL,
    `created_by` BIGINT UNSIGNED NULL,
    `updated_by` BIGINT UNSIGNED NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_content_type_slug` (`content_type`,`slug`),
    KEY `idx_content_type_status` (`content_type`,`status`),
    KEY `idx_published_at` (`published_at`),
    KEY `idx_content_featured` (`content_type`,`status`,`featured`,`sort_order`),
    KEY `idx_content_review_date` (`content_type`,`review_date`),
    CONSTRAINT `fk_content_created_by`
        FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk_content_updated_by`
        FOREIGN KEY (`updated_by`) REFERENCES `admin_users` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Revisionshistorie der CMS-Inhalte
-- ------------------------------------------------------------
CREATE TABLE `content_revisions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `content_item_id` BIGINT UNSIGNED NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `excerpt` TEXT NULL,
    `body` LONGTEXT NOT NULL,
    `meta_title` VARCHAR(255) NULL,
    `meta_description` VARCHAR(320) NULL,
    `canonical_url` VARCHAR(255) NULL,
    `og_image` VARCHAR(255) NULL,
    `review_date` DATE NULL,
    `reviewer_name` VARCHAR(120) NULL,
    `reviewer_age` SMALLINT UNSIGNED NULL,
    `reviewer_school_type` VARCHAR(120) NULL,
    `status` ENUM('draft','published','archived') NOT NULL,
    `changed_by` BIGINT UNSIGNED NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_revision_item` (`content_item_id`,`created_at`),
    KEY `idx_revision_user` (`changed_by`),
    CONSTRAINT `fk_revision_item`
        FOREIGN KEY (`content_item_id`) REFERENCES `content_items` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_revision_user`
        FOREIGN KEY (`changed_by`) REFERENCES `admin_users` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Administratives Audit-Protokoll
-- ------------------------------------------------------------
CREATE TABLE `audit_log` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` BIGINT UNSIGNED NULL,
    `action` VARCHAR(80) NOT NULL,
    `entity_type` VARCHAR(80) NOT NULL,
    `entity_id` BIGINT UNSIGNED NULL,
    `details` JSON NULL,
    `ip_hash` CHAR(64) NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_audit_entity` (`entity_type`,`entity_id`),
    KEY `idx_audit_created_at` (`created_at`),
    KEY `idx_audit_user` (`user_id`),
    CONSTRAINT `fk_audit_user`
        FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Ausgeführte Migrationen
-- ------------------------------------------------------------
CREATE TABLE `schema_migrations` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(190) NOT NULL,
    `executed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_schema_migrations_migration` (`migration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `schema_migrations` (`migration`, `executed_at`) VALUES
('20260716_001_content_indexes.sql', CURRENT_TIMESTAMP),
('20260717_002_review_metadata.sql', CURRENT_TIMESTAMP);

-- Die Website erzeugt den ersten Administrator sicher über:
-- php C:\xampp\htdocs\nh_seo\database\create-admin.php
-- Deshalb enthält dieser Dump bewusst kein voreingestelltes Passwort.

SET UNIQUE_CHECKS = 1;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- Ende des konsolidierten Dumps
-- ============================================================
