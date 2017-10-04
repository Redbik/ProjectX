<?php
/**
 * Created by PhpStorm.
 * User: Alexander
 * Date: 13.07.2017
 */

include ("config.php");

$photos = htmlspecialchars(trim($_POST['photos']));
//$photos = ',,./users/photos/p3.JPG';

$photoArr = explode(",", $photos);
for ($i=0;$i!=count($photoArr); $i++){

}
if ((!empty($photos))){
        $id = $_COOKIE['id'];

        $query = 'INSERT INTO photos (photo, status, user_id) VALUES ';
        for ($i=0;$i!=count($photoArr); $i++) {
            if ($i==count($photoArr)-1){
                $query = $query.'("'.$photoArr[$i].'",2,'.$id.')';
            }
            else
                $query = $query.'("'.$photoArr[$i].'",2,'.$id.'),';
        }
    $query = str_replace(',("",2,'.$id.')', '', $query);
    $query = str_replace('("",2,'.$id.'),', '', $query);

        $q = mysqli_query($db, $query);
//    echo $query;



}




