<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/internal-auth.php';

if (internal_user()) {
    header('Location: ' . internal_start_path(), true, 303);
    exit;
}

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_line((string)($_POST['username'] ?? ''));
    $status = login_rate_status($username);

    if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
        $error = 'Die Sitzung ist abgelaufen. Bitte laden Sie die Seite neu.';
    } elseif (!$status['allowed']) {
        http_response_code(429);
        header('Retry-After: ' . max(60, (int)$status['retry_after']));
        $error = 'Zu viele Anmeldeversuche. Bitte versuchen Sie es später erneut.';
    } elseif (internal_login($username, (string)($_POST['password'] ?? ''))) {
        login_rate_clear($username);
        header('Location: ' . internal_start_path(), true, 303);
        exit;
    } else {
        $failure = login_rate_record_failure($username);
        if (!$failure['allowed']) {
            http_response_code(429);
            header('Retry-After: ' . max(60, (int)$failure['retry_after']));
        }
        $error = 'Anmeldung fehlgeschlagen.';
    }
}

$site = require __DIR__ . '/../config/site.php';
$pageTitle = 'Interne Anmeldung | easyIT Nachhilfe Leipzig';
$pageDescription = 'Geschützter interner Bereich von easyIT Nachhilfe Leipzig.';
$pageCanonical = canonical_url($site, '/intern/login.php');
$pageRobots = 'noindex,nofollow';
?><!doctype html>
<html lang="de">
<head>
<?php require __DIR__ . '/../includes/meta.php'; ?>
<link rel="stylesheet" href="<?= e(app_path('/assets/css/internal.css')) ?>">
</head>
<body class="internal-login-page">
<main class="internal-login">
    <a class="internal-brand" href="<?= e(app_path('/index.php')) ?>">
        <img src="<?= e(app_path('/assets/img/brand-logo.svg')) ?>" alt="easyIT Nachhilfe Leipzig" width="180" height="135">
    </a>
    <h1>Interner Bereich</h1>
    <p>Melden Sie sich mit Ihrem persönlichen Anmeldenamen an.</p>

    <?php if (!db_available()): ?>
        <div class="internal-alert">Die Datenbankverbindung ist nicht verfügbar.</div>
    <?php endif; ?>

    <?php if (isset($_GET['logged_out'])): ?>
        <div class="internal-notice">Sie wurden sicher abgemeldet.</div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="internal-alert"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" class="internal-form">
        <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
        <label for="username">Anmeldename</label>
        <input id="username" name="username" value="<?= e($username) ?>" required autocomplete="username">

        <label for="password">Passwort</label>
        <input id="password" name="password" type="password" required autocomplete="current-password">

        <button class="button button--gold" type="submit">Anmelden</button>
    </form>

    <p><a href="<?= e(app_path('/index.php')) ?>">Zur öffentlichen Webseite</a></p>
</main>
</body>
</html>
