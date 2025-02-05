(function ($) {
    $('.infolio-menu .default .navbar-nav li.menu-item-has-children').addClass('nav-item dropdown');
    $('.infolio-menu .default .navbar-nav li.menu-item-has-children > a').addClass('nav-link dropdown-toggle').attr('role', 'button').attr('data-bs-toggle', 'dropdown').attr('aria-expanded', 'false');
    $('.infolio-menu .default .navbar-nav li.menu-item-has-children > ul').addClass('dropdown-menu');
    $('.infolio-menu .default .navbar-nav li.menu-item > a:first-of-type').addClass('nav-link')
    $('.infolio-menu .default .navbar-nav li.menu-item-has-children > ul > li.menu-item > a').removeClass('nav-link').addClass('dropdown-item');
    $('.infolio-menu .default .navbar-nav.animation li.menu-item > .nav-link').contents().wrap('<span class="rolling-text"></span>');
    
    if($(".infolio-menu .animation")){
        let elements = document.querySelectorAll(".infolio-menu .animation .nav-link");

        elements.forEach((element, index) => {
                let innerText = element.innerText;
                element.innerHTML = "";

                let textContainer = document.createElement("span");
                let animationContainer = document.createElement("span");
                animationContainer.classList.add("rolling-text")
                textContainer.classList.add("block");

                for (let letter of innerText) {
                    let span = document.createElement("span");
                    span.innerText = letter.trim() === "" ? "\xa0" : letter;
                    span.classList.add("letter");
                    textContainer.appendChild(span);
                }

                animationContainer.appendChild(textContainer);
                animationContainer.appendChild(textContainer.cloneNode(true));

                element.appendChild(animationContainer);

                element.addEventListener("mouseover", () => {
                    element.classList.remove("play");
                });
        });
    }

    $('.infolio-menu .default.navbar .dropdown').hover(function () {
        $(this).find('.dropdown-menu').addClass('show');
    }, function () {
        $(this).find('.dropdown-menu').removeClass('show')
    });

    $('.infolio-menu .default.navbar .dropdown-item').hover(function () {
        $(this).find('.dropdown-side').addClass('show');
    }, function () {
        $(this).find('.dropdown-side').removeClass('show')
    });

    $(".infolio-menu .default.navbar").on("click", ".navbar-toggler", function () {

        $(".navbar .navbar-collapse").toggleClass("show");
    });
    // drop-down-side
    $('.infolio-menu .default .navbar-nav .dropdown-menu li.menu-item-has-children').each(function () {
        let $menuItem = $(this);

        // Get submenu content
        let subMenuContent = $menuItem.find('> ul.sub-menu.dropdown-menu').html();

        // Wrap the submenu in the new structure
        $menuItem.find('> a').removeClass('dropdown-toggle dropdown-item')
            .wrap('<li class="dropdown-item"></li>')
            .parent()
            .append('<i class="fas fa-angle-right icon-arrow"></i>')
            .append('<ul class="dropdown-side"></ul>');

        // Append submenu content to the new structure
        $menuItem.find('.dropdown-item .dropdown-side').append(subMenuContent);

        // Remove the original submenu
        $menuItem.find('> ul.sub-menu.dropdown-menu').remove();
    });
    $('.infolio-menu .default .navbar-nav .dropdown-menu .dropdown-item').hover(function () {
        $(this).find('.dropdown-side').addClass('show');
    }, function () {
        $(this).find('.dropdown-side').removeClass('show')
    });
    // menu list
    $(window).on("load", function () {
        let elements = document.querySelectorAll(".infolio-menu .menu-list ul .menu-item > a");

        $('.infolio-menu .menu-list .menu-item-has-children').append('<i></i>')
        // + icon wrap it with overflowhidden
        $('.infolio-menu .menu-list ul .menu-item').each(function () {
            let content = $(this).html();
            $(this).children('a, i').wrapAll("<div class='o-hidden cursor-pointer'></div>");
        });
        // end of + icon
        $('.infolio-menu .menu-list .navigation > .menu-item-has-children .cursor-pointer').on('click', function () {
            $(this).parent().children('.sub-menu').toggleClass('sub-open');
            $(this).parent().toggleClass('sub-menu-open');
        });

        $('.infolio-menu .menu-list .navigation > .menu-item').on('mouseenter', function () {
            $(this).css("opacity", "1").siblings().css("opacity", ".5");
        });

        $('.infolio-menu .menu-list .navigation > .menu-item').on('mouseleave', function () {
            $(this).css("opacity", "1").siblings().css("opacity", "1");
        });
    });

})(jQuery);