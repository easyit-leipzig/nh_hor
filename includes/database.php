<?php
declare(strict_types=1);

function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $config = require __DIR__ . '/../config/database.php';
    $pdo = new PDO(
        $config['dsn'],
        $config['user'],
        $config['password'],
        $config['options']
    );
    return $pdo;
}

function db_last_error(): ?string
{
    static $lastError = null;

    if (func_num_args() === 1) {
        $argument = func_get_arg(0);
        $lastError = $argument === null ? null : (string)$argument;
    }

    return $lastError;
}

function db_available(): bool
{
    try {
        db()->query('SELECT 1');
        db_last_error(null);
        return true;
    } catch (Throwable $e) {
        db_last_error($e->getMessage());
        error_log('[easyIT database] Verbindung fehlgeschlagen: ' . $e->getMessage());
        return false;
    }
}
