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
    $arr = array();
    include ("config.php");
    include ('config_PDO.php');

    $QueryMin = "SELECT MIN(id_user) FROM vuser";
    $Min = $db->query($QueryMin)->fetchColumn();

    $QueryMax = "SELECT MAX(id_user) FROM vuser";
    $Max = $db->query($QueryMax)->fetchColumn();

    $arr = json_decode($_COOKIE['FotoBack'],true);
    $randFoto = rand($Min, $Max);
//    while (in_array($randFoto,$arr)){
//        $randFoto = rand($Min, $Max);
//    }

    $arr[] =  $randFoto;
    $json1 = json_encode($arr);
    setcookie("FotoBack", $json1,time() + 60 * 60 * 24 * 7);

    $result = $db->prepare('SELECT * FROM vuser WHERE id_user=:id  and `status` = 1');
    $result->bindParam(':id', $randFoto);
    $result->execute();

    $result1 = $db->prepare('UPDATE user SET `likes`=`likes`+1 WHERE id_user=:ids');
    $result1->bindParam(':ids', $randFoto);
    $result1->execute();
    $block = array();

    while ($row=$result->fetch(PDO::FETCH_ASSOC)){
        $block[] = $row;
    }

    echo json_encode($block);


