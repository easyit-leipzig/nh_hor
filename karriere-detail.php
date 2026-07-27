<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/security.php';
$site = require __DIR__ . '/config/site.php';
require_once __DIR__ . '/includes/career-repository.php';
$jobs = career_all_jobs();
$key = isset($careerKey) ? (string)$careerKey : (string)($_GET['fach'] ?? '');
if (!isset($jobs[$key])) {
    http_response_code(404);
    require __DIR__ . '/errors/404.php';
    exit;
}
$careerJob = $jobs[$key];
$pageTitle = $careerJob['title'] . ' | Karriere bei easyIT Nachhilfe Leipzig';
$pageDescription = $careerJob['intro'];
$pageCanonical = $site['base_url'] . '/' . ($careerJob['slug'] ?? ('karriere-' . $key . '.php'));
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
<div class="content-wrap jobs-page career-detail-page">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="<?= e(app_path('/index.php')) ?>">Startseite</a><span>›</span><a href="<?= e(app_path('/karriere.php')) ?>">Karriere</a><span>›</span><span aria-current="page"><?= e($careerJob['code']) ?></span></nav>
<?php require __DIR__ . '/includes/career-detail.php'; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
<script src="<?= e(app_path('/assets/js/career-gallery.js')) ?>" defer></script>
</body>
</html>
