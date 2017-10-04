<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 14.09.2017
 * Time: 16:55
 */
include ('config_PDO.php');
$id=htmlspecialchars(trim($_COOKIE['id']));
$photo=htmlspecialchars(trim($_POST['data']));
$result = $db->prepare("UPDATE user SET main_photo=:photo WHERE id_user =:id");
$result->bindParam(':photo', $photo);
$result->bindParam(':id', $id);
$result->execute();
