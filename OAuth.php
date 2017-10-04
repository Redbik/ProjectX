<?php

include ("actions/config.php");
mysqli_query($db,"SET NAMES 'utf8';");
$client_id = '433099980847-adf19u61nrl12me0c08ur67rgup0aqjh.apps.googleusercontent.com'; // Client ID
$client_secret = 'Ccl-2tFCf6lV4aU2IOMu73ZP'; // Client secret
$redirect_uri = 'http://localhost/www/ProjectX/'; // Redirect URIs

$urlGoogle = 'https://accounts.google.com/o/oauth2/auth';

$paramsGoogle = array(
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'client_id'     => $client_id,
    'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
);


if (isset($_GET['code'])) {
    $result = false;

    $paramsGoogle = array(
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $redirect_uri,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code']
    );

    $urlGoogle = 'https://accounts.google.com/o/oauth2/token';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $urlGoogle);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($paramsGoogle)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);
    $tokenInfo = json_decode($result, true);

    if (isset($tokenInfo['access_token'])) {
        $paramsGoogle['access_token'] = $tokenInfo['access_token'];

        $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($paramsGoogle))), true);
        if (isset($userInfo['id'])) {
            $userInfo = $userInfo;
            $result = true;
        }
    }

    if ($result) {
        $name = $userInfo['name'];
        $sername = $userInfo['name'];
        if ((empty($name)))
            return;
        $regexp= "/.* /ui";
        preg_match($regexp, $name, $name);
        $regexp= "/ .*/ui";
        preg_match($regexp, $sername, $sername);
        $query = mysqli_query($db,"SELECT name, sername, id_user, socId FROM user where `socId`='".$userInfo['id']."'");
//        $res=mysqli_fetch_array($query);
//        setcookie('id', $res['id_user']);
        if(mysqli_num_rows($query)==0){
            $query = mysqli_query($db,"INSERT INTO `user`(`name`, `sername`, `socId`) VALUES ('".$name[0]."','".$sername[0]."', '".$userInfo['id']."')");
            $query = 'SELECT MAX(id_user) FROM user';
            $q = mysqli_query($db, $query);
            $res=mysqli_fetch_array($q);
            $id = $res['MAX(id_user)'];
            $id = str_replace('[{"MAX(id_user)":"', '',$id);
            $id = str_replace('"}]', '',$id);
//            $query = mysqli_query($db,"INSERT INTO `photos`(`photo`, `status`, `user_id`) VALUES ('".$userInfo['picture']."','2',".$id.")");

            setcookie('id', $id);
            setcookie('main-photo', $userInfo['picture']);


        }
        else{
            $res=mysqli_fetch_array($query);
            setcookie('id', $res['id_user']);
        }
        echo "Социальный ID пользователя: " . $userInfo['uid'] . '<br />';
        echo "Имя пользователя: " . $userInfo['first_name'] . '<br />';
        echo "Ссылка на профиль пользователя: " . $userInfo['screen_name'] . '<br />';
        echo "Пол пользователя: " . $userInfo['sex'] . '<br />';
        echo "День Рождения: " . $userInfo['bdate'] . '<br />';
        echo '<img src="' . $userInfo['photo_big'] . '" />'; echo "<br />";
        header("Location:http://localhost/www/ProjectX");

    }

}

?>
