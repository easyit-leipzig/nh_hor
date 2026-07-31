<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/database.php';

header('Content-Type: text/plain; charset=utf-8');

if (!db_available()) {
    http_response_code(500);
    exit("FEHLER: Die Datenbankverbindung ist nicht verfügbar.\n");
}

try {
    $stmt = db()->query(
        "SELECT
            u.username,
            u.password_hash,
            u.is_active,
            r.role_key,
            r.is_active AS role_active
         FROM internal_users u
         INNER JOIN internal_roles r ON r.id = u.role_id
         ORDER BY u.username"
    );

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rows === []) {
        exit("FEHLER: In internal_users wurden keine Benutzer gefunden.\n");
    }

    foreach ($rows as $row) {
        $valid = password_verify('Test1234!', (string)$row['password_hash']);
        printf(
            "%-24s Rolle: %-13s Benutzer: %-4s Rolle: %-4s Passwort: %s\n",
            (string)$row['username'],
            (string)$row['role_key'],
            ((int)$row['is_active'] === 1 ? 'AKTIV' : 'AUS'),
            ((int)$row['role_active'] === 1 ? 'AKTIV' : 'AUS'),
            ($valid ? 'OK' : 'FEHLER')
        );
    }
} catch (Throwable $exception) {
    http_response_code(500);
    echo "DATENBANKFEHLER: " . $exception->getMessage() . "\n";
}
