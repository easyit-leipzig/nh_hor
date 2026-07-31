<?php
declare(strict_types=1);
require_once __DIR__ . '/../../includes/internal-auth.php';
internal_require_role('lehrer');
$portalTitle = 'Lehrerportal';
require __DIR__ . '/../includes/portal-header.php';
?>
<section class="internal-hero">
<h1>Lehrerportal</h1>
<p>Willkommen, <?= e((string)internal_user()['display_name']) ?>.</p>
</section>
<div class="internal-grid">
<?php if (internal_can('students.view_own')): ?>
<article class="internal-card" id="schueler">
<h2>Meine Schüler</h2>
<p>Zugeordnete Lernende anzeigen.</p>
</article>
<?php endif; ?>
<?php if (internal_can('appointments.view_own')): ?>
<article class="internal-card" id="termine">
<h2>Meine Termine</h2>
<p>Eigene Unterrichtstermine anzeigen.</p>
</article>
<?php endif; ?>
<?php if (internal_can('lessons.document')): ?>
<article class="internal-card" id="dokumentation">
<h2>Unterrichtsdokumentation</h2>
<p>Unterrichtsergebnisse dokumentieren.</p>
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
