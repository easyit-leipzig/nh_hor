-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Jul 2026 um 08:15
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `easyit`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_person` bigint(20) UNSIGNED NOT NULL,
  `address_type` enum('business','residential','postal','billing','other') NOT NULL DEFAULT 'business',
  `label` varchar(120) NOT NULL DEFAULT '',
  `organization` varchar(190) NOT NULL DEFAULT '',
  `department` varchar(190) NOT NULL DEFAULT '',
  `care_of` varchar(190) NOT NULL DEFAULT '',
  `address_line_1` varchar(190) NOT NULL DEFAULT '',
  `address_line_2` varchar(190) NOT NULL DEFAULT '',
  `address_line_3` varchar(190) NOT NULL DEFAULT '',
  `building` varchar(120) NOT NULL DEFAULT '',
  `street_name` varchar(190) NOT NULL DEFAULT '',
  `house_number` varchar(40) NOT NULL DEFAULT '',
  `post_office_box` varchar(80) NOT NULL DEFAULT '',
  `district` varchar(120) NOT NULL DEFAULT '',
  `city` varchar(120) NOT NULL DEFAULT '',
  `administrative_area` varchar(120) NOT NULL DEFAULT '',
  `postal_code` varchar(40) NOT NULL DEFAULT '',
  `country_code` char(2) NOT NULL DEFAULT 'DE',
  `country_name` varchar(120) NOT NULL DEFAULT 'Deutschland',
  `phone` varchar(80) NOT NULL DEFAULT '',
  `email` varchar(190) NOT NULL DEFAULT '',
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `add_index_content`
--

CREATE TABLE `add_index_content` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `internal_name` varchar(160) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slot_id` bigint(20) UNSIGNED DEFAULT NULL,
  `position_no` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `placement` enum('before','after','replace') NOT NULL DEFAULT 'after',
  `html_content` mediumtext NOT NULL,
  `media_id` bigint(20) UNSIGNED DEFAULT NULL,
  `css_content` mediumtext DEFAULT NULL,
  `js_content` mediumtext DEFAULT NULL,
  `wrapper_class` varchar(255) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 100,
  `valid_from` datetime DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `add_index_content`
--

