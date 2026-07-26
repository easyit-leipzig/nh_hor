<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');

$error = '';
$notice = (string)($_GET['result'] ?? '');
$contactTypes = [
    'phone' => 'Telefon',
    'mobile' => 'Mobiltelefon',
    'fax' => 'Fax',
    'email' => 'E-Mail',
    'http' => 'Webseite (HTTP/HTTPS)',
    'whatsapp' => 'WhatsApp',
    'signal' => 'Signal',
    'telegram' => 'Telegram',
    'linkedin' => 'LinkedIn',
    'xing' => 'Xing',
    'facebook' => 'Facebook',
    'instagram' => 'Instagram',
    'youtube' => 'YouTube',
    'github' => 'GitHub',
    'other' => 'Sonstiger Kontakt',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
        http_response_code(403);
        exit('Ungültige Anfrage.');
    }

    try {
        $action = (string)($_POST['action'] ?? 'save');
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;

        if ($action === 'delete') {
            if (!$id) {
                throw new RuntimeException('Ungültige Kontakt-ID.');
            }
            $stmt = db()->prepare('DELETE FROM contacts WHERE id=:id');
            $stmt->execute(['id' => $id]);
            admin_log('delete', 'contact', $id);
            header('Location: ' . app_path('/admin/imprint-contacts.php?result=deleted'), true, 303);
            exit;
        }

        $toPerson = filter_var($_POST['to_person'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;
        $type = strtolower(trim((string)($_POST['type'] ?? '')));
        $label = trim((string)($_POST['label'] ?? ''));
        $contactValue = trim((string)($_POST['contact_value'] ?? ''));
        $notes = trim((string)($_POST['notes'] ?? ''));
        $sortOrder = filter_var($_POST['sort_order'] ?? 100, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 100000]]);
        $active = isset($_POST['active']) ? 1 : 0;
        $isPrimary = isset($_POST['is_primary']) ? 1 : 0;

        if (!$toPerson) throw new RuntimeException('Bitte eine Person auswählen.');
        if (!preg_match('/^[a-z][a-z0-9_-]{1,39}$/', $type)) throw new RuntimeException('Der Kontakttyp ist ungültig.');
        if ($contactValue === '') throw new RuntimeException('Bitte einen Kontaktwert angeben.');
        if (mb_strlen($label) > 120 || mb_strlen($contactValue) > 500 || mb_strlen($notes) > 500) {
            throw new RuntimeException('Ein Eingabefeld überschreitet die zulässige Länge.');
        }
        if ($sortOrder === false) throw new RuntimeException('Die Sortierung muss zwischen 0 und 100000 liegen.');

        $personCheck = db()->prepare('SELECT COUNT(*) FROM imprint_persons WHERE id=:id');
        $personCheck->execute(['id' => $toPerson]);
        if ((int)$personCheck->fetchColumn() !== 1) throw new RuntimeException('Die ausgewählte Person existiert nicht.');

        if ($type === 'email' && !filter_var($contactValue, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Bitte eine gültige E-Mail-Adresse angeben.');
        }
        if ($type === 'http' && !filter_var($contactValue, FILTER_VALIDATE_URL)) {
            throw new RuntimeException('Bitte eine vollständige HTTP- oder HTTPS-URL angeben.');
        }

        $dates = [];
        foreach (['valid_from', 'valid_until'] as $field) {
            $raw = trim((string)($_POST[$field] ?? ''));
            if ($raw !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)) {
                throw new RuntimeException('Ungültiges Datumsformat.');
            }
            $dates[$field] = $raw !== '' ? $raw : null;
        }
        if ($dates['valid_from'] && $dates['valid_until'] && $dates['valid_until'] < $dates['valid_from']) {
            throw new RuntimeException('Das Gültigkeitsende darf nicht vor dem Beginn liegen.');
        }

        $pdo = db();
        $pdo->beginTransaction();
        if ($isPrimary === 1) {
            $sql = 'UPDATE contacts SET is_primary=0 WHERE to_person=:to_person AND type=:type';
            $params = ['to_person' => $toPerson, 'type' => $type];
            if ($id) {
                $sql .= ' AND id<>:id';
                $params['id'] = $id;
            }
            $clear = $pdo->prepare($sql);
            $clear->execute($params);
        }

        $params = [
            'to_person' => $toPerson,
            'type' => $type,
            'label' => $label,
            'contact_value' => $contactValue,
            'active' => $active,
            'is_primary' => $isPrimary,
            'sort_order' => $sortOrder,
            'valid_from' => $dates['valid_from'],
            'valid_until' => $dates['valid_until'],
            'notes' => $notes,
        ];

        if ($id) {
            $params['id'] = $id;
            $stmt = $pdo->prepare('UPDATE contacts SET to_person=:to_person,type=:type,label=:label,contact_value=:contact_value,active=:active,is_primary=:is_primary,sort_order=:sort_order,valid_from=:valid_from,valid_until=:valid_until,notes=:notes WHERE id=:id');
            $stmt->execute($params);
            $result = 'updated';
        } else {
            $stmt = $pdo->prepare('INSERT INTO contacts (to_person,type,label,contact_value,active,is_primary,sort_order,valid_from,valid_until,notes) VALUES (:to_person,:type,:label,:contact_value,:active,:is_primary,:sort_order,:valid_from,:valid_until,:notes)');
            $stmt->execute($params);
            $id = (int)$pdo->lastInsertId();
            $result = 'created';
        }
        $pdo->commit();
        admin_log($result === 'created' ? 'create' : 'update', 'contact', $id, ['to_person' => $toPerson, 'type' => $type]);
        header('Location: ' . app_path('/admin/imprint-contacts.php?result=' . $result), true, 303);
        exit;
    } catch (PDOException $e) {
        if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) $pdo->rollBack();
        $error = 'Der Kontakt konnte nicht gespeichert werden.';
        error_log('Kontaktverwaltung: ' . $e->getMessage());
    } catch (Throwable $e) {
        if (isset($pdo) && $pdo instanceof PDO && $pdo->inTransaction()) $pdo->rollBack();
        $error = $e->getMessage();
    }
}

