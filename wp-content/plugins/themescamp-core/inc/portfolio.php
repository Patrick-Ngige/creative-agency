<?php
// Registers the new post type  -------------------------------------------------------------------------

function themescamp_portfolio_post_type() { 
    global $tcg_theme_settings;

    // Get dynamic slugs from theme settings or default to 'portfolio'
    $portfolio_slug = themescamp_settings( 'tcg_portfolio_slug', 'portfolio' );
    $portfolio_category_slug = themescamp_settings( 'tcg_portfolio_category_slug', 'portfolio_category' );
    $portfolio_tag_slug = themescamp_settings( 'tcg_portfolio_tag_slug', 'porto_tag' );

    // Register the Portfolio Custom Post Type
    register_post_type( 'portfolio',
        array(
            'labels' => array(
                'name' => __( 'Portfolios', 'themescamp-core' ),
                'singular_name' => __( 'Portfolio', 'themescamp-core' ),
                'add_new' => __( 'Add New Portfolio', 'themescamp-core' ),
                'add_new_item' => __( 'Add New Portfolio', 'themescamp-core' ),
                'edit_item' => __( 'Edit Portfolio', 'themescamp-core' ),
                'new_item' => __( 'Add New Portfolio', 'themescamp-core' ),
                'view_item' => __( 'View Portfolio', 'themescamp-core' ),
                'search_items' => __( 'Search Portfolio', 'themescamp-core' ),
                'not_found' => __( 'No Portfolio found', 'themescamp-core' ),
                'not_found_in_trash' => __( 'No Portfolio found in trash', 'themescamp-core' )
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' ),
            'capability_type' => 'post',
            'rewrite' => array( 
                'slug' => $portfolio_slug,  // Dynamic slug for portfolio post type
                'with_front' => false
            ),
            'menu_position' => 5,
            'menu_icon' => 'dashicons-align-center',
            'exclude_from_search' => true,
            'taxonomies' => array( 'portfolio_category', 'porto_tag' ),  // Register taxonomies
            'show_in_nav_menus' => true, 
        )
    );
}

add_action( 'init', 'themescamp_portfolio_post_type' );

// Register Portfolio Category Taxonomy -------------------------------------------------------------------------
function themescamp_taxonomies_portfolio() {
    // Get dynamic slug for portfolio category
    $portfolio_category_slug = themescamp_settings( 'tcg_portfolio_category_slug', 'portfolio-category' );

    $labels = array(
        'name'              => _x( 'Portfolio Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Portfolio Categories' ),
        'all_items'         => __( 'All Portfolio Categories' ),
        'parent_item'       => __( 'Parent Portfolio Category' ),
        'parent_item_colon' => __( 'Parent Portfolio Category:' ),
        'edit_item'         => __( 'Edit Portfolio Category' ), 
        'update_item'       => __( 'Update Portfolio Category' ),
        'add_new_item'      => __( 'Add New Portfolio Category' ),
        'new_item_name'     => __( 'New Portfolio Category' ),
        'menu_name'         => __( 'Portfolio Categories' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'rewrite' => array(
            'slug' => $portfolio_category_slug,  // Dynamic slug for portfolio category
            'with_front' => false
        ),
        'has_archive' => true, 
    );
    register_taxonomy( 'portfolio_category', 'portfolio', $args );
}

add_action( 'init', 'themescamp_taxonomies_portfolio', 0 );

// Register Portfolio Tag Taxonomy -------------------------------------------------------------------------
function themescamp_taxonomies_portfolio_tag() {
    // Get dynamic slug for portfolio tag
    $portfolio_tag_slug = themescamp_settings( 'tcg_portfolio_tag_slug', 'portfolio-tag' );

    $labels = array(
        'name'              => _x( 'Portfolio Tags', 'taxonomy general name' ),
        'singular_name'     => _x( 'Portfolio Tag', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Portfolio Tags' ),
        'all_items'         => __( 'All Portfolio Tags' ),
        'edit_item'         => __( 'Edit Portfolio Tag' ), 
        'update_item'       => __( 'Update Portfolio Tag' ),
        'add_new_item'      => __( 'Add New Portfolio Tag' ),
        'new_item_name'     => __( 'New Portfolio Tag' ),
        'menu_name'         => __( 'Portfolio Tags' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'separate_items_with_commas' => __( 'Separate tags with commas' ),
        'add_or_remove_items' => __( 'Add or remove tags' ),
        'choose_from_most_used' => __( 'Choose from the most used tags' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'rewrite' => array(
            'slug' => $portfolio_tag_slug,  // Dynamic slug for portfolio tag
            'with_front' => false
        ),
        'query_var' => true,
        'has_archive' => true,
    );
    register_taxonomy( 'porto_tag', 'portfolio', $args );
}

add_action( 'init', 'themescamp_taxonomies_portfolio_tag', 0 );



//add secondry img to portfolio -------------------------------------------------------------------------
function themescamp_secondary_portfolio_image() {
    add_meta_box(
        'secondary_featured_image', // ID of the meta box
        'Secondary Featured Image', // Title
        'themescamp_sec_img_callback', // Callback function
        'portfolio', // Your custom post type slug
        'side', // Context: 'normal', 'side', or 'advanced'
        'low' // Priority
    );
}
add_action( 'add_meta_boxes', 'themescamp_secondary_portfolio_image' );

function themescamp_sec_img_callback( $post ) {
    // Get the current value of the secondary featured image (if exists)
    $secondary_image_id = get_post_meta( $post->ID, '_secondary_featured_image', true );
    $secondary_image_url = $secondary_image_id ? wp_get_attachment_url( $secondary_image_id ) : '';

    // Display the secondary featured image upload button
    echo '<div class="secondary-featured-image-wrapper">';
    echo '<img id="secondary-featured-image-preview" src="' . esc_url( $secondary_image_url ) . '" style="max-width:100%; display:' . ( $secondary_image_url ? 'block' : 'none' ) . ';" />';
    echo '<input type="hidden" id="secondary-featured-image-id" name="secondary_featured_image" value="' . esc_attr( $secondary_image_id ) . '" />';
    echo '<button type="button" class="button-secondary" id="secondary-featured-image-upload" style="vertical-align: initial;">Upload Image</button>';
    echo '<button type="button" class="button-link-delete" id="secondary-featured-image-remove" style="color: #a00; display:' . ( $secondary_image_url ? 'inline-block' : 'none' ) . ';">Remove</button>';
    echo '</div>';
}

//add custom link to portfolio -------------------------------------------------------------------------
function themescamp_custom_portfolio_link() {
    add_meta_box(
        'custom_link', // ID of the meta box
        'Custom Link', // Title
        'themescamp_portfolio_custom_link_callback', // Callback function
        'portfolio', // Your custom post type slug
        'side', // Context: 'normal', 'side', or 'advanced'
        'low' // Priority
    );
}
add_action( 'add_meta_boxes', 'themescamp_custom_portfolio_link' );

function themescamp_portfolio_custom_link_callback( $post ) {
    // Get the current value of the secondary featured image (if exists)
    $custom_link = get_post_meta( $post->ID, '_custom_link', true );

    // Display the secondary featured image upload button
    echo '<div class="custom-link-wrapper">';
    echo '<input type="text" id="custom-link-id" name="custom_link" value="' . esc_attr( $custom_link ) . '" />';
    echo '</div>';
}

function themescamp_save_sec_img( $post_id ) {
    // Verify if this is an auto-save routine. 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // Check permissions
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

    if ( isset( $_POST['secondary_featured_image'] ) ) {
        update_post_meta( $post_id, '_secondary_featured_image', sanitize_text_field( $_POST['secondary_featured_image'] ) );
    }
}
add_action( 'save_post', 'themescamp_save_sec_img' );

function themescamp_save_custom_link( $post_id ) {
    // Verify if this is an auto-save routine. 
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // Check permissions
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

    if ( isset( $_POST['custom_link'] ) ) {
        update_post_meta( $post_id, '_custom_link', sanitize_text_field( $_POST['custom_link'] ) );
    }
}
add_action( 'save_post', 'themescamp_save_custom_link' );

function themescamp_custom_portfolio_permalink( $permalink, $post ) {
    // Check if the post type is 'portfolio'
    if ( $post->post_type == 'portfolio' ) {
        // Get the custom link from post meta
        $custom_link = get_post_meta( $post->ID, '_custom_link', true );

        // If a custom link exists and is not empty, use it as the permalink
        if ( !empty( $custom_link ) ) {
            return esc_url( $custom_link );
        }
    }

    // Return the default permalink if no custom link is set
    return $permalink;
}
add_filter( 'post_type_link', 'themescamp_custom_portfolio_permalink', 99, 2 );