<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/PHPMailer/Exception.php';
require_once dirname(__DIR__) . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/Message.php';

use PHPMailer\PHPMailer\PHPMailer;

final class InformUser
{
    private const MAX_ATTACHMENTS = 20;
    private const MAX_ATTACHMENT_BYTES = 15_000_000;

    /** @var array<int,array{path:string,name:string}> */
    private array $attachments = [];

    public function __construct(
        private readonly PDO $pdo,
        private readonly array $config
    ) {
    }

    public function addAttachment(string $path, string $name = ''): self
    {
        if (count($this->attachments) >= self::MAX_ATTACHMENTS) {
            throw new RuntimeException('Es sind höchstens 20 Anhänge zulässig.');
        }
        if (!is_file($path) || !is_readable($path)) {
            throw new RuntimeException('Der Anhang ist nicht lesbar.');
        }
        if ((int)filesize($path) > self::MAX_ATTACHMENT_BYTES) {
            throw new RuntimeException('Ein einzelner Anhang darf höchstens 15 MB groß sein.');
        }

        $this->attachments[] = [
            'path' => $path,
            'name' => $name !== '' ? $name : basename($path),
        ];
        return $this;
    }

    public function clearAttachments(): self
    {
        $this->attachments = [];
        return $this;
    }

    /** @return array{success:bool,message:string,message_id?:int} */
    public function send(
        string $recipientEmail,
        string $recipientName,
        string $subject,
        string $htmlBody,
        ?int $senderAdminId = null,
        bool $storeInternal = true
    ): array {
        $recipientEmail = trim($recipientEmail);
        $recipientName = trim($recipientName);
        $subject = trim($subject);
        $htmlBody = trim($htmlBody);

        if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Die Empfängeradresse ist ungültig.'];
        }
        if ($subject === '' || $htmlBody === '') {
            return ['success' => false, 'message' => 'Betreff und Nachricht dürfen nicht leer sein.'];
        }

        $messageId = null;
        $messages = new Message($this->pdo);
        if ($storeInternal) {
            $stored = $messages->create($subject, $htmlBody, $senderAdminId, null, $recipientEmail, 'both');
            if (!$stored['success']) {
                return $stored;
            }
            $messageId = (int)$stored['id'];
        }

        try {
            $mail = $this->buildMailer();
            $mail->addAddress($recipientEmail, $recipientName);
            $mail->Subject = $subject;
            $mail->isHTML(true);
            $mail->Body = $this->wrapHtml($subject, $htmlBody);
            $mail->AltBody = trim(strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $htmlBody)));

            foreach ($this->attachments as $attachment) {
                $mail->addAttachment($attachment['path'], $attachment['name']);
            }

            $mail->send();
            if ($messageId !== null) {
                $messages->markStatus($messageId, 'sent');
            }
            $this->log($messageId, $recipientEmail, $subject, true, null);

            return [
                'success' => true,
                'message' => 'Die Nachricht wurde an den Mailserver übergeben.',
                'message_id' => $messageId,
            ];
        } catch (Throwable $exception) {
            if ($messageId !== null) {
                $messages->markStatus($messageId, 'failed', $exception->getMessage());
            }
            $this->log($messageId, $recipientEmail, $subject, false, $exception->getMessage());
            return [
                'success' => false,
                'message' => 'Der Versand ist fehlgeschlagen: ' . $exception->getMessage(),
                'message_id' => $messageId,
            ];
        } finally {
            $this->cleanupAttachments();
        }
    }

    private function buildMailer(): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $transport = (string)($this->config['transport'] ?? 'mail');

        if ($transport === 'smtp') {
            $smtp = (array)($this->config['smtp'] ?? []);
            $mail->isSMTP();
            $mail->Host = (string)($smtp['host'] ?? 'localhost');
            $mail->Port = (int)($smtp['port'] ?? 1025);
            $mail->SMTPAuth = (bool)($smtp['auth'] ?? false);
            $mail->Username = (string)($smtp['username'] ?? '');
            $mail->Password = (string)($smtp['password'] ?? '');
            $secure = (string)($smtp['secure'] ?? '');
            if ($secure !== '') {
                $mail->SMTPSecure = $secure;
            }
        } elseif ($transport === 'sendmail') {
            $mail->isSendmail();
            if (!empty($this->config['sendmail_path'])) {
                $mail->Sendmail = (string)$this->config['sendmail_path'];
            }
        } else {
            $mail->isMail();
        }

        $fromEmail = (string)($this->config['from_email'] ?? '');
        $fromName = (string)($this->config['from_name'] ?? 'easyIT Nachhilfe Leipzig');
        if (!filter_var($fromEmail, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('In config/communication.local.php fehlt eine gültige Absenderadresse.');
        }
        $mail->setFrom($fromEmail, $fromName);
        return $mail;
    }

    private function wrapHtml(string $title, string $content): string
    {
        $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        return '<!doctype html><html lang="de"><head><meta charset="utf-8"><title>' . $safeTitle . '</title></head>'
            . '<body style="font-family:Arial,sans-serif;line-height:1.55;color:#1f2937">'
            . '<div style="max-width:680px;margin:auto;padding:24px">'
            . '<h1 style="font-size:24px">' . $safeTitle . '</h1>'
            . $content
            . '<hr><p style="font-size:12px;color:#6b7280">Diese Nachricht wurde über easyIT Nachhilfe Leipzig versendet.</p>'
            . '</div></body></html>';
    }

    private function log(?int $messageId, string $recipient, string $subject, bool $success, ?string $error): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO communication_delivery_log
             (message_id, recipient_email, subject, transport, success, error_message)
             VALUES (:message_id, :recipient_email, :subject, :transport, :success, :error_message)'
        );
        $stmt->execute([
            'message_id' => $messageId,
            'recipient_email' => $recipient,
            'subject' => $subject,
            'transport' => (string)($this->config['transport'] ?? 'mail'),
            'success' => $success ? 1 : 0,
            'error_message' => $error,
        ]);
    }

    private function cleanupAttachments(): void
    {
        foreach ($this->attachments as $attachment) {
            $real = realpath($attachment['path']);
            $runtime = realpath(dirname(__DIR__, 2) . '/storage/communication');
            if ($real !== false && $runtime !== false && str_starts_with($real, $runtime . DIRECTORY_SEPARATOR)) {
                @unlink($real);
            }
        }
        $this->attachments = [];
    }
}
