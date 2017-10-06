/**
 * Created by Alexander on 14.09.2017.
 */



function sel_photos_lk() {
    $.ajax({
        url: "./actions/select_photos_lk.php",
        type: "POST",
        dataType: "json",
        success: function (data){
            // alert(1);

            for(var i=0;i<data.length;i++){

                var  status = data[i].status;

                if (data[i].photo == null){
                    return false;
                }

                $("#lk-photos .clone").clone(true).insertBefore(".plus.switch")
                    .removeClass("clone").addClass('fadeIn').show().find('.photo').css({
                    background: 'url('+ data[i].photo +')',
                    backgroundSize: 'cover',
                    backgroundPosition: 'center 25%'
                }).parents(".col-lg-3").find(".id").val(data[i].id_photo);

                if (status == 2){
                    $(".plus.switch").prev().find(".fa-clock-o").css('display', 'block').next().next(".delete-photo")
                        .css('display', 'block').parent().children(".events-c").remove();
                }
                if (status==3){
                    $(".plus.switch").prev().find(".fa-minus-circle").css('display', 'block').next(".delete-photo")
                        .css('display', 'block').parent().children(".events-c").remove();
                }


            }
            colPhotos();
            return false;

        }
    });

}



var photos = [];
function add_photos() {
    var img = $(".add-photo-form").find("input[type=file]").val();
    if ($(".plus-info.add-mobile-photo .photo-counter").text()=='3'){
        $(".add-photos .fa-plus-square-o").show();
        // alert(1);
    }
    if (img!='' && img!=undefined){
        var date = new Date();
        if ($(".plus-info.add-mobile-photo .photo-counter").text()=='3'){
            // alert(3);
            $(".add-photos .fa-plus-square-o").hide();
        }else{
            $(".add-photos .fa-plus-square-o").show();
        }
        $(".add-photos .clone").clone(true).insertBefore(".add-photos .plus").removeClass("clone").children().addClass('newPhoto');
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
                $(".add-photos").children().each(function (index) {
                    $(".photo-counter").parent().show().children(".photo-counter").text(index-2)
                });
                if(photos.indexOf(img) + 1) {
                    $(".newPhoto").parent().remove();
                } else{
                    $(".add-photos .newPhoto").css({
                        background :'url('+ img +')',
                        backgroundSize: 'cover',
                        backgroundPosition: 'center'
                    }).removeClass('newPhoto');
                    photos.push(img);
                    $(".add-photo-fio .clone-hid").attr('value',photos);
                }
                $('#add-photo-file').parent().html($('#add-photo-file').parent().html());
            }
        });
    }
}


function colPhotos() {

    $(".cabinet #lk-photos .col-lg-3").not(".clone, .plus").each(function (index) {
        $(".fa-camera + span").text(index + 1);
        $(".fa-camera + br + span").text(index + 1);
    });
}



$(".plus.switch, .add-mobile-photo").click(function () {
    if ($(".add-photos .photo-counter").text() >= 1){
        $(".add-photo-fio .clone-hid").attr('value',photos);
        var form = $(".add-photo-form").serialize();
        $.ajax({
            url: './actions/add-photo-lk.php',
            type: 'POST',
            data: form,
            success: function (data) {
                photos=[];
                $(".add-photos .col-lg-3:not(.plus, .clone)").clone(true).insertBefore(".plus.switch")
                    .find(".fa-clock-o").css('display', 'block').next(".delete-photo")
                    .css('display', 'block').parent().children(".events-c").remove();
                $(".add-photos .col-lg-3:not(.plus, .clone)").remove();
                if (screen.width<=768)
                    $(".add-photos").removeClass("slideInUp").addClass("slideOutDown");
                if (screen.width>768)
                    $(".photo-counter").text('0').parent().hide();
                $(".cabinet").removeClass("blur");
                colPhotos();
            }
        });
    }
});


