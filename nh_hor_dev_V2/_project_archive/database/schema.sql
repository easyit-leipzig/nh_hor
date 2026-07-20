-- easyIT – kanonisches Produktionsschema
-- Zielsystem: MariaDB 10.4+ / MySQL 8+, ausschließlich InnoDB und utf8mb4.
-- Für Neuinstallationen. Bestehende Installationen werden über database/migrate.php aktualisiert.

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS content_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content_type ENUM('faq','review','job','blog') NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(190) NOT NULL,
    excerpt TEXT NULL,
    body LONGTEXT NOT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description VARCHAR(320) NULL,
    canonical_url VARCHAR(255) NULL,
    og_image VARCHAR(255) NULL,
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
    KEY idx_content_featured (content_type, status, featured, sort_order),
    KEY idx_published_at (published_at),
    CONSTRAINT fk_content_created_by FOREIGN KEY (created_by) REFERENCES admin_users(id) ON DELETE SET NULL,
    CONSTRAINT fk_content_updated_by FOREIGN KEY (updated_by) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
    KEY idx_revision_item (content_item_id, created_at),
    CONSTRAINT fk_revision_item FOREIGN KEY (content_item_id) REFERENCES content_items(id) ON DELETE CASCADE,
    CONSTRAINT fk_revision_user FOREIGN KEY (changed_by) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS audit_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(80) NOT NULL,
    entity_type VARCHAR(80) NOT NULL,
    entity_id BIGINT UNSIGNED NULL,
    details JSON NULL,
    ip_hash CHAR(64) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_audit_entity (entity_type, entity_id),
    KEY idx_audit_created_at (created_at),
    CONSTRAINT fk_audit_user FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS tutors (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(160) NOT NULL,
    display_name VARCHAR(160) NOT NULL,
    professional_title VARCHAR(190) NOT NULL,
    short_intro TEXT NOT NULL,
    biography TEXT NOT NULL,
    teaching_approach TEXT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    image_alt VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_tutors_slug (slug),
    KEY idx_tutors_active_sort (is_active, sort_order, display_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS tutor_competencies (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tutor_id INT UNSIGNED NOT NULL,
    category ENUM('fach','methodik','didaktik','faehigkeit','qualifikation') NOT NULL,
    title VARCHAR(190) NOT NULL,
    description TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    KEY idx_tutor_competencies (tutor_id, category, sort_order),
    CONSTRAINT fk_tutor_competencies_tutor FOREIGN KEY (tutor_id) REFERENCES tutors(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS tutor_reviews (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tutor_id INT UNSIGNED NOT NULL,
    reviewer_name VARCHAR(120) NOT NULL,
    reviewer_context VARCHAR(190) NULL,
    review_date DATE NOT NULL,
    stars TINYINT UNSIGNED NOT NULL DEFAULT 5,
    review_text TEXT NOT NULL,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_tutor_reviews_public (tutor_id, is_published, review_date),
    KEY idx_tutor_reviews_stars (tutor_id, stars),
    CONSTRAINT fk_tutor_reviews_tutor FOREIGN KEY (tutor_id) REFERENCES tutors(id) ON DELETE CASCADE,
    CONSTRAINT chk_tutor_reviews_stars CHECK (stars BETWEEN 1 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS schema_migrations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(190) NOT NULL UNIQUE,
    checksum CHAR(64) NOT NULL,
    status ENUM('running','applied','failed') NOT NULL,
    started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    finished_at DATETIME NULL,
    duration_ms INT UNSIGNED NULL,
    error_message TEXT NULL,
    KEY idx_schema_migrations_status (status, started_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
