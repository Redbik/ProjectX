<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>Аутентификация через Facebook</title>
</head>
<body>

<?php
include ('actions/config.php');
mysqli_set_charset($db, 'utf8');
$client_id = '1496472677386659'; // Client ID
$client_secret = '82771c1b4eabc3d240c83835afe03d2c'; // Client secret
$redirect_uri = 'http://localhost/www/ProjectX/'; // Redirect URIs

$url = 'https://www.facebook.com/dialog/oauth';

$paramsFacebook = array(
    'client_id'     => $client_id,
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'scope'         => 'email,user_birthday'
);


if (isset($_GET['code'])) {
    $result = false;

    $paramsFacebook = array(
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'client_secret' => $client_secret,
        'code'          => $_GET['code']
    );

    $url = 'https://graph.facebook.com/oauth/access_token';

    $tokenInfo = null;
    parse_str(file_get_contents($url . '?' . http_build_query($paramsFacebook)), $tokenInfo);

    if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
        $paramsFacebook = array('access_token' => $tokenInfo['access_token']);

        $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($paramsFacebook))), true);

        if (isset($userInfo['id'])) {
            $userInfo = $userInfo;
            $result = true;
        }
    }

    if ($result) {
        $query = mysqli_query($db,"SELECT name, sername, id_user FROM user where `name`= '".$userInfo['first_name']."' and `sername`='".$userInfo['last_name']."'");
//        $res=mysqli_fetch_array($query);
//        setcookie('id', $res['id_user']);
        if(mysqli_num_rows($query)==0){
            $query = mysqli_query($db,"INSERT INTO `user`(`name`, `sername`) VALUES ('".$userInfo['first_name']."','".$userInfo['last_name']."')");
            $query = 'SELECT MAX(id_user) FROM user';
            $q = mysqli_query($db, $query);
            $res=mysqli_fetch_array($q);
            $id = $res['MAX(id_user)'];
            $id = str_replace('[{"MAX(id_user)":"', '',$id);
            $id = str_replace('"}]', '',$id);
            $photo= "http://graph.facebook.com/". $userInfo['username'] ."/picture?type=large";
            $query = mysqli_query($db,"INSERT INTO `photos`(`photo`, `status`, `user_id`) VALUES ('".$photo."','2',".$id.")");

            setcookie('id', $id);

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

//        echo "Социальный ID пользователя: " . $userInfo['id'] . '<br />';
//        echo "Имя пользователя: " . $userInfo['name'] . '<br />';
//        echo "Email: " . $userInfo['email'] . '<br />';
//        echo "Ссылка на профиль пользователя: " . $userInfo['link'] . '<br />';
//        echo "Пол пользователя: " . $userInfo['gender'] . '<br />';
//        echo "ДР: " . $userInfo['birthday'] . '<br />';
//        echo '<img src="http://graph.facebook.com/' . $userInfo['username'] . '/picture?type=large" />'; echo "<br />";

}
?>

</body>
</html>