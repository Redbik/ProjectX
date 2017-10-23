<?php
/* Подключение к базе данных MySQL, используя вызов драйвера */
$dsn = 'mysql:dbname=toofuru_thebest;host=localhost;port=3306';
$user = 'toofuru_thebest';
$password = ']WUF#XSN4n*_';

try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}

?>