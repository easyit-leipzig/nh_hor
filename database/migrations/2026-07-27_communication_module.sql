START TRANSACTION;

CREATE TABLE IF NOT EXISTS communication_messages (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    sender_admin_id BIGINT UNSIGNED NULL,
    recipient_admin_id BIGINT UNSIGNED NULL,
    recipient_email VARCHAR(320) NULL,
    channel ENUM('internal','email','both') NOT NULL DEFAULT 'internal',
    subject VARCHAR(255) NOT NULL,
    body MEDIUMTEXT NOT NULL,
    status ENUM('created','sent','failed') NOT NULL DEFAULT 'created',
    error_message TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    sent_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    KEY idx_communication_messages_status (status, created_at),
    KEY idx_communication_messages_recipient (recipient_admin_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS communication_delivery_log (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    message_id BIGINT UNSIGNED NULL,
    recipient_email VARCHAR(320) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    transport VARCHAR(30) NOT NULL,
    success TINYINT(1) NOT NULL DEFAULT 0,
    error_message TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_communication_delivery_created (created_at),
    KEY idx_communication_delivery_success (success, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;
