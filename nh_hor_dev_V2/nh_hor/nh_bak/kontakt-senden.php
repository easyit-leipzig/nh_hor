<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/security.php';

$site = require __DIR__ . '/config/site.php';
$formConfig = require __DIR__ . '/config/forms.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /kontakt.php', true, 303);
    exit;
}

$errors = [];
$data = [
    'name' => sanitize_line((string)($_POST['name'] ?? '')),
    'email' => sanitize_line((string)($_POST['email'] ?? '')),
    'phone' => sanitize_line((string)($_POST['phone'] ?? '')),
    'subject' => sanitize_line((string)($_POST['subject'] ?? '')),
    'school_type' => sanitize_line((string)($_POST['school_type'] ?? '')),
    'location' => sanitize_line((string)($_POST['location'] ?? '')),
    'message' => trim((string)($_POST['message'] ?? '')),
    'privacy' => (string)($_POST['privacy'] ?? ''),
    'website' => (string)($_POST['website'] ?? ''),
];

if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
    $errors[] = 'Die Sitzung ist abgelaufen. Bitte lade das Formular neu.';
}
if ($data['website'] !== '') {
    $errors[] = 'Die Anfrage konnte nicht verarbeitet werden.';
}
if (!rate_limit_ok((int)$formConfig['rate_limit_seconds'])) {
    $errors[] = 'Bitte warte kurz, bevor du das Formular erneut sendest.';
}
if (mb_strlen($data['name']) < 2) {
    $errors[] = 'Bitte gib einen Namen ein.';
}
if (!validate_email_address($data['email'])) {
    $errors[] = 'Bitte gib eine gültige E-Mail-Adresse ein.';
}
if (mb_strlen($data['message']) < 20) {
    $errors[] = 'Bitte beschreibe dein Anliegen etwas genauer.';
}
if (mb_strlen($data['message']) > (int)$formConfig['max_message_length']) {
    $errors[] = 'Die Nachricht ist zu lang.';
}
if ($data['privacy'] !== '1') {
    $errors[] = 'Bitte bestätige die Datenschutzhinweise.';
}

ensure_session_started();

if ($errors) {
    $_SESSION['contact_errors'] = $errors;
    $_SESSION['contact_old'] = $data;
    header('Location: /kontakt.php#kontaktformular', true, 303);
    exit;
}

$subject = 'Neue Website-Anfrage: ' . ($data['subject'] !== '' ? $data['subject'] : 'Nachhilfe');
$body = implode("\n", [
    'Neue Anfrage über easyIT-Leipzig.de',
    '',
    'Name: ' . $data['name'],
    'E-Mail: ' . $data['email'],
    'Telefon: ' . ($data['phone'] ?: 'nicht angegeben'),
    'Fach: ' . ($data['subject'] ?: 'nicht angegeben'),
    'Schulform: ' . ($data['school_type'] ?: 'nicht angegeben'),
    'Ort/Stadtteil: ' . ($data['location'] ?: 'nicht angegeben'),
    '',
    'Nachricht:',
    $data['message'],
    '',
    'Datenschutzversion: ' . $formConfig['privacy_version'],
    'Zeitpunkt: ' . date(DATE_ATOM),
]);

$mailSent = false;
if ((bool)$formConfig['enable_mail']) {
    $headers = [
        'From: ' . $formConfig['sender_name'] . ' <' . $formConfig['sender_email'] . '>',
        'Reply-To: ' . $data['email'],
        'Content-Type: text/plain; charset=UTF-8',
    ];
    $mailSent = mail(
        $formConfig['recipient_email'],
        '=?UTF-8?B?' . base64_encode($subject) . '?=',
        $body,
        implode("\r\n", $headers)
    );
}

$logEntry = [
    'created_at' => date(DATE_ATOM),
    'fingerprint' => client_fingerprint(),
    'subject' => $data['subject'],
    'school_type' => $data['school_type'],
    'location' => $data['location'],
    'mail_enabled' => (bool)$formConfig['enable_mail'],
    'mail_sent' => $mailSent,
];
@file_put_contents(
    __DIR__ . '/storage/contact-events.log',
    json_encode($logEntry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL,
    FILE_APPEND | LOCK_EX
);

unset($_SESSION['contact_old'], $_SESSION['contact_errors']);
$_SESSION['contact_success'] = true;

header('Location: /anfrage-erfolgreich.php', true, 303);
exit;
