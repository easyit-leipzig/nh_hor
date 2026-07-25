<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';

ensure_session_started();
if (admin_user()) {
    header('Location: ' . app_path('/admin/index.php'), true, 303);
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_line((string)($_POST['username'] ?? ''));
    $status = login_rate_status($username);

    if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
        admin_log('login_denied_csrf', 'admin_session', null, ['username_hash' => hash('sha256', mb_strtolower($username))]);
        $error = 'Die Sitzung ist abgelaufen.';
    } elseif (!$status['allowed']) {
        admin_log('login_rate_limited', 'admin_session', null, [
            'username_hash' => hash('sha256', mb_strtolower($username)),
            'retry_after' => $status['retry_after'],
        ]);
        http_response_code(429);
        header('Retry-After: ' . max(60, (int)$status['retry_after']));
        $error = 'Zu viele Anmeldeversuche. Bitte versuchen Sie es später erneut.';
    } elseif (admin_login($username, (string)($_POST['password'] ?? ''))) {
        login_rate_clear($username);
        admin_log('login_success', 'admin_session', null, ['username' => $username]);
        header('Location: ' . app_path('/admin/index.php'), true, 303);
        exit;
    } else {
        $failure = login_rate_record_failure($username);
        admin_log('login_failed', 'admin_session', null, [
            'username_hash' => hash('sha256', mb_strtolower($username)),
            'attempts' => $failure['attempts'],
            'locked' => !$failure['allowed'],
        ]);
        if (!$failure['allowed']) {
            http_response_code(429);
            header('Retry-After: ' . max(60, (int)$failure['retry_after']));
        }
        $error = 'Anmeldung fehlgeschlagen.';
    }
}

$adminTitle = 'Anmeldung';
require __DIR__ . '/includes/header.php';
?>
<section class="admin-login">
  <img src="<?= admin_e(app_path('/assets/img/brand-logo.svg')) ?>" alt="easyIT" class="admin-login-logo">
  <h1>Admin-Anmeldung</h1>
  <?php if (!db_available()): ?><div class="admin-alert">Die Datenbankverbindung ist noch nicht eingerichtet.</div><?php endif; ?>
  <?php if (isset($_GET["logged_out"])): ?><div class="admin-notice admin-notice--success">Du wurdest sicher abgemeldet.</div><?php endif; ?>
  <?php if ($error): ?><div class="admin-alert"><?= admin_e($error) ?></div><?php endif; ?>
  <form method="post" class="admin-form">
    <input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
    <label>Benutzername<input type="text" name="username" required autocomplete="username"></label>
    <label>Passwort<input type="password" name="password" required autocomplete="current-password"></label>
    <button class="admin-btn admin-btn--gold" type="submit">Anmelden</button>
  </form>
<?php $setupConfig = require __DIR__ . '/../config/admin.php'; ?>
<?php if ((bool)($setupConfig['setup_enabled'] ?? false) && strlen((string)($setupConfig['setup_token'] ?? '')) >= 32): ?>
<p class="admin-help">Noch kein Administrator? <a href="<?= admin_e(app_path('/admin/setup.php')) ?>">Ersteinrichtung öffnen</a></p>
<?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
