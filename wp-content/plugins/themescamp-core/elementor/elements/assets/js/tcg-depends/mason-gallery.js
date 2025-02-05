(function($) {
    "use strict";

    $(window).on("load", function () {
        $('.tcg-portfolio-adv .gallery').isotope({
            itemSelector: '.items'
        });

        var $gallery = $('.tcg-portfolio-adv .gallery').isotope();

        $('.tcg-portfolio-adv .filtering').on('click', 'span', function () {
            var filterValue = $(this).attr('data-filter');
            $gallery.isotope({ filter: filterValue });
        });

        $('.tcg-portfolio-adv .filtering').on('click', 'span', function () {
            $(this).addClass('active').siblings().removeClass('active');
        });
    });


})(jQuery);

