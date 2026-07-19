<?php
declare(strict_types=1);

$defaults = [
    'site_name' => 'easyIT Nachhilfe Leipzig',
    'base_url' => 'https://easyit-leipzig.de',
    'base_path' => '',
    'phone' => '',
    'email' => 'info@easyit-leipzig.de',
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

$localFile = __DIR__ . '/site.local.php';
$local = is_file($localFile) ? require $localFile : [];

if (!is_array($local)) {
    throw new RuntimeException('config/site.local.php muss ein PHP-Array zurückgeben.');
}

return array_replace($defaults, $local);
