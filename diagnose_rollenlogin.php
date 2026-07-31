<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/internal-auth.php';
header('Content-Type: text/plain; charset=utf-8');

echo "Datenbank: " . (db_available() ? "OK" : "FEHLER") . "\n";
if (!db_available()) exit;

foreach (['internal_roles','internal_users','internal_permissions','internal_role_permissions'] as $table) {
    try {
        $count = (int)db()->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        echo str_pad($table, 30) . ": $count Datensätze\n";
    } catch (Throwable $e) {
        echo str_pad($table, 30) . ": FEHLER – " . $e->getMessage() . "\n";
    }
}

echo "\nBenutzer:\n";
$stmt=db()->query(
    "SELECT u.username,r.role_key,u.is_active,r.is_active AS role_active,
            CHAR_LENGTH(u.password_hash) AS hash_length
     FROM internal_users u
     JOIN internal_roles r ON r.id=u.role_id
     ORDER BY r.role_key,u.username"
);
foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
    printf("%-24s %-13s Benutzer:%s Rolle:%s Hash:%d\n",
        $row['username'],$row['role_key'],
        ((int)$row['is_active']===1?'OK':'AUS'),
        ((int)$row['role_active']===1?'OK':'AUS'),
        (int)$row['hash_length']
    );
}
