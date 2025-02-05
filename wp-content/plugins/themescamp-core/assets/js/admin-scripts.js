/* Disable option panel empty sections*/
jQuery(document).ready(function($) {
    // Find all <a> elements within elements with the specified classes
    $('.redux-group-menu .empty_section a').each(function() {
        // Create a new <span> element with the same content as the <a>
        var span = $('<span>').text($(this).text());
        
        // Copy the classes from the original <a> element to the new <span>
        span.attr('class', $(this).attr('class'));

        // Replace the <a> with the <span>
        $(this).replaceWith(span);
    });


    $('.redux-action_bar .spinner').after('<span class="op-mode"><i class="fa-regular fa-moon"></i></span');
    $('.redux-wrap-div').addClass('op-dark');


    $('.op-mode').on('click', function() {
        $('.redux-wrap-div').toggleClass('op-dark');
    });


    // Switch license for market and token for Elements of Envato
    $( 'input#tcg-envato-elements-cb' ).on( 'change', function () {

        if ( $(this).is( ':checked' ) ) {
            $('.tcg-registration-wrap').addClass( 'hidden' );
            $('.tcg-license-support').addClass( 'hidden' );
            $( '#tcg-elements-token' ).removeClass( 'hidden' );
            $th.text( window.VAMTAM_ADMIN.elementsTxt );
        } else {
            $('.tcg-registration-wrap').removeClass( 'hidden' );
            $('.tcg-license-support').removeClass( 'hidden' );
            $( '#tcg-elements-token' ).addClass( 'hidden' );
            $th.text( window.VAMTAM_ADMIN.tfPcTxt );
        }
    } );

    // Switch license for market to be via purchase code
    $( 'input#tcg-envato-market-key-cb' ).on( 'change', function () {

        if ( $(this).is( ':checked' ) ) {
            $('.tcg-register').addClass( 'hidden' );
            $( '#tcg-market-key' ).removeClass( 'hidden' );
            $th.text( window.VAMTAM_ADMIN.elementsTxt );
        } else {
            $('.tcg-register').removeClass( 'hidden' );
            $( '#tcg-market-key' ).addClass( 'hidden' );
            $th.text( window.VAMTAM_ADMIN.tfPcTxt );
        }
    } );

    // import demos ocdi
    function checkUrlParameter() {
        var pageParam = new URLSearchParams(location.search).get('page');
        var hash = location.hash;

        if (pageParam === 'one-click-demo-import') {
            // Manage button visibility
            var importParam = new URLSearchParams(location.search).get('import');
            if (importParam === '2') {
                $('.import-homes').show();
                $('.import-inners').hide(); // Ensure inner pages button is hidden
            } else {
                $('.import-inners').show();
                $('.import-homes').hide(); // Ensure home pages button is hidden
            }

            // Add active class based on hash
            $('.ocdi__gl-navigation ul li:nth-of-type(1)').hide();
            if (hash === '#hometemplates') {
                $('.ocdi__gl-navigation ul li:nth-of-type(2)').addClass('active');
                $('.ocdi__gl-navigation ul li:nth-of-type(3)').removeClass('active');
                $('[data-categories="innerpages"]').hide();
                $('[data-categories="hometemplates"]').show(); // Ensure home templates are visible
            } else if (hash === '#innerpages') {
                $('.ocdi__gl-navigation ul li:nth-of-type(3)').addClass('active');
                $('.ocdi__gl-navigation ul li:nth-of-type(2)').removeClass('active');
                $('[data-categories="hometemplates"]').hide();
                $('[data-categories="innerpages"]').show(); // Ensure inner pages are visible
            } else {
                // If neither hash matches, remove active class and show all relevant elements
                $('.ocdi__gl-navigation ul li').removeClass('active');
                $('[data-categories]').show(); // Ensure all elements are visible if no specific hash
            }

            // // Scroll to 100 pixels before the element with the class "ocdi__gl-header"
            //  $('html, body').animate({
            //      scrollTop: $(".ocdi__gl-header").offset().top - 120 // Subtract 100 pixels from the scroll position
            //  }, 1000); // Adjust the duration (1000ms = 1 second) as needed
        }
    }

    // Media Uploader for Secondary Featured Image of portfolio
    var file_frame;
    $('#secondary-featured-image-upload').on('click', function (event) {
        event.preventDefault();
        if (file_frame) {
            file_frame.open();
            return;
        }
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select Secondary Featured Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });
        file_frame.on('select', function () {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $('#secondary-featured-image-id').val(attachment.id);
            $('#secondary-featured-image-preview').attr('src', attachment.url).show();
            $('#secondary-featured-image-remove').show();
        });
        file_frame.open();
    });

    $('#secondary-featured-image-remove').on('click', function () {
        $('#secondary-featured-image-id').val('');
        $('#secondary-featured-image-preview').hide();
        $(this).hide();
    });



    // Call the function after DOM is ready
    checkUrlParameter();

});
