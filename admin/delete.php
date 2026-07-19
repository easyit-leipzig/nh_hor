<?php
declare(strict_types=1);

require __DIR__ . '/includes/admin-functions.php';
admin_require_login();

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Methode nicht erlaubt.');
}

if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
    http_response_code(403);
    exit('Ungültige oder abgelaufene Sicherheitsanfrage.');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);
$type = (string)($_POST['type'] ?? 'faq');
$allowedTypes = ['faq', 'review', 'job', 'blog'];

if (!in_array($type, $allowedTypes, true)) {
    $type = 'faq';
}

if ($id === false || $id === null || !db_available()) {
    header('Location: /nh_hor/admin/content.php?type=' . rawurlencode($type) . '&archive=invalid', true, 303);
    exit;
}

$stmt = db()->prepare(
    'SELECT content_type, status
     FROM content_items
     WHERE id = :id
     LIMIT 1'
);
$stmt->execute(['id' => $id]);
$item = $stmt->fetch();

if (!$item) {
    header('Location: /nh_hor/admin/content.php?type=' . rawurlencode($type) . '&archive=missing', true, 303);
    exit;
}

$actualType = (string)$item['content_type'];
if (in_array($actualType, $allowedTypes, true)) {
    $type = $actualType;
}

if ((string)$item['status'] !== 'archived') {
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

    admin_log('archive', $type, $id, ['previous_status' => (string)$item['status']]);
}

header('Location: /nh_hor/admin/content.php?type=' . rawurlencode($type) . '&archive=success', true, 303);
exit;