INSERT INTO `add_index_content` (`id`, `internal_name`, `title`, `slot_id`, `position_no`, `placement`, `html_content`, `media_id`, `css_content`, `js_content`, `wrapper_class`, `active`, `sort_order`, `valid_from`, `valid_until`, `created_at`, `updated_at`) VALUES
(1, 'summer_sale_2026', 'Sommersale 2026', 1, 1, 'before', '<div class=\"container\"><strong>SOMMERSALE</strong><br>Jetzt Nachhilfe zum Ferienpreis sichern.<br><a class=\"button button--gold\" href=\"/kontakt.php\">Jetzt Termin vereinbaren</a></div>', NULL, '.promo-summer{background:#ffb300;color:#222;padding:30px;text-align:center;border-radius:18px;margin-bottom:24px}.promo-summer strong{font-size:clamp(1.6rem,4vw,2.8rem)}', '', 'promo-banner promo-summer', 0, 10, '2026-07-20 00:00:00', '2026-08-31 23:59:00', '2026-07-20 12:33:14', '2026-07-25 13:51:25'),
(2, 'mathe_workshop', 'Kostenloser Mathe-Workshop', 2, 2, 'after', '<div class=\"container\"><h2>Kostenloser Mathe-Workshop</h2><p>Samstag um 14 Uhr: Abiturvorbereitung Mathematik.</p><a class=\"button button--blue\" href=\"/kontakt.php\">Jetzt anmelden</a></div>', NULL, '.event-box{border:4px solid #0b63ce;padding:40px;margin:40px auto;text-align:center;border-radius:18px}', '', 'event-box', 1, 20, NULL, NULL, '2026-07-20 12:33:14', '2026-07-20 12:33:14'),
(3, 'christmas_special', 'Weihnachtsaktion', 5, 5, 'replace', '<div class=\"container\"><h2>Weihnachtsaktion</h2><p>Verschenke Nachhilfe-Gutscheine.</p><a class=\"button button--gold\" href=\"/kontakt.php\">Gutschein bestellen</a></div>', NULL, '.christmas{background:#8f1111;color:#fff;padding:60px;border-radius:18px;text-align:center}', '', 'christmas', 1, 30, '2026-12-01 00:00:00', '2026-12-24 23:59:59', '2026-07-20 12:33:14', '2026-07-20 12:33:14'),
(4, 'holiday_notice', 'Ferienhinweis', 6, 6, 'after', '<div class=\"container\"><h3>Hinweis</h3><p>Während der Sommerferien sind Termine nach Vereinbarung möglich.</p></div>', NULL, '.holiday{background:#eee;padding:25px;font-size:.95rem;border-radius:14px;margin-top:24px}', '', 'holiday', 1, 40, NULL, NULL, '2026-07-20 12:33:14', '2026-07-20 12:33:14');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(80) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'editor',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password_hash`, `role`, `is_active`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'othiele', 'thiele.olaf@googlemail.com', '$2y$10$aMR8wLIohS2AwQx7qZEXIOnvfoW8rzogHY8kl4ECNM/59qx2Gt7s.', 'admin', 1, '2026-07-26 07:38:55', '2026-07-20 12:52:09', '2026-07-26 07:38:55');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `audit_log`
--

CREATE TABLE `audit_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(80) NOT NULL,
  `entity_type` varchar(80) NOT NULL,
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `ip_hash` char(64) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `request_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `audit_log`
--

INSERT INTO `audit_log` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_hash`, `created_at`, `request_id`) VALUES
(0, NULL, 'login_failed', 'admin_session', NULL, '{\"username_hash\":\"8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918\",\"attempts\":1,\"locked\":false}', 'eff8e7ca506627fe15dda5e0e512fcaad70b6d520f37cc76597fdb4f2d83a1a3', '2026-07-25 06:46:45', NULL),
(1, 1, 'login_success', 'admin_session', NULL, '{\"username\":\"othiele\"}', 'eff8e7ca506627fe15dda5e0e512fcaad70b6d520f37cc76597fdb4f2d83a1a3', '2026-07-20 12:55:39', NULL),
(2, 1, 'create', 'imprint_person', 4, '{\"to_role\":2}', 'eff8e7ca506627fe15dda5e0e512fcaad70b6d520f37cc76597fdb4f2d83a1a3', '2026-07-20 13:40:04', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `career_faq`
--

CREATE TABLE `career_faq` (
  `id` int(10) UNSIGNED NOT NULL,
  `career_job_id` int(10) UNSIGNED NOT NULL,
  `question` varchar(1000) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 100,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `career_faq`
--

INSERT INTO `career_faq` (`id`, `career_job_id`, `question`, `answer`, `sort_order`, `is_active`) VALUES
(1, 1, 'Welche Deutschthemen werden besonders häufig nachgefragt?', 'Häufig geht es um Rechtschreibung, Grammatik, Textverständnis, Aufsatzformen, Argumentation, Literaturarbeit und gezielte Prüfungsvorbereitung.', 10, 1),
(2, 1, 'Muss ich Germanistik oder Lehramt studiert haben?', 'Ein passendes Studium ist willkommen, aber nicht die einzige Möglichkeit. Entscheidend sind sehr sichere Deutschkenntnisse, fachliche Zuverlässigkeit und die Fähigkeit, verständlich zu erklären.', 20, 1),
(3, 1, 'Wie individuell soll eine Stunde vorbereitet werden?', 'Die Vorbereitung orientiert sich am konkreten Lernstand, am Schulstoff, an bisherigen Schwierigkeiten und am vereinbarten Lernziel. Vorgefertigte Materialien dürfen genutzt werden, ersetzen aber nicht die didaktische Auswahl.', 30, 1),
(4, 1, 'Kann ich nur bestimmte Klassenstufen übernehmen?', 'Ja. Die Zuordnung erfolgt nach fachlicher Sicherheit, Erfahrung und persönlicher Präferenz. Niemand soll Themen oder Klassenstufen unterrichten, die nicht zuverlässig abgedeckt werden können.', 40, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `career_images`
--

CREATE TABLE `career_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `career_job_id` int(10) UNSIGNED NOT NULL,
  `image_role` enum('card','gallery','hero') NOT NULL DEFAULT 'gallery',
  `image_path` varchar(500) NOT NULL,
  `alt_text` varchar(500) NOT NULL,
  `caption` varchar(500) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 100,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `career_images`
--

INSERT INTO `career_images` (`id`, `career_job_id`, `image_role`, `image_path`, `alt_text`, `caption`, `sort_order`, `is_active`) VALUES
(1, 1, 'card', '/assets/img/jobs/deutsch/deutsch-08-empfang-easyit.jpg', 'Heller Empfangsbereich von easyIT Nachhilfe', 'Willkommen bei easyIT Nachhilfe', 10, 1),
(2, 1, 'card', '/assets/img/jobs/deutsch/deutsch-01-einzelunterricht.jpg', 'Lehrkraft begleitet eine Schülerin im individuellen Deutschunterricht', 'Individuelle Lernbegleitung', 20, 1),
(3, 1, 'card', '/assets/img/jobs/deutsch/deutsch-05-grammatik-erklaeren.jpg', 'Lehrkraft erklärt Satzbau und Grammatik an einem Whiteboard', 'Verstehen statt Auswendiglernen', 30, 1),
(4, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-04-schreibbegleitung.jpg', 'Lehrkraft unterstützt eine Schülerin beim Schreiben', 'Schreiben Schritt für Schritt entwickeln', 40, 1),
(5, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-07-gruppenunterricht.jpg', 'Lehrkraft unterrichtet eine kleine Lerngruppe', 'Kleine Gruppen aufmerksam führen', 50, 1),
(6, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-02-fachgespraech.jpg', 'Kolleginnen und Kollegen besprechen Unterrichtsmaterialien', 'Fachlicher Austausch im Team', 60, 1),
(7, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-03-kollegialer-austausch.jpg', 'Zwei Lehrkräfte tauschen sich mit Büchern aus', 'Materialien gemeinsam weiterentwickeln', 70, 1),
(8, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-06-unterrichtsplanung.jpg', 'Lehrkräfte planen Unterricht gemeinsam am Tisch', 'Unterricht sorgfältig vorbereiten', 80, 1),
(9, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-09-teammeeting.jpg', 'Teamgespräch in einem hellen Besprechungsraum', 'Offen und verbindlich zusammenarbeiten', 90, 1),
(10, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-10-fortbildung.jpg', 'Fortbildung mit Präsentation vor einer Gruppe', 'Fachlich und didaktisch weiterlernen', 100, 1),
(11, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-11-kleingruppengespraech.jpg', 'Lehrkraft moderiert ein Gespräch in kleiner Runde', 'Gespräche auf Augenhöhe führen', 110, 1),
(12, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-12-arbeitsrunde.jpg', 'Kollegiale Arbeitsrunde mit Unterlagen', 'Erfahrungen reflektieren', 120, 1),
(13, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-13-digitale-zusammenarbeit.jpg', 'Team arbeitet gemeinsam mit einem Notebook', 'Digitale Werkzeuge sinnvoll einsetzen', 130, 1),
(14, 1, 'gallery', '/assets/img/jobs/deutsch/deutsch-14-methodenworkshop.jpg', 'Methodenworkshop mit Präsentation und Flipchart', 'Methoden gemeinsam prüfen und verbessern', 140, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `career_jobs`
--

CREATE TABLE `career_jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `job_key` varchar(80) NOT NULL,
  `code` varchar(20) NOT NULL,
  `slug` varchar(190) NOT NULL,
  `title` varchar(255) NOT NULL,
  `claim` varchar(500) NOT NULL,
  `intro` text NOT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `sort_order` int(11) NOT NULL DEFAULT 100,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `career_jobs`
--

INSERT INTO `career_jobs` (`id`, `job_key`, `code`, `slug`, `title`, `claim`, `intro`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'deutsch', 'DEU', 'karriere-deutsch.php', 'Nachhilfelehrkraft Deutsch', 'Sprache verständlich machen. Ausdruck stärken. Selbstvertrauen entwickeln.', 'Gesucht werden Lehrkräfte, die Grammatik, Literatur, Rechtschreibung und schriftlichen Ausdruck nicht nur korrigieren, sondern nachvollziehbar vermitteln.', 'published', 10, '2026-07-26 07:38:22', '2026-07-26 07:38:22'),
(2, 'franzoesisch', 'FRA', 'karriere-franzoesisch.php', 'Nachhilfelehrkraft Französisch', 'Französisch sprechen, verstehen und mit Freude anwenden.', 'Gesucht werden sprachbegeisterte Lehrkräfte, die Aussprache, Grammatik, Hörverstehen und Kommunikation lebendig miteinander verbinden.', 'published', 20, '2026-07-26 07:38:22', '2026-07-26 07:38:22'),
(3, 'spanisch', 'SPAN', 'karriere-spanisch.php', 'Nachhilfelehrkraft Spanisch', 'Eine Weltsprache entdecken – verständlich, lebendig und persönlich.', 'Gesucht werden Lehrkräfte, die Lernende zum Sprechen ermutigen und Grammatik mit alltagsnaher Kommunikation verbinden.', 'published', 30, '2026-07-26 07:38:22', '2026-07-26 07:38:22'),
(4, 'soziale-faecher', 'SOZ', 'karriere-soziale-faecher.php', 'Nachhilfelehrkraft Soziale Fächer', 'Zusammenhänge erkennen. Quellen prüfen. Eigene Urteile begründen.', 'Gesucht werden Lehrkräfte für Geschichte, Geographie, Gemeinschaftskunde, Sozialkunde, Ethik und verwandte Fächer.', 'published', 40, '2026-07-26 07:38:22', '2026-07-26 07:38:22');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `career_job_items`
--

CREATE TABLE `career_job_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `career_job_id` int(10) UNSIGNED NOT NULL,
  `item_type` enum('subject','value','requirement','profile') NOT NULL,
  `item_text` varchar(1000) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `career_job_items`
--

INSERT INTO `career_job_items` (`id`, `career_job_id`, `item_type`, `item_text`, `sort_order`) VALUES
(1, 1, 'subject', 'Deutsch', 10),
(2, 1, 'subject', 'Deutsch als Zweitsprache', 20),
(3, 1, 'subject', 'Literatur', 30),
(4, 1, 'subject', 'Prüfungsvorbereitung', 40),
(5, 1, 'value', 'Verstehen statt Auswendiglernen', 10),
(6, 1, 'value', 'Geduldige und klare Rückmeldung', 20),
(7, 1, 'value', 'Individuelle Stundenplanung', 30),
(8, 1, 'value', 'Respekt vor unterschiedlichen Ausdruckswegen', 40),
(9, 1, 'requirement', 'Sehr sichere Deutschkenntnisse', 10),
(10, 1, 'requirement', 'Freude an Sprache, Texten und Literatur', 20),
(11, 1, 'requirement', 'Fähigkeit, Regeln anschaulich zu erklären', 30),
(12, 1, 'requirement', 'Zuverlässige Vor- und Nachbereitung', 40),
(13, 1, 'profile', 'Lehramts- oder Germanistikstudierende', 10),
(14, 1, 'profile', 'Lehrkräfte und pensionierte Lehrkräfte', 20),
(15, 1, 'profile', 'DaZ-/DaF-Fachkräfte', 30),
(16, 1, 'profile', 'Fachlich geeignete Quereinsteigerinnen und Quereinsteiger', 40);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `person_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('email','phone','contact_form') DEFAULT 'contact_form',
  `contact_value` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','read','answered','closed') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `contact_requests`
--

CREATE TABLE `contact_requests` (
  `request_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `level` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','processing','answered','closed','spam') NOT NULL DEFAULT 'new',
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `response_mail_sent` tinyint(1) NOT NULL DEFAULT 0,
  `notification_mail_sent` tinyint(1) NOT NULL DEFAULT 0,
  `mail_error` text DEFAULT NULL,
  `source_page` varchar(255) NOT NULL DEFAULT '/kontakt.php',
  `ip_hash` char(64) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content_items`
--

CREATE TABLE `content_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_type` enum('faq','review','job','blog') NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(190) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `body` longtext NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(320) DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `reviewer_name` varchar(120) DEFAULT NULL,
  `reviewer_age` smallint(5) UNSIGNED DEFAULT NULL,
  `reviewer_school_type` varchar(120) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `slot_id` bigint(20) UNSIGNED DEFAULT NULL,
  `media_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content_revisions`
--

CREATE TABLE `content_revisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content_item_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `body` longtext NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(320) DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `reviewer_name` varchar(120) DEFAULT NULL,
  `reviewer_age` smallint(5) UNSIGNED DEFAULT NULL,
  `reviewer_school_type` varchar(120) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL,
  `changed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `content_slots`
--

CREATE TABLE `content_slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slot_name` varchar(190) NOT NULL,
  `page_key` varchar(100) NOT NULL DEFAULT 'home',
  `label` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL DEFAULT '',
  `sort_order` int(11) NOT NULL DEFAULT 100,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `content_slots`
--

INSERT INTO `content_slots` (`id`, `slot_name`, `page_key`, `label`, `description`, `sort_order`, `active`, `created_at`, `updated_at`) VALUES
(1, 'home.hero', 'home', 'Hero / Startbereich', 'Hauptbereich am Anfang der Startseite', 10, 1, '2026-07-20 12:32:42', '2026-07-20 12:32:42'),
(2, 'home.subjects', 'home', 'Fächer', 'Übersicht der angebotenen Fächer', 20, 1, '2026-07-20 12:32:42', '2026-07-20 12:32:42'),
(3, 'home.about', 'home', 'easyIT kennenlernen', 'Orientierung, Methodik und Vorstellung', 30, 1, '2026-07-20 12:32:42', '2026-07-20 12:32:42'),
(4, 'home.faq', 'home', 'Häufige Fragen', 'FAQ-Bereich der Startseite', 40, 1, '2026-07-20 12:32:42', '2026-07-20 12:32:42'),
(5, 'home.contact', 'home', 'Call-to-Action / Kontakt', 'Kontaktaufforderung der Startseite', 50, 1, '2026-07-20 12:32:42', '2026-07-20 12:32:42'),
(6, 'home.footer', 'home', 'Nach dem letzten Startseitenbereich', 'Zusätzliche Inhalte am Ende der Startseite', 60, 1, '2026-07-20 12:32:42', '2026-07-20 12:32:42');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `homepage_blocks`
--

CREATE TABLE `homepage_blocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `block_type` varchar(50) NOT NULL DEFAULT 'neu',
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `image_crop` varchar(30) DEFAULT NULL,
  `sticker` varchar(50) DEFAULT NULL,
  `sticker_position` varchar(30) DEFAULT 'top-right',
  `sticker_image` varchar(1000) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_url` varchar(1000) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `homepage_blocks`
--

INSERT INTO `homepage_blocks` (`id`, `block_type`, `title`, `content`, `image`, `image_crop`, `sticker`, `sticker_position`, `sticker_image`, `button_text`, `button_url`, `position`, `active`, `valid_from`, `valid_until`, `created_at`, `updated_at`) VALUES
(1, 'neu', 'NEU: Prüfungsvorbereitung', 'Gezielte Vorbereitung auf Klassenarbeiten und Prüfungen.', '/assets/img/stud-lern.png', NULL, NULL, 'top-right', NULL, 'Mehr erfahren', '/kontakt.php', 1, 0, NULL, NULL, '2026-07-25 04:42:02', '2026-07-25 07:15:42'),
(2, 'veranstaltung', 'Mathe Workshop', 'Intensiver Workshop für Schülerinnen und Schüler.', '/assets/img/subjects/mathe.svg', NULL, NULL, 'top-right', NULL, 'Anmelden', '/kontakt.php', 2, 0, NULL, NULL, '2026-07-25 04:42:02', '2026-07-25 07:15:49'),
(3, 'veranstaltung', 'Ferienkurs Sommer', 'Lernen in den Ferien mit klarer Struktur.', '/assets/img/lern-stud.svg', NULL, NULL, 'top-right', NULL, 'Infos', '/kontakt.php', 3, 0, NULL, NULL, '2026-07-25 04:42:02', '2026-07-25 07:15:58'),
(4, 'gutschein', 'Nachhilfe verschenken', 'Ein Gutschein für individuelle Unterstützung.', '/assets/img/gutschein.png', NULL, NULL, 'top-right', NULL, 'Gutschein anfragen', '/kontakt.php', 4, 0, NULL, NULL, '2026-07-25 04:42:02', '2026-07-25 07:16:08'),
(5, 'neu', 'Neue Lernwerkzeuge', 'Digitale Hilfen für besseres Lernen.', '/assets/img/lern-stud.svg', NULL, NULL, 'top-right', NULL, 'Entdecken', '/lernwerkzeuge.php', 5, 0, NULL, NULL, '2026-07-25 04:42:02', '2026-07-25 07:16:16');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `image_credits`
--

CREATE TABLE `image_credits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `credit_from` varchar(255) DEFAULT NULL COMMENT 'Von / Beginn / Herkunft',
  `credit_to` varchar(255) DEFAULT NULL COMMENT 'Bis / Ende / Ziel',
  `page_name` varchar(255) NOT NULL COMMENT 'Bezeichnung der verwendenden Seite',
  `page_url` varchar(500) DEFAULT NULL,
  `index_nr` int(10) UNSIGNED DEFAULT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `author_url` varchar(500) DEFAULT NULL,
  `source_name` varchar(255) DEFAULT NULL,
  `source_url` varchar(500) DEFAULT NULL,
  `license_name` varchar(255) DEFAULT NULL,
  `license_url` varchar(500) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `image_credits`
--

INSERT INTO `image_credits` (`id`, `image_name`, `image_path`, `credit_from`, `credit_to`, `page_name`, `page_url`, `index_nr`, `author_name`, `author_url`, `source_name`, `source_url`, `license_name`, `license_url`, `note`, `valid_from`, `valid_until`, `active`, `created_at`, `updated_at`) VALUES
(1, 'beispielbild.jpg', 'assets/img/beispielbild.jpg', 'Bildanfang', 'Bildende', 'Startseite', '/index.php', 1, 'Urheber eintragen', NULL, 'Quelle eintragen', NULL, 'Lizenz eintragen', NULL, 'Musterdatensatz vor Veröffentlichung bearbeiten oder löschen.', NULL, NULL, 0, '2026-07-23 15:56:57', '2026-07-23 15:56:57');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `imprint_company`
--

CREATE TABLE `imprint_company` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `company` varchar(255) NOT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `imprint_company`
--

INSERT INTO `imprint_company` (`id`, `role_id`, `company`, `prefix`, `suffix`, `created_at`, `updated_at`) VALUES
(1, 2, 'easyIT Nachhilfe Leipzig', NULL, 'Kleinunternehmen nach § 19 UStG', '2026-07-22 04:39:32', '2026-07-22 04:39:32');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `imprint_persons`
--

CREATE TABLE `imprint_persons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_role` bigint(20) UNSIGNED NOT NULL,
  `salutation` varchar(40) NOT NULL DEFAULT '',
  `title` varchar(120) NOT NULL DEFAULT '',
  `firstname` varchar(120) NOT NULL,
  `lastname` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `imprint_persons`
--

INSERT INTO `imprint_persons` (`id`, `to_role`, `salutation`, `title`, `firstname`, `lastname`) VALUES
(1, 1, 'Herr', 'Dipl.-Ing.', 'Olaf', 'Thiele'),
(2, 3, 'Herr', 'Dipl.-Ing.', 'Olaf', 'Thiele'),
(3, 4, 'Herr', '', 'Olaf', 'Thiele'),
(4, 2, 'Herr', 'Dipl.-Ing.', 'Olaf', 'Thiele');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `imprint_roles`
--

CREATE TABLE `imprint_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('admin','company','personal','tutor','other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `imprint_roles`
--

INSERT INTO `imprint_roles` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'company'),
(3, 'personal'),
(4, 'tutor'),
(5, 'other');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `media_assets`
--

CREATE TABLE `media_assets` (
  `media_id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(500) NOT NULL,
  `mime_type` varchar(100) NOT NULL,
  `filesize` bigint(20) UNSIGNED DEFAULT 0,
  `width` int(10) UNSIGNED DEFAULT NULL,
  `height` int(10) UNSIGNED DEFAULT NULL,
  `alt_text` varchar(500) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `media_type` enum('image','document','video','other') DEFAULT 'image',
  `uploaded_by` bigint(20) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `navigation_items`
--

CREATE TABLE `navigation_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(120) NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '#',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `navigation_items`
--

INSERT INTO `navigation_items` (`id`, `parent_id`, `title`, `url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Start', '/index.php', 10, 1, '2026-07-20 07:28:49', '2026-07-20 07:28:49'),
(2, NULL, 'Über', '#', 20, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(3, NULL, 'Fächer', '/faecher.php', 30, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(4, NULL, 'Schulformen', '/schulformen.php', 40, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(5, NULL, 'Sonstiges', '#', 50, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(6, 2, 'Warum easyIT?', '/warum-easyit.php', 10, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(7, 2, 'Über', '/ueber-mich.php', 20, 1, '2026-07-20 07:28:50', '2026-07-25 06:06:26'),
(8, 2, 'Methodik', '/methodik.php', 30, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(9, 2, 'Bewertungen', '/bewertungen.php', 40, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(10, 3, 'Naturwissenschaften', '#', 10, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(11, 3, 'Sprachen', '#', 20, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(12, 3, 'Gesellschaft', '#', 30, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(13, 10, 'Mathematik', '/mathe-nachhilfe-leipzig.php', 10, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(14, 10, 'Physik', '/physik-nachhilfe-leipzig.php', 20, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(15, 10, 'Chemie', '/chemie-nachhilfe-leipzig.php', 30, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(16, 10, 'Informatik', '/informatik-nachhilfe-leipzig.php', 40, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(17, 11, 'Deutsch', '/deutsch-nachhilfe-leipzig.php', 10, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(18, 11, 'Englisch', '/englisch-nachhilfe-leipzig.php', 20, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(19, 11, 'Französisch', '/franzoesisch-nachhilfe-leipzig.php', 30, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(20, 11, 'Spanisch', '/spanisch-nachhilfe-leipzig.php', 40, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(21, 11, 'Latein', '/latein-nachhilfe-leipzig.php', 50, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(22, 12, 'Ethik', '/ethik-nachhilfe-leipzig.php', 10, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(23, 4, 'Grundschule', '/nachhilfe-grundschule-leipzig.php', 10, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(24, 4, 'Oberschule', '/nachhilfe-oberschule-leipzig.php', 20, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(25, 4, 'Gymnasium', '/nachhilfe-gymnasium-leipzig.php', 30, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(26, 4, 'Berufsschule', '/nachhilfe-berufsschule-leipzig.php', 40, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(27, 4, 'Abitur', '/abiturvorbereitung-leipzig.php', 50, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(28, 4, 'Studium', '/nachhilfe-studium-leipzig.php', 60, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(29, 5, 'Leipzig & Stadtteile', '/nachhilfe-in-leipzig.php', 10, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(30, 5, 'Lernwerkzeuge', '/lernwerkzeuge.php', 20, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(31, 5, 'Lernblog', '/blog.php', 30, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(32, 5, 'Preise & Ablauf', '/preise.php', 40, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(33, 5, 'FAQ', '/faq.php', 50, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(34, 5, 'Jobs', '/jobs.php', 60, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(35, 5, 'Sitemap', '/sitemap.php', 70, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
(36, 5, 'Bildnachweis', '/nh_hor/bildnachweis.php', 80, 1, '2026-07-23 16:11:02', '2026-07-23 16:11:02'),
(37, NULL, 'Karriere', '/karriere.php', 90, 1, '2026-07-26 04:25:02', '2026-07-26 04:25:02');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_person` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_key` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_key`, `description`) VALUES
(1, 'content.edit', 'Content bearbeiten'),
(2, 'content.delete', 'Content löschen'),
(3, 'media.upload', 'Medien hochladen'),
(4, 'media.delete', 'Medien löschen'),
(5, 'seo.edit', 'SEO bearbeiten'),
(6, 'user.manage', 'Benutzer verwalten');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `permissions_roles`
--

CREATE TABLE `permissions_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `permissions_roles`
--

INSERT INTO `permissions_roles` (`role_id`, `role_name`, `description`) VALUES
(1, 'superadmin', 'vollständiger Zugriff'),
(2, 'admin', 'Systemverwaltung'),
(3, 'editor', 'Content Bearbeitung'),
(4, 'author', 'Beiträge erstellen'),
(5, 'viewer', 'Nur Lesen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `persons`
--

CREATE TABLE `persons` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `salutation` varchar(50) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `company` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `house_number` varchar(50) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT 'Deutschland',
  `notes` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `persons`
--

INSERT INTO `persons` (`id`, `role_id`, `salutation`, `title`, `firstname`, `lastname`, `created_at`, `company`, `birthday`, `street`, `house_number`, `zip`, `city`, `country`, `notes`, `active`, `updated_at`) VALUES
(1, 3, 'Herr', 'Dipl.-Ing.', 'Olaf', 'Thiele', '2026-07-22 04:39:32', NULL, NULL, NULL, NULL, NULL, NULL, 'Deutschland', 0, 1, '2026-07-22 12:14:32');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `rolle` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `roles`
--

INSERT INTO `roles` (`id`, `rolle`, `created_at`) VALUES
(1, 'admin', '2026-07-22 04:39:32'),
(2, 'company', '2026-07-22 04:39:32'),
(3, 'personal', '2026-07-22 04:39:32'),
(4, 'tutor', '2026-07-22 04:39:32');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schema_migrations`
--

CREATE TABLE `schema_migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `migration` varchar(190) NOT NULL,
  `checksum` char(64) NOT NULL,
  `status` enum('running','applied','failed') NOT NULL,
  `started_at` datetime NOT NULL DEFAULT current_timestamp(),
  `finished_at` datetime DEFAULT NULL,
  `duration_ms` int(10) UNSIGNED DEFAULT NULL,
  `error_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `schema_migrations`
--

INSERT INTO `schema_migrations` (`id`, `migration`, `checksum`, `status`, `started_at`, `finished_at`, `duration_ms`, `error_message`) VALUES
(1, '20260716_001_content_indexes.sql', 'd8d27d5c7445edb699061b0c15243a51f87d02abd66f79ba52a1925fdf30dce4', 'applied', '2026-07-20 06:05:10', '2026-07-20 06:05:10', 0, NULL),
(2, '20260717_002_review_metadata.sql', '099e09c77136e0024a6b3b3bbdd8e3675dc2174f81da30b9919c980535bd0883', 'applied', '2026-07-20 06:05:10', '2026-07-20 06:05:10', 0, NULL),
(3, '20260718_003_tutoren.sql', '7ededa66bc0a874bbeb51d628cff8ecbe58c5512065c0aa3a7c83bdee9bd9b6f', 'applied', '2026-07-20 06:05:10', '2026-07-20 06:05:10', 0, NULL),
(4, '20260718_004_tutor_bewertungen.sql', 'a91f997fa1857764ef1ba5f34252d001c7f2165d0912166fde5a9e8729b8b6f1', 'applied', '2026-07-20 06:05:10', '2026-07-20 06:05:10', 0, NULL),
(5, '20260720_005_innodb_normalisierung.sql', '737ce0e110d921e0cdd47c1e622b34261cd3b2c3f74b14cd922234d100c228ea', 'applied', '2026-07-20 06:05:10', '2026-07-20 06:05:10', 0, NULL),
(6, 'easyit_revision_1.1.1_final', '', 'running', '2026-07-22 06:11:47', NULL, NULL, NULL),
(0, '2026-07-23_image_credits_v2', 'bf4ffdf6f180c4483dcf06d34f7114a225d960bcc0d9a725bb9bd4fb4a9ffb8a', '', '2026-07-23 17:56:57', '2026-07-23 17:56:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `seo_meta`
--

CREATE TABLE `seo_meta` (
  `seo_id` bigint(20) UNSIGNED NOT NULL,
  `object_type` enum('page','content','block','category') NOT NULL,
  `object_id` bigint(20) UNSIGNED NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `canonical_url` varchar(500) DEFAULT NULL,
  `robots` enum('index_follow','index_nofollow','noindex_follow','noindex_nofollow') DEFAULT 'index_follow',
  `og_title` varchar(255) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `og_image` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tutors`
--

CREATE TABLE `tutors` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(160) NOT NULL,
  `display_name` varchar(160) NOT NULL,
  `professional_title` varchar(190) NOT NULL,
  `short_intro` text NOT NULL,
  `biography` text NOT NULL,
  `teaching_approach` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_alt` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `tutors`
--

INSERT INTO `tutors` (`id`, `slug`, `display_name`, `professional_title`, `short_intro`, `biography`, `teaching_approach`, `image_path`, `image_alt`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'olaf-thiele', 'Olaf Thiele', 'Tutor für Mathematik, Physik, Chemie und Informatik', 'Fachübergreifende Lernbegleitung für Schule, Ausbildung, Abitur und Studium.', 'Olaf Thiele verbindet mathematisches, naturwissenschaftliches und informatisches Denken. Im Unterricht werden Zusammenhänge sichtbar gemacht, statt einzelne Verfahren nur auswendig zu lernen.', 'Ausgangspunkt ist immer der aktuelle Denkweg des Lernenden. Begriffe werden geklärt, Lösungswege schriftlich strukturiert, Fehler als Diagnose genutzt und Ergebnisse anschließend selbstständig überprüft.', 'assets/img/tutors/olaf-thiele.svg', 'Porträtgrafik von Olaf Thiele', 1, 10, '2026-07-20 06:05:09', '2026-07-20 06:05:09'),
(2, 'sprachentutorin', 'Sprachentutorin', 'Tutorin für Deutsch, Englisch, Französisch, Spanisch und Latein', 'Sprachliche Sicherheit durch verständliche Grammatik, aktiven Wortschatz und adressatengerechten Ausdruck.', 'Der Sprachunterricht verbindet systematischen Aufbau mit konkreter Anwendung. Lesen, Schreiben, Sprechen und Sprachreflexion werden passend zum Lernstand miteinander verknüpft.', 'Neue Strukturen werden an Beispielen eingeführt, gemeinsam angewendet und in kleinen Übungsschritten gesichert. Rückmeldungen zeigen nicht nur Fehler, sondern erklären, wie eine bessere Formulierung entsteht.', 'assets/img/tutors/sprachentutorin.svg', 'Porträtgrafik einer Sprachentutorin', 1, 20, '2026-07-20 06:05:09', '2026-07-20 06:05:09'),
(3, 'ethiktutor', 'Tutor für Ethik', 'Tutor für Ethik, Philosophie und gesellschaftliche Fragestellungen', 'Argumentieren lernen, Positionen prüfen und eigene Urteile nachvollziehbar begründen.', 'Der Ethikunterricht erschließt Begriffe, Konflikte und philosophische Positionen. Unterschiedliche Sichtweisen werden sachlich verglichen und auf konkrete Lebens- und Prüfungssituationen bezogen.', 'Diskussionen werden durch Leitfragen, Begriffsarbeit und Argumentationsmodelle strukturiert. Ziel ist kein vorgegebenes Urteil, sondern eine fachlich begründete, sprachlich klare und reflektierte Position.', 'assets/img/tutors/ethiktutor.svg', 'Porträtgrafik eines Tutors für Ethik', 1, 30, '2026-07-20 06:05:09', '2026-07-20 06:05:09'),
(0, 'olaf-thiele', 'Dipl.-Ing. Olaf Thiele', 'Tutor für Mathematik, Physik, Chemie und Informatik', 'Strukturiert, geduldig und fachübergreifend: Der Unterricht wird individuell vorbereitet und an Lernstand, Arbeitstempo und aktuelle Schulthemen angepasst.', 'Olaf Thiele ist Diplom-Ingenieur der Verfahrenstechnik und arbeitet fachübergreifend in Mathematik, Physik, Chemie und Informatik. Sein technischer Hintergrund unterstützt ihn dabei, Zusammenhänge sichtbar zu machen und Lösungswege nicht nur vorzugeben, sondern nachvollziehbar herzuleiten.', 'Jede Einheit beginnt mit einer kurzen Einordnung der aktuellen Situation. Anschließend wird mit vorbereiteten, individuell passenden Aufgaben gearbeitet. Eigene Lösungsvorschläge werden aufgenommen und gemeinsam geprüft. Zum Abschluss wird reflektiert, was verstanden wurde und welcher nächste Lernschritt sinnvoll ist.', '/assets/img/tutors/olaf-thiele.webp', 'Dipl.-Ing. Olaf Thiele, Tutor bei easyIT Leipzig', 1, 10, '2026-07-25 08:30:23', '2026-07-25 08:30:23');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tutor_competencies`
--

CREATE TABLE `tutor_competencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `tutor_id` int(10) UNSIGNED NOT NULL,
  `category` enum('fach','methodik','didaktik','faehigkeit','qualifikation') NOT NULL,
  `title` varchar(190) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `tutor_competencies`
--

INSERT INTO `tutor_competencies` (`id`, `tutor_id`, `category`, `title`, `description`, `sort_order`) VALUES
(9, 2, 'fach', 'Deutsch', 'Grammatik, Rechtschreibung, Textanalyse, Erörterung und adressatengerechtes Schreiben.', 10),
(10, 2, 'fach', 'Englisch', 'Wortschatz, Grammatik, Textproduktion, Lese- und Hörverstehen sowie Prüfungskommunikation.', 20),
(11, 2, 'fach', 'Französisch, Spanisch und Latein', 'Sprachsystem, Übersetzung, Ausdruck, Textverständnis und kontinuierlicher Wortschatzaufbau.', 30),
(12, 2, 'methodik', 'Sprachhandeln in kleinen Schritten', 'Neue Strukturen werden erklärt, modelliert, angewendet und anschließend in freien Aufgaben gesichert.', 10),
(13, 2, 'didaktik', 'Fehlersensible Rückmeldung', 'Korrekturen benennen Regel, Wirkung und konkrete Verbesserungsmöglichkeit.', 20),
(14, 2, 'faehigkeit', 'Differenzierte Ausdrucksförderung', 'Wortschatz und Satzbau werden passend zu Schulform, Aufgabe und individuellem Lernstand entwickelt.', 30),
(15, 2, 'qualifikation', 'Sprachdidaktische Ausrichtung', 'Kompetenzorientierte Verbindung von Grammatik, Textarbeit und kommunikativer Anwendung.', 40),
(16, 3, 'fach', 'Ethik und Philosophie', 'Normen, Werte, Menschenbilder, Argumentationstheorie und ausgewählte philosophische Positionen.', 10),
(17, 3, 'fach', 'Gesellschaftliche Konfliktfelder', 'Anwendung ethischer Modelle auf Technik, Umwelt, Verantwortung, Freiheit und Gerechtigkeit.', 20),
(18, 3, 'methodik', 'Strukturierte Argumentationsanalyse', 'Behauptung, Begründung, Beispiel, Einwand und Schlussfolgerung werden klar unterschieden.', 10),
(19, 3, 'didaktik', 'Perspektivwechsel ohne Beliebigkeit', 'Unterschiedliche Positionen werden offen geprüft und zugleich an fachlichen Kriterien gemessen.', 20),
(20, 3, 'faehigkeit', 'Moderation sachlicher Diskussionen', 'Kontroverse Fragen werden wertschätzend, begrifflich präzise und ergebnisoffen bearbeitet.', 30),
(21, 3, 'qualifikation', 'Philosophisch-ethische Fachorientierung', 'Sichere Arbeit mit Begriffen, Positionen, Texten und prüfungsrelevanten Urteilsformaten.', 40),
(0, 1, 'fach', 'Mathematik', 'Grundlagen, Algebra, Funktionen, Analysis, Geometrie und Prüfungsvorbereitung.', 10),
(0, 1, 'fach', 'Physik und Chemie', 'Naturwissenschaftliche Zusammenhänge werden schrittweise aus Modellen, Formeln und Experimenten erschlossen.', 20),
(0, 1, 'fach', 'Informatik', 'Algorithmen, Programmierung, Datenbanken und technische Grundlagen.', 30),
(0, 1, 'methodik', 'Individuelle Vorbereitung', 'Arbeitsblätter und Aufgaben werden vor der Stunde an Lernstand, Defizite, Unterrichtsthema und Arbeitstempo angepasst.', 10),
(0, 1, 'methodik', 'Klare Stundenstruktur', 'Persönlicher Einstieg, konzentrierte Arbeitsphase und gemeinsame Abschlussreflexion.', 20),
(0, 1, 'methodik', 'Dokumentierte Lernwege', 'Erarbeitete Lösungen werden geordnet festgehalten, damit Lernende später gezielt darauf zurückgreifen können.', 30),
(0, 1, 'didaktik', 'Mehrere Erklärungswege', 'Bei Rückfragen wird ein Problem neu und auf andere Weise erklärt, bis der Lösungsweg nachvollziehbar ist.', 10),
(0, 1, 'didaktik', 'Eigene Lösungen ernst nehmen', 'Vorschläge der Lernenden werden verstanden, geprüft und in die Unterrichtsführung einbezogen.', 20),
(0, 1, 'didaktik', 'Reflexion des Lernerfolgs', 'Am Ende wird gemeinsam geklärt, was gelernt wurde und was als Nächstes gefestigt werden muss.', 30),
(0, 1, 'faehigkeit', 'Geduld und persönliche Aufmerksamkeit', 'Rückmeldungen beschreiben den Unterricht wiederholt als geduldig, persönlich und an der Situation der Lernenden orientiert.', 10),
(0, 1, 'faehigkeit', 'Fachübergreifendes Denken', 'Der ingenieurwissenschaftliche Hintergrund erleichtert die Verbindung mathematischer, naturwissenschaftlicher und technischer Themen.', 20),
(0, 1, 'qualifikation', 'Diplom-Ingenieur Verfahrenstechnik', 'Ingenieurwissenschaftlicher Studienabschluss mit breiter mathematisch-naturwissenschaftlicher Grundlage.', 10),
(0, 1, 'qualifikation', 'Langjährige Unterrichtspraxis', 'Erfahrung in der individuellen und gruppenbezogenen Förderung unterschiedlicher Klassenstufen.', 20);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tutor_reviews`
--

CREATE TABLE `tutor_reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `tutor_id` int(10) UNSIGNED NOT NULL,
  `reviewer_name` varchar(120) NOT NULL,
  `reviewer_context` varchar(190) DEFAULT NULL,
  `review_date` date NOT NULL,
  `stars` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `review_text` text NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `tutor_reviews`
--

INSERT INTO `tutor_reviews` (`id`, `tutor_id`, `reviewer_name`, `reviewer_context`, `review_date`, `stars`, `review_text`, `is_published`, `sort_order`, `created_at`) VALUES
(5, 2, 'Sophie', 'Gymnasium, Englisch', '2026-06-08', 5, 'Meine Texte sind deutlich klarer geworden. Fehler werden nicht einfach markiert, sondern so erklärt, dass ich beim nächsten Text selbst darauf achten kann.', 1, 10, '2026-07-20 06:05:10'),
(6, 2, 'Emilia', 'Oberschule, Deutsch', '2026-04-29', 5, 'Die Grammatikregeln werden mit verständlichen Beispielen aufgebaut. Besonders gut finde ich, dass wir danach sofort eigene Sätze und Texte schreiben.', 1, 20, '2026-07-20 06:05:10'),
(7, 2, 'Noah', 'Gymnasium, Französisch', '2026-03-17', 4, 'Der Unterricht hilft mir, Wortschatz und Grammatik gemeinsam anzuwenden. Beim Sprechen bin ich inzwischen viel sicherer.', 1, 30, '2026-07-20 06:05:10'),
(8, 2, 'Charlotte', 'Abiturvorbereitung Deutsch', '2026-01-21', 5, 'Textanalysen und Erörterungen haben endlich eine klare Struktur. Ich weiß jetzt, wie ich aus meinen Gedanken eine nachvollziehbare Argumentation mache.', 1, 40, '2026-07-20 06:05:10'),
(9, 3, 'Max', 'Gymnasium, Klasse 10', '2026-06-14', 5, 'Wir diskutieren nicht einfach nur Meinungen, sondern prüfen Begriffe, Argumente und Gegenargumente. Dadurch kann ich meine Position viel besser begründen.', 1, 10, '2026-07-20 06:05:10'),
(10, 3, 'Anna', 'Abiturvorbereitung Ethik', '2026-05-05', 5, 'Philosophische Positionen wurden verständlich gegenübergestellt und direkt auf Prüfungsaufgaben angewendet. Das hat mir beim Schreiben sehr geholfen.', 1, 20, '2026-07-20 06:05:10'),
(11, 3, 'Leon', 'Oberschule, Klasse 9', '2026-03-26', 5, 'Ich habe gelernt, Behauptung, Begründung und Beispiel sauber zu trennen. Diskussionen fühlen sich dadurch weniger chaotisch an.', 1, 30, '2026-07-20 06:05:10'),
(12, 3, 'Nele', 'Gymnasium, Klasse 11', '2026-02-12', 4, 'Auch bei schwierigen Themen bleibt der Unterricht sachlich und offen. Gleichzeitig wird genau darauf geachtet, ob ein Argument wirklich trägt.', 1, 40, '2026-07-20 06:05:10'),
(0, 1, 'Pierre Freiberg', 'Öffentliche Google-Bewertung · Vater eines Schülers', '2026-04-01', 5, 'Unser Sohn geht nun fast ein Jahr zur Mathe-Nachhilfe. Herr Thiele ist der Lehrer und wir alle sind sehr zufrieden. Um zwei Noten hat er sich verbessert. Für uns 100 Prozent Weiterempfehlung.', 1, 0, '2026-07-25 08:30:23'),
(0, 1, 'Silvia Hilpert', 'Öffentliche Google-Bewertung · Mutter eines Schülers', '2026-03-01', 5, 'Unser Sohn geht mittlerweile schon ein Jahr zur Nachhilfe und wir haben es nicht bereut. Die Mathematiknoten haben sich bereits nach einem halben Jahr verbessert. Herr Thiele ist ein hervorragender Lehrer, bei dem man sehr viel lernen kann.', 1, 0, '2026-07-25 08:30:23'),
(0, 1, 'Susanne Canitz', 'Öffentliche Google-Bewertung · Mutter zweier Schülerinnen', '2026-01-01', 5, 'Meine beiden Töchter sind mit dem Mathematikunterricht sehr zufrieden. Beide sagen unabhängig voneinander, dass Herr Thiele der beste und geduldigste Mathematiklehrer ist, den sie bisher hatten. Seit Beginn der Nachhilfe haben sich ihre Schulnoten verbessert.', 1, 0, '2026-07-25 08:30:23'),
(0, 1, 'Lia Schubert', 'Öffentliche Google-Bewertung · Schülerin', '2025-11-01', 5, 'Ich gehe selbst zur Mathe-Nachhilfe und bin sehr zufrieden mit Herrn Thiele. Er ist modern und flexibel und bringt mir neue Inhalte sehr schnell bei.', 1, 0, '2026-07-25 08:30:23'),
(0, 1, 'Nike', 'Verifizierte Trustpilot-Bewertung', '2026-06-02', 5, 'Herr Thiele bereitet sich sehr gut auf den Unterricht vor und geht auf Wünsche und Schwächen ein. Man kann so oft nachfragen, wie man möchte, und er versucht jedes Mal, das Problem neu zu erklären. Am Ende gibt es eine Reflexion, von der beide Seiten lernen.', 1, 0, '2026-07-25 08:30:23'),
(0, 1, 'Familie Hilpert', 'Direkte Elternrückmeldung', '2026-02-01', 5, 'Unser Sohn ist mit dem Unterricht bei Herrn Thiele sehr zufrieden. Seine Mathematiknote auf dem Zeugnis hat sich wieder von 4 auf 3 verbessert.', 1, 0, '2026-07-25 08:30:23'),
(0, 1, 'Anonymisierte Schülerin', 'Persönliche Rückmeldung · mit Einwilligung', '2026-04-18', 5, 'Der Unterricht bei Herrn Thiele ist strukturierter, präziser und stabiler. Er interessiert sich stärker für die persönliche Situation der Schüler. Ich habe das Gefühl, in seinem Unterricht mehr für mich zu erreichen.', 1, 0, '2026-07-25 08:30:23'),
(0, 1, 'Anonymisierter Schüler', 'Persönliche Rückmeldung · mit Einwilligung', '2026-04-24', 5, 'Vor jeder Stunde gibt es einen kurzen persönlichen Einstieg. Am Ende wird zusammengefasst, was gelernt wurde. Eigene Lösungsvorschläge werden verstanden und in den Unterricht einbezogen, statt nur einen vorgegebenen Weg durchzusetzen.', 1, 0, '2026-07-25 08:30:23'),
(0, 1, 'Anonymisierte Schülerin', 'Persönliche Rückmeldung', '2026-04-25', 5, 'Die Arbeitsblätter sind bereits vor der Stunde vorbereitet und begleiten das aktuelle Unterrichtsthema. Dadurch kann Herr Thiele auf Fragen schneller reagieren und ein Thema besonders verständlich erklären.', 1, 0, '2026-07-25 08:30:23');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_addresses_person` (`to_person`),
  ADD KEY `idx_addresses_country_postal` (`country_code`,`postal_code`),
  ADD KEY `idx_addresses_primary` (`to_person`,`is_primary`);

--
-- Indizes für die Tabelle `add_index_content`
--
ALTER TABLE `add_index_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_add_index_content_runtime` (`active`,`position_no`,`placement`,`sort_order`),
  ADD KEY `idx_add_index_content_validity` (`valid_from`,`valid_until`),
  ADD KEY `idx_add_index_content_slot_runtime` (`slot_id`,`active`,`placement`,`sort_order`),
  ADD KEY `idx_add_index_media` (`media_id`);

--
-- Indizes für die Tabelle `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_audit_created_at` (`created_at`),
  ADD KEY `fk_audit_user` (`user_id`);

--
-- Indizes für die Tabelle `career_faq`
--
ALTER TABLE `career_faq`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_career_faq_job_sort` (`career_job_id`,`sort_order`);

--
-- Indizes für die Tabelle `career_images`
--
ALTER TABLE `career_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_career_images_job_role_sort` (`career_job_id`,`image_role`,`sort_order`);

--
-- Indizes für die Tabelle `career_jobs`
--
ALTER TABLE `career_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_career_jobs_key` (`job_key`),
  ADD UNIQUE KEY `uq_career_jobs_slug` (`slug`),
  ADD KEY `idx_career_jobs_status_sort` (`status`,`sort_order`);

--
-- Indizes für die Tabelle `career_job_items`
--
ALTER TABLE `career_job_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_career_items_job_type_sort` (`career_job_id`,`item_type`,`sort_order`);

--
-- Indizes für die Tabelle `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `idx_contact_status_created` (`status`,`created_at`),
  ADD KEY `idx_contact_email` (`email`),
  ADD KEY `idx_contact_assigned` (`assigned_to`);

--
-- Indizes für die Tabelle `homepage_blocks`
--
ALTER TABLE `homepage_blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_homepage_blocks_active_position` (`active`,`position`),
  ADD KEY `idx_homepage_blocks_runtime` (`active`,`valid_from`,`valid_until`,`position`);

--
-- Indizes für die Tabelle `image_credits`
--
ALTER TABLE `image_credits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_image_credits_active` (`active`),
  ADD KEY `idx_image_credits_page` (`page_name`),
  ADD KEY `idx_image_credits_index_nr` (`index_nr`),
  ADD KEY `idx_image_credits_validity` (`valid_from`,`valid_until`);

--
-- Indizes für die Tabelle `navigation_items`
--
ALTER TABLE `navigation_items`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notes_person` (`to_person`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `career_faq`
--
ALTER TABLE `career_faq`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `career_images`
--
ALTER TABLE `career_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT für Tabelle `career_jobs`
--
ALTER TABLE `career_jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `career_job_items`
--
ALTER TABLE `career_job_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `request_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `homepage_blocks`
--
ALTER TABLE `homepage_blocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `image_credits`
--
ALTER TABLE `image_credits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `navigation_items`
--
ALTER TABLE `navigation_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT für Tabelle `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `career_faq`
--
ALTER TABLE `career_faq`
  ADD CONSTRAINT `fk_career_faq_job` FOREIGN KEY (`career_job_id`) REFERENCES `career_jobs` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `career_images`
--
ALTER TABLE `career_images`
  ADD CONSTRAINT `fk_career_images_job` FOREIGN KEY (`career_job_id`) REFERENCES `career_jobs` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `career_job_items`
--
ALTER TABLE `career_job_items`
  ADD CONSTRAINT `fk_career_items_job` FOREIGN KEY (`career_job_id`) REFERENCES `career_jobs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
