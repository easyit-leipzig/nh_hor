<?php
declare(strict_types=1);

require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
    http_response_code(403);
    exit('Ungültige oder abgelaufene Anfrage.');
}

if (!db_available()) {
    http_response_code(503);
    exit('Die Datenbank ist derzeit nicht erreichbar.');
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;
$blockType = (string)($_POST['block_type'] ?? 'neu');
$allowedTypes = ['neu', 'veranstaltung', 'gutschein', 'text_image'];
if (!in_array($blockType, $allowedTypes, true)) {
    $blockType = 'neu';
}

$title = sanitize_line((string)($_POST['title'] ?? ''));
$content = trim((string)($_POST['content'] ?? ''));
$buttonText = sanitize_line((string)($_POST['button_text'] ?? ''));
$buttonUrl = trim((string)($_POST['button_url'] ?? ''));
$position = filter_var($_POST['position'] ?? 0, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100000]]);
$active = isset($_POST['active']) ? 1 : 0;
$image = trim((string)($_POST['existing_image'] ?? '')) ?: null;

if ($title === '') {
    header('Location: ' . app_path('/admin/homepage_blocks_edit.php' . ($id ? '?id=' . $id . '&error=title' : '?error=title')), true, 303);
    exit;
}
if ($position === false) {
    $position = 0;
}
if ($buttonUrl !== '' && !str_starts_with($buttonUrl, '/') && filter_var($buttonUrl, FILTER_VALIDATE_URL) === false) {
    header('Location: ' . app_path('/admin/homepage_blocks_edit.php' . ($id ? '?id=' . $id . '&error=url' : '?error=url')), true, 303);
    exit;
}

if (!empty($_FILES['image']['name']) && is_uploaded_file((string)$_FILES['image']['tmp_name'])) {
    if ((int)($_FILES['image']['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        header('Location: ' . app_path('/admin/homepage_blocks_edit.php' . ($id ? '?id=' . $id . '&error=upload' : '?error=upload')), true, 303);
        exit;
    }
    if ((int)($_FILES['image']['size'] ?? 0) > 5 * 1024 * 1024) {
        header('Location: ' . app_path('/admin/homepage_blocks_edit.php' . ($id ? '?id=' . $id . '&error=size' : '?error=size')), true, 303);
        exit;
    }

    $tmp = (string)$_FILES['image']['tmp_name'];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($tmp) ?: '';
    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];
    if (!isset($extensions[$mime])) {
        header('Location: ' . app_path('/admin/homepage_blocks_edit.php' . ($id ? '?id=' . $id . '&error=type' : '?error=type')), true, 303);
        exit;
    }

    $uploadDir = dirname(__DIR__) . '/uploads/homepage';
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
        throw new RuntimeException('Das Upload-Verzeichnis konnte nicht angelegt werden.');
    }
    $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
    if (!move_uploaded_file($tmp, $uploadDir . '/' . $filename)) {
        throw new RuntimeException('Das Bild konnte nicht gespeichert werden.');
    }
    $image = 'uploads/homepage/' . $filename;
}

try {
    if ($id) {
        $stmt = db()->prepare(
            'UPDATE homepage_blocks
             SET block_type=:block_type,title=:title,content=:content,image=:image,
                 button_text=:button_text,button_url=:button_url,position=:position,active=:active
             WHERE id=:id'
        );
        $stmt->execute([
            'block_type' => $blockType,
            'title' => $title,
            'content' => $content,
            'image' => $image,
            'button_text' => $buttonText,
            'button_url' => $buttonUrl,
            'position' => $position,
            'active' => $active,
            'id' => $id,
        ]);
        admin_log('update', 'homepage_block', $id);
        $result = 'updated';
    } else {
        $stmt = db()->prepare(
            'INSERT INTO homepage_blocks
             (block_type,title,content,image,button_text,button_url,position,active)
             VALUES (:block_type,:title,:content,:image,:button_text,:button_url,:position,:active)'
        );
        $stmt->execute([
            'block_type' => $blockType,
            'title' => $title,
            'content' => $content,
            'image' => $image,
            'button_text' => $buttonText,
            'button_url' => $buttonUrl,
            'position' => $position,
            'active' => $active,
        ]);
        $id = (int)db()->lastInsertId();
        admin_log('create', 'homepage_block', $id);
        $result = 'created';
    }
    header('Location: ' . app_path('/admin/homepage_blocks.php?result=' . $result), true, 303);
    exit;
} catch (Throwable $e) {
    error_log('[easyIT homepage blocks] ' . $e->getMessage());
    header('Location: ' . app_path('/admin/homepage_blocks_edit.php' . ($id ? '?id=' . $id . '&error=database' : '?error=database')), true, 303);
    exit;
}
