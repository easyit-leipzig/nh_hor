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
        if (!$row) { http_response_code(404); $error = 'missing'; }
    } catch (Throwable $e) { $error = 'database'; }
}
$messages = [
    'title' => 'Bitte einen Titel eingeben.', 'url' => 'Die Button-URL ist ungültig.',
    'upload' => 'Beim Hochladen ist ein Fehler aufgetreten.', 'size' => 'Das Bild darf höchstens 5 MB groß sein.',
    'type' => 'Erlaubt sind JPEG-, PNG- und WebP-Bilder.',
    'database' => 'Der Block konnte nicht aus der Datenbank gelesen oder gespeichert werden.',
    'missing' => 'Der angeforderte Block wurde nicht gefunden.', 'css' => 'Das Experten-CSS enthält nicht erlaubte Anweisungen.'
];
$defaults = [
    'backgroundColor'=>'#ffffff','textColor'=>'#17324d','accentColor'=>'#0057a4','buttonColor'=>'#0057a4','buttonTextColor'=>'#ffffff',
    'padding'=>32,'gap'=>32,'borderRadius'=>20,'borderWidth'=>0,'borderColor'=>'#cad8e4','shadow'=>'medium',
    'minHeight'=>220,'imageWidth'=>280,'imageHeight'=>220,'imageRadius'=>16,'imageFit'=>'cover','imagePosition'=>'center center',
    'layout'=>'image-left','textAlign'=>'left','titleSize'=>32,'contentSize'=>16,'hoverEffect'=>'lift'
];
$savedStyle = json_decode((string)($row['style_json'] ?? ''), true);
$style = array_merge($defaults, is_array($savedStyle) ? $savedStyle : []);
$adminTitle = $id ? 'Homepage-Block bearbeiten' : 'Homepage-Block anlegen';
require __DIR__ . '/includes/header.php';
?>
<link rel="stylesheet" href="<?= admin_e(app_path('/assets/css/homepage-block-editor.css')) ?>">
<div class="admin-actions"><h1 style="margin-right:auto"><?= $id ? 'Homepage-Block bearbeiten' : 'Homepage-Block anlegen' ?></h1><a class="admin-btn admin-btn--gold" href="<?= admin_e(app_path('/admin/homepage_blocks_help.php')) ?>">Detaillierte Bedienungsanleitung</a><a class="admin-btn" href="<?= admin_e(app_path('/admin/homepage_blocks.php')) ?>">Zur Übersicht</a></div>
<?php if (isset($messages[$error])): ?><p class="admin-notice admin-notice--error"><?= admin_e($messages[$error]) ?></p><?php endif; ?>
<form method="post" action="<?= admin_e(app_path('/admin/homepage_blocks_save.php')) ?>" enctype="multipart/form-data" class="admin-form" id="block-editor-form">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
<?php if ($id): ?><input type="hidden" name="id" value="<?= (int)$id ?>"><?php endif; ?>
<input type="hidden" name="existing_image" value="<?= admin_e((string)($row['image'] ?? '')) ?>">
<input type="hidden" name="style_json" id="style_json" value="<?= admin_e(json_encode($style, JSON_UNESCAPED_SLASHES)) ?>">

<div class="block-editor-layout">
<div class="block-editor-controls">
<section class="admin-card editor-section">
<h2>Inhalt</h2>
<div class="admin-form--columns">
<label>Typ<select name="block_type" data-preview="type"><?php foreach (['neu'=>'Neu','veranstaltung'=>'Veranstaltung','gutschein'=>'Gutschein','text_image'=>'Text mit Bild'] as $value=>$label): ?><option value="<?= admin_e($value) ?>"<?= ($row['block_type'] ?? 'neu') === $value ? ' selected' : '' ?>><?= admin_e($label) ?></option><?php endforeach; ?></select></label>
<label>Titel<input name="title" maxlength="255" required value="<?= admin_e((string)($row['title'] ?? '')) ?>" data-preview="title"></label>
<label>Button-Text<input name="button_text" maxlength="255" value="<?= admin_e((string)($row['button_text'] ?? '')) ?>" data-preview="buttonText"></label>
<label>Button-URL<input name="button_url" maxlength="1000" value="<?= admin_e((string)($row['button_url'] ?? '')) ?>" placeholder="/kontakt.php"></label>
<label>Position<input type="number" name="position" min="0" max="100000" value="<?= (int)($row['position'] ?? 0) ?>"></label>
<label class="editor-checkbox"><input type="checkbox" name="active" value="1"<?= !isset($row['active']) || (int)$row['active'] === 1 ? ' checked' : '' ?>> Aktiv</label>
</div>
<label>Text<textarea name="content" rows="6" data-preview="content"><?= admin_e((string)($row['content'] ?? '')) ?></textarea></label>
<label>Bild (JPEG, PNG oder WebP, maximal 5 MB)<input type="file" name="image" accept="image/jpeg,image/png,image/webp" id="image-upload"></label>
<?php if (!empty($row['image'])): ?><p>Aktuelles Bild: <code><?= admin_e((string)$row['image']) ?></code></p><?php endif; ?>
</section>

