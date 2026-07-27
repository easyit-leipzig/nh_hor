<?php
namespace PHPMailer\PHPMailer;

/**
 * Phase-0-Transportadapter mit PHPMailer-kompatibler Schnittstelle.
 * InformUser.php bleibt unverändert. Der Versand erfolgt lokal über
 * den zentral konfigurierten Mailpit-Sendmail-Aufruf.
 */
class PHPMailer
{
    public $CharSet = 'UTF-8';
    public $Subject = '';
    public $Body = '';
    public $AltBody = '';
    public $ErrorInfo = '';
    public $Mailer = 'mail';
    public $Host = 'localhost';
    public $Port = 25;
    public $SMTPAuth = false;
    public $Username = '';
    public $Password = '';
    public $SMTPSecure = '';
    public $Sendmail = '/usr/sbin/sendmail -bs';

    private array $from = [];
    private array $addresses = [];
    private array $bcc = [];
    private array $images = [];
    private array $attachments = [];
    private bool $isHtml = false;
    private bool $exceptions = false;

    public function __construct($exceptions = null)
    {
        $this->exceptions = (bool)$exceptions;
    }

    public function isMail()
    {
        $this->Mailer = 'mail';
        return true;
    }

    public function isSendmail()
    {
        $this->Mailer = 'sendmail';
        return true;
    }

    public function isSMTP()
    {
        $this->Mailer = 'smtp';
        return true;
    }

    public function setFrom($email, $name = '')
    {
        $this->from = [(string)$email, (string)$name];
        return true;
    }

    public function addAddress($email, $name = '')
    {
        $this->addresses[] = [(string)$email, (string)$name];
        return true;
    }

    public function addBCC($email, $name = '')
    {
        $this->bcc[] = [(string)$email, (string)$name];
        return true;
    }

    public function isHtml($value = true)
    {
        $this->isHtml = (bool)$value;
        return true;
    }

    public function AddEmbeddedImage($path, $cid, $name = '')
    {
        $this->images[] = [(string)$path, (string)$cid, (string)$name];
        return true;
    }

    public function addAttachment($path, $name = '')
    {
        $path = (string)$path;
        if (!is_file($path) || !is_readable($path)) {
            $this->ErrorInfo = 'Anhang nicht lesbar: ' . $path;
            if ($this->exceptions) {
                throw new Exception($this->ErrorInfo);
            }
            return false;
        }
        $this->attachments[] = [$path, (string)($name !== '' ? $name : basename($path))];
        return true;
    }

    public function send()
    {
        try {
            if ($this->addresses === []) {
                throw new \RuntimeException('Es wurde kein Empfänger angegeben.');
            }

            if ($this->Mailer === 'smtp') {
                throw new \RuntimeException(
                    'Der mitgelieferte PHPMailer-Adapter unterstützt in diesem Projekt keinen direkten SMTP-Versand. ' .
                    'Verwenden Sie in config/communication.local.php den Transport mail oder sendmail.'
                );
            }

            if ($this->Mailer === 'sendmail') {
                $command = trim((string)$this->Sendmail);
                if ($command === '') {
                    throw new \RuntimeException('Der Sendmail-Aufruf ist nicht konfiguriert.');
                }
                $this->sendWithCommand($command);
                return true;
            }

            $this->sendWithPhpMail();
            return true;
        } catch (\Throwable $e) {
            $this->ErrorInfo = $e->getMessage();
            if ($this->exceptions) {
                throw new Exception($this->ErrorInfo, 0, $e);
            }
            return false;
        }
    }

