CREATE DATABASE IF NOT EXISTS easyit
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE easyit;

CREATE TABLE IF NOT EXISTS admin_users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80) NOT NULL UNIQUE,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','editor') NOT NULL DEFAULT 'editor',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    last_login_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS content_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content_type ENUM('faq','review','job','blog') NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(190) NOT NULL,
    excerpt TEXT NULL,
    body LONGTEXT NOT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description VARCHAR(320) NULL,
    review_date DATE NULL,
    reviewer_name VARCHAR(120) NULL,
    reviewer_age SMALLINT UNSIGNED NULL,
    reviewer_school_type VARCHAR(120) NULL,
    status ENUM('draft','published','archived') NOT NULL DEFAULT 'draft',
    sort_order INT NOT NULL DEFAULT 0,
    featured TINYINT(1) NOT NULL DEFAULT 0,
    published_at DATETIME NULL,
    created_by BIGINT UNSIGNED NULL,
    updated_by BIGINT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_content_type_slug (content_type, slug),
    KEY idx_content_type_status (content_type, status),
    KEY idx_published_at (published_at),
    CONSTRAINT fk_content_created_by FOREIGN KEY (created_by) REFERENCES admin_users(id) ON DELETE SET NULL,
    CONSTRAINT fk_content_updated_by FOREIGN KEY (updated_by) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS content_revisions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content_item_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT NULL,
    body LONGTEXT NOT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description VARCHAR(320) NULL,
    review_date DATE NULL,
    reviewer_name VARCHAR(120) NULL,
    reviewer_age SMALLINT UNSIGNED NULL,
    reviewer_school_type VARCHAR(120) NULL,
    status ENUM('draft','published','archived') NOT NULL,
    changed_by BIGINT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_revision_item FOREIGN KEY (content_item_id) REFERENCES content_items(id) ON DELETE CASCADE,
    CONSTRAINT fk_revision_user FOREIGN KEY (changed_by) REFERENCES admin_users(id) ON DELETE SET NULL,
    KEY idx_revision_item (content_item_id, created_at)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS audit_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(80) NOT NULL,
    entity_type VARCHAR(80) NOT NULL,
    entity_id BIGINT UNSIGNED NULL,
    details JSON NULL,
    ip_hash CHAR(64) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_audit_user FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE SET NULL,
    KEY idx_audit_entity (entity_type, entity_id),
    KEY idx_audit_created_at (created_at)
) ENGINE=MyISAM;
