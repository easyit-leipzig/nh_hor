<?php
declare(strict_types=1);

require __DIR__ . '/includes/admin-functions.php';
admin_require_login();
if (!admin_has_role('admin')) {
    http_response_code(403);
    exit('Keine Berechtigung.');
}

require_once dirname(__DIR__) . '/classes/Communication/InformUser.php';
require_once dirname(__DIR__) . '/classes/Communication/Message.php';

$adminTitle = 'Kommunikation testen';
$result = null;
$errors = [];

if (!db_available()) {
    $errors[] = 'Die Datenbankverbindung ist nicht verfügbar.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf_or_abort();

    $recipientEmail = trim((string)($_POST['recipient_email'] ?? ''));
    $recipientName = trim((string)($_POST['recipient_name'] ?? ''));
    $subject = trim((string)($_POST['subject'] ?? ''));
    $body = trim((string)($_POST['body'] ?? ''));
    $mode = (string)($_POST['mode'] ?? 'both');

    if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Bitte eine gültige Empfängeradresse eintragen.';
    }
    if ($subject === '') {
        $errors[] = 'Bitte einen Betreff eintragen.';
    }
    if ($body === '') {
        $errors[] = 'Bitte einen Nachrichtentext eintragen.';
    }
    if (!in_array($mode, ['email', 'internal', 'both'], true)) {
        $errors[] = 'Der Versandmodus ist ungültig.';
    }

    $uploadDir = dirname(__DIR__) . '/storage/communication';
    $uploadedPaths = [];

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
        $errors[] = 'Das temporäre Verzeichnis für Anhänge konnte nicht angelegt werden.';
    }
    if (is_dir($uploadDir) && !is_writable($uploadDir)) {
        $errors[] = 'Das temporäre Verzeichnis für Anhänge ist nicht beschreibbar.';
    }
    if (isset($_FILES['attachments']) && is_array($_FILES['attachments']['name'] ?? null)) {
        $names = $_FILES['attachments']['name'];
        $tmpNames = $_FILES['attachments']['tmp_name'];
        $errorsUpload = $_FILES['attachments']['error'];
        $sizes = $_FILES['attachments']['size'];

        if (count($names) > 20) {
            $errors[] = 'Es sind höchstens 20 Anhänge zulässig.';
        } else {
            foreach ($names as $index => $originalName) {
                if ((int)$errorsUpload[$index] === UPLOAD_ERR_NO_FILE) {
                    continue;
                }
                if ((int)$errorsUpload[$index] !== UPLOAD_ERR_OK) {
                    $errors[] = 'Ein Anhang konnte nicht hochgeladen werden.';
                    continue;
                }
                if ((int)$sizes[$index] > 15_000_000) {
                    $errors[] = 'Der Anhang „' . admin_e((string)$originalName) . '“ ist größer als 15 MB.';
                    continue;
                }
                $safeName = preg_replace('/[^a-zA-Z0-9._-]+/', '_', basename((string)$originalName)) ?: 'attachment.bin';
                $target = $uploadDir . '/' . bin2hex(random_bytes(12)) . '-' . $safeName;
                if (!move_uploaded_file((string)$tmpNames[$index], $target)) {
                    $errors[] = 'Ein Anhang konnte nicht sicher gespeichert werden.';
                    continue;
                }
                $uploadedPaths[] = ['path' => $target, 'name' => (string)$originalName];
            }
        }
    }

    if ($errors === [] && db_available()) {
        try {
            $user = admin_user();
            $senderAdminId = isset($user['id']) ? (int)$user['id'] : null;
            $config = require dirname(__DIR__) . '/config/communication.php';

            if ($mode === 'internal') {
                $message = new Message(db());
                $result = $message->create($subject, nl2br(admin_e($body)), $senderAdminId, null, $recipientEmail, 'internal');
            } else {
                $service = new InformUser(db(), $config);
                foreach ($uploadedPaths as $attachment) {
                    $service->addAttachment($attachment['path'], $attachment['name']);
                }
                $result = $service->send(
                    $recipientEmail,
                    $recipientName,
                    $subject,
                    nl2br(admin_e($body)),
                    $senderAdminId,
                    $mode === 'both'
                );
            }

            admin_log('communication_test', 'communication', $result['message_id'] ?? $result['id'] ?? null, [
                'mode' => $mode,
                'recipient' => $recipientEmail,
                'success' => (bool)($result['success'] ?? false),
            ]);
        } catch (Throwable $exception) {
            $result = ['success' => false, 'message' => 'Technischer Fehler: ' . $exception->getMessage()];
            foreach ($uploadedPaths as $attachment) {
                @unlink($attachment['path']);
            }
        }
    } else {
        foreach ($uploadedPaths as $attachment) {
            @unlink($attachment['path']);
        }
    }
}

require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions">
    <h1 style="margin-right:auto">InformUser und Message testen</h1>
    <a class="admin-btn" href="<?= admin_e(app_path('/admin/communication-log.php')) ?>">Versandprotokoll</a>
</div>
<p>Geschützter Funktionstest für E-Mail-Versand und interne Nachrichten. Anhänge: maximal 20 Dateien, jeweils maximal 15 MB.</p>

<?php foreach ($errors as $error): ?>
    <div class="admin-alert"><?= admin_e(strip_tags($error)) ?></div>
<?php endforeach; ?>

<?php if (is_array($result)): ?>
    <div class="admin-alert">
        <strong><?= !empty($result['success']) ? 'Erfolgreich' : 'Fehlgeschlagen' ?>:</strong>
        <?= admin_e((string)($result['message'] ?? 'Keine Rückmeldung.')) ?>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="admin-card" style="max-width:900px">
    <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">

    <label for="mode"><strong>Modus</strong></label>
    <select id="mode" name="mode" required>
        <option value="both">E-Mail senden und intern protokollieren</option>
        <option value="email">Nur E-Mail senden</option>
        <option value="internal">Nur interne Nachricht speichern</option>
    </select>

    <label for="recipient_name"><strong>Empfängername</strong></label>
    <input id="recipient_name" name="recipient_name" type="text" maxlength="255" value="<?= admin_e((string)($_POST['recipient_name'] ?? '')) ?>">

    <label for="recipient_email"><strong>Empfänger-E-Mail</strong></label>
    <input id="recipient_email" name="recipient_email" type="email" maxlength="320" required value="<?= admin_e((string)($_POST['recipient_email'] ?? '')) ?>">

    <label for="subject"><strong>Betreff</strong></label>
    <input id="subject" name="subject" type="text" maxlength="255" required value="<?= admin_e((string)($_POST['subject'] ?? 'Testnachricht InformUser')) ?>">

    <label for="body"><strong>Nachricht</strong></label>
    <textarea id="body" name="body" rows="10" required><?= admin_e((string)($_POST['body'] ?? 'Dies ist eine Testnachricht aus dem Admin-Bereich von nh_hor.')) ?></textarea>

    <label for="attachments"><strong>Anhänge</strong></label>
    <input id="attachments" name="attachments[]" type="file" multiple>

    <div class="admin-actions" style="margin-top:1rem">
        <button class="admin-btn" type="submit">Test ausführen</button>
    </div>
</form>

<section class="admin-card" style="margin-top:1rem">
    <h2>Konfiguration</h2>
    <p>Kopiere <code>config/communication.local.example.php</code> nach <code>config/communication.local.php</code> und trage dort den lokalen Mailpit- oder produktiven Sendmail-/SMTP-Transport ein.</p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