    private function sendWithCommand(string $command): void
    {
        $message = $this->buildMessage();
        $descriptorSpec = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $process = proc_open($command, $descriptorSpec, $pipes);
        if (!is_resource($process)) {
            throw new \RuntimeException('Sendmail konnte nicht gestartet werden.');
        }
        fwrite($pipes[0], $message);
        fclose($pipes[0]);
        $stdout = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);
        if ($exitCode !== 0) {
            throw new \RuntimeException('Sendmail meldete Exit-Code ' . $exitCode . ': ' . trim((string)$stderr));
        }
    }

    private function sendWithPhpMail(): void
    {
        $to = implode(', ', array_map(fn(array $a): string => $this->formatAddress($a[0], $a[1]), $this->addresses));
        [$headers, $body] = $this->buildMailParts();
        $ok = mail($to, $this->encodeHeader((string)$this->Subject), $body, implode("\r\n", $headers));
        if (!$ok) {
            throw new \RuntimeException('PHP mail() hat die Nachricht nicht an den konfigurierten Mailserver übergeben.');
        }
    }

    private function buildMailParts(): array
    {
        $fromEmail = $this->from[0] ?? 'noreply@easyit-leipzig.local';
        $fromName = $this->from[1] ?? 'easyIT Leipzig';
        $headers = [
            'Date: ' . date(DATE_RFC2822),
            'From: ' . $this->formatAddress($fromEmail, $fromName),
            'MIME-Version: 1.0',
        ];
        if ($this->bcc !== []) {
            $headers[] = 'Bcc: ' . implode(', ', array_map(fn(array $a): string => $this->formatAddress($a[0], $a[1]), $this->bcc));
        }
        if ($this->attachments === []) {
            $headers[] = 'Content-Type: ' . ($this->isHtml ? 'text/html' : 'text/plain') . '; charset=' . $this->CharSet;
            $headers[] = 'Content-Transfer-Encoding: 8bit';
            return [$headers, (string)$this->Body];
        }
        $boundary = '=_easyit_' . bin2hex(random_bytes(12));
        $headers[] = 'Content-Type: multipart/mixed; boundary="' . $boundary . '"';
        $body = '--' . $boundary . "\r\n"
            . 'Content-Type: ' . ($this->isHtml ? 'text/html' : 'text/plain') . '; charset=' . $this->CharSet . "\r\n"
            . "Content-Transfer-Encoding: 8bit\r\n\r\n" . (string)$this->Body . "\r\n";
        foreach ($this->attachments as [$path, $name]) {
            $mime = function_exists('mime_content_type') ? (mime_content_type($path) ?: 'application/octet-stream') : 'application/octet-stream';
            $safeName = str_replace(["\r", "\n", '"'], ['', '', "'"], $name);
            $body .= '--' . $boundary . "\r\n"
                . 'Content-Type: ' . $mime . '; name="' . $safeName . '"' . "\r\n"
                . "Content-Transfer-Encoding: base64\r\n"
                . 'Content-Disposition: attachment; filename="' . $safeName . '"' . "\r\n\r\n"
                . chunk_split(base64_encode((string)file_get_contents($path))) . "\r\n";
        }
        $body .= '--' . $boundary . "--\r\n";
        return [$headers, $body];
    }

    private function buildMessage(): string
    {
        $fromEmail = $this->from[0] ?? 'noreply@easyit-leipzig.local';
        $fromName = $this->from[1] ?? 'easyIT Leipzig Testumgebung';
        $to = array_map(fn(array $a): string => $this->formatAddress($a[0], $a[1]), $this->addresses);
        $headers = [
            'Date: ' . date(DATE_RFC2822),
            'From: ' . $this->formatAddress($fromEmail, $fromName),
            'To: ' . implode(', ', $to),
            'Subject: ' . $this->encodeHeader((string)$this->Subject),
            'MIME-Version: 1.0',
        ];
        if ($this->bcc !== []) {
            $headers[] = 'Bcc: ' . implode(', ', array_map(fn(array $a): string => $this->formatAddress($a[0], $a[1]), $this->bcc));
        }

        if ($this->attachments === []) {
            $headers[] = 'Content-Type: ' . ($this->isHtml ? 'text/html' : 'text/plain') . '; charset=' . $this->CharSet;
            $headers[] = 'Content-Transfer-Encoding: 8bit';
            return implode("\r\n", $headers) . "\r\n\r\n" . (string)$this->Body . "\r\n";
        }

        $boundary = '=_easyit_' . bin2hex(random_bytes(12));
        $headers[] = 'Content-Type: multipart/mixed; boundary="' . $boundary . '"';
        $parts = [];
        $parts[] = '--' . $boundary . "\r\n"
            . 'Content-Type: ' . ($this->isHtml ? 'text/html' : 'text/plain') . '; charset=' . $this->CharSet . "\r\n"
            . "Content-Transfer-Encoding: 8bit\r\n\r\n"
            . (string)$this->Body . "\r\n";

        foreach ($this->attachments as [$path, $name]) {
            $mime = function_exists('mime_content_type') ? (mime_content_type($path) ?: 'application/octet-stream') : 'application/octet-stream';
            $safeName = str_replace(["\r", "\n", '"'], ['', '', "'"], $name);
            $encoded = chunk_split(base64_encode((string)file_get_contents($path)));
            $parts[] = '--' . $boundary . "\r\n"
                . 'Content-Type: ' . $mime . '; name="' . $safeName . '"' . "\r\n"
                . "Content-Transfer-Encoding: base64\r\n"
                . 'Content-Disposition: attachment; filename="' . $safeName . '"' . "\r\n\r\n"
                . $encoded . "\r\n";
        }
        $parts[] = '--' . $boundary . "--\r\n";
        return implode("\r\n", $headers) . "\r\n\r\n" . implode('', $parts);
    }

    private function formatAddress(string $email, string $name): string
    {
        return $name !== '' ? $this->encodeHeader($name) . ' <' . $email . '>' : $email;
    }

    private function encodeHeader(string $value): string
    {
        return '=?UTF-8?B?' . base64_encode($value) . '?=';
    }

    private function writeLog(array $config, int $exitCode, string $stdout, string $stderr): void
    {
        $log = (string)($config['log_file'] ?? '');
        if ($log === '') {
            return;
        }
        if (!is_dir(dirname($log))) {
            mkdir(dirname($log), 0777, true);
        }
        $record = [
            'timestamp' => date('c'),
            'transport' => 'PHPMailer-compatible/sendmail',
            'command' => $config['sendmail_command'] ?? '',
            'from' => $this->from,
            'to' => $this->addresses,
            'bcc' => $this->bcc,
            'subject' => $this->Subject,
            'attachments' => array_map(fn(array $a): array => ['path' => $a[0], 'name' => $a[1], 'size' => is_file($a[0]) ? filesize($a[0]) : null], $this->attachments),
            'exit_code' => $exitCode,
            'stdout' => trim($stdout),
            'stderr' => trim($stderr),
        ];
        file_put_contents($log, json_encode($record, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);
    }
}
