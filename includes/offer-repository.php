<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

/** @return array<int,array<string,mixed>> */
function offer_list(bool $activeOnly = true): array
{
    if (!db_available()) {
        return [];
    }

    $sql = 'SELECT id,badge,title,price_amount,price_text,price_unit,description,features_json,footnote,featured,is_active,sort_order,created_at,updated_at FROM offers';
    if ($activeOnly) {
        $sql .= ' WHERE is_active = 1';
    }
    $sql .= ' ORDER BY sort_order ASC, id ASC';

    try {
        $rows = db()->query($sql)->fetchAll();
    } catch (Throwable $e) {
        error_log('[easyIT offers] Angebote konnten nicht geladen werden: ' . $e->getMessage());
        return [];
    }

    foreach ($rows as &$row) {
        $decoded = json_decode((string)($row['features_json'] ?? ''), true);
        $row['features'] = is_array($decoded)
            ? array_values(array_filter(array_map('strval', $decoded), static fn(string $v): bool => trim($v) !== ''))
            : [];
    }
    unset($row);

    return $rows;
}

function offer_find(int $id): ?array
{
    if ($id < 1 || !db_available()) {
        return null;
    }
    try {
        $stmt = db()->prepare('SELECT * FROM offers WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }
        $decoded = json_decode((string)($row['features_json'] ?? ''), true);
        $row['features'] = is_array($decoded) ? $decoded : [];
        return $row;
    } catch (Throwable $e) {
        error_log('[easyIT offers] Angebot konnte nicht geladen werden: ' . $e->getMessage());
        return null;
    }
}

function offer_price_label(array $offer): string
{
    // Ein eingetragener Zahlenpreis hat Vorrang. Dadurch kann ein alter
    // Platzhalter wie „Preis eintragen“ die aktuelle Preisangabe nicht verdecken.
    $amount = $offer['price_amount'] ?? null;
    if ($amount !== null && $amount !== '') {
        $number = number_format((float)$amount, 2, ',', '.');
        $unit = trim((string)($offer['price_unit'] ?? ''));
        return $number . "\u{00A0}€" . ($unit !== '' ? ' ' . $unit : '');
    }

    $text = trim((string)($offer['price_text'] ?? ''));
    if ($text !== '') {
        return $text;
    }

    return 'Preis auf Anfrage';
}
