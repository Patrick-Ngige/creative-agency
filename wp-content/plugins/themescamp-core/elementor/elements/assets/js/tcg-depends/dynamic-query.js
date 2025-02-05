!(function ($) {
    "use strict";
    function tcgDynamicQueryFilters($scope, $) {

        $(window).on('load', function () {
            var enable = document.querySelector(".tcg-dynamic-query .gallery");


            if (enable) {

                $('.tcg-dynamic-query .gallery').isotope({
                    itemSelector: '.tcg-dynamic-query-item'
                });
                var $gallery = $('.tcg-dynamic-query .gallery').isotope();
                $('.tcg-dynamic-query .tcg-dynamic-query-filters').on('click', 'span', function () {
                    var filterValue = $(this).attr('data-filter');
                    $gallery.isotope({ filter: filterValue });
                });
                $('.tcg-dynamic-query .tcg-dynamic-query-filters').on('click', 'span', function () {
                    $(this).addClass('active').siblings().removeClass('active');
                });
            }
        });
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tcg-dynamic-query.default', tcgDynamicQueryFilters);
    });
})(jQuery);
