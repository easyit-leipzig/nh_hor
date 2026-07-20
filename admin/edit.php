<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
require __DIR__ . '/../includes/content-repository.php';
admin_require_login();

$allowed = ['faq','review','job','blog'];
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$item = null;

if ($id > 0 && db_available()) {
    $stmt = db()->prepare('SELECT * FROM content_items WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    $item = $stmt->fetch() ?: null;
}

$type = (string)($_GET['type'] ?? $_POST['content_type'] ?? ($item['content_type'] ?? 'faq'));
if (!in_array($type, $allowed, true)) {
    $type = 'faq';
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
        $error = 'Die Sitzung ist abgelaufen.';
    } elseif (!db_available()) {
        $error = 'Keine Datenbankverbindung.';
    } else {
        $user = admin_user();
        $title = sanitize_line((string)($_POST['title'] ?? ''));
        $slug = admin_slugify((string)($_POST['slug'] ?? $title));
        $excerpt = trim((string)($_POST['excerpt'] ?? ''));
        $body = trim((string)($_POST['body'] ?? ''));
        $metaTitle = sanitize_line((string)($_POST['meta_title'] ?? ''));
        $metaDescription = sanitize_line((string)($_POST['meta_description'] ?? ''));
        $reviewDate = $type === 'review' ? sanitize_line((string)($_POST['review_date'] ?? '')) : '';
        $reviewerName = $type === 'review' ? sanitize_line((string)($_POST['reviewer_name'] ?? '')) : '';
        $reviewerAge = $type === 'review' ? (int)($_POST['reviewer_age'] ?? 0) : 0;
        $reviewerSchoolType = $type === 'review' ? sanitize_line((string)($_POST['reviewer_school_type'] ?? '')) : '';
        $reviewDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $reviewDate) ? $reviewDate : null;
        $reviewerAge = ($reviewerAge >= 1 && $reviewerAge <= 120) ? $reviewerAge : null;
        $status = (string)($_POST['status'] ?? 'draft');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $featured = isset($_POST['featured']) ? 1 : 0;

        if ($title === '' || $slug === '' || $body === '') {
            $error = 'Titel, Slug und Inhalt sind erforderlich.';
        } elseif (!in_array($status, ['draft','published','archived'], true)) {
            $error = 'Ungültiger Status.';
        } else {
            $pdo = db();
            $pdo->beginTransaction();
            try {
                if ($id > 0 && $item) {
                    $rev = $pdo->prepare(
                        'INSERT INTO content_revisions
                         (content_item_id,title,excerpt,body,meta_title,meta_description,review_date,reviewer_name,reviewer_age,reviewer_school_type,status,changed_by)
                         VALUES (:id,:title,:excerpt,:body,:meta_title,:meta_description,:review_date,:reviewer_name,:reviewer_age,:reviewer_school_type,:status,:user)'
                    );
                    $rev->execute([
                        'id'=>$id,'title'=>$item['title'],'excerpt'=>$item['excerpt'],'body'=>$item['body'],
                        'meta_title'=>$item['meta_title'],'meta_description'=>$item['meta_description'],
                        'review_date'=>$item['review_date'] ?? null,'reviewer_name'=>$item['reviewer_name'] ?? null,
                        'reviewer_age'=>$item['reviewer_age'] ?? null,'reviewer_school_type'=>$item['reviewer_school_type'] ?? null,
                        'status'=>$item['status'],'user'=>$user['id']
                    ]);

                    $stmt = $pdo->prepare(
                        'UPDATE content_items SET
                         title=:title, slug=:slug, excerpt=:excerpt, body=:body,
                         meta_title=:meta_title, meta_description=:meta_description,
                         review_date=:review_date, reviewer_name=:reviewer_name, reviewer_age=:reviewer_age, reviewer_school_type=:reviewer_school_type,
                         status=:status, sort_order=:sort_order, featured=:featured,
                         published_at=CASE WHEN :status = "published" AND published_at IS NULL THEN NOW() ELSE published_at END,
                         updated_by=:user
                         WHERE id=:id'
                    );
                    $stmt->execute([
                        'title'=>$title,'slug'=>$slug,'excerpt'=>$excerpt,'body'=>$body,
                        'meta_title'=>$metaTitle,'meta_description'=>$metaDescription,
                        'review_date'=>$reviewDate,'reviewer_name'=>$reviewerName ?: null,'reviewer_age'=>$reviewerAge,'reviewer_school_type'=>$reviewerSchoolType ?: null,
                        'status'=>$status,'sort_order'=>$sortOrder,'featured'=>$featured,
                        'user'=>$user['id'],'id'=>$id
                    ]);
                    admin_log('update', $type, $id, ['status'=>$status]);
                    cms_forget_type_cache($type);
                } else {
                    $stmt = $pdo->prepare(
                        'INSERT INTO content_items
                         (content_type,title,slug,excerpt,body,meta_title,meta_description,review_date,reviewer_name,reviewer_age,reviewer_school_type,status,sort_order,featured,published_at,created_by,updated_by)
                         VALUES
                         (:type,:title,:slug,:excerpt,:body,:meta_title,:meta_description,:review_date,:reviewer_name,:reviewer_age,:reviewer_school_type,:status,:sort_order,:featured,
                          CASE WHEN :status = "published" THEN NOW() ELSE NULL END,:user,:user)'
                    );
                    $stmt->execute([
                        'type'=>$type,'title'=>$title,'slug'=>$slug,'excerpt'=>$excerpt,'body'=>$body,
                        'meta_title'=>$metaTitle,'meta_description'=>$metaDescription,
                        'review_date'=>$reviewDate,'reviewer_name'=>$reviewerName ?: null,'reviewer_age'=>$reviewerAge,'reviewer_school_type'=>$reviewerSchoolType ?: null,
                        'status'=>$status,'sort_order'=>$sortOrder,'featured'=>$featured,'user'=>$user['id']
                    ]);
                    $id = (int)$pdo->lastInsertId();
                    admin_log('create', $type, $id, ['status'=>$status]);
                    cms_forget_type_cache($type);
                }
                $pdo->commit();
                header('Location: ' . app_path('/admin/content.php?type=' . rawurlencode($type)), true, 303);
                exit;
            } catch (Throwable $e) {
                $pdo->rollBack();
                $error = 'Speichern fehlgeschlagen. Prüfe, ob der Slug bereits vergeben ist.';
            }
        }
    }
}

