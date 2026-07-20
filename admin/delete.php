<?php
declare(strict_types=1);

require __DIR__ . '/includes/admin-functions.php';
admin_require_login();

$method = strtoupper((string)($_SERVER['REQUEST_METHOD'] ?? 'GET'));
if ($method !== 'POST') {
    admin_log('archive_denied_method', 'content', null, [
        'method' => $method,
        'request_uri' => (string)($_SERVER['REQUEST_URI'] ?? ''),
    ]);
    http_response_code(405);
    header('Allow: POST');
    exit('Methode nicht erlaubt.');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);
$type = (string)($_POST['type'] ?? 'faq');
$allowedTypes = ['faq', 'review', 'job', 'blog'];
if (!in_array($type, $allowedTypes, true)) {
    $type = 'faq';
}

if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
    admin_log('archive_denied_csrf', $type, is_int($id) ? $id : null, [
        'reason' => 'invalid_or_expired_token',
    ]);
    http_response_code(403);
    exit('Ungültige oder abgelaufene Sicherheitsanfrage.');
}

if (!admin_has_role('admin')) {
    admin_log('archive_denied_role', $type, is_int($id) ? $id : null, [
        'required_role' => 'admin',
        'actual_role' => (string)(admin_user()['role'] ?? ''),
    ]);
    http_response_code(403);
    exit('Keine Berechtigung für diese Aktion.');
}

if ($id === false || $id === null) {
    admin_log('archive_failed', $type, null, ['reason' => 'invalid_id']);
    header('Location: ' . app_path('/admin/content.php?type=' . rawurlencode($type)) . '&archive=invalid', true, 303);
    exit;
}

if (!db_available()) {
    admin_log('archive_failed', $type, $id, ['reason' => 'database_unavailable']);
    header('Location: ' . app_path('/admin/content.php?type=' . rawurlencode($type)) . '&archive=error', true, 303);
    exit;
}

try {
    $stmt = db()->prepare(
        'SELECT content_type, status
         FROM content_items
         WHERE id = :id
         LIMIT 1'
    );
    $stmt->execute(['id' => $id]);
    $item = $stmt->fetch();

    if (!$item) {
        admin_log('archive_failed', $type, $id, ['reason' => 'not_found']);
        header('Location: ' . app_path('/admin/content.php?type=' . rawurlencode($type)) . '&archive=missing', true, 303);
        exit;
    }

    $actualType = (string)$item['content_type'];
    if (in_array($actualType, $allowedTypes, true)) {
        $type = $actualType;
    }

    if ((string)$item['status'] === 'archived') {
        admin_log('archive_skipped', $type, $id, ['reason' => 'already_archived']);
        header('Location: ' . app_path('/admin/content.php?type=' . rawurlencode($type)) . '&archive=already', true, 303);
        exit;
    }

    $update = db()->prepare(
        'UPDATE content_items
         SET status = :status, updated_by = :user
         WHERE id = :id'
    );
    $update->execute([
        'status' => 'archived',
        'user' => (int)(admin_user()['id'] ?? 0),
        'id' => $id,
    ]);

    if ($update->rowCount() !== 1) {
        admin_log('archive_failed', $type, $id, ['reason' => 'update_not_applied']);
        header('Location: ' . app_path('/admin/content.php?type=' . rawurlencode($type)) . '&archive=error', true, 303);
        exit;
    }

    admin_log('archive', $type, $id, [
        'previous_status' => (string)$item['status'],
        'new_status' => 'archived',
    ]);

    header('Location: ' . app_path('/admin/content.php?type=' . rawurlencode($type)) . '&archive=success', true, 303);
    exit;
} catch (Throwable $e) {
    admin_log('archive_failed', $type, $id, [
        'reason' => 'exception',
        'exception_class' => get_class($e),
    ]);
    error_log('Archivierung fehlgeschlagen: ' . $e->getMessage());
    header('Location: ' . app_path('/admin/content.php?type=' . rawurlencode($type)) . '&archive=error', true, 303);
    exit;
}
