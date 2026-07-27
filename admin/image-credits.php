<?php
declare(strict_types=1);

session_start();

require_once dirname(__DIR__) . '/includes/functions.php';

if (empty($_SESSION['admin_user_id']) && empty($_SESSION['user_id']) && empty($_SESSION['admin'])) {
    header('Location: ' . app_path('/admin/login.php'));
    exit;
}

function creditsPdo(): PDO
{
    if (function_exists('db')) {
        $pdo = db();
        if ($pdo instanceof PDO) return $pdo;
    }
    if (function_exists('getDb')) {
        $pdo = getDb();
        if ($pdo instanceof PDO) return $pdo;
    }
    throw new RuntimeException('Keine PDO-Verbindung gefunden.');
}

function h(?string $v): string
{
    return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if (empty($_SESSION['image_credits_csrf'])) {
    $_SESSION['image_credits_csrf'] = bin2hex(random_bytes(32));
}

$pdo = creditsPdo();
$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['image_credits_csrf'], (string)($_POST['csrf'] ?? ''))) {
        http_response_code(403);
        $error = 'Ungültiges CSRF-Token.';
    } else {
        $action = (string)($_POST['action'] ?? 'save');
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) ?: 0;

        if ($action === 'delete' && $id > 0) {
            $stmt = $pdo->prepare('DELETE FROM image_credits WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $message = 'Eintrag gelöscht.';
        } else {
            $data = [
                'image_name' => trim((string)($_POST['image_name'] ?? '')),
                'image_path' => trim((string)($_POST['image_path'] ?? '')) ?: null,
                'credit_from' => trim((string)($_POST['credit_from'] ?? '')) ?: null,
                'credit_to' => trim((string)($_POST['credit_to'] ?? '')) ?: null,
                'page_name' => trim((string)($_POST['page_name'] ?? '')),
                'page_url' => trim((string)($_POST['page_url'] ?? '')) ?: null,
                'index_nr' => ($_POST['index_nr'] ?? '') !== '' ? (int)$_POST['index_nr'] : null,
                'author_name' => trim((string)($_POST['author_name'] ?? '')) ?: null,
                'author_url' => trim((string)($_POST['author_url'] ?? '')) ?: null,
                'source_name' => trim((string)($_POST['source_name'] ?? '')) ?: null,
                'source_url' => trim((string)($_POST['source_url'] ?? '')) ?: null,
                'license_name' => trim((string)($_POST['license_name'] ?? '')) ?: null,
                'license_url' => trim((string)($_POST['license_url'] ?? '')) ?: null,
                'note' => trim((string)($_POST['note'] ?? '')) ?: null,
                'active' => isset($_POST['active']) ? 1 : 0,
            ];

            if ($data['image_name'] === '' || $data['page_name'] === '') {
                $error = 'Bildname und Seite sind Pflichtfelder.';
            } elseif ($id > 0) {
                $data['id'] = $id;
                $sql = 'UPDATE image_credits SET image_name=:image_name,image_path=:image_path,credit_from=:credit_from,credit_to=:credit_to,page_name=:page_name,page_url=:page_url,index_nr=:index_nr,author_name=:author_name,author_url=:author_url,source_name=:source_name,source_url=:source_url,license_name=:license_name,license_url=:license_url,note=:note,active=:active WHERE id=:id';
                $pdo->prepare($sql)->execute($data);
                $message = 'Eintrag aktualisiert.';
            } else {
                $sql = 'INSERT INTO image_credits (image_name,image_path,credit_from,credit_to,page_name,page_url,index_nr,author_name,author_url,source_name,source_url,license_name,license_url,note,active) VALUES (:image_name,:image_path,:credit_from,:credit_to,:page_name,:page_url,:index_nr,:author_name,:author_url,:source_name,:source_url,:license_name,:license_url,:note,:active)';
                $pdo->prepare($sql)->execute($data);
                $message = 'Eintrag angelegt.';
            }
        }
    }
}

