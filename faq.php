<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/content-repository.php';
$site = require __DIR__ . '/config/site.php';

$pageTitle = 'FAQ zur Nachhilfe in Leipzig | easyIT';
$pageDescription = 'Antworten zu Ablauf, Fächern, Klassenstufen, Prüfungsvorbereitung und Kontakt bei easyIT Nachhilfe Leipzig.';
$pageCanonical = $site['base_url'] . '/faq.php';

$dbFaqs = cms_items('faq', 'published', 100);
$fallbackFaqs = [
    ['title'=>'Für welche Klassenstufen ist die Nachhilfe geeignet?','body'=>'Die Unterstützung kann an Schulform, Klassenstufe, Ausbildung oder Studium angepasst werden.'],
    ['title'=>'Wie läuft eine erste Stunde ab?','body'=>'Zunächst werden Ziel, aktueller Lernstand und konkrete Schwierigkeiten gemeinsam geklärt.'],
    ['title'=>'Ist Prüfungsvorbereitung möglich?','body'=>'Ja. Themen, Zeitplan, Aufgabentypen und typische Fehler werden gezielt bearbeitet.'],
];
$faqs = $dbFaqs ?: $fallbackFaqs;

$pageSchemas = [[
    '@context'=>'https://schema.org',
    '@type'=>'FAQPage',
    'mainEntity'=>array_map(static fn(array $faq): array => [
        '@type'=>'Question',
        'name'=>$faq['title'],
        'acceptedAnswer'=>['@type'=>'Answer','text'=>$faq['body']]
    ], $faqs)
]];
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="index.php">Startseite</a><span>›</span><span aria-current="page">FAQ</span></nav>
<section class="hero">
  <div><span class="eyebrow">Häufige Fragen</span><h1>Fragen zur Nachhilfe in Leipzig</h1><p>Hier stehen Antworten zu Ablauf, Unterricht, Lernzielen und Kontakt.</p></div>
  <aside class="hero-panel"><h2>Weitere Frage?</h2><p>Über das Kontaktformular kann eine konkrete Situation direkt beschrieben werden.</p><a href="/kontakt.php">Kontakt aufnehmen →</a></aside>
</section>
<section class="section faq">
<?php foreach ($faqs as $faq): ?>
  <details>
    <summary><?= e((string)$faq['title']) ?></summary>
    <div><?= cms_content_html((string)$faq['body']) ?></div>
  </details>
<?php endforeach; ?>
</section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
