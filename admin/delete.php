<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_login();

$id = (int)($_GET['id'] ?? 0);
if ($id > 0 && db_available()) {
    $stmt = db()->prepare('SELECT content_type FROM content_items WHERE id=:id');
    $stmt->execute(['id'=>$id]);
    $type = $stmt->fetchColumn() ?: 'faq';

    $update = db()->prepare('UPDATE content_items SET status="archived", updated_by=:user WHERE id=:id');
    $update->execute(['user'=>admin_user()['id'],'id'=>$id]);
    admin_log('archive', (string)$type, $id);
    header('Location: /admin/content.php?type=' . rawurlencode((string)$type), true, 303);
    exit;
}
header('Location: /admin/index.php', true, 303);
exit;
