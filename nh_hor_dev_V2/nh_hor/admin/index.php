<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_login();

$counts = ['faq'=>0,'review'=>0,'job'=>0,'blog'=>0];
if (db_available()) {
    $rows = db()->query('SELECT content_type, COUNT(*) AS total FROM content_items GROUP BY content_type')->fetchAll();
    foreach ($rows as $row) {
        $counts[$row['content_type']] = (int)$row['total'];
    }
}

$adminTitle = 'Dashboard';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions"><h1 style="margin-right:auto">Dashboard</h1><a class="admin-btn" href="/admin/cache-clear.php">Cache leeren</a></div>
<p>Inhalte zentral bearbeiten, prüfen und veröffentlichen.</p><?php if (isset($_GET["cache"])): ?><div class="admin-alert"><?= (int)$_GET["cache"] ?> Cache-Dateien wurden entfernt.</div><?php endif; ?>
<div class="admin-grid">
  <?php foreach ($counts as $type => $count): ?>
    <article class="admin-card">
      <h2><?= admin_e(strtoupper($type)) ?></h2>
      <p><strong><?= $count ?></strong> Einträge</p>
      <a class="admin-btn" href="/admin/content.php?type=<?= admin_e($type) ?>">Verwalten</a>
    </article>
  <?php endforeach; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
