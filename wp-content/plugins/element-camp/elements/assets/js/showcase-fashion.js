(function ($) {
    "use strict";
    function elementcamp_showcase_fashion($scope, $) {

        function createFashionSlider(el) {
            const swiperEl = el.querySelector('.swiper-container');
            let navigationLocked = false;
            let transitionDisabled = false;
            let frameId;

            // eslint-disable-next-line
            const disableTransitions = (el) => {
                el.classList.add('showcase-fashion-no-transition');
                transitionDisabled = true;
                cancelAnimationFrame(frameId);
                frameId = requestAnimationFrame(() => {
                    el.classList.remove('showcase-fashion-no-transition');
                    transitionDisabled = false;
                    navigationLocked = false;
                });
            };

            let fashionSlider;

            const onNextClick = () => {
                if (!navigationLocked) {
                    fashionSlider.slideNext();
                }
            };
            const onPrevClick = () => {
                if (!navigationLocked) {
                    fashionSlider.slidePrev();
                }
            };

            const initNavigation = (swiper) => {
                // Use lock to control the button locking time without using the button component that comes with it
                swiper.el
                    .querySelector('.showcase-fashion-button-next')
                    .addEventListener('click', onNextClick);
                swiper.el
                    .querySelector('.showcase-fashion-button-prev')
                    .addEventListener('click', onPrevClick);
            };

            const destroyNavigation = (swiper) => {
                swiper.el
                    .querySelector('.showcase-fashion-button-next')
                    .removeEventListener('click', onNextClick);
                swiper.el
                    .querySelector('.showcase-fashion-button-prev')
                    .removeEventListener('click', onPrevClick);
            };

            let loopFixed;

            fashionSlider = new Swiper(swiperEl, {

                speed: 1300,
                allowTouchMove: false, // no touch swiping
                parallax: true, // text parallax
                on: {
                    loopFix() {
                        loopFixed = false;
                    },
                    transitionStart(swiper) {
                        const isLoop = swiper.params.loop;
                        if (isLoop) {
                            if (loopFixed) {
                                return;
                            }
                            if (!loopFixed) {
                                loopFixed = true;
                            }
                        }

                        // eslint-disable-next-line
                        const { slides, previousIndex, activeIndex, el } = swiper;
                        if (!transitionDisabled) navigationLocked = true; // lock navigation buttons

                        const activeSlide = slides[activeIndex];
                        const previousSlide = slides[previousIndex];
                        const previousImageScale = previousSlide.querySelector(
                            '.showcase-fashion-scale',
                        ); // image wrapper
                        const previousImage = previousSlide.querySelector('img'); // current image
                        const activeImage = activeSlide.querySelector('img'); // next image
                        const direction = activeIndex - previousIndex;
                        const bgColor = activeSlide.getAttribute('data-slide-bg-color');
                        el.style['background-color'] = bgColor; // background color animation

                        previousImageScale.style.transform = 'scale(0.6)';
                        previousImage.style.transitionDuration = '1000ms';
                        previousImage.style.transform = 'scale(1.2)'; // image scaling parallax
                        const previousSlideTitle = previousSlide.querySelector(
                            '.showcase-fashion-title-text',
                        );
                        previousSlideTitle.style.transition = '1000ms';
                        previousSlideTitle.style.color = 'rgba(255,255,255,0)'; // text transparency animation

                        const onTransitionEnd = (e) => {
                            if (e.target !== previousImage) return;
                            previousImage.removeEventListener('transitionend', onTransitionEnd);
                            activeImage.style.transitionDuration = '1300ms';
                            activeImage.style.transform = 'translate3d(0, 0, 0) scale(1.2)'; // image shift parallax
                            previousImage.style.transitionDuration = '1300ms';
                            previousImage.style.transform = `translate3d(${
                                60 * direction
                            }%, 0, 0)  scale(1.2)`;
                        };
                        previousImage.addEventListener('transitionend', onTransitionEnd);
                    },
                    transitionEnd(swiper) {
                        // eslint-disable-next-line
                        const { slides, activeIndex, el } = swiper;
                        const activeSlide = slides[activeIndex];
                        const activeImage = activeSlide.querySelector('img');
                        const isLoop = swiper.params.loop;

                        activeSlide.querySelector('.showcase-fashion-scale').style.transform =
                            'scale(1)';
                        activeImage.style.transitionDuration = '1000ms';
                        activeImage.style.transform = 'scale(1)';

                        const activeSlideTitle = activeSlide.querySelector(
                            '.showcase-fashion-title-text',
                        );
                        activeSlideTitle.style.transition = '1000ms';
                        activeSlideTitle.style.color = 'rgba(255,255,255,1)'; // text transparency animation

                        const onTransitionEnd = (e) => {
                            if (e.target !== activeImage) return;
                            activeImage.removeEventListener('transitionend', onTransitionEnd);
                            navigationLocked = false;
                        };
                        activeImage.addEventListener('transitionend', onTransitionEnd);
                        if (!isLoop) {
                            // First and last, disable button
                            if (activeIndex === 0) {
                                el.querySelector('.showcase-fashion-button-prev').classList.add(
                                    'showcase-fashion-button-disabled',
                                );
                            } else {
                                el.querySelector('.showcase-fashion-button-prev').classList.remove(
                                    'showcase-fashion-button-disabled',
                                );
                            }

                            if (activeIndex === slides.length - 1) {
                                el.querySelector('.showcase-fashion-button-next').classList.add(
                                    'showcase-fashion-button-disabled',
                                );
                            } else {
                                el.querySelector('.showcase-fashion-button-next').classList.remove(
                                    'showcase-fashion-button-disabled',
                                );
                            }
                        }
                    },
                    beforeInit(swiper) {
                        // eslint-disable-next-line
                        const { el } = swiper;
                        // disable initial transition
                        disableTransitions(el);
                    },
                    init(swiper) {
                        // Set initial slide bg color
                        // eslint-disable-next-line
                        const { slides, activeIndex, el } = swiper;
                        // set current bg color
                        const bgColor = slides[activeIndex].getAttribute('data-slide-bg-color');
                        el.style['background-color'] = bgColor; // background color animation
                        // trigger the transitionEnd event once during initialization
                        swiper.emit('transitionEnd');
                        // init navigation
                        initNavigation(swiper);
                    },
                    resize(swiper) {
                        disableTransitions(swiper.el);
                    },
                    destroy(swiper) {
                        destroyNavigation(swiper);
                    },
                },
                mousewheel: {
                    enabled: true,
                },
            });

            return fashionSlider;
        }

        const sliderEl = document.querySelector('.tcgelements-showcase-fashion');

        createFashionSlider(sliderEl);

    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tcgelements-showcase-fashion.default', elementcamp_showcase_fashion);
    });

})(jQuery);