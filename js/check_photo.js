/**
 * Created by Alexander on 27.07.2017.
 */
function check_photo() {
    $.ajax({
        url: "./actions/check_photo.php",
        type: "POST",
        dataType: "json",
        success: function (data){
            var slideTo = 1;
            var kolPhoto = 0;
            $(".validate#check .col-lg-3.clone").clone(true).show().insertBefore("#check .plus")
                .removeClass("clone").children(".carousel.slide").attr('id', 'carousel_check_01')
                .find("ol li").attr('data-target', '#carousel_check_01');
            for(var i=0;i<data.length;i++){
//                    if (kolPhoto==2) return false;
                var prevId = $("#check .plus").prev().find(".item:last input[type=hidden]").val();
                if (prevId == data[i].id_user){
                    $("#check .plus").prev().find(".item.clone").clone(true)
                        .insertAfter($("#check .plus").prev().find(".item:first")).removeClass("clone")
                        .children(".photo").css({
                        background: 'url('+ data[i].photo +')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    }).parent().children(".id_photo").val(data[i].id_photo);

//                    alert(data[i].photo);

                }
                else{

                    $(".validate#check .col-lg-3.clone").clone(true).show().insertBefore("#check .plus")
                        .removeClass("clone").children(".carousel.slide").attr('id', 'carousel_check_0' + data[i].id_user)
                        .find("ol li").attr('data-target', '#carousel_check_0' + data[i].id_user);
                    $("#check .plus").prev().find(".item.clone").clone(true)
                        .insertAfter($("#check .plus").prev().find(".item:first")).removeClass("clone")
                        .children(".photo").css({
                        background: 'url('+ data[i].photo +')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center 25%'
                    }).parent().children(".id_photo").val(data[i].id_photo);
                    slideTo =1;
//                        kolPhoto++;
                }
                $("#check .plus").prev().find(".about-name").text(data[i].name);
                $("#check .plus").prev().find(".about-uni").text(data[i].univer);
                $("#check .plus").prev().find(".about-fac").text(data[i].fac);
                $("#check .plus").prev().find(".about-ins").attr('href',(data[i].instagram));
                $("#check .plus").prev().find(".about-vk").attr('href',(data[i].vk));
                $("#check .plus").prev().find("input.user_id").val(data[i].id_user);
                $("#check .plus").prev().find("ol").children(".clone").clone(true)
                    .insertAfter($("#check .plus").prev().find("ol li:last-child")).removeClass("clone")
                    .attr('data-slide-to', slideTo).show(function () {
                });
                slideTo++;
//                    alert($("#check .plus").prev().find(".carousel.slide").attr('id'));
                $("#check .plus").prev().find("ol li").each(function () {
                    $(this).removeClass("active");
                    $("#check .plus").prev().find("ol li:not(.clone):last-child").addClass("active");
                });
                $("#check .plus").prev().find(".item").each(function () {
                    $(this).removeClass("active");
                    $("#check .plus").prev().find(".item:not(.clone):last").addClass("active");
                });
            }

            return false;
        }
    });
}


$(".validate-panel .fa-check-circle-o").click(function () {
    var check_photo = $(this).parents('.item').find('.id_photo').val();
    // check_photo = check_photo.replace(/.*\/ProjectX\/|"\)/g, "");
    $.cookie('check_photo', check_photo);
    $.ajax({
        url: './actions/accept_photo.php',
        type: 'POST',
        dataType: 'json',
        cache: false,
        success: function (data) {
        }
    });
});

$(".validate-panel .fa-times-circle-o").click(function () {
    var check_photo = $(this).parents('.item').find('.id_photo').val();
    $.cookie('check_photo', check_photo);
    $.ajax({
        url: './actions/not_accepted_photo.php',
        type: 'POST',
        dataType: 'json',
        cache: false,
        success: function (data) {
        }
    });
});
