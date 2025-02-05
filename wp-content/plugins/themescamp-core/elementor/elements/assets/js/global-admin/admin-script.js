//Masonry the kit templates
jQuery(document).ajaxComplete(function() {
    // Delay to ensure all DOM manipulations have completed
    setTimeout(function() {
        jQuery('#tc-elementkit-template-library-templates-container').isotope({
            itemSelector: '.elementor-template-library-template-remote',
            layoutMode: 'masonry',
            masonry: {
                columnWidth: '.elementor-template-library-template-remote'
            }
        });
    }, 500); // 0.5 second delay, adjust as needed
});
