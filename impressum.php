<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/database.php';
$site = require __DIR__ . '/config/site.php';
$pageTitle = 'Impressum | easyIT Nachhilfe Leipzig';
$pageDescription = 'Anbieterkennzeichnung von easyIT Nachhilfe Leipzig.';
$pageCanonical = $site['base_url'] . '/impressum.php';
?><!doctype html>
<html lang="de">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt"><div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="index.php">Startseite</a><span>›</span><span aria-current="page">Impressum</span></nav>
<section class="content-hero"><span class="eyebrow">Rechtliche Anbieterangaben</span><h1>Impressum</h1><p class="lead">Anbieterkennzeichnung von easyIT Nachhilfe Leipzig. Die Pflichtangaben müssen vor Veröffentlichung vollständig ergänzt werden.</p></section>

<section class="section prose">
<h2>Angaben des Anbieters</h2>
<?php
$company = null;
try {
    $stmt = db()->query("SELECT company, prefix, suffix FROM imprint_company ORDER BY id ASC LIMIT 1");
    $company = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
} catch (Throwable $e) {
    $company = null;
}
$stmt = db()->prepare(
"
SELECT
    salutation,
    title,
    firstname,
    lastname

FROM imprint_persons

WHERE to_role = 2

LIMIT 1
"
);

$stmt->execute();

$owner = $stmt->fetch(PDO::FETCH_ASSOC);
$owner_name = implode(
    ' ',
    array_filter(
        [
            $owner['salutation'] ?? '',
            $owner['title'] ?? '',
            $owner['firstname'] ?? '',
            $owner['lastname'] ?? ''
        ],
        function ($value) {
            return trim((string)$value) !== '';
        }
    )
);


?>
<p>
<strong>Name:</strong>
<?= e(($company['prefix'] ?? '') . ' ' . ($company['company'] ?? $site['owner']) . ' ' . ($company['suffix'] ?? '')) ?><br>
<strong>Vertreten durch:</strong>
<?= $owner_name ?><br>
<strong>Anschrift:</strong> <?= e($site['postal_address']['streetAddress']) ?>, <?= e($site['postal_address']['postalCode']) ?> <?= e($site['postal_address']['addressLocality']) ?><br>
<strong>Telefon:</strong> <a href="tel:<?= e(preg_replace('/\s+/', '', $site['phone'])) ?>"><?= e($site['phone']) ?></a><br>
<strong>E-Mail:</strong> <a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a>
</p>
<h2>Steuerangaben</h2>
<p>Kleinunternehmen nach § 19 UStG von der Umsatzsteuer befreit</p>
<h2>Verantwortlich für Inhalte</h2><p><?= e($site['owner']) ?>, <?= e($site['postal_address']['streetAddress']) ?>, <?= e($site['postal_address']['postalCode']) ?> <?= e($site['postal_address']['addressLocality']) ?></p>
<!--
<h2>Verbraucherstreitbeilegung</h2><p>[Individuell prüfen, ob und welche Information nach dem Verbraucherstreitbeilegungsgesetz erforderlich ist.]</p>
-->
</section>

</div><?php require __DIR__ . '/includes/footer.php'; ?></main></div></body></html>