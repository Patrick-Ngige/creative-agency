<?php
//Elementor Editor view
global $post;
//display menu list
function themescamp_navmenu_navbar_menu_choices() {
	$menus = wp_get_nav_menus();
	$items = array();
	$i     = 0;
	foreach ( $menus as $menu ) {
		if ( $i == 0 ) {
			$default = $menu->slug;
			$i ++;
		}
		$items[ $menu->slug ] = $menu->name;
	}

	return $items;
}

//display offcanvas list
function themescamp_offcanvas_choices() {
    // Query for all posts of type 'tcg_teb' regardless of status (optional)
    $offcanvas_query = new WP_Query( array( 
    	'post_type' => 'tcg_teb', 
    	'post_status' => 'any', 
    	'posts_per_page' => -1,
	    'meta_query' => array(
	        array(
	            'key' => 'template_type',
	            'value' => 'offcanvas',
	            'compare' => '='
	        )
	    )


	 ) );
    
    $posts = $offcanvas_query->posts; 
    $items = array();

    // Check if we have posts to loop through
    if( $posts ) {
        foreach ( $posts as $offcanvas ) {
            // Use the ID as the key and post_title as the value
            $items[ $offcanvas->ID ] = $offcanvas->post_title;
        }
    }
   
    return $items;
}


//display category blog list
function themescamp_category_choice() {
    $categories = get_categories( );
	$blogs = array();
	$i     = 0;
	foreach ( $categories as $category ) {
		if ( $i == 0 ) {
			$default = $category->name ;
			$i ++;
		}
		$blogs[ $category->term_id ] = $category->name;
	}
	return $blogs;
}

function themescamp_portfolio_tag_choice()
{
	$tags = get_terms('porto_tag', array(
		'hide_empty' => true,
	));
	$blogs = array();
	$i     = 0;
	foreach ($tags as $tag) {
		if ($i == 0) {
			$default = $tag->name;
			$i++;
		}
		$blogs[$tag->term_id] = $tag->name;
	}
	return $blogs;
}

function themescamp_post_tag_choice()
{
	$tags = get_terms('post_tag', array(
		'hide_empty' => false,
	));
	$blogs = array();
	$i     = 0;
	foreach ($tags as $tag) {
		if ($i == 0) {
			$default = $tag->name;
			$i++;
		}
		$blogs[$tag->slug] = $tag->name;
	}
	return $blogs;
}

//display portfolio categories
function themescamp_tax_choice() {
    $categories = get_terms('portfolio_category' );
	$blogs = array();
	$i     = 0;
	foreach ( $categories as $category ) {
		if ( $i == 0 ) {
			$default = $category->name ;
			$i ++;
		}
		$blogs[ $category->term_id ] = $category->name;
	}
	return $blogs;
}

//display products categories
function themescamp_products_choice() {
    $categories = get_terms('product_cat' );
	$blogs = array();
	$i     = 0;
	foreach ( $categories as $category ) {
		if ( $i == 0 ) {
			$default = $category->name ;
			$i ++;
		}
		$blogs[ $category->term_id ] = $category->name;
	}
	return $blogs;
}

//for imagesloaded 
add_action( 'elementor/editor/after_enqueue_scripts', function() {
   wp_enqueue_script( 'imagesloaded'); 
} );

//add new category elementor
add_action( 'elementor/init', function () {
	$elementsManager = Elementor\Plugin::instance()->elements_manager;
	$elementsManager->add_category(
		'themescamp-elements',
		array(
			'title' => 'ThemesCamp Builder',
			'icon'  => 'font',
		),
		1
	);
} );

//add new category elementor
add_action( 'elementor/init', function () {
	$elementsManager = Elementor\Plugin::instance()->elements_manager;
	$elementsManager->add_category(
		'themescamp-menu-elements',
		array(
			'title' => 'Themescamp Custom Menu Elements',
			'icon'  => 'font',
		),
		2
	);
} );

//add new category elementor
add_action( 'elementor/init', function () {
	$elementsManager = Elementor\Plugin::instance()->elements_manager;
	$elementsManager->add_category(
		'themescamp-portfolio-elements',
		array(
			'title' => 'Themescamp Single Portfolio Elements',
			'icon'  => 'font',
		),
		3
	);
} );

//add new category elementor 
add_action( 'elementor/init', function () {
	$elementsManager = Elementor\Plugin::instance()->elements_manager;
	$elementsManager->add_category(
		'themescamp-blog-elements',
		array(
			'title' => 'Themescamp Blog Post Elements',
			'icon'  => 'font',
		),
		4
	);
} );




add_action('elementor/element/before_section_end', function( $section, $section_id, $args ) {
	if( $section->get_name() == 'google_maps' && $section_id == 'section_map' ){
		// we are at the end of the "section_image" area of the "image-box"
		$section->add_control(
			'tc_map_style' ,
			[
				'label'        => 'Map Style',
				'type'         => Elementor\Controls_Manager::SELECT,
				'default'      => 'default',
				'options'      => array( 'default' => 'Default', 'gray' => 'Grayscale Map' ),
				'prefix_class' => 'map-',
				'label_block'  => true,
			]
		);
	}
}, 10, 3 );


// Dynamic Slider
add_action( 'elementor/editor/after_enqueue_scripts', function() {
    wp_enqueue_script('tcg-dynamic-editor-js', THEMESCAMP_URL .'elementor/elements/assets/admin/js/dynamic-editor.js', false, true  );
} );

add_action( 'elementor/editor/after_enqueue_styles', function() {  
    wp_enqueue_style('tcg-dynamic-slider-editor-style', THEMESCAMP_URL .'elementor/elements/assets/admin/css/style.css', array(), null, 'all'  );
} );


add_action( 'wp_ajax_nopriv_tcg_create_dynamic_block', 'tcg_create_dynamic_block' );
add_action( 'wp_ajax_tcg_create_dynamic_block', 'tcg_create_dynamic_block' );

function tcg_create_dynamic_block() {
    $slider_title = $_POST['post_title'];

    // Create post object
    $new_tcg_dynamic_slider = array(
        'post_type'     => 'tcg_teb',
        'post_title'    => $slider_title,
        'post_status'   => 'publish',
        'post_author'   => 1,
        'meta_input' => array(
	        'template_type' => 'block',
	    )
    );

    // Insert the post into the database
    echo wp_insert_post( $new_tcg_dynamic_slider );
    
    wp_die();
}