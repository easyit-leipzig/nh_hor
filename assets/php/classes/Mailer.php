<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

final class Mailer
{
    public function __construct(
        private readonly array $config
    ) {
    }

    public function sendText(
        string $to,
        string $subject,
        string $body,
        ?string $replyTo = null,
        ?string $replyToName = null
    ): void {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = (string) $this->config['host'];
        $mail->Port = (int) $this->config['port'];
        $mail->SMTPAuth = (bool) $this->config['auth'];
        $mail->CharSet = 'UTF-8';
        $mail->Timeout = 10;

        if ($mail->SMTPAuth) {
            $mail->Username = (string) $this->config['username'];
            $mail->Password = (string) $this->config['password'];
        }

        $encryption = strtolower((string) ($this->config['encryption'] ?? ''));
        if ($encryption === 'tls') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        } elseif ($encryption === 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;
        }

        $mail->setFrom(
            (string) $this->config['from_email'],
            (string) $this->config['from_name']
        );
        $mail->addAddress($to);

        if ($replyTo !== null && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
            $mail->addReplyTo($replyTo, $replyToName ?? '');
        }

        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();
    }
}
