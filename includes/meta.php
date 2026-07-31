<?php
declare(strict_types=1);

$site = require __DIR__ . '/../config/site.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/structured-data.php';

$pageTitle = trim((string)($pageTitle ?? $site['default_title']));
$pageDescription = trim((string)($pageDescription ?? $site['default_description']));
$pageRobots = trim((string)($pageRobots ?? 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1'));
$pageSchemas = is_array($pageSchemas ?? null) ? $pageSchemas : [];

// Canonicals werden immer über die zentrale, host-unabhängige Funktion normalisiert.
// Dadurch werden /nh_hor, /index.php und Tracking-Parameter nicht indexiert.
$pageCanonical = canonical_url($site, isset($pageCanonical) ? (string)$pageCanonical : null);
$pageImage = schema_absolute_url($site, (string)($pageImage ?? $site['image']));
$pageImageAlt = trim((string)($pageImageAlt ?? 'easyIT Nachhilfe Leipzig – verständlich lernen und sicherer werden'));
$pageType = trim((string)($pageType ?? 'website'));
$isIndexable = stripos($pageRobots, 'noindex') === false;

if ($pageTitle === '') {
    $pageTitle = (string)$site['default_title'];
}
if ($pageDescription === '') {
    $pageDescription = (string)$site['default_description'];
}

if ($isIndexable) {
    $hasBreadcrumb = false;
    foreach ($pageSchemas as $schema) {
        if (is_array($schema) && ($schema['@type'] ?? null) === 'BreadcrumbList') {
            $hasBreadcrumb = true;
            break;
        }
    }

    $homeCanonical = rtrim((string)$site['base_url'], '/') . '/';
    if (!$hasBreadcrumb && rtrim($pageCanonical, '/') !== rtrim($homeCanonical, '/')) {
        $breadcrumbName = trim((string)preg_replace('/\s*\|.*$/u', '', $pageTitle));
        $pageSchemas[] = breadcrumb_schema($site, [
            ['name' => 'Startseite', 'url' => '/'],
            ['name' => $breadcrumbName !== '' ? $breadcrumbName : $site['site_name'], 'url' => $pageCanonical],
        ]);
    }

    array_unshift($pageSchemas, webpage_schema($site, $pageTitle, $pageDescription, $pageCanonical, $pageImage));
}
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#0057a4">
<meta name="color-scheme" content="light">
<meta name="robots" content="<?= e($pageRobots) ?>">
<meta name="author" content="<?= e((string)$site['owner']) ?>">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($pageDescription) ?>">
<link rel="canonical" href="<?= e($pageCanonical) ?>">
<link rel="alternate" hreflang="de-DE" href="<?= e($pageCanonical) ?>">
<link rel="alternate" hreflang="x-default" href="<?= e($pageCanonical) ?>">
<meta property="og:locale" content="de_DE">
<meta property="og:type" content="<?= e($pageType) ?>">
<meta property="og:site_name" content="<?= e((string)$site['site_name']) ?>">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($pageDescription) ?>">
<meta property="og:url" content="<?= e($pageCanonical) ?>">
<meta property="og:image" content="<?= e($pageImage) ?>">
<meta property="og:image:secure_url" content="<?= e($pageImage) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="<?= e($pageImageAlt) ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($pageTitle) ?>">
<meta name="twitter:description" content="<?= e($pageDescription) ?>">
<meta name="twitter:image" content="<?= e($pageImage) ?>">
<meta name="twitter:image:alt" content="<?= e($pageImageAlt) ?>">
<link rel="icon" href="<?= e(app_path('/assets/img/favicon.svg')) ?>" type="image/svg+xml">
<link rel="manifest" href="<?= e(app_path('/manifest.webmanifest')) ?>">
<link rel="preload" href="<?= e(asset_url('assets/css/main.css')) ?>" as="style">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/main.css')) ?>">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/header.css')) ?>">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/menu-flag.css')) ?>">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/css3menu0/style.css')) ?>">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/sidebar.css')) ?>">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/content.css')) ?>">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/footer.css')) ?>">
<link rel="stylesheet" href="<?= e(asset_url('assets/css/homepage_blocks.css')) ?>">
<?php if ($isIndexable): ?>
<script type="application/ld+json" nonce="<?= e(security_csp_nonce()) ?>">
<?= json_encode(organization_schema($site), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
<script type="application/ld+json" nonce="<?= e(security_csp_nonce()) ?>">
<?= json_encode(website_schema($site), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
<?php foreach ($pageSchemas as $schema): ?>
<script type="application/ld+json" nonce="<?= e(security_csp_nonce()) ?>">
<?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>
<?php endforeach; ?>
<?php endif; ?>
