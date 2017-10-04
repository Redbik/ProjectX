<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 05.09.2017
 * Time: 20:45
 */
include ('config_PDO.php');
$id=htmlspecialchars($_COOKIE['id']);
$name=htmlspecialchars(trim($_POST['name']));
$old=htmlspecialchars($_POST['old']);
$univer=htmlspecialchars(trim($_POST['univer']));
$fac=htmlspecialchars(trim($_POST['fac']));
$vk=htmlspecialchars($_POST['vk']);
$instagram=htmlspecialchars(trim($_POST['instagram']));
if (
    !(empty($id)) &&
    !(empty($name)) &&
    !(empty($old)) &&
    !(empty($univer)) &&
    !(empty($fac))
){
    $result = $db->prepare("
  UPDATE user SET `name`=:name, 
  `old`=:old,
  `univer`=:univer,
  `fac`=:fac,
  `vk`=:vk,
  `instagram`=:instagram
  WHERE id_user =:id");
    $result->bindParam(':id', $id);
    $result->bindParam(':old', $old);
    $result->bindParam(':univer', $univer);
    $result->bindParam(':fac', $fac);
    $result->bindParam(':vk', $vk);
    $result->bindParam(':instagram', $instagram);
    $result->bindParam(':name', $name);
    $result->execute();
    $block = array();

    while ($row=$result->fetch(PDO::FETCH_ASSOC)){
        $block[] = $row;
    }
//    header("Location:".$location);
}
