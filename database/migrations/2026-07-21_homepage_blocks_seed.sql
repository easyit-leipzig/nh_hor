-- Idempotente Beispieldaten für Homepage-Blöcke
INSERT INTO homepage_blocks (block_type,title,content,image,button_text,button_url,position,active)
SELECT 'neu','NEU: Prüfungsvorbereitung','Gezielte Vorbereitung auf Klassenarbeiten und Prüfungen.','/assets/img/stud-lern.png','Mehr erfahren','/kontakt.php',1,1
WHERE NOT EXISTS (SELECT 1 FROM homepage_blocks WHERE title='NEU: Prüfungsvorbereitung');

INSERT INTO homepage_blocks (block_type,title,content,image,button_text,button_url,position,active)
SELECT 'veranstaltung','Mathe Workshop','Intensiver Workshop für Schülerinnen und Schüler.','/assets/img/subjects/mathe.svg','Anmelden','/kontakt.php',2,1
WHERE NOT EXISTS (SELECT 1 FROM homepage_blocks WHERE title='Mathe Workshop');

INSERT INTO homepage_blocks (block_type,title,content,image,button_text,button_url,position,active)
SELECT 'veranstaltung','Ferienkurs Sommer','Lernen in den Ferien mit klarer Struktur.','/assets/img/lern-stud.svg','Infos','/kontakt.php',3,1
WHERE NOT EXISTS (SELECT 1 FROM homepage_blocks WHERE title='Ferienkurs Sommer');

INSERT INTO homepage_blocks (block_type,title,content,image,button_text,button_url,position,active)
SELECT 'gutschein','Nachhilfe verschenken','Ein Gutschein für individuelle Unterstützung.','/assets/img/gutschein.png','Gutschein anfragen','/kontakt.php',4,1
WHERE NOT EXISTS (SELECT 1 FROM homepage_blocks WHERE title='Nachhilfe verschenken');

INSERT INTO homepage_blocks (block_type,title,content,image,button_text,button_url,position,active)
SELECT 'neu','Neue Lernwerkzeuge','Digitale Hilfen für besseres Lernen.','/assets/img/lern-stud.svg','Entdecken','/lernwerkzeuge.php',5,1
WHERE NOT EXISTS (SELECT 1 FROM homepage_blocks WHERE title='Neue Lernwerkzeuge');
