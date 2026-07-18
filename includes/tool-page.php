<?php
declare(strict_types=1);

require __DIR__ . '/functions.php';
$site = require __DIR__ . '/../config/site.php';
$tools = require __DIR__ . '/../config/tools.php';

if (!isset($toolKey, $tools[$toolKey])) {
    http_response_code(404);
    exit('Werkzeug nicht gefunden.');
}
$tool = $tools[$toolKey];
$pageTitle = $tool['title'];
$pageDescription = $tool['description'];
$pageCanonical = $site['base_url'] . $site['base_path'] . '/' . $tool['file'];

$pageSchemas = [
    [
        '@context' => 'https://schema.org',
        '@type' => 'WebApplication',
        'name' => $tool['name'],
        'applicationCategory' => 'EducationalApplication',
        'operatingSystem' => 'Web',
        'description' => $tool['description'],
        'url' => $pageCanonical,
        'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'EUR'],
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Startseite', 'item' => $site['base_url'] . $site['base_path'] . '/index.php'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Lernwerkzeuge', 'item' => $site['base_url'] . '/nh_hor/lernwerkzeuge.php'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $tool['name'], 'item' => $pageCanonical],
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
  <a href="/nh_hor/lernwerkzeuge.php">Lernwerkzeuge</a><span>›</span>
  <span aria-current="page"><?= e($tool['name']) ?></span>
</nav>

<section class="hero tool-hero">
  <div>
    <span class="eyebrow">Kostenloses Lernwerkzeug</span>
    <h1><?= e($tool['name']) ?></h1>
    <p><?= e($tool['summary']) ?></p>
  </div>
  <aside class="hero-panel privacy-panel">
    <span class="tool-icon" aria-hidden="true"><?= e($tool['icon']) ?></span>
    <h2>Direkt im Browser</h2>
    <p>Alle Eingaben bleiben auf diesem Gerät. Es werden keine Rechendaten an einen Server übertragen.</p>
  </aside>
</section>

<section class="section tool-section">
  <?php require __DIR__ . '/../tools/' . $toolKey . '.php'; ?>
</section>

<section class="section">
  <header class="section-heading">
    <div><span class="eyebrow">Weitere Werkzeuge</span><h2>Passende Lernhilfen</h2></div>
  </header>
  <div class="tool-grid">
    <?php foreach ($tools as $key => $other): if ($key === $toolKey) continue; ?>
      <a class="tool-card" href="/nh_hor/<?= e($other['file']) ?>">
        <span class="tool-card__icon" aria-hidden="true"><?= e($other['icon']) ?></span>
        <strong><?= e($other['name']) ?></strong>
        <span><?= e($other['summary']) ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<section class="section cta">
  <div><span class="eyebrow">Mehr als ein Rechner</span><h2>Individuelle Unterstützung in Leipzig</h2><p>Ein Werkzeug liefert ein Ergebnis. Im Unterricht geht es zusätzlich darum, den Rechenweg und die zugrunde liegende Idee zu verstehen.</p></div>
  <a class="button button--gold" href="/nh_hor/kontakt.php">Nachhilfe anfragen</a>
</section>
</div>
<?php require __DIR__ . '/footer.php'; ?>
</main>
</div>
<script src="/nh_hor/assets/js/tools.js" defer></script>
</body>
</html>
