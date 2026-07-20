-- easyIT Revision V3.1: datenbankgestützte Hauptnavigation

CREATE TABLE IF NOT EXISTS navigation_items (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    parent_id INT UNSIGNED NULL,
    title VARCHAR(120) NOT NULL,
    url VARCHAR(255) NOT NULL DEFAULT '#',
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_navigation_parent_sort (parent_id, sort_order, id),
    KEY idx_navigation_active (is_active),
    CONSTRAINT fk_navigation_parent
        FOREIGN KEY (parent_id) REFERENCES navigation_items(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Nur initial befüllen, wenn die Tabelle noch keine Einträge enthält.
INSERT INTO navigation_items (parent_id, title, url, sort_order, is_active)
SELECT NULL, 'Start', '/index.php', 10, 1
WHERE NOT EXISTS (SELECT 1 FROM navigation_items LIMIT 1);

SET @nav_ueber := NULL;
INSERT INTO navigation_items (parent_id, title, url, sort_order, is_active)
SELECT NULL, 'Über', '#', 20, 1
WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id IS NULL AND title='Über');
SELECT id INTO @nav_ueber FROM navigation_items WHERE parent_id IS NULL AND title='Über' ORDER BY id LIMIT 1;

SET @nav_faecher := NULL;
INSERT INTO navigation_items (parent_id, title, url, sort_order, is_active)
SELECT NULL, 'Fächer', '/faecher.php', 30, 1
WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id IS NULL AND title='Fächer');
SELECT id INTO @nav_faecher FROM navigation_items WHERE parent_id IS NULL AND title='Fächer' ORDER BY id LIMIT 1;

SET @nav_schulformen := NULL;
INSERT INTO navigation_items (parent_id, title, url, sort_order, is_active)
SELECT NULL, 'Schulformen', '/schulformen.php', 40, 1
WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id IS NULL AND title='Schulformen');
SELECT id INTO @nav_schulformen FROM navigation_items WHERE parent_id IS NULL AND title='Schulformen' ORDER BY id LIMIT 1;

SET @nav_sonstiges := NULL;
INSERT INTO navigation_items (parent_id, title, url, sort_order, is_active)
SELECT NULL, 'Sonstiges', '#', 50, 1
WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id IS NULL AND title='Sonstiges');
SELECT id INTO @nav_sonstiges FROM navigation_items WHERE parent_id IS NULL AND title='Sonstiges' ORDER BY id LIMIT 1;

INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_ueber,'Warum easyIT?','/warum-easyit.php',10,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_ueber AND title='Warum easyIT?');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_ueber,'Über mich','/ueber-mich.php',20,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_ueber AND title='Über mich');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_ueber,'Methodik','/methodik.php',30,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_ueber AND title='Methodik');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_ueber,'Bewertungen','/bewertungen.php',40,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_ueber AND title='Bewertungen');

SET @nav_nawi := NULL;
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_faecher,'Naturwissenschaften','#',10,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_faecher AND title='Naturwissenschaften');
SELECT id INTO @nav_nawi FROM navigation_items WHERE parent_id=@nav_faecher AND title='Naturwissenschaften' ORDER BY id LIMIT 1;
SET @nav_sprachen := NULL;
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_faecher,'Sprachen','#',20,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_faecher AND title='Sprachen');
SELECT id INTO @nav_sprachen FROM navigation_items WHERE parent_id=@nav_faecher AND title='Sprachen' ORDER BY id LIMIT 1;
SET @nav_gesellschaft := NULL;
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_faecher,'Gesellschaft','#',30,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_faecher AND title='Gesellschaft');
SELECT id INTO @nav_gesellschaft FROM navigation_items WHERE parent_id=@nav_faecher AND title='Gesellschaft' ORDER BY id LIMIT 1;

INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_nawi,'Mathematik','/mathe-nachhilfe-leipzig.php',10,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_nawi AND title='Mathematik');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_nawi,'Physik','/physik-nachhilfe-leipzig.php',20,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_nawi AND title='Physik');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_nawi,'Chemie','/chemie-nachhilfe-leipzig.php',30,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_nawi AND title='Chemie');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_nawi,'Informatik','/informatik-nachhilfe-leipzig.php',40,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_nawi AND title='Informatik');

INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sprachen,'Deutsch','/deutsch-nachhilfe-leipzig.php',10,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sprachen AND title='Deutsch');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sprachen,'Englisch','/englisch-nachhilfe-leipzig.php',20,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sprachen AND title='Englisch');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sprachen,'Französisch','/franzoesisch-nachhilfe-leipzig.php',30,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sprachen AND title='Französisch');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sprachen,'Spanisch','/spanisch-nachhilfe-leipzig.php',40,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sprachen AND title='Spanisch');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sprachen,'Latein','/latein-nachhilfe-leipzig.php',50,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sprachen AND title='Latein');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_gesellschaft,'Ethik','/ethik-nachhilfe-leipzig.php',10,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_gesellschaft AND title='Ethik');

INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_schulformen,'Grundschule','/nachhilfe-grundschule-leipzig.php',10,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_schulformen AND title='Grundschule');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_schulformen,'Oberschule','/nachhilfe-oberschule-leipzig.php',20,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_schulformen AND title='Oberschule');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_schulformen,'Gymnasium','/nachhilfe-gymnasium-leipzig.php',30,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_schulformen AND title='Gymnasium');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_schulformen,'Berufsschule','/nachhilfe-berufsschule-leipzig.php',40,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_schulformen AND title='Berufsschule');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_schulformen,'Abitur','/abiturvorbereitung-leipzig.php',50,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_schulformen AND title='Abitur');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_schulformen,'Studium','/nachhilfe-studium-leipzig.php',60,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_schulformen AND title='Studium');

INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sonstiges,'Leipzig & Stadtteile','/nachhilfe-in-leipzig.php',10,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sonstiges AND title='Leipzig & Stadtteile');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sonstiges,'Lernwerkzeuge','/lernwerkzeuge.php',20,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sonstiges AND title='Lernwerkzeuge');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sonstiges,'Lernblog','/blog.php',30,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sonstiges AND title='Lernblog');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sonstiges,'Preise & Ablauf','/preise.php',40,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sonstiges AND title='Preise & Ablauf');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sonstiges,'FAQ','/faq.php',50,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sonstiges AND title='FAQ');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sonstiges,'Jobs','/jobs.php',60,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sonstiges AND title='Jobs');
INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active)
SELECT @nav_sonstiges,'Sitemap','/sitemap.php',70,1 WHERE NOT EXISTS (SELECT 1 FROM navigation_items WHERE parent_id=@nav_sonstiges AND title='Sitemap');
