<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 27.07.2017
 * Time: 1:01
 */

include ('config_PDO.php');
$result = $db->prepare('SELECT * FROM vuser WHERE status=2 ORDER BY id_user');
$result->execute();

$block = array();

while ($row=$result->fetch(PDO::FETCH_ASSOC)){
    $block[] = $row;
}

echo json_encode($block);