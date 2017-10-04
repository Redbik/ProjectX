<?php
include ('config_PDO.php');
$id= htmlspecialchars(trim($_COOKIE['id']));
$result = $db->prepare('SELECT status, photo, likes, id_photo  FROM vuser WHERE id_user=:id_user');
$result->bindParam(":id_user", $id);
$result->execute();
$block1 = array();

while ($row=$result->fetch(PDO::FETCH_ASSOC)){
    $block1[] = $row;
}

echo json_encode($block1);