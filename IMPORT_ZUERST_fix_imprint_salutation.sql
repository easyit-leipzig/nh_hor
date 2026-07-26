-- ============================================================
-- easyIT Nachhilfe
-- Korrektur des Feldnamens imprint_persons.saturation -> salutation
-- MariaDB 10.4 / MySQL-kompatibel und idempotent
-- ============================================================

SET @current_database := DATABASE();

SET @table_exists := (
    SELECT COUNT(*)
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = @current_database
      AND TABLE_NAME = 'imprint_persons'
);

SET @old_column_exists := (
    SELECT COUNT(*)
    FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = @current_database
      AND TABLE_NAME = 'imprint_persons'
      AND COLUMN_NAME = 'saturation'
);

SET @new_column_exists := (
    SELECT COUNT(*)
    FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = @current_database
      AND TABLE_NAME = 'imprint_persons'
      AND COLUMN_NAME = 'salutation'
);

SET @migration_sql := CASE
    WHEN @table_exists = 0 THEN
        'SELECT ''Hinweis: Tabelle imprint_persons ist nicht vorhanden.'' AS migration_status'
    WHEN @old_column_exists = 1 AND @new_column_exists = 0 THEN
        'ALTER TABLE `imprint_persons` CHANGE COLUMN `saturation` `salutation` VARCHAR(40) NOT NULL DEFAULT '''''
    WHEN @old_column_exists = 1 AND @new_column_exists = 1 THEN
        'SELECT ''Hinweis: Beide Felder sind vorhanden; keine automatische Änderung durchgeführt.'' AS migration_status'
    ELSE
        'SELECT ''OK: Feld salutation ist bereits korrekt vorhanden.'' AS migration_status'
END;

PREPARE migration_statement FROM @migration_sql;
EXECUTE migration_statement;
DEALLOCATE PREPARE migration_statement;
