<?php
declare(strict_types=1);

require __DIR__ . '/functions.php';
require_once __DIR__ . '/structured-data.php';
$site = require __DIR__ . '/../config/site.php';
$schoolTypes = require __DIR__ . '/../config/school-types.php';
$subjects = require __DIR__ . '/../config/subjects.php';

if (!isset($schoolTypeKey, $schoolTypes[$schoolTypeKey])) {
    http_response_code(404);
    exit('Schulformseite nicht gefunden.');
}
$type = $schoolTypes[$schoolTypeKey];
$pageTitle = $type['title'];
$pageDescription = $type['description'];
$pageCanonical = $site['base_url'] . $site['base_path'] . '/' . $type['file'];

$pageSchemas = [[
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'name' => 'Nachhilfe ' . $type['name'] . ' in Leipzig',
    'serviceType' => 'Nachhilfe für ' . $type['name'],
    'description' => $type['description'],
    'provider' => organization_reference($site),
    'areaServed' => ['@type' => 'City', 'name' => 'Leipzig'],
    'url' => $pageCanonical,
], [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Startseite', 'item' => $site['base_url'] . '/'],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Schulformen', 'item' => $site['base_url'] . '/schulformen.php'],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $type['name'], 'item' => $pageCanonical],
    ],
]];
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head><?php require __DIR__ . '/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="index.php">Startseite</a><span>›</span><a href="schulformen.php">Schulformen</a><span>›</span><span aria-current="page"><?= e($type['name']) ?></span></nav>

<section class="hero">
  <div>
    <span class="eyebrow">Lehrplanorientierte Unterstützung</span>
    <h1>Nachhilfe für <?= e($type['name']) ?></h1>
    <p><?= e($type['lead']) ?></p>
    <div class="hero-actions">
      <a class="button button--gold" href="/kontakt.php?schulform=<?= rawurlencode($type['name']) ?>">Unterstützung anfragen</a>
      <a class="button button--blue" href="#bildungsanforderungen">Anforderungen ansehen</a>
    </div>
  </div>
  <aside class="hero-panel">
    <h2><?= e($type['focus']) ?></h2>
    <p>Unterricht, Lernstand, Prüfungsziel und verfügbare Zeit bestimmen gemeinsam den passenden Lernweg.</p>
  </aside>
</section>

<section class="section" id="bildungsanforderungen">
  <header class="section-heading"><div><span class="eyebrow">Bildungsanforderungen</span><h2>Was Lehrplan und Bildungsstandards verlangen</h2></div></header>
  <p class="section-intro"><?= e($type['standards_intro']) ?></p>
  <div class="card-grid card-grid--2 standards-grid">
    <?php foreach ($type['competencies'] as $competency): ?>
      <article class="card standard-card"><h3><?= e($competency['title']) ?></h3><p><?= e($competency['text']) ?></p></article>
    <?php endforeach; ?>
  </div>
</section>

<section class="section" id="schwerpunkte">
  <header class="section-heading"><div><span class="eyebrow">Schwerpunkte</span><h2>Wichtige Themen dieser Lernphase</h2></div></header>
  <div class="topic-list"><?php foreach ($type['topics'] as $topic): ?><div class="topic-chip"><?= e($topic) ?></div><?php endforeach; ?></div>
</section>

<section class="section split-section school-support">
  <div>
    <span class="eyebrow">Unterstützung</span>
    <h2>So setzt easyIT die Anforderungen um</h2>
    <ul class="check-list">
      <?php foreach ($type['support'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
    </ul>
  </div>
  <aside class="info-panel">
    <h3>Kein Ersatz für Schule oder Hochschule</h3>
    <p>Die offiziellen Vorgaben bilden den Rahmen. Entscheidend für die konkrete Förderung sind jedoch die tatsächlich behandelten Themen, die Unterlagen der Lehrkraft sowie der individuelle Lernstand.</p>
  </aside>
</section>

<section class="section">
  <header class="section-heading"><div><span class="eyebrow">Lernweg</span><h2>Vom aktuellen Stand zum sicheren Anwenden</h2></div></header>
  <div class="learning-roadmap">
    <?php foreach ($type['roadmap'] as $item): ?>
      <article class="roadmap-step"><span><?= e($item['step']) ?></span><div><h3><?= e($item['title']) ?></h3><p><?= e($item['text']) ?></p></div></article>
    <?php endforeach; ?>
  </div>
</section>

<section class="section">
  <header class="section-heading"><div><span class="eyebrow">Passende Fächer</span><h2>Fachliche Unterstützung auswählen</h2></div></header>
  <div class="mini-link-grid">
    <?php foreach ($subjects as $subject): ?><a href="/<?= e($subject['file']) ?>"><span aria-hidden="true"><?= e($subject['icon']) ?></span><strong><?= e($subject['name']) ?></strong></a><?php endforeach; ?>
  </div>
</section>

<section class="section official-sources">
  <header class="section-heading"><div><span class="eyebrow">Offizielle Grundlagen</span><h2>Lehrpläne und Bildungsstandards</h2></div></header>
  <p>Die folgenden offiziellen Angebote dienen als fachlicher Orientierungsrahmen. Maßgeblich bleiben die aktuell an der jeweiligen Schule oder Hochschule verwendeten Unterlagen.</p>
  <ul class="source-link-list">
    <?php foreach ($type['sources'] as $source): ?><li><a href="<?= e($source['url']) ?>" target="_blank" rel="noopener noreferrer"><?= e($source['label']) ?> <span aria-hidden="true">↗</span></a></li><?php endforeach; ?>
  </ul>
  <p class="source-note">Redaktioneller Stand: Juli 2026. Lehrpläne und Prüfungsregelungen können geändert werden.</p>
</section>

<section class="section cta">
  <div><span class="eyebrow">Nächster Schritt</span><h2>Nachhilfe für <?= e($type['name']) ?> anfragen</h2><p>Mit Fach, Klassen- oder Ausbildungsstufe, aktuellem Thema und Lernziel lässt sich der Bedarf schnell einordnen.</p></div>
  <a class="button button--gold" href="/kontakt.php?schulform=<?= rawurlencode($type['name']) ?>">Kontakt aufnehmen</a>
</section>
</div>
<?php require __DIR__ . '/footer.php'; ?>
</main>
</div>
</body>
</html>
