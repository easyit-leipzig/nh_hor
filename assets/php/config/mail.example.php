<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;

return [
    'host' => getenv('MAIL_HOST') ?: '127.0.0.1',
    'port' => (int) (getenv('MAIL_PORT') ?: 1025),
    'auth' => filter_var(getenv('MAIL_AUTH') ?: 'false', FILTER_VALIDATE_BOOL),
    'username' => getenv('MAIL_USERNAME') ?: '',
    'password' => getenv('MAIL_PASSWORD') ?: '',
    'encryption' => getenv('MAIL_ENCRYPTION') ?: '', // '', 'tls', 'ssl'
    'from_email' => getenv('MAIL_FROM_EMAIL') ?: 'info@easyit-leipzig.de',
    'from_name' => getenv('MAIL_FROM_NAME') ?: 'easyIT Nachhilfe Leipzig',
    'admin_email' => getenv('MAIL_ADMIN_EMAIL') ?: 'info@easyit-leipzig.de',
    'reply_subject' => 'Ihre Anfrage bei easyIT Nachhilfe Leipzig',
];
