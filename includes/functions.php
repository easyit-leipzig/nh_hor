<?php
declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
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
