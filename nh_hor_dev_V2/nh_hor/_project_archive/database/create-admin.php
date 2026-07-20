<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Nur über die Kommandozeile ausführbar.');
}

require __DIR__ . '/../includes/database.php';

$username = $argv[1] ?? '';
$email = $argv[2] ?? '';
$password = $argv[3] ?? '';

if ($username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 12) {
    fwrite(STDERR, "Aufruf: php database/create-admin.php BENUTZER EMAIL PASSWORT\n");
    fwrite(STDERR, "Das Passwort muss mindestens 12 Zeichen lang sein.\n");
    exit(1);
}

$stmt = db()->prepare(
    'INSERT INTO admin_users (username,email,password_hash,role)
     VALUES (:username,:email,:password_hash,"admin")'
);
$stmt->execute([
    'username'=>$username,
    'email'=>$email,
    'password_hash'=>password_hash($password, PASSWORD_DEFAULT),
]);

fwrite(STDOUT, "Admin wurde angelegt.\n");
