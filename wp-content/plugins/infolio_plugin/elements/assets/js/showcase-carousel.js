(function ($) {
    //    full screen
    var galleryText = new Swiper('.infolio-showcase-carousel .gallery-text .swiper-container', {
        spaceBetween: 30,
        slidesPerView: 1,
        direction: 'vertical',
        loop: true,
        loopedSlides: 4,
        touchRatio: 0.2,
        slideToClickedSlide: true,
        mousewheel: true,
        speed: 1500,
    });

    var galleryImg = new Swiper('.infolio-showcase-carousel .gallery-img .swiper-container', {
        spaceBetween: 80,
        slidesPerView: 2,
        centeredSlides: true,
        loop: true,
        loopedSlides: 4,
        mousewheel: true,
        speed: 1500,
        navigation: {
            nextEl: '.infolio-showcase-carousel .swiper-controls .swiper-button-next',
            prevEl: '.infolio-showcase-carousel .swiper-controls .swiper-button-prev',
        },
        pagination: {
            el: '.infolio-showcase-carousel .swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
                return '<span class="' + className + '">' + '<svg class="fp-arc-loader" width="16" height="16" viewBox="0 0 16 16">' +
                    '<circle class="path" cx="8" cy="8" r="5.5" fill="none" transform="rotate(-90 8 8)" stroke="#FFF"' +
                    'stroke-opacity="1" stroke-width="1px"></circle>' +
                    '<circle cx="8" cy="8" r="3" fill="#FFF"></circle>' +
                    '</svg></span>';
            },

        },
        keyboard: {
            enabled: true,
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
                slidesPerView: 2,
            },
        }
    });

    galleryImg.on("slideChangeTransitionStart", function () {
        galleryText.slideTo(galleryImg.activeIndex);
    });
    galleryText.on("transitionStart", function () {
        galleryImg.slideTo(galleryText.activeIndex);
    });
    //     half slider
    var halfText = new Swiper('.infolio-showcase-half .gallery-text .swiper-container', {
        spaceBetween: 100,
        centeredSlides: true,
        slidesPerView: 1,
        touchRatio: 0.2,
        slideToClickedSlide: true,
        loopedSlides: 4,
        mousewheel: true,
        speed: 1500,
        breakpoints: {
            0: {
                spaceBetween: 10,
                slidesPerView: 1,
                centeredSlides: false,
            },
            640: {
                spaceBetween: 30,
                slidesPerView: 1,
                centeredSlides: false,
            },
            768: {
                spaceBetween: 50,
                slidesPerView: 1,
                centeredSlides: false,
            },
            1024: {
                spaceBetween: 100,
                slidesPerView: 2,
                centeredSlides: true,
            },
        }
    });

    var halfImg = new Swiper('.infolio-showcase-half .gallery-img .swiper-container', {
        spaceBetween: 0,
        centeredSlides: true,
        loopedSlides: 4,
        mousewheel: true,
        speed: 1500,
        navigation: {
            nextEl: '.infolio-showcase-half .swiper-controls .swiper-button-next',
            prevEl: '.infolio-showcase-half .swiper-controls .swiper-button-prev',
        },
        pagination: {
            el: '.infolio-showcase-half .swiper-pagination',
            clickable: true,
            renderBullet: function (index, className) {
                return '<span class="' + className + '">' + '<svg class="fp-arc-loader" width="16" height="16" viewBox="0 0 16 16">' +
                    '<circle class="path" cx="8" cy="8" r="5.5" fill="none" transform="rotate(-90 8 8)" stroke="#FFF"' +
                    'stroke-opacity="1" stroke-width="1px"></circle>' +
                    '<circle cx="8" cy="8" r="3" fill="#FFF"></circle>' +
                    '</svg></span>';
            },

        },
        keyboard: {
            enabled: true,
        },
        thumbs: {
            swiper: halfText
        },
    });

    halfImg.on("slideChangeTransitionStart", function () {
        halfText.slideTo(halfImg.activeIndex);
    });
    halfText.on("transitionStart", function () {
        halfImg.slideTo(halfText.activeIndex);
    });
})(jQuery);