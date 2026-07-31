<?php
declare(strict_types=1);
require_once __DIR__ . '/../../includes/internal-auth.php';
internal_require_role('mitarbeiter');
$portalTitle = 'Mitarbeiterportal';
require __DIR__ . '/../includes/portal-header.php';
?>
<section class="internal-hero">
<h1>Mitarbeiterportal</h1>
<p>Willkommen, <?= e((string)internal_user()['display_name']) ?>.</p>
</section>
<div class="internal-grid">
<?php if (internal_can('students.manage')): ?>
<article class="internal-card" id="schueler">
<h2>Schülerverwaltung</h2>
<p>Schülerdaten und Zuordnungen verwalten.</p>
</article>
<?php endif; ?>
<?php if (internal_can('appointments.manage')): ?>
<article class="internal-card" id="termine">
<h2>Kalender und Termine</h2>
<p>Termine planen und bearbeiten.</p>
</article>
<?php endif; ?>
<?php if (internal_can('messages.manage')): ?>
<article class="internal-card" id="nachrichten">
<h2>Nachrichten</h2>
<p>Interne Nachrichten bearbeiten.</p>
</article>
<?php endif; ?>
<?php if (internal_can('offers.manage')): ?>
<article class="internal-card" id="angebote">
<h2>Angebote</h2>
<p>Angebote einsehen und pflegen.</p>
</article>
<?php endif; ?>
</div>
<?php require __DIR__ . '/../includes/portal-footer.php'; ?>
