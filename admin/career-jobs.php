<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
require_once __DIR__ . '/../includes/career-repository.php';
admin_require_role('admin');

$jobs = career_all_jobs(true);
$adminTitle = 'Karriere-Stellenprofile';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions">
  <h1 style="margin-right:auto">Karriere-Stellenprofile</h1>
  <a class="admin-btn" href="<?= admin_e(app_path('/admin/career-job-edit.php')) ?>">Neues Profil</a>
</div>
<?php if (!career_tables_available()): ?>
<div class="admin-alert">Die Karriere-Datenbanktabellen fehlen. Bitte zuerst <code>database/migrations/2026-07-26_career_module_phase3.sql</code> importieren. Bis dahin werden die Inhalte aus <code>config/jobs.php</code> angezeigt.</div>
<?php endif; ?>
<div class="admin-card">
<table class="admin-table">
<thead><tr><th>Reihenfolge</th><th>Code</th><th>Titel</th><th>Status</th><th>URL</th><th>Aktion</th></tr></thead>
<tbody>
<?php foreach ($jobs as $key => $job): ?>
<tr>
<td><?= (int)($job['sort_order'] ?? 100) ?></td>
<td><strong><?= admin_e((string)$job['code']) ?></strong></td>
<td><?= admin_e((string)$job['title']) ?><br><small><?= admin_e((string)$key) ?></small></td>
<td><?= admin_e((string)($job['status'] ?? 'Konfiguration')) ?></td>
<td><a href="<?= admin_e(app_path('/' . $job['slug'])) ?>" target="_blank" rel="noopener">Vorschau</a></td>
<td><a class="admin-btn" href="<?= admin_e(app_path('/admin/career-job-edit.php?key=' . rawurlencode((string)$key))) ?>">Bearbeiten</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
