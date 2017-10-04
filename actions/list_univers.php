<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 11.09.2017
 * Time: 22:24
 */
include ('config_PDO.php');
$result = $db->prepare('SELECT name FROM univers ORDER BY name');
$result->execute();

$block = array();

while ($row=$result->fetch(PDO::FETCH_ASSOC)){
    $block[] = $row;
}

echo json_encode($block);