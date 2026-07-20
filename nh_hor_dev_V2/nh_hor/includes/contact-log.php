<?php
declare(strict_types=1);

function contact_log_file(): string
{
    return dirname(__DIR__) . '/storage/contact-events.log';
}

function contact_log_cleanup(int $retentionDays): void
{
    $file = contact_log_file();
    if (!is_file($file)) return;
    $cutoff = time() - max(1, $retentionDays) * 86400;
    $lines = @file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!is_array($lines)) return;
    $kept = [];
    foreach ($lines as $line) {
        $entry = json_decode($line, true);
        $timestamp = is_array($entry) ? strtotime((string)($entry['created_at'] ?? '')) : false;
        if ($timestamp !== false && $timestamp >= $cutoff) $kept[] = $line;
    }
    @file_put_contents($file, $kept ? implode(PHP_EOL, $kept) . PHP_EOL : '', LOCK_EX);
}

function contact_log_event(string $event, bool $success, ?string $errorCode = null): void
{
    $entry = [
        'created_at' => date(DATE_ATOM),
        'event' => $event,
        'success' => $success,
    ];
    if ($errorCode !== null && $errorCode !== '') $entry['error_code'] = $errorCode;
    @file_put_contents(contact_log_file(), json_encode($entry, JSON_UNESCAPED_SLASHES) . PHP_EOL, FILE_APPEND | LOCK_EX);
}
