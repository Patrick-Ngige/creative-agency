<?php

// Itack single product page body class
function themescamp_single_product_woocommerce_body_class( $classes ) {

    if(in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) )  ) && class_exists( 'WooCommerce' )):
        // NOT single product page, so return
        if ( ! is_product() ) return $classes;
        
        // Add new class
        $classes[] = 'tcg-single-product';

    endif;

    return $classes;
}
add_filter( 'body_class', 'themescamp_single_product_woocommerce_body_class', 10, 2 );

function themescamp_add_woocommerce_support() {
    // WooCommerce basic support
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 300,
        'gallery_thumbnail_image_width' => 250,
        'single_image_width'    => 800,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ) );

    // Additional WooCommerce features
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'themescamp_add_woocommerce_support' );


/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function themescamp_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents 3" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php esc_attr__( 'View your shopping cart','themescamp-core' ); ?>"><?php

        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            

        ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'themescamp_add_to_cart_fragment' );