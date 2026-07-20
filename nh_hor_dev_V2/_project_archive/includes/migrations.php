<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

function migration_table_ready(): void
{
    db()->exec(
        "CREATE TABLE IF NOT EXISTS schema_migrations (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(190) NOT NULL UNIQUE,
            checksum CHAR(64) NOT NULL,
            status ENUM('running','applied','failed') NOT NULL,
            started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            finished_at DATETIME NULL,
            duration_ms INT UNSIGNED NULL,
            error_message TEXT NULL,
            KEY idx_schema_migrations_status (status, started_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    // Kompatibilität mit der früheren zweispaltigen Migrationstabelle.
    $columns = db()->query("SHOW COLUMNS FROM schema_migrations")->fetchAll(PDO::FETCH_COLUMN);
    $required = [
        'checksum' => "ALTER TABLE schema_migrations ADD COLUMN checksum CHAR(64) NOT NULL DEFAULT '' AFTER migration",
        'status' => "ALTER TABLE schema_migrations ADD COLUMN status ENUM('running','applied','failed') NOT NULL DEFAULT 'applied' AFTER checksum",
        'started_at' => "ALTER TABLE schema_migrations ADD COLUMN started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER status",
        'finished_at' => "ALTER TABLE schema_migrations ADD COLUMN finished_at DATETIME NULL AFTER started_at",
        'duration_ms' => "ALTER TABLE schema_migrations ADD COLUMN duration_ms INT UNSIGNED NULL AFTER finished_at",
        'error_message' => "ALTER TABLE schema_migrations ADD COLUMN error_message TEXT NULL AFTER duration_ms",
    ];
    foreach ($required as $column => $sql) {
        if (!in_array($column, $columns, true)) {
            db()->exec($sql);
        }
    }
}

function migration_statements(string $sql): array
{
    $statements = [];
    $buffer = '';
    $inString = false;
    $quote = '';
    $length = strlen($sql);
    for ($i = 0; $i < $length; $i++) {
        $char = $sql[$i];
        $next = $i + 1 < $length ? $sql[$i + 1] : '';
        if (!$inString && $char === '-' && $next === '-') {
            while ($i < $length && $sql[$i] !== "\n") { $i++; }
            $buffer .= "\n";
            continue;
        }
        if (($char === "'" || $char === '"') && ($i === 0 || $sql[$i - 1] !== '\\')) {
            if (!$inString) { $inString = true; $quote = $char; }
            elseif ($quote === $char) { $inString = false; $quote = ''; }
        }
        if ($char === ';' && !$inString) {
            if (trim($buffer) !== '') { $statements[] = trim($buffer); }
            $buffer = '';
        } else { $buffer .= $char; }
    }
    if (trim($buffer) !== '') { $statements[] = trim($buffer); }
    return $statements;
}

function migration_constraint_exists(string $table, string $constraint): bool
{
    $stmt = db()->prepare('SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = :table_name AND CONSTRAINT_NAME = :constraint_name');
    $stmt->execute(['table_name' => $table, 'constraint_name' => $constraint]);
    return (int)$stmt->fetchColumn() > 0;
}

function migration_add_foreign_keys(): void
{
    $orphans = [
        ['tutor_competencies', 'tutor_id', 'tutors'],
        ['tutor_reviews', 'tutor_id', 'tutors'],
    ];
    foreach ($orphans as [$table, $column, $parent]) {
        $count = (int)db()->query("SELECT COUNT(*) FROM {$table} c LEFT JOIN {$parent} p ON p.id = c.{$column} WHERE p.id IS NULL")->fetchColumn();
        if ($count > 0) {
            throw new RuntimeException("Fremdschlüssel kann nicht ergänzt werden: {$table}.{$column} enthält {$count} verwaiste Datensätze.");
        }
    }
    $constraints = [
        ['tutor_competencies','fk_tutor_competencies_tutor','ALTER TABLE tutor_competencies ADD CONSTRAINT fk_tutor_competencies_tutor FOREIGN KEY (tutor_id) REFERENCES tutors(id) ON DELETE CASCADE'],
        ['tutor_reviews','fk_tutor_reviews_tutor','ALTER TABLE tutor_reviews ADD CONSTRAINT fk_tutor_reviews_tutor FOREIGN KEY (tutor_id) REFERENCES tutors(id) ON DELETE CASCADE'],
    ];
    foreach ($constraints as [$table,$name,$sql]) {
        if (!migration_constraint_exists($table,$name)) { db()->exec($sql); }
    }
}

function run_migrations(string $directory): array
{
    migration_table_ready();
    $pdo = db();
    $locked = (int)$pdo->query("SELECT GET_LOCK('easyit_schema_migration', 10)")->fetchColumn();
    if ($locked !== 1) { throw new RuntimeException('Migrationssperre konnte nicht erworben werden.'); }
    $applied = [];
    try {
        $files = glob(rtrim($directory, '/') . '/*.sql') ?: [];
        sort($files, SORT_STRING);
        foreach ($files as $file) {
            $name = basename($file);
            $sql = file_get_contents($file);
            if ($sql === false || trim($sql) === '') { throw new RuntimeException("Migration {$name} ist leer oder nicht lesbar."); }
            $checksum = hash('sha256', $sql);
            $stmt = $pdo->prepare('SELECT checksum, status FROM schema_migrations WHERE migration = :migration');
            $stmt->execute(['migration' => $name]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && $row['status'] === 'applied') {
                if ($row['checksum'] !== '' && !hash_equals((string)$row['checksum'], $checksum)) {
                    throw new RuntimeException("Checksumme der bereits ausgeführten Migration {$name} wurde verändert.");
                }
                continue;
            }
            $started = microtime(true);
            $upsert = $pdo->prepare("INSERT INTO schema_migrations (migration, checksum, status, started_at, finished_at, duration_ms, error_message)
                VALUES (:migration,:checksum,'running',NOW(),NULL,NULL,NULL)
                ON DUPLICATE KEY UPDATE checksum=VALUES(checksum),status='running',started_at=NOW(),finished_at=NULL,duration_ms=NULL,error_message=NULL");
            $upsert->execute(['migration'=>$name,'checksum'=>$checksum]);
            $transactional = stripos($sql, '-- @transactional true') !== false;
            try {
                if ($transactional) { $pdo->beginTransaction(); }
                foreach (migration_statements($sql) as $statement) { $pdo->exec($statement); }
                if ($name === '20260720_005_innodb_normalisierung.sql') { migration_add_foreign_keys(); }
                if ($transactional && $pdo->inTransaction()) { $pdo->commit(); }
                $duration = (int)round((microtime(true)-$started)*1000);
                $done=$pdo->prepare("UPDATE schema_migrations SET status='applied',finished_at=NOW(),duration_ms=:duration,error_message=NULL WHERE migration=:migration");
                $done->execute(['duration'=>$duration,'migration'=>$name]);
                $applied[]=$name;
            } catch (Throwable $e) {
                if ($pdo->inTransaction()) { $pdo->rollBack(); }
                $duration=(int)round((microtime(true)-$started)*1000);
                $fail=$pdo->prepare("UPDATE schema_migrations SET status='failed',finished_at=NOW(),duration_ms=:duration,error_message=:error WHERE migration=:migration");
                $fail->execute(['duration'=>$duration,'error'=>mb_substr($e->getMessage(),0,4000),'migration'=>$name]);
                throw new RuntimeException("Migration {$name} fehlgeschlagen: {$e->getMessage()}",0,$e);
            }
        }
    } finally {
        $pdo->query("SELECT RELEASE_LOCK('easyit_schema_migration')");
    }
    return $applied;
}

function migration_status(): array
{
    migration_table_ready();
    return db()->query('SELECT migration, checksum, status, started_at, finished_at, duration_ms, error_message FROM schema_migrations ORDER BY migration')->fetchAll(PDO::FETCH_ASSOC) ?: [];
}
