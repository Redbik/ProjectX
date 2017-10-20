<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 12.09.2017
 * Time: 22:30
 */

include ('config_PDO.php');
$id_univer = htmlspecialchars(trim($_POST['id']));
$name = htmlspecialchars(trim($_POST['name']));
$result = $db->prepare('UPDATE univers SET status=1, name= :name  WHERE  id_univer= :id_univer');
$result->bindParam(":name", $name);
$result->bindParam(":id_univer", $id_univer);
$result->execute();
$result = $db->prepare('INSERT INTO univers (name, status) VALUES (:name, 1)');
$result->bindParam(":name", $name);
$result->execute();

