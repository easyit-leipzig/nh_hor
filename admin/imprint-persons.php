<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');

$error = '';
$notice = (string)($_GET['result'] ?? '');

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
                throw new RuntimeException('Ungültige Personen-ID.');
            }
            $stmt = db()->prepare('DELETE FROM imprint_persons WHERE id = :id');
            $stmt->execute(['id' => $id]);
            admin_log('delete', 'imprint_person', $id);
            header('Location: ' . app_path('/admin/imprint-persons.php?result=deleted'), true, 303);
            exit;
        }

        $toRole = filter_var($_POST['to_role'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?: null;
        $saturation = trim((string)($_POST['saturation'] ?? ''));
        $title = trim((string)($_POST['title'] ?? ''));
        $firstname = trim((string)($_POST['firstname'] ?? ''));
        $lastname = trim((string)($_POST['lastname'] ?? ''));

        if (!$toRole) throw new RuntimeException('Bitte eine Rolle auswählen.');
        if ($firstname === '' || mb_strlen($firstname) > 120) throw new RuntimeException('Bitte einen gültigen Vornamen angeben.');
        if ($lastname === '' || mb_strlen($lastname) > 120) throw new RuntimeException('Bitte einen gültigen Nachnamen angeben.');
        if (mb_strlen($saturation) > 40 || mb_strlen($title) > 120) throw new RuntimeException('Anrede oder Titel ist zu lang.');

        $roleCheck = db()->prepare('SELECT COUNT(*) FROM imprint_roles WHERE id = :id');
        $roleCheck->execute(['id' => $toRole]);
        if ((int)$roleCheck->fetchColumn() !== 1) throw new RuntimeException('Die ausgewählte Rolle existiert nicht.');

        $params = ['to_role'=>$toRole, 'saturation'=>$saturation, 'title'=>$title, 'firstname'=>$firstname, 'lastname'=>$lastname];
        if ($id) {
            $params['id'] = $id;
            $stmt = db()->prepare('UPDATE imprint_persons SET to_role=:to_role, saturation=:saturation, title=:title, firstname=:firstname, lastname=:lastname WHERE id=:id');
            $stmt->execute($params);
            admin_log('update', 'imprint_person', $id, ['to_role'=>$toRole]);
            $result = 'updated';
        } else {
            $stmt = db()->prepare('INSERT INTO imprint_persons (to_role, saturation, title, firstname, lastname) VALUES (:to_role, :saturation, :title, :firstname, :lastname)');
            $stmt->execute($params);
            $id = (int)db()->lastInsertId();
            admin_log('create', 'imprint_person', $id, ['to_role'=>$toRole]);
            $result = 'created';
        }
        header('Location: ' . app_path('/admin/imprint-persons.php?result=' . $result), true, 303);
        exit;
    } catch (PDOException $e) {
        $error = 'Die Person konnte nicht gespeichert werden.';
        error_log('Impressumsperson: ' . $e->getMessage());
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$roles = db_available() ? db()->query("SELECT id, role FROM imprint_roles ORDER BY FIELD(role,'admin','company','personal','tutor','other'), id")->fetchAll() : [];
$persons = db_available() ? db()->query("SELECT p.id, p.to_role, p.saturation, p.title, p.firstname, p.lastname, r.role FROM imprint_persons p JOIN imprint_roles r ON r.id=p.to_role ORDER BY FIELD(r.role,'admin','company','personal','tutor','other'), p.lastname, p.firstname, p.id")->fetchAll() : [];

$adminTitle = 'Impressumspersonen';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions"><h1 style="margin-right:auto">Impressumspersonen</h1><a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-roles.php')) ?>">Rollen verwalten</a></div>
<p>Personen und Namensformen den Rollen für Impressum und Adressnennung zuordnen.</p>
<?php if ($notice): ?><p class="admin-notice admin-notice--success">Änderung gespeichert.</p><?php endif; ?>
<?php if ($error): ?><p class="admin-notice admin-notice--error"><?= admin_e($error) ?></p><?php endif; ?>

<section class="admin-card" style="margin-bottom:2rem">
<h2>Person anlegen</h2>
<form method="post" class="admin-form admin-form--columns">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="save">
<label>Rolle<select name="to_role" required><option value="">Bitte wählen</option><?php foreach($roles as $role): ?><option value="<?= (int)$role['id'] ?>"><?= admin_e((string)$role['role']) ?></option><?php endforeach; ?></select></label>
<label>Anrede (`saturation`)<input name="saturation" maxlength="40" placeholder="Herr"></label>
<label>Titel<input name="title" maxlength="120" placeholder="Dipl.-Ing."></label>
<label>Vorname<input name="firstname" maxlength="120" required></label>
<label>Nachname<input name="lastname" maxlength="120" required></label>
<button class="admin-btn admin-btn--gold" type="submit">Anlegen</button>
</form>
</section>

<table class="admin-table"><thead><tr><th>ID</th><th>Rolle</th><th>Anrede</th><th>Titel</th><th>Vorname</th><th>Nachname</th><th>Aktionen</th></tr></thead><tbody>
<?php foreach($persons as $person): ?>
<tr><form method="post">
<td><?= (int)$person['id'] ?><input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int)$person['id'] ?>"></td>
<td><select name="to_role" required><?php foreach($roles as $role): ?><option value="<?= (int)$role['id'] ?>"<?= (int)$role['id']===(int)$person['to_role']?' selected':'' ?>><?= admin_e((string)$role['role']) ?></option><?php endforeach; ?></select></td>
<td><input name="saturation" maxlength="40" value="<?= admin_e((string)$person['saturation']) ?>"></td>
<td><input name="title" maxlength="120" value="<?= admin_e((string)$person['title']) ?>"></td>
<td><input name="firstname" maxlength="120" required value="<?= admin_e((string)$person['firstname']) ?>"></td>
<td><input name="lastname" maxlength="120" required value="<?= admin_e((string)$person['lastname']) ?>"></td>
<td><button class="admin-btn" type="submit">Speichern</button></form>
<form method="post" class="admin-inline-form" onsubmit="return confirm('Person wirklich löschen?');"><input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$person['id'] ?>"><button class="admin-btn admin-btn--danger" type="submit">Löschen</button></form></td>
</tr>
<?php endforeach; ?>
</tbody></table>
<?php require __DIR__ . '/includes/footer.php'; ?>
