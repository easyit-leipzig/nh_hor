DROP TABLE IF EXISTS `menu_items`;
CREATE TABLE `menu_items` (
 `id` bigint unsigned NOT NULL AUTO_INCREMENT,
 `parent_id` bigint unsigned DEFAULT NULL,
 `title` varchar(120) NOT NULL,
 `url` varchar(255) NOT NULL DEFAULT '#',
 `target` enum('_self','_blank') NOT NULL DEFAULT '_self',
 `css_class` varchar(120) DEFAULT NULL,
 `sort_order` int NOT NULL DEFAULT 0,
 `is_active` tinyint(1) NOT NULL DEFAULT 1,
 PRIMARY KEY (`id`), KEY `idx_menu_parent_sort` (`parent_id`,`sort_order`), KEY `idx_menu_active` (`is_active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `menu_items` (`id`,`parent_id`,`title`,`url`,`sort_order`,`is_active`) VALUES
(1,NULL,'Start','/nh_hor/index.php',10,1),(2,NULL,'Über','#',20,1),(3,NULL,'Fächer','/nh_hor/faecher.php',30,1),(4,NULL,'Schulformen','/nh_hor/schulformen.php',40,1),(5,NULL,'Sonstiges','#',50,1),
(21,2,'Warum easyIT?','/nh_hor/warum-easyit.php',10,1),(22,2,'Über mich','/nh_hor/ueber-mich.php',20,1),(23,2,'Methodik','/nh_hor/methodik.php',30,1),(24,2,'Bewertungen','/nh_hor/bewertungen.php',40,1),
(31,3,'Naturwissenschaften','#',10,1),(32,3,'Sprachen','#',20,1),
(311,31,'Mathematik','/nh_hor/mathe-nachhilfe-leipzig.php',10,1),(312,31,'Physik','/nh_hor/physik-nachhilfe-leipzig.php',20,1),(313,31,'Chemie','/nh_hor/chemie-nachhilfe-leipzig.php',30,1),(314,31,'Informatik','/nh_hor/informatik-nachhilfe-leipzig.php',40,1),
(321,32,'Deutsch','/nh_hor/deutsch-nachhilfe-leipzig.php',10,1),(322,32,'Englisch','/nh_hor/englisch-nachhilfe-leipzig.php',20,1),(323,32,'Französisch','/nh_hor/franzoesisch-nachhilfe-leipzig.php',30,1),(324,32,'Spanisch','/nh_hor/spanisch-nachhilfe-leipzig.php',40,1),(325,32,'Latein','/nh_hor/latein-nachhilfe-leipzig.php',50,1),
(411,4,'Grundschule','/nh_hor/nachhilfe-grundschule-leipzig.php',10,1),(412,4,'Oberschule','/nh_hor/nachhilfe-oberschule-leipzig.php',20,1),(413,4,'Gymnasium','/nh_hor/nachhilfe-gymnasium-leipzig.php',30,1),(414,4,'Berufsschule','/nh_hor/nachhilfe-berufsschule-leipzig.php',40,1),(415,4,'Abitur','/nh_hor/abiturvorbereitung-leipzig.php',50,1),(416,4,'Studium','/nh_hor/nachhilfe-studium-leipzig.php',60,1),
(51,5,'Leipzig & Stadtteile','/nh_hor/nachhilfe-in-leipzig.php',10,1),(52,5,'Lernwerkzeuge','/nh_hor/lernwerkzeuge.php',20,1),(53,5,'Lernblog','/nh_hor/blog.php',30,1),(54,5,'Preise & Ablauf','/nh_hor/preise.php',40,1),(55,5,'FAQ','/nh_hor/faq.php',50,1),(56,5,'Jobs','/nh_hor/jobs.php',60,1),(57,5,'Sitemap','/nh_hor/sitemap.php',70,1);
