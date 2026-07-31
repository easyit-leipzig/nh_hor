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
  <article class="admin-card">
    <h2>ANGEBOTE &amp; PREISE</h2>
    <p>Unterrichtsangebote, Preise, Leistungsmerkmale, Reihenfolge und Veröffentlichung verwalten.</p>
    <a class="admin-btn" href="<?= admin_e(app_path('/admin/offers.php')) ?>">Verwalten</a>
  </article>
  <?php if (admin_has_role('admin')): ?>
    <article class="admin-card">
      <h2>KOMMUNIKATION</h2>
      <p>InformUser und Message testen, E-Mails mit Anhängen versenden und Versandprotokolle prüfen.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/communication-test.php')) ?>">Testen</a>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/communication-log.php')) ?>">Protokoll</a>
    </article>
    <article class="admin-card">
      <h2>KARRIEREPROFILE</h2>
      <p>Stellenangebote, Werte, Anforderungen, Bildserien und FAQ pflegen.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/career-jobs.php')) ?>">Verwalten</a>
    </article>
    <article class="admin-card">
      <h2>NAVIGATION</h2>
      <p>Hauptmenü und Untermenüs verwalten.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/navigation.php')) ?>">Verwalten</a>
    </article>
    <article class="admin-card">
      <h2>FREIE STARTSEITENINHALTE</h2>
      <p>Eigene HTML-, CSS- und JavaScript-Blöcke positionieren oder Bereiche ersetzen.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/index-content.php')) ?>">Verwalten</a>
    </article>
    <article class="admin-card">
      <h2>HOMEPAGE-BLÖCKE</h2>
      <p>Vordefinierte Aktionen, Veranstaltungen, Gutscheine und Bildblöcke pflegen.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/homepage_blocks.php')) ?>">Verwalten</a>
    </article>
    <article class="admin-card">
      <h2>IMPRESSUMSPERSONEN</h2>
      <p>Personen und Namensformen den Rollen zuordnen.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-persons.php')) ?>">Verwalten</a>
    </article>
    <article class="admin-card">
      <h2>ADRESSEN</h2>
      <p>Internationale Anschriften den Personen zuordnen.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-addresses.php')) ?>">Verwalten</a>
    </article>
    <article class="admin-card">
      <h2>KONTAKTE</h2>
      <p>Telefon, E-Mail, Webseiten und weitere Kontaktwege verwalten.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-contacts.php')) ?>">Verwalten</a>
    </article>
    <article class="admin-card">
      <h2>IMPRESSUMSROLLEN</h2>
      <p>Rollen für Impressum und Adressnennung verwalten.</p>
      <a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-roles.php')) ?>">Verwalten</a>
    </article>
  <?php endif; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
