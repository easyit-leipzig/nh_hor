<?php
declare(strict_types=1);

require __DIR__ . '/functions.php';
$site = require __DIR__ . '/../config/site.php';
$subjects = require __DIR__ . '/../config/subjects.php';

if (!isset($subjectKey, $subjects[$subjectKey])) {
    http_response_code(404);
    exit('Fachseite nicht gefunden.');
}

$subject = $subjects[$subjectKey];
$pageTitle = $subject['title'];
$pageDescription = $subject['description'];
$pageCanonical = $site['base_url'] . '/index.php' . $subject['file'];

$faqEntities = array_map(static fn(array $item): array => [
    '@type' => 'Question',
    'name' => $item[0],
    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item[1]],
], $subject['faq']);

$pageSchemas = [
    [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $subject['name'] . '-Nachhilfe in Leipzig',
        'serviceType' => $subject['name'] . ' Nachhilfe',
        'description' => $subject['description'],
        'provider' => [
            '@type' => 'EducationalOrganization',
            'name' => $site['site_name'],
            'url' => $site['base_url'],
        ],
        'areaServed' => ['@type' => 'City', 'name' => 'Leipzig'],
        'url' => $pageCanonical,
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faqEntities,
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Startseite', 'item' => $site['base_url'] . '/index.php'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Fächer', 'item' => $site['base_url'] . '/nh_hor/faecher.php'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $subject['name'], 'item' => $pageCanonical],
        ],
    ],
];
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head><?php require __DIR__ . '/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen">
    <a href="index.php">Startseite</a><span>›</span>
    <a href="/nh_hor/faecher.php">Fächer</a><span>›</span>
    <span aria-current="page"><?= e($subject['name']) ?></span>
</nav>

<section class="hero subject-hero">
  <div>
    <span class="eyebrow"><?= e($subject['name']) ?> · Leipzig</span>
    <h1><?= e($subject['name']) ?>-Nachhilfe in Leipzig</h1>
    <p><?= e($subject['lead']) ?></p>
    <div class="hero-actions">
      <a class="button button--gold" href="/nh_hor/kontakt.php?fach=<?= rawurlencode($subject['name']) ?>">Probestunde anfragen</a>
      <a class="button button--blue" href="#themen">Themen ansehen</a>
    </div>
  </div>
  <aside class="hero-panel subject-symbol subject-symbol--visual" aria-label="Fachübersicht">
    <img class="subject-hero-image" src="/nh_hor/assets/img/subjects/<?= e($subjectKey) ?>.svg" width="800" height="560" alt="<?= e($subject['name']) ?> anschaulich lernen" loading="eager">
    <strong class="subject-symbol__fallback" aria-hidden="true"><?= e($subject['icon']) ?></strong>
    <h2><?= e($subject['name']) ?> verständlich lernen</h2>
    <p>Individuelle Unterstützung für Unterricht, Hausaufgaben, Klausuren und Prüfungen.</p>
  </aside>
</section>

<section class="section" id="themen">
  <header class="section-heading">
    <div><span class="eyebrow">Lernbereiche</span><h2>Diese Themen können wir bearbeiten</h2></div>
    <p>Die Auswahl richtet sich nach aktuellem Stand und konkretem Ziel.</p>
  </header>
  <div class="topic-list">
    <?php foreach ($subject['topics'] as $topic): ?>
        <div class="topic-chip"><?= e($topic) ?></div>
    <?php endforeach; ?>
  </div>
</section>

<section class="section">
  <header class="section-heading">
    <div><span class="eyebrow">Typische Hürden</span><h2>Wo Lernen häufig ins Stocken gerät</h2></div>
  </header>
  <div class="card-grid card-grid--3">
  <?php foreach ($subject['problems'] as $problem): ?>
    <article class="card"><h3><?= e($problem[0]) ?></h3><p><?= e($problem[1]) ?></p></article>
  <?php endforeach; ?>
  </div>
</section>

<section class="section learning-path">
  <header class="section-heading">
    <div><span class="eyebrow">Methodik</span><h2>Ein nachvollziehbarer Lernweg</h2></div>
    <p>Die Schritte werden an Thema und Lerntempo angepasst.</p>
  </header>
  <ol class="steps">
  <?php foreach ($subject['method'] as $index => $step): ?>
    <li><span><?= $index + 1 ?></span><strong><?= e($step) ?></strong></li>
  <?php endforeach; ?>
  </ol>
  <p>Der Unterricht orientiert sich nicht nur an der nächsten Lösung. Ziel ist, zu erkennen, warum ein Vorgehen funktioniert, wie es auf neue Aufgaben übertragen wird und woran sich das Ergebnis selbst kontrollieren lässt.</p>
</section>

<section class="section split-section">
  <div>
    <span class="eyebrow">Prüfungsvorbereitung</span>
    <h2>Sicherer in Klausur, Abschluss und Abitur</h2>
    <p><?= e($subject['exam']) ?></p>
    <a class="text-link" href="/nh_hor/preise.php">Ablauf und Rahmen kennenlernen →</a>
  </div>
  <aside class="check-panel">
    <h3>Gemeinsam planbar</h3>
    <ul><li>Ausgangsstand klären</li><li>Schwerpunkte priorisieren</li><li>Aufgabentypen trainieren</li><li>Fehlermuster auswerten</li><li>Zeitstrategie entwickeln</li></ul>
  </aside>
</section>

<section class="section faq" id="faq">
  <header class="section-heading">
    <div><span class="eyebrow">FAQ</span><h2>Fragen zur <?= e($subject['name']) ?>-Nachhilfe</h2></div>
    <a class="text-link" href="/nh_hor/faq.php">Alle Fragen ansehen →</a>
  </header>
  <?php foreach ($subject['faq'] as $item): ?>
    <details><summary><?= e($item[0]) ?></summary><p><?= e($item[1]) ?></p></details>
  <?php endforeach; ?>
</section>

<section class="section related-subjects">
  <header class="section-heading"><div><span class="eyebrow">Fachübergreifend</span><h2>Weitere Nachhilfeangebote</h2></div></header>
  <div class="mini-link-grid">
  <?php foreach ($subjects as $key => $other): if ($key === $subjectKey) continue; ?>
    <a href="/<?= e($other['file']) ?>"><span aria-hidden="true"><?= e($other['icon']) ?></span><strong><?= e($other['name']) ?></strong></a>
  <?php endforeach; ?>
  </div>
</section>

<section class="section cta">
  <div>
    <span class="eyebrow">Persönlich starten</span>
    <h2><?= e($subject['name']) ?> gemeinsam angehen</h2>
    <p>Beschreibe kurz Klassenstufe, Thema und aktuelle Schwierigkeit. So lässt sich die erste Stunde sinnvoll vorbereiten.</p>
  </div>
  <a class="button button--gold" href="/nh_hor/kontakt.php?fach=<?= rawurlencode($subject['name']) ?>">Unverbindlich anfragen</a>
</section>
</div>
<?php require __DIR__ . '/footer.php'; ?>
</main>
</div>
</body>
</html>
