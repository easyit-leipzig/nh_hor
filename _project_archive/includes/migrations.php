<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

function migration_table_ready(): void
{
    db()->exec(
        'CREATE TABLE IF NOT EXISTS schema_migrations (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(190) NOT NULL UNIQUE,
            executed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB'
    );
}

function run_migrations(string $directory): array
{
    migration_table_ready();
    $executed = db()->query('SELECT migration FROM schema_migrations')->fetchAll(PDO::FETCH_COLUMN);
    $executed = array_flip($executed ?: []);
    $applied = [];

    foreach (glob(rtrim($directory, '/') . '/*.sql') ?: [] as $file) {
        $name = basename($file);
        if (isset($executed[$name])) {
            continue;
        }

        $sql = file_get_contents($file);
        if ($sql === false || trim($sql) === '') {
            continue;
        }

        $pdo = db();
        $pdo->beginTransaction();
        try {
            $pdo->exec($sql);
            $stmt = $pdo->prepare('INSERT INTO schema_migrations (migration) VALUES (:migration)');
            $stmt->execute(['migration' => $name]);
            $pdo->commit();
            $applied[] = $name;
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    return $applied;
}
