<?php
declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Returns the application base path for the current deployment.
 * Local XAMPP installations use /nh_hor, production uses the domain root.
 */
function app_base_path(): string
{
    static $basePath = null;
    if ($basePath !== null) {
        return $basePath;
    }

    $configured = getenv('SITE_BASE_PATH');
    if (is_string($configured) && trim($configured) !== '') {
        $basePath = '/' . trim($configured, '/');
        return $basePath === '/' ? '' : $basePath;
    }

    $host = strtolower((string)($_SERVER['HTTP_HOST'] ?? ''));
    $isLocal = $host === 'localhost' || str_starts_with($host, 'localhost:')
        || $host === '127.0.0.1' || str_starts_with($host, '127.0.0.1:');

    if ($isLocal) {
        $scriptName = str_replace('\\', '/', (string)($_SERVER['SCRIPT_NAME'] ?? ''));
        if (preg_match('~^(/[^/]+)(?:/|$)~', $scriptName, $match) === 1) {
            $basePath = $match[1];
            return $basePath;
        }
        $basePath = '/nh_hor';
        return $basePath;
    }

    $basePath = '';
    return $basePath;
}

function app_path(string $path = '/'): string
{
    $normalized = '/' . ltrim($path, '/');
    $basePath = app_base_path();
    if ($normalized === '/') {
        return $basePath !== '' ? $basePath . '/' : '/';
    }
    return $basePath . $normalized;
}

/**
 * Builds a canonical URL exclusively from the configured base URL.
 *
 * Security/SEO rules:
 * - never trusts HTTP_HOST;
 * - uses only the path component of the request URI;
 * - strips the local/server base path (for example /nh_hor);
 * - canonicalizes /index.php to /;
 * - discards all request query parameters;
 * - permits only explicitly supported canonical parameters supplied by code.
 *
 * @param array<string,mixed> $site
 * @param array<string,scalar|null> $canonicalQuery
 */
function canonical_url(array $site, ?string $requestUri = null, array $canonicalQuery = []): string
{
    $baseUrl = rtrim((string)($site['base_url'] ?? ''), '/');
    if ($baseUrl === '' || filter_var($baseUrl, FILTER_VALIDATE_URL) === false) {
        throw new InvalidArgumentException('Für Canonical-URLs ist eine gültige base_url erforderlich.');
    }

    $uri = $requestUri ?? (string)($_SERVER['REQUEST_URI'] ?? '/');
    $path = parse_url($uri, PHP_URL_PATH);
    if (!is_string($path) || $path === '' || $path[0] !== '/') {
        $path = '/';
    }

    // A local deployment may run below /nh_hor. This technical path must not
    // become part of the public canonical URL.
    $basePath = rtrim((string)($site['base_path'] ?? ''), '/');
    if ($basePath !== '' && ($path === $basePath || str_starts_with($path, $basePath . '/'))) {
        $path = substr($path, strlen($basePath));
        if ($path === '') {
            $path = '/';
        }
    }

    // Normalize duplicate slashes and dot segments.
    $segments = [];
    $hadTrailingSlash = $path !== '/' && str_ends_with($path, '/');
    foreach (explode('/', preg_replace('#/+#', '/', $path) ?? $path) as $segment) {
        if ($segment === '' || $segment === '.') {
            continue;
        }
        if ($segment === '..') {
            array_pop($segments);
            continue;
        }
        $decoded = rawurldecode($segment);
        if (str_contains($decoded, "\0")) {
            continue;
        }
        $segments[] = rawurlencode($decoded);
    }

    $normalizedPath = '/' . implode('/', $segments);
    if ($normalizedPath === '/index.php') {
        $normalizedPath = '/';
    } elseif ($hadTrailingSlash && $normalizedPath !== '/') {
        $normalizedPath .= '/';
    }

    // Only parameters with actual canonical meaning are accepted. They must
    // be supplied by the page itself, never copied wholesale from $_GET.
    $supportedCanonicalParameters = ['slug', 'tutor'];
    $query = [];
    foreach ($supportedCanonicalParameters as $key) {
        if (!array_key_exists($key, $canonicalQuery)) {
            continue;
        }
        $value = trim((string)$canonicalQuery[$key]);
        if ($value === '' || preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $value) !== 1) {
            continue;
        }
        $query[$key] = $value;
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


/**
 * Returns the public path of a content-hashed frontend asset.
 *
 * Logical asset names remain stable in PHP templates, while deployed CSS and
 * JavaScript files receive immutable content hashes in their filenames.
 */
function asset_url(string $logicalPath): string
{
    static $manifest = null;

    $normalized = ltrim($logicalPath, '/');
    if ($manifest === null) {
        $manifestFile = __DIR__ . '/../config/asset-manifest.php';
        $manifest = is_file($manifestFile) ? require $manifestFile : [];
        if (!is_array($manifest)) {
            $manifest = [];
        }
    }

    $resolved = $manifest[$normalized] ?? $normalized;
    return app_path('/' . ltrim((string)$resolved, '/'));
}
