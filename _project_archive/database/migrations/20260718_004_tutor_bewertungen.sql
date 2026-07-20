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
