<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/cache.php';

function cms_items(string $type, string $status = 'published', int $limit = 100, bool $useCache = true): array
{
    $allowedTypes = ['faq', 'review', 'job', 'blog'];
    $allowedStatus = ['draft', 'published', 'archived'];

    if (!in_array($type, $allowedTypes, true) || !in_array($status, $allowedStatus, true)) {
        return [];
    }

    $limit = max(1, min($limit, 500));
    $cacheKey = "cms_{$type}_{$status}_{$limit}";

    if ($useCache && $status === 'published') {
        $cached = cache_get($cacheKey, 300);
        if (is_array($cached)) {
            return $cached;
        }
    }

    if (!db_available()) {
        return [];
    }

    $sql = "SELECT * FROM content_items
            WHERE content_type = :type AND status = :status
            ORDER BY featured DESC, sort_order ASC, published_at DESC, id DESC
            LIMIT {$limit}";
    $stmt = db()->prepare($sql);
    $stmt->execute(['type' => $type, 'status' => $status]);
    $items = $stmt->fetchAll();

    if ($useCache && $status === 'published') {
        cache_set($cacheKey, $items);
    }

    return $items;
}

function cms_item_by_slug(string $type, string $slug, bool $includeDraft = false): ?array
{
    if (!db_available()) {
        return null;
    }

    $statusSql = $includeDraft ? '' : ' AND status = "published"';
    $stmt = db()->prepare(
        "SELECT * FROM content_items
         WHERE content_type = :type AND slug = :slug {$statusSql}
         LIMIT 1"
    );
    $stmt->execute(['type' => $type, 'slug' => $slug]);
    $item = $stmt->fetch();
    return $item ?: null;
}

function cms_content_html(string $body): string
{
    $escaped = htmlspecialchars($body, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $paragraphs = preg_split('/\R{2,}/', trim($escaped)) ?: [];
    return implode("\n", array_map(
        static fn(string $paragraph): string => '<p>' . nl2br(trim($paragraph)) . '</p>',
        array_filter($paragraphs, static fn(string $paragraph): bool => trim($paragraph) !== '')
    ));
}

function cms_forget_type_cache(string $type): void
{
    foreach ([10, 20, 50, 100, 500] as $limit) {
        cache_forget("cms_{$type}_published_{$limit}");
    }
}