$persons = db_available() ? db()->query("SELECT p.id,p.salutation,p.title,p.firstname,p.lastname,r.role FROM imprint_persons p JOIN imprint_roles r ON r.id=p.to_role ORDER BY p.lastname,p.firstname,p.id")->fetchAll() : [];
$contacts = db_available() ? db()->query("SELECT c.*,p.salutation,p.title,p.firstname,p.lastname,r.role FROM contacts c JOIN imprint_persons p ON p.id=c.to_person JOIN imprint_roles r ON r.id=p.to_role ORDER BY p.lastname,p.firstname,c.sort_order,c.type,c.id")->fetchAll() : [];

function contact_person_label(array $p): string {
    return trim(implode(' ', array_filter([(string)$p['salutation'], (string)$p['title'], (string)$p['firstname'], (string)$p['lastname']]))) . ' [' . (string)$p['role'] . ']';
}

$adminTitle = 'Kontakte';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions"><h1 style="margin-right:auto">Kontakte</h1><a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-persons.php')) ?>">Personen verwalten</a></div>
<p>Telefonnummern, E-Mail-Adressen, Webseiten und weitere Kontaktwege personengebunden verwalten.</p>
<?php if ($notice): ?><p class="admin-notice admin-notice--success">Änderung gespeichert.</p><?php endif; ?>
<?php if ($error): ?><p class="admin-notice admin-notice--error"><?= admin_e($error) ?></p><?php endif; ?>

<section class="admin-card" style="margin-bottom:2rem">
<h2>Kontakt anlegen</h2>
<form method="post" class="admin-form admin-form--columns">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="save">
<label>Person<select name="to_person" required><option value="">Bitte wählen</option><?php foreach($persons as $p): ?><option value="<?= (int)$p['id'] ?>"><?= admin_e(contact_person_label($p)) ?></option><?php endforeach; ?></select></label>
<label>Typ<select name="type" required><?php foreach($contactTypes as $value=>$label): ?><option value="<?= admin_e($value) ?>"><?= admin_e($label) ?></option><?php endforeach; ?></select></label>
<label>Bezeichnung<input name="label" maxlength="120" placeholder="Büro, Mobil, Support …"></label>
<label>Kontaktwert<input name="contact_value" maxlength="500" required placeholder="+49 …, info@…, https://…"></label>
<label>Sortierung<input name="sort_order" type="number" min="0" max="100000" value="100" required></label>
<label>Gültig ab<input name="valid_from" type="date"></label>
<label>Gültig bis<input name="valid_until" type="date"></label>
<label>Notiz<input name="notes" maxlength="500"></label>
<label><input name="active" type="checkbox" value="1" checked> Aktiv</label>
<label><input name="is_primary" type="checkbox" value="1"> Primärkontakt dieser Person und dieses Typs</label>
<button class="admin-btn admin-btn--gold" type="submit">Kontakt anlegen</button>
</form>
</section>

<?php foreach($contacts as $c): ?>
<section class="admin-card" style="margin-bottom:1.5rem">
<form method="post" class="admin-form admin-form--columns">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
<label>Person<select name="to_person" required><?php foreach($persons as $p): ?><option value="<?= (int)$p['id'] ?>"<?= (int)$p['id']===(int)$c['to_person']?' selected':'' ?>><?= admin_e(contact_person_label($p)) ?></option><?php endforeach; ?></select></label>
<label>Typ<select name="type" required><?php $typesForRow=$contactTypes; if(!isset($typesForRow[$c['type']])) $typesForRow[$c['type']]=(string)$c['type']; foreach($typesForRow as $value=>$label): ?><option value="<?= admin_e((string)$value) ?>"<?= (string)$value===(string)$c['type']?' selected':'' ?>><?= admin_e((string)$label) ?></option><?php endforeach; ?></select></label>
<label>Bezeichnung<input name="label" maxlength="120" value="<?= admin_e((string)$c['label']) ?>"></label>
<label>Kontaktwert<input name="contact_value" maxlength="500" required value="<?= admin_e((string)$c['contact_value']) ?>"></label>
<label>Sortierung<input name="sort_order" type="number" min="0" max="100000" value="<?= (int)$c['sort_order'] ?>" required></label>
<label>Gültig ab<input name="valid_from" type="date" value="<?= admin_e((string)$c['valid_from']) ?>"></label>
<label>Gültig bis<input name="valid_until" type="date" value="<?= admin_e((string)$c['valid_until']) ?>"></label>
<label>Notiz<input name="notes" maxlength="500" value="<?= admin_e((string)$c['notes']) ?>"></label>
<label><input name="active" type="checkbox" value="1"<?= (int)$c['active']===1?' checked':'' ?>> Aktiv</label>
<label><input name="is_primary" type="checkbox" value="1"<?= (int)$c['is_primary']===1?' checked':'' ?>> Primärkontakt</label>
<button class="admin-btn" type="submit">Speichern</button>
</form>
<form method="post" class="admin-inline-form" onsubmit="return confirm('Kontakt wirklich löschen?');">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$c['id'] ?>"><button class="admin-btn admin-btn--danger" type="submit">Löschen</button>
</form>
</section>
<?php endforeach; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
