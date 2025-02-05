(function ($) {
    "use strict";
    $('.infolio-portfolio-carsouel .infolio-portfolio-carsouel-init').each(function () {

        var containe = $(this).find('[data-swiper="container"]').attr('id');
        var pagination = $(this).find('[data-swiper="pagination"]').attr('id');
        var prev = $(this).find('[data-swiper="prev"]').attr('id');
        var next = $(this).find('[data-swiper="next"]').attr('id');
        var items = $(this).data('items');
        var autoplay = $(this).data('autoplay');
        var iSlide = $(this).data('initial');
        var loop = $(this).data('loop');
        var parallax = $(this).data('parallax');
        var space = $(this).data('space');
        var speed = $(this).data('swiper-speed');
        var center = $(this).data('center');
        var effect = $(this).data('effect');
        var direction = $(this).data('direction');
        var mousewheel = $(this).data('mousewheel');

        // Configuration
        var conf = {

        };

        if ($(this).hasClass('infolio-work-swiper-auto')) {
            var conf = {

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
                        slidesPerView: "auto",
                    },
                },

                navigation: {
                    nextEl: '.infolio-portfolio-carsouel .swiper-button-next',
                    prevEl: '.infolio-portfolio-carsouel .swiper-button-prev'
                }
            };
        };

        if ($(this).hasClass('infolio-work-swiper-center')) {
            var conf = {

                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 30,
                    },
                    768: {
                        slidesPerView: 1,
                        spaceBetween: 50,
                    },
                    1024: {
                        slidesPerView: 2,
                    },
                },

                pagination: {
                    el: '.infolio-portfolio-carsouel .swiper-pagination',
                    clickable: true,
                },

                navigation: {
                    nextEl: '.infolio-portfolio-carsouel .swiper-button-next',
                    prevEl: '.infolio-portfolio-carsouel .swiper-button-prev'
                },
            };
        };

        if (items) {
            conf.slidesPerView = items
        };
        if (autoplay) {
            conf.autoplay = autoplay
        };
        if (iSlide) {
            conf.initialSlide = iSlide
        };
        if (center) {
            conf.centeredSlides = center
        };
        if (loop) {
            conf.loop = loop
        };
        if (parallax) {
            conf.parallax = parallax
        };
        if (space) {
            conf.spaceBetween = space
        };
        if (speed) {
            conf.speed = speed
        };
        if (mousewheel) {
            conf.mousewheel = mousewheel
        };
        if (effect) {
            conf.effect = effect
        };
        if (direction) {
            conf.direction = direction
        };
        if (prev) {
            conf.prevButton = '#' + prev
        };
        if (next) {
            conf.nextButton = '#' + next
        };
        if (pagination) {
            conf.pagination = '#' + pagination,
                conf.paginationClickable = true
        };

        // Initialization
        if (containe) {
            var initID = '#' + containe;
            var init = new Swiper(initID, conf);
        };
    });
})(jQuery);
