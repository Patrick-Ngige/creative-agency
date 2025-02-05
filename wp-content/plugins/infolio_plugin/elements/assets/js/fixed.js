(function ($) {
    "use strict";
    $(document).ready(function () {
        var wind = $(window);
        var width = $(window).width();
        if (width > 991) {
            wind.on('scroll', function () {
                $(".infolio-portfolio-fixed .cont").each(function () {
                    var bottom_of_object =
                        $(this).offset().top + $(this).outerHeight();
                    var bottom_of_window =
                        $(window).scrollTop() + $(window).height();
                    var tab_id = $(this).attr('data-tab');
                    if (bottom_of_window > bottom_of_object) {
                        $("#" + tab_id).addClass('current');
                        $(this).addClass('current');
                    } else {
                        $("#" + tab_id).removeClass('current');
                        $(this).removeClass('current');
                    }
                });
            });
        }
        $(".left.infolio-portfolio-sticky-item").stick_in_parent();
        if (window.gsap && window.ScrollTrigger) {
            ScrollTrigger.create({
                trigger: '.left.infolio-portfolio-sticky-item',
                start: 'top top',  // Start when the top of the sticky item is at the top of the viewport
                endTrigger: '.infolio-portfolio-fixed', // Use the outer container as the end trigger
                end: 'bottom bottom', // End when the bottom of the outer container is at the bottom of the viewport
                pin: true, // Pin the sticky item
                pinSpacing: false // Disable additional spacing by ScrollTrigger
            });
        }
    });
})(jQuery);