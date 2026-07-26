-- Revision V3.8: Zentrale Unternehmensdaten für Impressum
CREATE TABLE IF NOT EXISTS imprint_company (
 id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
 role_id BIGINT UNSIGNED NOT NULL,
 company VARCHAR(190) NOT NULL,
 prefix VARCHAR(120) NOT NULL DEFAULT '',
 suffix VARCHAR(255) NOT NULL DEFAULT '',
 created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY(id),
 KEY idx_imprint_company_role(role_id),
 CONSTRAINT fk_imprint_company_role FOREIGN KEY(role_id)
  REFERENCES imprint_roles(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO imprint_company(role_id,company,prefix,suffix)
SELECT r.id,'easyIT Nachhilfe Leipzig','', 'Kleinunternehmen nach § 19 UStG'
FROM imprint_roles r
WHERE r.role='company'
AND NOT EXISTS (SELECT 1 FROM imprint_company);
