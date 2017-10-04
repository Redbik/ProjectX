<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 27.07.2017
 * Time: 1:46
 */

include ('config_PDO.php');
$photo = htmlspecialchars(trim($_COOKIE['check_photo']));
$result = $db->prepare('UPDATE photos SET status=3 WHERE  id_photo= :id_photo');
$result->bindParam(':id_photo', $photo);
$result->execute();
