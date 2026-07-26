SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS contact_requests (
    request_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    subject VARCHAR(255) DEFAULT NULL,
    level VARCHAR(150) DEFAULT NULL,
    message TEXT NOT NULL,
    status ENUM('new','processing','answered','closed','spam') NOT NULL DEFAULT 'new',
    assigned_to BIGINT UNSIGNED DEFAULT NULL,
    response_mail_sent TINYINT(1) NOT NULL DEFAULT 0,
    notification_mail_sent TINYINT(1) NOT NULL DEFAULT 0,
    mail_error TEXT DEFAULT NULL,
    source_page VARCHAR(255) NOT NULL DEFAULT '/kontakt.php',
    ip_hash CHAR(64) DEFAULT NULL,
    user_agent VARCHAR(500) DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (request_id),
    KEY idx_contact_status_created (status, created_at),
    KEY idx_contact_email (email),
    KEY idx_contact_assigned (assigned_to)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
