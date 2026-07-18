<?php
declare(strict_types=1);

require __DIR__ . '/../includes/admin-functions.php';
require __DIR__ . '/../../includes/content-repository.php';
admin_require_login();

$id = (int)($_GET['id'] ?? 0);
if ($id < 1 || !db_available()) {
    http_response_code(404);
    exit('Inhalt nicht gefunden.');
}

$stmt = db()->prepare('SELECT * FROM content_items WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $id]);
$item = $stmt->fetch();

if (!$item) {
    http_response_code(404);
    exit('Inhalt nicht gefunden.');
}

$adminTitle = 'Vorschau';
require __DIR__ . '/../includes/header.php';
?>
<article class="admin-card">
  <p><strong>Typ:</strong> <?= admin_e($item['content_type']) ?> · <strong>Status:</strong> <?= admin_e($item['status']) ?></p>
  <h1><?= admin_e($item['title']) ?></h1>
  <?php if ($item['excerpt']): ?><p><strong><?= admin_e($item['excerpt']) ?></strong></p><?php endif; ?>
  <div><?= cms_content_html((string)$item['body']) ?></div>
  <?php if ($item['content_type'] === 'review'): ?>
    <p><strong>Bewertungsangaben:</strong>
      <?= !empty($item['review_date']) ? admin_e(date('d.m.Y', strtotime((string)$item['review_date']))) : '—' ?> ·
      <?= admin_e((string)($item['reviewer_name'] ?: '—')) ?> ·
      <?= !empty($item['reviewer_age']) ? (int)$item['reviewer_age'] . ' Jahre' : '—' ?> ·
      <?= admin_e((string)($item['reviewer_school_type'] ?: '—')) ?>
    </p>
  <?php endif; ?>
</article>
<?php require __DIR__ . '/../includes/footer.php'; ?>
