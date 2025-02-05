<?php
/**
 * Plugin Name: Themescamp Framework
 * Plugin URI: https://themescamp.com/potfolio
 * Description: Core plugin for ThemesCamp WordPress Themes.
 * Author: themesCamp
 * Author URI: https://themescamp.com
 * Requires at least: 6.0
 * Tested up to: 6.6
 * Requires PHP: 7.4
 * Version: 2.1.8
 * License: GPL3
 * Text Domain: themescamp-core
 * Domain Path: /lang
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'VERSION', '2.1.7' );
define( 'THEMESCAMP__FILE__', __FILE__ );
define( 'THEMESCAMP_URL', plugins_url( '/', THEMESCAMP__FILE__ ) );
define( 'THEMESCAMP_PLUGIN_BASE', plugin_basename( THEMESCAMP__FILE__ ) );
define( 'TCG_BADGE', '<span class="tc-e-badge"></span>');


/*============================================== Plugin Load ============================================*/

// Load the plugin after other plugins are loaded.
function themescamp_plgn_load() {

	// Load localization file
	load_plugin_textdomain( 'themescamp-core' );

	// Require the main plugin file 
	require( __DIR__ . '/init.php' );

}
add_action( 'plugins_loaded','themescamp_plgn_load' );


// Display an error message in the WordPress admin dashboard if the "Elementor" plugin is out of date
function themescamp_plugin_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message = '<p>' . __( 'Themescamp Plugin is not working because you are using an old version of Elementor.', 'themescamp-core' ) . '</p>';
	$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'themescamp-core' ) ) . '</p>';

	echo '<div class="error">' . $message . '</div>';
}


/*============================================== After plugin Load ============================================*/

//include option-settings
include('inc/admin/option-settings.php');

// ## Add action hook a function executed after the theme is loaded and set up.
add_action( 'after_setup_theme', 'themescamp_theme_setup' );
function themescamp_theme_setup() {
    
    if (defined('TCG_THEME_DEV_MOD') && TCG_THEME_DEV_MOD === true) {
        update_option('tcg_theme_dev_mod', true);
    } else{update_option('tcg_theme_dev_mod', false);}

    if (defined('TCG_THEME_ELEMENTS') && TCG_THEME_ELEMENTS === true) {
        update_option('tcg_theme_elements', true);
    } else{update_option('tcg_theme_elements', false);}

    if (defined('TCG_THEME_NAME')) {
        update_option('tcg_theme_name', TCG_THEME_NAME);
    }else{update_option('tcg_theme_name', '');} 

    if (!empty(defined('TCG_THEME_ID'))) {
        update_option('tcg_theme_id', TCG_THEME_ID);
    }else{delete_option('tcg_theme_id');}

    if (defined('TCG_THEME_VERSION')) {
        update_option('tcg_theme_version', TCG_THEME_VERSION);
    }else{update_option('tcg_theme_version', '');}

    if (defined('TCG_THEME_DEMO_URL')) {
        update_option('tcg_theme_demo_url', TCG_THEME_DEMO_URL);
    }else{update_option('tcg_theme_demo_url', '');}

    if (defined('DARK_LIGHT_SUPPORT') && DARK_LIGHT_SUPPORT === true) { 
        update_option('dark_light_support', true);
    } else{update_option('dark_light_support', false);}

    if (defined('TCG_THEME_DEMO_CLOUD') && TCG_THEME_DEMO_CLOUD === true) {
        update_option('tcg_theme_demo_cloud', true);
    } else{update_option('tcg_theme_demo_cloud', false);}

    if (defined('TCG_THEME_DEMO_WITH_INNER') && TCG_THEME_DEMO_WITH_INNER === true) {
        update_option('tcg_theme_demo_with_inner', true);
    } else{update_option('tcg_theme_demo_with_inner', false);}
    
    update_option( 'elementor_disable_color_schemes', 'yes' ); 
    update_option( 'elementor_disable_typography_schemes', 'yes' ); 
    update_option( 'elementor_load_fa4_shim', 'yes' ); 
    $cpt_support = [ 'page', 'post','product','portfolio','tcg_teb' ];
    update_option( 'elementor_cpt_support', $cpt_support ); //update 'Costom post type'

    // Custom Post Type Supports 
    add_theme_support( 'tcg_teb' );
    add_theme_support( 'portfolio' );
}

