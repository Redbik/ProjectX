<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 27.09.2017
 * Time: 16:59
 */

include ('config_PDO.php');
$result = $db->prepare('SELECT main_photo FROM user LIMIT 4');
$result->execute();
$block = array();
while ($row=$result->fetch(PDO::FETCH_ASSOC)){
    $block[] = $row;
}

echo json_encode($block);
