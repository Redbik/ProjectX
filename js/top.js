/**
 * Created by Alexander on 24.09.2017.
 */
function sel_top() {
    $.ajax({
        url: "./actions/select_top.php",
        type: "POST",
        dataType: "json",
        success: function (data){
            // alert(data[0].main_photo);

            var slideTo = 1;
            var kolPhoto = 0;
            $(".fulltop #fulltop .col-md-4.clone").clone(true).show().insertBefore("#fulltop .plus")
                .removeClass("clone").find(".carousel.slide").attr('id', 'carousel_01')
                .find("ol li").attr('data-target', '#carousel_01');
            for(var i=0;i<data.length;i++){
//                    if (kolPhoto==2) return false;
                if (data[i].photo == data[0].main_photo)
                    var mainPhoto = data[i].photo;
                var prevId = $("#fulltop .plus").prev().find(".item:last input[type=hidden]").val();
                if (prevId == data[i].id_user){
                    $("#fulltop .plus").prev().find(".item.clone").clone(true)
                        .insertAfter($("#fulltop .plus").prev().find(".item:first")).removeClass("clone")
                        .children().css({
                        background: 'url('+ data[i].photo +')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    });
//                    alert(data[i].photo);

                }
                else{

                    $(".fulltop #fulltop .col-md-4.clone").clone(true).show().insertBefore("#fulltop .plus")
                        .removeClass("clone").find(".carousel.slide").attr('id', 'carousel_0' + data[i].id_user)
                        .find("ol li").attr('data-target', '#carousel_0' + data[i].id_user);
                    $("#fulltop .plus").prev().find(".item.clone").clone(true)
                        .insertAfter($("#fulltop .plus").prev().find(".item:first")).removeClass("clone")
                        .children().css({
                        background: 'url('+ data[i].photo +')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    });
                    slideTo =1;
//                        kolPhoto++;
                }
                $("#fulltop .plus").prev().find(".about-name").text(data[i].name);
                $("#fulltop .plus").prev().find(".about-old").text(data[i].old);
                $("#fulltop .plus").prev().find(".about-uni").text(data[i].univer);
                $("#fulltop .plus").prev().find(".about-fac").text(data[i].fac);
                if (data[i].instagram=='')
                    $("#fulltop .plus").prev().find(".about-inst").hide();
                else
                    $("#fulltop .plus").prev().find(".about-inst").attr('href','https://instagram.com/'+data[i].instagram);
                if (data[i].vk=='')
                    $("#fulltop .plus").prev().find(".about-vk").hide();
                else
                    $("#fulltop .plus").prev().find(".about-vk").attr('href','https://vk.com/'+data[i].vk);

                $("#fulltop .plus").prev().find("input[type=hidden]").val(data[i].id_user);

                $("#fulltop .plus").prev().find("ol").children(".clone").clone(true)
                    .insertAfter($("#fulltop .plus").prev().find("ol li:last-child")).removeClass("clone")
                    .attr('data-slide-to', slideTo).show(function () {
                });
                slideTo++;
//                    alert($("#fulltop .plus").prev().find(".carousel.slide").attr('id'));
                $("#fulltop .plus").prev().find("ol li").each(function () {
                    $(this).removeClass("active");
                    $("#fulltop .plus").prev().find("ol li:not(.clone):last-child").addClass("active");
                });
                $("#fulltop .plus").prev().find(".item").each(function () {
                    $(this).removeClass("active");
                    $("#fulltop .plus").prev().find(".item:not(.clone):last").addClass("active");
                });
            }
            $("#fulltop").find(".col-md-4.clone").next().remove();
//--------------Вывод главной фотки v
            if (mainPhoto != undefined) {
                    $("#fulltop .plus").prev().find(".item.clone").clone(true)
                        .insertAfter($("#fulltop .plus").prev().find(".item:first")).removeClass("clone")
                        .children().css({
                        background: 'url('+ mainPhoto +')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    });
                $("#fulltop .plus").prev().find(".item.clone").clone(true)
                    .insertAfter($("#fulltop .plus").prev().find(".item:first")).removeClass("clone")
                    .children().css({
                    background: 'url('+ data[0].main_photo +')',
                    backgroundSize: 'cover',
                    backgroundPosition: 'center 25%'
                });
                $("#fulltop .plus").prev().find(".item").each(function () {
                    $(this).removeClass("active");
                    $("#fulltop .plus").prev().find(".item:not(.clone):last").addClass("active");
                });
                $("#fulltop .plus").prev().find("ol li").each(function () {
                    $(this).removeClass("active");
                    $("#fulltop .plus").prev().find("ol li:not(.clone):last-child").addClass("active");
                });
                var eqPhoto =[];
                $("#fulltop .plus").prev().find(".item:not(.clone)").each(function (index) {
                    var backImg= $(this).children().css('background-image');
                    if (eqPhoto.indexOf(backImg) + 1){
                        $("#fulltop .plus").prev().find(".item:not(.clone)").each(function () {
                            if ($(this).children().css('background-image') == backImg){
                                $(this).remove();
                                return false;
                            }
                        });
                    }
                    else{
                        eqPhoto.push(backImg);
                    }
                });
            }
//--------------Вывод главной фотки ^
            $("#fulltop .col-md-4.clone").next().remove();
            return false;
        }
    });
}

function firstTop() {

    $.ajax({
        url: "./actions/select_top.php",
        type: "POST",
        dataType: "json",
        success: function (data){
            // alert(data[0].id_user);


            var slideTo = 1;
            $("#firsttop").find(".item.clone").clone(true)
                .appendTo($("#firsttop .carousel-inner")).removeClass("clone")
                .children(".image").css({
                background: 'url('+ data[0].photo +')',
                backgroundSize: 'cover',
                backgroundPosition: 'center 25%'
            }).next("input").val(data[0].id_user);
            // alert($("#firsttop").find(".item.clone").children(".image").next().val());
            $("#firsttop").find("li.clone").clone(true)
                .appendTo($("#firsttop").find("ol")).removeClass("clone")
                .attr('data-slide-to', 0).show();
            $("#firsttop").find(".about-name").text(data[0].name);
            $("#firsttop").find(".about-old").text(data[0].old);
            $("#firsttop").find(".about-uni").text(data[0].univer);
            $("#firsttop").find(".about-fac").text(data[0].fac);
            if (data[0].instagram=='')
                $("#firsttop").find(".about-inst").hide();
            else
                $("#firsttop").find(".about-inst").attr('href','https://instagram.com/'+data[0].instagram);
            if (data[0].vk=='')
                $("#firsttop").find(".about-vk").hide();
            else
                $("#firsttop").find(".about-vk").attr('href','https://vk.com/'+data[0].vk);
            for(var i=1;i<data.length;i++) {
                if (data[i].photo == data[0].main_photo)
                    var mainPhoto = data[i].photo;
                var prevId = $("#firsttop .carousel-inner").find(".item input[type=hidden]:last-child").val();

                if (prevId == data[i].id_user) {
                    $("#firsttop").find(".item.clone").clone(true)
                        .appendTo($("#firsttop .carousel-inner")).removeClass("clone")
                        .children(".image").css({
                        background: 'url('+ data[i].photo +')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    });


//                    }
//                    alert(data[i].name);


                    $("#firsttop").find("input[type=hidden]").val(data[i].id_user);

                    $("#firsttop").find("li.clone").clone(true)
                        .appendTo($("#firsttop").find("ol")).removeClass("clone")
                        .attr('data-slide-to', slideTo).show(function () {
                    });
                    slideTo++;
//                    alert($("#firsttop .plus").prev().find(".carousel.slide").attr('id'));
                    $("#firsttop").find("ol li").each(function () {
                        $(this).removeClass("active");
                        $("#firsttop").find("ol li:not(.clone):last-child").addClass("active");
                    });
                    $("#firsttop").find(".item").each(function () {
                        $(this).removeClass("active");
                        $("#firsttop").find(".item:not(.clone):last").addClass("active");
                    });
                }
                else{
                    // return false;
                }

            }

            if (mainPhoto != undefined) {
                $("#firsttop").find(".item.clone").clone(true)
                    .appendTo($("#firsttop .carousel-inner")).removeClass("clone")
                    .children(".image").css({
                    background: 'url(' + mainPhoto + ')',
                    backgroundSize: 'cover',
                    backgroundPosition: 'center 25%'
                });
                $("#firsttop").find(".item").each(function () {
                    $(this).removeClass("active");
                    $("#firsttop").find(".item:not(.clone):last").addClass("active");
                });
                $("#firsttop").find("ol li").each(function () {
                    $(this).removeClass("active");
                    $("#firsttop").find("ol li:not(.clone):last-child").addClass("active");
                });
                var eqPhoto = [];
                $("#firsttop").find(".item:not(.clone)").each(function (index) {
                    var backImg = $(this).children().css('background-image');
                    if (eqPhoto.indexOf(backImg) + 1) {
                        $("#firsttop").find(".item:not(.clone)").each(function () {
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
            return false;

        }
    });

}

/**
 * Created by Alexander on 24.09.2017.
 */
function left_top() {
    $.ajax({
        url: "./actions/left_top.php",
        type: "POST",
        dataType: "json",
        success: function (data){
            for(var i=0;i<data.length;i++){
                $(".top-grid .clone").clone(true).insertBefore($(".top-grid .clone"))
                    .removeClass("clone").show().children().css({
                    background: 'url('+ data[i].main_photo +')',
                    backgroundSize: 'cover',
                    backgroundPosition: 'center 25%'
                });
            }
            return false;
        }
    });
}