// Filter out the "tcg_teb" post type with "template_type" set to "block" 
function themescamp_exclude_tcg_teb_block_from_elementor_admin_bar( $settings ) {
    if ( isset( $settings['elementor_edit_page']['children'] ) && themescamp_settings('tcg_show_block_edit')== 'hide') {
        
        $settings['elementor_edit_page']['children'] = array_filter( $settings['elementor_edit_page']['children'], function ( $child ) {
            $post_id = str_replace( 'elementor_edit_doc_', '', $child['id'] );
            $post_type = get_post_type( $post_id );
            $template_type = get_post_meta( $post_id, 'template_type', true );

            // Exclude "tcg_teb" post type with "template_type" set to "block"
            return !($post_type === 'tcg_teb' && $template_type === 'block');
        });
    }

    return $settings;
}
add_filter( 'elementor/frontend/admin_bar/settings', 'themescamp_exclude_tcg_teb_block_from_elementor_admin_bar' );



/*==============================================Theme Enhancement============================================*/

// Remove the calculated image sizes
add_filter( 'wp_calculate_image_sizes', '__return_false' );


// Remove iframe obsolete attribute
function themescamp_remove_iframe_attributes($content){
    return str_replace(array('<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"', '</iframe>'), array('<iframe ', '</iframe>'), $content);
}
add_filter('the_content', 'themescamp_remove_iframe_attributes');

// Remove noscript obsolete attribute
function themescamp_remove_noscript_attributes($content){
    return str_replace(array('<noscript><img'), array('<img'), $content);
}
add_filter('the_content', 'themescamp_remove_noscript_attributes');


// Remove font-display from the header
function themescamp_start_wp_head_buffer()
{
    ob_start();
}
function themescamp_end_wp_head_buffer()
{
    $head_content = ob_get_clean();
    $head_content = str_replace('font-display:swap;', '', $head_content);

    echo $head_content;
}
add_action('wp_head', 'themescamp_start_wp_head_buffer', 0);
add_action('wp_head', 'themescamp_end_wp_head_buffer', PHP_INT_MAX);

// Function to remove the WordPress generator meta tag
function themescamp_remove_wordpress_generator() {
    remove_action('wp_head', 'wp_generator');
}

// Add our function to the wp_head action hook
add_action('wp', 'themescamp_remove_wordpress_generator');


function themescamp_custom_styles_to_head() {
    // Check for header styles
    if ( ! empty( $GLOBALS['tcg_custom_header_styles'] ) ) {
        echo $GLOBALS['tcg_custom_header_styles'];
    }
    // Check for footer styles
    if ( ! empty( $GLOBALS['tcg_custom_footer_styles'] ) ) {
        echo $GLOBALS['tcg_custom_footer_styles'];
    }
    // Check for offcanvas styles
    if ( ! empty( $GLOBALS['tcg_custom_offcanvas_styles'] ) ) {
        echo $GLOBALS['tcg_custom_offcanvas_styles'];
    }
}
add_action('wp_head', 'themescamp_custom_styles_to_head');


/*============================================== Include ============================================*/


//include elementor Addon & Lib
include('elementor/elementor-init.php');

//include footer
include('inc/template-parts/standard-blocks.php');

//include portfolio custom post type,metaboxes & single portfolio script
include('inc/portfolio.php');

//include page metabox
include('inc/page-metaboxes.php');

//include Custom font
include('inc/custom-font.php');

//include single portfolio function
include('inc/single-portfolio.php');


//included newsletter widget
include('inc/newsletter.php');

