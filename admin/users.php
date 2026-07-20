<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');
$error=''; $notice=(string)($_GET['result']??''); $me=admin_user();
$config=require __DIR__.'/../config/admin.php';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (!csrf_is_valid((string)($_POST['csrf_token']??''))) { http_response_code(403); exit('Ungültige Anfrage.'); }
    try {
        $action=(string)($_POST['action']??'create');
        $id=filter_var($_POST['id']??null,FILTER_VALIDATE_INT,['options'=>['min_range'=>1]])?:null;
        if ($action==='toggle') {
            if (!$id || $id===(int)$me['id']) throw new RuntimeException('Das eigene Konto kann hier nicht deaktiviert werden.');
            $stmt=db()->prepare('UPDATE admin_users SET is_active=IF(is_active=1,0,1) WHERE id=:id'); $stmt->execute(['id'=>$id]);
            admin_log('toggle_active','admin_user',$id); header('Location: ' . app_path('/admin/users.php?result=updated'),true,303); exit;
        }
        if ($action==='reset_password') {
            $password=(string)($_POST['password']??'');
            if (!$id || strlen($password)<(int)$config['password_min_length']) throw new RuntimeException('Das neue Passwort ist zu kurz.');
            $stmt=db()->prepare('UPDATE admin_users SET password_hash=:hash WHERE id=:id'); $stmt->execute(['hash'=>password_hash($password,PASSWORD_DEFAULT),'id'=>$id]);
            admin_log('reset_password','admin_user',$id); header('Location: ' . app_path('/admin/users.php?result=password'),true,303); exit;
        }
        $username=trim((string)($_POST['username']??'')); $email=trim((string)($_POST['email']??''));
        $role=in_array($_POST['role']??'', ['admin','editor'],true)?(string)$_POST['role']:'editor';
        $password=(string)($_POST['password']??'');
        if (!preg_match('/^[A-Za-z0-9._-]{3,80}$/',$username)) throw new RuntimeException('Ungültiger Benutzername.');
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) throw new RuntimeException('Ungültige E-Mail-Adresse.');
        if (strlen($password)<(int)$config['password_min_length']) throw new RuntimeException('Das Passwort ist zu kurz.');
        $stmt=db()->prepare('INSERT INTO admin_users(username,email,password_hash,role,is_active) VALUES(:username,:email,:hash,:role,1)');
        $stmt->execute(['username'=>$username,'email'=>$email,'hash'=>password_hash($password,PASSWORD_DEFAULT),'role'=>$role]);
        $newId=(int)db()->lastInsertId(); admin_log('create','admin_user',$newId); header('Location: ' . app_path('/admin/users.php?result=created'),true,303); exit;
    } catch(Throwable $e) { $error=$e->getMessage(); }
}
$users=db_available()?db()->query('SELECT id,username,email,role,is_active,last_login_at,created_at FROM admin_users ORDER BY username')->fetchAll():[];
$adminTitle='Benutzer'; require __DIR__.'/includes/header.php';
?>
<h1>Admin-Benutzer</h1>
<?php if($notice):?><p class="admin-notice admin-notice--success">Änderung gespeichert.</p><?php endif;?>
<?php if($error):?><p class="admin-notice admin-notice--error"><?=admin_e($error)?></p><?php endif;?>
<section class="admin-card" style="margin-bottom:2rem"><h2>Benutzer anlegen</h2>
<form method="post" class="admin-form admin-form--columns"><input type="hidden" name="csrf_token" value="<?=admin_e(csrf_token())?>"><input type="hidden" name="action" value="create">
<label>Benutzername<input name="username" required></label><label>E-Mail<input type="email" name="email" required></label><label>Rolle<select name="role"><option value="editor">Redaktion</option><option value="admin">Administrator</option></select></label><label>Startpasswort<input type="password" name="password" required></label><button class="admin-btn admin-btn--gold" type="submit">Anlegen</button></form></section>
<table class="admin-table"><thead><tr><th>Benutzer</th><th>Rolle</th><th>Status</th><th>Letzte Anmeldung</th><th>Aktionen</th></tr></thead><tbody>
<?php foreach($users as $u):?><tr><td><strong><?=admin_e((string)$u['username'])?></strong><br><?=admin_e((string)$u['email'])?></td><td><?=admin_e((string)$u['role'])?></td><td><?=(int)$u['is_active']===1?'aktiv':'inaktiv'?></td><td><?=admin_e((string)($u['last_login_at']??'–'))?></td><td>
<?php if((int)$u['id']!==(int)$me['id']):?><form method="post" class="admin-inline-form"><input type="hidden" name="csrf_token" value="<?=admin_e(csrf_token())?>"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?=(int)$u['id']?>"><button class="admin-btn" type="submit">Status ändern</button></form><?php endif;?>
<form method="post" class="admin-inline-form admin-password-reset"><input type="hidden" name="csrf_token" value="<?=admin_e(csrf_token())?>"><input type="hidden" name="action" value="reset_password"><input type="hidden" name="id" value="<?=(int)$u['id']?>"><input type="password" name="password" required placeholder="Neues Passwort"><button class="admin-btn admin-btn--danger" type="submit">Passwort setzen</button></form>
</td></tr><?php endforeach;?>
</tbody></table>
<?php require __DIR__.'/includes/footer.php'; ?>
