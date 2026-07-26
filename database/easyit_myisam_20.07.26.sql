-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Jul 2026 um 14:33
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
) ;

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
  `css_content` mediumtext DEFAULT NULL,
  `js_content` mediumtext DEFAULT NULL,
  `wrapper_class` varchar(255) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 100,
  `valid_from` datetime DEFAULT NULL,
  `valid_until` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

--
-- Daten für Tabelle `add_index_content`
--

INSERT INTO `add_index_content` (`id`, `internal_name`, `title`, `slot_id`, `position_no`, `placement`, `html_content`, `css_content`, `js_content`, `wrapper_class`, `active`, `sort_order`, `valid_from`, `valid_until`, `created_at`, `updated_at`) VALUES
(1, 'summer_sale_2026', 'Sommersale 2026', 1, 1, 'before', '<div class=\"container\"><strong>SOMMERSALE</strong><br>Jetzt Nachhilfe zum Ferienpreis sichern.<br><a class=\"button button--gold\" href=\"/kontakt.php\">Jetzt Termin vereinbaren</a></div>', '.promo-summer{background:#ffb300;color:#222;padding:30px;text-align:center;border-radius:18px;margin-bottom:24px}.promo-summer strong{font-size:clamp(1.6rem,4vw,2.8rem)}', '', 'promo-banner promo-summer', 1, 10, '2026-07-20 00:00:00', '2026-08-31 23:59:59', '2026-07-20 12:33:14', '2026-07-20 12:33:14'),
(2, 'mathe_workshop', 'Kostenloser Mathe-Workshop', 2, 2, 'after', '<div class=\"container\"><h2>Kostenloser Mathe-Workshop</h2><p>Samstag um 14 Uhr: Abiturvorbereitung Mathematik.</p><a class=\"button button--blue\" href=\"/kontakt.php\">Jetzt anmelden</a></div>', '.event-box{border:4px solid #0b63ce;padding:40px;margin:40px auto;text-align:center;border-radius:18px}', '', 'event-box', 1, 20, NULL, NULL, '2026-07-20 12:33:14', '2026-07-20 12:33:14'),
(3, 'christmas_special', 'Weihnachtsaktion', 5, 5, 'replace', '<div class=\"container\"><h2>Weihnachtsaktion</h2><p>Verschenke Nachhilfe-Gutscheine.</p><a class=\"button button--gold\" href=\"/kontakt.php\">Gutschein bestellen</a></div>', '.christmas{background:#8f1111;color:#fff;padding:60px;border-radius:18px;text-align:center}', '', 'christmas', 1, 30, '2026-12-01 00:00:00', '2026-12-24 23:59:59', '2026-07-20 12:33:14', '2026-07-20 12:33:14'),
(4, 'holiday_notice', 'Ferienhinweis', 6, 6, 'after', '<div class=\"container\"><h3>Hinweis</h3><p>Während der Sommerferien sind Termine nach Vereinbarung möglich.</p></div>', '.holiday{background:#eee;padding:25px;font-size:.95rem;border-radius:14px;margin-top:24px}', '', 'holiday', 1, 40, NULL, NULL, '2026-07-20 12:33:14', '2026-07-20 12:33:14');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `email`, `password_hash`, `role`, `is_active`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'othiele', 'thiele.olaf@googlemail.com', '$2y$10$aMR8wLIohS2AwQx7qZEXIOnvfoW8rzogHY8kl4ECNM/59qx2Gt7s.', 'admin', 1, '2026-07-20 12:55:39', '2026-07-20 12:52:09', '2026-07-20 12:55:39');

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `audit_log`
--

INSERT INTO `audit_log` (`id`, `user_id`, `action`, `entity_type`, `entity_id`, `details`, `ip_hash`, `created_at`) VALUES
(1, 1, 'login_success', 'admin_session', NULL, '{\"username\":\"othiele\"}', 'eff8e7ca506627fe15dda5e0e512fcaad70b6d520f37cc76597fdb4f2d83a1a3', '2026-07-20 12:55:39'),
(2, 1, 'create', 'imprint_person', 4, '{\"to_role\":2}', 'eff8e7ca506627fe15dda5e0e512fcaad70b6d520f37cc76597fdb4f2d83a1a3', '2026-07-20 13:40:04');

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
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ;

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
-- Tabellenstruktur für Tabelle `imprint_persons`
--

