(function ($) {
    var parallaxSlider;
    var parallaxSliderOptions = {
        speed: 1500,
        autoplay: {
            delay: 5000,
        },
        parallax: true,
        loop: true,

        on: {
            init: function () {
                var swiper = this;
                for (var i = 0; i < swiper.slides.length; i++) {
                    $(swiper.slides[i])
                        .find('.bg-img')
                        .attr({
                            'data-swiper-parallax': 0.75 * swiper.width
                        });
                }
            },
            resize: function () {
                this.update();
            }
        },

        pagination: {
            el: '.infolio-slides .swiper-pagination',
            type: 'fraction',
            clickable: true
        },

        navigation: {
            nextEl: '.infolio-slides .swiper-button-next',
            prevEl: '.infolio-slides .swiper-button-prev'
        }
    };
    parallaxSlider = new Swiper('.infolio-slides .parallax-slider', parallaxSliderOptions);
})(jQuery);