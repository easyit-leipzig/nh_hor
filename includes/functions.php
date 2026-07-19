<?php
declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}



/**
 * Builds a canonical URL from the configured public base URL.
 * Query parameters are discarded by default and are only retained when
 * explicitly supplied by the calling page.
 *
 * @param array<string,mixed> $site
 * @param array<string,scalar|null> $allowedQuery
 */
function canonical_url(array $site, ?string $requestUri = null, array $allowedQuery = []): string
{
    $baseUrl = rtrim((string)($site['base_url'] ?? ''), '/');
    $fallbackPath = rtrim((string)($site['base_path'] ?? ''), '/') . '/index.php';
    $uri = $requestUri ?? (string)($_SERVER['REQUEST_URI'] ?? $fallbackPath);
    $path = parse_url($uri, PHP_URL_PATH);

    if (!is_string($path) || $path === '' || $path[0] !== '/') {
        $path = $fallbackPath;
    }

    // Collapse duplicate slashes and remove dot segments without trusting Host.
    $segments = [];
    foreach (explode('/', preg_replace('#/+#', '/', $path) ?? $path) as $segment) {
        if ($segment === '' || $segment === '.') {
            continue;
        }
        if ($segment === '..') {
            array_pop($segments);
            continue;
        }
        $segments[] = rawurlencode(rawurldecode($segment));
    }
    $normalizedPath = '/' . implode('/', $segments);
    if (str_ends_with($path, '/') && $normalizedPath !== '/') {
        $normalizedPath .= '/';
    }

    $query = [];
    foreach ($allowedQuery as $key => $value) {
        if (!is_string($key) || $key === '' || $value === null || $value === '') {
            continue;
        }
        $query[$key] = (string)$value;
    }

    return $baseUrl . $normalizedPath
        . ($query !== [] ? '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986) : '');
}

function current_page(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $name = basename($path);
    return $name === '' ? 'index.php' : $name;
}

function is_active(string $file): bool
{
    return current_page() === $file;
}

function nav_link(string $href, string $label, string $icon = ''): string
{
    $active = is_active(basename($href));
    $class = $active ? 'nav-link is-active' : 'nav-link';
    $aria = $active ? ' aria-current="page"' : '';
    return '<a class="' . $class . '" href="' . e($href) . '"' . $aria . '>'
        . '<span aria-hidden="true">' . e($icon) . '</span>'
        . '<span>' . e($label) . '</span></a>';
}
