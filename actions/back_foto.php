    <?php
    /**
     * Created by PhpStorm.
     * User: Dima
     * Date: 17.09.2017
     * Time: 18:32
     */


    include ('config_PDO.php');

    if (!(empty($_POST['photoHistory']))){
            $photoHistory = htmlspecialchars($_POST['photoHistory']);
                // setcookie('aaa',$photoHistory);

            $photoHistory= str_replace('NaN', '', $photoHistory);
            $photoHistory= str_replace('undefined', '', $photoHistory);
            $photoHistory = explode(",", $photoHistory);

    }
    $reversed = array_reverse($photoHistory);

    $randFoto = $reversed[0];
    setcookie('rand',$randFoto);
    $result = $db->prepare('SELECT * FROM vuser WHERE id_user=:id  and `status` = 1');
    $result->bindParam(':id', $randFoto);
    $result->execute();

    $block = array();

    while ($row=$result->fetch(PDO::FETCH_ASSOC)){
        $block[] = $row;
    }

    echo json_encode($block);


