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
<div class="admin-actions"><h1 style="margin-right:auto">Dashboard</h1><form method="post" action="<?= admin_e(app_path('/admin/cache-clear.php')) ?>" class="admin-inline-form"><input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><button class="admin-btn" type="submit">Cache leeren</button></form></div>
<p>Inhalte zentral bearbeiten, prüfen und veröffentlichen.</p><?php if (isset($_GET["cache"])): ?><div class="admin-alert"><?= (int)$_GET["cache"] ?> Cache-Dateien wurden entfernt.</div><?php endif; ?>
<div class="admin-grid">
  <?php foreach ($counts as $type => $count): ?>
    <article class="admin-card">
      <h2><?= admin_e(strtoupper($type)) ?></h2>
      <p><strong><?= $count ?></strong> Einträge</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/content.php?type=' . rawurlencode($type))) ?>">Verwalten</a>
    </article>
  <?php endforeach; ?>
  <?php if (admin_has_role('admin')): ?>
    <article class="admin-card">
      <h2>NAVIGATION</h2>
      <p>Hauptmenü und Untermenüs verwalten.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/navigation.php')) ?>">Verwalten</a>
    </article>
    <article class="admin-card">
      <h2>IMPRESSUMSPERSONEN</h2>
      <p>Personen und Namensformen den Rollen zuordnen.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-persons.php')) ?>">Verwalten</a>
    </article>
    <article class="admin-card">
      <h2>IMPRESSUMSROLLEN</h2>
      <p>Rollen für Impressum und Adressnennung verwalten.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-roles.php')) ?>">Verwalten</a>
    </article>
  <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
