<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Offline | easyIT Nachhilfe Leipzig';
$pageDescription = 'Diese Seite ist derzeit offline nicht verfügbar.';
$pageCanonical = $site['base_url'] . '/nh_hor/offline.php';
$pageRobots = 'noindex,nofollow';
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<section class="section">
  <span class="eyebrow">Offline</span>
  <h1>Keine Verbindung</h1>
  <p>Die gewünschte Seite ist aktuell nicht im Zwischenspeicher verfügbar. Bitte prüfe die Internetverbindung und lade die Seite erneut.</p>
  <a class="button button--blue" href="/nh_hor/index.php">Zur Startseite</a>
</section>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
