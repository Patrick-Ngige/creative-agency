(function ($) {
    $(document).ready(function () {
        $(".infolio-search-form").on("click", ".infolio-search-icon", function () {
            $(".infolio-search-form").toggleClass("open");

            if ($(".infolio-search-form").hasClass('open')) {
                $(".infolio-search-form .close-search").slideDown();
            } else {
                $(".infolio-search-form .close-search").slideUp();
            }
        });

        // Prevent the click event propagation for the input element
        $(".infolio-search-form").on("click", "input", function (event) {
            event.stopPropagation();
        });
    });
})(jQuery);
