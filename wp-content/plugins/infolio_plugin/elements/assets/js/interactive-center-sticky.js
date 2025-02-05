(function ($) {
    "use strict";
    $(document).ready(function () {
        $(".infolio-interactive-center .item .hover-reveal").each(function () {
            ScrollTrigger.create({
                trigger: '.infolio-interactive-center',
                start: 'top center',  // Start when the top of the sticky item is at the top of the viewport
                endTrigger: '.infolio-interactive-center', // Use the outer container as the end trigger
                end: 'bottom center', // End when the bottom of the outer container is at the bottom of the viewport
                xPercent: -100,
                pin: $(this), // Pin the sticky item
                pinSpacing: false // Disable additional spacing by ScrollTrigger
            });
        });
    });
})(jQuery);