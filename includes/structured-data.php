<?php
declare(strict_types=1);

/** @param mixed $value */
function schema_nonempty($value): bool
{
    if (is_string($value)) {
        return trim($value) !== '';
    }
    return $value !== null && $value !== [];
}

/** @param array<string,mixed> $site */
function organization_schema(array $site): array
{
    $base = rtrim((string)($site['base_url'] ?? ''), '/');
    $path = '/' . trim((string)($site['base_path'] ?? ''), '/');
    if ($path === '/') {
        $path = '';
    }
    $home = $base . $path . '/';

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        '@id' => $home . '#organization',
        'name' => (string)($site['site_name'] ?? ''),
        'url' => $home,
        'description' => (string)($site['default_description'] ?? ''),
        'areaServed' => [
            '@type' => 'City',
            'name' => (string)($site['service_area'] ?? 'Leipzig'),
        ],
        'knowsAbout' => [
            'Mathematik Nachhilfe',
            'Physik Nachhilfe',
            'Chemie Nachhilfe',
            'Informatik Nachhilfe',
            'Prüfungsvorbereitung',
            'Abiturvorbereitung',
        ],
    ];

    foreach (['email', 'telephone'] as $schemaKey) {
        $configKey = $schemaKey === 'telephone' ? 'phone' : $schemaKey;
        if (schema_nonempty($site[$configKey] ?? null)) {
            $schema[$schemaKey] = trim((string)$site[$configKey]);
        }
    }

    $logo = trim((string)($site['logo'] ?? ''));
    if ($logo !== '') {
        $schema['logo'] = str_starts_with($logo, 'http') ? $logo : $base . $path . '/' . ltrim($logo, '/');
    }
    $image = trim((string)($site['image'] ?? ''));
    if ($image !== '') {
        $schema['image'] = str_starts_with($image, 'http') ? $image : $base . $path . '/' . ltrim($image, '/');
    }

    $address = is_array($site['postal_address'] ?? null) ? $site['postal_address'] : [];
    $required = ['streetAddress', 'postalCode', 'addressLocality', 'addressCountry'];
    $complete = true;
    foreach ($required as $key) {
        if (!schema_nonempty($address[$key] ?? null)) {
            $complete = false;
            break;
        }
    }
    if ($complete) {
        $schema['@type'] = ['EducationalOrganization', 'LocalBusiness'];
        $schema['address'] = array_merge(['@type' => 'PostalAddress'], array_intersect_key($address, array_flip([
            'streetAddress', 'postalCode', 'addressLocality', 'addressRegion', 'addressCountry'
        ])));

        if (schema_nonempty($site['price_range'] ?? null)) {
            $schema['priceRange'] = trim((string)$site['price_range']);
        }
        if (is_array($site['opening_hours'] ?? null) && $site['opening_hours'] !== []) {
            $schema['openingHoursSpecification'] = $site['opening_hours'];
        }
        if (is_array($site['geo'] ?? null)
            && isset($site['geo']['latitude'], $site['geo']['longitude'])
            && is_numeric($site['geo']['latitude']) && is_numeric($site['geo']['longitude'])) {
            $schema['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => (float)$site['geo']['latitude'],
                'longitude' => (float)$site['geo']['longitude'],
            ];
        }
    }

    if (is_array($site['same_as'] ?? null)) {
        $sameAs = array_values(array_filter(array_map('trim', $site['same_as']), static fn(string $url): bool => filter_var($url, FILTER_VALIDATE_URL) !== false));
        if ($sameAs !== []) {
            $schema['sameAs'] = $sameAs;
        }
    }

    return array_filter($schema, 'schema_nonempty');
}
