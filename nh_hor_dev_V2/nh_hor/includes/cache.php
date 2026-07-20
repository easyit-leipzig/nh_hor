<?php
declare(strict_types=1);

function cache_path(string $key): string
{
    $safe = preg_replace('/[^a-zA-Z0-9._-]/', '_', $key) ?: 'cache';
    return __DIR__ . '/../cache/' . $safe . '.json';
}

function cache_get(string $key, int $ttl = 300): mixed
{
    $path = cache_path($key);
    if (!is_file($path) || (time() - filemtime($path)) > $ttl) {
        return null;
    }

    $content = file_get_contents($path);
    if ($content === false) {
        return null;
    }

    return json_decode($content, true);
}

function cache_set(string $key, mixed $value): void
{
    $path = cache_path($key);
    @file_put_contents(
        $path,
        json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        LOCK_EX
    );
}

function cache_forget(string $key): void
{
    $path = cache_path($key);
    if (is_file($path)) {
        @unlink($path);
    }
}

function cache_clear_all(): int
{
    $count = 0;
    foreach (glob(__DIR__ . '/../cache/*.json') ?: [] as $file) {
        if (@unlink($file)) {
            $count++;
        }
    }
    return $count;
}
