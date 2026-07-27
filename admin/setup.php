<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';

$config = require __DIR__ . '/../config/admin.php';
$error = '';
$done = false;
$count = null;

if (!db_available()) {
    http_response_code(503);
    $error = 'Die Datenbankverbindung ist nicht verfügbar.';
    if (!config_is_production() && function_exists('db_last_error') && db_last_error()) {
        $error .= ' Ursache: ' . db_last_error();
    }
} else {
    try {
        $count = (int)db()->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
    } catch (Throwable $e) {
        http_response_code(503);
        $error = 'Die Admin-Tabellen fehlen. Bitte zuerst database/migrations/2026-07-20_admin_complete.sql importieren.';
    }
}

// Die Ersteinrichtung ist ausschließlich erlaubt, solange noch kein
// Administratorkonto existiert. Danach sperrt sich diese Seite automatisch.
if ($count !== null && $count > 0) {
    http_response_code(403);
    exit('Die Ersteinrichtung ist bereits abgeschlossen.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $error === '' && $count === 0) {
    $username = trim((string)($_POST['username'] ?? ''));
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $password2 = (string)($_POST['password_confirm'] ?? '');
    $minLength = (int)($config['password_min_length'] ?? 12);

    if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
        $error = 'Die Sitzung ist abgelaufen.';
    } elseif (!preg_match('/^[A-Za-z0-9._-]{3,80}$/', $username)) {
        $error = 'Der Benutzername muss 3–80 zulässige Zeichen enthalten.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Bitte eine gültige E-Mail-Adresse eingeben.';
    } elseif (strlen($password) < $minLength) {
        $error = 'Das Passwort muss mindestens ' . $minLength . ' Zeichen lang sein.';
    } elseif ($password !== $password2) {
        $error = 'Die Passwörter stimmen nicht überein.';
    } else {
        try {
            db()->beginTransaction();

            // Sperre gegen parallele Ersteinrichtungen.
            $currentCount = (int)db()->query('SELECT COUNT(*) FROM admin_users FOR UPDATE')->fetchColumn();
            if ($currentCount > 0) {
                db()->rollBack();
                http_response_code(409);
                $error = 'Die Ersteinrichtung wurde inzwischen bereits abgeschlossen.';
            } else {
                $stmt = db()->prepare(
                    "INSERT INTO admin_users (username,email,password_hash,role,is_active)\n" .
                    "VALUES (:username,:email,:hash,'admin',1)"
                );
                $stmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'hash' => password_hash($password, PASSWORD_DEFAULT),
                ]);
                db()->commit();
                $done = true;
            }
        } catch (Throwable $e) {
            if (db()->inTransaction()) {
                db()->rollBack();
            }
            $error = 'Der Administrator konnte nicht angelegt werden. Benutzername oder E-Mail-Adresse sind möglicherweise bereits vergeben.';
        }
    }
}

$adminTitle = 'Ersteinrichtung';
require __DIR__ . '/includes/header.php';
?>
<section class="admin-login">
<img src="<?= admin_e(app_path('/assets/img/brand-logo.svg')) ?>" alt="easyIT" class="admin-login-logo">
<h1>Adminbereich einrichten</h1>
<?php if ($error): ?><div class="admin-notice admin-notice--error"><?= admin_e($error) ?></div><?php endif; ?>
<?php if ($done): ?>
<div class="admin-notice admin-notice--success">Der erste Administrator wurde angelegt. Die Ersteinrichtung ist damit automatisch gesperrt.</div>
<p><a class="admin-btn admin-btn--gold" href="<?= admin_e(app_path('/admin/login.php')) ?>">Zur Anmeldung</a></p>
<?php elseif ($count === 0 && $error === ''): ?>
<p>Es ist noch kein Administrator vorhanden. Mit diesem Formular wird das erste Administratorkonto angelegt. Danach sperrt sich die Ersteinrichtung automatisch.</p>
<form method="post" class="admin-form">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>">
<label>Benutzername<input type="text" name="username" required autocomplete="username"></label>
<label>E-Mail-Adresse<input type="email" name="email" required autocomplete="email"></label>
<label>Passwort<input type="password" name="password" required minlength="<?= (int)($config['password_min_length'] ?? 12) ?>" autocomplete="new-password"></label>
<label>Passwort wiederholen<input type="password" name="password_confirm" required autocomplete="new-password"></label>
<button class="admin-btn admin-btn--gold" type="submit">Ersten Administrator anlegen</button>
</form>
<?php endif; ?>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
