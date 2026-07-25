<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');

$rows = [];
$error = '';
try {
    if (!db_available()) {
        throw new RuntimeException('Die Datenbank ist nicht erreichbar.');
    }
    $rows = db()->query('SELECT * FROM homepage_blocks ORDER BY position,id')->fetchAll();
} catch (Throwable $e) {
    $error = 'Die Tabelle homepage_blocks ist nicht verfügbar. Bitte die zugehörige Migration importieren.';
}
$result = (string)($_GET['result'] ?? '');
$adminTitle = 'Homepage-Blöcke';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions">
  <h1 style="margin-right:auto">Homepage-Blöcke</h1>
  <a class="admin-btn admin-btn--gold" href="<?= admin_e(app_path('/admin/homepage_blocks_edit.php')) ?>">Neuer Block</a>
  <a class="admin-btn" href="<?= admin_e(app_path('/index.php')) ?>" target="_blank" rel="noopener">Startseite öffnen</a>
</div>
<p>Vordefinierte Hinweis-, Veranstaltungs-, Gutschein- und Bildblöcke verwalten.</p>
<?php if ($result === 'created'): ?><p class="admin-notice admin-notice--success">Der Block wurde angelegt.</p><?php endif; ?>
<?php if ($result === 'updated'): ?><p class="admin-notice admin-notice--success">Der Block wurde aktualisiert.</p><?php endif; ?>
<?php if ($error): ?><p class="admin-notice admin-notice--error"><?= admin_e($error) ?></p><?php endif; ?>
<table class="admin-table">
<thead><tr><th>Position</th><th>Typ</th><th>Titel</th><th>Status</th><th>Aktionen</th></tr></thead>
<tbody>
<?php foreach ($rows as $row): ?>
<tr>
  <td><?= (int)$row['position'] ?></td>
  <td><?= admin_e((string)$row['block_type']) ?></td>
  <td><strong><?= admin_e((string)$row['title']) ?></strong></td>
  <td><?= !empty($row['active']) ? 'aktiv' : 'inaktiv' ?></td>
  <td><a class="admin-btn" href="<?= admin_e(app_path('/admin/homepage_blocks_edit.php?id=' . (int)$row['id'])) ?>">Bearbeiten</a></td>
</tr>
<?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="5">Keine Blöcke vorhanden.</td></tr><?php endif; ?>
</tbody>
</table>
<?php require __DIR__ . '/includes/footer.php'; ?>
