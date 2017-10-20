<?php
/**
 * Created by PhpStorm.
 * User: Dima
 * Date: 17.09.2017
 * Time: 18:32
 */


//            include ("config.php");
//

//
//            $arr = array();
//
//            $arr = json_decode($_COOKIE['first'],true);
//            while(in_array($randFoto,$arr)){
//                $randFoto = rand(1, 12);
//            }
//    //        $result = mysql_query("SELECT * FROM foto WHERE id_foto='$randFoto'");
//    //        $result1 = mysql_query("UPDATE foto SET `like`=`like`+1 WHERE id_foto='$randFoto'");
//
//            $result = $db->prepare('SELECT * FROM photos WHERE user_id=:id');
//            $result->bindParam(':id', $randFoto);
//            $result->execute();
//
//
////            $result1 = $db->prepare('UPDATE foto SET `like`=`like`+1 WHERE id_foto=:ids');
////            $result1->bindParam(':ids', $randFoto);
////            $result1->execute();
//
//            $foto = array();
//
//            while($row = $result->fetch()){
//                $foto[] = $row;
//                $arr[] = $row['id_foto'];
//            }
//
//            $json1 = json_encode($arr);
//            setcookie("first", $json1);
//
//            $json = json_encode($foto);
//            echo $json;
    include ('config_PDO.php');
    $ids = htmlspecialchars($_POST['idfoto']);
    $QueryMin = "SELECT MIN(id_user) FROM vuser";
    $Min = $db->query($QueryMin)->fetchColumn();

    $QueryMax = "SELECT MAX(id_user) FROM vuser";
    $Max = $db->query($QueryMax)->fetchColumn();

    $QueryCount = "SELECT COUNT(DISTINCT id_user) FROM vuser WHERE status=1";
    $Count = $db->query($QueryCount)->fetchColumn();
    if (!(empty($_POST['photoHistory']))){
            $photoHistory = htmlspecialchars($_POST['photoHistory']);
            $photoHistory= str_replace('NaN', '', $photoHistory);
            $photoHistory= str_replace('undefined', '', $photoHistory);
            $photoHistory = explode(",", $photoHistory);

    }


    //    $randFoto = rand($Min, $Max);
    //    while (in_array($randFoto,$arr)){
    //        $randFoto = rand($Min, $Max);
    //    }
    $CountArr = count($photoHistory);
    if ($Count == $CountArr){
        setcookie("clearPhotoHistory", "1", time()+60, "/");
        do{

            $randFoto = rand($Min, $Max);
            $Counts = $db->prepare("SELECT * FROM vuser WHERE id_user=:id and `status` = 1");
            $Counts->bindParam(':id', $randFoto);
            $Counts ->execute();
            $Counts = $Counts->rowCount();
    } while(in_array($randFoto, $photoHistory) || $Counts=='0');

    }else{
        do {
            $randFoto = rand($Min, $Max);
            $Counts = $db->prepare("SELECT * FROM vuser WHERE id_user=:id and `status` = 1");
            $Counts->bindParam(':id', $randFoto);
            $Counts ->execute();
            $Counts = $Counts->rowCount();
        }
        while(in_array($randFoto, $photoHistory) || $Counts==0);

        // setcookie("FotoBack", $json1,time() + 60);
        // setcookie("backPhoto", $json1,time() + 60);
    }

$result = $db->prepare('SELECT * FROM vuser WHERE id_user=:id  and `status` = 1');
$result->bindParam(':id', $randFoto);
$result->execute();

$result1 = $db->prepare('UPDATE user SET `likes`=`likes`+1 WHERE id_user=:ids');
$result1->bindParam(':ids', $ids);
$result1->execute();


$block = array();

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $block[] = $row;
}

echo json_encode($block);

