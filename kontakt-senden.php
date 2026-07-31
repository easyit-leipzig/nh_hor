<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/SmtpMailer.php';
require_once __DIR__ . '/includes/contact-log.php';
require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/assets/php/classes/Contacts.php';

$site = require __DIR__ . '/config/site.php';
$formConfig = require __DIR__ . '/config/forms.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . app_path('/kontakt.php'), true, 303);
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
    header('Location: ' . app_path('/kontakt.php#kontaktformular'), true, 303);
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
$mailError = null;
$requestId = null;
contact_log_cleanup((int)$formConfig['contact_log_retention_days']);

/*
 * Die Anfrage wird zuerst dauerhaft gespeichert. Der Mailversand ist nur
 * die Benachrichtigung und darf nicht darüber entscheiden, ob die Anfrage
 * erhalten bleibt.
 */
try {
    $contacts = new Contacts(db());
    $levelParts = array_values(array_filter([
        $data['school_type'],
        $data['location'] !== '' ? 'Ort/Stadtteil: ' . $data['location'] : '',
    ], static fn(string $value): bool => $value !== ''));

    $requestId = $contacts->create([
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'subject' => $data['subject'],
        'level' => implode(' | ', $levelParts),
        'message' => $data['message'],
        'source_page' => app_path('/kontakt.php'),
        'ip_hash' => isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] !== ''
            ? hash('sha256', (string)$_SERVER['REMOTE_ADDR'])
            : null,
        'user_agent' => isset($_SERVER['HTTP_USER_AGENT'])
            ? mb_substr((string)$_SERVER['HTTP_USER_AGENT'], 0, 500)
            : null,
    ]);
    contact_log_event('contact_request_saved', true, 'request_' . $requestId);
} catch (Throwable $exception) {
    contact_log_event('contact_request_save_failed', false, substr(preg_replace('/[^a-z0-9]+/i', '_', strtolower($exception->getMessage())) ?? 'database_error', 0, 80));
    error_log('[easyIT contact database] ' . $exception->getMessage());
    $_SESSION['contact_errors'] = ['Die Anfrage konnte nicht in der Datenbank gespeichert werden. Bitte versuche es später erneut.'];
    $_SESSION['contact_old'] = $data;
    header('Location: ' . app_path('/kontakt.php#kontaktformular'), true, 303);
    exit;
}

if ((bool)$formConfig['enable_mail']) {
    try {
        (new SmtpMailer($formConfig))->send(
            (string)$formConfig['recipient_email'],
            $subject,
            $body,
            $data['email']
        );
        $mailSent = true;
        contact_log_event('contact_mail_handed_to_smtp', true);
    } catch (Throwable $exception) {
        $mailError = 'smtp_' . preg_replace('/[^a-z0-9]+/i', '_', strtolower($exception->getMessage()));
        $mailError = substr(trim($mailError, '_'), 0, 80);
        contact_log_event('contact_mail_failed', false, $mailError);
        error_log('[easyIT contact SMTP] ' . $exception->getMessage());
    }
} else {
    contact_log_event('contact_mail_disabled', false, 'mail_disabled');
}

if ($requestId !== null) {
    try {
        $contacts->markMailState(
            $requestId,
            false,
            $mailSent,
            $mailSent ? null : ($mailError ?? 'mail_disabled')
        );
    } catch (Throwable $exception) {
        contact_log_event('contact_mail_state_update_failed', false, 'request_' . $requestId);
        error_log('[easyIT contact database mail state] ' . $exception->getMessage());
    }
}

/*
 * Auch bei einem Mailfehler ist die Anfrage bereits in contact_requests
 * gespeichert. Deshalb wird dem Besucher kein Datenverlust vorgetäuscht.
 */
if (!$mailSent) {
    contact_log_event('contact_saved_without_notification', true, 'request_' . (string)$requestId);
}

unset($_SESSION['contact_old'], $_SESSION['contact_errors']);
$_SESSION['contact_success'] = true;

header('Location: ' . app_path('/anfrage-erfolgreich.php'), true, 303);
exit;
