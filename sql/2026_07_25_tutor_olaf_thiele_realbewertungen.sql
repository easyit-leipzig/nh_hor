-- ============================================================
-- easyIT / nh_hor
-- Reales Tutorprofil und reale Bewertungen für Olaf Thiele
-- Idempotentes Datenupdate
-- ============================================================

START TRANSACTION;

INSERT INTO tutors
(
    slug,
    display_name,
    professional_title,
    short_intro,
    biography,
    teaching_approach,
    image_path,
    image_alt,
    sort_order,
    is_active
)
VALUES
(
    'olaf-thiele',
    'Dipl.-Ing. Olaf Thiele',
    'Tutor für Mathematik, Physik, Chemie und Informatik',
    'Strukturiert, geduldig und fachübergreifend: Der Unterricht wird individuell vorbereitet und an Lernstand, Arbeitstempo und aktuelle Schulthemen angepasst.',
    'Olaf Thiele ist Diplom-Ingenieur der Verfahrenstechnik und arbeitet fachübergreifend in Mathematik, Physik, Chemie und Informatik. Sein technischer Hintergrund unterstützt ihn dabei, Zusammenhänge sichtbar zu machen und Lösungswege nicht nur vorzugeben, sondern nachvollziehbar herzuleiten.',
    'Jede Einheit beginnt mit einer kurzen Einordnung der aktuellen Situation. Anschließend wird mit vorbereiteten, individuell passenden Aufgaben gearbeitet. Eigene Lösungsvorschläge werden aufgenommen und gemeinsam geprüft. Zum Abschluss wird reflektiert, was verstanden wurde und welcher nächste Lernschritt sinnvoll ist.',
    '/assets/img/tutors/olaf-thiele.webp',
    'Dipl.-Ing. Olaf Thiele, Tutor bei easyIT Leipzig',
    10,
    1
)
ON DUPLICATE KEY UPDATE
    display_name = VALUES(display_name),
    professional_title = VALUES(professional_title),
    short_intro = VALUES(short_intro),
    biography = VALUES(biography),
    teaching_approach = VALUES(teaching_approach),
    image_path = VALUES(image_path),
    image_alt = VALUES(image_alt),
    sort_order = VALUES(sort_order),
    is_active = VALUES(is_active);

SET @tutor_id := (SELECT id FROM tutors WHERE slug = 'olaf-thiele' LIMIT 1);

DELETE FROM tutor_competencies WHERE tutor_id = @tutor_id;

INSERT INTO tutor_competencies
(tutor_id, category, title, description, sort_order)
VALUES
(@tutor_id,'fach','Mathematik','Grundlagen, Algebra, Funktionen, Analysis, Geometrie und Prüfungsvorbereitung.',10),
(@tutor_id,'fach','Physik und Chemie','Naturwissenschaftliche Zusammenhänge werden schrittweise aus Modellen, Formeln und Experimenten erschlossen.',20),
(@tutor_id,'fach','Informatik','Algorithmen, Programmierung, Datenbanken und technische Grundlagen.',30),

(@tutor_id,'methodik','Individuelle Vorbereitung','Arbeitsblätter und Aufgaben werden vor der Stunde an Lernstand, Defizite, Unterrichtsthema und Arbeitstempo angepasst.',10),
(@tutor_id,'methodik','Klare Stundenstruktur','Persönlicher Einstieg, konzentrierte Arbeitsphase und gemeinsame Abschlussreflexion.',20),
(@tutor_id,'methodik','Dokumentierte Lernwege','Erarbeitete Lösungen werden geordnet festgehalten, damit Lernende später gezielt darauf zurückgreifen können.',30),

(@tutor_id,'didaktik','Mehrere Erklärungswege','Bei Rückfragen wird ein Problem neu und auf andere Weise erklärt, bis der Lösungsweg nachvollziehbar ist.',10),
(@tutor_id,'didaktik','Eigene Lösungen ernst nehmen','Vorschläge der Lernenden werden verstanden, geprüft und in die Unterrichtsführung einbezogen.',20),
(@tutor_id,'didaktik','Reflexion des Lernerfolgs','Am Ende wird gemeinsam geklärt, was gelernt wurde und was als Nächstes gefestigt werden muss.',30),

(@tutor_id,'faehigkeit','Geduld und persönliche Aufmerksamkeit','Rückmeldungen beschreiben den Unterricht wiederholt als geduldig, persönlich und an der Situation der Lernenden orientiert.',10),
(@tutor_id,'faehigkeit','Fachübergreifendes Denken','Der ingenieurwissenschaftliche Hintergrund erleichtert die Verbindung mathematischer, naturwissenschaftlicher und technischer Themen.',20),

