;(function ($) {
    'use strict';

    $(document).ready(function () {
        // OffCanvas Handler
        $('.tcg-offcanvas').each(function () {
            var selector = $(this),
                toggle = selector.find('.offcanvas-toggle'),
                overly = selector.find('.offcanvas-overly'),
                close = selector.find('.offcanvas-close'),
                wrapper = selector.find('.tcg-offcanvas-wrapper');
            
            // Toggle offcanvas on button click
            toggle.on('click', toggleWrapper);
            
            // Close offcanvas on overlay click
            overly.on('click', removeWrapperClass);
            
            // Close offcanvas on close button click
            close.on('click', removeWrapperClass);
        });
        
        // Toggle the offcanvas wrapper
        function toggleWrapper(e) {
            e.preventDefault();
            var offcanvasWrapper = $(this).closest('.tcg-offcanvas').find('.tcg-offcanvas-wrapper');
            
            if (!offcanvasWrapper.hasClass('show-offcanvas')) {
                $('body').css('overflow', 'hidden');
            } else {
                $('body').css('overflow', 'auto');
            }
            
            offcanvasWrapper.toggleClass('show-offcanvas');
        }

        // Remove the 'show-offcanvas' class from the wrapper
        function removeWrapperClass(e) {
            e.preventDefault();
            var offcanvasWrapper = $(this).closest('.tcg-offcanvas-wrapper');
            
            offcanvasWrapper.removeClass('show-offcanvas');
            $('body').css('overflow', 'auto');
        }
    });

})(jQuery);
