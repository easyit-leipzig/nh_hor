<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');

$allowedRoles = ['admin', 'company', 'personal', 'tutor', 'other'];
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
                throw new RuntimeException('Ungültige Rollen-ID.');
            }
            $stmt = db()->prepare('DELETE FROM imprint_roles WHERE id = :id');
            $stmt->execute(['id' => $id]);
            admin_log('delete', 'imprint_role', $id);
            header('Location: ' . app_path('/admin/imprint-roles.php?result=deleted'), true, 303);
            exit;
        }

        $role = trim((string)($_POST['role'] ?? ''));
        if (!in_array($role, $allowedRoles, true)) {
            throw new RuntimeException('Unzulässige Rolle. Erlaubt sind admin, company, personal, tutor und other.');
        }

        if ($id) {
            $stmt = db()->prepare('UPDATE imprint_roles SET role = :role WHERE id = :id');
            $stmt->execute(['role' => $role, 'id' => $id]);
            admin_log('update', 'imprint_role', $id, ['role' => $role]);
            $result = 'updated';
        } else {
            $stmt = db()->prepare('INSERT INTO imprint_roles (role) VALUES (:role)');
            $stmt->execute(['role' => $role]);
            $id = (int)db()->lastInsertId();
            admin_log('create', 'imprint_role', $id, ['role' => $role]);
            $result = 'created';
        }

        header('Location: ' . app_path('/admin/imprint-roles.php?result=' . $result), true, 303);
        exit;
    } catch (PDOException $e) {
        $error = $e->getCode() === '23000'
            ? 'Die Rolle ist bereits vorhanden oder wird noch von einer Person verwendet.'
            : 'Die Rolle konnte nicht gespeichert werden.';
        error_log('Impressumsrolle: ' . $e->getMessage());
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$roles = db_available()
    ? db()->query('SELECT r.id, r.role, COUNT(p.id) AS person_count FROM imprint_roles r LEFT JOIN imprint_persons p ON p.to_role = r.id GROUP BY r.id, r.role ORDER BY FIELD(r.role,\'admin\',\'company\',\'personal\',\'tutor\',\'other\'), r.id')->fetchAll()
    : [];

$adminTitle = 'Impressumsrollen';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions"><h1 style="margin-right:auto">Impressumsrollen</h1><a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-persons.php')) ?>">Personen verwalten</a></div>
<p>Verwaltung der zulässigen Rollen für Impressum und Adressnennung.</p>
<?php if ($notice): ?><p class="admin-notice admin-notice--success">Änderung gespeichert.</p><?php endif; ?>
<?php if ($error): ?><p class="admin-notice admin-notice--error"><?= admin_e($error) ?></p><?php endif; ?>

<section class="admin-card" style="margin-bottom:2rem">
  <h2>Rolle anlegen</h2>
  <form method="post" class="admin-form admin-form--columns">
    <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
    <input type="hidden" name="action" value="save">
    <label>Rolle
      <select name="role" required>
        <?php foreach ($allowedRoles as $role): ?><option value="<?= admin_e($role) ?>"><?= admin_e($role) ?></option><?php endforeach; ?>
      </select>
    </label>
    <button class="admin-btn admin-btn--gold" type="submit">Anlegen</button>
  </form>
</section>

<table class="admin-table">
<thead><tr><th>ID</th><th>Rolle</th><th>Personen</th><th>Bearbeiten</th><th>Löschen</th></tr></thead>
<tbody>
<?php foreach ($roles as $role): ?>
<tr>
  <td><?= (int)$role['id'] ?></td>
  <td><strong><?= admin_e((string)$role['role']) ?></strong></td>
  <td><?= (int)$role['person_count'] ?></td>
  <td>
    <form method="post" class="admin-inline-form">
      <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" value="<?= (int)$role['id'] ?>">
      <select name="role" required>
        <?php foreach ($allowedRoles as $allowed): ?><option value="<?= admin_e($allowed) ?>"<?= $allowed === $role['role'] ? ' selected' : '' ?>><?= admin_e($allowed) ?></option><?php endforeach; ?>
      </select>
      <button class="admin-btn" type="submit">Speichern</button>
    </form>
  </td>
  <td>
    <form method="post" class="admin-inline-form" onsubmit="return confirm('Rolle wirklich löschen?');">
      <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
      <input type="hidden" name="action" value="delete">
      <input type="hidden" name="id" value="<?= (int)$role['id'] ?>">
      <button class="admin-btn admin-btn--danger" type="submit"<?= (int)$role['person_count'] > 0 ? ' disabled title="Rolle wird verwendet"' : '' ?>>Löschen</button>
    </form>
  </td>
</tr>
<?php endforeach; ?>
</tbody></table>
<?php require __DIR__ . '/includes/footer.php'; ?>
