<?php
declare(strict_types=1);
require __DIR__.'/includes/admin-functions.php';
admin_require_role('admin');
if($_SERVER['REQUEST_METHOD']!=='POST'||!csrf_is_valid((string)($_POST['csrf_token']??''))) exit('Ungültige Anfrage');
$img=null;
if(!empty($_FILES['image']['name'])&&is_uploaded_file($_FILES['image']['tmp_name'])){
$ext=strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
if(in_array($ext,['jpg','jpeg','png','webp'],true)){ $img='uploads/homepage/'.basename($_FILES['image']['name']); move_uploaded_file($_FILES['image']['tmp_name'],dirname(__DIR__).'/'.$img); }
}
$stmt=db()->prepare('INSERT INTO homepage_blocks(block_type,title,content,image,button_text,button_url,position,active) VALUES(?,?,?,?,?,?,?,?)');
$stmt->execute([$_POST['block_type']??'neu',$_POST['title']??'',$_POST['content']??'',$img,$_POST['button_text']??'',$_POST['button_url']??',(int)($_POST['position']??0),isset($_POST['active'])?1:0]);
header('Location: homepage_blocks.php',true,303);
