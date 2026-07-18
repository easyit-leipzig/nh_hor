<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$site = require __DIR__ . '/config/site.php';
$subjects = require __DIR__ . '/config/subjects.php';
$areas = require __DIR__ . '/config/areas.php';
$schoolTypes = require __DIR__ . '/config/school-types.php';
$pageTitle = 'Sitemap | easyIT Nachhilfe Leipzig';
$pageDescription = 'Übersicht aller Fach-, Stadtteil-, Schulform- und Serviceseiten von easyIT Nachhilfe Leipzig.';
$pageCanonical = $site['base_url'] . '/nh_hor/sitemap.php';
?><!doctype html><html lang="de" data-theme="leipzig-blau"><head><?php require __DIR__.'/includes/meta.php'; ?></head><body>
<?php require __DIR__.'/includes/header.php'; ?><div class="page-shell"><?php require __DIR__.'/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="index.php">Startseite</a><span>›</span><span aria-current="page">Sitemap</span></nav>
<section class="section"><span class="eyebrow">Seitenübersicht</span><h1>Sitemap</h1>
<div class="card-grid card-grid--3">
<article class="card"><h2>Fächer</h2><ul><?php foreach($subjects as $subject): ?><li><a href="/<?= e($subject['file']) ?>"><?= e($subject['name']) ?></a></li><?php endforeach; ?></ul></article>
<article class="card"><h2>Leipzig & Stadtteile</h2><ul><?php foreach($areas as $area): ?><li><a href="/<?= e($area['file']) ?>"><?= e($area['name']) ?></a></li><?php endforeach; ?></ul></article>
<article class="card"><h2>Schulformen</h2><ul><?php foreach($schoolTypes as $type): ?><li><a href="/<?= e($type['file']) ?>"><?= e($type['name']) ?></a></li><?php endforeach; ?></ul></article>
</div>
<div class="section"><h2>Service</h2><div class="mini-link-grid"><a href="/nh_hor/warum-easyit.php"><strong>Warum easyIT?</strong></a><a href="/nh_hor/ueber-mich.php"><strong>Über mich</strong></a><a href="/nh_hor/methodik.php"><strong>Methodik</strong></a><a href="/nh_hor/preise.php"><strong>Preise</strong></a><a href="/nh_hor/bewertungen.php"><strong>Bewertungen</strong></a><a href="/nh_hor/faq.php"><strong>FAQ</strong></a><a href="/nh_hor/jobs.php"><strong>Jobs</strong></a><a href="/nh_hor/kontakt.php"><strong>Kontakt</strong></a></div></div>
</section></div><?php require __DIR__.'/includes/footer.php'; ?></main></div></body></html>