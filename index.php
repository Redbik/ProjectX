<!DOCTYPE html>
<?php
include ('authVk.php');
include ('OAuth.php');
//    include ('authFacebook.php');
if (isset($_COOKIE['id'])){
    $id = htmlspecialchars($_COOKIE['id']);
    $queryRows = mysqli_query($db,'SELECT name, sername, univer, fac, old FROM user WHERE id_user='.$id.' and (
        name = "" or
        sername = "" or
        univer = "" or
        fac = "" or
        old = "")
        ');
    if (mysqli_num_rows($queryRows)==0){
        setcookie('auth-info', 'full');

    }
    else{
        setcookie('auth-info', 'not_full');

    }
    $query = mysqli_query($db,"SELECT name, sername, univer, fac, old, vk, instagram, main_photo, likes FROM user where `id_user`= '$id'");
    $res=mysqli_fetch_array($query);
    $main_photo=htmlspecialchars(trim($res['main_photo']));
    $name = htmlspecialchars(trim($res['name']));
    $univer = htmlspecialchars(trim($res['univer']));
    $fac = htmlspecialchars(trim($res['fac']));
    $old = htmlspecialchars(trim($res['old']));
    $vk = htmlspecialchars(trim($res['vk']));
    $userLikes = htmlspecialchars(trim($res['likes']));
    $instagram = htmlspecialchars(trim($res['instagram']));
    $query2 = mysqli_query($db,"SELECT id_photo,likes,photo,status,user_id FROM photos WHERE user_id ='$id'");
    $res2=mysqli_fetch_array($query2);
    $photo = $res2['photo'];
    $likes = $res2['likes'];

    $a = mysqli_query($db,"SELECT name, sername, univer, fac, old, vk, instagram, main_photo, likes, id_user FROM user ORDER BY likes DESC");
    $topPlace=0;
    $b = mysqli_fetch_array($a);
    for($i=0; $i<count($b); $i++){
        $topPlace = $topPlace + 1;
//    echo $b['name'].' '.$b['likes'].' '.$top.' место'.'<br>';
        if ($id==$b['id_user']){
            $top = $topPlace;
        };
        $b = mysqli_fetch_array($a);

    }
}


