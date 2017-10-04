<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 12.09.2017
 * Time: 0:15
 */
include ('config_PDO.php');
$word = htmlspecialchars(trim($_POST['data']));
$result = $db->prepare("SELECT name FROM `univers` WHERE full_name LIKE '%".$word."%' or name LIKE '%".$word."%'");
$result->execute();

$block = array();

while ($row=$result->fetch(PDO::FETCH_ASSOC)){
    $block[] = $row;
}

echo json_encode($block);