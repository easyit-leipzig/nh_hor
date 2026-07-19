<?php
declare(strict_types=1);

final class ConfigurationException extends RuntimeException {}

function config_env(string $name, ?string $default = null): ?string
{
    $value = getenv($name);
    if ($value === false && array_key_exists($name, $_ENV)) {
        $value = (string)$_ENV[$name];
    }
    if ($value === false && array_key_exists($name, $_SERVER)) {
        $value = (string)$_SERVER[$name];
    }
    if ($value === false || trim((string)$value) === '') {
        return $default;
    }
    return trim((string)$value);
}

function config_environment(): string
{
    $configured = config_env('APP_ENV');
    if ($configured !== null) {
        return strtolower($configured);
    }

    $host = strtolower((string)($_SERVER['HTTP_HOST'] ?? ''));
    if ($host === 'localhost' || str_starts_with($host, 'localhost:') || $host === '127.0.0.1' || str_starts_with($host, '127.0.0.1:')) {
        return 'development';
    }

    return 'production';
}

function config_is_production(): bool
{
    return config_environment() === 'production';
}

function config_directory(): string
{
    $configured = config_env('EASYIT_CONFIG_DIR');
    if ($configured !== null) {
        $real = realpath($configured);
        if ($real === false || !is_dir($real)) {
            throw new ConfigurationException('EASYIT_CONFIG_DIR verweist nicht auf ein lesbares Verzeichnis.');
        }
        return $real;
    }
    return __DIR__;
}

function config_local_file(string $filename): string
{
    return rtrim(config_directory(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
}

function config_load_local(string $filename): array
{
    $path = config_local_file($filename);
    if (!is_file($path)) {
        return [];
    }
    $value = require $path;
    if (!is_array($value)) {
        throw new ConfigurationException($path . ' muss ein PHP-Array zurückgeben.');
    }
    return $value;
}

function config_bool(?string $value, bool $default = false): bool
{
    if ($value === null) {
        return $default;
    }
    $parsed = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    return $parsed ?? $default;
}

function config_require_nonempty(array $config, array $keys, string $context): void
{
    foreach ($keys as $key) {
        $value = $config[$key] ?? null;
        if (!is_string($value) || trim($value) === '') {
            throw new ConfigurationException($context . ': Pflichtwert "' . $key . '" fehlt.');
        }
    }
}

function config_abort(Throwable $exception): never
{
    error_log('[easyIT configuration] ' . $exception->getMessage());
    http_response_code(503);
    header('Content-Type: text/html; charset=UTF-8');
    $detail = config_is_production()
        ? 'Die Website ist vorübergehend nicht vollständig konfiguriert. Bitte versuchen Sie es später erneut.'
        : htmlspecialchars($exception->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    echo '<!doctype html><html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title>Konfigurationsfehler</title></head><body><main style="max-width:48rem;margin:5rem auto;padding:1.5rem;font:16px/1.6 system-ui,sans-serif"><h1>Konfigurationsfehler</h1><p>' . $detail . '</p></main></body></html>';
    exit;
}
