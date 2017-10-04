<?php
    include ("actions/config.php");
include ('authVk.php');
//include ('OAuth.php');


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Проверка</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Oswald:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500&amp;subset=cyrillic" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&amp;subset=cyrillic" rel="stylesheet">
</head>
<body>

<?php
//if (isset($_COOKIE['socId'])!='82532480') {
//    echo '
//     <div class="lk-c circle">
//                    <div class="login-icons">
//    ';
//    echo $link = ' <a href="' . $urlVk . '?' . urldecode(http_build_query($paramsVk)) . '"><i class="fa fa-vk"></i></a>';
////    echo $link = ' <a href="' . $urlGoogle . '?' . urldecode(http_build_query($paramsGoogle)) . '"><i class="fa fa-google"></i></a>';
//    echo '
//    </div>
//                    <span>Воити через VK</span>
//                </div>
//    ';
//    return false;
//}
?>

<div class="cabinet" id="lk" style="animation-duration: 600ms;">
    <div class="container-fluid">
        <div class="head">

            <div class="menu-point">
                <a href="#add-univer" class="menuli active-menu">
                    <span>Проверка вузов</span>
                </a>
                <a href="#check" class="menuli ">
                    <span>Проверка фото</span>
                </a>
                <a href="#add-photo" class="menuli ">
                    <span>Добавление фоток</span>
                </a>
            </div>
        </div>
        <div class="container  validate" id="check">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 clone">
                <div id="carousel_3" class="carousel slide">
                    <ol class="carousel-indicators">
                        <li class="clone" style="display:none;" data-target="#carousel_3" data-slide-to="1"></li>

                    </ol>

                    <div class="carousel-inner" >
                        <div class="about animated fadeIn">
                            <p class="about-name">Карина</p><span>,23</span> <br>
                            <p class="about-uni">Рэу им. Г.В. Плеханова</p>, <span class="about-fac">Маркетинг</span> <br>
                            <a href="" class="about-inst"><i class="fa fa-instagram contacts"></i></a>
                            <a href="" class="about-vk"><i class="fa fa-vk contacts"></i></a>
                        </div>
                        <div class="item clone">
                            <div class="photo">
                                <i class="fa fa-clock-o"></i>
                                <i class="fa fa-minus-circle"></i>
                                <div class="clearfix"></div>
                            </div>
                            <div class="validate-panel">
                                <i class="fa fa-check-circle-o" style="float: left"></i>
                                <i class="fa fa-times-circle-o"  style="float: right"></i>
                            </div>
                            <input type="hidden" class="user_id" value="1">
                            <input type="hidden" class="id_photo" value="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 plus" style="display: none">
                <i class="fa fa-plus-square-o"></i>
            </div>
        </div>
        <div class="container validate" id="add-photo">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 clone">
                <div id="carousel_13" class="carousel slide">
                    <ol class="carousel-indicators">
                        <li class="clone" style="display:none;" data-target="#carousel_13" data-slide-to="1"></li>
                    </ol>
                    <div class="carousel-inner" >
                        <div class="about animated fadeIn">
                            <p class="about-name">Карина</p><span>,23</span> <br>
                            <p class="about-uni">Рэу им. Г.В. Плеханова</p>, <span class="about-fac">Маркетинг</span> <br>
                            <a href="" class="about-inst"><i class="fa fa-instagram contacts"></i></a>
                            <a href="" class="about-vk"><i class="fa fa-vk contacts"></i></a>
                        </div>
                        <div class="item clone">
                            <div class="photo">
                                <i class="fa fa-clock-o"></i>
                                <i class="fa fa-minus-circle"></i>
                                <div class="clearfix"></div>
                            </div>
                            <input type="hidden" value="1">
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 plus">
                <i class="fa fa-plus-square-o"></i>
            </div>
        </div>
        <div class="container active validate" id="add-univer">
            <?php
                $query = mysqli_query($db, "SELECT name, id_univer FROM univers WHERE status=2");
                while ($res=mysqli_fetch_array($query)){
                    echo '
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col">
                        <form class="add-univer-form">
                            <textarea name="name">'.$res['name'].'</textarea>
                            <input type="hidden" name="id" value="'.$res['id_univer'].'">
                            <div class="validate-panel">
                                <i class="fa fa-check-circle-o" style="float: left"></i>
                                <i class="fa fa-times-circle-o"  style="float: right"></i>
                            </div>
                        </form>
                            
                        </div>
                    ';
                }
            ?>
            ?>

        </div>
    </div>