$edit = null;
$editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT) ?: 0;
if ($editId > 0) {
    $stmt = $pdo->prepare('SELECT * FROM image_credits WHERE id=:id');
    $stmt->execute(['id' => $editId]);
    $edit = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

$rows = $pdo->query('SELECT * FROM image_credits ORDER BY page_name,index_nr,image_name,id')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Bildnachweise verwalten</title>
<style>body{font-family:system-ui,sans-serif;margin:2rem;background:#f5f7fa;color:#17263a}main{max-width:1400px;margin:auto}.card{background:#fff;padding:1.2rem;border-radius:12px;margin-bottom:1.5rem;box-shadow:0 2px 12px #0001}.grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:1rem}label{display:block;font-weight:700}input,textarea{width:100%;box-sizing:border-box;padding:.65rem;margin-top:.3rem}textarea{min-height:90px}.full{grid-column:1/-1}button,.button{display:inline-block;padding:.65rem 1rem;border:0;border-radius:7px;background:#173b63;color:#fff;text-decoration:none;cursor:pointer}table{width:100%;border-collapse:collapse}th,td{padding:.65rem;border-bottom:1px solid #ddd;text-align:left;vertical-align:top}.danger{background:#a32626}.msg{padding:1rem;border-radius:8px;background:#e7f6eb}.err{padding:1rem;border-radius:8px;background:#fde8e8}@media(max-width:900px){.grid{grid-template-columns:1fr}.table-wrap{overflow:auto}}</style></head><body><main>
<h1>Bildnachweise verwalten</h1>
<?php if($message): ?><p class="msg"><?=h($message)?></p><?php endif; ?>
<?php if($error): ?><p class="err"><?=h($error)?></p><?php endif; ?>
<section class="card"><h2><?= $edit ? 'Eintrag bearbeiten' : 'Eintrag anlegen' ?></h2>
<form method="post"><input type="hidden" name="csrf" value="<?=h($_SESSION['image_credits_csrf'])?>"><input type="hidden" name="id" value="<?= (int)($edit['id'] ?? 0) ?>">
<div class="grid">
<label>Bildname *<input name="image_name" required value="<?=h($edit['image_name'] ?? '')?>"></label>
<label>Bildpfad<input name="image_path" value="<?=h($edit['image_path'] ?? '')?>"></label>
<label>Index-Nr.<input type="number" min="0" name="index_nr" value="<?=h(isset($edit['index_nr']) ? (string)$edit['index_nr'] : '')?>"></label>
<label>Von<input name="credit_from" value="<?=h($edit['credit_from'] ?? '')?>"></label>
<label>Bis<input name="credit_to" value="<?=h($edit['credit_to'] ?? '')?>"></label>
<label>Seite *<input name="page_name" required value="<?=h($edit['page_name'] ?? '')?>"></label>
<label>Seiten-URL<input name="page_url" value="<?=h($edit['page_url'] ?? '')?>"></label>
<label>Urheber<input name="author_name" value="<?=h($edit['author_name'] ?? '')?>"></label>
<label>Urheber-URL<input name="author_url" value="<?=h($edit['author_url'] ?? '')?>"></label>
<label>Quelle<input name="source_name" value="<?=h($edit['source_name'] ?? '')?>"></label>
<label>Quellen-URL<input name="source_url" value="<?=h($edit['source_url'] ?? '')?>"></label>
<label>Lizenz<input name="license_name" value="<?=h($edit['license_name'] ?? '')?>"></label>
<label>Lizenz-URL<input name="license_url" value="<?=h($edit['license_url'] ?? '')?>"></label>
<label class="full">Bemerkung<textarea name="note"><?=h($edit['note'] ?? '')?></textarea></label>
<label><input type="checkbox" name="active" value="1" <?= !isset($edit['active']) || (int)$edit['active']===1 ? 'checked' : '' ?>> aktiv</label>
</div><p><button type="submit" name="action" value="save">Speichern</button> <a class="button" href="image-credits.php">Neu / Abbrechen</a></p></form></section>
<section class="card"><h2>Vorhandene Einträge</h2><div class="table-wrap"><table><thead><tr><th>ID</th><th>Index</th><th>Bild</th><th>Von</th><th>Bis</th><th>Seite</th><th>Urheber</th><th>Aktiv</th><th>Aktion</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?= (int)$r['id'] ?></td><td><?=h($r['index_nr']===null?'–':(string)$r['index_nr'])?></td><td><?=h($r['image_name'])?></td><td><?=h($r['credit_from'])?></td><td><?=h($r['credit_to'])?></td><td><?=h($r['page_name'])?></td><td><?=h($r['author_name'])?></td><td><?= (int)$r['active']===1?'ja':'nein' ?></td><td><a class="button" href="?edit=<?=(int)$r['id']?>">Bearbeiten</a> <form method="post" style="display:inline" onsubmit="return confirm('Eintrag wirklich löschen?')"><input type="hidden" name="csrf" value="<?=h($_SESSION['image_credits_csrf'])?>"><input type="hidden" name="id" value="<?=(int)$r['id']?>"><button class="danger" name="action" value="delete">Löschen</button></form></td></tr><?php endforeach; ?>
</tbody></table></div></section>
</main></body></html>
