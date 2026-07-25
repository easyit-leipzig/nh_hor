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
function schema_absolute_url(array $site, string $value): string
{
    $value = trim($value);
    if ($value === '') {
        return '';
    }
    if (filter_var($value, FILTER_VALIDATE_URL)) {
        return $value;
    }
    return rtrim((string)$site['base_url'], '/') . '/' . ltrim($value, '/');
}

/** @param array<string,mixed> $site */
function organization_id(array $site): string
{
    return rtrim((string)$site['base_url'], '/') . '/#organization';
}

/**
 * Globale, reale Unternehmensdaten. Es wird bewusst genau eine Organisation
 * ausgezeichnet; seitenspezifische Schemas referenzieren sie über @id.
 *
 * @param array<string,mixed> $site
 * @return array<string,mixed>
 */
function organization_schema(array $site): array
{
    $home = rtrim((string)$site['base_url'], '/') . '/';
    $address = is_array($site['postal_address'] ?? null) ? $site['postal_address'] : [];

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        '@id' => organization_id($site),
        'name' => trim((string)($site['site_name'] ?? '')),
        'legalName' => trim((string)($site['owner'] ?? '')),
        'url' => $home,
        'description' => trim((string)($site['default_description'] ?? '')),
        'telephone' => trim((string)($site['phone'] ?? '')),
        'email' => trim((string)($site['email'] ?? '')),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => trim((string)($address['streetAddress'] ?? '')),
            'postalCode' => trim((string)($address['postalCode'] ?? '')),
            'addressLocality' => trim((string)($address['addressLocality'] ?? '')),
            'addressRegion' => trim((string)($address['addressRegion'] ?? '')),
            'addressCountry' => trim((string)($address['addressCountry'] ?? '')),
        ],
        'areaServed' => [
            '@type' => 'City',
            'name' => trim((string)($site['service_area'] ?? 'Leipzig')),
        ],
    ];

    $logo = schema_absolute_url($site, (string)($site['logo'] ?? ''));
    if ($logo !== '') {
        $schema['logo'] = [
            '@type' => 'ImageObject',
            '@id' => $home . '#logo',
            'url' => $logo,
            'contentUrl' => $logo,
            'width' => 1200,
            'height' => 900,
        ];
    }

    $image = schema_absolute_url($site, (string)($site['image'] ?? ''));
    if ($image !== '') {
        $schema['image'] = [[
            '@type' => 'ImageObject',
            'url' => $image,
            'contentUrl' => $image,
            'width' => 1200,
            'height' => 630,
        ]];
    }

    if (schema_nonempty($site['price_range'] ?? null)) {
        $schema['priceRange'] = trim((string)$site['price_range']);
    }
    if (is_array($site['opening_hours'] ?? null) && $site['opening_hours'] !== []) {
        $schema['openingHoursSpecification'] = $site['opening_hours'];
    }
    if (is_array($site['geo'] ?? null)
        && isset($site['geo']['latitude'], $site['geo']['longitude'])
        && is_numeric($site['geo']['latitude'])
        && is_numeric($site['geo']['longitude'])) {
        $schema['geo'] = [
            '@type' => 'GeoCoordinates',
            'latitude' => (float)$site['geo']['latitude'],
            'longitude' => (float)$site['geo']['longitude'],
        ];
    }

    if (is_array($site['same_as'] ?? null)) {
        $sameAs = array_values(array_filter(
            array_map('trim', $site['same_as']),
            static fn(string $url): bool => filter_var($url, FILTER_VALIDATE_URL) !== false
        ));
        if ($sameAs !== []) {
            $schema['sameAs'] = $sameAs;
        }
    }

    return $schema;
}

/** @param array<string,mixed> $site */
function organization_reference(array $site): array
{
    return ['@id' => organization_id($site)];
}

/**
 * @param array<string,mixed> $site
 * @param list<array{name:string,url:string}> $items
 */
function breadcrumb_schema(array $site, array $items): array
{
    $elements = [];
    foreach ($items as $index => $item) {
        $elements[] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $item['name'],
            'item' => schema_absolute_url($site, $item['url']),
        ];
    }
    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $elements,
    ];
}

/** @param array<string,mixed> $site */
function website_schema(array $site): array
{
    $home = rtrim((string)$site['base_url'], '/') . '/';
    return [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => $home . '#website',
        'url' => $home,
        'name' => trim((string)($site['site_name'] ?? '')),
        'inLanguage' => 'de-DE',
        'publisher' => organization_reference($site),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => $home . 'suche.php?q={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ];
}

/**
 * @param array<string,mixed> $site
 * @return array<string,mixed>
 */
function webpage_schema(array $site, string $title, string $description, string $canonical, string $image): array
{
    $home = rtrim((string)$site['base_url'], '/') . '/';
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        '@id' => $canonical . '#webpage',
        'url' => $canonical,
        'name' => $title,
        'description' => $description,
        'inLanguage' => 'de-DE',
        'isPartOf' => ['@id' => $home . '#website'],
        'about' => organization_reference($site),
        'publisher' => organization_reference($site),
    ];
    if ($image !== '') {
        $schema['primaryImageOfPage'] = [
            '@type' => 'ImageObject',
            'url' => $image,
            'contentUrl' => $image,
        ];
    }
    return $schema;
}
