<?php
declare(strict_types=1);

require __DIR__ . '/includes/admin-functions.php';
require_once __DIR__ . '/../includes/offer-repository.php';
admin_require_login();

if (!admin_has_role('admin') && !admin_has_role('editor')) {
    http_response_code(403);
    exit('Keine Berechtigung für die Angebotsverwaltung.');
}

$error = '';
$notice = (string)($_GET['result'] ?? '');
$editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;

function offer_admin_lines(string $value): array
{
    $lines = preg_split('/\R/u', $value) ?: [];
    return array_values(array_filter(array_map('trim', $lines), static fn(string $line): bool => $line !== ''));
}

if (strtoupper((string)($_SERVER['REQUEST_METHOD'] ?? 'GET')) === 'POST') {
    admin_verify_csrf_or_abort();

    if (!db_available()) {
        $error = 'Die Datenbank ist nicht erreichbar.';
    } else {
        try {
            $action = (string)($_POST['action'] ?? 'save');
            $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;

            if ($action === 'delete') {
                if (!$id) {
                    throw new RuntimeException('Ungültiges Angebot.');
                }
                $stmt = db()->prepare('DELETE FROM offers WHERE id = :id');
                $stmt->execute(['id' => $id]);
                admin_log('delete', 'offer', $id);
                header('Location: ' . app_path('/admin/offers.php?result=deleted'), true, 303);
                exit;
            }

            $title = trim((string)($_POST['title'] ?? ''));
            $badge = trim((string)($_POST['badge'] ?? ''));
            $priceText = trim((string)($_POST['price_text'] ?? ''));
            $priceUnit = trim((string)($_POST['price_unit'] ?? ''));
            $description = trim((string)($_POST['description'] ?? ''));
            $footnote = trim((string)($_POST['footnote'] ?? ''));
            $sortOrder = (int)($_POST['sort_order'] ?? 100);
            $featured = isset($_POST['featured']) ? 1 : 0;
            $isActive = isset($_POST['is_active']) ? 1 : 0;
            $features = offer_admin_lines((string)($_POST['features'] ?? ''));

            $rawAmount = trim(str_replace(['.', ','], ['', '.'], (string)($_POST['price_amount'] ?? '')));
            $priceAmount = $rawAmount === '' ? null : filter_var($rawAmount, FILTER_VALIDATE_FLOAT);

            if ($title === '') {
                throw new RuntimeException('Der Angebotstitel darf nicht leer sein.');
            }
            if ($description === '') {
                throw new RuntimeException('Die Beschreibung darf nicht leer sein.');
            }
            if ($rawAmount !== '' && $priceAmount === false) {
                throw new RuntimeException('Der numerische Preis ist ungültig. Bitte beispielsweise 25,00 eingeben.');
            }
            if ($priceText === '' && $priceAmount === null) {
                throw new RuntimeException('Bitte entweder einen numerischen Preis oder einen freien Preistext eintragen.');
            }

            // Bei einem Zahlenpreis wird ein alter Platzhaltertext entfernt.
            // Freie Texte wie „kostenfrei“ oder „individuell“ werden nur ohne Zahlenpreis verwendet.
            if ($priceAmount !== null && $priceAmount !== false) {
                $priceText = '';
            }

            $params = [
                'badge' => $badge,
                'title' => $title,
                'price_amount' => $priceAmount,
                'price_text' => $priceText,
                'price_unit' => $priceUnit,
                'description' => $description,
                'features_json' => json_encode($features, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                'footnote' => $footnote !== '' ? $footnote : null,
                'featured' => $featured,
                'is_active' => $isActive,
                'sort_order' => $sortOrder,
            ];

            if ($id) {
                $params['id'] = $id;
                $stmt = db()->prepare(
                    'UPDATE offers SET badge=:badge,title=:title,price_amount=:price_amount,price_text=:price_text,price_unit=:price_unit,description=:description,features_json=:features_json,footnote=:footnote,featured=:featured,is_active=:is_active,sort_order=:sort_order WHERE id=:id'
                );
                $stmt->execute($params);
                admin_log('update', 'offer', $id, ['title' => $title]);
            } else {
                $stmt = db()->prepare(
                    'INSERT INTO offers (badge,title,price_amount,price_text,price_unit,description,features_json,footnote,featured,is_active,sort_order) VALUES (:badge,:title,:price_amount,:price_text,:price_unit,:description,:features_json,:footnote,:featured,:is_active,:sort_order)'
                );
                $stmt->execute($params);
                $id = (int)db()->lastInsertId();
                admin_log('create', 'offer', $id, ['title' => $title]);
            }

            header('Location: ' . app_path('/admin/offers.php?result=saved'), true, 303);
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
        $items = offer_list(false);
        if ($editId) {
            $editing = offer_find((int)$editId);
            if (!$editing) {
                $error = 'Das ausgewählte Angebot wurde nicht gefunden.';
            }
        }
    } catch (Throwable $e) {
        $error = 'Die Angebotstabelle fehlt. Bitte database/migrations/2026-07-28_offers.sql importieren.';
    }
}

$form = $editing ?? [
    'id' => null,
    'badge' => '',
    'title' => '',
    'price_amount' => null,
    'price_text' => '',
    'price_unit' => '/ 60 Minuten',
    'description' => '',
    'features' => [],
    'footnote' => '',
    'featured' => 0,
    'is_active' => 1,
    'sort_order' => 100,
];

$adminTitle = 'Angebote und Preise';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions">
    <h1 style="margin-right:auto">Angebote und Preise</h1>
    <?php if ($editing): ?><a class="admin-btn" href="<?= admin_e(app_path('/admin/offers.php')) ?>">Neues Angebot</a><?php endif; ?>
    <a class="admin-btn" href="<?= admin_e(app_path('/preise.php?stand=' . time())) ?>" target="_blank" rel="noopener">Preisseite ansehen</a>
</div>

<p>Hier werden alle Angebotskarten der öffentlichen Seite <code>preise.php</code> angelegt, bearbeitet, sortiert, veröffentlicht oder gelöscht.</p>

<?php if ($notice === 'saved'): ?><p class="admin-notice admin-notice--success">Angebot gespeichert.</p><?php endif; ?>
<?php if ($notice === 'deleted'): ?><p class="admin-notice admin-notice--success">Angebot gelöscht.</p><?php endif; ?>
<?php if ($error !== ''): ?><p class="admin-notice admin-notice--error"><?= admin_e($error) ?></p><?php endif; ?>

<section class="admin-card" style="margin-bottom:2rem">
    <h2><?= $editing ? 'Angebot bearbeiten' : 'Neues Angebot anlegen' ?></h2>
    <form method="post" action="<?= admin_e(app_path('/admin/offers.php' . ($editing ? '?edit=' . (int)$editing['id'] : ''))) ?>">
        <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
        <input type="hidden" name="action" value="save">
        <?php if ($editing): ?><input type="hidden" name="id" value="<?= (int)$editing['id'] ?>"><?php endif; ?>

        <div class="admin-grid">
            <label>Kennzeichnung / Badge
                <input name="badge" maxlength="80" value="<?= admin_e((string)$form['badge']) ?>" placeholder="z. B. Kernangebot">
            </label>
            <label>Angebotstitel
                <input required name="title" maxlength="160" value="<?= admin_e((string)$form['title']) ?>" placeholder="z. B. Einzelunterricht">
            </label>
            <label>Numerischer Preis in Euro
                <input name="price_amount" inputmode="decimal" value="<?= $form['price_amount'] !== null ? admin_e(number_format((float)$form['price_amount'], 2, ',', '')) : '' ?>" placeholder="z. B. 25,00">
            </label>
            <label>Preiseinheit
                <input name="price_unit" maxlength="120" value="<?= admin_e((string)$form['price_unit']) ?>" placeholder="z. B. / 60 Minuten">
            </label>
            <label>Freier Preistext
                <input name="price_text" maxlength="120" value="<?= admin_e((string)$form['price_text']) ?>" placeholder="z. B. kostenfrei oder individuell">
                <small>Nur verwenden, wenn kein Zahlenpreis eingetragen wird, z. B. „kostenfrei“ oder „individuell“.</small>
            </label>
            <label>Sortierung
                <input type="number" name="sort_order" value="<?= (int)$form['sort_order'] ?>">
            </label>
        </div>

        <label>Beschreibung
            <textarea required name="description" rows="4"><?= admin_e((string)$form['description']) ?></textarea>
        </label>

        <label>Leistungsmerkmale – ein Eintrag je Zeile
            <textarea name="features" rows="6" placeholder="persönlicher Schwerpunkt&#10;flexible Fachinhalte&#10;gezielte Rückmeldung"><?= admin_e(implode("\n", (array)$form['features'])) ?></textarea>
        </label>

        <label>Fußnote / Zusatzhinweis
            <textarea name="footnote" rows="3"><?= admin_e((string)($form['footnote'] ?? '')) ?></textarea>
        </label>

        <p>
            <label><input type="checkbox" name="featured" value="1" <?= (int)$form['featured'] === 1 ? 'checked' : '' ?>> Als Kernangebot hervorheben</label><br>
            <label><input type="checkbox" name="is_active" value="1" <?= (int)$form['is_active'] === 1 ? 'checked' : '' ?>> Auf der Preisseite veröffentlichen</label>
        </p>

        <div class="admin-actions">
            <button class="admin-btn admin-btn--gold" type="submit">Angebot speichern</button>
            <?php if ($editing): ?><a class="admin-btn" href="<?= admin_e(app_path('/admin/offers.php')) ?>">Abbrechen</a><?php endif; ?>
        </div>
    </form>
</section>

<table class="admin-table">
    <thead><tr><th>Sortierung</th><th>Angebot</th><th>Preis</th><th>Status</th><th>Geändert</th><th>Hervorgehoben</th><th>Aktionen</th></tr></thead>
    <tbody>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= (int)$item['sort_order'] ?></td>
            <td><strong><?= admin_e((string)$item['title']) ?></strong><?php if ((string)$item['badge'] !== ''): ?><br><small><?= admin_e((string)$item['badge']) ?></small><?php endif; ?></td>
            <td><?= admin_e(offer_price_label($item)) ?></td>
            <td><?= (int)$item['is_active'] === 1 ? 'veröffentlicht' : 'inaktiv' ?></td>
            <td><?= admin_e(date('d.m.Y H:i', strtotime((string)$item['updated_at']))) ?></td>
            <td><?= (int)$item['featured'] === 1 ? 'ja' : 'nein' ?></td>
            <td class="admin-actions">
                <a class="admin-btn" href="<?= admin_e(app_path('/admin/offers.php?edit=' . (int)$item['id'])) ?>">Bearbeiten</a>
                <form method="post" action="<?= admin_e(app_path('/admin/offers.php')) ?>" class="admin-inline-form" onsubmit="return confirm('Angebot wirklich löschen?');">
                    <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                    <button class="admin-btn admin-btn--danger" type="submit">Löschen</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$items): ?><tr><td colspan="7">Noch keine Angebote vorhanden oder die Migration wurde noch nicht importiert.</td></tr><?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/includes/footer.php'; ?>
