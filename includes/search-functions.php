<?php
declare(strict_types=1);

/** @return array<int,array{title:string,url:string,keywords:string}> */
function site_search_pages(): array
{
    static $pages = null;
    if ($pages === null) {
        $loaded = require __DIR__ . '/../config/search-pages.php';
        $pages = is_array($loaded) ? $loaded : [];
    }
    return $pages;
}

function site_search_length(string $value): int
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}

function site_search_substr(string $value, int $start, int $length): string
{
    return function_exists('mb_substr') ? mb_substr($value, $start, $length, 'UTF-8') : substr($value, $start, $length);
}

function site_search_excerpt(string $value, int $limit = 180): string
{
    if (function_exists('mb_strimwidth')) {
        return mb_strimwidth($value, 0, $limit, '…', 'UTF-8');
    }
    return strlen($value) > $limit ? substr($value, 0, max(0, $limit - 3)) . '...' : $value;
}

function site_search_normalize(string $value): string
{
    $trimmed = trim($value);
    $value = function_exists('mb_strtolower') ? mb_strtolower($trimmed, 'UTF-8') : strtolower($trimmed);
    $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
    $value = is_string($transliterated) ? $transliterated : $value;
    return preg_replace('/[^a-z0-9]+/', ' ', $value) ?? '';
}

/** @return array<int,array{title:string,url:string,keywords:string,score:int}> */
function site_search(string $query, int $limit = 30): array
{
    $normalizedQuery = site_search_normalize($query);
    $tokens = array_values(array_filter(preg_split('/\s+/', $normalizedQuery) ?: [], static fn(string $token): bool => strlen($token) >= 2));
    if ($tokens === []) {
        return [];
    }

    $matches = [];
    foreach (site_search_pages() as $page) {
        $title = (string)($page['title'] ?? '');
        $keywords = (string)($page['keywords'] ?? '');
        $titleNormalized = site_search_normalize($title);
        $haystack = $titleNormalized . ' ' . site_search_normalize($keywords);
        $score = 0;

        foreach ($tokens as $token) {
            if (!str_contains($haystack, $token)) {
                continue 2;
            }
            $score += str_contains($titleNormalized, $token) ? 5 : 1;
        }

        if (str_contains($titleNormalized, $normalizedQuery)) {
            $score += 10;
        }

        $matches[] = [
            'title' => $title,
            'url' => (string)($page['url'] ?? '/'),
            'keywords' => $keywords,
            'score' => $score,
        ];
    }

    usort($matches, static fn(array $a, array $b): int => ($b['score'] <=> $a['score']) ?: strcasecmp($a['title'], $b['title']));
    return array_slice($matches, 0, max(1, $limit));
}
