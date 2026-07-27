<?php
declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

try {
    $site = require __DIR__ . '/site.php';
    $appConfig = require __DIR__ . '/config.php';

    $defaults = [
        'recipient_email' => (string)$site['email'],
        'sender_email' => (string)$site['email'],
        'sender_name' => 'easyIT Website',
        'enable_mail' => false,
        'transport' => 'mail',
        'smtp_host' => '',
        'smtp_port' => 587,
        'smtp_encryption' => 'tls',
        'smtp_username' => '',
        'smtp_password' => '',
        'smtp_timeout' => 15,
        'rate_limit_seconds' => 60,
        'max_message_length' => 5000,
        'privacy_version' => '2026-07-20',
        'contact_log_retention_days' => 30,
    ];

    $mail = isset($appConfig['mail']) && is_array($appConfig['mail'])
        ? $appConfig['mail']
        : [];

    // Rückwärtskompatibilität für eine optionale forms.local.php.
    $legacy = config_load_local('forms.local.php');

    $normalized = [
        'recipient_email' => $mail['recipient_email'] ?? null,
        'sender_email' => $mail['sender_email'] ?? null,
        'sender_name' => $mail['sender_name'] ?? null,
        'enable_mail' => $mail['enabled'] ?? null,
        'transport' => $mail['transport'] ?? null,
        'smtp_host' => $mail['smtp_host'] ?? null,
        'smtp_port' => $mail['smtp_port'] ?? null,
        'smtp_encryption' => $mail['smtp_encryption'] ?? null,
        'smtp_username' => $mail['smtp_username'] ?? null,
        'smtp_password' => $mail['smtp_password'] ?? null,
        'smtp_timeout' => $mail['smtp_timeout'] ?? null,
    ];
    $normalized = array_filter($normalized, static fn($value): bool => $value !== null);

    $config = array_replace($defaults, $normalized, $legacy);

    $map = [
        'recipient_email' => 'MAIL_RECIPIENT',
        'sender_email' => 'MAIL_SENDER',
        'sender_name' => 'MAIL_SENDER_NAME',
        'transport' => 'MAIL_TRANSPORT',
        'smtp_host' => 'SMTP_HOST',
        'smtp_encryption' => 'SMTP_ENCRYPTION',
        'smtp_username' => 'SMTP_USERNAME',
        'smtp_password' => 'SMTP_PASSWORD',
    ];
    foreach ($map as $key => $env) {
        $config[$key] = config_env($env, (string)$config[$key]) ?? '';
    }

    $config['enable_mail'] = config_bool(config_env('MAIL_ENABLED'), (bool)$config['enable_mail']);
    $config['smtp_port'] = (int)(config_env('SMTP_PORT', (string)$config['smtp_port']) ?? $config['smtp_port']);
    $config['smtp_timeout'] = (int)(config_env('SMTP_TIMEOUT', (string)$config['smtp_timeout']) ?? $config['smtp_timeout']);
    $config['contact_log_retention_days'] = (int)(config_env('CONTACT_LOG_RETENTION_DAYS', (string)$config['contact_log_retention_days']) ?? $config['contact_log_retention_days']);

    $config['transport'] = strtolower(trim((string)$config['transport']));
    if (!in_array($config['transport'], ['mail', 'smtp', 'log'], true)) {
        throw new ConfigurationException('MAIL_TRANSPORT muss mail, smtp oder log sein.');
    }

    if ($config['enable_mail']) {
        config_require_nonempty($config, ['recipient_email', 'sender_email', 'sender_name'], 'Mail-Konfiguration');
        foreach (['recipient_email', 'sender_email'] as $key) {
            if (!filter_var($config[$key], FILTER_VALIDATE_EMAIL)) {
                throw new ConfigurationException('Mail-Konfiguration: "' . $key . '" ist ungültig.');
            }
        }

        if ($config['transport'] === 'smtp') {
            config_require_nonempty($config, ['smtp_host', 'smtp_username', 'smtp_password'], 'SMTP-Konfiguration');
            if (!in_array(strtolower((string)$config['smtp_encryption']), ['tls', 'ssl', 'none'], true)) {
                throw new ConfigurationException('SMTP_ENCRYPTION muss tls, ssl oder none sein.');
            }
            if ($config['smtp_port'] < 1 || $config['smtp_port'] > 65535) {
                throw new ConfigurationException('SMTP_PORT ist ungültig.');
            }
        }
    }

    return $config;
} catch (Throwable $exception) {
    config_abort($exception);
}
