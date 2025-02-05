(function ($) {
    $('.infolio-inter-links-center .links-text li').on('mouseenter', function () {
        var tab_id = $(this).attr('data-tab');
        $('.links-text li').removeClass('current');
        $(this).addClass('current');

        $('.links-img .img').removeClass('current');
        $("#" + tab_id).addClass('current');

        if ($(this).hasClass('current')) {
            return false;
        }
    });

    $('.infolio-inter-links-center .links-text li').on('mouseleave', function () {
        $('.links-text li').removeClass('current');
        $('.links-img .img').removeClass('current');
    });


    $('.infolio-inter-links-center .links-text li').on('mouseenter', function () {
        $(this).removeClass('no-active').siblings().addClass('no-active');
    });

    $('.infolio-inter-links-center .links-text li').on('mouseleave', function () {
        $('.infolio-inter-links-center .links-text li').removeClass('no-active');
    });
})(jQuery);
