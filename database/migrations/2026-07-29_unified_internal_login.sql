-- ============================================================
-- easyIT nh_hor – vereinheitlichter rollenbasierter Login
-- MariaDB / MySQL, utf8mb4
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS internal_roles (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    role_key VARCHAR(50) NOT NULL,
    role_name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_internal_roles_key (role_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS internal_users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    display_name VARCHAR(150) NOT NULL,
    email VARCHAR(255) NULL,
    role_id INT UNSIGNED NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    last_login_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_internal_users_username (username),
    KEY idx_internal_users_role (role_id),
    CONSTRAINT fk_internal_users_role FOREIGN KEY (role_id) REFERENCES internal_roles(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS internal_permissions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    permission_key VARCHAR(100) NOT NULL,
    permission_name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_internal_permissions_key (permission_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS internal_role_permissions (
    role_id INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    CONSTRAINT fk_irp_role FOREIGN KEY (role_id) REFERENCES internal_roles(id) ON DELETE CASCADE,
    CONSTRAINT fk_irp_permission FOREIGN KEY (permission_id) REFERENCES internal_permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO internal_roles (role_key, role_name, description, is_active) VALUES
('admin','Administrator','Vollzugriff auf den Adminbereich und das interne System',1),
('mitarbeiter','Mitarbeiter','Interne Verwaltung von Schülern, Terminen, Nachrichten und Angeboten',1),
('lehrer','Lehrer','Eigene Schüler, Termine, Unterrichtsdokumentation und Nachrichten',1),
('schueler','Schüler','Eigene Termine, Aufgaben, Dokumente und Nachrichten',1),
('eltern','Eltern','Zugeordnete Schüler, Termine, Mitteilungen und Angebote',1),
('viewer','Viewer','Lesender Zugriff auf freigegebene Inhalte',1)
ON DUPLICATE KEY UPDATE role_name=VALUES(role_name),description=VALUES(description),is_active=1;

INSERT INTO internal_permissions (permission_key, permission_name) VALUES
('users.manage','Benutzer verwalten'),
('roles.manage','Rollen verwalten'),
('students.manage','Schüler verwalten'),
('students.view_own','Eigene Schüler anzeigen'),
('appointments.manage','Termine verwalten'),
('appointments.view_own','Eigene Termine anzeigen'),
('appointments.view_children','Termine zugeordneter Schüler anzeigen'),
('messages.manage','Nachrichten verwalten'),
('messages.use','Nachrichten verwenden'),
('offers.manage','Angebote verwalten'),
('offers.view_own','Eigene Angebote anzeigen'),
('lessons.document','Unterricht dokumentieren'),
('tasks.view_own','Eigene Aufgaben anzeigen'),
('documents.view_own','Eigene Dokumente anzeigen'),
('children.view','Zugeordnete Schüler anzeigen'),
('content.view','Freigegebene Inhalte anzeigen'),
('downloads.view','Freigegebene Downloads anzeigen')
ON DUPLICATE KEY UPDATE permission_name=VALUES(permission_name);

-- Administrator erhält alle Berechtigungen.
INSERT IGNORE INTO internal_role_permissions (role_id, permission_id)
SELECT r.id, p.id FROM internal_roles r CROSS JOIN internal_permissions p
WHERE r.role_key='admin';

INSERT IGNORE INTO internal_role_permissions (role_id, permission_id)
SELECT r.id,p.id FROM internal_roles r JOIN internal_permissions p
ON p.permission_key IN ('students.manage','appointments.manage','messages.manage','offers.manage')
WHERE r.role_key='mitarbeiter';

INSERT IGNORE INTO internal_role_permissions (role_id, permission_id)
SELECT r.id,p.id FROM internal_roles r JOIN internal_permissions p
ON p.permission_key IN ('students.view_own','appointments.view_own','lessons.document','messages.use')
WHERE r.role_key='lehrer';

INSERT IGNORE INTO internal_role_permissions (role_id, permission_id)
SELECT r.id,p.id FROM internal_roles r JOIN internal_permissions p
ON p.permission_key IN ('appointments.view_own','tasks.view_own','documents.view_own','messages.use')
WHERE r.role_key='schueler';

INSERT IGNORE INTO internal_role_permissions (role_id, permission_id)
SELECT r.id,p.id FROM internal_roles r JOIN internal_permissions p
ON p.permission_key IN ('children.view','appointments.view_children','messages.use','offers.view_own')
WHERE r.role_key='eltern';

INSERT IGNORE INTO internal_role_permissions (role_id, permission_id)
SELECT r.id,p.id FROM internal_roles r JOIN internal_permissions p
ON p.permission_key IN ('content.view','downloads.view')
WHERE r.role_key='viewer';

-- Bestehenden Administrator aus admin_users übernehmen.
-- Das Passwort wird unverändert übernommen; othiele kann sich weiter mit seinem bisherigen Passwort anmelden.
INSERT INTO internal_users
(username,password_hash,display_name,email,role_id,is_active,last_login_at)
SELECT
    a.username,
    a.password_hash,
    a.username,
    a.email,
    r.id,
    a.is_active,
    a.last_login_at
FROM admin_users a
JOIN internal_roles r ON r.role_key='admin'
WHERE NOT EXISTS (
    SELECT 1 FROM internal_users u WHERE u.username=a.username
);

-- Bereits übernommene Administratoren auf aktuelle Daten synchronisieren.
UPDATE internal_users u
JOIN admin_users a ON a.username=u.username
JOIN internal_roles r ON r.role_key='admin'
SET u.password_hash=a.password_hash,
    u.email=a.email,
    u.role_id=r.id,
    u.is_active=a.is_active
WHERE u.username='othiele';

SET FOREIGN_KEY_CHECKS = 1;

SELECT u.username,r.role_key,u.is_active
FROM internal_users u
JOIN internal_roles r ON r.id=u.role_id
ORDER BY r.role_key,u.username;
