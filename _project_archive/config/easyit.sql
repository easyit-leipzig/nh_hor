-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 18. Jul 2026 um 08:52
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.0.30

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
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
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
-- Tabellenstruktur für Tabelle `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(120) NOT NULL,
  `url` varchar(255) NOT NULL DEFAULT '#',
  `target` enum('_self','_blank') NOT NULL DEFAULT '_self',
  `css_class` varchar(120) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `menu_items`
--

INSERT INTO `menu_items` (`id`, `parent_id`, `title`, `url`, `target`, `css_class`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Start', '/nh_hor/index.php', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(2, NULL, 'Über', '#', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(3, NULL, 'Fächer', '/nh_hor/faecher.php', '_self', NULL, 30, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(4, NULL, 'Schulformen', '/nh_hor/schulformen.php', '_self', NULL, 40, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(5, NULL, 'Sonstiges', '#', '_self', NULL, 50, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(21, 2, 'Warum easyIT?', '/nh_hor/warum-easyit.php', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(22, 2, 'Über mich', '/nh_hor/ueber-mich.php', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(23, 2, 'Methodik', '/nh_hor/methodik.php', '_self', NULL, 30, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(31, 3, 'Naturwissenschaften', '#', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(32, 3, 'Sprachen', '#', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(311, 31, 'Mathematik', '/nh_hor/mathe-nachhilfe-leipzig.php', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(312, 31, 'Physik', '/nh_hor/physik-nachhilfe-leipzig.php', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(313, 31, 'Chemie', '/nh_hor/chemie-nachhilfe-leipzig.php', '_self', NULL, 30, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(314, 31, 'Informatik', '/nh_hor/informatik-nachhilfe-leipzig.php', '_self', NULL, 40, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(321, 32, 'Deutsch', '/nh_hor/deutsch-nachhilfe-leipzig.php', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(322, 32, 'Englisch', '/nh_hor/englisch-nachhilfe-leipzig.php', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(323, 32, 'Französisch', '/nh_hor/franzoesisch-nachhilfe-leipzig.php', '_self', NULL, 30, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(324, 32, 'Spanisch', '/nh_hor/spanisch-nachhilfe-leipzig.php', '_self', NULL, 40, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(325, 32, 'Latein', '/nh_hor/latein-nachhilfe-leipzig.php', '_self', NULL, 50, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(41, 4, 'Schule', '#', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(42, 4, 'Abschluss & Studium', '#', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(411, 41, 'Grundschule', '/nh_hor/nachhilfe-grundschule-leipzig.php', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(412, 41, 'Oberschule', '/nh_hor/nachhilfe-oberschule-leipzig.php', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(413, 41, 'Gymnasium', '/nh_hor/nachhilfe-gymnasium-leipzig.php', '_self', NULL, 30, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(414, 41, 'Berufsschule', '/nh_hor/nachhilfe-berufsschule-leipzig.php', '_self', NULL, 40, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(421, 42, 'Abitur', '/nh_hor/abiturvorbereitung-leipzig.php', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(422, 42, 'Studium', '/nh_hor/nachhilfe-studium-leipzig.php', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(51, 5, 'Lernen & Service', '#', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(52, 5, 'easyIT', '#', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(511, 51, 'Lernwerkzeuge', '/nh_hor/lernwerkzeuge.php', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(512, 51, 'Lernblog', '/nh_hor/blog.php', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(513, 51, 'FAQ', '/nh_hor/faq.php', '_self', NULL, 30, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(521, 52, 'Preise & Ablauf', '/nh_hor/preise.php', '_self', NULL, 10, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(522, 52, 'Bewertungen', '/nh_hor/bewertungen.php', '_self', NULL, 20, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(523, 52, 'Jobs', '/nh_hor/jobs.php', '_self', NULL, 30, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(524, 52, 'Kontakt', '/nh_hor/kontakt.php', '_self', NULL, 40, 1, '2026-07-18 07:06:51', '2026-07-18 07:06:51'),
(1000, NULL, 'Kontakt', '/nh_hor/kontakt.php', '_self', 'menu-contact', 900, 1, '2026-07-18 07:59:36', '2026-07-18 07:59:36'),
(1001, NULL, 'Anmelden', '/nh_hor/login.php', '_self', 'menu-login', 910, 1, '2026-07-18 07:59:36', '2026-07-18 07:59:36');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schema_migrations`
--

CREATE TABLE `schema_migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `migration` varchar(190) NOT NULL,
  `executed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `schema_migrations`
--

INSERT INTO `schema_migrations` (`id`, `migration`, `executed_at`) VALUES
(1, '20260716_001_content_indexes.sql', '2026-07-17 14:06:54'),
(2, '20260717_002_review_metadata.sql', '2026-07-17 14:06:54');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_admin_users_username` (`username`),
  ADD UNIQUE KEY `uq_admin_users_email` (`email`),
  ADD KEY `idx_admin_users_active_role` (`is_active`,`role`);

--
-- Indizes für die Tabelle `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_audit_created_at` (`created_at`),
  ADD KEY `idx_audit_user` (`user_id`);

--
-- Indizes für die Tabelle `content_items`
--
ALTER TABLE `content_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_content_type_slug` (`content_type`,`slug`),
  ADD KEY `idx_content_type_status` (`content_type`,`status`),
  ADD KEY `idx_published_at` (`published_at`),
  ADD KEY `idx_content_featured` (`content_type`,`status`,`featured`,`sort_order`),
  ADD KEY `idx_content_review_date` (`content_type`,`review_date`),
  ADD KEY `fk_content_created_by` (`created_by`),
  ADD KEY `fk_content_updated_by` (`updated_by`);

--
-- Indizes für die Tabelle `content_revisions`
--
ALTER TABLE `content_revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_revision_item` (`content_item_id`,`created_at`),
  ADD KEY `idx_revision_user` (`changed_by`);

--
-- Indizes für die Tabelle `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_menu_parent_sort` (`parent_id`,`sort_order`),
  ADD KEY `idx_menu_active` (`is_active`),
  ADD KEY `idx_menu_parent` (`parent_id`);

--
-- Indizes für die Tabelle `schema_migrations`
--
ALTER TABLE `schema_migrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_schema_migrations_migration` (`migration`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT für Tabelle `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1002;

--
-- AUTO_INCREMENT für Tabelle `schema_migrations`
--
ALTER TABLE `schema_migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `content_items`
--
ALTER TABLE `content_items`
  ADD CONSTRAINT `fk_content_created_by` FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_content_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints der Tabelle `content_revisions`
--
ALTER TABLE `content_revisions`
  ADD CONSTRAINT `fk_revision_item` FOREIGN KEY (`content_item_id`) REFERENCES `content_items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_revision_user` FOREIGN KEY (`changed_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
