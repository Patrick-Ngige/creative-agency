(function ($) {
    $('.infolio-portfolio-tabs .cluom').on('mouseenter', function () {
        var tab_id = $(this).attr('data-tab');
        $('.infolio-portfolio-tabs .cluom').removeClass('current');
        $(this).addClass('current');
        $('.infolio-portfolio-tabs .glry-img .tab-img ').removeClass('current');
        $("#" + tab_id).addClass('current');
        if ($(this).hasClass('current')) {
            return false;
        }
    });
})(jQuery);