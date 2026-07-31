<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/content-repository.php';

$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Nachhilfe mit Erfolg | Erfolgsnachweise und Bewertungen';
$pageDescription = 'Nachvollziehbare Erfolgsdarstellung von easyIT Nachhilfe: Auswertung, Kriterien und veröffentlichte Bewertungen in persönlicher Ich-Form.';
$pageCanonical = canonical_url($site, '/erfolg.php');

$reviews = [];
try {
    $items = cms_items('review', 'published', 100);
    foreach ($items as $item) {
        $body = trim((string)($item['body'] ?? ''));
        if ($body === '') {
            continue;
        }
        $reviews[] = [
            'name' => trim((string)($item['reviewer_name'] ?? 'Anonym veröffentlicht')),
            'context' => trim((string)($item['reviewer_school_type'] ?? '')),
            'date' => (string)($item['review_date'] ?? ''),
            'text' => $body,
        ];
    }
} catch (Throwable $exception) {
    error_log('[easyIT Erfolg] Bewertungen konnten nicht geladen werden: ' . $exception->getMessage());
}
?>
<!doctype html>
<html lang="de">
<head>
<?php require __DIR__ . '/includes/meta.php'; ?>
<link rel="stylesheet" href="<?= e(app_path('/assets/css/erfolg.css')) ?>">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>

<main class="main-content" id="hauptinhalt">
<div class="content-wrap erfolg-page">

<nav class="breadcrumbs" aria-label="Brotkrumen">
  <a href="<?= e(app_path('/index.php')) ?>">Startseite</a>
  <span>›</span>
  <span aria-current="page">Erfolg</span>
</nav>

<section class="erfolg-hero" aria-labelledby="erfolg-heading">
  <div>
    <span class="eyebrow">Nachvollziehbare Lernentwicklung</span>
    <h1 id="erfolg-heading">Nachhilfe mit Erfolg</h1>
    <p class="lead"><strong>90&nbsp;% der ausgewerteten Schülerinnen und Schüler von easyIT Nachhilfe zeigen innerhalb von sechs Monaten eine deutliche Notenverbesserung.</strong></p>
    <p>Die Aussage wird nicht als Erfolgsgarantie verwendet. Sie beschreibt die dokumentierte Entwicklung der ausgewerteten Lernverläufe und wird durch veröffentlichte Rückmeldungen ergänzt.</p>
  </div>

  <aside class="erfolg-quote" aria-label="Erfolgsquote">
    <strong>90&nbsp;%</strong>
    <span>deutliche Notenverbesserung innerhalb von sechs Monaten</span>
  </aside>
</section>

<section class="section" aria-labelledby="nachweis-heading">
  <header class="section-heading">
    <div>
      <span class="eyebrow">Bewertungsgrundlage</span>
      <h2 id="nachweis-heading">Wie der Erfolgsnachweis verstanden wird</h2>
    </div>
  </header>

  <div class="evidence-grid">
    <article>
      <strong>Ausgangswert</strong>
      <p>Die schulische Ausgangslage wird zu Beginn anhand vorhandener Noten, konkreter Aufgaben und festgestellter Wissenslücken dokumentiert.</p>
    </article>
    <article>
      <strong>Beobachtungszeitraum</strong>
      <p>Berücksichtigt werden Lernverläufe, die über einen Zeitraum von bis zu sechs Monaten ausreichend dokumentiert wurden.</p>
    </article>
    <article>
      <strong>Deutliche Verbesserung</strong>
      <p>Als deutlich gilt eine nachvollziehbare Verbesserung der schulischen Bewertung oder eine vergleichbare, dokumentierte Leistungsentwicklung.</p>
    </article>
    <article>
      <strong>Keine Garantie</strong>
      <p>Jeder Lernweg ist individuell. Die Quote beschreibt ausgewertete Verläufe und stellt kein Versprechen für einen bestimmten Einzelfall dar.</p>
    </article>
  </div>
</section>

<section class="section" aria-labelledby="bewertungen-heading">
  <header class="section-heading">
    <div>
      <span class="eyebrow">Persönliche Erfahrungen</span>
      <h2 id="bewertungen-heading">Bewertungen in Ich-Form</h2>
      <p>Die veröffentlichten Rückmeldungen werden in der persönlichen Form der Lernenden beziehungsweise Eltern angezeigt.</p>
    </div>
  </header>

  <?php if ($reviews === []): ?>
    <div class="info-panel">
      <h3>Derzeit keine veröffentlichten Bewertungen</h3>
      <p>Die Erfolgsseite ist vorbereitet. Freigegebene Bewertungen aus dem CMS werden hier automatisch eingeblendet.</p>
    </div>
  <?php else: ?>
    <div class="review-grid">
    <?php foreach ($reviews as $review): ?>
      <article class="review-card">
        <div class="review-stars" aria-label="veröffentlichte Bewertung">★★★★★</div>
        <blockquote>„<?= e($review['text']) ?>“</blockquote>
        <footer>
          <strong><?= e($review['name'] !== '' ? $review['name'] : 'Anonym veröffentlicht') ?></strong>
          <?php if ($review['context'] !== ''): ?><span><?= e($review['context']) ?></span><?php endif; ?>
          <?php if ($review['date'] !== ''): ?><time datetime="<?= e($review['date']) ?>"><?= e(date('d.m.Y', strtotime($review['date']))) ?></time><?php endif; ?>
        </footer>
      </article>
    <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<section class="section proof-note" aria-labelledby="transparenz-heading">
  <h2 id="transparenz-heading">Transparenzhinweis</h2>
  <p>Die Quote von 90&nbsp;% darf nur veröffentlicht bleiben, solange die zugrunde liegende interne Auswertung nachvollziehbar dokumentiert ist. Bewertungen werden ausschließlich nach Freigabe veröffentlicht. Individuelle Lernerfolge sind keine Erfolgsgarantie.</p>
</section>

<section class="section">
  <div class="cta">
    <div>
      <span class="eyebrow">Persönlich beginnen</span>
      <h2>Lernstand und Ziel gemeinsam klären</h2>
      <p>Im ersten Gespräch wird festgelegt, woran eine sinnvolle Entwicklung konkret erkennbar sein soll.</p>
    </div>
    <a class="button button--gold" href="<?= e(app_path('/kontakt.php')) ?>">Nachhilfe anfragen</a>
  </div>
</section>

</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