?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Голосование</title>
    <script src="js/granim.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,600&amp;subset=cyrillic" rel="stylesheet">
    <style>
        .prel-back{
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #333;
            z-index: 9999999;
            text-align: center;
            transition: 0s;
        }

        .prel{
            position: fixed;
            z-index: 999;
            width: 300px;
            height: 300px;
            left: calc(50% - 150px);
            top: calc(50% - 150px);
            background: #333;
            border-radius: 30px;
            overflow: hidden;
            animation: rotate 6s infinite cubic-bezier(0.51, 0.36, 0.51, 0.75);
            transition: 0s;
        }

        .prel-text{
            transition: 0s;
            text-align: center;
            position: absolute;
            top: 80%;
            margin-left: -63px;
            font-size: 1.4em;
            font-weight: bold;
            color: #fff;
            font-family: 'Roboto', sans-serif;
            animation: text 1.5s infinite cubic-bezier(0.21, 0.15, 0.5, 1.42);
        }

        #preloader{
            width: 100%;
            height: 100%;
            position: relative;
            z-index: -1;
            transition: 0s;
        }

        .prel-text span{
            transition: 0s;
            color: #ff1a4b;
        }

        @keyframes rotate {
            0%{
                transform: rotate(0deg);
                border-radius: 80px;
            }

            50%{
                transform: rotate(360deg);
                border-radius: 50%;
                width: 290px;
                height: 290px;
            }

            100%{
                transform: rotate(720deg);
                border-radius: 80px;
            }
        }

        @keyframes text {
            0%{
                margin-top: 0;
            }
            50%{
                margin-top: -15px;

            }

            100%{
                margin-top: 0;
            }
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="prel-back">
    <div class="prel">
        <canvas id="preloader"></canvas>
    </div>
    <span class="prel-text"><span>T</span>ofu loading <span>..</span></span>
</div>
<script>
    var granimInstance = new Granim({
        element: '#preloader',
        name: 'radial-gradient',
        direction: 'radial',
        opacity: [1, 0.5, 0.8],
        isPausedWhenNotInView: true,
        states : {
            "default-state": {
                gradients: [
                    ['#e0d7e1', '#92b4ba', '#ccb86f'],
                    ['#611235', '#6a4590','#1fb9bb'],
                    ['#ac2259', '#9733EE','#9d207b']

                ],
                transitionSpeed: 4000
            }
        }
    });
</script>
<div class="login-window animated bounceIn">
    <div class="lk-c circle">
        <div class="login-icons">
            <?php
            echo $link = ' <a href="' . $urlVk . '?' . urldecode(http_build_query($paramsVk)) . '"><i class="fa fa-vk"></i></a>';
            echo $link = ' <a href="' . $urlGoogle . '?' . urldecode(http_build_query($paramsGoogle)) . '"><i class="fa fa-google"></i></a>';
            echo '   <a href=""><i class="fa fa-twitter"></i></a>';
            ?>
        </div>
        <span style="color: #4abde0;">Воити через соцсети</span><br>
        <i class="fa fa-times"></i>
    </div>
</div>
<div class="auth-window animated bounceIn">
    <div class="about-auth">
        <p style="margin-bottom: 0;text-transform: uppercase; font-size: 1.2em; font-weight: 300; border-bottom: 2px solid rgba(49, 49, 49, 0.09);">
            Авторизация прошла успешно!<br>
            Для начла работы, осталось заполнить некоторые данные:
        </p>
        <form class="about-auth-form animated" style="display: block;animation-duration: 600ms;">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3" >Имя</div>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="text" name="name" value="<?php
                    echo $name;
                    ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">Возраст</div>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="text" name="old" class="old-mask" style="width: 70px" value="<?php
                    echo $old;
                    ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">Учебное заведение</div>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="text" name="univer" id="univers-mask" autocomplete="off" value="<?php
                    echo $univer;
                    ?>">
                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                    <div class="univers-list">
                        <ol>
                            <li></li>
                        </ol>
                    </div>
                    <!--                        <span>моего вуза нет в списке</span>-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">Факультет</div>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="text" name="fac" value="<?php
                    echo $fac;
                    ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">Ссылка на VK</div>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <div class="maskVk">vk.com/</div> <input type="text" name="vk" class="vk-mask" value="<?php
                    echo $vk;
                    ?>" >
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-3">Аккаунт <span id="instagram-style">Instagram</span></div>
                <div class="col-md-9 col-sm-9 col-xs-9">
                    <input type="text" name="instagram" value="<?php
                    echo $instagram;
                    ?>">
                </div>
            </div>
            <div class="row">
                <div class="ready-button animated bounceIn" id="form-auth">
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </div>
            </div>
        </form>
        <div class="add-main-photo animated fadeInRight" style="animation-duration: 600ms;display: none; position: absolute; width: 100%; top: 131px;">

            <form class="add-main-photo-form" enctype="multipart/form-data" style="padding: 12px 0px; background: #a73a5e;">
                <div class="logo-lk" style="margin-bottom: 0;">
                    <?php
                    if (empty($main_photo)){
                        $main_photo=$_COOKIE['main-photo'];
                    }
                    echo '<img src="'.$main_photo.'" alt="Главное фото">';
                    ?>
                    <input type="file" id="main-photo-auth" name="userfile">
                </div>
                <p><span class="auth-name"></span>, <span class="auth-old"></span> <br><span class="auth-univer"></span>, <span class="auth-fac"></span></p>

            </form>
            <label for="main-photo-auth" style="margin-top: 12px">
                <div class="button-edit-photo" >Изменить фото</div>
            </label><br>
            <div id="politic">
                <input type="checkbox" id="check-politic">Я даю согласие на обработку персональных данных,
                так же соглашаюсь с политикой конфиденциальности сайта
            </div>
            <div class="but-panel-auth" style="padding-top: 15px">
                <div class="ready-button" id="back-auth">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </div>
                <div class="ready-button animated bounceIn" id="finish-auth" style="display: none">
                    OK
                </div>
            </div>

        </div>

    </div>
</div>

<div class="scrollTop  hidden-sm hidden-xs">
    <a href="#likes" >
        <i class="fa fa-angle-up golike animated rotateIn" style="margin-bottom: 10px" ></i>
    </a>
        <i class="fa fa-angle-up goback" style="margin-bottom: 10px; display: none;" ></i>
    <a href="#lk" style="display: none">
        <i class="fa fa-user animated rotateIn" style="display: none;"></i>
    </a>
    <a href="#login" >
        <i class="fa fa-user-o animated rotateIn" style=""></i>
    </a>
    <i class="fa fa-thumbs-o-up animated rotateIn" style="display: none"></i>
</div>

<div class="mobile-panel visible-sm visible-xs mobile" id="">
    <div class="col-xs-3">
            <i class="fa fa-plus-square-o">
            </i>
    </div>
    <div class="col-xs-3">
        <i class="fa fa-user check-menu" style="display: none"></i>
        <i class="fa fa-user-o"></i>

    </div>
    <div class="col-xs-3">
        <i class="fa fa-thumbs-up"></i>
    </div>
    <div class="col-xs-3">
        <i class="fa fa-star"></i>
    </div>
</div>
<div class="window-delete animated bounceIn">
    <div>Удалить фото? <br>
        <button class="yes">Да</button>
        <button class="no">Нет</button>
    </div>
    <input type="hidden" class="id">
    <div></div>
</div>
<div class="cabinet animated slideInLeft" id="lk" style="display:block;animation-duration: 600ms;">
    <div class="container-fluid">

        <div class="head">
            <a href="exitLk.php">
                <i class="fa fa-sign-out mobile visible-sm visible-xs" ></i>
            </a>

            <div class="logo-lk animated" >
                <?php
                    echo '<img src="'.$main_photo.'" alt="Главное фото">';
                ?>
                </div>
                <div class="personal-info">
                    <div class="info">
                        <p class="pName">
                            <?php
                                echo $name;
                            ?>,
                        </p>
                        <p class="pOld"> 
                            21
                        </p>
                        <br>
                        <p class="pUniver">
                            <?php
                                echo $univer;
                            ?>, 
                        </p>
                        <p class="pFac">
                            <?php
                            echo $fac;
                            ?>
                        </p>
                        <div class="clearfix"></div>
                    </div>
                    <i class="fa fa-pencil"></i>
                    <div class="clearfix"></div>
                </div>




            <div class="menu-point hidden-sm hidden-xs">
                <i class="fa fa-heart"></i>
                <span><?php
                    echo $userLikes;
                    ?></span>
                <i class="fa fa-camera"></i>
                <span>5</span>
                <i class="fa fa-globe"></i>
                <span><?php
                    echo $top;
                    ?></span>
                <a href="exitLk.php">
                    <i class="fa fa-sign-out"></i>
                </a>
            </div>

            <div class="menu-point mobile visible-sm visible-xs">
                <div class="col-xs-4">
                    <i class="fa fa-heart"></i> <br>
                    <span><?php
                        echo $userLikes;
                        ?></span>
                </div>
                <div class="col-xs-4">
                    <i class="fa fa-camera"></i> <br>
                    <span>5</span>
                </div>
                <div class="col-xs-4">
                    <i class="fa fa-globe"></i> <br>
                    <span><?php
                        echo $top;
                        ?></span>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="container">
            <div class="row" id="lk-photos">
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 clone animated">
                    <div class="photo">
                        <i class="fa fa-clock-o"></i>
                        <i class="fa fa-minus-circle"></i>
                        <i class="fa fa-times delete-photo" ></i>

                        <div class="top-ph-panel">
                            <img src="img/accept-photo.png"  alt="Фото одобрено">

                        </div>
                        <div class="clearfix"></div>
                        <div class="events-c">
                            <i class="fa fa-user events-c-side" style="float: left"></i>
                            <i class="fa fa-trash events-c-side" style="float: right"></i>
                        </div>
                    </div>
                    <input type="hidden" class="id" name="id">
                </div>

                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4  hidden-sm hidden-xs plus switch">
                    <i class="fa fa-plus-square-o"></i><br>
                    <div class="plus-info animated fadeIn" style="">
                        добавить
                        <span class="photo-counter" style="transition: 0ms">0</span>
                        /4 фото
                    </div>
                </div>
            </div>
            <div class="row add-photos animated slideInUp" style="animation-duration: 300ms">
                <div class="col-md-12 visible-sm visible-xs" style="display: none;">
                    <div class="plus-info add-mobile-photo animated fadeIn" style="display: block">
                        добавить
                        <span class="photo-counter" style="transition: 0ms">0</span>
                        /4 фото
                    </div>
                    <i class="fa fa-times"></i>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 clone animated slideInUp" style="animation-duration: 300ms;">
                    <div class="photo">
                        <i class="fa fa-clock-o"></i>
                        <i class="fa fa-minus-circle"></i>
                        <i class="fa fa-times delete-photo animated fadeIn" style="animation-duration: 400ms"></i>


                    </div>


                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 plus">
                    <div class="add-photo-fio" style="display: none">
                        <form class="add-photo-form" enctype="multipart/form-data">
                            <input type="file" id="add-photo-file" name="userfile">
                            <input type="hidden" class="clone-hid" name="photos">
                        </form>
                        <i class="fa fa-address-card ready-add" aria-hidden="true"></i>
                    </div>
                    <label for="add-photo-file">
                        <i class="fa fa-plus-square-o">
                        </i>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="welcome">
        <div class="container-fluid" style="position: relative">
<!--
echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через ВКонтакте</a></p>';
echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Facebook</a></p>';


-->
                <div class="lk-c circle">
                    <div class="login-icons">
                        <?php
                        echo $link = ' <a href="' . $urlVk . '?' . urldecode(http_build_query($paramsVk)) . '"><i class="fa fa-vk"></i></a>';
                        echo $link = ' <a href="' . $urlGoogle . '?' . urldecode(http_build_query($paramsGoogle)) . '"><i class="fa fa-google"></i></a>';
                        echo '   <a href=""><i class="fa fa-twitter"></i></a>';
                        ?>

                    </div>
                    <span>Воити через соцсети</span>
                </div>
            <div class="main-c circle">
                <canvas id="canvas-basic">

                </canvas>
                <h2 id="canvas-logo">Добро пожаловать!</h2>
                <h3>Выбери самую популярную студентку твоего Вуза или... </h3>
                <h2>стань ею</h2>
            </div>
            <div class="slogan hidden-sm hidden-xs">
                <span>T</span>ofu
                <hr>
                <span>T</span>op <span>Of</span> <span>U</span>niversity
            </div>

            <a href="#likes">
                <div class="ready-c circle">
                    <span>Приступить</span> <br>
                <i class="fa fa-angle-down"></i>
                </div>
            </a>
        </div>
    </div>
    <div class="likes animated" style="animation-duration: 600ms;">
        <div class="head" id="likes">
            <div class="contauner-fluid">
                <div class="col-md-3 hidden-sm hidden-xs" >
                    <div class="title">
                        <h2 style="font-size: 2.3em">Список вузов</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="title">
                        <h2 style="font-size: 3em">Голосование</h2>
                    </div>
                </div>
                <div class="col-md-3 hidden-sm hidden-xs">
                    <h2 style="font-size: 2.3em">Топ</h2>
                </div>
            </div>
        </div>
        <div class="container-fluid ">
            <div class="col-md-3 top-padding univers" style="color: #000;">
                <div class="soon"  data-content="Скоро появится возможность просмотра участниц именно твоего вуза! Следи за обновлениями чтобы не пропустить!" data-trigger="hover" data-toggle="popover" data-placement="bottom">
                    <div>COMING SOON <BR>
                        <span>...</span>
                    </div>
                </div>
                <div class="uni-search">
                    <input type="text" placeholder="Найти ВУЗ">
                    <i class="fa fa-search"></i>
                </div>

                <a href="?vuz=ВШЭ">
                    <div class="li">
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                        ВШЭ
                    </div>
                </a>
                <a href="">
                    <div class="li">
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                        МГУ
                    </div>
                </a>
                <a href="">
                    <div class="li">
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                        МПТ
                    </div>
                </a>
            </div>
            <div class="col-md-6 top-padding">
                <div class="images" id="like-photo">

                    <!--S L I D E R   B O O T S T R A P ----------------------------------------->
                    <div id="carousel_13" class="carousel slide animated">
                        <div class="about animated fadeIn">
                            <p class="about-name">Карина</p><span class="about-old">,23</span> <br>
                            <p class="about-uni">Рэу им. Г.В. Плеханова,</p> <span class="about-fac">Маркетинг</span> <br>
                            <a href="" class="about-vk"><i class="fa fa-vk contacts"></i></a>
                            <a href="" class="about-inst"><i class="fa fa-instagram contacts"></i></a>
                        </div>
                        <li class="clone" style="display:none;" data-target="#carousel_13" data-slide-to="0"></li>

                        <ol class="carousel-indicators">
                        </ol>
                        <div class="item clone ">
                            <div class="image animated"  style="animation-duration: 500ms">


                            </div>
                            <input type="hidden" value="1">
                        </div>
                        <div class="carousel-inner" >
                            <a href="#carousel_13" class="left carousel-control" data-slide="prev">
                                <i class="glyphicon glyphicon-chevron-left"></i>
                            </a>
                            <a href="#carousel_13" class="right carousel-control" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="image-panel">
                    <i class="fa fa-angle-left backFoto" style="float: left; padding-right: 9px;"></i>
                    <i class="fa fa-heart" style="font-size: 3em; padding-top: 21px"></i>
                    <i class="fa fa-angle-right" style="float: right; padding-left: 9px;"></i>
                </div>
            </div>
            <div class="col-md-3 top-padding">
                <div class="top-grid">
                    <div class="col-md-12 col-sm-3 col-xs-12 clone">
                        <div class="top-grid-photo ">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="fulltop animated" style="animation-duration: 600ms">

        <div class="container-fluid">
            <div class="container" id="firsttop">
                <h2>-МИСС Tofu!-</h2>
                <div class="images">

                    <!--S L I D E R   B O O T S T R A P ----------------------------------------->
                    <div id="carousel_firsttop" class="carousel slide">
                        <div class="about animated slideInDown">
                            <p class="about-name">Карина</p><span class="about-old">,23</span> <br>
                            <p class="about-uni">Рэу им. Г.В. Плеханова,</p> <span class="about-fac">Маркетинг</span> <br>
                            <a href="" class="about-vk"><i class="fa fa-vk contacts"></i></a>
                            <a href="" class="about-inst"><i class="fa fa-instagram contacts"></i></a>
                        </div>
                        <li class="clone" style="display:none;" data-target="#carousel_firsttop" data-slide-to="0"></li>

                        <ol class="carousel-indicators">

                        </ol>
                        <div class="item clone">
                            <div class="image"></div>
                            <input type="hidden" value="1">
                        </div>
                        <div class="carousel-inner" >
                            <a href="#carousel_firsttop" class="left carousel-control" data-slide="prev">
                                <i class="glyphicon glyphicon-chevron-left"></i>
                            </a>
                            <a href="#carousel_firsttop" class="right carousel-control" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            <h2>-Лучшие участницы-</h2>
                <div class="row" id="fulltop">
                    <div class="col-md-4 col-sm-4 col-xs-12 clone">
                        <div class="images">

                            <!--S L I D E R   B O O T S T R A P ----------------------------------------->
                            <div id="carousel_5" class="carousel slide">
                                <div class="about animated slideInDown">
                                    <p class="about-name">Карина</p><span class="about-old">,23</span> <br>
                                    <p class="about-uni">Рэу им. Г.В. Плеханова,</p> <span class="about-fac">Маркетинг</span> <br>
                                    <a href="" class="about-vk"><i class="fa fa-vk contacts"></i></a>
                                    <a href="" class="about-inst"><i class="fa fa-instagram contacts"></i></a>
                                </div>
                                <ol class="carousel-indicators">
                                    <li class="clone" style="display:none;" data-target="#carousel_13" data-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner" >
                                    <div class="item clone">
                                        <div class="image animated fadeInLeft">

                                        </div>
                                        <input type="hidden" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 plus" style="display: none">
                        <i class="fa fa-plus-square-o"></i>
                    </div>
                </div>
        </div>
    </div>

<div class="footer"></div>
<div class="back-modal animated" id="auth-window" style="background: rgba(255, 255, 255, 0.61); z-index: 999999"></div>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/animate.css">
<link rel="stylesheet" href="css/nprogress.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
<link href="https://fonts.googleapis.com/css?family=Oswald:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500&amp;subset=cyrillic" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lobster&amp;subset=cyrillic" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Dosis:500,600" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.cookie/jquery.cookie.js"></script>
<script src="js/jquery.touchSwipe.min.js"></script>
<script src="js/jquery.maskedinput.js"></script>
<script src="js/nprogress.js"></script>
<script src="js/list_univers.js"></script>
<!--<script src="js/translit.js"></script>-->

<script src="js/lk.js"></script>
<script src="js/top.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
        integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
        crossorigin="anonymous"></script>

<script>

    String.prototype.translit = (function(){
        var L = {
                'А':'A','а':'a','Б':'B','б':'b','В':'V','в':'v','Г':'G','г':'g',
                'Д':'D','д':'d','Е':'E','е':'e','Ё':'Yo','ё':'yo','Ж':'Zh','ж':'zh',
                'З':'Z','з':'z','И':'I','и':'i','Й':'Y','й':'y','К':'K','к':'k',
                'Л':'L','л':'l','М':'M','м':'m','Н':'N','н':'n','О':'O','о':'o',
                'П':'P','п':'p','Р':'R','р':'r','С':'S','с':'s','Т':'T','т':'t',
                'У':'U','у':'u','Ф':'F','ф':'f','Х':'Kh','х':'kh','Ц':'Ts','ц':'ts',
                'Ч':'Ch','ч':'ch','Ш':'Sh','ш':'sh','Щ':'Sch','щ':'sch','Ъ':'"','ъ':'"',
                'Ы':'Y','ы':'y','Ь':"'",'ь':"'",'Э':'E','э':'e','Ю':'Yu','ю':'yu',
                'Я':'Ya','я':'ya'
            },
            r = '',
            k;
        for (k in L) r += k;
        r = new RegExp('[' + r + ']', 'g');
        k = function(a){
            return a in L ? L[a] : '';
        };
        return function(){
            return this.replace(r, k);
        };
    })();


    $(".old-mask").mask("99", {placeholder: ""});
    $(function () {
        $(".auth-window input#check-politic").click(function () {
//        alert($("input#check-politic").attr("checked"));
            if($(this).is(':checked')) {
                $("#finish-auth").show();
            }
            else{
                $("#finish-auth").hide();

            }
        });
    });


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        $('[data-toggle="popover"]').popover()
    });
    var granimInstance = new Granim({
        element: '#canvas-basic',
        name: 'radial-gradient',
        direction: 'radial',
        opacity: [1, 0.5, 0.8],
        isPausedWhenNotInView: true,
        states : {
            "default-state": {
                gradients: [
                    ['#61045F', '#960494','#61045F'],
                    ['#c08218', '#24ba5d', '#ccb86f'],
                    ['#1fb9bb', '#6a4590','#611235'],
                    ['#da2c73', '#9733EE','#da2c73']

                ],
                transitionSpeed: 4000
            }
        }
    });






    function select_foto() {
        $.ajax({
            url: './actions/select_foto.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            success: function (data) {
                $(".backFoto").removeClass("noToch");
                var slideTo = 0;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].photo == data[0].main_photo)
                        var mainPhoto = data[i].photo;
                    $("#like-photo").find(".item.clone").clone(true)
                        .appendTo($("#like-photo .carousel-inner")).removeClass("clone")
                        .children().css({
                        background: 'url(' + data[i].photo + ')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    });


//                    }
//                    alert(data[i].name);
                    $("#like-photo").find(".about-name").text(data[i].name + ', ');
                    $("#like-photo").find(".about-old").text(data[i].old);
                    $("#like-photo").find(".about-uni").text(data[i].univer + ', ');
                    $("#like-photo").find(".about-fac").text(data[i].fac);
                    if (data[i].instagram == '')
                        $("#like-photo").find(".about-inst").hide();
                    else
                        $("#like-photo").find(".about-inst").attr('href', 'https://instagram.com/' + data[i].instagram);
                    if (data[i].vk == '')
                        $("#like-photo").find(".about-vk").hide();
                    else
                        $("#like-photo").find(".about-vk").attr('href', 'https://vk.com/' + data[i].vk);
                    $("#like-photo").find("input[type=hidden]").val(data[i].id_user);

                    $("#like-photo").find("li.clone").clone(true)
                        .appendTo($("#like-photo").find("ol")).removeClass("clone")
                        .attr('data-slide-to', slideTo).show(function () {
                    });
                    slideTo++;
//                    alert($("#like-photo .plus").prev().find(".carousel.slide").attr('id'));
                    $("#like-photo").find("ol li").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find("ol li:not(.clone):last-child").addClass("active");
                    });
                    $("#like-photo").find(".item").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find(".item:not(.clone):last").addClass("active");
                    });
                }
