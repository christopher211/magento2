require([ "jquery" ], function($){

    $(window).scroll(function () {
        if( $(window).scrollTop() > $('.header').offset().top && !($('.header').hasClass('sticky'))){
            $('.header-2').addClass('sticky');
        } else if ($(window).scrollTop() === 0){
            $('.header').removeClass('sticky');
        }
    });
});

require([
    "jquery",
    "domReady!"
], function($) {
    $(window).scroll(function () {
        if( $(window).scrollTop() > $('#header').offset().top && !($('#header').hasClass('sticky_header'))){
            $('#header').addClass('sticky_header');
        } else if ($(window).scrollTop() == 0){
            $('#header').removeClass('sticky_header');
        }
    });
});