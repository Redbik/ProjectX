<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 22.05.2017
 * Time: 17:10
 */

include ('config_PDO.php');
$result = $db->prepare('SELECT * FROM vuser ');
$result->execute();

$block = array();

while ($row=$result->fetch(PDO::FETCH_ASSOC)){
    $block[] = $row;
}

echo json_encode($block);