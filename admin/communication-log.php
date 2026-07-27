<?php
declare(strict_types=1);

require __DIR__ . '/includes/admin-functions.php';
admin_require_login();
if (!admin_has_role('admin')) {
    http_response_code(403);
    exit('Keine Berechtigung.');
}

$adminTitle = 'Kommunikationsprotokoll';
$messages = [];
$deliveries = [];
$error = null;

if (db_available()) {
    try {
        $messages = db()->query(
            'SELECT id, recipient_email, channel, subject, status, error_message, created_at, sent_at
             FROM communication_messages ORDER BY id DESC LIMIT 100'
        )->fetchAll(PDO::FETCH_ASSOC);
        $deliveries = db()->query(
            'SELECT id, message_id, recipient_email, subject, transport, success, error_message, created_at
             FROM communication_delivery_log ORDER BY id DESC LIMIT 100'
        )->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $exception) {
        $error = 'Die Kommunikationstabellen fehlen oder konnten nicht gelesen werden. Bitte zuerst die Migration importieren.';
    }
}

require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions">
    <h1 style="margin-right:auto">Kommunikationsprotokoll</h1>
    <a class="admin-btn" href="<?= admin_e(app_path('/admin/communication-test.php')) ?>">Neuer Test</a>
</div>
<?php if ($error !== null): ?><div class="admin-alert"><?= admin_e($error) ?></div><?php endif; ?>

<section class="admin-card">
<h2>Nachrichten</h2>
<div style="overflow:auto"><table style="width:100%;border-collapse:collapse">
<thead><tr><th>ID</th><th>Zeit</th><th>Empfänger</th><th>Kanal</th><th>Betreff</th><th>Status</th><th>Fehler</th></tr></thead>
<tbody>
<?php foreach ($messages as $row): ?>
<tr>
<td><?= (int)$row['id'] ?></td><td><?= admin_e((string)$row['created_at']) ?></td><td><?= admin_e((string)$row['recipient_email']) ?></td>
<td><?= admin_e((string)$row['channel']) ?></td><td><?= admin_e((string)$row['subject']) ?></td><td><?= admin_e((string)$row['status']) ?></td><td><?= admin_e((string)$row['error_message']) ?></td>
</tr>
<?php endforeach; ?>
<?php if ($messages === []): ?><tr><td colspan="7">Noch keine Nachrichten vorhanden.</td></tr><?php endif; ?>
</tbody></table></div>
</section>

<section class="admin-card" style="margin-top:1rem">
<h2>Versandversuche</h2>
<div style="overflow:auto"><table style="width:100%;border-collapse:collapse">
<thead><tr><th>ID</th><th>Zeit</th><th>Empfänger</th><th>Transport</th><th>Ergebnis</th><th>Fehler</th></tr></thead>
<tbody>
<?php foreach ($deliveries as $row): ?>
<tr>
<td><?= (int)$row['id'] ?></td><td><?= admin_e((string)$row['created_at']) ?></td><td><?= admin_e((string)$row['recipient_email']) ?></td>
<td><?= admin_e((string)$row['transport']) ?></td><td><?= (int)$row['success'] === 1 ? 'erfolgreich' : 'fehlgeschlagen' ?></td><td><?= admin_e((string)$row['error_message']) ?></td>
</tr>
<?php endforeach; ?>
<?php if ($deliveries === []): ?><tr><td colspan="6">Noch keine Versandversuche vorhanden.</td></tr><?php endif; ?>
</tbody></table></div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