//--------------Вывод главной фотки v
                if (mainPhoto != undefined) {
                    $("#like-photo").find(".item.clone").clone(true)
                        .appendTo($("#like-photo .carousel-inner")).removeClass("clone")
                        .children().css({
                        background: 'url(' + mainPhoto + ')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    });
                    $("#like-photo").find(".item").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find(".item:not(.clone):last").addClass("active");
                    });
                    $("#like-photo").find("ol li").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find("ol li:not(.clone):last-child").addClass("active");
                    });
                    var eqPhoto = [];
                    $("#like-photo").find(".item:not(.clone)").each(function (index) {
                        var backImg = $(this).children().css('background-image');
                        if (eqPhoto.indexOf(backImg) + 1) {
                            $("#like-photo").find(".item:not(.clone)").each(function () {
                                if ($(this).children().css('background-image') == backImg) {
                                    $(this).remove();
                                    return false;
                                }
                            });
                        }
                        else {
                            eqPhoto.push(backImg);
                        }
                    });
                }
//--------------Вывод главной фотки ^
                $("#like-photo .item:last-child").children().addClass("rotateInDownRight");
//                return false;
            }
        });
    }

    $(".image-panel .fa-angle-right").click(function () {
        select_foto();
        $('#like-photo .carousel-inner').children(":not(a)").remove();
        $('#like-photo ol').children().remove();
        $(".right, .left").each(function (index) {
        });
    });

    function back_foto() {
        $.ajax({
            url: './actions/back_foto.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            success: function (data){
                var slideTo = 0;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].photo == data[0].main_photo)
                        var mainPhoto = data[i].photo;
                    $("#like-photo").find(".item.clone").clone(true)
                        .appendTo($("#like-photo .carousel-inner")).removeClass("clone")
                        .children().css({
                        background: 'url(' + data[i].photo + ')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    });

//                    }
//                    alert(data[i].name);
                    $("#like-photo").find(".about-name").text(data[i].name + ', ');
                    $("#like-photo").find(".about-old").text(data[i].old);
                    $("#like-photo").find(".about-uni").text(data[i].univer + ', ');
                    $("#like-photo").find(".about-fac").text(data[i].fac);
                    if (data[i].instagram == '')
                        $("#like-photo").find(".about-inst").hide();
                    else
                        $("#like-photo").find(".about-inst").attr('href', 'https://instagram.com/' + data[i].instagram);
                    if (data[i].vk == '')
                        $("#like-photo").find(".about-vk").hide();
                    else
                        $("#like-photo").find(".about-vk").attr('href', 'https://vk.com/' + data[i].vk);
                    $("#like-photo").find("input[type=hidden]").val(data[i].id_user);

                    $("#like-photo").find("li.clone").clone(true)
                        .appendTo($("#like-photo").find("ol")).removeClass("clone")
                        .attr('data-slide-to', slideTo).show(function () {
                    });
                    slideTo++;
//                    alert($("#like-photo .plus").prev().find(".carousel.slide").attr('id'));
                    $("#like-photo").find("ol li").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find("ol li:not(.clone):last-child").addClass("active");
                    });
                    $("#like-photo").find(".item").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find(".item:not(.clone):last").addClass("active");
                    });
                }
