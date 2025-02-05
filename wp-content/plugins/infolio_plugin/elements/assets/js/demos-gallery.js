(function ($) {
    "use strict";

    $(document).ready(function() {

        $('.infolio-demos .gallery').isotope();
        
        $('.infolio-demos .gallery').imagesLoaded(function() {$('.infolio-demos .gallery').isotope();});

        var $gallery = $('.infolio-demos .gallery').isotope();

        $('.infolio-demos .filtering').on('click', 'span', function () {
            var filterValue = $(this).attr('data-filter');
            $gallery.isotope({ filter: filterValue });
        });

        $('.infolio-demos .filtering').on('click', 'span', function () {
            $(this).addClass('active').siblings().removeClass('active');
        });

    });

})(jQuery);