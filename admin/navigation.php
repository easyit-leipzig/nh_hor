<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_login();

if (!admin_has_role('admin')) {
    http_response_code(403);
    exit('Keine Berechtigung für die Menüverwaltung.');
}

$error = '';
$notice = (string)($_GET['result'] ?? '');
$editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;

if (strtoupper((string)($_SERVER['REQUEST_METHOD'] ?? 'GET')) === 'POST') {
    if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
        http_response_code(403);
        exit('Ungültige oder abgelaufene Sicherheitsanfrage.');
    }
    if (!db_available()) {
        $error = 'Die Datenbank ist nicht erreichbar.';
    } else {
        try {
            $action = (string)($_POST['action'] ?? 'save');
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;
            if ($action === 'delete') {
                if (!$id) throw new RuntimeException('Ungültiger Menüeintrag.');
                $stmt = db()->prepare('DELETE FROM navigation_items WHERE id = :id');
                $stmt->execute(['id' => $id]);
                admin_log('delete', 'navigation', $id);
                header('Location: ' . app_path('/admin/navigation.php?result=deleted'), true, 303);
                exit;
            }

            $title = trim((string)($_POST['title'] ?? ''));
            $url = trim((string)($_POST['url'] ?? '#'));
            $sortOrder = filter_var($_POST['sort_order'] ?? 0, FILTER_VALIDATE_INT);
            $parentId = filter_var($_POST['parent_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            if ($title === '') throw new RuntimeException('Der Titel darf nicht leer sein.');
            if ($url === '') $url = '#';
            if ($id && $parentId === $id) throw new RuntimeException('Ein Menüpunkt kann nicht sein eigenes Elternelement sein.');

            if ($id) {
                $stmt = db()->prepare('UPDATE navigation_items SET parent_id=:parent_id,title=:title,url=:url,sort_order=:sort_order,is_active=:is_active WHERE id=:id');
                $stmt->execute(['parent_id'=>$parentId,'title'=>$title,'url'=>$url,'sort_order'=>(int)$sortOrder,'is_active'=>$isActive,'id'=>$id]);
                admin_log('update', 'navigation', $id);
            } else {
                $stmt = db()->prepare('INSERT INTO navigation_items (parent_id,title,url,sort_order,is_active) VALUES (:parent_id,:title,:url,:sort_order,:is_active)');
                $stmt->execute(['parent_id'=>$parentId,'title'=>$title,'url'=>$url,'sort_order'=>(int)$sortOrder,'is_active'=>$isActive]);
                $id = (int)db()->lastInsertId();
                admin_log('create', 'navigation', $id);
            }
            header('Location: ' . app_path('/admin/navigation.php?result=saved'), true, 303);
            exit;
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}

$items = [];
$editing = null;
if (db_available()) {
    try {
        $items = db()->query('SELECT id,parent_id,title,url,sort_order,is_active FROM navigation_items ORDER BY COALESCE(parent_id,0),sort_order,id')->fetchAll();
        if ($editId) {
            foreach ($items as $item) if ((int)$item['id'] === $editId) $editing = $item;
        }
    } catch (Throwable $e) {
        $error = 'Die Menütabelle fehlt. Bitte zuerst database/migrations/2026-07-20_navigation_items.sql ausführen.';
    }
}

function nav_admin_depth(int $id, array $byId): int {
    $depth = 0; $seen = [];
    while (isset($byId[$id]) && $byId[$id]['parent_id'] !== null && $depth < 10) {
        if (isset($seen[$id])) break;
        $seen[$id] = true; $id = (int)$byId[$id]['parent_id']; $depth++;
    }
    return $depth;
}
$byId = [];
foreach ($items as $item) $byId[(int)$item['id']] = $item;

$adminTitle = 'Navigation';
require __DIR__ . '/includes/header.php';
?>
<h1>Navigation</h1>
<?php if ($notice === 'saved'): ?><p class="admin-notice admin-notice--success">Menüeintrag gespeichert.</p><?php endif; ?>
<?php if ($notice === 'deleted'): ?><p class="admin-notice admin-notice--success">Menüeintrag einschließlich seiner Unterpunkte gelöscht.</p><?php endif; ?>
<?php if ($error !== ''): ?><p class="admin-notice admin-notice--error"><?= admin_e($error) ?></p><?php endif; ?>

<section class="admin-card" style="margin-bottom:2rem">
<h2><?= $editing ? 'Menüeintrag bearbeiten' : 'Menüeintrag anlegen' ?></h2>
<form method="post" action="<?= admin_e(app_path('/admin/navigation.php' . ($editing ? '?edit=' . (int)$editing['id'] : ''))) ?>">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
<input type="hidden" name="action" value="save">
<?php if ($editing): ?><input type="hidden" name="id" value="<?= (int)$editing['id'] ?>"><?php endif; ?>
<p><label>Titel<br><input required name="title" value="<?= admin_e((string)($editing['title'] ?? '')) ?>"></label></p>
<p><label>URL<br><input required name="url" value="<?= admin_e((string)($editing['url'] ?? '#')) ?>"></label></p>
<p><label>Übergeordneter Menüpunkt<br><select name="parent_id"><option value="">– Hauptebene –</option>
<?php foreach ($items as $item): if ($editing && (int)$item['id'] === (int)$editing['id']) continue; ?>
<option value="<?= (int)$item['id'] ?>" <?= isset($editing['parent_id']) && (int)$editing['parent_id']===(int)$item['id']?'selected':'' ?>><?= admin_e(str_repeat('— ', nav_admin_depth((int)$item['id'],$byId)).(string)$item['title']) ?></option>
<?php endforeach; ?></select></label></p>
<p><label>Sortierung<br><input type="number" name="sort_order" value="<?= (int)($editing['sort_order'] ?? 10) ?>"></label></p>
<p><label><input type="checkbox" name="is_active" value="1" <?= !isset($editing['is_active']) || (int)$editing['is_active']===1?'checked':'' ?>> Aktiv</label></p>
<div class="admin-actions"><button class="admin-btn admin-btn--gold" type="submit">Speichern</button><?php if ($editing): ?><a class="admin-btn" href="<?= admin_e(app_path('/admin/navigation.php')) ?>">Abbrechen</a><?php endif; ?></div>
</form>
</section>

<table class="admin-table">
<thead><tr><th>Titel</th><th>URL</th><th>Ebene</th><th>Sortierung</th><th>Status</th><th>Aktionen</th></tr></thead>
<tbody>
<?php foreach ($items as $item): ?>
<tr>
<td><?= admin_e(str_repeat('— ', nav_admin_depth((int)$item['id'],$byId)).(string)$item['title']) ?></td>
<td><code><?= admin_e((string)$item['url']) ?></code></td>
<td><?= nav_admin_depth((int)$item['id'],$byId)+1 ?></td>
<td><?= (int)$item['sort_order'] ?></td>
<td><?= (int)$item['is_active']===1?'aktiv':'inaktiv' ?></td>
<td class="admin-actions"><a class="admin-btn" href="<?= admin_e(app_path('/admin/navigation.php?edit=' . (int)$item['id'])) ?>">Bearbeiten</a>
<form method="post" action="<?= admin_e(app_path('/admin/navigation.php')) ?>" class="admin-inline-form" onsubmit="return confirm('Menüpunkt und alle Unterpunkte wirklich löschen?');">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button class="admin-btn admin-btn--danger" type="submit">Löschen</button></form></td>
</tr>
<?php endforeach; ?>
<?php if (!$items): ?><tr><td colspan="6">Keine Datenbankeinträge vorhanden.</td></tr><?php endif; ?>
</tbody></table>
<?php require __DIR__ . '/includes/footer.php'; ?>
