<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$site = require __DIR__ . '/config/site.php';
$tools = require __DIR__ . '/config/tools.php';
$pageTitle = 'Kostenlose Lernwerkzeuge | easyIT Nachhilfe Leipzig';
$pageDescription = 'Kostenlose Lernwerkzeuge für Noten, Prozentrechnung, Einheiten und Lernplanung. Direkt im Browser und ohne Registrierung.';
$pageCanonical = $site['base_url'] . '/nh_hor/lernwerkzeuge.php';
$pageSchemas = [[
  '@context' => 'https://schema.org',
  '@type' => 'CollectionPage',
  'name' => 'Lernwerkzeuge',
  'description' => $pageDescription,
  'url' => $pageCanonical,
]];
?><!doctype html><html lang="de" data-theme="leipzig-blau"><head><?php require __DIR__.'/includes/meta.php'; ?></head><body>
<?php require __DIR__.'/includes/header.php'; ?><div class="page-shell"><?php require __DIR__.'/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="/">Startseite</a><span>›</span><span aria-current="page">Lernwerkzeuge</span></nav>
<section class="hero tool-hero"><div><span class="eyebrow">Kostenlos und ohne Registrierung</span><h1>Lernwerkzeuge für Schule und Studium</h1><p>Die Rechner helfen beim Kontrollieren, Planen und Nachvollziehen. Alle Berechnungen laufen ausschließlich im Browser.</p></div><aside class="hero-panel privacy-panel"><span class="tool-icon" aria-hidden="true">✓</span><h2>Datensparsam</h2><p>Keine Konten, keine Übertragung von Eingaben und keine versteckte Speicherung.</p></aside></section>
<section class="section"><header class="section-heading"><div><span class="eyebrow">Werkzeuge</span><h2>Direkt losrechnen</h2></div></header><div class="tool-grid">
<?php foreach($tools as $tool): ?><a class="tool-card" href="/<?= e($tool['file']) ?>"><span class="tool-card__icon" aria-hidden="true"><?= e($tool['icon']) ?></span><strong><?= e($tool['name']) ?></strong><span><?= e($tool['summary']) ?></span></a><?php endforeach; ?>
</div></section>
<section class="section"><span class="eyebrow">Didaktischer Hinweis</span><h2>Ergebnis und Rechenweg gehören zusammen</h2><p>Ein Rechner kann ein Ergebnis kontrollieren. Für nachhaltiges Lernen sollte zusätzlich klar sein, welche Größen gegeben sind, welche Formel gilt und warum das Ergebnis plausibel ist.</p></section>
</div><?php require __DIR__.'/includes/footer.php'; ?></main></div></body></html>