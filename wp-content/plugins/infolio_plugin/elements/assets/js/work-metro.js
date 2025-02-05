(function ($) {
    $(document).ready(function() {
        $('[data-tooltip-tit]').hover(function () {
            $('<div class="infolio-div-tooltip-tit"></div>').text($(this).attr('data-tooltip-tit')).appendTo('.blank-builder').fadeIn();
        }, function () {
            $('.infolio-div-tooltip-tit').remove();
        }).mousemove(function (e) {
            $('.infolio-div-tooltip-tit').css({top: e.pageY + 10, left: e.pageX + 20})
        });

        $('[data-tooltip-sub]').hover(function () {
            $('<div class="infolio-div-tooltip-sub"></div>').text($(this).attr('data-tooltip-sub')).appendTo('.blank-builder').fadeIn();
        }, function () {
            $('.infolio-div-tooltip-sub').remove();
        }).mousemove(function (e) {
            $('.infolio-div-tooltip-sub').css({top: e.pageY + (-20), left: e.pageX + 30})
        });
    })
})(jQuery);