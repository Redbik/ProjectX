<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 06.09.2017
 * Time: 13:53
 */
include ('config_PDO.php');
$id=htmlspecialchars($_COOKIE['id']);
$photo=htmlspecialchars(trim($_POST['data']));
//$id = 11;
//$photo='https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg';
$result=$db-> prepare("UPDATE user SET main_photo=:mainPhoto WHERE id_user =:id");
$result->bindParam(':mainPhoto',$photo);
$result->bindParam(':id',$id);
$result->execute();

$result = $db-> prepare("SELECT COUNT(*) FROM photos WHERE photo =:photo and user_id=:user_id");
$result->bindParam(':photo', $photo);
$result->bindParam(':user_id', $id);
$result->execute();
$numRows = $result -> fetchColumn();
if ($numRows==0) {
    $result = $db->prepare("INSERT INTO `photos`(`photo`, `status`, `user_id`) VALUES (:photo,'2',:id)");
    $result->bindParam(':photo', $photo);
    $result->bindParam(':id', $id);
    $result->execute();
}



