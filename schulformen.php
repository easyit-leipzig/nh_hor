<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$site = require __DIR__ . '/config/site.php';
$schoolTypes = require __DIR__ . '/config/school-types.php';
$pageTitle = 'Nachhilfe nach Schulform in Leipzig | easyIT';
$pageDescription = 'Nachhilfe in Leipzig für Grundschule, Oberschule, Gymnasium, Berufsschule, Abitur und Studium.';
$pageCanonical = $site['base_url'] . '/nh_hor/schulformen.php';
?><!doctype html><html lang="de" data-theme="leipzig-blau"><head><?php require __DIR__.'/includes/meta.php'; ?></head><body>
<?php require __DIR__.'/includes/header.php'; ?><div class="page-shell"><?php require __DIR__.'/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="/nh_hor/">Startseite</a><span>›</span><span aria-current="page">Schulformen</span></nav>
<section class="hero"><div><span class="eyebrow">Lernphasen</span><h1>Nachhilfe nach Schulform und Lernziel</h1><p>Grundschule, weiterführende Schule, Ausbildung, Abitur und Studium stellen unterschiedliche Anforderungen. Deshalb braucht jede Lernphase einen passenden Schwerpunkt.</p></div><aside class="hero-panel"><h2>Nicht nur der Stoff unterscheidet sich</h2><p>Auch Selbstständigkeit, Fachsprache, Prüfungstypen und Lernorganisation verändern sich.</p></aside></section>
<section class="section"><header class="section-heading"><div><span class="eyebrow">Übersicht</span><h2>Passende Unterstützung finden</h2></div></header><div class="card-grid card-grid--3">
<?php foreach ($schoolTypes as $type): ?><article class="card"><h3><?= e($type['name']) ?></h3><p><?= e($type['focus']) ?></p><a href="/nh_hor/<?= e($type['file']) ?>">Mehr erfahren →</a></article><?php endforeach; ?>
</div></section>
</div><?php require __DIR__.'/includes/footer.php'; ?></main></div></body></html>