CREATE TABLE `imprint_persons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_role` bigint(20) UNSIGNED NOT NULL,
  `saturation` varchar(40) NOT NULL DEFAULT '',
  `title` varchar(120) NOT NULL DEFAULT '',
  `firstname` varchar(120) NOT NULL,
  `lastname` varchar(120) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `imprint_persons`
--

INSERT INTO `imprint_persons` (`id`, `to_role`, `saturation`, `title`, `firstname`, `lastname`) VALUES
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(7, 2, 'Über mich', '/ueber-mich.php', 20, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50'),
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
(35, 5, 'Sitemap', '/sitemap.php', 70, 1, '2026-07-20 07:28:50', '2026-07-20 07:28:50');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `schema_migrations`
--

INSERT INTO `schema_migrations` (`id`, `migration`, `checksum`, `status`, `started_at`, `finished_at`, `duration_ms`, `error_message`) VALUES
(1, '20260716_001_content_indexes.sql', 'd8d27d5c7445edb699061b0c15243a51f87d02abd66f79ba52a1925fdf30dce4', 'applied', '2026-07-20 06:05:10', '2026-07-20 06:05:10', 0, NULL),
(2, '20260717_002_review_metadata.sql', '099e09c77136e0024a6b3b3bbdd8e3675dc2174f81da30b9919c980535bd0883', 'applied', '2026-07-20 06:05:10', '2026-07-20 06:05:10', 0, NULL),
(3, '20260718_003_tutoren.sql', '7ededa66bc0a874bbeb51d628cff8ecbe58c5512065c0aa3a7c83bdee9bd9b6f', 'applied', '2026-07-20 06:05:10', '2026-07-20 06:05:10', 0, NULL),
(4, '20260718_004_tutor_bewertungen.sql', 'a91f997fa1857764ef1ba5f34252d001c7f2165d0912166fde5a9e8729b8b6f1', 'applied', '2026-07-20 06:05:10', '2026-07-20 06:05:10', 0, NULL),
(5, '20260720_005_MyISAM_normalisierung.sql', '737ce0e110d921e0cdd47c1e622b34261cd3b2c3f74b14cd922234d100c228ea', 'applied', '2026-07-20 06:05:10', '2026-07-20 06:05:10', 0, NULL);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `tutors`
--

INSERT INTO `tutors` (`id`, `slug`, `display_name`, `professional_title`, `short_intro`, `biography`, `teaching_approach`, `image_path`, `image_alt`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'olaf-thiele', 'Olaf Thiele', 'Tutor für Mathematik, Physik, Chemie und Informatik', 'Fachübergreifende Lernbegleitung für Schule, Ausbildung, Abitur und Studium.', 'Olaf Thiele verbindet mathematisches, naturwissenschaftliches und informatisches Denken. Im Unterricht werden Zusammenhänge sichtbar gemacht, statt einzelne Verfahren nur auswendig zu lernen.', 'Ausgangspunkt ist immer der aktuelle Denkweg des Lernenden. Begriffe werden geklärt, Lösungswege schriftlich strukturiert, Fehler als Diagnose genutzt und Ergebnisse anschließend selbstständig überprüft.', 'assets/img/tutors/olaf-thiele.svg', 'Porträtgrafik von Olaf Thiele', 1, 10, '2026-07-20 06:05:09', '2026-07-20 06:05:09'),
(2, 'sprachentutorin', 'Sprachentutorin', 'Tutorin für Deutsch, Englisch, Französisch, Spanisch und Latein', 'Sprachliche Sicherheit durch verständliche Grammatik, aktiven Wortschatz und adressatengerechten Ausdruck.', 'Der Sprachunterricht verbindet systematischen Aufbau mit konkreter Anwendung. Lesen, Schreiben, Sprechen und Sprachreflexion werden passend zum Lernstand miteinander verknüpft.', 'Neue Strukturen werden an Beispielen eingeführt, gemeinsam angewendet und in kleinen Übungsschritten gesichert. Rückmeldungen zeigen nicht nur Fehler, sondern erklären, wie eine bessere Formulierung entsteht.', 'assets/img/tutors/sprachentutorin.svg', 'Porträtgrafik einer Sprachentutorin', 1, 20, '2026-07-20 06:05:09', '2026-07-20 06:05:09'),
(3, 'ethiktutor', 'Tutor für Ethik', 'Tutor für Ethik, Philosophie und gesellschaftliche Fragestellungen', 'Argumentieren lernen, Positionen prüfen und eigene Urteile nachvollziehbar begründen.', 'Der Ethikunterricht erschließt Begriffe, Konflikte und philosophische Positionen. Unterschiedliche Sichtweisen werden sachlich verglichen und auf konkrete Lebens- und Prüfungssituationen bezogen.', 'Diskussionen werden durch Leitfragen, Begriffsarbeit und Argumentationsmodelle strukturiert. Ziel ist kein vorgegebenes Urteil, sondern eine fachlich begründete, sprachlich klare und reflektierte Position.', 'assets/img/tutors/ethiktutor.svg', 'Porträtgrafik eines Tutors für Ethik', 1, 30, '2026-07-20 06:05:09', '2026-07-20 06:05:09');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `tutor_competencies`
--

INSERT INTO `tutor_competencies` (`id`, `tutor_id`, `category`, `title`, `description`, `sort_order`) VALUES
(1, 1, 'fach', 'Mathematik', 'Grundlagen, Analysis, Algebra, Geometrie, Stochastik und anwendungsbezogene Modellierung.', 10),
(2, 1, 'fach', 'Physik', 'Mechanik, Elektrizitätslehre, Optik, Thermodynamik und moderne Physik.', 20),
(3, 1, 'fach', 'Chemie', 'Stoffaufbau, Reaktionsgleichungen, Stöchiometrie, organische und physikalische Chemie.', 30),
(4, 1, 'fach', 'Informatik', 'Algorithmisches Denken, Programmierung, Datenbanken und technische Grundlagen.', 40),
(5, 1, 'methodik', 'Schriftlich strukturierte Lösungswege', 'Jeder Lösungsweg wird so dokumentiert, dass Annahmen, Teilschritte und Kontrollen nachvollziehbar bleiben.', 10),
(6, 1, 'didaktik', 'Fachübergreifende Verknüpfung', 'Mathematische, naturwissenschaftliche und informatische Zusammenhänge werden gezielt miteinander verbunden.', 20),
(7, 1, 'faehigkeit', 'Diagnose von Denkfehlern', 'Fehler werden nicht nur korrigiert, sondern auf Begriffs-, Verfahrens- oder Verständnislücken zurückgeführt.', 30),
(8, 1, 'qualifikation', 'Studien- und Berufserfahrung im technischen Umfeld', 'Breite technische Perspektive für schulische und studienbezogene Problemstellungen.', 40),
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
(21, 3, 'qualifikation', 'Philosophisch-ethische Fachorientierung', 'Sichere Arbeit mit Begriffen, Positionen, Texten und prüfungsrelevanten Urteilsformaten.', 40);

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
) ;

