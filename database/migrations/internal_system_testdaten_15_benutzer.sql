-- ================================================================
-- Rollenbasiertes internes System: Testdaten
-- Enthält Rollen, Berechtigungen, Rollenzuordnungen und 15 Benutzer
-- Standard-Testpasswort für alle Benutzer: Test1234!
-- ================================================================

SET NAMES utf8mb4;
START TRANSACTION;

-- ------------------------------------------------
-- 1. Rollen
-- ------------------------------------------------
INSERT INTO internal_roles
    (role_key, role_name, description, is_active)
VALUES
    ('admin',       'Administrator', 'Vollzugriff auf das interne System.', 1),
    ('mitarbeiter', 'Mitarbeiter',   'Verwaltung von Schülern, Terminen, Nachrichten und Dokumentationen.', 1),
    ('lehrer',      'Lehrkraft',     'Zugriff auf eigene Schüler, Termine und Unterrichtsdokumentationen.', 1),
    ('schueler',    'Schüler',       'Zugriff auf eigene Termine, Aufgaben, Dokumente und Lernstände.', 1),
    ('eltern',      'Eltern',        'Zugriff auf zugeordnete Schüler, Termine und Mitteilungen.', 1),
    ('viewer',      'Lesender Zugriff', 'Nur lesender Zugriff auf freigegebene interne Inhalte.', 1)
ON DUPLICATE KEY UPDATE
    role_name = VALUES(role_name),
    description = VALUES(description),
    is_active = VALUES(is_active);

-- ------------------------------------------------
-- 2. Berechtigungen
-- ------------------------------------------------
INSERT INTO internal_permissions
    (permission_key, permission_name, description)
VALUES
    ('dashboard.view',          'Dashboard anzeigen',             'Darf das interne Dashboard aufrufen.'),
    ('users.view',              'Benutzer anzeigen',              'Darf Benutzerkonten ansehen.'),
    ('users.manage',            'Benutzer verwalten',             'Darf Benutzerkonten anlegen, ändern und deaktivieren.'),
    ('roles.manage',            'Rollen verwalten',               'Darf Rollen und Rollenzuordnungen bearbeiten.'),
    ('permissions.manage',      'Berechtigungen verwalten',       'Darf Berechtigungen den Rollen zuordnen.'),
    ('students.view_all',       'Alle Schüler anzeigen',          'Darf alle Schülerdatensätze anzeigen.'),
    ('students.view_assigned',  'Zugeordnete Schüler anzeigen',   'Darf nur zugeordnete Schülerdatensätze anzeigen.'),
    ('students.view_own',       'Eigenes Schülerkonto anzeigen',  'Darf ausschließlich den eigenen Schülerdatensatz anzeigen.'),
    ('students.manage',         'Schüler verwalten',              'Darf Schülerdatensätze anlegen und bearbeiten.'),
    ('appointments.view_all',   'Alle Termine anzeigen',          'Darf sämtliche Termine anzeigen.'),
    ('appointments.view_own',   'Eigene Termine anzeigen',        'Darf nur eigene oder zugeordnete Termine anzeigen.'),
    ('appointments.manage',     'Termine verwalten',              'Darf Termine anlegen, ändern und löschen.'),
    ('lessons.document',        'Unterricht dokumentieren',       'Darf Unterrichtsdokumentationen erfassen und ändern.'),
    ('messages.read',           'Nachrichten lesen',              'Darf interne Nachrichten lesen.'),
    ('messages.write',          'Nachrichten schreiben',          'Darf interne Nachrichten verfassen.'),
    ('offers.view',             'Angebote anzeigen',              'Darf Angebote und Buchungen anzeigen.'),
    ('offers.manage',           'Angebote verwalten',             'Darf Angebote anlegen und bearbeiten.'),
    ('content.manage',          'Inhalte verwalten',              'Darf interne und öffentliche Inhalte bearbeiten.'),
    ('reports.view',            'Auswertungen anzeigen',          'Darf Berichte und Auswertungen anzeigen.'),
    ('system.manage',           'System verwalten',               'Darf technische Systemeinstellungen ändern.')
ON DUPLICATE KEY UPDATE
    permission_name = VALUES(permission_name),
    description = VALUES(description);

-- ------------------------------------------------
-- 3. Rollenzuordnungen neu aufbauen
-- ------------------------------------------------
DELETE FROM internal_role_permissions
WHERE role_id IN (
    SELECT id FROM internal_roles
    WHERE role_key IN ('admin', 'mitarbeiter', 'lehrer', 'schueler', 'eltern', 'viewer')
);

-- Administrator: alle Berechtigungen
INSERT INTO internal_role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM internal_roles r
CROSS JOIN internal_permissions p
WHERE r.role_key = 'admin';

