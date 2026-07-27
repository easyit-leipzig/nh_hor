<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

try {
    $application = require __DIR__ . '/config.php';
    $app = isset($application['app']) && is_array($application['app']) ? $application['app'] : [];
    $brand = isset($application['brand']) && is_array($application['brand']) ? $application['brand'] : [];

    $defaults = [
        'site_name' => (string)($brand['name'] ?? 'easyIT Nachhilfe Leipzig'),
        'base_url' => (string)($app['base_url'] ?? 'https://www.easyit-nachhilfe.de'),
        'base_path' => '',
        'phone' => '+49 1520 178 27 34',
        'email' => (string)($brand['email'] ?? 'kontakt@easyit-nachhilfe.de'),
        'service_area' => 'Leipzig',
        'postal_address' => [
            'streetAddress' => 'An der Kotsche 1',
            'postalCode' => '04207',
            'addressLocality' => 'Leipzig',
            'addressRegion' => 'Sachsen',
            'addressCountry' => 'DE',
        ],
        'logo' => (string)($brand['logo'] ?? 'assets/img/brand-logo.svg'),
        'image' => 'assets/img/social-preview-1200x630.png',
        'price_range' => '',
        'opening_hours' => [],
        'geo' => [],
        'same_as' => [],
        'owner' => 'Olaf Thiele',
        'default_title' => 'Nachhilfe Leipzig für Naturwissenschaften, Sprachen und Soziales | easyIT',
        'default_description' => 'Individuelle Nachhilfe in Leipzig für Naturwissenschaften, Sprachen und soziale Fächer. Verständlich erklärt, persönlich begleitet und gezielt vorbereitet.',
    ];

    // Optionale, ausschließlich websitebezogene Ergänzungen bleiben möglich.
    $site = array_replace_recursive($defaults, config_load_local('site.local.php'));

    if (($application['environment'] ?? '') === 'local') {
        $scriptName = str_replace('\\', '/', (string)($_SERVER['SCRIPT_NAME'] ?? ''));
        $detectedBasePath = '';
        if (preg_match('~^(/[^/]+)(?:/|$)~', $scriptName, $match) === 1) {
            $detectedBasePath = $match[1];
        }
        $site['base_path'] = $detectedBasePath !== '' ? $detectedBasePath : '/nh_hor';
    }

    $site['phone'] = config_env('SITE_PHONE', (string)$site['phone']) ?? '';
    $site['email'] = config_env('SITE_EMAIL', (string)$site['email']) ?? '';
    $site['base_url'] = rtrim(config_env('SITE_BASE_URL', (string)$site['base_url']) ?? '', '/');
    $site['base_path'] = '/' . trim(config_env('SITE_BASE_PATH', (string)$site['base_path']) ?? '', '/');
    if ($site['base_path'] === '/') {
        $site['base_path'] = '';
    }
    $site['owner'] = config_env('SITE_OWNER', (string)$site['owner']) ?? '';

    if (!filter_var($site['base_url'], FILTER_VALIDATE_URL)) {
        throw new ConfigurationException('SITE_BASE_URL muss eine gültige URL sein.');
    }
    if (($application['environment'] ?? '') === 'server' && !str_starts_with($site['base_url'], 'https://')) {
        throw new ConfigurationException('SITE_BASE_URL muss auf dem Server eine HTTPS-Adresse sein.');
    }
    if ($site['email'] !== '' && !filter_var($site['email'], FILTER_VALIDATE_EMAIL)) {
        throw new ConfigurationException('SITE_EMAIL ist keine gültige E-Mail-Adresse.');
    }

    security_send_headers();
    return $site;
} catch (Throwable $exception) {
    config_abort($exception);
}
