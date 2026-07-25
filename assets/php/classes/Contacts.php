<?php
declare(strict_types=1);

final class Contacts
{
    public function __construct(
        private readonly PDO $db
    ) {
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO contact_requests
            (
                name, email, phone, subject, level, message,
                source_page, ip_hash, user_agent
            )
            VALUES
            (
                :name, :email, :phone, :subject, :level, :message,
                :source_page, :ip_hash, :user_agent
            )'
        );

        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] !== '' ? $data['phone'] : null,
            'subject' => $data['subject'] !== '' ? $data['subject'] : null,
            'level' => $data['level'] !== '' ? $data['level'] : null,
            'message' => $data['message'],
            'source_page' => $data['source_page'] ?? '/kontakt.php',
            'ip_hash' => $data['ip_hash'] ?? null,
            'user_agent' => $data['user_agent'] ?? null,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function markMailState(
        int $requestId,
        bool $responseSent,
        bool $notificationSent,
        ?string $error = null
    ): void {
        $stmt = $this->db->prepare(
            'UPDATE contact_requests
             SET response_mail_sent = :response_sent,
                 notification_mail_sent = :notification_sent,
                 mail_error = :mail_error
             WHERE request_id = :request_id'
        );

        $stmt->execute([
            'response_sent' => $responseSent ? 1 : 0,
            'notification_sent' => $notificationSent ? 1 : 0,
            'mail_error' => $error,
            'request_id' => $requestId,
        ]);
    }
}
