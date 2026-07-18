<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/content-repository.php';
$site = require __DIR__ . '/config/site.php';

$slug = sanitize_line((string)($_GET['slug'] ?? ''));
$post = $slug !== '' ? cms_item_by_slug('blog', $slug) : null;

if (!$post) {
    http_response_code(404);
    require __DIR__ . '/errors/404.php';
    exit;
}

$pageTitle = $post['meta_title'] ?: ($post['title'] . ' | easyIT Lernblog');
$pageDescription = $post['meta_description'] ?: ($post['excerpt'] ?: 'Artikel aus dem easyIT Lernblog.');
$pageCanonical = $post['canonical_url'] ?: ($site['base_url'] . '/nh_hor/blog-artikel.php?slug=' . rawurlencode($slug));

$pageSchemas = [[
    '@context'=>'https://schema.org',
    '@type'=>'BlogPosting',
    'headline'=>$post['title'],
    'description'=>$pageDescription,
    'datePublished'=>$post['published_at'],
    'dateModified'=>$post['updated_at'],
    'mainEntityOfPage'=>$pageCanonical,
    'publisher'=>['@type'=>'EducationalOrganization','name'=>$site['site_name']]
]];
?><!doctype html>
<html lang="de" data-theme="leipzig-blau">
<head><?php require __DIR__ . '/includes/meta.php'; ?></head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>
<div class="page-shell">
<?php require __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content" id="hauptinhalt">
<div class="content-wrap">
<nav class="breadcrumbs" aria-label="Brotkrumen"><a href="/">Startseite</a><span>›</span><a href="/nh_hor/blog.php">Lernblog</a><span>›</span><span aria-current="page"><?= e((string)$post['title']) ?></span></nav>
<article class="section article-page">
  <span class="eyebrow">Lernblog</span>
  <h1><?= e((string)$post['title']) ?></h1>
  <?php if ($post['excerpt']): ?><p class="article-lead"><?= e((string)$post['excerpt']) ?></p><?php endif; ?>
  <div><?= cms_content_html((string)$post['body']) ?></div>
</article>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
</main>
</div>
</body>
</html>
