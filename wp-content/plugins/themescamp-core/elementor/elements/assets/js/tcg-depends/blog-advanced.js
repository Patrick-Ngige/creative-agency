jQuery(document).ready(function($) {
    $('.tcg-post-list.tcg-masonry').isotope({
        itemSelector: '.grid-item',
        layoutMode: 'masonry',
        masonry: {
            columnWidth: '.grid-item'
        }
    });
});
