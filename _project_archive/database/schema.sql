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
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS content_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    content_type ENUM('faq','review','job','blog') NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(190) NOT NULL,
    excerpt TEXT NULL,
    body LONGTEXT NOT NULL,
    meta_title VARCHAR(255) NULL,
    meta_description VARCHAR(320) NULL,
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
    KEY idx_published_at (published_at),
    CONSTRAINT fk_content_created_by FOREIGN KEY (created_by) REFERENCES admin_users(id) ON DELETE SET NULL,
    CONSTRAINT fk_content_updated_by FOREIGN KEY (updated_by) REFERENCES admin_users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

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
    CONSTRAINT fk_revision_item FOREIGN KEY (content_item_id) REFERENCES content_items(id) ON DELETE CASCADE,
    CONSTRAINT fk_revision_user FOREIGN KEY (changed_by) REFERENCES admin_users(id) ON DELETE SET NULL,
    KEY idx_revision_item (content_item_id, created_at)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS audit_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    action VARCHAR(80) NOT NULL,
    entity_type VARCHAR(80) NOT NULL,
    entity_id BIGINT UNSIGNED NULL,
    details JSON NULL,
    ip_hash CHAR(64) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_audit_user FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE SET NULL,
    KEY idx_audit_entity (entity_type, entity_id),
    KEY idx_audit_created_at (created_at)
) ENGINE=InnoDB;
USE easyit;

