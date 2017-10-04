<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 17.09.2017
 * Time: 20:53
 */

include ('config_PDO.php');
$likes = $_POST['likes'];
$result = $db->prepare("UPDATE user SET likes='$likes' WHERE id_user=".$_COOKIE['id']);
$result->execute();

