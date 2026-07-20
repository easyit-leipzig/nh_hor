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
    ], $local);

    $map = [
        'recipient_email' => 'MAIL_RECIPIENT', 'sender_email' => 'MAIL_SENDER',
        'sender_name' => 'MAIL_SENDER_NAME', 'smtp_host' => 'SMTP_HOST',
        'smtp_encryption' => 'SMTP_ENCRYPTION', 'smtp_username' => 'SMTP_USERNAME',
        'smtp_password' => 'SMTP_PASSWORD',
    ];
    foreach ($map as $key => $env) $config[$key] = config_env($env, (string)$config[$key]) ?? '';
    $config['enable_mail'] = config_bool(config_env('MAIL_ENABLED'), (bool)$config['enable_mail']);
    $config['smtp_port'] = (int)(config_env('SMTP_PORT', (string)$config['smtp_port']) ?? $config['smtp_port']);
    $config['smtp_timeout'] = (int)(config_env('SMTP_TIMEOUT', (string)$config['smtp_timeout']) ?? $config['smtp_timeout']);
    $config['contact_log_retention_days'] = (int)(config_env('CONTACT_LOG_RETENTION_DAYS', (string)$config['contact_log_retention_days']) ?? $config['contact_log_retention_days']);

    if ($config['enable_mail']) {
        config_require_nonempty($config, ['recipient_email','sender_email','sender_name','smtp_host','smtp_username','smtp_password'], 'SMTP-Konfiguration');
        foreach (['recipient_email','sender_email'] as $key) if (!filter_var($config[$key], FILTER_VALIDATE_EMAIL)) throw new ConfigurationException('SMTP-Konfiguration: "' . $key . '" ist ungültig.');
        if (!in_array(strtolower((string)$config['smtp_encryption']), ['tls','ssl','none'], true)) throw new ConfigurationException('SMTP_ENCRYPTION muss tls, ssl oder none sein.');
        if ($config['smtp_port'] < 1 || $config['smtp_port'] > 65535) throw new ConfigurationException('SMTP_PORT ist ungültig.');
    }
    return $config;
} catch (Throwable $exception) { config_abort($exception); }
