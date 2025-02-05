(function ($) {
    $(document).ready(function () {
        $('.infolio-work-carsouel .infolio-work-crus').each(function () {
            var speed = $(this).data('swiper-speed');
            var items = $(this).data('items');
            var space = $(this).data('space');
            var center = $(this).data('center');
            var loop = $(this).data('loop');

            var workCarousel;
            var workCarouselOptions = {
                speed: speed,
                slidesPerView: items,
                spaceBetween: space,

                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    640: {
                        slidesPerView: 2,
                    },
                    768: {
                        slidesPerView: 3,
                    },
                    1024: {
                        slidesPerView: items,
                    },
                },

                navigation: {
                    nextEl: '.infolio-work-carsouel .swiper-button-next',
                    prevEl: '.infolio-work-carsouel .swiper-button-prev'
                }
            };
            if (center) {
                workCarouselOptions.centeredSlides = center
            };
            if (loop) {
                workCarouselOptions.loop = loop
            };
            workCarousel = new Swiper('.infolio-work-carsouel .infolio-work-crus .swiper-container', workCarouselOptions);


        });
    });
})(jQuery);
