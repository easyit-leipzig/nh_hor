<?php
declare(strict_types=1);

$subjects = require __DIR__ . '/subjects.php';
$areas = require __DIR__ . '/areas.php';
$schoolTypes = require __DIR__ . '/school-types.php';

$pages = [
    ['title' => 'Startseite', 'url' => '/index.php', 'keywords' => 'easyit nachhilfe leipzig lernförderung'],
    ['title' => 'Nachhilfe Leipzig', 'url' => '/nachhilfe-leipzig.php', 'keywords' => 'nachhilfe leipzig lernförderung unterricht'],
    ['title' => 'Fächer', 'url' => '/faecher.php', 'keywords' => 'fächer mathematik physik chemie informatik sprachen'],
    ['title' => 'Methodik', 'url' => '/methodik.php', 'keywords' => 'lernmethode verstehen erklären fragen unterricht'],
    ['title' => 'Preise', 'url' => '/preise.php', 'keywords' => 'preise kosten nachhilfe honorar'],
    ['title' => 'Bewertungen', 'url' => '/bewertungen.php', 'keywords' => 'bewertungen erfahrungen feedback'],
    ['title' => 'FAQ', 'url' => '/faq.php', 'keywords' => 'fragen antworten nachhilfe ablauf'],
    ['title' => 'Kontakt', 'url' => '/kontakt.php', 'keywords' => 'kontakt probestunde anfrage telefon email'],
    ['title' => 'Jobs', 'url' => '/jobs.php', 'keywords' => 'jobs honorarkraft tutor lehrer bewerbung'],
    ['title' => 'Lernwerkzeuge', 'url' => '/lernwerkzeuge.php', 'keywords' => 'notenrechner prozentrechner einheitenrechner lernzeitplaner'],
    ['title' => 'Notenrechner', 'url' => '/notenrechner.php', 'keywords' => 'note durchschnitt gewichtung berechnen'],
    ['title' => 'Prozentrechner', 'url' => '/prozentrechner.php', 'keywords' => 'prozentwert grundwert prozentsatz berechnen'],
    ['title' => 'Einheitenrechner', 'url' => '/einheitenrechner.php', 'keywords' => 'einheiten länge masse zeit umrechnen'],
    ['title' => 'Lernzeitplaner', 'url' => '/lernzeitplaner.php', 'keywords' => 'lernplan prüfung zeit planen'],
    ['title' => 'Über mich', 'url' => '/ueber-mich.php', 'keywords' => 'inhaber lehrer tutor easyit'],
    ['title' => 'Warum easyIT?', 'url' => '/warum-easyit.php', 'keywords' => 'vorteile konzept individuelle nachhilfe'],
    ['title' => 'Sitemap', 'url' => '/sitemap.php', 'keywords' => 'seitenübersicht alle seiten'],
    ['title' => 'Impressum', 'url' => '/impressum.php', 'keywords' => 'anbieter rechtliche angaben'],
    ['title' => 'Datenschutz', 'url' => '/datenschutz.php', 'keywords' => 'datenschutz personenbezogene daten'],
];

foreach ($subjects as $subject) {
    $pages[] = [
        'title' => (string)($subject['name'] ?? 'Fach') . ' Nachhilfe Leipzig',
        'url' => '/' . ltrim((string)$subject['file'], '/'),
        'keywords' => implode(' ', array_filter([
            (string)($subject['name'] ?? ''),
            (string)($subject['description'] ?? ''),
            implode(' ', (array)($subject['topics'] ?? [])),
        ])),
    ];
}

foreach ($areas as $area) {
    $pages[] = [
        'title' => 'Nachhilfe ' . (string)($area['name'] ?? 'Leipzig'),
        'url' => '/' . ltrim((string)$area['file'], '/'),
        'keywords' => implode(' ', array_filter([
            (string)($area['name'] ?? ''),
            (string)($area['description'] ?? ''),
            (string)($area['focus'] ?? ''),
        ])),
    ];
}

foreach ($schoolTypes as $type) {
    $pages[] = [
        'title' => 'Nachhilfe ' . (string)($type['name'] ?? 'Schulform') . ' Leipzig',
        'url' => '/' . ltrim((string)$type['file'], '/'),
        'keywords' => implode(' ', array_filter([
            (string)($type['name'] ?? ''),
            (string)($type['description'] ?? ''),
            implode(' ', (array)($type['topics'] ?? [])),
        ])),
    ];
}

return $pages;
