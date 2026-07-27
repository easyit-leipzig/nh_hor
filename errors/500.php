<?php
declare(strict_types=1);
http_response_code(500);
require_once __DIR__ . '/../includes/functions.php';
$site = require __DIR__ . '/../config/site.php';
$pageTitle = 'Technischer Fehler | easyIT Nachhilfe Leipzig';
$pageDescription = 'Ein technischer Fehler ist aufgetreten.';
$pageCanonical = $site['base_url'] . '/errors/500.php';
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
  <span class="error-code">500</span>
  <h1>Etwas ist schiefgelaufen.</h1>
  <p>Die Seite konnte nicht vollständig geladen werden. Bitte versuche es später erneut.</p>
  <div class="hero-actions">
    <a class="button button--gold" href="/index.php">Zur Startseite</a>
    <a class="button button--blue" href="/sitemap.php">Sitemap öffnen</a>
  </div>
</section>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
</main>
</div>
</body>
</html>