//included custom widget
include('inc/about-us.php');

//included recent posts widget
include('inc/recent-posts.php');

//included sharing
include('inc/sharebox.php');

//included User roles
include('inc/user-roles.php');

//included shortcode importer
include('inc/shortcode.php');

//included breadcrumbs
include('inc/breadcrumbs.php');

//include options-framework (Customized by ThemesCamp)
include('options-core/framework.php');

//include options-framework (Customized by ThemesCamp)
if(!class_exists('OCDI_Plugin')){
    include('ocdi/one-click-demo-import.php');
}

//include color schemes 
require_once( ABSPATH . 'wp-admin/includes/class-walker-nav-menu-edit.php' );
include( 'inc/mega-menu/mega-menu.php');

//include woo 
include('inc/woo.php');

//included switcher
include( 'inc/sw.php');

//included template-parts
include( 'inc/template-parts/parts-init.php');

//included pages
include( 'inc/template-parts/pages.php');

//included posts
include( 'inc/template-parts/post.php');

//included portfolio
include( 'inc/template-parts/portfolio.php');

//included posts
include( 'inc/template-parts/header.php');

//included posts
include( 'inc/template-parts/author.php');
include( 'inc/template-parts/author-template.php');

//included blogs
include( 'inc/template-parts/blank.php');

//included blogs
include( 'inc/template-parts/blogs.php');

//included Portfolio archive
include( 'inc/template-parts/port-archive.php');

//included search
include( 'inc/template-parts/search.php');
include( 'inc/template-parts/search-template.php');

//included search
include( 'inc/template-parts/sidebars.php');

//included count view
include( 'inc/template-parts/count-view.php');

//included 404 error
include( 'inc/template-parts/err.php');
include( 'inc/template-parts/404-template.php');

//include color schemes 
include( 'inc/template-parts/sidebar-helper.php');

//include license 
// Define your license inclusion function
//function include_license_function() {
    if (get_option('tcg_theme_id') || get_option('tcg_theme_dev_mod')) {
        include( 'inc/license.php');
    }
//}
// Hook your function to a custom action hook
//add_action('tcg_include_license', 'include_license_function');


//include Template builder
include( 'inc/template-builder/template-admin.php');
include( 'inc/template-builder/template-frontend.php');
include( 'inc/template-builder/template-rules.php');
include('inc/template-builder/template-cpt.php');


include('inc/admin/admin-init.php');
include('inc/admin/show-meta.php');
include('inc/admin/performance.php');

include('inc/ajax.php');

//included import demos
if(get_option('tcg_theme_demo_cloud')){
    include( 'inc/one-click-cloud.php');
}else{
    include( 'inc/one-click.php');
}

/*============================================== Core functions ============================================*/

//plugin translation 
function themescamp_textdomain_translation() {
    load_plugin_textdomain('themescamp-core', false, dirname(plugin_basename(__FILE__)) . '/lang/');
} // end custom_theme_setup
add_action('after_setup_theme', 'themescamp_textdomain_translation');



//CPT templates
function themescamp_template_redirect($template) {
    global $post;

    // Array mapping post types to their templates
    $post_type_templates = array(
        'header'    => 'templates/single-header.php',
        'footer'    => 'templates/single-footer.php',
        'portfolio' => 'templates/single-portfolio.php',
        'shop'      => 'templates/single-shop.php',
        'megamenu'  => 'templates/single-megamenu.php',
        'offcanvas' => 'templates/single-offcanvas.php',
        '404'       => 'templates/404.php',
        'elementor_library' => 'templates/single-elementor_library.php',
        'product'   => 'templates/single-product.php',
        'archive-product' => 'templates/archive-product.php',
    );

    // Determine if the current page is a single or archive page
    if (is_singular() && is_object($post) && isset($post->post_type)) {
        $post_type = $post->post_type;

        // Check for single post types
        if (isset($post_type_templates[$post_type])) {
            $new_template = plugin_dir_path(__FILE__) . $post_type_templates[$post_type];
            
            // Check if the file exists
            if (file_exists($new_template)) {
                return $new_template;
            }
        }
    } elseif (is_post_type_archive()) {
        // Handle archive pages for custom post types
        $post_type = get_post_type();

        if (isset($post_type_templates["archive-$post_type"])) {
            $new_template = plugin_dir_path(__FILE__) . $post_type_templates["archive-$post_type"];
            
            // Check if the file exists
            if (file_exists($new_template)) {
                return $new_template;
            }
        }
    }

    return $template;
}
add_filter('template_include', 'themescamp_template_redirect', 99);