//--------------Вывод главной фотки v
                if (mainPhoto != undefined) {
                    $("#like-photo").find(".item.clone").clone(true)
                        .appendTo($("#like-photo .carousel-inner")).removeClass("clone")
                        .children().css({
                        background: 'url(' + mainPhoto + ')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    });
                    $("#like-photo").find(".item").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find(".item:not(.clone):last").addClass("active");
                    });
                    $("#like-photo").find("ol li").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find("ol li:not(.clone):last-child").addClass("active");
                    });
                    var eqPhoto = [];
                    $("#like-photo").find(".item:not(.clone)").each(function (index) {
                        var backImg = $(this).children().css('background-image');
                        if (eqPhoto.indexOf(backImg) + 1) {
                            $("#like-photo").find(".item:not(.clone)").each(function () {
                                if ($(this).children().css('background-image') == backImg) {
                                    $(this).remove();
                                    return false;
                                }
                            });
                        }
                        else {
                            eqPhoto.push(backImg);
                        }
                    });
                }
//--------------Вывод главной фотки ^
                $("#like-photo .item:last-child").children().addClass("rotateInDownLeft");
                return false;
            }
        });
    }

    $(".image-panel .fa-angle-left").click(function () {
        back_foto();
        $(this).addClass('noToch');
        $('#like-photo .carousel-inner').children(":not(a)").remove();
        $('#like-photo ol').children().remove();
        $(".right, .left").each(function (index) {
        });
    });

    function like_foto() {
//        $("#like-photo .item:last-child").addClass("rotateOutUpLeft", function () {
//        });
        $.ajax({
            url: './actions/like_foto.php',
            type: 'POST',
            dataType: 'json',
            cache: false,
            success: function (data){
                $(".backFoto").removeClass("noToch");

//                alert(data);
                var slideTo = 0;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].photo == data[0].main_photo)
                        var mainPhoto = data[i].photo;
                    $("#like-photo").find(".item.clone").clone(true)
                        .appendTo($("#like-photo .carousel-inner")).removeClass("clone")
                        .children().css({
                        background: 'url(' + data[i].photo + ')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    });


//                    }
//                    alert(data[i].name);
                    $("#like-photo").find(".about-name").text(data[i].name + ', ');
                    $("#like-photo").find(".about-old").text(data[i].old);
                    $("#like-photo").find(".about-uni").text(data[i].univer + ', ');
                    $("#like-photo").find(".about-fac").text(data[i].fac);
                    if (data[i].instagram == '')
                        $("#like-photo").find(".about-inst").hide();
                    else
                        $("#like-photo").find(".about-inst").attr('href', 'https://instagram.com/' + data[i].instagram);
                    if (data[i].vk == '')
                        $("#like-photo").find(".about-vk").hide();
                    else
                        $("#like-photo").find(".about-vk").attr('href', 'https://vk.com/' + data[i].vk);
                    $("#like-photo").find("input[type=hidden]").val(data[i].id_user);

                    $("#like-photo").find("li.clone").clone(true)
                        .appendTo($("#like-photo").find("ol")).removeClass("clone")
                        .attr('data-slide-to', slideTo).show(function () {
                    });
                    slideTo++;
//                    alert($("#like-photo .plus").prev().find(".carousel.slide").attr('id'));
                    $("#like-photo").find("ol li").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find("ol li:not(.clone):last-child").addClass("active");
                    });
                    $("#like-photo").find(".item").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find(".item:not(.clone):last").addClass("active");
                    });
                }
