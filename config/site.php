<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

try {
    $defaults = [
        'site_name' => 'easyIT Nachhilfe Leipzig',
        'base_url' => 'https://easyit-leipzig.de',
        'base_path' => '',
        'phone' => '',
        'email' => '',
        'service_area' => 'Leipzig',
        'postal_address' => [],
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

    if (!filter_var($site['base_url'], FILTER_VALIDATE_URL) || !str_starts_with($site['base_url'], 'https://')) {
        throw new ConfigurationException('SITE_BASE_URL muss eine gültige HTTPS-Adresse sein.');
    }
    if ($site['email'] !== '' && !filter_var($site['email'], FILTER_VALIDATE_EMAIL)) {
        throw new ConfigurationException('SITE_EMAIL ist keine gültige E-Mail-Adresse.');
    }

    if (config_is_production()) {
        config_require_nonempty($site, ['phone', 'email', 'owner'], 'Websitekonfiguration');
        config_require_nonempty($site['postal_address'], ['streetAddress', 'postalCode', 'addressLocality', 'addressCountry'], 'Geschäftsadresse');
    }

    return $site;
} catch (Throwable $exception) {
    config_abort($exception);
}
