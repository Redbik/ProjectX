<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 14.09.2017
 * Time: 15:51
 */

include ('config_PDO.php');
$id= $_POST['id'];
$result = $db->prepare('DELETE FROM photos WHERE id_photo=:id_photo');
$result->bindParam(':id_photo', $id);
$result->execute();

$block = array();

while ($row=$result->fetch(PDO::FETCH_ASSOC)){
    $block[] = $row;
}

echo json_encode($block);