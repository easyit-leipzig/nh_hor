<?php
declare(strict_types=1);

return [
    'ip_hash_secret' => getenv('CONTACT_IP_HASH_SECRET') ?: 'BITTE-DURCH-LANGE-ZUFAELLIGE-ZEICHENFOLGE-ERSETZEN',
    'minimum_submit_seconds' => 2,
    'rate_limit_seconds' => 60,
    'max_name_length' => 150,
    'max_email_length' => 255,
    'max_phone_length' => 50,
    'max_subject_length' => 255,
    'max_level_length' => 150,
    'max_message_length' => 10000,
];
