<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Nur über die Kommandozeile ausführbar.'); }
require __DIR__ . '/../includes/migrations.php';
$command = $argv[1] ?? 'up';
try {
    if ($command === 'status') {
        $rows = migration_status();
        if (!$rows) { fwrite(STDOUT, "Noch keine Migrationen protokolliert.\n"); exit(0); }
        foreach ($rows as $row) {
            printf("%-46s %-8s %s%s\n", $row['migration'], $row['status'], $row['finished_at'] ?? '-', $row['error_message'] ? ' | '.$row['error_message'] : '');
        }
        exit(0);
    }
    if ($command !== 'up') { fwrite(STDERR, "Verwendung: php database/migrate.php [up|status]\n"); exit(2); }
    $applied = run_migrations(__DIR__ . '/migrations');
    if (!$applied) { fwrite(STDOUT, "Keine neuen Migrationen.\n"); exit(0); }
    foreach ($applied as $migration) { fwrite(STDOUT, "Ausgeführt: {$migration}\n"); }
} catch (Throwable $e) { fwrite(STDERR, "Migration fehlgeschlagen: {$e->getMessage()}\n"); exit(1); }