$adminTitle = $id > 0 ? 'Inhalt bearbeiten' : 'Neuer Inhalt';
require __DIR__ . '/includes/header.php';
?>
<h1><?= admin_e($adminTitle) ?></h1>
<?php if ($error): ?><div class="admin-alert"><?= admin_e($error) ?></div><?php endif; ?>
<form method="post" class="admin-form">
  <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
  <input type="hidden" name="id" value="<?= $id ?>">
  <input type="hidden" name="content_type" value="<?= admin_e($type) ?>">
  <label>Titel<input type="text" name="title" required value="<?= admin_e((string)($item['title'] ?? '')) ?>"></label>
  <label>Slug<input type="text" name="slug" value="<?= admin_e((string)($item['slug'] ?? '')) ?>" placeholder="wird aus Titel erzeugt"></label>
  <label>Kurztext<textarea name="excerpt" rows="3"><?= admin_e((string)($item['excerpt'] ?? '')) ?></textarea></label>
  <label>Inhalt<textarea name="body" rows="14" required><?= admin_e((string)($item['body'] ?? '')) ?></textarea></label>
  <label>SEO-Titel<input type="text" name="meta_title" value="<?= admin_e((string)($item['meta_title'] ?? '')) ?>"></label>
  <label>Meta-Beschreibung<textarea name="meta_description" rows="3"><?= admin_e((string)($item['meta_description'] ?? '')) ?></textarea></label>
  <?php if ($type === 'review'): ?>
  <fieldset class="admin-fieldset">
    <legend>Angaben unter der Bewertungskachel</legend>
    <label>Datum<input type="date" name="review_date" value="<?= admin_e((string)($item['review_date'] ?? '')) ?>"></label>
    <label>Name<input type="text" name="reviewer_name" maxlength="120" value="<?= admin_e((string)($item['reviewer_name'] ?? '')) ?>" placeholder="z. B. Lisa M."></label>
    <label>Alter<input type="number" name="reviewer_age" min="1" max="120" value="<?= admin_e((string)($item['reviewer_age'] ?? '')) ?>" placeholder="z. B. 15"></label>
    <label>Schulform<input type="text" name="reviewer_school_type" maxlength="120" value="<?= admin_e((string)($item['reviewer_school_type'] ?? '')) ?>" placeholder="z. B. Gymnasium"></label>
  </fieldset>
  <?php endif; ?>
  <label>Status<select name="status">
    <?php foreach (['draft'=>'Entwurf','published'=>'Veröffentlicht','archived'=>'Archiviert'] as $value=>$label): ?>
      <option value="<?= $value ?>" <?= (($item['status'] ?? 'draft') === $value) ? 'selected' : '' ?>><?= $label ?></option>
    <?php endforeach; ?>
  </select></label>
  <label>Sortierung<input type="number" name="sort_order" value="<?= (int)($item['sort_order'] ?? 0) ?>"></label>
  <label><input type="checkbox" name="featured" value="1" <?= !empty($item['featured']) ? 'checked' : '' ?>> Hervorheben</label>
  <div class="admin-actions">
    <button class="admin-btn admin-btn--gold" type="submit">Speichern</button>
    <a class="admin-btn" href="<?= admin_e(app_path('/admin/content.php?type=' . rawurlencode($type))) ?>">Abbrechen</a>
  </div>
</form>
<?php require __DIR__ . '/includes/footer.php'; ?>
