(function ($) {
    "use strict";
    $(window).on("load", function () { // makes sure the whole site is loaded
        //preloader
        $(".pre-loading").fadeOut(); // will first fade out the loading animation
        $(".pre-loading").delay(450).fadeOut("slow"); // will fade out the white DIV that covers the website. 
        $(".svg-pre-loading").fadeOut(); // will first fade out the loading animation
        $(".svg-pre-loading").delay(450).fadeOut("slow"); // will fade out the white DIV that covers the website. 
        $("#preloader").fadeOut(); // will first fade out the loading animation
        $("#preloader").delay(450).fadeOut("slow"); // will fade out the white DIV that covers the website. 
    });

    // ------------ Preloader -----------
    $(function () {
        const svg = document.getElementById("tcg-loader-svg");
        const tl = gsap.timeline();
        const curve = "M0 502S175 272 500 272s500 230 500 230V0H0Z";
        const flat = "M0 2S175 1 500 1s500 1 500 1V0H0Z";
      
        tl.to(".loader-wrap-heading .load-text , .loader-wrap-heading .cont", {
          delay: 1.5,
          y: -100,
          opacity: 0,
        });
        tl.to(svg, {
          duration: 0.5,
          attr: { d: curve },
          ease: "power2.easeIn",
        }).to(svg, {
          duration: 0.5,
          attr: { d: flat },
          ease: "power2.easeOut",
        });
        tl.to(".loader-wrap", {
          y: -1500,
        });
        tl.to(".loader-wrap", {
          zIndex: -1,
          display: "none",
        });
        tl.from(
          "header .container",
          {
            y: 40,
            opacity: 0,
            delay: 0.3,
          },
          "-=1.5"
        );
      
        // Set a timeout to ensure the animation finishes
        setTimeout(() => {
          tl.progress(1); // Force the animation to complete
        }, 4000); // Adjust the timeout value as needed
      });
})(jQuery);