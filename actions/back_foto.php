    <?php
    /**
     * Created by PhpStorm.
     * User: Dima
     * Date: 17.09.2017
     * Time: 18:32
     */


    include ('config_PDO.php');

    $arr = array();
    $arr = json_decode($_COOKIE['FotoBack'],true);
    $reversed = array_reverse($arr);

    $randFoto = $reversed[1];
    $result = $db->prepare('SELECT * FROM vuser WHERE id_user=:id  and `status` = 1');
    $result->bindParam(':id', $randFoto);
    $result->execute();

    $block = array();

    while ($row=$result->fetch(PDO::FETCH_ASSOC)){
        $block[] = $row;
    }

    echo json_encode($block);


