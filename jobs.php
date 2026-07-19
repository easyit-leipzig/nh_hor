<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/content-repository.php';
$site = require __DIR__ . '/config/site.php';

$pageTitle = 'Jobs als Honorarkraft in Leipzig | easyIT Nachhilfe';
$pageDescription = 'Aktuelle Tätigkeiten als Honorarkraft für Sprachen, Ethikfächer und weitere Fachbereiche bei easyIT Leipzig.';
$pageCanonical = $site['base_url'] . '/jobs.php';

$jobs = cms_items('job', 'published', 50);
$fallback = [
    ['title'=>'Honorarkraft Sprachen','body'=>'Gesucht werden Honorarkräfte für Deutsch, Englisch, Französisch, Spanisch und Latein.'],
    ['title'=>'Honorarkraft Ethikfächer','body'=>'Gesucht werden geeignete Lehrkräfte für Ethik, Philosophie und verwandte Fächer.'],
    ['title'=>'Weitere Fachbereiche','body'=>'Bewerbungen aus zusätzlichen schulischen und akademischen Fachgebieten sind willkommen.'],
];
$items = $jobs ?: $fallback;
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="index.php">Startseite</a><span>›</span><span aria-current="page">Jobs</span></nav>
<section class="hero">
  <div><span class="eyebrow">Mitwirken</span><h1>Jobs und Honorartätigkeiten</h1><p>easyIT sucht fachlich sichere, verlässliche und lernorientierte Unterstützung.</p></div>
  <aside class="hero-panel"><h2>Wichtig</h2><p>Neben Fachwissen zählen Geduld, verständliche Erklärungen und ein respektvoller Umgang.</p></aside>
</section>
<section class="section">
<div class="card-grid card-grid--3">
<?php foreach ($items as $job): ?>
  <article class="card"><h2><?= e((string)$job['title']) ?></h2><div><?= cms_content_html((string)$job['body']) ?></div><a href="/kontakt.php">Interesse mitteilen →</a></article>
<?php endforeach; ?>
</div>
</section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
