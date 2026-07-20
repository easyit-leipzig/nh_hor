<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');

$error = '';
$notice = (string)($_GET['result'] ?? '');
$placements = ['before'=>'Vor Position einfügen','after'=>'Nach Position einfügen','replace'=>'Position ersetzen'];
$positionLabels = [
    1 => 'Hero / Startbereich',
    2 => 'Fächer',
    3 => 'easyIT kennenlernen',
    4 => 'Häufige Fragen',
    5 => 'Call-to-Action / Kontakt',
    6 => 'Nach dem letzten Startseitenbereich',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
        http_response_code(403);
        exit('Ungültige Anfrage.');
    }
    try {
        $action = (string)($_POST['action'] ?? 'save');
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]) ?: null;
        if ($action === 'delete') {
            if (!$id) throw new RuntimeException('Ungültige ID.');
            $stmt = db()->prepare('DELETE FROM add_index_content WHERE id=:id');
            $stmt->execute(['id'=>$id]);
            admin_log('delete', 'index_content', $id);
            header('Location: ' . app_path('/admin/index-content.php?result=deleted'), true, 303);
            exit;
        }

        $internalName = trim((string)($_POST['internal_name'] ?? ''));
        $title = trim((string)($_POST['title'] ?? ''));
        $positionNo = filter_var($_POST['position_no'] ?? null, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1,'max_range'=>1000]]);
        $placement = (string)($_POST['placement'] ?? 'after');
        $html = trim((string)($_POST['html_content'] ?? ''));
        $css = trim((string)($_POST['css_content'] ?? ''));
        $js = trim((string)($_POST['js_content'] ?? ''));
        $wrapperClass = trim((string)($_POST['wrapper_class'] ?? ''));
        $sortOrder = filter_var($_POST['sort_order'] ?? 100, FILTER_VALIDATE_INT, ['options'=>['min_range'=>0,'max_range'=>100000]]);
        $active = isset($_POST['active']) ? 1 : 0;
        if ($internalName === '') throw new RuntimeException('Bitte eine interne Bezeichnung angeben.');
        if ($html === '') throw new RuntimeException('Bitte HTML-Inhalt angeben.');
        if ($positionNo === false) throw new RuntimeException('Die Position muss zwischen 1 und 1000 liegen.');
        if (!isset($placements[$placement])) throw new RuntimeException('Ungültige Einfügeart.');
        if ($sortOrder === false) throw new RuntimeException('Ungültige Sortierung.');
        if (mb_strlen($internalName) > 160 || mb_strlen($title) > 255 || mb_strlen($wrapperClass) > 255) {
            throw new RuntimeException('Ein Textfeld ist zu lang.');
        }
        if ($wrapperClass !== '' && preg_match('/^[a-zA-Z0-9_\- ]+$/', $wrapperClass) !== 1) {
            throw new RuntimeException('Wrapper-Klassen dürfen nur Buchstaben, Zahlen, Leerzeichen, Bindestriche und Unterstriche enthalten.');
        }
        $dates = [];
        foreach (['valid_from','valid_until'] as $field) {
            $raw = trim((string)($_POST[$field] ?? ''));
            if ($raw !== '' && preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $raw) !== 1) {
                throw new RuntimeException('Ungültiges Datum oder ungültige Uhrzeit.');
            }
            $dates[$field] = $raw !== '' ? str_replace('T',' ', $raw) . ':00' : null;
        }
        if ($dates['valid_from'] && $dates['valid_until'] && $dates['valid_until'] < $dates['valid_from']) {
            throw new RuntimeException('Das Gültigkeitsende darf nicht vor dem Beginn liegen.');
        }
        $params = compact('internalName','title','positionNo','placement','html','css','js','wrapperClass','sortOrder','active');
        $params['validFrom'] = $dates['valid_from'];
        $params['validUntil'] = $dates['valid_until'];
        if ($id) {
            $params['id'] = $id;
            $stmt = db()->prepare('UPDATE add_index_content SET internal_name=:internalName,title=:title,position_no=:positionNo,placement=:placement,html_content=:html,css_content=:css,js_content=:js,wrapper_class=:wrapperClass,sort_order=:sortOrder,active=:active,valid_from=:validFrom,valid_until=:validUntil WHERE id=:id');
            $stmt->execute($params);
            $result = 'updated';
        } else {
            $stmt = db()->prepare('INSERT INTO add_index_content (internal_name,title,position_no,placement,html_content,css_content,js_content,wrapper_class,sort_order,active,valid_from,valid_until) VALUES (:internalName,:title,:positionNo,:placement,:html,:css,:js,:wrapperClass,:sortOrder,:active,:validFrom,:validUntil)');
            $stmt->execute($params);
            $id = (int)db()->lastInsertId();
            $result = 'created';
        }
        admin_log($result === 'created' ? 'create' : 'update', 'index_content', $id, ['position'=>$positionNo,'placement'=>$placement]);
        header('Location: ' . app_path('/admin/index-content.php?result=' . $result), true, 303);
        exit;
    } catch (PDOException $e) {
        error_log('[easyIT index content admin] ' . $e->getMessage());
        $error = 'Der Startseiteninhalt konnte nicht gespeichert werden. Ist die Migration importiert?';
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$items = [];
try {
    $items = db()->query('SELECT * FROM add_index_content ORDER BY position_no, sort_order, id')->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
    $error = $error ?: 'Die Tabelle add_index_content ist noch nicht verfügbar. Bitte zuerst die Migration importieren.';
}
function index_admin_datetime(?string $value): string { return $value ? str_replace(' ', 'T', substr($value,0,16)) : ''; }
$adminTitle = 'Startseitenblöcke';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions"><h1 style="margin-right:auto">Startseitenblöcke</h1><a class="admin-btn" href="<?= admin_e(app_path('/index.php')) ?>" target="_blank" rel="noopener">Startseite öffnen</a></div>
<p>Aktions-, Veranstaltungs- und Hinweisblöcke an nummerierten Positionen ergänzen oder bestehende Bereiche ersetzen. HTML, CSS und JavaScript werden nur von vertrauenswürdigen Administratoren gepflegt.</p>
<?php if ($notice): ?><p class="admin-notice admin-notice--success">Änderung gespeichert.</p><?php endif; ?>
<?php if ($error): ?><p class="admin-notice admin-notice--error"><?= admin_e($error) ?></p><?php endif; ?>

<section class="admin-card" style="margin-bottom:2rem">
<h2>Neuen Block anlegen</h2>
<form method="post" class="admin-form">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="save">
<div class="admin-form--columns">
<label>Interne Bezeichnung<input name="internal_name" maxlength="160" required placeholder="Sommersale 2026"></label>
<label>Optionaler Titel<input name="title" maxlength="255" placeholder="Nur für die Verwaltung"></label>
<label>Position<select name="position_no"><?php foreach($positionLabels as $no=>$label): ?><option value="<?= $no ?>"><?= $no ?> – <?= admin_e($label) ?></option><?php endforeach; ?></select></label>
<label>Einfügeart<select name="placement"><?php foreach($placements as $value=>$label): ?><option value="<?= admin_e($value) ?>"><?= admin_e($label) ?></option><?php endforeach; ?></select></label>
<label>Wrapper-CSS-Klassen<input name="wrapper_class" maxlength="255" placeholder="section promo-section"></label>
<label>Sortierung<input name="sort_order" type="number" min="0" max="100000" value="100"></label>
<label>Gültig ab<input name="valid_from" type="datetime-local"></label>
<label>Gültig bis<input name="valid_until" type="datetime-local"></label>
<label><input name="active" type="checkbox" value="1" checked> Aktiv</label>
</div>
<label>HTML<textarea name="html_content" rows="10" required placeholder="&lt;div class=&quot;promo&quot;&gt;...&lt;/div&gt;"></textarea></label>
<label>CSS<textarea name="css_content" rows="7" placeholder=".promo { ... }"></textarea></label>
<label>JavaScript<textarea name="js_content" rows="7" placeholder="document.querySelector(...)"></textarea></label>
<button class="admin-btn admin-btn--gold" type="submit">Block anlegen</button>
</form>
</section>

<?php foreach($items as $item): ?>
<section class="admin-card" style="margin-bottom:1.5rem">
<h2><?= admin_e((string)$item['internal_name']) ?> <small>#<?= (int)$item['id'] ?></small></h2>
<form method="post" class="admin-form">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
<div class="admin-form--columns">
<label>Interne Bezeichnung<input name="internal_name" maxlength="160" required value="<?= admin_e((string)$item['internal_name']) ?>"></label>
<label>Optionaler Titel<input name="title" maxlength="255" value="<?= admin_e((string)$item['title']) ?>"></label>
<label>Position<input name="position_no" type="number" min="1" max="1000" value="<?= (int)$item['position_no'] ?>" required></label>
<label>Einfügeart<select name="placement"><?php foreach($placements as $value=>$label): ?><option value="<?= admin_e($value) ?>"<?= $value===$item['placement']?' selected':'' ?>><?= admin_e($label) ?></option><?php endforeach; ?></select></label>
<label>Wrapper-CSS-Klassen<input name="wrapper_class" maxlength="255" value="<?= admin_e((string)$item['wrapper_class']) ?>"></label>
<label>Sortierung<input name="sort_order" type="number" min="0" max="100000" value="<?= (int)$item['sort_order'] ?>"></label>
<label>Gültig ab<input name="valid_from" type="datetime-local" value="<?= admin_e(index_admin_datetime($item['valid_from'])) ?>"></label>
<label>Gültig bis<input name="valid_until" type="datetime-local" value="<?= admin_e(index_admin_datetime($item['valid_until'])) ?>"></label>
<label><input name="active" type="checkbox" value="1"<?= (int)$item['active']===1?' checked':'' ?>> Aktiv</label>
</div>
<label>HTML<textarea name="html_content" rows="10" required><?= admin_e((string)$item['html_content']) ?></textarea></label>
<label>CSS<textarea name="css_content" rows="7"><?= admin_e((string)$item['css_content']) ?></textarea></label>
<label>JavaScript<textarea name="js_content" rows="7"><?= admin_e((string)$item['js_content']) ?></textarea></label>
<button class="admin-btn" type="submit">Speichern</button>
</form>
<form method="post" class="admin-inline-form" onsubmit="return confirm('Block wirklich löschen?');">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button class="admin-btn admin-btn--danger" type="submit">Löschen</button>
</form>
</section>
<?php endforeach; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