//--------------Вывод главной фотки v
                if (mainPhoto != undefined) {
                    $("#like-photo").find(".item.clone").clone(true)
                        .appendTo($("#like-photo .carousel-inner")).removeClass("clone")
                        .children().css({
                        background: 'url(' + mainPhoto + ')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    });
                    $("#like-photo").find(".item").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find(".item:not(.clone):last").addClass("active");
                    });
                    $("#like-photo").find("ol li").each(function () {
                        $(this).removeClass("active");
                        $("#like-photo").find("ol li:not(.clone):last-child").addClass("active");
                    });
                    var eqPhoto = [];
                    $("#like-photo").find(".item:not(.clone)").each(function (index) {
                        var backImg = $(this).children().css('background-image');
                        if (eqPhoto.indexOf(backImg) + 1) {
                            $("#like-photo").find(".item:not(.clone)").each(function () {
                                if ($(this).children().css('background-image') == backImg) {
                                    $(this).remove();
                                    return false;
                                }
                            });
                        }
                        else {
                            eqPhoto.push(backImg);
                        }
                    });
                }
//--------------Вывод главной фотки ^
                $("#like-photo .item:last-child").children().addClass("pulse");

                return false;
            }
        });
    }

    function ckeck_menu_user() {
        $(".cabinet").show().removeClass("slideOutLeft").addClass("slideInLeft");
        $(".fulltop").removeClass("slideInRight").addClass("slideOutRight");
        $(".likes").removeClass("slideInRight").addClass("slideOutRight");
        $("body").css('overflow', 'hidden');
        $(".cabinet").css('overflow', 'auto');
    }

    $(".image-panel .fa-heart").click(function () {
        like_foto();
        $('#like-photo .carousel-inner').children(":not(a)").remove();
        $('#like-photo ol').children().remove();
        $(".right, .left").each(function (index) {
        });
    });

    $(".add-photos label").hover(function () {
        $(this).children(".fa-plus-square-o").css({
            color: 'rgba(51, 51, 51, 0.91)'
        });
    }, function () {
        $(this).children(".fa-plus-square-o").css({
            color: ''
        });

    }).click(function () {
        $(".add-photos").children().each(function (index) {
            if (index == 6 ){
                $(".add-photos .plus").remove();
            }
        })
    });

    $(".cabinet .plus.switch .fa").hover(function () {
        $(".plus-info").css('text-shadow','0 0 1px rgba(255, 0, 0, 0.93)');

    }, function () {
        $(".plus-info").css('text-shadow','none');

    });
    $(function () {
        $(".cabinet .switch.plus .fa").click(function () {
            var h = $(".add-photos").css('height');
//        alert();
            if (h == '0px'){
                $(".add-photos").animate({
                    minHeight: '270px'
                }, 10, "linear", function () {
                    $(".cabinet").animate({
                        scrollTop: 9999
                    });
                });
            }
            else{
                $(".add-photos").animate({
                    minHeight: '0px'
                }, 10, "easeInQuad");
            }

        });
    });



    $(".photo").hover(function () {
        $(this).find(".events-c").addClass("events-c-hover");
        $(this).find(".number-ph-like").addClass("number-ph-like-hover");
    }, function () {
        $(this).find(".events-c").removeClass("events-c-hover");
        $(this).find(".number-ph-like").removeClass("number-ph-like-hover");

    });

    $(".add-photo-form input").hover(function () {
        $(this).parent().prev(".fa-plus-square-o").css({
            color: 'rgba(51, 51, 51, 0.91)'
        });
    }, function () {
        $(this).parent().prev(".fa-plus-square-o").css({
            color: ''
        });
    });

    $(".fa-heart").hover(function () {
        $(this).addClass("animated pulse");
    }, function () {
        $(this).removeClass("animated pulse");

    });


    $(".li").hover(function () {
        $(this).children(".fa-angle-down").css({
            transform: 'rotate(-90deg)',
            background: 'rgba(255, 255, 255, 0.52)'
        });
    }, function () {
        $(this).children(".fa-angle-down").css({
            transform: '',
            background: ''
        });
    });

    if ($(window).scrollTop() > $("#likes").offset().top)
        $(".scrollTop").find(".fa-angle-up").css('transform', 'rotate(0deg)');
    else
        $(".scrollTop").find(".fa-angle-up").css('transform', 'rotate(180deg)');

    if ($(window).scrollTop() > $("#likes").offset().top + 200){
        $(".scrollTop i").css('background', 'rgba(216, 216, 216, 0.44)');
    } else{
        $(".scrollTop i").css('background', '');

    }

    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > $("#likes").offset().top){
                $(".scrollTop").find(".fa-angle-up").css('transform', 'rotate(0deg)');
            }
            else{
                $(".scrollTop").find(".fa-angle-up").css('transform', 'rotate(180deg)');
            }
