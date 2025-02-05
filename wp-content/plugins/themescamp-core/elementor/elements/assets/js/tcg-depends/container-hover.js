(function ($) {
    "use strict";

    function waitForElementToExist(selector) {
        return new Promise(resolve => {
            if (document.querySelector(selector)) {
                return resolve(document.querySelector(selector));
            }

            const observer = new MutationObserver(() => {
                if (document.querySelector(selector)) {
                    resolve(document.querySelector(selector));
                    observer.disconnect();
                }
            });

            observer.observe(document.body, {
                subtree: true,
                childList: true,
            });
        });
    }

    function tcgElementsImage($scope, $) {
        $(document).ready(function () {
            $('.e-parent .elementor-widget-tcg-post-featured-image').parent().on('mouseenter', function () {
                // When the mouse enters an element with class 'e-parent' and has a direct child with class 'elementor-widget-tcg-post-featured-image'
                $(this).find('.selector-type-container').addClass('tcg-post-image-container-active'); // Add the active class to '.selector-type-container' inside 'e-parent'
            }).on('mouseleave', function () {
                // When the mouse leaves an element with class 'e-parent' and has a direct child with class 'elementor-widget-tcg-post-featured-image'
                $(this).find('.selector-type-container').removeClass('tcg-post-image-container-active'); // Remove the active class from '.selector-type-container' inside 'e-parent'
            });
        });
    };

    function tcgPostDynamicMeta($scope, $) {
        $(document).ready(function () {
            $('.e-parent .elementor-widget-tcg-dynamic-post-meta').parent().on('mouseenter', function () {
                // When the mouse enters an element with class 'e-parent' and has a direct child with class 'elementor-widget-tcg-post-featured-image'
                $(this).find('.selector-type-container').addClass('tcg-dynamic-post-meta-container-active'); // Add the active class to '.selector-type-container' inside 'e-parent'
            }).on('mouseleave', function () {
                // When the mouse leaves an element with class 'e-parent' and has a direct child with class 'elementor-widget-tcg-post-featured-image'
                $(this).find('.selector-type-container').removeClass('tcg-dynamic-post-meta-container-active'); // Remove the active class from '.selector-type-container' inside 'e-parent'
            });
            $('.e-parent .elementor-widget-tcg-dynamic-post-meta').parent().parent().on('mouseenter', function () {
                // When the mouse enters an element with class 'e-parent' and has a direct child with class 'elementor-widget-tcg-post-featured-image'
                $(this).find('.selector-type-parent-container').addClass('tcg-dynamic-post-meta-container-active'); // Add the active class to '.selector-type-container' inside 'e-parent'
            }).on('mouseleave', function () {
                // When the mouse leaves an element with class 'e-parent' and has a direct child with class 'elementor-widget-tcg-post-featured-image'
                $(this).find('.selector-type-parent-container').removeClass('tcg-dynamic-post-meta-container-active'); // Remove the active class from '.selector-type-container' inside 'e-parent'
            });
        });
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tcg-post-featured-image.default', tcgElementsImage);
        elementorFrontend.hooks.addAction('frontend/element_ready/tcg-dynamic-post-meta.default', tcgPostDynamicMeta);
    });

})(jQuery);