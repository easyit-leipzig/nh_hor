<?php
declare(strict_types=1);
require_once __DIR__ . '/../../includes/internal-auth.php';
internal_require_role('viewer');
$portalTitle = 'Informationsportal';
require __DIR__ . '/../includes/portal-header.php';
?>
<section class="internal-hero">
<h1>Informationsportal</h1>
<p>Willkommen, <?= e((string)internal_user()['display_name']) ?>.</p>
</section>
<div class="internal-grid">
<?php if (internal_can('content.view')): ?>
<article class="internal-card" id="inhalte">
<h2>Freigegebene Inhalte</h2>
<p>Für Ihre Rolle freigegebene Inhalte lesen.</p>
</article>
<?php endif; ?>
<?php if (internal_can('downloads.view')): ?>
<article class="internal-card" id="downloads">
<h2>Downloads</h2>
<p>Freigegebene Dokumente herunterladen.</p>
</article>
<?php endif; ?>
</div>
<?php require __DIR__ . '/../includes/portal-footer.php'; ?>