$(".window-delete button.yes").click(function () {
    var id = $(".window-delete .id").val();
    $(".cabinet .col-lg-3").each(function () {
       if ($(this).find(".id").val()==id){
           $(this).remove();
       }
    });
    $.ajax({
        url: './actions/del_photo.php',
        type: "POST",
        data: {"id":id},
        success:function (data) {
        }
    });
});

$(".window-delete button").click(function () {
    $(".window-delete").removeClass("bounceIn").addClass("zoomOut", function () {
        $(".window-delete").hide(300);
    });
    $(".cabinet").removeClass("blur");
});

$(".cabinet .fa-user").click(function () {
    var photo = $(this).parents(".photo").css('background-image');
    if (photo.indexOf('localhost') + 1){
        photo = photo.replace('url("http://localhost/www/ProjectX/', '');
        photo ='./' +  photo.replace('")', '');
    }
    else{
        photo = photo.replace('url("', '');
        photo = photo.replace('")', '');
    }
    $(".cabinet .logo-lk img").attr('src', photo).parent().removeClass('pulse', function () {
        $(".cabinet .logo-lk img").parent().addClass('pulse');
    });
    $.ajax({
        url: './actions/update_main_photo.php',
        type: "POST",
        data: {"data":photo},
        success:function (data) {
        }
    });
});

$(".photo").hover(function () {
    $(this).find(".fa-clock-o").addClass("indicator-hover");
    $(this).find(".fa-minus-circle").addClass("indicator-hover");
}, function () {
    $(this).find(".fa-clock-o").removeClass("indicator-hover");
    $(this).find(".fa-minus-circle").removeClass("indicator-hover");
});

$(".add-photos .photo").hover(function () {
    $(this).find(".delete-photo").css('display', 'block');
}, function () {
    $(this).find(".delete-photo").css('display', 'none');

});

$(".cabinet .fa-trash, .cabinet #lk-photos .delete-photo").click(function () {
    var photo = $(this).parents(".photo").css("background-image");
    var id = $(this).parents(".col-lg-3").find(".id").val();
    $(".window-delete").show().removeClass("zoomOut").addClass("bounceIn").find("div:last").css("background-image", photo)
        .prev().val(id);
    $(".cabinet").addClass('blur');

});


$(".add-photos .delete-photo").click(function () {
    var delPhoto= 'т';
    delPhoto = String($(this).parents(".photo").css('background-image'));
    delPhoto = delPhoto.replace('url("http://localhost/www/ProjectX/', '');
    delPhoto ='./' +  delPhoto.replace('")', '');
    // delete photos[0];
    if (photos[0]===delPhoto){
    }
    for (var i=0; i<photos.length; i++){
        // alert(photos[i]);
        // alert(delPhoto);

        if (photos[i]==delPhoto){
            $(this).parents(".col-lg-3").remove();
            // alert("i=" + i + "; photos[" + i + "]=" + photos[i] + "; delPhoto=" + delPhoto);
            delete photos[i];
            $(".add-photo-fio .clone-hid").attr('value',photos);
            var counter = $(".add-photos").find(".photo-counter").text();
            $(".photo-counter").text(counter - 1);
            return;
        }
    }
    return false;
});

$(".mobile-panel .fa-plus-square-o").click(function () {
    $(".add-photos").removeClass("slideOutDown").addClass("slideInUp").show();
    $(".cabinet").addClass("blur");
    $(".mobile-panel .check-menu").removeClass("check-menu");
    $(".fa-user").addClass('check-menu');

    ckeck_menu_user();
});

$(".add-photos .col-md-12 .fa-times").click(function () {
    $(this).parents(".add-photos").addClass("slideOutDown");
    $(".cabinet").removeClass("blur");
});

$(".personal-info .fa-pencil").click(function () {
    $(".auth-window").addClass("edit-info-lk").show();
    $(".cabinet").addClass("blur");

});