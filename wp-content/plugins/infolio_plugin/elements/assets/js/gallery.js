(function ($) {
    "use strict";
    $(document).ready(function () {
        $('.infolio-portfolio-gallery.style1 .items-gallery').isotope({
            itemSelector: '.items'
        });
        $('.infolio-portfolio-gallery.style2 .items-gallery').isotope({
            // options
            itemSelector: '.items',
            masonry: {
                // use element for option
                columnWidth: '.width2'
            }
        });
    });
})(jQuery);