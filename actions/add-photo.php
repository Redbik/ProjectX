<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 13.07.2017
 */

include ("config.php");
mysqli_set_charset($db, 'utf8');

$name = htmlspecialchars(trim($_POST['name']));
$sername = htmlspecialchars(trim($_POST['sername']));
$old = htmlspecialchars(trim($_POST['old']));
$univer = htmlspecialchars(trim($_POST['univer']));
$fac = htmlspecialchars(trim($_POST['fac']));
$vk = htmlspecialchars(trim($_POST['vk']));
$instagram = htmlspecialchars(trim($_POST['instagram']));
$mainPhoto = htmlspecialchars(trim($_POST['main_photo']));
$photos = htmlspecialchars(trim($_POST['photos']));

$id= 0;
$photoArr = explode(",", $photos);

if ((!empty($name)) &&
    (!empty($sername)) &&
    (!empty($old)) &&
    (!empty($univer))){

    $q = mysqli_query($db, "SELECT vk FROM user WHERE  `vk`='$vk'" );
    if(mysqli_num_rows($q)==0 || $vk =='') {
        $q = mysqli_query($db, "SELECT name, sername, vk FROM user WHERE `name` = '$name' and `sername`='$sername' and `vk`='$vk'" );
        if(mysqli_num_rows($q)==0) {

            $query = 'INSERT INTO user (name,sername, old ,univer,fac,vk,instagram, main_photo) VALUES (  "'.$name.'"  ,"'.$sername.'",  '.$old.',"'.$univer.'","'.$fac.'","'.$vk.'","'.$instagram.'","'.$mainPhoto.'")';
            $q = mysqli_query($db, $query);
            $query = 'SELECT MAX(id_user) FROM user';

            $q = mysqli_query($db, $query);
            $res = mysqli_fetch_array($q);
            $id = $res['MAX(id_user)'];

            $id = str_replace('[{"MAX(id_user)":"', '',$id);
            $id = str_replace('"}]', '',$id);
            $query = 'INSERT INTO photos (photo, status, user_id) VALUES ';
            for ($i=0;$i!=count($photoArr); $i++) {
                if ($i==count($photoArr)-1)
                    $query = $query.'("'.$photoArr[$i].'",1,'.$id.')';
                else
                    $query = $query.'("'.$photoArr[$i].'",1,'.$id.'),';
            }

            $q = mysqli_query($db, $query);
//            unset($photoArr);
        }
    }
}




