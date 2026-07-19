<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Impressum | easyIT Nachhilfe Leipzig';
$pageDescription = 'Anbieterkennzeichnung von easyIT Nachhilfe Leipzig. Die Pflichtangaben müssen vor Veröffentlichung vollständig ergänzt werden.';
$pageCanonical = $site['base_url'] . '/nh_hor/impressum.php';
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="/">Startseite</a><span>›</span><span aria-current="page">Impressum</span></nav>
<section class="content-hero"><span class="eyebrow">Rechtliche Anbieterangaben</span><h1>Impressum</h1><p class="lead">Anbieterkennzeichnung von easyIT Nachhilfe Leipzig. Die Pflichtangaben müssen vor Veröffentlichung vollständig ergänzt werden.</p></section>

<section class="section prose"><div class="notice notice--error"><strong>Nicht unverändert veröffentlichen.</strong><p>Die folgenden Felder sind Platzhalter und müssen mit den tatsächlichen Angaben nach § 5 DDG und gegebenenfalls weiteren Vorschriften ergänzt sowie rechtlich geprüft werden.</p></div><h2>Angaben des Anbieters</h2><p><strong>Name:</strong> Olaf Thiele<br><strong>Anschrift:</strong> [vollständige ladungsfähige Anschrift]<br><strong>Telefon:</strong> [Telefonnummer]<br><strong>E-Mail:</strong> [E-Mail-Adresse]</p><h2>Steuerliche Angaben</h2><p>[Steuernummer oder Umsatzsteuer-Identifikationsnummer nur soweit rechtlich erforderlich und zur Veröffentlichung bestimmt.]</p><h2>Verantwortlich für Inhalte</h2><p>[Name und Anschrift eintragen, sofern erforderlich.]</p><h2>Verbraucherstreitbeilegung</h2><p>[Individuell prüfen, ob und welche Information nach dem Verbraucherstreitbeilegungsgesetz erforderlich ist.]</p></section>

</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>