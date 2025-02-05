(function ($) {
    $(window).load(function(){
        var $gallery = $('.infolio-portfolio-gallery:not(.style3) .items-gallery').isotope();
        $('.infolio-filtering').on('click', 'span', function () {
            var filterValue = $(this).attr('data-filter');
            $gallery.isotope({ filter: filterValue });
        });


        $('.infolio-filtering').on('click', 'span', function () {
            $(this).addClass('active').siblings().removeClass('active');
        });
    });
    $('.infolio-portfolio-gallery:not(.style3) .items-gallery').isotope();
})(jQuery);