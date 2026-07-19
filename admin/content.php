<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_login();

$allowed = ['faq','review','job','blog'];
$type = (string)($_GET['type'] ?? 'faq');
if (!in_array($type, $allowed, true)) {
    $type = 'faq';
}

$archiveResult = (string)($_GET['archive'] ?? '');
$items = [];
if (db_available()) {
    $stmt = db()->prepare('SELECT id, title, slug, status, updated_at FROM content_items WHERE content_type = :type ORDER BY updated_at DESC');
    $stmt->execute(['type' => $type]);
    $items = $stmt->fetchAll();
}

$adminTitle = 'Inhalte';
require __DIR__ . '/includes/header.php';
?>
<?php if ($archiveResult === 'success'): ?>
<p class="admin-notice admin-notice--success">Der Eintrag wurde archiviert.</p>
<?php elseif ($archiveResult === 'missing'): ?>
<p class="admin-notice admin-notice--error">Der Eintrag wurde nicht gefunden.</p>
<?php elseif ($archiveResult === 'invalid'): ?>
<p class="admin-notice admin-notice--error">Die Archivierungsanfrage war ungültig.</p>
<?php elseif ($archiveResult === 'already'): ?>
<p class="admin-notice admin-notice--error">Der Eintrag war bereits archiviert.</p>
<?php elseif ($archiveResult === 'error'): ?>
<p class="admin-notice admin-notice--error">Der Eintrag konnte nicht archiviert werden.</p>
<?php endif; ?>
<div class="admin-actions">
  <h1 style="margin-right:auto"><?= admin_e(strtoupper($type)) ?></h1>
  <a class="admin-btn admin-btn--gold" href="/admin/edit.php?type=<?= admin_e($type) ?>">Neuer Eintrag</a>
</div>
<table class="admin-table">
<thead><tr><th>Titel</th><th>Status</th><th>Geändert</th><th>Aktionen</th></tr></thead>
<tbody>
<?php foreach ($items as $item): ?>
<tr>
  <td><strong><?= admin_e($item['title']) ?></strong><br><small><?= admin_e($item['slug']) ?></small></td>
  <td><?= admin_e($item['status']) ?></td>
  <td><?= admin_e($item['updated_at']) ?></td>
  <td class="admin-actions">
    <a class="admin-btn" href="/admin/edit.php?id=<?= (int)$item['id'] ?>">Bearbeiten</a>
    <a class="admin-btn" href="/admin/preview/content.php?id=<?= (int)$item['id'] ?>">Vorschau</a>
    <?php if (admin_has_role('admin')): ?>
    <form method="post" action="/admin/delete.php" class="admin-inline-form" onsubmit="return confirm('Diesen Eintrag wirklich archivieren?');">
      <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
      <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
      <input type="hidden" name="type" value="<?= admin_e($type) ?>">
      <button class="admin-btn admin-btn--danger" type="submit">Archivieren</button>
    </form>
    <?php endif; ?>
  </td>
</tr>
<?php endforeach; ?>
<?php if (!$items): ?><tr><td colspan="4">Noch keine Einträge vorhanden.</td></tr><?php endif; ?>
</tbody>
</table>
<?php require __DIR__ . '/includes/footer.php'; ?>
