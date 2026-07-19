<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/content-repository.php';
$site = require __DIR__ . '/config/site.php';

$pageTitle = 'Lernblog | easyIT Nachhilfe Leipzig';
$pageDescription = 'Artikel zu Mathematik, Naturwissenschaften, Informatik, Sprachen, Prüfungen und Lernmethoden.';
$pageCanonical = $site['base_url'] . '/nh_hor/blog.php';
$posts = cms_items('blog', 'published', 100);
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="index.php">Startseite</a><span>›</span><span aria-current="page">Lernblog</span></nav>
<section class="hero">
  <div><span class="eyebrow">Wissen und Lernmethoden</span><h1>easyIT Lernblog</h1><p>Fachliche Erklärungen und praktische Hinweise für Schule, Studium und Prüfung.</p></div>
  <aside class="hero-panel"><h2>Redaktionell gepflegt</h2><p>Neue Beiträge werden im CMS vorbereitet, geprüft und anschließend veröffentlicht.</p></aside>
</section>
<section class="section">
<?php if ($posts): ?>
<div class="card-grid card-grid--3">
<?php foreach ($posts as $post): ?>
  <article class="card">
    <h2><?= e((string)$post['title']) ?></h2>
    <p><?= e((string)($post['excerpt'] ?: 'Artikel aus dem easyIT Lernblog.')) ?></p>
    <a href="/nh_hor/blog-artikel.php?slug=<?= rawurlencode((string)$post['slug']) ?>">Artikel lesen →</a>
  </article>
<?php endforeach; ?>
</div>
<?php else: ?><p>Der Lernblog wird derzeit redaktionell vorbereitet.</p><?php endif; ?>
</section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
