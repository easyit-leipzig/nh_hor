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

function db_available(): bool
{
    try {
        db()->query('SELECT 1');
        return true;
    } catch (Throwable $e) {
        return false;
    }
}
