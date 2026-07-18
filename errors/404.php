<?php
declare(strict_types=1);
http_response_code(404);
require __DIR__ . '/../includes/functions.php';
$site = require __DIR__ . '/../config/site.php';
$pageTitle = 'Seite nicht gefunden | easyIT Nachhilfe Leipzig';
$pageDescription = 'Die angeforderte Seite wurde nicht gefunden.';
$pageCanonical = $site['base_url'] . '/nh_hor/errors/404.php';
$pageRobots = 'noindex,nofollow';
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/../includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/../includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/../includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<section class="section error-page">
  <span class="error-code">404</span>
  <h1>Diese Seite gibt es nicht.</h1>
  <p>Möglicherweise wurde die Adresse geändert oder der Link ist veraltet.</p>
  <div class="hero-actions">
    <a class="button button--gold" href="/">Zur Startseite</a>
    <a class="button button--blue" href="/nh_hor/sitemap.php">Sitemap öffnen</a>
  </div>
</section>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
</main>
</div>
</body>
</html>
