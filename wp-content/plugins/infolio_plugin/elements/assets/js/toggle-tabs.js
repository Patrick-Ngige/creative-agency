(function ($) {
    $('.infolio-toggle-tabs .tab-links').on('click', '.item-link', function () {

        var tab_id = $(this).attr('data-tab');

        $('.infolio-toggle-tabs .tab-links .item-link').removeClass('current');
        $(this).addClass('current');

        $('.tab-content').hide();
        $("#" + tab_id).show();

    });

    $('#infolio-tabs-fade .tab-links').on('click', '.item-link', function () {

        var tab2_id = $(this).attr('data-tab');

        $('#infolio-tabs-fade .tab-links .item-link').removeClass('current');
        $(this).addClass('current');

        $('.tab-content').fadeOut();
        $("#" + tab2_id).fadeIn();

    });

})(jQuery);