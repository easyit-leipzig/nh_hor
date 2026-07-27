# Datenbank unter XAMPP einrichten

1. In XAMPP **Apache** und **MySQL** starten.
2. `http://localhost/phpmyadmin/` öffnen.
3. Eine Datenbank mit dem Namen `easyit` und der Kollation `utf8mb4_unicode_ci` anlegen.
4. Die bereitgestellte Datei `easyit (2).sql` in diese Datenbank importieren.
5. Die lokale Verbindung steht in `config/database.local.php`:

```php
return [
    'host' => '127.0.0.1',
    'port' => 3306,
    'name' => 'easyit',
    'user' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
];
```

6. Danach `http://localhost/nh_hor/admin/setup.php` öffnen.

Bei einem abweichenden MySQL-Benutzer oder Passwort muss ausschließlich `config/database.local.php` angepasst werden.
