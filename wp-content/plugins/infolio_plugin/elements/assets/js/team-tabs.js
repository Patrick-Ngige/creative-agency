(function ($) {
    var pageSection = $(".bg-img");
    pageSection.each(function (indx) {
        if ($(this).attr("data-background")) {
            $(this).css("background-image", "url(" + $(this).data("background") + ")");
        }
    });
    $('.infolio-team-tabs .cluom').on('mouseenter', function () {
        var tab_id = $(this).attr('data-tab');
        $('.infolio-team-tabs .cluom').removeClass('current');
        $(this).addClass('current');

        $('.infolio-team-tabs .glry-img .tab-img ').removeClass('current');
        $("#" + tab_id).addClass('current');

        if ($(this).hasClass('current')) {
            return false;
        }
    });
})(jQuery);