function themescamp_templates($template) {
    // Array of taxonomies
    $taxonomies = array('portfolio_category', 'porto_tag');

    // Get the queried object
    $term = get_queried_object();

    // Set the path to the plugin's template directory
    $plugin_path = plugin_dir_path(__FILE__) . 'templates/';

    // Check if it's the portfolio post type archive or a taxonomy archive
    if (is_post_type_archive('portfolio') || (is_tax($taxonomies) && isset($term->taxonomy))) {
        return $plugin_path . 'archive-portfolio.php';  
    }

    // Return the default template if no condition matches
    return $template;
}
add_filter('template_include', 'themescamp_templates');



//MENUS


// Function to display menu description 
function themescamp_nav_description( $item_output, $item, $depth, $args ) {
    if ( !empty( $item->description ) ) {
        $item_output = str_replace( $args->link_after . '</a>', '<p class="menu-item-desc">' . $item->description . '</p>' . $args->link_after . '</a>', $item_output );
    }
    return $item_output;
}


add_filter( 'walker_nav_menu_start_el', 'themescamp_nav_description', 10, 4 );

//function custom header by page settings   
function themescamp_custom_menu_page ($menu) {
    global $post ;
    $tcg_header_menu =  themescamp_settings( $menu );
    if (!empty($tcg_header_menu)):
        wp_nav_menu( array(
            'menu'            => $tcg_header_menu,
            'items_wrap' => '<ul id="%1$s" class="home-nav navigation %2$s">%3$s</ul>',
            'menu_id'         => '',
            'echo'            => true,
        ) );
    elseif(has_nav_menu('primary_menu')):
        $menu = '';
        $walker = class_exists('Themescamp_Walker_Nav_Primary') ? new Themescamp_Walker_Nav_Primary() : ''; // Check if class is exists
        wp_nav_menu( array(
            'menu_id'         => '',
            'items_wrap' => '<ul id="%1$s" class="home-nav navigation %2$s">%3$s</ul>',
            'theme_location' => 'primary_menu',
            'walker' => $walker


              
        ) );
    endif;
}

//function custom header by page settings
function themescamp_custom_flat_menu_page ($flatmenu) {
    global $post ;
    $walker = class_exists('Themescamp_Walker_Nav_Primary') ? new Themescamp_Walker_Nav_Primary() : ''; // Check if class is exists
    $tcg_header_flat_menu = themescamp_settings( $flatmenu );
    if ( !empty($tcg_header_flat_menu) ):
        $menuParameters_flat = array(
            'menu' => $tcg_header_flat_menu,
            'container'       => true,
            'items_wrap'      => '<ul id="%1$s" class="mob-nav  %2$s">%3$s</ul>',
            'depth'           => 0,
            
        );
    else:
        $menuParameters_flat = array(
            'theme_location' => 'primary_menu',
            'container'       => false,
            'items_wrap'      => '<ul id="%1$s" class="mob-nav  %2$s">%3$s</ul>',
            'depth'           => 0,
            'walker' => $walker
        );
    endif;
    echo strip_tags(wp_nav_menu( $menuParameters_flat ), '<a>' );
}