<section class="admin-card editor-section">
<div class="editor-heading"><h2>Visueller Editor</h2><button type="button" class="admin-btn editor-reset" id="editor-reset">Standardwerte</button></div>
<div class="editor-grid">
<label>Hintergrund<input type="color" data-style="backgroundColor" value="<?= admin_e($style['backgroundColor']) ?>"></label>
<label>Textfarbe<input type="color" data-style="textColor" value="<?= admin_e($style['textColor']) ?>"></label>
<label>Akzentfarbe<input type="color" data-style="accentColor" value="<?= admin_e($style['accentColor']) ?>"></label>
<label>Buttonfarbe<input type="color" data-style="buttonColor" value="<?= admin_e($style['buttonColor']) ?>"></label>
<label>Buttontext<input type="color" data-style="buttonTextColor" value="<?= admin_e($style['buttonTextColor']) ?>"></label>
<label>Rahmenfarbe<input type="color" data-style="borderColor" value="<?= admin_e($style['borderColor']) ?>"></label>
<label>Layout<select data-style="layout"><option value="image-left">Bild links</option><option value="image-right">Bild rechts</option><option value="image-top">Bild oben</option><option value="text-only">Nur Text</option></select></label>
<label>Textausrichtung<select data-style="textAlign"><option value="left">Links</option><option value="center">Zentriert</option><option value="right">Rechts</option></select></label>
<label>Schatten<select data-style="shadow"><option value="none">Keiner</option><option value="soft">Leicht</option><option value="medium">Mittel</option><option value="strong">Stark</option></select></label>
<label>Hover-Effekt<select data-style="hoverEffect"><option value="none">Keiner</option><option value="lift">Anheben</option><option value="zoom">Vergrößern</option><option value="glow">Leuchten</option></select></label>
<label>Bildanpassung<select data-style="imageFit"><option value="cover">Ausfüllen</option><option value="contain">Einpassen</option><option value="fill">Strecken</option></select></label>
<label>Bildposition<select data-style="imagePosition"><option value="center center">Mitte</option><option value="center top">Oben</option><option value="center bottom">Unten</option><option value="left center">Links</option><option value="right center">Rechts</option></select></label>
</div>
<div class="editor-ranges">
<?php foreach ([['padding','Innenabstand',0,80,'px'],['gap','Abstand Bild/Text',0,80,'px'],['borderRadius','Eckenradius',0,60,'px'],['borderWidth','Rahmenbreite',0,12,'px'],['minHeight','Mindesthöhe',120,600,'px'],['imageWidth','Bildbreite',100,600,'px'],['imageHeight','Bildhöhe',100,500,'px'],['imageRadius','Bildecken',0,60,'px'],['titleSize','Titelgröße',18,64,'px'],['contentSize','Textgröße',12,28,'px']] as [$key,$label,$min,$max,$unit]): ?>
<label><span><?= admin_e($label) ?> <output data-output="<?= admin_e($key) ?>"><?= (int)$style[$key] ?><?= $unit ?></output></span><input type="range" min="<?= $min ?>" max="<?= $max ?>" value="<?= (int)$style[$key] ?>" data-style="<?= admin_e($key) ?>" data-unit="<?= $unit ?>"></label>
<?php endforeach; ?>
</div>
</section>

<section class="admin-card editor-section">
<details class="expert-mode"<?= trim((string)($row['custom_css'] ?? '')) !== '' ? ' open' : '' ?>><summary>Experten-CSS-Modus</summary>
<p class="admin-help">Nur CSS-Deklarationen für die Kachel eingeben, beispielsweise <code>background-image: linear-gradient(...);</code>. Selektoren, geschweifte Klammern, <code>@import</code> und JavaScript-URLs sind gesperrt.</p>
<label>Zusätzliche CSS-Deklarationen<textarea name="custom_css" id="custom_css" rows="8" spellcheck="false" placeholder="background-image: linear-gradient(135deg, #ffffff, #eef6ff);&#10;letter-spacing: 0.01em;"><?= admin_e((string)($row['custom_css'] ?? '')) ?></textarea></label>
<p id="css-warning" class="admin-notice admin-notice--error" hidden></p>
</details>
</section>
<button class="admin-btn admin-btn--gold editor-save" type="submit">Block speichern</button>
</div>

<aside class="block-editor-preview-panel">
<div class="preview-toolbar" role="group" aria-label="Vorschaugröße"><button type="button" data-viewport="desktop" class="is-active">Desktop</button><button type="button" data-viewport="tablet">Tablet</button><button type="button" data-viewport="mobile">Mobil</button></div>
<div class="preview-stage" id="preview-stage">
<section class="homepage-block-editor-preview" id="block-preview">
<div class="preview-media"><img id="preview-image" src="<?= admin_e(!empty($row['image']) ? app_path('/'.ltrim((string)$row['image'],'/')) : app_path('/assets/img/stud-lern.png')) ?>" alt=""></div>
<div class="preview-content"><h2 id="preview-title"><?= admin_e((string)($row['title'] ?? 'Titel der Block-Kachel')) ?></h2><p id="preview-text"><?= nl2br(admin_e((string)($row['content'] ?? 'Hier erscheint der Inhalt der Kachel.'))) ?></p><a id="preview-button" href="#"><?= admin_e((string)($row['button_text'] ?? 'Mehr erfahren')) ?></a></div>
</section>
</div>
<p class="preview-note">Die Vorschau aktualisiert sich unmittelbar. Die tatsächliche Breite richtet sich auf der Startseite nach dem Inhaltsbereich.</p>
</aside>
</div>
</form>
<script src="<?= admin_e(app_path('/assets/js/homepage-block-editor.js')) ?>" defer></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
