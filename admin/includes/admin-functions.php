<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

function admin_e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function admin_slugify(string $value): string
{
    $value = mb_strtolower(trim($value));
    $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value) ?: $value;
    $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
    return trim($value, '-');
}

function admin_log(string $action, string $entityType, ?int $entityId = null, array $details = []): void
{
    if (!db_available()) {
        return;
    }

    $user = admin_user();
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    try {
        $stmt = db()->prepare(
            'INSERT INTO audit_log (user_id, action, entity_type, entity_id, details, ip_hash)
             VALUES (:user_id, :action, :entity_type, :entity_id, :details, :ip_hash)'
        );
        $stmt->execute([
            'user_id' => $user['id'] ?? null,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'details' => $details ? json_encode($details, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null,
            'ip_hash' => hash('sha256', $ip),
        ]);
    } catch (Throwable $e) {
        error_log('Admin-Audit-Protokollierung fehlgeschlagen: ' . $e->getMessage());
    }
}
function admin_verify_csrf_or_abort(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
        http_response_code(403);
        exit('Die Sitzung ist abgelaufen oder die Anfrage ist ungültig. Bitte laden Sie die Seite neu.');
    }
}

