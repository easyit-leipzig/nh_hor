<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;
$row = [];
$error = (string)($_GET['error'] ?? '');
if ($id) {
    try {
        $stmt = db()->prepare('SELECT * FROM homepage_blocks WHERE id=:id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch() ?: [];
        if (!$row) {
            http_response_code(404);
            $error = 'missing';
        }
    } catch (Throwable $e) {
        $error = 'database';
    }
}
$messages = [
    'title' => 'Bitte einen Titel eingeben.',
    'url' => 'Die Button-URL ist ungültig.',
    'upload' => 'Beim Hochladen ist ein Fehler aufgetreten.',
    'size' => 'Das Bild darf höchstens 5 MB groß sein.',
    'type' => 'Erlaubt sind JPEG-, PNG- und WebP-Bilder.',
    'database' => 'Der Block konnte nicht aus der Datenbank gelesen oder gespeichert werden.',
    'missing' => 'Der angeforderte Block wurde nicht gefunden.',
];
$adminTitle = $id ? 'Homepage-Block bearbeiten' : 'Homepage-Block anlegen';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions"><h1 style="margin-right:auto"><?= $id ? 'Homepage-Block bearbeiten' : 'Homepage-Block anlegen' ?></h1><a class="admin-btn" href="<?= admin_e(app_path('/admin/homepage_blocks.php')) ?>">Zur Übersicht</a></div>
<?php if (isset($messages[$error])): ?><p class="admin-notice admin-notice--error"><?= admin_e($messages[$error]) ?></p><?php endif; ?>
<form method="post" action="<?= admin_e(app_path('/admin/homepage_blocks_save.php')) ?>" enctype="multipart/form-data" class="admin-form">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
<?php if ($id): ?><input type="hidden" name="id" value="<?= (int)$id ?>"><?php endif; ?>
<input type="hidden" name="existing_image" value="<?= admin_e((string)($row['image'] ?? '')) ?>">
<div class="admin-form--columns">
<label>Typ<select name="block_type">
<?php foreach (['neu'=>'Neu','veranstaltung'=>'Veranstaltung','gutschein'=>'Gutschein','text_image'=>'Text mit Bild'] as $value=>$label): ?>
<option value="<?= admin_e($value) ?>"<?= ($row['block_type'] ?? 'neu') === $value ? ' selected' : '' ?>><?= admin_e($label) ?></option>
<?php endforeach; ?>
</select></label>
<label>Titel<input name="title" maxlength="255" required value="<?= admin_e((string)($row['title'] ?? '')) ?>"></label>
<label>Button-Text<input name="button_text" maxlength="255" value="<?= admin_e((string)($row['button_text'] ?? '')) ?>"></label>
<label>Button-URL<input name="button_url" maxlength="1000" value="<?= admin_e((string)($row['button_url'] ?? '')) ?>" placeholder="/kontakt.php"></label>
<label>Position<input type="number" name="position" min="0" max="100000" value="<?= (int)($row['position'] ?? 0) ?>"></label>
<label><input type="checkbox" name="active" value="1"<?= !isset($row['active']) || (int)$row['active'] === 1 ? ' checked' : '' ?>> Aktiv</label>
</div>
<label>Text<textarea name="content" rows="8"><?= admin_e((string)($row['content'] ?? '')) ?></textarea></label>
<label>Bild (JPEG, PNG oder WebP, maximal 5 MB)<input type="file" name="image" accept="image/jpeg,image/png,image/webp"></label>
<?php if (!empty($row['image'])): ?><p>Aktuelles Bild: <code><?= admin_e((string)$row['image']) ?></code></p><?php endif; ?>
<button class="admin-btn admin-btn--gold" type="submit">Speichern</button>
</form>
<?php require __DIR__ . '/includes/footer.php'; ?>
