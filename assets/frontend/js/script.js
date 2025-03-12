
$(document).scroll(function() { 
    var obj_act_top = $(this).scrollTop();
});

// VOLVER ARRIBA

$(document).ready(function() {
    new WOW().init();
    var obj_act_top = $(this).scrollTop();

    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
            $("nav.navbar").removeClass('navbar-fondo');

        } else {
            $('#back-to-top').fadeOut();
            $("nav.navbar").addClass('navbar-fondo');

        }

    });

    $('a#back-to-top').click(function () {

        $('body,html').animate({
            scrollTop: 0
        }, 500);

        return false;

    });

    if ($(this).scrollTop() > 50) {
        $('#back-to-top').fadeIn();
        $("nav.navbar").removeClass('navbar-fondo');

    } else {
        $('#back-to-top').fadeOut();
        $("nav.navbar").addClass('navbar-fondo');

    }

});