<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_login();
$error=''; $success=''; $user=admin_user();
$config = require __DIR__ . '/../config/admin.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $current=(string)($_POST['current_password']??'');
    $new=(string)($_POST['new_password']??'');
    $confirm=(string)($_POST['new_password_confirm']??'');
    if (!csrf_is_valid((string)($_POST['csrf_token']??''))) $error='Die Sitzung ist abgelaufen.';
    elseif (strlen($new)<(int)$config['password_min_length']) $error='Das neue Passwort ist zu kurz.';
    elseif ($new!==$confirm) $error='Die neuen Passwörter stimmen nicht überein.';
    else {
        $stmt=db()->prepare('SELECT password_hash FROM admin_users WHERE id=:id AND is_active=1');
        $stmt->execute(['id'=>$user['id']]); $hash=$stmt->fetchColumn();
        if (!$hash || !password_verify($current,(string)$hash)) $error='Das aktuelle Passwort ist falsch.';
        else {
            $upd=db()->prepare('UPDATE admin_users SET password_hash=:hash WHERE id=:id');
            $upd->execute(['hash'=>password_hash($new,PASSWORD_DEFAULT),'id'=>$user['id']]);
            admin_log('password_change','admin_user',(int)$user['id']); $success='Das Passwort wurde geändert.';
        }
    }
}
$adminTitle='Konto'; require __DIR__.'/includes/header.php';
?>
<h1>Mein Konto</h1>
<div class="admin-card admin-card--narrow">
<p><strong>Benutzer:</strong> <?= admin_e((string)$user['username']) ?><br><strong>E-Mail:</strong> <?= admin_e((string)$user['email']) ?><br><strong>Rolle:</strong> <?= admin_e((string)$user['role']) ?></p>
<?php if($error):?><p class="admin-notice admin-notice--error"><?=admin_e($error)?></p><?php endif;?>
<?php if($success):?><p class="admin-notice admin-notice--success"><?=admin_e($success)?></p><?php endif;?>
<form method="post" class="admin-form">
<input type="hidden" name="csrf_token" value="<?=admin_e(csrf_token())?>">
<label>Aktuelles Passwort<input type="password" name="current_password" required autocomplete="current-password"></label>
<label>Neues Passwort<input type="password" name="new_password" required autocomplete="new-password"></label>
<label>Neues Passwort wiederholen<input type="password" name="new_password_confirm" required autocomplete="new-password"></label>
<button class="admin-btn admin-btn--gold" type="submit">Passwort ändern</button>
</form></div>
<?php require __DIR__.'/includes/footer.php'; ?>
