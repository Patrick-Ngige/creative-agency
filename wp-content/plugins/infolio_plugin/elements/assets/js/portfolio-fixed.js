(function ($) {
    $('.infolio-portfolio .links-img .img').on('mouseenter', function () {
        var tab_id = $(this).attr('data-tab');
        $('.links-img .img').removeClass('current');
        $(this).addClass('current');

        $('.links-text li').removeClass('current');
        $("#" + tab_id).addClass('current');

        if ($(this).hasClass('current')) {
            return false;
        }
    });

    $('.infolio-portfolio .links-img .img').on('mouseleave', function () {
        $('.links-text li').removeClass('current');
        $('.links-img .img').removeClass('current');
    });
})(jQuery);