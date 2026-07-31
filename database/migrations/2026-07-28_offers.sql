-- -----------------------------------------------------------------------------
-- easyIT Nachhilfe: Angebote und Preise
-- Stand: 2026-07-28
-- Engine: MyISAM, Zeichensatz utf8mb4
-- -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS offers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    badge VARCHAR(80) NOT NULL DEFAULT '',
    title VARCHAR(160) NOT NULL,
    price_amount DECIMAL(10,2) NULL,
    price_text VARCHAR(120) NOT NULL DEFAULT '',
    price_unit VARCHAR(120) NOT NULL DEFAULT '',
    description TEXT NOT NULL,
    features_json LONGTEXT NULL,
    footnote TEXT NULL,
    featured TINYINT(1) NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 100,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_offers_public (is_active, sort_order, id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO offers
(badge, title, price_amount, price_text, price_unit, description, features_json, footnote, featured, is_active, sort_order)
SELECT 'Kennenlernen', 'Erstgespräch', NULL, 'kostenfrei*', '',
       'Kurze Klärung von Fach, Ziel, Stand und organisatorischem Rahmen.',
       '["Bedarf einschätzen","passende Unterrichtsform klären","offene Fragen beantworten"]',
       '* Formulierung und Umfang des kostenfreien Kennenlernens bitte vor Veröffentlichung verbindlich festlegen.',
       0, 1, 10
WHERE NOT EXISTS (SELECT 1 FROM offers WHERE title = 'Erstgespräch');

INSERT INTO offers
(badge, title, price_amount, price_text, price_unit, description, features_json, footnote, featured, is_active, sort_order)
SELECT 'Kernangebot', 'Einzelunterricht', NULL, 'Preis eintragen', '',
       'Individuelle Nachhilfe mit Vorbereitung und passender Lernstruktur.',
       '["persönlicher Schwerpunkt","flexible Fachinhalte","gezielte Rückmeldung"]',
       NULL, 1, 1, 20
WHERE NOT EXISTS (SELECT 1 FROM offers WHERE title = 'Einzelunterricht');

INSERT INTO offers
(badge, title, price_amount, price_text, price_unit, description, features_json, footnote, featured, is_active, sort_order)
SELECT 'Intensiv', 'Prüfungsvorbereitung', NULL, 'individuell', '',
       'Planbare Vorbereitung auf Klausur, Abschlussprüfung oder Abitur.',
       '["Bestandsaufnahme","Lernplan","Prüfungssimulation"]',
       NULL, 0, 1, 30
WHERE NOT EXISTS (SELECT 1 FROM offers WHERE title = 'Prüfungsvorbereitung');