//        rgba(216, 216, 216, 0.44)
            if ($(this).scrollTop() > $("#likes").offset().top + 200){
                $(".scrollTop i").css('background', 'rgba(216, 216, 216, 0.44)');
            } else{
                $(".scrollTop i").css('background', '');

            }
        });

        $('a:not(.carousel-control, .goback)').click(function () {
            var href = $(this).attr("href");
//            alert(href);
            $("html").animate({
                scrollTop: $(href).offset().top
            }, 700);
        });

        $(".scrollTop .fa-angle-up").click(function () {
            var back = $(window).scrollTop();
            $(this).attr("id", back).hide();
            $(".goback").show();

        });

        $(".goback").click(function () {
            $(".scrollTop").find(".fa-angle-up").show();
            $(this).hide();
            var back = $(".scrollTop .fa-angle-up").attr("id");
            $("html").animate({
                scrollTop: back
            }, 700, function () {
//                alert(1);
            });
        });

    });


    $(".scrollTop .fa-user").click(function () {
        $(".cabinet").show().removeClass("slideOutLeft").addClass("slideInLeft");
        $(".likes, .fulltop").removeClass("slideInRight").addClass("slideOutRight");
        $(this).hide().parent().next().show();
        $(".scrollTop .fa-angle-up").hide();
        $("body").css('overflow', 'hidden');
        $(".cabinet").css('overflow', 'auto');

    });

    $(".scrollTop .fa-thumbs-o-up").click(function () {
        $(".likes, .fulltop").removeClass("slideOutRight").addClass("slideInRight");
        $(".cabinet").removeClass("slideInLeft").addClass("slideOutLeft");
        $(this).hide().prev().children().show();
        $(".scrollTop .golike").show();
        $("body").css('overflow-y', 'auto');
    });

    $(".mobile-panel .fa").click(function () {
        if ($(this).attr('class')!='fa fa-plus-square-o' && $(this).attr('class')!='fa fa-user-o'){
            $(".mobile-panel .check-menu").removeClass("check-menu");
            $(this).not(".fa-plus-square-o, .fa-user-o").addClass('check-menu');
        }
    });

    $(".mobile-panel .fa-user").click(function () {
        ckeck_menu_user();
    });

    $(".mobile-panel .fa-thumbs-up").click(function () {
        $(".likes").removeClass("slideOutRight").addClass("slideInRight");
        $(".fulltop").removeClass("slideInRight").addClass("slideOutRight");
        $(".cabinet").removeClass("slideInLeft").addClass("slideOutLeft");
        $("body").css('overflow-y', 'auto');

    });

    $(".mobile-panel .fa-star").click(function () {
        $(".likes").removeClass("slideInRight").addClass("slideOutRight");
        $(".cabinet").removeClass("slideInLeft").addClass("slideOutLeft");
        $(".fulltop").show().removeClass("slideOutRight").addClass("slideInRight");
        $("body").css('overflow', 'hidden');
        $(".fulltop").css('overflow', 'auto');
    });







    function add_main_photo() {

        var img = $(".add-main-photo-form").find("input[type=file]").val();
        if (img!=''){
            img = img.replace("C:\\fakepath\\","");
            img = img.replace(/[\s]+/g, '');
            img = img.translit();
            img = "./users/photos/" + img;
            var formData = new FormData($(".add-main-photo-form")[0]);
            $.ajax({
                url: "./actions/add-photo-folder.php",
                type: "Post",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function (data) {
                    $(".logo-lk img").attr('src',img).removeClass('newPhoto');
//                    $(".add-photo-fio .clone-hid").attr('value',photos);
//                    $('#main-photo-auth').parent().html($('#main-photo-auth').parent().html());
                }
            });
        }
    }

    function editCabinetInfo() {
        $(".cabinet .pName").text($(".auth-window input[name=name]").val() + ', ');
        $(".cabinet .pOld").text($(".auth-window input[name=old]").val());
        $(".cabinet .pUniver").text($(".auth-window input[name=univer]").val()+ ', ');
        $(".cabinet .pFac").text($(".auth-window input[name=fac]").val());
    }


    $("#finish-auth").click(function () {
        var img = $(".add-main-photo-form").find("input").val();
        img = img.replace("C:\\fakepath\\","");
        img = img.replace(/[\s]+/g, '');
        img = img.translit();
        img = "./users/photos/" + img;
        if (img='./users/photos/'){
            img = $(".add-main-photo-form").find("img").attr('src');
        }
        $.ajax({
            url: "./actions/add-main-photo.php",
            type: "Post",
            data: {"data":img},
            success: function (data) {
                $(".auth-window, .back-modal#auth-window").addClass('bounceOut').hide().removeClass('bounceOut');
                $(".cabinet #lk-photos .col-lg-3:not(.plus, .clone)").remove();
                sel_photos_lk();
                editCabinetInfo();
                $(".cabinet").removeClass("blur");
            }
        });
    });

    $(".auth-window input").keyup(function () {

        $(".about-auth-form input:not(input[name=instagram],input[name=vk] )").each(function () {
            if ($(this).val()!=""){
                $(".ready-button#form-auth").show();
            }
            else{
                $(".ready-button#form-auth").hide();
                return false;

            }
        });
    });

    $(".about-auth-form input:not(input[name=instagram],input[name=vk] )").each(function () {
        if ($(this).val()!=""){
            $(".ready-button#form-auth").show();
        }
        else{
            $(".ready-button#form-auth").hide();
            return false;

        }
    });

    $(".ready-button").click(function () {
        $(".about-auth-form").removeClass("fadeItLeft").addClass("fadeOutLeft");
        $(".add-main-photo").show().removeClass("fadeOutRight").addClass("fadeInRight");
        var data = $(".about-auth-form").serialize();

        $.ajax({
            url: "./actions/auth-finish.php",
            type: "Post",
            data: data,
            success: function (data) {

                $("span.auth-name").text($("input[name=name]").val());
                $("span.auth-old").text($("input[name=old]").val());
                $("span.auth-univer").text($("input[name=univer]").val());
                $("span.auth-fac").text($("input[name=fac]").val());
            }
        });
    });
    $(".ready-button#back-auth").click(function () {
        $(".about-auth-form").removeClass("fadeOutLeft").addClass("fadeInLeft");
        $(".add-main-photo").removeClass("fadeInRight").addClass("fadeOutRight");
    });

    $(".fa-caret-down").click(function () {
        if ($(this).next().css('height')=='200px'){
            $(this).next().show().animate({
                opacity: 0,
                height: 0
            }, 10);
        }
        else{
            $(this).next().show().animate({
                opacity: 1,
                height: 200
            }, 10);
        }
    });

    $(".univers-list li").click(function () {
        $("#univers-mask").val($(this).text());
        $(".univers-list").animate({
            opacity: 0,
            height: 0
        }, 10);
    });

    $(".scrollTop a[href='#login'], .mobile-panel .fa-user-o").click(function () {
        $(".login-window").show();
        $(".welcome, .likes, .scrollTop, .fulltop").addClass("blur");
        $(".back-modal").css({
            'background': 'transparent',
            'z-index': 9999
        }).show();
//        alert(1);

    });

    $(".login-window .fa-times").click(function () {
        $(".login-window, .back-modal").hide();
        $(".welcome, .likes, .scrollTop, .fulltop").removeClass("blur");

    });



    $(function () {
        var width=screen.width; // ширина
//        alert(width);
        if (width<=768){
//            alert(1);
            $(".add-photos").insertBefore('.cabinet');
        }
        if (width>=1440){
//            alert(1);
//            $(".head h2:contains('Топ')").text('');

        }

        var authInfo= $.cookie('auth-info');
        var authId= $.cookie('id');
        if (authInfo=='not_full' && $.cookie('id')!='null'){
            $('.auth-window, .back-modal#auth-window').show();
        }
        if ($.cookie('id')>='0'){
            $(".welcome").remove();
            $(".scrollTop a[href='#lk']").show();
            $(".mobile-panel .fa-user").show();
            $(".scrollTop a[href='#login']").remove();
            $(".mobile-panel .fa-user-o").remove();
            $(".scrollTop .fa-thumbs-o-up").show();
            $(".scrollTop .golike").hide();
            $("body").css('overflow', 'hidden');
            $(".cabinet").css('overflow', 'auto');
        }else{
            $(".mobile-panel .fa-plus-square-o").remove();
            $(".mobile-panel").css('padding-right', '85px');
            $(".cabinet").remove();
            $(".mobile-panel .fa-thumbs-up").addClass("check-menu");

        }



        setInterval(add_photos, 100);
        setInterval(add_main_photo, 100);
        sel_photos_lk();
        list_univers();
        select_foto();
        sel_top();
        firstTop();
        left_top();
    });


    //    $(function() {
    //        //Keep track of how many swipes
    //        var count=0;
    //        //Enable swiping...
    //        $(".image").swipe( {
    //            //Single swipe handler for left swipes
    //            swipeLeft:function() {
    //                alert(1);
    //            },
    //            //Default is 75px, set to 0 for demo so any distance triggers swipe
    //            threshold:0
    //        });
    //    });
</script>
<script>
    $(window).on('load', function () {
        $(".prel-back").delay(1000).fadeOut(1000);
    });
    //    $(".prel").hide();
</script>
</body>

</html>
