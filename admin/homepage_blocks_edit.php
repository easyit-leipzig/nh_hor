<?php
declare(strict_types=1);
require __DIR__.'/includes/admin-functions.php';
admin_require_role('admin');
$id=(int)($_GET['id']??0); $r=$id?db()->prepare('SELECT * FROM homepage_blocks WHERE id=?'):null;
if($r){$r->execute([$id]);$row=$r->fetch()?:[];}else{$row=[];}
include __DIR__.'/includes/header.php';
?>
<h1>Homepage Block</h1>
<form method="post" action="homepage_blocks_save.php" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="<?=htmlspecialchars(csrf_token())?>">
<input type="hidden" name="id" value="<?=$id?>">
<label>Typ <select name="block_type"><option>neu</option><option>veranstaltung</option><option>gutschein</option><option>text_image</option></select></label><br>
<label>Titel <input name="title" value="<?=htmlspecialchars($row['title']??'')?>"></label><br>
<label>Text <textarea name="content"><?=htmlspecialchars($row['content']??'')?></textarea></label><br>
<label>Bild <input type="file" name="image"></label><br>
<label>Button Text <input name="button_text"></label><br>
<label>Button URL <input name="button_url"></label><br>
<label>Position <input name="position" value="<?=htmlspecialchars((string)($row['position']??0))?>"></label><br>
<label><input type="checkbox" name="active" checked> Aktiv</label><br>
<button type="submit">Speichern</button>
</form>
<?php include __DIR__.'/includes/footer.php'; ?>
