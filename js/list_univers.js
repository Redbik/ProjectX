/**
 * Created by Alexander on 11.09.2017.
 */
function list_univers() {
   $.ajax({
       url: "./actions/list_univers.php",
       type: "POST",
       dataType: "json",
       success: function (data) {
           for (var i = 0; i < data.length; i++) {
                $(".univers-list ol li:first-child").clone(true).insertBefore($(".univers-list ol li:last-child")).text(data[i].name);
           }
       }

   });
}

$("#univers-mask").keyup(function(){
    $(".univers-list").show().animate({
        opacity: 1,
        height: 200
    }, 10);
    $(".univers-list ol li:first-child").text("");

    $(".univers-list ol li:not(ol li:first-child)").remove();
    var data = $("#univers-mask").val();
    $.ajax({
        url: "./actions/search_univers.php",
        type: "POST",
        dataType: "json",
        data:{data:data},
        success: function (data) {
            for (var i = 0; i < data.length; i++) {
                $(".univers-list ol li:first-child").clone(true).insertBefore($(".univers-list ol li:last-child")).text(data[i].name);
            }
        }

    });

});

$(".validate#add-univer .fa-check-circle-o").click(function () {

    var data = $(this).parents('.col').find('.add-univer-form').serialize();
    // check_photo = check_photo.replace(/.*\/ProjectX\/|"\)/g, "");
    $.ajax({
        url: './actions/accept_univer.php',
        type: 'POST',
        data: data,
        success: function (data) {
            $(this).parents(".col").remove();
        }
    });
});

$(".validate#add-univer .fa-times-circle-o").click(function () {
    var data = $(this).parents('.col').find('input').val();
    // check_photo = check_photo.replace(/.*\/ProjectX\/|"\)/g, "");
    $.ajax({
        url: './actions/accept_univer.php',
        type: 'POST',
        data:{data: data},
        success: function (data) {
        }
    });
});