--
-- Daten für Tabelle `tutor_reviews`
--

INSERT INTO `tutor_reviews` (`id`, `tutor_id`, `reviewer_name`, `reviewer_context`, `review_date`, `stars`, `review_text`, `is_published`, `sort_order`, `created_at`) VALUES
(1, 1, 'Lena', 'Gymnasium, Klasse 11', '2026-06-24', 5, 'Mathematik wird nicht nur vorgerechnet. Ich verstehe inzwischen, warum ein Lösungsweg funktioniert, und kann ihn in neuen Aufgaben selbst anwenden.', 1, 10, '2026-07-20 06:05:10'),
(2, 1, 'Jonas', 'Abiturvorbereitung Mathematik und Physik', '2026-05-18', 5, 'Die Vorbereitung war sehr strukturiert. Besonders hilfreich waren die schriftlichen Lösungswege und die ehrliche Rückmeldung, an welcher Stelle mein Verständnis noch nicht sicher war.', 1, 20, '2026-07-20 06:05:10'),
(3, 1, 'Miriam', 'Studium, technische Grundlagen', '2026-03-11', 5, 'Komplexe Zusammenhänge wurden fachübergreifend erklärt. Dadurch konnte ich Formeln endlich mit ihrer Bedeutung verbinden, statt sie nur auswendig zu lernen.', 1, 30, '2026-07-20 06:05:10'),
(4, 1, 'Paul', 'Oberschule, Klasse 9', '2026-02-02', 4, 'Ich arbeite heute ordentlicher und erkenne meine eigenen Fehler schneller. Der Unterricht ist anspruchsvoll, aber immer nachvollziehbar.', 1, 40, '2026-07-20 06:05:10'),
(5, 2, 'Sophie', 'Gymnasium, Englisch', '2026-06-08', 5, 'Meine Texte sind deutlich klarer geworden. Fehler werden nicht einfach markiert, sondern so erklärt, dass ich beim nächsten Text selbst darauf achten kann.', 1, 10, '2026-07-20 06:05:10'),
(6, 2, 'Emilia', 'Oberschule, Deutsch', '2026-04-29', 5, 'Die Grammatikregeln werden mit verständlichen Beispielen aufgebaut. Besonders gut finde ich, dass wir danach sofort eigene Sätze und Texte schreiben.', 1, 20, '2026-07-20 06:05:10'),
(7, 2, 'Noah', 'Gymnasium, Französisch', '2026-03-17', 4, 'Der Unterricht hilft mir, Wortschatz und Grammatik gemeinsam anzuwenden. Beim Sprechen bin ich inzwischen viel sicherer.', 1, 30, '2026-07-20 06:05:10'),
(8, 2, 'Charlotte', 'Abiturvorbereitung Deutsch', '2026-01-21', 5, 'Textanalysen und Erörterungen haben endlich eine klare Struktur. Ich weiß jetzt, wie ich aus meinen Gedanken eine nachvollziehbare Argumentation mache.', 1, 40, '2026-07-20 06:05:10'),
(9, 3, 'Max', 'Gymnasium, Klasse 10', '2026-06-14', 5, 'Wir diskutieren nicht einfach nur Meinungen, sondern prüfen Begriffe, Argumente und Gegenargumente. Dadurch kann ich meine Position viel besser begründen.', 1, 10, '2026-07-20 06:05:10'),
(10, 3, 'Anna', 'Abiturvorbereitung Ethik', '2026-05-05', 5, 'Philosophische Positionen wurden verständlich gegenübergestellt und direkt auf Prüfungsaufgaben angewendet. Das hat mir beim Schreiben sehr geholfen.', 1, 20, '2026-07-20 06:05:10'),
(11, 3, 'Leon', 'Oberschule, Klasse 9', '2026-03-26', 5, 'Ich habe gelernt, Behauptung, Begründung und Beispiel sauber zu trennen. Diskussionen fühlen sich dadurch weniger chaotisch an.', 1, 30, '2026-07-20 06:05:10'),
(12, 3, 'Nele', 'Gymnasium, Klasse 11', '2026-02-12', 4, 'Auch bei schwierigen Themen bleibt der Unterricht sachlich und offen. Gleichzeitig wird genau darauf geachtet, ob ein Argument wirklich trägt.', 1, 40, '2026-07-20 06:05:10');

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
  ADD KEY `idx_add_index_content_slot_runtime` (`slot_id`,`active`,`placement`,`sort_order`);

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
-- Indizes für die Tabelle `content_items`
--
ALTER TABLE `content_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_content_type_slug` (`content_type`,`slug`),
  ADD KEY `idx_content_type_status` (`content_type`,`status`),
  ADD KEY `idx_content_featured` (`content_type`,`status`,`featured`,`sort_order`),
  ADD KEY `idx_published_at` (`published_at`),
  ADD KEY `fk_content_created_by` (`created_by`),
  ADD KEY `fk_content_updated_by` (`updated_by`);

