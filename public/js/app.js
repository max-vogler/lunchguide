$(function () {
    var throttle = window.requestAnimationFrame || function(f){ window.setTimeout(f, 1000/60) };
    var $header = $(".header .container");
    var headerHeight = $(".header").height();
    var calculateEffects = function () {
        $header.css('opacity', 1 - Math.min(1, Math.max(0, window.pageYOffset/headerHeight)));
    }

    $(window).scroll(function () {
        throttle(calculateEffects); 
    })

    calculateEffects();
});
