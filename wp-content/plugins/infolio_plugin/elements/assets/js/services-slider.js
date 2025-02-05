(function ($) {
    function infolioServicesSlider($scope, $) {
        $('.infolio-serv-swiper').each(function () {

            var servSlider;
            var servSliderOptions = {
                loop: true,
                spaceBetween: 30,
                navigation: {
                    nextEl: '.infolio-services .buttons .swiper-button-next',
                    prevEl: '.infolio-services .buttons .swiper-button-prev'
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                    },
                    640: {
                        slidesPerView: 1,
                    },
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            };
            servSlider = new Swiper('.infolio-serv-swiper .swiper-container', servSliderOptions);
            
        });
    };

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/Infolio-services-slider.default', infolioServicesSlider);
    });
})(jQuery);
