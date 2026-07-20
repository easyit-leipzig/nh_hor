<?php
declare(strict_types=1);

final class SmtpException extends RuntimeException {}

final class SmtpMailer
{
    public function __construct(private readonly array $config) {}

    public function send(string $to, string $subject, string $body, string $replyTo): void
    {
        $host = (string)$this->config['smtp_host'];
        $port = (int)$this->config['smtp_port'];
        $timeout = (int)$this->config['smtp_timeout'];
        $encryption = strtolower((string)$this->config['smtp_encryption']);
        $remote = ($encryption === 'ssl' ? 'ssl://' : '') . $host . ':' . $port;
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
                'allow_self_signed' => false,
                'SNI_enabled' => true,
                'peer_name' => $host,
            ],
        ]);
        $errno = 0; $errstr = '';
        $socket = @stream_socket_client($remote, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $context);
        if (!is_resource($socket)) {
            throw new SmtpException('SMTP-Verbindung fehlgeschlagen (' . $errno . ').');
        }
        stream_set_timeout($socket, $timeout);

        try {
            $this->expect($socket, [220]);
            $hostname = gethostname() ?: 'localhost';
            $this->command($socket, 'EHLO ' . $hostname, [250]);

            if ($encryption === 'tls') {
                $this->command($socket, 'STARTTLS', [220]);
                if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
                    throw new SmtpException('SMTP-TLS konnte nicht aktiviert werden.');
                }
                $this->command($socket, 'EHLO ' . $hostname, [250]);
            }

            $username = (string)$this->config['smtp_username'];
            $password = (string)$this->config['smtp_password'];
            if ($username !== '') {
                $this->command($socket, 'AUTH LOGIN', [334]);
                $this->command($socket, base64_encode($username), [334], false);
                $this->command($socket, base64_encode($password), [235], false);
            }

            $from = (string)$this->config['sender_email'];
            $this->command($socket, 'MAIL FROM:<' . $from . '>', [250]);
            $this->command($socket, 'RCPT TO:<' . $to . '>', [250, 251]);
            $this->command($socket, 'DATA', [354]);

            $headers = [
                'Date: ' . date(DATE_RFC2822),
                'From: ' . $this->encodeHeader((string)$this->config['sender_name']) . ' <' . $from . '>',
                'To: <' . $to . '>',
                'Reply-To: <' . $replyTo . '>',
                'Subject: ' . $this->encodeHeader($subject),
                'Message-ID: <' . bin2hex(random_bytes(12)) . '@' . preg_replace('/[^a-z0-9.-]/i', '', $host) . '>',
                'MIME-Version: 1.0',
                'Content-Type: text/plain; charset=UTF-8',
                'Content-Transfer-Encoding: 8bit',
            ];
            $payload = implode("\r\n", $headers) . "\r\n\r\n" . $this->dotStuff($body) . "\r\n.";
            fwrite($socket, $payload . "\r\n");
            $this->expect($socket, [250]);
            $this->command($socket, 'QUIT', [221]);
        } finally {
            fclose($socket);
        }
    }

    private function command($socket, string $command, array $expected, bool $loggable = true): void
    {
        if (fwrite($socket, $command . "\r\n") === false) {
            throw new SmtpException('SMTP-Schreibfehler.');
        }
        $this->expect($socket, $expected);
    }

    private function expect($socket, array $expected): string
    {
        $response = '';
        do {
            $line = fgets($socket, 515);
            if ($line === false) {
                $meta = stream_get_meta_data($socket);
                throw new SmtpException(!empty($meta['timed_out']) ? 'SMTP-Zeitüberschreitung.' : 'SMTP-Antwort fehlt.');
            }
            $response .= $line;
        } while (isset($line[3]) && $line[3] === '-');
        $code = (int)substr($line, 0, 3);
        if (!in_array($code, $expected, true)) {
            throw new SmtpException('SMTP-Server antwortete mit Status ' . $code . '.');
        }
        return $response;
    }

    private function encodeHeader(string $value): string
    {
        return '=?UTF-8?B?' . base64_encode($value) . '?=';
    }

    private function dotStuff(string $body): string
    {
        $body = preg_replace("~\r?\n~", "\r\n", $body) ?? $body;
        return preg_replace('/^\./m', '..', $body) ?? $body;
    }
}
