<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 24.09.2017
 * Time: 19:03
 */
include ('config_PDO.php');

$query = 'SELECT id_user FROM `user` ORDER BY likes DESC LIMIT 7';
$q = $db->query($query);
$q->setFetchMode(PDO::FETCH_ASSOC);
$ids = array();
$res = $q->fetch(PDO::FETCH_BOTH);
for ($i=0; $i<count($res)+5; $i++){
    $ids[$i]= htmlspecialchars($res['id_user']);

    $res = $q->fetch(PDO::FETCH_BOTH);
}


$result1 = $db->prepare('SELECT name, univer, fac, old, vk, instagram, likes, id_user, photo, main_photo FROM `vuser` WHERE id_user=:id1  and `status` = 1
UNION
SELECT name, univer, fac, old, vk, instagram, likes, id_user, photo, main_photo FROM `vuser` WHERE id_user=:id2  and `status` = 1
UNION
SELECT name, univer, fac, old, vk, instagram, likes, id_user, photo, main_photo FROM `vuser` WHERE id_user=:id3  and `status` = 1
UNION
SELECT name, univer, fac, old, vk, instagram, likes, id_user, photo, main_photo FROM `vuser` WHERE id_user=:id4  and `status` = 1
UNION
SELECT name, univer, fac, old, vk, instagram, likes, id_user, photo, main_photo FROM `vuser` WHERE id_user=:id5  and `status` = 1
UNION
SELECT name, univer, fac, old, vk, instagram, likes, id_user, photo, main_photo FROM `vuser` WHERE id_user=:id6  and `status` = 1
UNION
SELECT name, univer, fac, old, vk, instagram, likes, id_user, photo, main_photo FROM `vuser` WHERE id_user=:id7 ORDER BY likes DESC, id_user 
');


$id1=$ids[0];
$id2=$ids[1];
$id3=$ids[2];
$result1->bindParam(':id1', $ids[0]);
$result1->bindParam(':id2', $ids[1]);
$result1->bindParam(':id3', $ids[2]);
$result1->bindParam(':id4', $ids[3]);
$result1->bindParam(':id5', $ids[4]);
$result1->bindParam(':id6', $ids[5]);
$result1->bindParam(':id7', $ids[6]);
$result1->execute();
$block1 = array();
while ($row=$result1->fetch(PDO::FETCH_ASSOC)){
    $block1[] = $row;
}

echo json_encode($block1);