-- Mitarbeiter
INSERT INTO internal_role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM internal_roles r
JOIN internal_permissions p
  ON p.permission_key IN (
      'dashboard.view',
      'users.view',
      'students.view_all',
      'students.manage',
      'appointments.view_all',
      'appointments.manage',
      'lessons.document',
      'messages.read',
      'messages.write',
      'offers.view',
      'reports.view'
  )
WHERE r.role_key = 'mitarbeiter';

-- Lehrkraft
INSERT INTO internal_role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM internal_roles r
JOIN internal_permissions p
  ON p.permission_key IN (
      'dashboard.view',
      'students.view_assigned',
      'appointments.view_own',
      'lessons.document',
      'messages.read',
      'messages.write',
      'offers.view'
  )
WHERE r.role_key = 'lehrer';

-- Schüler
INSERT INTO internal_role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM internal_roles r
JOIN internal_permissions p
  ON p.permission_key IN (
      'dashboard.view',
      'students.view_own',
      'appointments.view_own',
      'messages.read',
      'messages.write',
      'offers.view'
  )
WHERE r.role_key = 'schueler';

-- Eltern
INSERT INTO internal_role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM internal_roles r
JOIN internal_permissions p
  ON p.permission_key IN (
      'dashboard.view',
      'students.view_assigned',
      'appointments.view_own',
      'messages.read',
      'messages.write',
      'offers.view'
  )
WHERE r.role_key = 'eltern';

-- Viewer
INSERT INTO internal_role_permissions (role_id, permission_id)
SELECT r.id, p.id
FROM internal_roles r
JOIN internal_permissions p
  ON p.permission_key IN (
      'dashboard.view',
      'messages.read',
      'offers.view'
  )
WHERE r.role_key = 'viewer';

-- ------------------------------------------------
-- 4. 15 Testbenutzer
-- Standardpasswort für alle Konten: Test1234!
-- ------------------------------------------------
INSERT INTO internal_users
    (username, password_hash, display_name, email, role_id, is_active)
VALUES
    ('admin',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Systemadministrator', 'admin@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'admin' LIMIT 1), 1),

    ('mitarbeiter.anna',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Anna Bergmann', 'anna.bergmann@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'mitarbeiter' LIMIT 1), 1),

    ('mitarbeiter.markus',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Markus Lindner', 'markus.lindner@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'mitarbeiter' LIMIT 1), 1),

    ('lehrer.thiele',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Herr Thiele', 'olaf.thiele@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'lehrer' LIMIT 1), 1),

    ('lehrer.mueller',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Frau Müller', 'sandra.mueller@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'lehrer' LIMIT 1), 1),

    ('lehrer.schneider',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Herr Schneider', 'tobias.schneider@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'lehrer' LIMIT 1), 1),

    ('schueler.lena',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Lena Fischer', 'lena.fischer@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'schueler' LIMIT 1), 1),

    ('schueler.noah',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Noah Weber', 'noah.weber@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'schueler' LIMIT 1), 1),

    ('schueler.emma',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Emma Hoffmann', 'emma.hoffmann@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'schueler' LIMIT 1), 1),

    ('schueler.lukas',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Lukas Wagner', 'lukas.wagner@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'schueler' LIMIT 1), 1),

    ('schueler.mia',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Mia Becker', 'mia.becker@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'schueler' LIMIT 1), 1),

    ('eltern.fischer',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Familie Fischer', 'familie.fischer@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'eltern' LIMIT 1), 1),

    ('eltern.weber',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Familie Weber', 'familie.weber@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'eltern' LIMIT 1), 1),

    ('viewer.gast',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Interner Gastzugang', 'gast@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'viewer' LIMIT 1), 1),

    ('viewer.pruefung',
     '$2y$12$fQqO7FRrmwQQbeF1hdleHeI1Efxct8ZPO7tbQXvUAdqtYgmF8iqk2',
     'Prüfzugang', 'pruefung@example.local',
     (SELECT id FROM internal_roles WHERE role_key = 'viewer' LIMIT 1), 1)
ON DUPLICATE KEY UPDATE
    password_hash = VALUES(password_hash),
    display_name = VALUES(display_name),
    email = VALUES(email),
    role_id = VALUES(role_id),
    is_active = VALUES(is_active);

COMMIT;

-- ------------------------------------------------
-- Kontrollabfragen
-- ------------------------------------------------
SELECT
    u.id,
    u.username,
    u.display_name,
    u.email,
    r.role_key,
    r.role_name,
    u.is_active
FROM internal_users u
INNER JOIN internal_roles r ON r.id = u.role_id
ORDER BY r.id, u.username;

SELECT
    r.role_name,
    COUNT(rp.permission_id) AS anzahl_berechtigungen
FROM internal_roles r
LEFT JOIN internal_role_permissions rp ON rp.role_id = r.id
GROUP BY r.id, r.role_name
ORDER BY r.id;
