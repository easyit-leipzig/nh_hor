<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

try {
    $defaults = [
        'site_name' => 'easyIT Nachhilfe Leipzig',
        'base_url' => 'https://easyit-leipzig.de',
        'base_path' => '',
        'phone' => '+49 1520 178 27 34',
        'email' => 'info@easyit-nachhilfe.de',
        'service_area' => 'Leipzig',
        'postal_address' => [
            'street_address' => 'An der Kotsche 1',
            'postal_code' => '04207',
            'address_locality' => 'Leipzig',
            'address_region' => 'Sachsen',
            'address_country' => 'DE',
        
        ],
        'logo' => 'assets/img/logo.svg',
        'image' => 'assets/img/og-easyit.svg',
        'price_range' => '',
        'opening_hours' => [],
        'geo' => [],
        'same_as' => [],
        'owner' => 'Olaf Thiele',
        'default_title' => 'Nachhilfe Leipzig für Mathe, Physik, Chemie & Informatik | easyIT',
        'default_description' => 'Individuelle Nachhilfe in Leipzig für Mathematik, Physik, Chemie und Informatik. Verständlich erklärt, persönlich begleitet und gezielt auf Prüfungen vorbereitet.',
    ];

    $local = config_load_local('site.local.php');
    $site = array_replace($defaults, $local);

    $site['phone'] = config_env('SITE_PHONE', (string)$site['phone']) ?? '';
    $site['email'] = config_env('SITE_EMAIL', (string)$site['email']) ?? '';
    $site['base_url'] = rtrim(config_env('SITE_BASE_URL', (string)$site['base_url']) ?? '', '/');
    $site['owner'] = config_env('SITE_OWNER', (string)$site['owner']) ?? '';

    $address = is_array($site['postal_address']) ? $site['postal_address'] : [];
    $site['postal_address'] = array_replace($address, [
        'streetAddress' => config_env('SITE_STREET', isset($address['streetAddress']) ? (string)$address['streetAddress'] : '') ?? '',
        'postalCode' => config_env('SITE_POSTAL_CODE', isset($address['postalCode']) ? (string)$address['postalCode'] : '') ?? '',
        'addressLocality' => config_env('SITE_CITY', isset($address['addressLocality']) ? (string)$address['addressLocality'] : 'Leipzig') ?? 'Leipzig',
        'addressRegion' => config_env('SITE_REGION', isset($address['addressRegion']) ? (string)$address['addressRegion'] : 'Sachsen') ?? 'Sachsen',
        'addressCountry' => config_env('SITE_COUNTRY', isset($address['addressCountry']) ? (string)$address['addressCountry'] : 'DE') ?? 'DE',
    ]);

    if (!filter_var($site['base_url'], FILTER_VALIDATE_URL)) {
        throw new ConfigurationException('SITE_BASE_URL muss eine gültige URL sein.');
    }
    if (config_is_production() && !str_starts_with($site['base_url'], 'https://')) {
        throw new ConfigurationException('SITE_BASE_URL muss in Produktion eine HTTPS-Adresse sein.');
    }
    if ($site['email'] !== '' && !filter_var($site['email'], FILTER_VALIDATE_EMAIL)) {
        throw new ConfigurationException('SITE_EMAIL ist keine gültige E-Mail-Adresse.');
    }

    if (config_is_production()) {
        config_require_nonempty($site, ['phone', 'email', 'owner'], 'Websitekonfiguration');
        config_require_nonempty($site['postal_address'], ['streetAddress', 'postalCode', 'addressLocality', 'addressCountry'], 'Geschäftsadresse');
    }

    // Root-relative HTML paths (/assets/..., /kontakt.php, ...) must include
    // the local project prefix when the application runs below /nh_hor.
    $publicBasePath = rtrim((string)($site['base_path'] ?? ''), '/');
    if ($publicBasePath !== '' && PHP_SAPI !== 'cli' && !defined('EASYIT_PATH_REWRITE_ACTIVE')) {
        define('EASYIT_PATH_REWRITE_ACTIVE', true);
        ob_start(static function (string $html) use ($publicBasePath): string {
            return preg_replace_callback(
                '~\b(href|src|action)=([' . "\"'" . '])/((?!/)[^' . "\"'" . ']*)\2~i',
                static function (array $match) use ($publicBasePath): string {
                    $path = '/' . $match[3];
                    if ($path === $publicBasePath || str_starts_with($path, $publicBasePath . '/')) {
                        return $match[0];
                    }
                    return $match[1] . '=' . $match[2] . $publicBasePath . $path . $match[2];
                },
                $html
            ) ?? $html;
        });
    }

    return $site;
} catch (Throwable $exception) {
    config_abort($exception);
}
