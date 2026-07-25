<?php
declare(strict_types=1);

/**
 * Wird am Anfang von kontakt.php eingebunden.
 * Erwartet das vorhandene Formular mit:
 * website, name, email, phone, subject, level, message, csrf_token.
 */

require __DIR__ . '/bootstrap.php';

$contactSuccess = false;
$contactErrors = [];
$contactData = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'subject' => '',
    'level' => '',
    'message' => '',
];

$_SESSION['contact_form_started_at'] ??= time();
$_SESSION['contact_csrf_token'] ??= bin2hex(random_bytes(32));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($contactData as $field => $default) {
        $contactData[$field] = trim((string) ($_POST[$field] ?? $default));
    }

    $postedToken = (string) ($_POST['csrf_token'] ?? '');
    if (!hash_equals((string) $_SESSION['contact_csrf_token'], $postedToken)) {
        $contactErrors[] = 'Die Sitzung ist abgelaufen. Bitte laden Sie die Seite neu.';
    }

    if (trim((string) ($_POST['website'] ?? '')) !== '') {
        $contactErrors[] = 'Die Anfrage konnte nicht verarbeitet werden.';
    }

    $elapsed = time() - (int) ($_SESSION['contact_form_started_at'] ?? time());
    if ($elapsed < (int) $contactConfig['minimum_submit_seconds']) {
        $contactErrors[] = 'Das Formular wurde zu schnell abgesendet.';
    }

    $lastSubmission = (int) ($_SESSION['contact_last_submission'] ?? 0);
    if ($lastSubmission > 0 && time() - $lastSubmission < (int) $contactConfig['rate_limit_seconds']) {
        $contactErrors[] = 'Bitte warten Sie kurz, bevor Sie eine weitere Anfrage senden.';
    }

    if ($contactData['name'] === '' || mb_strlen($contactData['name']) > (int) $contactConfig['max_name_length']) {
        $contactErrors[] = 'Bitte geben Sie einen gültigen Namen ein.';
    }

    if (
        !filter_var($contactData['email'], FILTER_VALIDATE_EMAIL)
        || mb_strlen($contactData['email']) > (int) $contactConfig['max_email_length']
    ) {
        $contactErrors[] = 'Bitte geben Sie eine gültige E-Mail-Adresse ein.';
    }

    foreach (['phone', 'subject', 'level'] as $field) {
        $limitKey = 'max_' . $field . '_length';
        if (mb_strlen($contactData[$field]) > (int) $contactConfig[$limitKey]) {
            $contactErrors[] = 'Eine Eingabe ist zu lang.';
            break;
        }
    }

    if (
        $contactData['message'] === ''
        || mb_strlen($contactData['message']) > (int) $contactConfig['max_message_length']
    ) {
        $contactErrors[] = 'Bitte geben Sie eine Nachricht ein.';
    }

    if ($contactErrors === []) {
        $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? '');
        $contactData['ip_hash'] = $ip !== ''
            ? hash_hmac('sha256', $ip, (string) $contactConfig['ip_hash_secret'])
            : null;
        $contactData['user_agent'] = mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 500);
        $contactData['source_page'] = mb_substr((string) ($_SERVER['REQUEST_URI'] ?? '/kontakt.php'), 0, 255);

        $pdo->beginTransaction();

        try {
            $requestId = $contacts->create($contactData);
            $pdo->commit();
        } catch (Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log('Kontaktformular DB-Fehler: ' . $exception->getMessage());
            $contactErrors[] = 'Die Anfrage konnte momentan nicht gespeichert werden.';
        }

        if ($contactErrors === []) {
            $responseSent = false;
            $notificationSent = false;
            $mailErrors = [];

            $customerBody =
                "Guten Tag {$contactData['name']},\n\n"
                . "vielen Dank für Ihre Anfrage bei easyIT Nachhilfe Leipzig.\n"
                . "Ihre Nachricht wurde unter der Vorgangsnummer #{$requestId} gespeichert.\n"
                . "Ich melde mich nach der Prüfung Ihrer Angaben persönlich zurück.\n\n"
                . "Ihre Angaben:\n"
                . "Fach: " . ($contactData['subject'] ?: 'nicht angegeben') . "\n"
                . "Klassenstufe / Ausbildung / Studium: " . ($contactData['level'] ?: 'nicht angegeben') . "\n\n"
                . "Freundliche Grüße\n"
                . "Olaf Thiele\n"
                . "easyIT Nachhilfe Leipzig";

            $adminBody =
                "Neue Kontaktanfrage #{$requestId}\n\n"
                . "Name: {$contactData['name']}\n"
                . "E-Mail: {$contactData['email']}\n"
                . "Telefon: " . ($contactData['phone'] ?: 'nicht angegeben') . "\n"
                . "Fach: " . ($contactData['subject'] ?: 'nicht angegeben') . "\n"
                . "Klassenstufe / Ausbildung / Studium: " . ($contactData['level'] ?: 'nicht angegeben') . "\n\n"
                . "Nachricht:\n{$contactData['message']}\n";

            try {
                $mailer->sendText(
                    $contactData['email'],
                    (string) $mailConfig['reply_subject'],
                    $customerBody
                );
                $responseSent = true;
            } catch (Throwable $exception) {
                $mailErrors[] = 'Antwortmail: ' . $exception->getMessage();
            }

            try {
                $mailer->sendText(
                    (string) $mailConfig['admin_email'],
                    "Neue Kontaktanfrage #{$requestId}",
                    $adminBody,
                    $contactData['email'],
                    $contactData['name']
                );
                $notificationSent = true;
            } catch (Throwable $exception) {
                $mailErrors[] = 'Benachrichtigung: ' . $exception->getMessage();
            }

            $contacts->markMailState(
                $requestId,
                $responseSent,
                $notificationSent,
                $mailErrors !== [] ? implode("\n", $mailErrors) : null
            );

            if ($mailErrors !== []) {
                error_log('Kontaktformular Mailfehler #' . $requestId . ': ' . implode(' | ', $mailErrors));
            }

            $_SESSION['contact_last_submission'] = time();
            $_SESSION['contact_form_started_at'] = time();
            $_SESSION['contact_csrf_token'] = bin2hex(random_bytes(32));

            $contactSuccess = true;
            $contactData = array_fill_keys(array_keys($contactData), '');
        }
    }
}