CREATE TABLE IF NOT EXISTS tutors (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
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
    PRIMARY KEY (id),
    UNIQUE KEY uq_tutors_slug (slug),
    KEY idx_tutors_active_sort (is_active, sort_order, display_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS tutor_competencies (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    tutor_id INT UNSIGNED NOT NULL,
    category ENUM('fach','methodik','didaktik','faehigkeit','qualifikation') NOT NULL,
    title VARCHAR(190) NOT NULL,
    description TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_tutor_competencies (tutor_id, category, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tutors
(slug, display_name, professional_title, short_intro, biography, teaching_approach, image_path, image_alt, is_active, sort_order)
VALUES
('olaf-thiele', 'Olaf Thiele', 'Tutor für Mathematik, Physik, Chemie und Informatik',
 'Fachübergreifende Lernbegleitung für Schule, Ausbildung, Abitur und Studium.',
 'Olaf Thiele verbindet mathematisches, naturwissenschaftliches und informatisches Denken. Im Unterricht werden Zusammenhänge sichtbar gemacht, statt einzelne Verfahren nur auswendig zu lernen.',
 'Ausgangspunkt ist immer der aktuelle Denkweg des Lernenden. Begriffe werden geklärt, Lösungswege schriftlich strukturiert, Fehler als Diagnose genutzt und Ergebnisse anschließend selbstständig überprüft.',
 'assets/img/tutors/olaf-thiele.svg', 'Porträtgrafik von Olaf Thiele', 1, 10),
('sprachentutorin', 'Sprachentutorin', 'Tutorin für Deutsch, Englisch, Französisch, Spanisch und Latein',
 'Sprachliche Sicherheit durch verständliche Grammatik, aktiven Wortschatz und adressatengerechten Ausdruck.',
 'Der Sprachunterricht verbindet systematischen Aufbau mit konkreter Anwendung. Lesen, Schreiben, Sprechen und Sprachreflexion werden passend zum Lernstand miteinander verknüpft.',
 'Neue Strukturen werden an Beispielen eingeführt, gemeinsam angewendet und in kleinen Übungsschritten gesichert. Rückmeldungen zeigen nicht nur Fehler, sondern erklären, wie eine bessere Formulierung entsteht.',
 'assets/img/tutors/sprachentutorin.svg', 'Porträtgrafik einer Sprachentutorin', 1, 20),
('ethiktutor', 'Tutor für Ethik', 'Tutor für Ethik, Philosophie und gesellschaftliche Fragestellungen',
 'Argumentieren lernen, Positionen prüfen und eigene Urteile nachvollziehbar begründen.',
 'Der Ethikunterricht erschließt Begriffe, Konflikte und philosophische Positionen. Unterschiedliche Sichtweisen werden sachlich verglichen und auf konkrete Lebens- und Prüfungssituationen bezogen.',
 'Diskussionen werden durch Leitfragen, Begriffsarbeit und Argumentationsmodelle strukturiert. Ziel ist kein vorgegebenes Urteil, sondern eine fachlich begründete, sprachlich klare und reflektierte Position.',
 'assets/img/tutors/ethiktutor.svg', 'Porträtgrafik eines Tutors für Ethik', 1, 30)
ON DUPLICATE KEY UPDATE
 professional_title=VALUES(professional_title), short_intro=VALUES(short_intro), biography=VALUES(biography),
 teaching_approach=VALUES(teaching_approach), image_path=VALUES(image_path), image_alt=VALUES(image_alt),
 is_active=VALUES(is_active), sort_order=VALUES(sort_order);

DELETE tc FROM tutor_competencies tc
INNER JOIN tutors t ON t.id = tc.tutor_id
WHERE t.slug IN ('olaf-thiele','sprachentutorin','ethiktutor');

INSERT INTO tutor_competencies (tutor_id, category, title, description, sort_order)
SELECT id, 'fach', 'Mathematik', 'Grundlagen, Analysis, Algebra, Geometrie, Stochastik und anwendungsbezogene Modellierung.', 10 FROM tutors WHERE slug='olaf-thiele'
UNION ALL SELECT id, 'fach', 'Physik', 'Mechanik, Elektrizitätslehre, Optik, Thermodynamik und moderne Physik.', 20 FROM tutors WHERE slug='olaf-thiele'
UNION ALL SELECT id, 'fach', 'Chemie', 'Stoffaufbau, Reaktionsgleichungen, Stöchiometrie, organische und physikalische Chemie.', 30 FROM tutors WHERE slug='olaf-thiele'
UNION ALL SELECT id, 'fach', 'Informatik', 'Algorithmisches Denken, Programmierung, Datenbanken und technische Grundlagen.', 40 FROM tutors WHERE slug='olaf-thiele'
UNION ALL SELECT id, 'methodik', 'Schriftlich strukturierte Lösungswege', 'Jeder Lösungsweg wird so dokumentiert, dass Annahmen, Teilschritte und Kontrollen nachvollziehbar bleiben.', 10 FROM tutors WHERE slug='olaf-thiele'
UNION ALL SELECT id, 'didaktik', 'Fachübergreifende Verknüpfung', 'Mathematische, naturwissenschaftliche und informatische Zusammenhänge werden gezielt miteinander verbunden.', 20 FROM tutors WHERE slug='olaf-thiele'
UNION ALL SELECT id, 'faehigkeit', 'Diagnose von Denkfehlern', 'Fehler werden nicht nur korrigiert, sondern auf Begriffs-, Verfahrens- oder Verständnislücken zurückgeführt.', 30 FROM tutors WHERE slug='olaf-thiele'
UNION ALL SELECT id, 'qualifikation', 'Studien- und Berufserfahrung im technischen Umfeld', 'Breite technische Perspektive für schulische und studienbezogene Problemstellungen.', 40 FROM tutors WHERE slug='olaf-thiele'

UNION ALL SELECT id, 'fach', 'Deutsch', 'Grammatik, Rechtschreibung, Textanalyse, Erörterung und adressatengerechtes Schreiben.', 10 FROM tutors WHERE slug='sprachentutorin'
UNION ALL SELECT id, 'fach', 'Englisch', 'Wortschatz, Grammatik, Textproduktion, Lese- und Hörverstehen sowie Prüfungskommunikation.', 20 FROM tutors WHERE slug='sprachentutorin'
UNION ALL SELECT id, 'fach', 'Französisch, Spanisch und Latein', 'Sprachsystem, Übersetzung, Ausdruck, Textverständnis und kontinuierlicher Wortschatzaufbau.', 30 FROM tutors WHERE slug='sprachentutorin'
UNION ALL SELECT id, 'methodik', 'Sprachhandeln in kleinen Schritten', 'Neue Strukturen werden erklärt, modelliert, angewendet und anschließend in freien Aufgaben gesichert.', 10 FROM tutors WHERE slug='sprachentutorin'
UNION ALL SELECT id, 'didaktik', 'Fehlersensible Rückmeldung', 'Korrekturen benennen Regel, Wirkung und konkrete Verbesserungsmöglichkeit.', 20 FROM tutors WHERE slug='sprachentutorin'
UNION ALL SELECT id, 'faehigkeit', 'Differenzierte Ausdrucksförderung', 'Wortschatz und Satzbau werden passend zu Schulform, Aufgabe und individuellem Lernstand entwickelt.', 30 FROM tutors WHERE slug='sprachentutorin'
UNION ALL SELECT id, 'qualifikation', 'Sprachdidaktische Ausrichtung', 'Kompetenzorientierte Verbindung von Grammatik, Textarbeit und kommunikativer Anwendung.', 40 FROM tutors WHERE slug='sprachentutorin'

UNION ALL SELECT id, 'fach', 'Ethik und Philosophie', 'Normen, Werte, Menschenbilder, Argumentationstheorie und ausgewählte philosophische Positionen.', 10 FROM tutors WHERE slug='ethiktutor'
UNION ALL SELECT id, 'fach', 'Gesellschaftliche Konfliktfelder', 'Anwendung ethischer Modelle auf Technik, Umwelt, Verantwortung, Freiheit und Gerechtigkeit.', 20 FROM tutors WHERE slug='ethiktutor'
UNION ALL SELECT id, 'methodik', 'Strukturierte Argumentationsanalyse', 'Behauptung, Begründung, Beispiel, Einwand und Schlussfolgerung werden klar unterschieden.', 10 FROM tutors WHERE slug='ethiktutor'
UNION ALL SELECT id, 'didaktik', 'Perspektivwechsel ohne Beliebigkeit', 'Unterschiedliche Positionen werden offen geprüft und zugleich an fachlichen Kriterien gemessen.', 20 FROM tutors WHERE slug='ethiktutor'
UNION ALL SELECT id, 'faehigkeit', 'Moderation sachlicher Diskussionen', 'Kontroverse Fragen werden wertschätzend, begrifflich präzise und ergebnisoffen bearbeitet.', 30 FROM tutors WHERE slug='ethiktutor'
UNION ALL SELECT id, 'qualifikation', 'Philosophisch-ethische Fachorientierung', 'Sichere Arbeit mit Begriffen, Positionen, Texten und prüfungsrelevanten Urteilsformaten.', 40 FROM tutors WHERE slug='ethiktutor';


-- ==========================================================
-- Tutorbewertungen (Migration 20260718_004)
-- ==========================================================
USE easyit;

CREATE TABLE IF NOT EXISTS tutor_reviews (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    tutor_id INT UNSIGNED NOT NULL,
    reviewer_name VARCHAR(120) NOT NULL,
    reviewer_context VARCHAR(190) NULL,
    review_date DATE NOT NULL,
    stars TINYINT UNSIGNED NOT NULL DEFAULT 5,
    review_text TEXT NOT NULL,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_tutor_reviews_public (tutor_id, is_published, review_date),
    KEY idx_tutor_reviews_stars (tutor_id, stars)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELETE tr FROM tutor_reviews tr
INNER JOIN tutors t ON t.id = tr.tutor_id
WHERE t.slug IN ('olaf-thiele','sprachentutorin','ethiktutor');

INSERT INTO tutor_reviews
(tutor_id, reviewer_name, reviewer_context, review_date, stars, review_text, is_published, sort_order)
SELECT id, 'Lena', 'Gymnasium, Klasse 11', '2026-06-24', 5,
       'Mathematik wird nicht nur vorgerechnet. Ich verstehe inzwischen, warum ein Lösungsweg funktioniert, und kann ihn in neuen Aufgaben selbst anwenden.', 1, 10
FROM tutors WHERE slug='olaf-thiele'
UNION ALL SELECT id, 'Jonas', 'Abiturvorbereitung Mathematik und Physik', '2026-05-18', 5,
       'Die Vorbereitung war sehr strukturiert. Besonders hilfreich waren die schriftlichen Lösungswege und die ehrliche Rückmeldung, an welcher Stelle mein Verständnis noch nicht sicher war.', 1, 20 FROM tutors WHERE slug='olaf-thiele'
UNION ALL SELECT id, 'Miriam', 'Studium, technische Grundlagen', '2026-03-11', 5,
       'Komplexe Zusammenhänge wurden fachübergreifend erklärt. Dadurch konnte ich Formeln endlich mit ihrer Bedeutung verbinden, statt sie nur auswendig zu lernen.', 1, 30 FROM tutors WHERE slug='olaf-thiele'
UNION ALL SELECT id, 'Paul', 'Oberschule, Klasse 9', '2026-02-02', 4,
       'Ich arbeite heute ordentlicher und erkenne meine eigenen Fehler schneller. Der Unterricht ist anspruchsvoll, aber immer nachvollziehbar.', 1, 40 FROM tutors WHERE slug='olaf-thiele'

UNION ALL SELECT id, 'Sophie', 'Gymnasium, Englisch', '2026-06-08', 5,
       'Meine Texte sind deutlich klarer geworden. Fehler werden nicht einfach markiert, sondern so erklärt, dass ich beim nächsten Text selbst darauf achten kann.', 1, 10 FROM tutors WHERE slug='sprachentutorin'
UNION ALL SELECT id, 'Emilia', 'Oberschule, Deutsch', '2026-04-29', 5,
       'Die Grammatikregeln werden mit verständlichen Beispielen aufgebaut. Besonders gut finde ich, dass wir danach sofort eigene Sätze und Texte schreiben.', 1, 20 FROM tutors WHERE slug='sprachentutorin'
UNION ALL SELECT id, 'Noah', 'Gymnasium, Französisch', '2026-03-17', 4,
       'Der Unterricht hilft mir, Wortschatz und Grammatik gemeinsam anzuwenden. Beim Sprechen bin ich inzwischen viel sicherer.', 1, 30 FROM tutors WHERE slug='sprachentutorin'
UNION ALL SELECT id, 'Charlotte', 'Abiturvorbereitung Deutsch', '2026-01-21', 5,
       'Textanalysen und Erörterungen haben endlich eine klare Struktur. Ich weiß jetzt, wie ich aus meinen Gedanken eine nachvollziehbare Argumentation mache.', 1, 40 FROM tutors WHERE slug='sprachentutorin'

UNION ALL SELECT id, 'Max', 'Gymnasium, Klasse 10', '2026-06-14', 5,
       'Wir diskutieren nicht einfach nur Meinungen, sondern prüfen Begriffe, Argumente und Gegenargumente. Dadurch kann ich meine Position viel besser begründen.', 1, 10 FROM tutors WHERE slug='ethiktutor'
UNION ALL SELECT id, 'Anna', 'Abiturvorbereitung Ethik', '2026-05-05', 5,
       'Philosophische Positionen wurden verständlich gegenübergestellt und direkt auf Prüfungsaufgaben angewendet. Das hat mir beim Schreiben sehr geholfen.', 1, 20 FROM tutors WHERE slug='ethiktutor'
UNION ALL SELECT id, 'Leon', 'Oberschule, Klasse 9', '2026-03-26', 5,
       'Ich habe gelernt, Behauptung, Begründung und Beispiel sauber zu trennen. Diskussionen fühlen sich dadurch weniger chaotisch an.', 1, 30 FROM tutors WHERE slug='ethiktutor'
UNION ALL SELECT id, 'Nele', 'Gymnasium, Klasse 11', '2026-02-12', 4,
       'Auch bei schwierigen Themen bleibt der Unterricht sachlich und offen. Gleichzeitig wird genau darauf geachtet, ob ein Argument wirklich trägt.', 1, 40 FROM tutors WHERE slug='ethiktutor';
