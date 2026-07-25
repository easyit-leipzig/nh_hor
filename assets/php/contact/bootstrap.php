<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/classes/Mailer.php';
require_once dirname(__DIR__) . '/classes/Contacts.php';

/*
 * Vorhandene PDO-Datei verwenden.
 * Sie muss eine Variable $pdo vom Typ PDO bereitstellen.
 */
require dirname(__DIR__) . '/config/database.php';

if (!isset($pdo) || !$pdo instanceof PDO) {
    throw new RuntimeException('Die Datenbankverbindung $pdo wurde nicht bereitgestellt.');
}

$mailConfigFile = dirname(__DIR__) . '/config/mail.php';
$contactConfigFile = dirname(__DIR__) . '/config/contact.php';

if (!is_file($mailConfigFile) || !is_file($contactConfigFile)) {
    throw new RuntimeException('mail.php oder contact.php fehlt. Beispielkonfiguration kopieren.');
}

$mailConfig = require $mailConfigFile;
$contactConfig = require $contactConfigFile;

$contacts = new Contacts($pdo);
$mailer = new Mailer($mailConfig);