</div>
<div class="back-modal" style="display: none"></div>
<div class="add-photos" style="display: none">
    <div class="container-fluid">
        <div class="col-sm-4 col-xs-4 clone">
            <div class="photo">
            </div>

        </div>
        <div class="col-sm-4 col-xs-4 plus">
            <label for="add-photo-file">
                <i class="fa fa-plus-square-o">
                </i>
            </label>

        </div>

    </div>
    <div class="add-photo-fio">
        <form class="add-photo-form" enctype="multipart/form-data">
            <input type="file" id="add-photo-file" name="userfile">
            <input type="text" name="name" placeholder="Имя" >
            <input type="text" name="sername" placeholder="Фамилия" >
            <input type="number" name="old" placeholder="Возраст">
            <input type="text" name="univer" placeholder="ВУЗ">
            <input type="text" name="fac" placeholder="Факультет">
            <input type="text" name="vk" placeholder="Ссылка на VK">
            <input type="text" name="instagram" placeholder="Ссылка на Instagram">
            <input type="hidden" class="main_photo_hid" name="main_photo">
            <input type="hidden" class="clone-hid" name="photos">
        </form>
        <i class="fa fa-address-card ready-add" aria-hidden="true"></i>
    </div>
</div>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.cookie/jquery.cookie.js"></script>
<script src="js/check_photo.js"></script>
<script src="js/list_univers.js"></script>
<script src="js/translit.js"></script>
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

    $(".add-photos label").hover(function () {
        $(this).children(".fa-plus-square-o").css({
            color: 'rgba(51, 51, 51, 0.91)'
        });
    }, function () {
        $(this).children(".fa-plus-square-o").css({
            color: ''
        });
    });


    $('.menuli').click(function () {
        $('.menuli').each(function () {
           $(this).removeClass('active-menu');
        });
        $(this).addClass('active-menu');

        var choice = $(this).attr('href');
        $('.validate').each(function () {
            $(this).removeClass('active');
        });

        $(choice).addClass('active');
    });


    $(".validate-panel .fa-times-circle-o, .validate-panel .fa-check-circle-o").click(function () {
        var photoIndex = 0;
        $(this).parents(".carousel.slide").find('ol li.active').remove();
        $(this).parents(".carousel.slide").find('ol li:last-child').addClass('active');
        $(this).parents('.carousel-inner').children('.item').each(function (index) {
            photoIndex= index;

        });
        if (photoIndex==1){
            $(this).parents(".col-lg-3").remove();
        }
        else
            $(this).parents(".item").addClass('check-hide-photo').hide();
            $(this).parents(".carousel-inner").find(".item:not(.check-hide-photo, .clone):last").addClass('active');

    });
</script>

