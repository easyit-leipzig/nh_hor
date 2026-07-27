<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/search-functions.php';

$site = require __DIR__ . '/config/site.php';
$query = trim((string)($_GET['q'] ?? ''));
if (site_search_length($query) > 100) {
    $query = site_search_substr($query, 0, 100);
}

$results = site_search_length($query) >= 2 ? site_search($query) : [];
$pageTitle = $query !== '' ? 'Suche nach „' . $query . '“ | easyIT Nachhilfe Leipzig' : 'Suche | easyIT Nachhilfe Leipzig';
$pageDescription = 'Serverseitige Seitensuche von easyIT Nachhilfe Leipzig.';
$pageCanonical = rtrim((string)$site['base_url'], '/') . '/suche.php';
$pageRobots = 'noindex,follow';
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="/index.php">Startseite</a><span>›</span><span aria-current="page">Suche</span></nav>
<section class="section">
<span class="eyebrow">Seitensuche</span>
<h1>Website durchsuchen</h1>
<form class="card" role="search" action="/suche.php" method="get">
  <label for="searchPageInput"><strong>Suchbegriff</strong></label>
  <div class="form-row">
    <input id="searchPageInput" name="q" type="search" value="<?= e($query) ?>" minlength="2" maxlength="100" required autocomplete="off">
    <button class="button button--blue" type="submit">Suchen</button>
  </div>
</form>

<?php if ($query === ''): ?>
<p>Gib mindestens zwei Zeichen ein. Die Suche funktioniert auch ohne JavaScript.</p>
<?php elseif (site_search_length($query) < 2): ?>
<p>Bitte gib mindestens zwei Zeichen ein.</p>
<?php elseif ($results === []): ?>
<h2>Keine Ergebnisse</h2>
<p>Für „<?= e($query) ?>“ wurde keine passende Seite gefunden. Nutze alternativ die <a href="/sitemap.php">Sitemap</a>.</p>
<?php else: ?>
<h2><?= count($results) ?> <?= count($results) === 1 ? 'Ergebnis' : 'Ergebnisse' ?> für „<?= e($query) ?>“</h2>
<div class="card-grid card-grid--2">
<?php foreach ($results as $result): ?>
<article class="card">
  <h3><a href="<?= e($result['url']) ?>"><?= e($result['title']) ?></a></h3>
  <p><?= e(site_search_excerpt($result['keywords'])) ?></p>
</article>
<?php endforeach; ?>
</div>
<?php endif; ?>
</section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
