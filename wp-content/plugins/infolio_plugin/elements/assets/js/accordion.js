(function ($) {
    $(".infolio-accordion .accordion").on("click", ".title", function () {

        $(this).next().slideDown();

        $(".accordion-info").not($(this).next()).slideUp();

    });

    $(".infolio-accordion .accordion").on("click", ".item", function () {

        $(this).addClass("active").siblings().removeClass("active");

    });
})(jQuery);