<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
require_once __DIR__ . '/../includes/career-repository.php';
admin_require_role('admin');

$key = trim((string)($_GET['key'] ?? $_POST['job_key'] ?? ''));
$job = $key !== '' ? career_job($key, true) : null;
$errors = [];
$notice = '';

function career_lines(string $value): array {
    return array_values(array_filter(array_map('trim', preg_split('/\R/u', $value) ?: []), static fn(string $v): bool => $v !== ''));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf_or_abort();
    if (!career_tables_available()) $errors[] = 'Die Karriere-Datenbanktabellen wurden noch nicht importiert.';
    $data = [
        'job_key' => admin_slugify((string)($_POST['job_key'] ?? '')),
        'code' => strtoupper(trim((string)($_POST['code'] ?? ''))),
        'slug' => trim((string)($_POST['slug'] ?? '')),
        'title' => trim((string)($_POST['title'] ?? '')),
        'claim' => trim((string)($_POST['claim'] ?? '')),
        'intro' => trim((string)($_POST['intro'] ?? '')),
        'status' => in_array($_POST['status'] ?? '', ['draft','published','archived'], true) ? (string)$_POST['status'] : 'draft',
        'sort_order' => (int)($_POST['sort_order'] ?? 100),
    ];
    foreach (['job_key','code','slug','title','claim','intro'] as $required) if ($data[$required] === '') $errors[] = 'Pflichtfeld fehlt: ' . $required;
    if ($data['slug'] !== '' && !preg_match('/^[a-z0-9][a-z0-9._-]*\.php$/', $data['slug'])) $errors[] = 'Die URL-Datei muss z. B. karriere-deutsch.php lauten.';

    if (!$errors) {
        try {
            db()->beginTransaction();
            if ($job && isset($job['id'])) {
                $stmt = db()->prepare('UPDATE career_jobs SET job_key=:job_key,code=:code,slug=:slug,title=:title,claim=:claim,intro=:intro,status=:status,sort_order=:sort_order WHERE id=:id');
                $stmt->execute($data + ['id'=>(int)$job['id']]);
                $jobId = (int)$job['id'];
            } else {
                $stmt = db()->prepare('INSERT INTO career_jobs(job_key,code,slug,title,claim,intro,status,sort_order) VALUES(:job_key,:code,:slug,:title,:claim,:intro,:status,:sort_order)');
                $stmt->execute($data);
                $jobId = (int)db()->lastInsertId();
            }
            db()->prepare('DELETE FROM career_job_items WHERE career_job_id=:id')->execute(['id'=>$jobId]);
            $itemStmt = db()->prepare('INSERT INTO career_job_items(career_job_id,item_type,item_text,sort_order) VALUES(:id,:type,:text,:sort)');
            foreach (['subjects'=>'subject','values'=>'value','requirements'=>'requirement','profiles'=>'profile'] as $field=>$type) {
                foreach (career_lines((string)($_POST[$field] ?? '')) as $i=>$text) $itemStmt->execute(['id'=>$jobId,'type'=>$type,'text'=>$text,'sort'=>($i+1)*10]);
            }
            db()->prepare('DELETE FROM career_images WHERE career_job_id=:id')->execute(['id'=>$jobId]);
            $imageStmt = db()->prepare('INSERT INTO career_images(career_job_id,image_role,image_path,alt_text,caption,sort_order,is_active) VALUES(:id,:role,:path,:alt,:caption,:sort,1)');
            $paths = $_POST['image_path'] ?? []; $roles = $_POST['image_role'] ?? []; $alts = $_POST['image_alt'] ?? []; $captions = $_POST['image_caption'] ?? [];
            foreach ($paths as $i=>$path) {
                $path = trim((string)$path); if ($path === '') continue;
                $role = in_array($roles[$i] ?? '', ['hero','card','gallery'], true) ? (string)$roles[$i] : 'gallery';
                $imageStmt->execute(['id'=>$jobId,'role'=>$role,'path'=>$path,'alt'=>trim((string)($alts[$i] ?? '')),'caption'=>trim((string)($captions[$i] ?? '')),'sort'=>($i+1)*10]);
            }
            db()->prepare('DELETE FROM career_faq WHERE career_job_id=:id')->execute(['id'=>$jobId]);
            $faqStmt = db()->prepare('INSERT INTO career_faq(career_job_id,question,answer,sort_order,is_active) VALUES(:id,:q,:a,:sort,1)');
            $questions = $_POST['faq_q'] ?? []; $answers = $_POST['faq_a'] ?? [];
            foreach ($questions as $i=>$q) { $q=trim((string)$q); $a=trim((string)($answers[$i]??'')); if($q!==''&&$a!=='') $faqStmt->execute(['id'=>$jobId,'q'=>$q,'a'=>$a,'sort'=>($i+1)*10]); }
            db()->commit();
            admin_log('save','career_job',$jobId,['job_key'=>$data['job_key']]);
            header('Location: ' . app_path('/admin/career-job-edit.php?key=' . rawurlencode($data['job_key']) . '&saved=1'), true, 303); exit;
        } catch (Throwable $e) {
            if (db()->inTransaction()) db()->rollBack();
            error_log('[career admin save] '.$e->getMessage());
            $errors[] = 'Speichern fehlgeschlagen. Job-Key und URL müssen eindeutig sein.';
        }
    }
    $job = array_replace($job ?? [], $data, [
        'subjects'=>career_lines((string)($_POST['subjects']??'')), 'values'=>career_lines((string)($_POST['values']??'')),
        'requirements'=>career_lines((string)($_POST['requirements']??'')), 'profiles'=>career_lines((string)($_POST['profiles']??'')),
    ]);
}
if (isset($_GET['saved'])) $notice = 'Stellenprofil wurde gespeichert.';
$job ??= ['job_key'=>'','code'=>'','slug'=>'karriere-.php','title'=>'','claim'=>'','intro'=>'','status'=>'draft','sort_order'=>100,'subjects'=>[],'values'=>[],'requirements'=>[],'profiles'=>[],'detail_images'=>[],'faq'=>[]];
$images = $job['detail_images'] ?? $job['images'] ?? [];
while (count($images) < 5) $images[] = ['src'=>'','alt'=>'','caption'=>''];
$faqs = $job['faq'] ?? [];
while (count($faqs) < 4) $faqs[] = ['q'=>'','a'=>''];
$adminTitle = 'Karriereprofil bearbeiten';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions"><h1 style="margin-right:auto">Karriereprofil bearbeiten</h1><a class="admin-btn" href="<?= admin_e(app_path('/admin/career-jobs.php')) ?>">Zur Übersicht</a></div>
<?php if ($notice): ?><div class="admin-alert"><?= admin_e($notice) ?></div><?php endif; ?>
<?php foreach ($errors as $error): ?><div class="admin-alert"><?= admin_e($error) ?></div><?php endforeach; ?>
<form method="post" class="admin-card">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
<div class="admin-grid">
<label>Job-Key<input name="job_key" required value="<?= admin_e((string)($job['job_key'] ?? $key)) ?>"></label>
<label>Kürzel<input name="code" required value="<?= admin_e((string)$job['code']) ?>"></label>
<label>Seitendatei<input name="slug" required value="<?= admin_e((string)$job['slug']) ?>"></label>
<label>Reihenfolge<input type="number" name="sort_order" value="<?= (int)($job['sort_order'] ?? 100) ?>"></label>
<label>Status<select name="status"><option value="draft"<?= ($job['status']??'')==='draft'?' selected':'' ?>>Entwurf</option><option value="published"<?= ($job['status']??'')==='published'?' selected':'' ?>>Veröffentlicht</option><option value="archived"<?= ($job['status']??'')==='archived'?' selected':'' ?>>Archiviert</option></select></label>
</div>
<label>Titel<input name="title" required value="<?= admin_e((string)$job['title']) ?>"></label>
<label>Slogan<input name="claim" required value="<?= admin_e((string)$job['claim']) ?>"></label>
<label>Einleitung<textarea name="intro" rows="4" required><?= admin_e((string)$job['intro']) ?></textarea></label>
<div class="admin-grid">
<label>Fächer – eine Zeile je Eintrag<textarea name="subjects" rows="7"><?= admin_e(implode("\n", $job['subjects'] ?? [])) ?></textarea></label>
<label>Werte – eine Zeile je Eintrag<textarea name="values" rows="7"><?= admin_e(implode("\n", $job['values'] ?? [])) ?></textarea></label>
<label>Anforderungen – eine Zeile je Eintrag<textarea name="requirements" rows="7"><?= admin_e(implode("\n", $job['requirements'] ?? [])) ?></textarea></label>
<label>Passende Profile – eine Zeile je Eintrag<textarea name="profiles" rows="7"><?= admin_e(implode("\n", $job['profiles'] ?? [])) ?></textarea></label>
</div>
<h2>Bildserie</h2><p>Bildpfade beginnen mit <code>/assets/…</code>. Rolle „Hero“ bestimmt das große Titelbild, „Card“ die Vorschau auf der Karrierestartseite.</p>
<?php foreach ($images as $i=>$image): ?><fieldset class="admin-card"><legend>Bild <?= $i+1 ?></legend><div class="admin-grid"><label>Rolle<select name="image_role[]"><option value="hero">Hero</option><option value="card"<?= $i<3?' selected':'' ?>>Card</option><option value="gallery"<?= $i>=3?' selected':'' ?>>Galerie</option></select></label><label>Pfad<input name="image_path[]" value="<?= admin_e((string)($image['src']??'')) ?>"></label><label>Alternativtext<input name="image_alt[]" value="<?= admin_e((string)($image['alt']??'')) ?>"></label><label>Bildunterschrift<input name="image_caption[]" value="<?= admin_e((string)($image['caption']??'')) ?>"></label></div></fieldset><?php endforeach; ?>
<h2>FAQ</h2>
<?php foreach ($faqs as $i=>$faq): ?><fieldset class="admin-card"><legend>Frage <?= $i+1 ?></legend><label>Frage<input name="faq_q[]" value="<?= admin_e((string)($faq['q']??'')) ?>"></label><label>Antwort<textarea name="faq_a[]" rows="3"><?= admin_e((string)($faq['a']??'')) ?></textarea></label></fieldset><?php endforeach; ?>
<button class="admin-btn" type="submit">Stellenprofil speichern</button>
</form>
<?php require __DIR__ . '/includes/footer.php'; ?>