(@tutor_id,'qualifikation','Diplom-Ingenieur Verfahrenstechnik','Ingenieurwissenschaftlicher Studienabschluss mit breiter mathematisch-naturwissenschaftlicher Grundlage.',10),
(@tutor_id,'qualifikation','Langjährige Unterrichtspraxis','Erfahrung in der individuellen und gruppenbezogenen Förderung unterschiedlicher Klassenstufen.',20);

-- Nur die für diesen Profilstand vorgesehenen Bewertungen ersetzen.
DELETE FROM tutor_reviews WHERE tutor_id = @tutor_id;

INSERT INTO tutor_reviews
(tutor_id, reviewer_name, reviewer_context, review_date, stars, review_text, is_published)
VALUES
(@tutor_id,'Pierre Freiberg','Öffentliche Google-Bewertung · Vater eines Schülers','2026-04-01',5,
 'Unser Sohn geht nun fast ein Jahr zur Mathe-Nachhilfe. Herr Thiele ist der Lehrer und wir alle sind sehr zufrieden. Um zwei Noten hat er sich verbessert. Für uns 100 Prozent Weiterempfehlung.',1),

(@tutor_id,'Silvia Hilpert','Öffentliche Google-Bewertung · Mutter eines Schülers','2026-03-01',5,
 'Unser Sohn geht mittlerweile schon ein Jahr zur Nachhilfe und wir haben es nicht bereut. Die Mathematiknoten haben sich bereits nach einem halben Jahr verbessert. Herr Thiele ist ein hervorragender Lehrer, bei dem man sehr viel lernen kann.',1),

(@tutor_id,'Susanne Canitz','Öffentliche Google-Bewertung · Mutter zweier Schülerinnen','2026-01-01',5,
 'Meine beiden Töchter sind mit dem Mathematikunterricht sehr zufrieden. Beide sagen unabhängig voneinander, dass Herr Thiele der beste und geduldigste Mathematiklehrer ist, den sie bisher hatten. Seit Beginn der Nachhilfe haben sich ihre Schulnoten verbessert.',1),

(@tutor_id,'Lia Schubert','Öffentliche Google-Bewertung · Schülerin','2025-11-01',5,
 'Ich gehe selbst zur Mathe-Nachhilfe und bin sehr zufrieden mit Herrn Thiele. Er ist modern und flexibel und bringt mir neue Inhalte sehr schnell bei.',1),

(@tutor_id,'Nike','Verifizierte Trustpilot-Bewertung','2026-06-02',5,
 'Herr Thiele bereitet sich sehr gut auf den Unterricht vor und geht auf Wünsche und Schwächen ein. Man kann so oft nachfragen, wie man möchte, und er versucht jedes Mal, das Problem neu zu erklären. Am Ende gibt es eine Reflexion, von der beide Seiten lernen.',1),

(@tutor_id,'Familie Hilpert','Direkte Elternrückmeldung','2026-02-01',5,
 'Unser Sohn ist mit dem Unterricht bei Herrn Thiele sehr zufrieden. Seine Mathematiknote auf dem Zeugnis hat sich wieder von 4 auf 3 verbessert.',1),

(@tutor_id,'Anonymisierte Schülerin','Persönliche Rückmeldung · mit Einwilligung','2026-04-18',5,
 'Der Unterricht bei Herrn Thiele ist strukturierter, präziser und stabiler. Er interessiert sich stärker für die persönliche Situation der Schüler. Ich habe das Gefühl, in seinem Unterricht mehr für mich zu erreichen.',1),

(@tutor_id,'Anonymisierter Schüler','Persönliche Rückmeldung · mit Einwilligung','2026-04-24',5,
 'Vor jeder Stunde gibt es einen kurzen persönlichen Einstieg. Am Ende wird zusammengefasst, was gelernt wurde. Eigene Lösungsvorschläge werden verstanden und in den Unterricht einbezogen, statt nur einen vorgegebenen Weg durchzusetzen.',1),

(@tutor_id,'Anonymisierte Schülerin','Persönliche Rückmeldung','2026-04-25',5,
 'Die Arbeitsblätter sind bereits vor der Stunde vorbereitet und begleiten das aktuelle Unterrichtsthema. Dadurch kann Herr Thiele auf Fragen schneller reagieren und ein Thema besonders verständlich erklären.',1);

COMMIT;
