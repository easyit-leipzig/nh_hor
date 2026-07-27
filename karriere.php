<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/security.php';
$site = require __DIR__ . '/config/site.php';
require_once __DIR__ . '/includes/career-repository.php';
$jobs = career_all_jobs();

$pageTitle = 'Jobs als Nachhilfelehrkraft | easyIT Nachhilfe Leipzig';
$pageDescription = 'Stellenangebote für Deutsch, Französisch, Spanisch, soziale Fächer und verwandte Unterrichtsbereiche bei easyIT Nachhilfe Leipzig.';
$pageCanonical = $site['base_url'] . '/karriere.php';
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head>
<?php require __DIR__ . '/includes/meta.php'; ?>
<link rel="stylesheet" href="<?= e(app_path('/assets/css/jobs.css')) ?>">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap jobs-page">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="<?= e(app_path('/index.php')) ?>">Startseite</a><span>›</span><span aria-current="page">Karriere</span></nav>

<section class="jobs-hero">
  <div class="jobs-hero__copy">
    <span class="eyebrow">Arbeiten bei easyIT Nachhilfe</span>
    <h1>Unterrichten mit Vorbereitung, Haltung und persönlicher Verantwortung</h1>
    <p>Unsere Lehrkräfte vermitteln nicht nur Lösungen. Sie bereiten jede Stunde individuell vor, erklären Zusammenhänge nachvollziehbar und begleiten Lernende auf Augenhöhe.</p>
    <div class="jobs-hero__actions">
      <a class="button button--gold" href="<?= e(app_path('/kontakt.php?subject=Bewerbung')) ?>">Interesse mitteilen</a>
      <a class="button" href="#fachbereiche">Fachbereiche ansehen</a>
    </div>
  </div>
  <aside class="jobs-promise" aria-label="Arbeitgeberversprechen">
    <strong>Verstehen. Vorbereiten. Verbessern.</strong>
    <span>Auch als Lehrkraft arbeitest du bei uns nicht nach Standardschablone, sondern mit einem klaren Blick auf den einzelnen Menschen.</span>
  </aside>
</section>

<section class="section jobs-values" aria-labelledby="werte-title">
  <span class="eyebrow">Was uns verbindet</span>
  <h2 id="werte-title">Die Werte von easyIT Nachhilfe</h2>
  <div class="jobs-value-grid">
    <article><strong>Individuelle Vorbereitung</strong><p>Unterrichtsmaterial, Erklärweg und Lernziel werden auf die konkrete Situation abgestimmt.</p></article>
    <article><strong>Verstehen statt Vorsagen</strong><p>Wir geben keine bloßen Ergebnisse vor, sondern entwickeln nachvollziehbare Lösungswege.</p></article>
    <article><strong>Arbeiten auf Augenhöhe</strong><p>Fragen, Unsicherheiten und eigene Ideen der Lernenden werden ernst genommen.</p></article>
    <article><strong>Messbare Entwicklung</strong><p>Fortschritte werden beobachtet, reflektiert und für Lernende sowie Eltern verständlich gemacht.</p></article>
  </div>
</section>

<section class="section" id="fachbereiche" aria-labelledby="fachbereiche-title">
  <span class="eyebrow">Aktuell vorbereitet</span>
  <h2 id="fachbereiche-title">Stellenprofile und Bildwelten</h2>
  <p class="jobs-section-intro">Die Fachprofile besitzen jetzt eigene Detailseiten. Deutsch ist bereits mit der vollständigen easyIT-Bildserie aus Unterricht, Vorbereitung, Teamarbeit und Fortbildung ausgestattet.</p>

  <div class="job-list">
  <?php foreach ($jobs as $key => $job): ?>
    <article class="job-card" id="<?= e($key) ?>">
      <header class="job-card__header">
        <span class="job-code"><?= e($job['code']) ?></span>
        <div><h3><?= e($job['title']) ?></h3><p><?= e($job['claim']) ?></p></div>
      </header>

      <div class="job-gallery" aria-label="Bildserie <?= e($job['title']) ?>">
      <?php foreach ($job['images'] as $image): ?>
        <figure>
          <img src="<?= e(app_path($image['src'])) ?>" alt="<?= e($image['alt']) ?>" width="640" height="420" loading="lazy" decoding="async">
          <figcaption><?= e($image['caption']) ?></figcaption>
        </figure>
      <?php endforeach; ?>
      </div>

      <p class="job-intro"><?= e($job['intro']) ?></p>
      <div class="job-details">
        <section><h4>Fächer</h4><ul><?php foreach ($job['subjects'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?></ul></section>
        <section><h4>Werte</h4><ul><?php foreach ($job['values'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?></ul></section>
        <section><h4>Anforderungen</h4><ul><?php foreach ($job['requirements'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?></ul></section>
        <section><h4>Passende Profile</h4><ul><?php foreach ($job['profiles'] as $item): ?><li><?= e($item) ?></li><?php endforeach; ?></ul></section>
      </div>
      <div class="job-card__actions">
        <a class="job-apply" href="<?= e(app_path('/kontakt.php?subject=' . rawurlencode('Bewerbung ' . $job['code']))) ?>">Für <?= e($job['code']) ?> bewerben <span aria-hidden="true">→</span></a>
        <a class="job-card__detail" href="<?= e(app_path('/' . $job['slug'])) ?>">Vollständiges Stellenprofil ansehen</a>
      </div>
    </article>
  <?php endforeach; ?>
  </div>
</section>

<section class="section jobs-next">
  <span class="eyebrow">Phase 3 abgeschlossen</span>
  <h2>Datenbankgestützte Karrierepflege</h2>
  <p>Die Stellenprofile werden jetzt über die Datenbank geladen und können im geschützten Adminbereich einschließlich Bildserien, Anforderungen, Werte und FAQ gepflegt werden. Die Konfigurationsdatei bleibt als ausfallsichere Rückfallebene erhalten.</p>
</section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
