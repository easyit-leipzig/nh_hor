-- Revision V3.9: Personenbezogene Kontaktmöglichkeiten

CREATE TABLE IF NOT EXISTS contacts (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  to_person BIGINT UNSIGNED NOT NULL,
  type VARCHAR(40) NOT NULL,
  label VARCHAR(120) NOT NULL DEFAULT '',
  contact_value VARCHAR(500) NOT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  is_primary TINYINT(1) NOT NULL DEFAULT 0,
  sort_order INT UNSIGNED NOT NULL DEFAULT 100,
  valid_from DATE NULL,
  valid_until DATE NULL,
  notes VARCHAR(500) NOT NULL DEFAULT '',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_contacts_person (to_person),
  KEY idx_contacts_type_active (type, active),
  KEY idx_contacts_person_sort (to_person, sort_order, id),
  KEY idx_contacts_primary (to_person, type, is_primary),
  CONSTRAINT fk_contacts_person
    FOREIGN KEY (to_person) REFERENCES imprint_persons(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT chk_contacts_type CHECK (type REGEXP '^[a-z][a-z0-9_-]{1,39}$'),
  CONSTRAINT chk_contacts_active CHECK (active IN (0,1)),
  CONSTRAINT chk_contacts_primary CHECK (is_primary IN (0,1)),
  CONSTRAINT chk_contacts_validity CHECK (valid_until IS NULL OR valid_from IS NULL OR valid_until >= valid_from)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
