<?php
declare(strict_types=1);
require __DIR__.'/includes/admin-functions.php';
admin_require_role('admin');
$rows=db()->query('SELECT * FROM homepage_blocks ORDER BY position,id')->fetchAll();
include __DIR__.'/includes/header.php';
?>
<h1>Homepage Blöcke</h1>
<p><a href="homepage_blocks_edit.php">Neuer Block</a></p>
<table class="admin-table"><tr><th>Position</th><th>Typ</th><th>Titel</th><th>Status</th><th></th></tr>
<?php foreach($rows as $r): ?>
<tr><td><?=htmlspecialchars((string)$r['position'])?></td><td><?=htmlspecialchars((string)$r['block_type'])?></td><td><?=htmlspecialchars((string)$r['title'])?></td><td><?=!empty($r['active'])?'aktiv':'inaktiv'?></td><td><a href="homepage_blocks_edit.php?id=<?=$r['id']?>">Bearbeiten</a></td></tr>
<?php endforeach; ?></table>
<?php include __DIR__.'/includes/footer.php'; ?>
