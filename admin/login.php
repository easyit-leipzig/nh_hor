<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';

ensure_session_started();
if (admin_user()) {
    header('Location: /admin/index.php', true, 303);
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
        $error = 'Die Sitzung ist abgelaufen.';
    } elseif (admin_login(
        sanitize_line((string)($_POST['username'] ?? '')),
        (string)($_POST['password'] ?? '')
    )) {
        header('Location: /admin/index.php', true, 303);
        exit;
    } else {
        $error = 'Anmeldung fehlgeschlagen.';
    }
}

$adminTitle = 'Anmeldung';
require __DIR__ . '/includes/header.php';
?>
<section class="admin-login">
  <h1>Admin-Anmeldung</h1>
  <?php if (!db_available()): ?><div class="admin-alert">Die Datenbankverbindung ist noch nicht eingerichtet.</div><?php endif; ?>
  <?php if ($error): ?><div class="admin-alert"><?= admin_e($error) ?></div><?php endif; ?>
  <form method="post" class="admin-form">
    <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
    <label>Benutzername<input type="text" name="username" required autocomplete="username"></label>
    <label>Passwort<input type="password" name="password" required autocomplete="current-password"></label>
    <button class="admin-btn admin-btn--gold" type="submit">Anmelden</button>
  </form>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
