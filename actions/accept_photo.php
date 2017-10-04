<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 27.07.2017
 * Time: 1:45
 */

include ('config_PDO.php');
$photo = htmlspecialchars(trim($_COOKIE['check_photo']));
$result = $db->prepare('UPDATE photos SET status=1 WHERE  id_photo= :id');
$result -> bindParam(':id', $photo);
$result->execute();
