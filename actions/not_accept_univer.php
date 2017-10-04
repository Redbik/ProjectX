<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 12.09.2017
 * Time: 22:30
 */

include ('config_PDO.php');
$id_univer = htmlspecialchars(trim($_POST['data']));
$result = $db->prepare('UPDATE univers SET status=1 WHERE  id_univer= :id_univer');
$result->bindParam(':id_univer', $id_univer);
$result->execute();