--
-- Indizes für die Tabelle `content_revisions`
--
ALTER TABLE `content_revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_revision_item` (`content_item_id`,`created_at`),
  ADD KEY `fk_revision_user` (`changed_by`);

--
-- Indizes für die Tabelle `content_slots`
--
ALTER TABLE `content_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_content_slots_name` (`slot_name`),
  ADD KEY `idx_content_slots_page` (`page_key`,`active`,`sort_order`);

--
-- Indizes für die Tabelle `imprint_persons`
--
ALTER TABLE `imprint_persons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_imprint_persons_role` (`to_role`);

--
-- Indizes für die Tabelle `imprint_roles`
--
ALTER TABLE `imprint_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_imprint_roles_role` (`role`);

--
-- Indizes für die Tabelle `navigation_items`
--
ALTER TABLE `navigation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_navigation_parent_sort` (`parent_id`,`sort_order`,`id`),
  ADD KEY `idx_navigation_active` (`is_active`);

--
-- Indizes für die Tabelle `schema_migrations`
--
ALTER TABLE `schema_migrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `migration` (`migration`),
  ADD KEY `idx_schema_migrations_status` (`status`,`started_at`);

--
-- Indizes für die Tabelle `tutors`
--
ALTER TABLE `tutors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_tutors_slug` (`slug`),
  ADD KEY `idx_tutors_active_sort` (`is_active`,`sort_order`,`display_name`);

--
-- Indizes für die Tabelle `tutor_competencies`
--
ALTER TABLE `tutor_competencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tutor_competencies` (`tutor_id`,`category`,`sort_order`);

--
-- Indizes für die Tabelle `tutor_reviews`
--
ALTER TABLE `tutor_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_tutor_reviews_public` (`tutor_id`,`is_published`,`review_date`),
  ADD KEY `idx_tutor_reviews_stars` (`tutor_id`,`stars`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `add_index_content`
--
ALTER TABLE `add_index_content`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `content_items`
--
ALTER TABLE `content_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `content_revisions`
--
ALTER TABLE `content_revisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `content_slots`
--
ALTER TABLE `content_slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `imprint_persons`
--
ALTER TABLE `imprint_persons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `imprint_roles`
--
ALTER TABLE `imprint_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `navigation_items`
--
ALTER TABLE `navigation_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT für Tabelle `schema_migrations`
--
ALTER TABLE `schema_migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `tutors`
--
ALTER TABLE `tutors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `tutor_competencies`
--
ALTER TABLE `tutor_competencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT für Tabelle `tutor_reviews`
--
ALTER TABLE `tutor_reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `fk_addresses_person` FOREIGN KEY (`to_person`) REFERENCES `imprint_persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `add_index_content`
--
ALTER TABLE `add_index_content`
  ADD CONSTRAINT `fk_add_index_content_slot` FOREIGN KEY (`slot_id`) REFERENCES `content_slots` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;

--
-- Constraints der Tabelle `content_items`
--
ALTER TABLE `content_items`
  ADD CONSTRAINT `fk_content_created_by` FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_content_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;

--
-- Constraints der Tabelle `content_revisions`
--
ALTER TABLE `content_revisions`
  ADD CONSTRAINT `fk_revision_item` FOREIGN KEY (`content_item_id`) REFERENCES `content_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_revision_user` FOREIGN KEY (`changed_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;

--
-- Constraints der Tabelle `imprint_persons`
--
ALTER TABLE `imprint_persons`
  ADD CONSTRAINT `fk_imprint_persons_role` FOREIGN KEY (`to_role`) REFERENCES `imprint_roles` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `navigation_items`
--
ALTER TABLE `navigation_items`
  ADD CONSTRAINT `fk_navigation_parent` FOREIGN KEY (`parent_id`) REFERENCES `navigation_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tutor_competencies`
--
ALTER TABLE `tutor_competencies`
  ADD CONSTRAINT `fk_tutor_competencies_tutor` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `tutor_reviews`
--
ALTER TABLE `tutor_reviews`
  ADD CONSTRAINT `fk_tutor_reviews_tutor` FOREIGN KEY (`tutor_id`) REFERENCES `tutors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
