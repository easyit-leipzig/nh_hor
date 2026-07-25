<?php
$f=__DIR__.'/config.server.php';
echo "<pre>";
if(!file_exists($f)) die("Datei fehlt");
$c=require $f;
try{
$db=$c['database'];
new PDO("mysql:host={$db['host']};port={$db['port']};dbname={$db['name']};charset={$db['charset']}",$db['username'],$db['password']);
echo "OK: Datenbankverbindung erfolgreich";
}catch(Throwable $e){
echo $e->getMessage();
}
echo "</pre>";