//related post
function themescamp_related_post( $post_id, $related_count, $args = array() ) {
    $args = wp_parse_args( (array) $args, array(
        'orderby' => 'rand',
        'return'  => 'query',
    ) );

    $related_args = array(
    'post_type'      => get_post_type( $post_id ),
    'posts_per_page' => $related_count,
    'post_status'    => 'publish',
    'post__not_in'   => array( $post_id ),
    'orderby'        => $args['orderby'],
    'tax_query'      => array()
    );

    $post = get_post( $post_id );
    $taxonomies = get_object_taxonomies( $post, 'names' );

    foreach( $taxonomies as $taxonomy ) {
        $terms = get_the_terms( $post_id, $taxonomy );
        if ( empty( $terms ) ) continue;
        $term_list = wp_list_pluck( $terms, 'slug' );
        $related_args['tax_query'][] = array(
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => $term_list
        );
    }

    if( count( $related_args['tax_query'] ) > 1 ) {
        $related_args['tax_query']['relation'] = 'OR';
    }

    if( $args['return'] == 'query' ) {
        return new WP_Query( $related_args );
    } else {
        return $related_args;
    }
}


/* Replacing the default WordPress search form with an HTML5 version */   

function themescamp_search_form( $form ) {
    $tcg_unique_id = themescamp_unique_id( 'search-form-' );
    $form = '<form role="search" method="get" id="'.esc_attr( $tcg_unique_id ).'" class="searchform" action="' . esc_url( home_url( '/' ) ) . '" > 
    <input type="search" placeholder="'.esc_attr__('Type keyword here','themescamp-core').'" value="' . get_search_query() . '" name="s" />
    <input type="submit" class="searchsubmit" />
    </form>';
    return $form;
}


//Get unique ID. 
function themescamp_unique_id( $prefix = '' ) {
    static $id_counter = 0;
    if ( function_exists( 'wp_unique_id' ) ) {
        return wp_unique_id( $prefix );
    }
    return $prefix . (string) ++$id_counter;
}

// Add specific CSS class to body by filter. 
 
add_filter( 'body_class', function( $classes ) {
    $tcg_mode='';
    if (themescamp_settings( 'tcg_theme_mode')=='dark_mode'){$tcg_mode='tcg-dark-mode';
    }elseif(themescamp_settings( 'tcg_theme_mode')=='auto_mode'){$tcg_mode='tcg-auto-mode';}
    return array_merge( $classes, array( $tcg_mode ) );
} );


function themescamp_admin_bar_menu( $wp_admin_bar ) {

    $menu_title = get_option('tcg_theme_name') ? ucfirst(get_option('tcg_theme_name')) : 'ThemesCamp';

    // Add the main item
    $wp_admin_bar->add_node( [
        'id'    => 'tcg-admin-menu', // Unique ID for the main item
        'title' => $menu_title , // Title to be displayed in the admin bar
        'href'  => admin_url(), // Link for the main item (can be any URL or admin page)
    ] );

    $wp_admin_bar->add_node( [
        'id'     => 'options_link',
        'parent' => 'tcg-admin-menu',
        'title'  => 'Theme Options',
        'href'   => admin_url('admin.php?page=tcg_theme_settings'), 
    ] );

    $wp_admin_bar->add_node( [
        'id'     => 'builder_link',
        'parent' => 'tcg-admin-menu',
        'title'  => 'Theme Builder',
        'href'   => admin_url('edit.php?post_type=tcg_teb'), 
    ] );

    $wp_admin_bar->add_node( [
        'id'     => 'system_link',
        'parent' => 'tcg-admin-menu',
        'title'  => 'System status',
        'href'   => admin_url('admin.php?page=system-settings-page'), 
    ] );


    $wp_admin_bar->add_node( [
        'id'     => 'intro_link',
        'parent' => 'tcg-admin-menu',
        'title'  => 'General info',
        'href'   => admin_url('admin.php?page=tcg_init'), 
    ] );

}

add_action( 'admin_bar_menu', 'themescamp_admin_bar_menu', 100 );
