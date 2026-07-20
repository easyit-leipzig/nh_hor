<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Nur über die Kommandozeile ausführbar.'); }
require __DIR__ . '/../includes/database.php';
$expected=['admin_users','content_items','content_revisions','audit_log','tutors','tutor_competencies','tutor_reviews','schema_migrations'];
$errors=[];
foreach($expected as $table){
 $stmt=db()->prepare("SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME=:table_name");
 $stmt->execute(['table_name'=>$table]); $engine=$stmt->fetchColumn();
 if($engine===false){$errors[]="Tabelle fehlt: {$table}";} elseif(strtoupper((string)$engine)!=='INNODB'){$errors[]="{$table} verwendet {$engine} statt InnoDB";}
}
$failed=(int)db()->query("SELECT COUNT(*) FROM schema_migrations WHERE status='failed'")->fetchColumn();
if($failed>0){$errors[]="{$failed} Migration(en) mit Status failed";}
foreach(['fk_tutor_competencies_tutor','fk_tutor_reviews_tutor'] as $fk){
 $s=db()->prepare("SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA=DATABASE() AND CONSTRAINT_NAME=:name AND CONSTRAINT_TYPE='FOREIGN KEY'");
 $s->execute(['name'=>$fk]); if((int)$s->fetchColumn()!==1){$errors[]="Fremdschlüssel fehlt: {$fk}";}
}
if($errors){foreach($errors as $e){fwrite(STDERR,"FEHLER: {$e}\n");}exit(1);} fwrite(STDOUT,"OK: kanonisches InnoDB-Schema und Migrationsstatus sind konsistent.\n");
