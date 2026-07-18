<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Nur über die Kommandozeile ausführbar.');
}

require __DIR__ . '/../includes/migrations.php';

try {
    $applied = run_migrations(__DIR__ . '/migrations');
    if (!$applied) {
        fwrite(STDOUT, "Keine neuen Migrationen.\n");
        exit(0);
    }

    foreach ($applied as $migration) {
        fwrite(STDOUT, "Ausgeführt: {$migration}\n");
    }
} catch (Throwable $e) {
    fwrite(STDERR, "Migration fehlgeschlagen: " . $e->getMessage() . "\n");
    exit(1);
}
