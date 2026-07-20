<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

try {
    $site = require __DIR__ . '/site.php';
    $local = config_load_local('forms.local.php');

    $config = array_replace([
        'recipient_email' => (string)$site['email'],
        'sender_email' => '',
        'sender_name' => 'easyIT Website',
        'enable_mail' => false,
        'rate_limit_seconds' => 60,
        'max_message_length' => 5000,
        'privacy_version' => '2026-07-16',
    ], $local);

    $config['recipient_email'] = config_env('MAIL_RECIPIENT', (string)$config['recipient_email']) ?? '';
    $config['sender_email'] = config_env('MAIL_SENDER', (string)$config['sender_email']) ?? '';
    $config['sender_name'] = config_env('MAIL_SENDER_NAME', (string)$config['sender_name']) ?? 'easyIT Website';
    $config['enable_mail'] = config_bool(config_env('MAIL_ENABLED'), (bool)$config['enable_mail']);

    if ($config['enable_mail']) {
        config_require_nonempty($config, ['recipient_email', 'sender_email', 'sender_name'], 'Mailkonfiguration');
        foreach (['recipient_email', 'sender_email'] as $key) {
            if (!filter_var($config[$key], FILTER_VALIDATE_EMAIL)) {
                throw new ConfigurationException('Mailkonfiguration: "' . $key . '" ist ungültig.');
            }
        }
    }

    return $config;
} catch (Throwable $exception) {
    config_abort($exception);
}
