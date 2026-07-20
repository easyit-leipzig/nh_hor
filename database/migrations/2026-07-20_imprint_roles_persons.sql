-- Revision V3.7, Schritt 1: Rollen- und Personenverwaltung für Impressum/Adressnennung

CREATE TABLE IF NOT EXISTS imprint_roles (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  role ENUM('admin','company','personal','tutor','other') NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_imprint_roles_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS imprint_persons (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  to_role BIGINT UNSIGNED NOT NULL,
  saturation VARCHAR(40) NOT NULL DEFAULT '',
  title VARCHAR(120) NOT NULL DEFAULT '',
  firstname VARCHAR(120) NOT NULL,
  lastname VARCHAR(120) NOT NULL,
  PRIMARY KEY (id),
  KEY idx_imprint_persons_role (to_role),
  CONSTRAINT fk_imprint_persons_role
    FOREIGN KEY (to_role) REFERENCES imprint_roles(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO imprint_roles (role) VALUES
  ('admin'), ('company'), ('personal'), ('tutor'), ('other')
ON DUPLICATE KEY UPDATE role = VALUES(role);

-- Administrator / rechtlich verantwortliche Namensform
INSERT INTO imprint_persons (to_role, saturation, title, firstname, lastname)
SELECT r.id, 'Herr', 'Dipl.-Ing.', 'Olaf', 'Thiele'
FROM imprint_roles r
WHERE r.role = 'admin'
  AND NOT EXISTS (
    SELECT 1 FROM imprint_persons p
    WHERE p.to_role = r.id AND p.saturation = 'Herr' AND p.title = 'Dipl.-Ing.'
      AND p.firstname = 'Olaf' AND p.lastname = 'Thiele'
  );

-- Persönliche Namensform
INSERT INTO imprint_persons (to_role, saturation, title, firstname, lastname)
SELECT r.id, 'Herr', 'Dipl.-Ing.', 'Olaf', 'Thiele'
FROM imprint_roles r
WHERE r.role = 'personal'
  AND NOT EXISTS (
    SELECT 1 FROM imprint_persons p
    WHERE p.to_role = r.id AND p.saturation = 'Herr' AND p.title = 'Dipl.-Ing.'
      AND p.firstname = 'Olaf' AND p.lastname = 'Thiele'
  );

-- Tutor-Namensform ohne akademischen Titel
INSERT INTO imprint_persons (to_role, saturation, title, firstname, lastname)
SELECT r.id, 'Herr', '', 'Olaf', 'Thiele'
FROM imprint_roles r
WHERE r.role = 'tutor'
  AND NOT EXISTS (
    SELECT 1 FROM imprint_persons p
    WHERE p.to_role = r.id AND p.saturation = 'Herr' AND p.title = ''
      AND p.firstname = 'Olaf' AND p.lastname = 'Thiele'
  );