<script>
    $(".plus .fa-plus-square-o").click(function () {
        $(".add-photos, .back-modal").show();
    });
    $(".back-modal").click(function () {
        $(".add-photos, .back-modal").hide();
    });
    var photos = [];

    function add_photos() {
        var img = $(".add-photo-form").find("input[type=file]").val();
        if (img!=''){
            $(".add-photos .clone").clone(true).insertBefore(".add-photos .plus").removeClass("clone").children().addClass('newPhoto');
//            $(".add-photo-fio .clone-hid").clone(true).insertBefore(".add-photo-form .clone-hid").removeClass("clone-hid").addClass('newHid');
            img = img.replace("C:\\fakepath\\","");
            img = img.replace(/[\s]+/g, '');
            img = img.translit();
            img = "./users/photos/" + img;
            var formData = new FormData($(".add-photo-form")[0]);
            $.ajax({
                url: "./actions/add-photo-folder.php",
                type: "Post",
                contentType: false,
                processData: false,
                cache: false,
                data: formData,
                success: function (data) {
                    if(photos.indexOf(img) + 1) {
                        $(".newPhoto").parent().remove();
                    } else{
                        $(".border-main-photo").removeClass("border-main-photo");
                        $(".add-photos .main_photo_hid").val(img);
                        $(".add-photos .newPhoto").css({
                            background :'url('+ img +')',
                            backgroundSize: 'cover',
                            backgroundPosition: 'center'
                        }).removeClass('newPhoto').addClass("border-main-photo");
                        photos.push(img);
                        $(".add-photo-fio .clone-hid").attr('value',photos);
                    }
//                    $('#add-photo-file').parent().html($('#add-photo-file').parent().html());
                    $(".add-photo-form")[0].reset();
                }
            });
        }
    }

    $(".ready-add").click(function () {
        var form = $(".add-photo-form").serialize();
        $.ajax({
            url: './actions/add-photo.php',
            type: 'POST',
            data: form,
            success: function (data) {
                $('.add-photo-form')[0].reset();
                $(".validate#add-photo .col-lg-3:not(.clone, .plus)").remove();
                sel_users();
                $(".add-photos .container-fluid .col-sm-4:not(.clone,.plus)").each(function () {
                   $(this).remove();
                });
                photos = [];
            }
        });
    });


    function sel_users() {
        $.ajax({
            url: "./actions/select_users.php",
            type: "POST",
            dataType: "json",
            success: function (data){
                var slideTo = 1;
                var kolPhoto = 0;
                $(".validate#add-photo .col-lg-3.clone").clone(true).show().insertBefore("#add-photo .plus")
                    .removeClass("clone").children(".carousel.slide").attr('id', 'carousel_01')
                    .find("ol li").attr('data-target', '#carousel_01');
                for(var i=0;i<data.length;i++){
//                    if (kolPhoto==2) return false;
                    var prevId = $("#add-photo .plus").prev().find(".item:last input[type=hidden]").val();
                    if (prevId == data[i].id_user){
                        $("#add-photo .plus").prev().find(".item.clone").clone(true)
                            .insertAfter($("#add-photo .plus").prev().find(".item:first")).removeClass("clone")
                            .children().css({
                            background: 'url('+ data[i].photo +')',
                            backgroundSize: 'cover',
                            backgroundPosition: 'center 25%'
                        });
//                    alert(data[i].photo);

                    }
                    else{

                        $(".validate#add-photo .col-lg-3.clone").clone(true).show().insertBefore("#add-photo .plus")
                            .removeClass("clone").children(".carousel.slide").attr('id', 'carousel_0' + data[i].id_user)
                            .find("ol li").attr('data-target', '#carousel_0' + data[i].id_user);
                        $("#add-photo .plus").prev().find(".item.clone").clone(true)
                            .insertAfter($("#add-photo .plus").prev().find(".item:first")).removeClass("clone")
                            .children().css({
                            background: 'url('+ data[i].photo +')',
                            backgroundSize: 'cover',
                            backgroundPosition: 'center 25%'
                        });
                        slideTo =1;
//                        kolPhoto++;
                    }
                    $("#add-photo .plus").prev().find(".about-name").text(data[i].name);
                    $("#add-photo .plus").prev().find(".about-uni").text(data[i].univer);
                    $("#add-photo .plus").prev().find(".about-fac").text(data[i].fac);
                    $("#add-photo .plus").prev().find(".about-ins").attr('href',(data[i].instagram));
                    $("#add-photo .plus").prev().find(".about-vk").attr('href',(data[i].vk));
                    $("#add-photo .plus").prev().find("input[type=hidden]").val(data[i].id_user);

                    $("#add-photo .plus").prev().find("ol").children(".clone").clone(true)
                            .insertAfter($("#add-photo .plus").prev().find("ol li:last-child")).removeClass("clone")
                            .attr('data-slide-to', slideTo).show(function () {
                    });
                    slideTo++;
//                    alert($("#add-photo .plus").prev().find(".carousel.slide").attr('id'));
                    $("#add-photo .plus").prev().find("ol li").each(function () {
                        $(this).removeClass("active");
                        $("#add-photo .plus").prev().find("ol li:not(.clone):last-child").addClass("active");
                    });
                    $("#add-photo .plus").prev().find(".item").each(function () {
                        $(this).removeClass("active");
                        $("#add-photo .plus").prev().find(".item:not(.clone):last").addClass("active");
                    });
                }

                return false;
            }
        });
    }

    $(".add-photos .photo").click(function () {
       $(".border-main-photo").removeClass("border-main-photo");
       var mainPhoto = $(this).css('background-image');
       mainPhoto = mainPhoto.replace('url("http://localhost/www/ProjectX/', '');
       mainPhoto ='./' +  mainPhoto.replace('")', '');
       $(this).addClass("border-main-photo");
        $(".add-photos .main_photo_hid").val(mainPhoto);
    });



    $(function () {
        setInterval(add_photos, 100);
        sel_users();
        check_photo();
    });
</script>
</html>