<?php
declare(strict_types=1);

$site = require __DIR__ . '/../config/site.php';
$pageTitle = $pageTitle ?? $site['default_title'];
$pageDescription = $pageDescription ?? $site['default_description'];
$pageCanonical = $pageCanonical ?? $site['base_url'] . ($_SERVER['REQUEST_URI'] ?? '/');
$pageRobots = $pageRobots ?? 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1';
$pageSchemas = $pageSchemas ?? [];
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#0057a4">
<meta name="robots" content="<?= e($pageRobots) ?>">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDescription) ?>">
<link rel="canonical" href="<?= e($pageCanonical) ?>">
<meta property="og:locale" content="de_DE">
<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e($site['site_name']) ?>">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($pageDescription) ?>">
<meta property="og:url" content="<?= e($pageCanonical) ?>">
<meta property="og:image" content="<?= e($site['base_url']) ?>/assets/img/og-easyit.svg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($pageTitle) ?>">
<meta name="twitter:description" content="<?= e($pageDescription) ?>">
<link rel="icon" href="/nh_hor/assets/img/favicon.svg" type="image/svg+xml">
<link rel="manifest" href="/nh_hor/manifest.webmanifest">
<link rel="preload" href="/nh_hor/assets/css/main.css" as="style">
<link rel="stylesheet" href="/nh_hor/assets/css/main.css">
<link rel="stylesheet" href="/nh_hor/assets/css/header.css">
<link rel="stylesheet" href="/nh_hor/assets/css/sidebar.css">
<link rel="stylesheet" href="/nh_hor/assets/css/content.css">
<link rel="stylesheet" href="/nh_hor/assets/css/footer.css">
<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => ['EducationalOrganization', 'LocalBusiness'],
    'name' => $site['site_name'],
    'url' => $site['base_url'],
    'email' => $site['email'],
    'telephone' => $site['phone'],
    'areaServed' => [
        '@type' => 'City',
        'name' => 'Leipzig'
    ],
    'knowsAbout' => [
        'Mathematik Nachhilfe',
        'Physik Nachhilfe',
        'Chemie Nachhilfe',
        'Informatik Nachhilfe',
        'Prüfungsvorbereitung',
        'Abiturvorbereitung'
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php foreach ($pageSchemas as $schema): ?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
<?php endforeach; ?>
