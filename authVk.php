<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
</head>
<body>
    <?php
    include ('actions/config.php');
    mysqli_set_charset($db, 'utf8');
    $client_id = '6168263'; // ID приложения
    $client_secret = 'zf0bUbD2ZTjIj10MLL00'; // Защищённый ключ
    $redirect_uri = $location; // Адрес сайта

    $urlVk = 'http://oauth.vk.com/authorize';

    $paramsVk = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code'
    );



if (isset($_GET['code'])) {
    $result = false;
    $paramsVk = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $_GET['code'],
        'redirect_uri' => $redirect_uri
    );

   @ $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($paramsVk))), true);

    if (isset($token['access_token'])) {
        $paramsVk = array(
            'uids'         => $token['user_id'],
            'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big,education',
            'access_token' => $token['access_token']
        );

        $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($paramsVk))), true);
        if (isset($userInfo['response'][0]['uid'])) {
            $userInfo = $userInfo['response'][0];
            $result = true;
        }
    }

    if ($result) {
        $query = mysqli_query($db,"SELECT name, sername, socId, id_user FROM user where `socId` ='".$userInfo['uid']."'");
//        $res=mysqli_fetch_array($query);
//        setcookie('id', $res['id_user']);
        if(mysqli_num_rows($query)==0){
            $query = mysqli_query($db,"INSERT INTO `user`(`name`, `sername`, `socId`) VALUES ('".$userInfo['first_name']."','".$userInfo['last_name']."', '".$userInfo['uid']."')");
            $query = 'SELECT MAX(id_user) FROM user';
            $q = mysqli_query($db, $query);
            $res=mysqli_fetch_array($q);
            $id = $res['MAX(id_user)'];
            $id = str_replace('[{"MAX(id_user)":"', '',$id);
            $id = str_replace('"}]', '',$id);
//            $query = mysqli_query($db,"INSERT INTO `photos`(`photo`, `status`, `user_id`) VALUES ('".$userInfo['photo_big']."','2',".$id.")");

            setcookie('id', $id);
            setcookie('main-photo', $userInfo['photo_big']);

        }
        else{
            $res=mysqli_fetch_array($query);
            setcookie('id', $res['id_user']);
            setcookie('vk', $userInfo['screen_name']);
//            if ($res['socId']=='82532480'){
//                setcookie('socId', $res['socId']);
//                setcookie('socIdd', $res['socId']);
//                header("Location:".$location.'admin.php');
//                return false;
//            }
        }
//        echo "Пол пользователя: " . $userInfo['sex'] . '<br />';
        header("Location:".$location);
    }

}
?>
</body>
</html>