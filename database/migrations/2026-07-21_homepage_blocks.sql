-- Homepage-Blöcke für die Administrationsoberfläche
CREATE TABLE IF NOT EXISTS homepage_blocks (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    block_type VARCHAR(50) NOT NULL DEFAULT 'neu',
    title VARCHAR(255) NOT NULL,
    content TEXT NULL,
    image VARCHAR(1000) NULL,
    button_text VARCHAR(255) NULL,
    button_url VARCHAR(1000) NULL,
    position INT NOT NULL DEFAULT 0,
    active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_homepage_blocks_active_position (active, position)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
