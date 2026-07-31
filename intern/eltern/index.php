<?php
declare(strict_types=1);
require_once __DIR__ . '/../../includes/internal-auth.php';
internal_require_role('eltern');
$portalTitle = 'Elternportal';
require __DIR__ . '/../includes/portal-header.php';
?>
<section class="internal-hero">
<h1>Elternportal</h1>
<p>Willkommen, <?= e((string)internal_user()['display_name']) ?>.</p>
</section>
<div class="internal-grid">
<?php if (internal_can('children.view')): ?>
<article class="internal-card" id="schueler">
<h2>Zugeordnete Schüler</h2>
<p>Zugeordnete Kinder und Lernstände anzeigen.</p>
</article>
<?php endif; ?>
<?php if (internal_can('appointments.view_children')): ?>
<article class="internal-card" id="termine">
<h2>Termine</h2>
<p>Termine der zugeordneten Kinder anzeigen.</p>
</article>
<?php endif; ?>
<?php if (internal_can('messages.use')): ?>
<article class="internal-card" id="mitteilungen">
<h2>Mitteilungen</h2>
<p>Nachrichten lesen und senden.</p>
</article>
<?php endif; ?>
<?php if (internal_can('offers.view_own')): ?>
<article class="internal-card" id="angebote">
<h2>Angebote</h2>
<p>Eigene vereinbarte Angebote anzeigen.</p>
</article>
<?php endif; ?>
</div>
<?php require __DIR__ . '/../includes/portal-footer.php'; ?>
