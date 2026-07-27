<?php
declare(strict_types=1);

final class Message
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    /** @return array{success:bool,message:string,id?:int} */
    public function create(
        string $subject,
        string $body,
        ?int $senderAdminId,
        ?int $recipientAdminId = null,
        ?string $recipientEmail = null,
        string $channel = 'internal'
    ): array {
        $subject = trim($subject);
        $body = trim($body);
        $channel = in_array($channel, ['internal', 'email', 'both'], true) ? $channel : 'internal';

        if ($subject === '' || $body === '') {
            return ['success' => false, 'message' => 'Betreff und Inhalt dürfen nicht leer sein.'];
        }

        $stmt = $this->pdo->prepare(
            'INSERT INTO communication_messages
             (sender_admin_id, recipient_admin_id, recipient_email, channel, subject, body, status)
             VALUES (:sender_admin_id, :recipient_admin_id, :recipient_email, :channel, :subject, :body, :status)'
        );
        $stmt->execute([
            'sender_admin_id' => $senderAdminId,
            'recipient_admin_id' => $recipientAdminId,
            'recipient_email' => $recipientEmail !== '' ? $recipientEmail : null,
            'channel' => $channel,
            'subject' => $subject,
            'body' => $body,
            'status' => 'created',
        ]);

        return [
            'success' => true,
            'message' => 'Die Nachricht wurde gespeichert.',
            'id' => (int)$this->pdo->lastInsertId(),
        ];
    }

    public function markStatus(int $messageId, string $status, ?string $error = null): void
    {
        $allowed = ['created', 'sent', 'failed'];
        if (!in_array($status, $allowed, true)) {
            throw new InvalidArgumentException('Unzulässiger Nachrichtenstatus.');
        }

        $stmt = $this->pdo->prepare(
            'UPDATE communication_messages
             SET status = :status, error_message = :error_message,
                 sent_at = CASE WHEN :status_sent = \'sent\' THEN CURRENT_TIMESTAMP ELSE sent_at END
             WHERE id = :id'
        );
        $stmt->execute([
            'status' => $status,
            'error_message' => $error,
            'status_sent' => $status,
            'id' => $messageId,
        ]);
    }

    /** @return array<int,array<string,mixed>> */
    public function latest(int $limit = 50): array
    {
        $limit = max(1, min(200, $limit));
        return $this->pdo->query(
            'SELECT id, sender_admin_id, recipient_admin_id, recipient_email, channel,
                    subject, body, status, error_message, created_at, sent_at
             FROM communication_messages
             ORDER BY id DESC
             LIMIT ' . $limit
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}
