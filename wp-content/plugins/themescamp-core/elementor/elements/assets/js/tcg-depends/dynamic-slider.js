!(function ($) {
    // slider
    function tcgDynamicSlider($scope, $) {
        const $slider = $scope.find('.tcg-dynamic-slider');
        const sliderSettings = $slider.data('tcg-dynamic-slider');
        const $swiperContainer = $slider.find('.swiper-container');
        const $nextArrow = $slider.find('.swiper-button-next');
        const $prevArrow = $slider.find('.swiper-button-prev');
        const $pagination = $slider.find('.swiper-pagination');
        const $scrollbar = $slider.find('.swiper-scrollbar');

        // Slider Area Element Animation
        const $slideElements = $slider.find('.tcg-dynamic-slide .elementor-element[data-settings*="animation"], .tcg-dynamic-slide .elementor-element[data-settings*="_animation"]');

        function slideElemAnimation(swiper) {
            $slideElements.each(function () {
                const $this = $(this);
                const settings = $this.data('settings');
                const animationName = settings._animation || settings.animation;
                const animationDelay = settings._animation_delay || settings.animation_delay;

                if (swiper.activeIndex === $this.closest('.swiper-slide').index()) {
                    $this.removeClass('elementor-invisible').addClass('animated ' + animationName);
                } else {
                    $this.removeClass('animated ' + animationName).addClass('elementor-invisible');
                }
            });
        }

        // fix swiper vertical slider height bug
        function setSlideHeight(swiper) {
            if (sliderSettings.autoHeight === 'true' && sliderSettings.direction !== 'vertical') {
                return;
            }

            const currentSlide = swiper.slides[swiper.activeIndex];
            const newHeight = $(currentSlide).height();

            $swiperContainer.find('.swiper-wrapper, .swiper-slide').css({ height: newHeight });
            swiper.update();
        }

        // set slidesPerView to 1
        function oneSlideView(breakpoints) {
            Object.keys(breakpoints).forEach(key => {
                breakpoints[key].slidesPerView = 1;
            });
            return breakpoints;
        }

        const swiperOptions = {
            loop: sliderSettings.loop === 'true',
            effect: sliderSettings.effect,
            speed: sliderSettings.speed,
            direction: sliderSettings.direction,
            oneWayMovement: sliderSettings.oneWayMovement === 'true',
            centeredSlides: sliderSettings.centeredSlides === 'true',
            autoHeight: sliderSettings.autoHeight === 'true',
            mousewheel: {
                enabled: sliderSettings.mousewheel === 'true',
            },
            keyboard: {
                enabled: sliderSettings.keyboard === 'true',
            },
            navigation: {
                nextEl: $nextArrow.get(0),
                prevEl: $prevArrow.get(0),
            },
            pagination: {
                el: $pagination.get(0),
                type: sliderSettings.paginationType,
                clickable: true
            },
            scrollbar: {
                el: $scrollbar.get(0),
                draggable: true,
                snapOnRelease: true,
            },
            on: {
                init: function () {
                    setSlideHeight(this);
                    slideElemAnimation(this);
                },
                slideChangeTransitionStart: function () {
                    slideElemAnimation(this);
                },
                resize: function () {
                    setSlideHeight(this);
                    this.update();
                },
            },
            observer: true,
            observeParents: true,
        };

        if (sliderSettings.effect === 'parallax') {
            swiperOptions.parallax = true;
            swiperOptions.on.init = function () {
                setSlideHeight(this);
                slideElemAnimation(this);
                var swiper = this;
                for (var i = 0; i < swiper.slides.length; i++) {
                    $(swiper.slides[i])
                        .find(".tcg-dynamic-slide > .elementor > .e-con")
                        .attr({
                            "data-swiper-parallax": 0.75 * swiper.width,
                        });
                }
            };
            swiperOptions.breakpoints = oneSlideView(sliderSettings.breakpoints);
        } if (sliderSettings.effect === 'material') {
            swiperOptions.materialEffect = {
                slideSplitRatio: 0.65
            };
            swiperOptions.modules = [EffectMaterial];
            swiperOptions.breakpoints = sliderSettings.breakpoints;
        } else if (sliderSettings.effect !== 'slide' && sliderSettings.effect !== 'coverflow' && sliderSettings.effect !== 'cards' && sliderSettings.effect !== 'material') {
            swiperOptions.breakpoints = oneSlideView(sliderSettings.breakpoints);
        } else {
            swiperOptions.breakpoints = sliderSettings.breakpoints;
        }

        if (sliderSettings.autoplay) {
            swiperOptions.autoplay = {
                delay: sliderSettings.autoplay.delay,
                reverseDirection: sliderSettings.autoplay.reverseDirection === 'true',
                disableOnInteraction: sliderSettings.autoplay.disableOnInteraction === 'true',
            };
        }

        if (sliderSettings.effect === 'cards') {
            swiperOptions.cardsEffect = {
                rotate: true,
                slideShadows: false,
                perSlideOffset: sliderSettings.cardsOffset,
                perSlideRotate: sliderSettings.cardsRotate,
            };
        }

        const swiper = new Swiper($swiperContainer.get(0), swiperOptions);
    }

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tcg-dynamic-slider.default', tcgDynamicSlider);
    });
})(jQuery);