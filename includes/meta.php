<?php
declare(strict_types=1);

$site = require __DIR__ . '/../config/site.php';
require_once __DIR__ . '/functions.php';
$pageTitle = $pageTitle ?? $site['default_title'];
$pageDescription = $pageDescription ?? $site['default_description'];
$pageCanonical = $pageCanonical ?? canonical_url($site);
$pageRobots = $pageRobots ?? 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1';
$pageSchemas = $pageSchemas ?? [];

require_once __DIR__ . '/structured-data.php';
$organizationSchema = organization_schema($site);
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
<meta property="og:image" content="<?= e($site['base_url'] . $site['base_path']) ?>/assets/img/og-easyit.svg">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($pageTitle) ?>">
<meta name="twitter:description" content="<?= e($pageDescription) ?>">
<link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
<link rel="manifest" href="/manifest.webmanifest">
<link rel="preload" href="/assets/css/main.css" as="style">
<link rel="stylesheet" href="/assets/css/main.css">
<link rel="stylesheet" href="/assets/css/header.css">
<link rel="stylesheet" href="/assets/css/sidebar.css">
<link rel="stylesheet" href="/assets/css/content.css">
<link rel="stylesheet" href="/assets/css/footer.css">
<script type="application/ld+json">
<?= json_encode($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php foreach ($pageSchemas as $schema): ?>
<script type="application/ld+json">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
<?php endforeach; ?>
