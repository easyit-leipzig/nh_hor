<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/content-repository.php';
$site = require __DIR__ . '/config/site.php';
$subjects = require __DIR__ . '/config/subjects.php';
$areas = require __DIR__ . '/config/areas.php';
$schoolTypes = require __DIR__ . '/config/school-types.php';

header('Content-Type: application/xml; charset=UTF-8');
header('X-Robots-Tag: noindex, follow', true);

/** @return string|null */
function sitemap_lastmod_for_file(string $file): ?string
{
    $path = __DIR__ . '/' . ltrim($file, '/');
    if (!is_file($path)) {
        return null;
    }
    $mtime = filemtime($path);
    return $mtime === false ? null : gmdate('Y-m-d', $mtime);
}

/** @param array<string,array{loc:string,lastmod:?string,changefreq:string,priority:string}> $urls */
function sitemap_add(array &$urls, string $loc, ?string $lastmod = null, string $changefreq = 'monthly', string $priority = '0.6'): void
{
    if (isset($urls[$loc])) {
        if ($lastmod !== null && ($urls[$loc]['lastmod'] === null || $lastmod > $urls[$loc]['lastmod'])) {
            $urls[$loc]['lastmod'] = $lastmod;
        }
        return;
    }
    $urls[$loc] = ['loc' => $loc, 'lastmod' => $lastmod, 'changefreq' => $changefreq, 'priority' => $priority];
}

$staticPages = [
    'index.php', 'faecher.php', 'nachhilfe-in-leipzig.php', 'schulformen.php',
    'nachhilfe-leipzig.php', 'abiturvorbereitung-leipzig.php', 'nachhilfe-studium-leipzig.php',
    'warum-easyit.php', 'ueber-mich.php', 'methodik.php', 'preise.php', 'bewertungen.php',
    'faq.php', 'jobs.php', 'kontakt.php', 'sitemap.php', 'impressum.php', 'datenschutz.php',
    'lernwerkzeuge.php', 'notenrechner.php', 'prozentrechner.php', 'einheitenrechner.php',
    'lernzeitplaner.php', 'blog.php'
];

foreach ($subjects as $item) {
    if (!empty($item['file'])) { $staticPages[] = (string)$item['file']; }
}
foreach ($areas as $item) {
    if (!empty($item['file'])) { $staticPages[] = (string)$item['file']; }
}
foreach ($schoolTypes as $item) {
    if (!empty($item['file'])) { $staticPages[] = (string)$item['file']; }
}

$excluded = [
    'offline.php', 'anfrage-erfolgreich.php', 'kontakt-senden.php', 'sitemap-xml.php',
    'blog-artikel.php', 'tutor-bewertungen.php'
];

$urls = [];
foreach (array_unique($staticPages) as $file) {
    if (in_array($file, $excluded, true) || !is_file(__DIR__ . '/' . $file)) {
        continue;
    }
    $path = $file === 'index.php' ? '/' : '/' . ltrim($file, '/');
    $priority = $file === 'index.php' ? '1.0' : (in_array($file, ['faecher.php', 'nachhilfe-in-leipzig.php', 'preise.php', 'kontakt.php'], true) ? '0.8' : '0.6');
    $changefreq = $file === 'index.php' ? 'weekly' : 'monthly';
    sitemap_add($urls, canonical_url($site, $path), sitemap_lastmod_for_file($file), $changefreq, $priority);
}

// Only published CMS records are eligible. Drafts, previews and archived items never enter the sitemap.
foreach (cms_items('blog', 'published', 500, false) as $post) {
    $slug = trim((string)($post['slug'] ?? ''));
    if ($slug === '' || preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug) !== 1) {
        continue;
    }
    $lastmodRaw = (string)($post['updated_at'] ?? $post['published_at'] ?? '');
    $timestamp = $lastmodRaw !== '' ? strtotime($lastmodRaw) : false;
    $lastmod = $timestamp !== false ? gmdate('Y-m-d', $timestamp) : null;
    sitemap_add($urls, canonical_url($site, '/blog-artikel.php', ['slug' => $slug]), $lastmod, 'monthly', '0.7');
}

ksort($urls, SORT_STRING);

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $entry) {
    echo "  <url>\n";
    echo '    <loc>' . htmlspecialchars($entry['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>\n";
    if ($entry['lastmod'] !== null) {
        echo '    <lastmod>' . $entry['lastmod'] . "</lastmod>\n";
    }
    echo '    <changefreq>' . $entry['changefreq'] . "</changefreq>\n";
    echo '    <priority>' . $entry['priority'] . "</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>' . "\n";
