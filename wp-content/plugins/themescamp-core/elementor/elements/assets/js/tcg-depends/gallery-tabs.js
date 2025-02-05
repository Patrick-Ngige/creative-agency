(function ($) {
    "use strict";

    $(document).ready(function() {

        $('.tcg-gallery-tabs .gallery').isotope();
        
        $('.tcg-gallery-tabs .gallery').imagesLoaded(function() {$('.tcg-gallery-tabs .gallery').isotope();});

        var $gallery = $('.tcg-gallery-tabs .gallery').isotope();

        $('.tcg-gallery-tabs .filtering').on('click', 'span', function () {
            var filterValue = $(this).attr('data-filter');
            $gallery.isotope({ filter: filterValue });
        });

        $('.tcg-gallery-tabs .filtering').on('click', 'span', function () {
            $(this).addClass('active').siblings().removeClass('active');
        });

    });

})(jQuery);