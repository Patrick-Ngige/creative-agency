/**
 * Start mailchimp widget script
 */

(function ($, elementor) {

    'use strict';

    function mailchimpNotification(data) {
        $('.tcg-mailchimp').after(`<div class="tcg-mailchimp-notification ${data.type}">${data.message}</div>`);
    }

    function clearMailchimpNotification() {
        $('.tcg-mailchimp-notification').remove();
    }

    var widgetMailChimp = function ($scope, $) {

        var $mailChimp = $scope.find('.tcg-mailchimp');

        if (!$mailChimp.length) {
            return;
        }

        $mailChimp.submit(function () {

            var mailchimpform = $(this);
            mailchimpNotification({
                type: 'warning',
                message: 'Subscribing you please wait...'
            }); 
            $.ajax({
                url: mailchimpform.attr('action'),
                type: 'POST',
                data: mailchimpform.serialize(),
                success: function (data) {
                    clearMailchimpNotification();
                    mailchimpNotification({
                        type: 'success',
                        message: data
                    });

                    // set local storage for coupon reveal
                    // localStorage.setItem("epCouponReveal", 'submitted');
                }
            });
            return false;

        });

        return false;

    };


    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tcg-mailchimp.default', widgetMailChimp);
    });

}(jQuery, window.elementorFrontend));

/**
 * End mailchimp widget script
 */

