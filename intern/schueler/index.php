<?php
declare(strict_types=1);
require_once __DIR__ . '/../../includes/internal-auth.php';
internal_require_role('schueler');
$portalTitle = 'Lernportal';
require __DIR__ . '/../includes/portal-header.php';
?>
<section class="internal-hero">
<h1>Lernportal</h1>
<p>Willkommen, <?= e((string)internal_user()['display_name']) ?>.</p>
</section>
<div class="internal-grid">
<?php if (internal_can('appointments.view_own')): ?>
<article class="internal-card" id="termine">
<h2>Meine Termine</h2>
<p>Anstehende Nachhilfetermine anzeigen.</p>
</article>
<?php endif; ?>
<?php if (internal_can('tasks.view_own')): ?>
<article class="internal-card" id="aufgaben">
<h2>Meine Aufgaben</h2>
<p>Freigegebene Aufgaben anzeigen.</p>
</article>
<?php endif; ?>
<?php if (internal_can('documents.view_own')): ?>
<article class="internal-card" id="dokumente">
<h2>Meine Dokumente</h2>
<p>Unterrichtsdokumente abrufen.</p>
</article>
<?php endif; ?>
<?php if (internal_can('messages.use')): ?>
<article class="internal-card" id="nachrichten">
<h2>Nachrichten</h2>
<p>Nachrichten lesen und senden.</p>
</article>
<?php endif; ?>
</div>
<?php require __DIR__ . '/../includes/portal-footer.php'; ?>
