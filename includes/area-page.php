<?php
declare(strict_types=1);

require __DIR__ . '/functions.php';
$site = require __DIR__ . '/../config/site.php';
$areas = require __DIR__ . '/../config/areas.php';
$subjects = require __DIR__ . '/../config/subjects.php';

if (!isset($areaKey, $areas[$areaKey])) {
    http_response_code(404);
    exit('Ortsseite nicht gefunden.');
}
$area = $areas[$areaKey];
$pageTitle = $area['title'];
$pageDescription = $area['description'];
$pageCanonical = $site['base_url'] . '/' . $area['file'];

$pageSchemas = [
    [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => 'Nachhilfe in ' . $area['name'],
        'serviceType' => 'Individuelle Nachhilfe',
        'description' => $area['description'],
        'provider' => [
            '@type' => 'EducationalOrganization',
            'name' => $site['site_name'],
            'url' => $site['base_url'],
        ],
        'areaServed' => [
            '@type' => $area['type'] === 'city' ? 'City' : 'AdministrativeArea',
            'name' => $area['name'],
        ],
        'url' => $pageCanonical,
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Startseite', 'item' => $site['base_url'] . '/'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Nachhilfe in Leipzig', 'item' => $site['base_url'] . '/nh_hor/nachhilfe-leipzig.php'],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $area['name'], 'item' => $pageCanonical],
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
  <a href="/">Startseite</a><span>›</span>
  <?php if ($areaKey !== 'leipzig'): ?><a href="/nh_hor/nachhilfe-leipzig.php">Leipzig</a><span>›</span><?php endif; ?>
  <span aria-current="page"><?= e($area['name']) ?></span>
</nav>

<section class="hero local-hero">
  <div>
    <span class="eyebrow">Lokale Lernförderung</span>
    <h1>Nachhilfe in <?= e($area['name']) ?></h1>
    <p><?= e($area['lead']) ?></p>
    <div class="hero-actions">
      <a class="button button--gold" href="/nh_hor/kontakt.php?ort=<?= rawurlencode($area['name']) ?>">Nachhilfe anfragen</a>
      <a class="button button--blue" href="#faecher">Fächer ansehen</a>
    </div>
  </div>
  <aside class="hero-panel">
    <span class="local-pin" aria-hidden="true">⌖</span>
    <h2><?= e($area['focus']) ?></h2>
    <p><?= e($area['local_text']) ?></p>
  </aside>
</section>

<section class="section">
  <header class="section-heading">
    <div><span class="eyebrow">Individuell</span><h2>Was gute Nachhilfe hier leisten soll</h2></div>
  </header>
  <div class="card-grid card-grid--3">
    <?php foreach ($area['benefits'] as $benefit): ?>
      <article class="card"><h3><?= e($benefit[0]) ?></h3><p><?= e($benefit[1]) ?></p></article>
    <?php endforeach; ?>
  </div>
</section>

<section class="section" id="faecher">
  <header class="section-heading">
    <div><span class="eyebrow">Fächer</span><h2>Nachhilfeangebote für <?= e($area['name']) ?></h2></div>
    <p>Verfügbarkeit und Unterrichtsform werden individuell abgestimmt.</p>
  </header>
  <div class="mini-link-grid">
    <?php foreach ($subjects as $subject): ?>
      <a href="/<?= e($subject['file']) ?>"><span aria-hidden="true"><?= e($subject['icon']) ?></span><strong><?= e($subject['name']) ?></strong></a>
    <?php endforeach; ?>
  </div>
</section>

<section class="section split-section">
  <div>
    <span class="eyebrow">Ablauf</span>
    <h2>Vom ersten Kontakt zum Lernplan</h2>
    <p>In der Anfrage genügen zunächst Fach, Klassenstufe oder Studiengang, aktuelles Thema und das gewünschte Ziel. Danach wird geklärt, ob eine regelmäßige Begleitung oder eine zeitlich begrenzte Vorbereitung sinnvoller ist.</p>
    <a class="text-link" href="/nh_hor/preise.php">Ablauf und Rahmen ansehen →</a>
  </div>
  <aside class="check-panel">
    <h3>Für die Anfrage hilfreich</h3>
    <ul>
      <li>Fach und Klassenstufe</li>
      <li>Aktuelles Unterrichtsthema</li>
      <li>Konkrete Schwierigkeiten</li>
      <li>Nächster Prüfungstermin</li>
      <li>Gewünschter Zeitrahmen</li>
    </ul>
  </aside>
</section>

<?php if ($areaKey === 'leipzig'): ?>
<section class="section">
  <header class="section-heading">
    <div><span class="eyebrow">Stadtteile</span><h2>Nachhilfe für Leipzig und Umgebung</h2></div>
  </header>
  <div class="local-link-grid">
    <?php foreach ($areas as $key => $other): if ($key === 'leipzig') continue; ?>
      <a href="/<?= e($other['file']) ?>"><?= e($other['name']) ?><span>→</span></a>
    <?php endforeach; ?>
  </div>
</section>
<?php else: ?>
<section class="section related-local">
  <header class="section-heading">
    <div><span class="eyebrow">Weitere Stadtteile</span><h2>Nachhilfe in Leipzig</h2></div>
    <a class="text-link" href="/nh_hor/nachhilfe-leipzig.php">Leipzig-Übersicht →</a>
  </header>
  <div class="local-link-grid local-link-grid--compact">
    <?php $shown = 0; foreach ($areas as $key => $other): if ($key === 'leipzig' || $key === $areaKey) continue; ?>
      <a href="/<?= e($other['file']) ?>"><?= e($other['name']) ?><span>→</span></a>
    <?php if (++$shown >= 6) break; endforeach; ?>
  </div>
</section>
<?php endif; ?>

<section class="section cta">
  <div><span class="eyebrow">Unverbindlich starten</span><h2>Nachhilfe für <?= e($area['name']) ?> anfragen</h2><p>Beschreibe kurz Lernziel und aktuellen Stand. So kann die erste Rückmeldung bereits konkret ausfallen.</p></div>
  <a class="button button--gold" href="/nh_hor/kontakt.php?ort=<?= rawurlencode($area['name']) ?>">Kontakt aufnehmen</a>
</section>
</div>
<?php require __DIR__ . '/footer.php'; ?>
</main>
</div>
</body>
</html>
