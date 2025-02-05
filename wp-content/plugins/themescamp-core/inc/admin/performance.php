<?php
namespace ThemescampPlugin\Admin;
global  $post, $tcg_theme_settings;
/**
 * Performance
 */
class Themescamp_Performance {

    function __construct() {

        //via action
        add_action( 'after_setup_theme', [$this, 'remove_emojy'], 99 );
        add_action( 'wp_enqueue_scripts', [$this, 'remove_css'], 99 );
        add_action( 'wp_enqueue_scripts', [$this, 'remove_gsap_anim_scripts'], 99 );
        add_action( 'wp_enqueue_scripts', [$this, 'remove_smoke_cursor_scripts'], 99 );
        add_action( 'elementor/frontend/after_enqueue_scripts', [$this, 'remove_scripts'], 99 );
        add_action( 'elementor/frontend/after_enqueue_styles', [$this, 'remove_styles'], 20 );
    }

    function remove_emojy() {

        if(themescamp_settings( 'performance_emojy' ) == false){
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('wp_print_styles', 'print_emoji_styles');
            remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
            remove_action( 'admin_print_styles', 'print_emoji_styles' );
        }
    }

    function remove_css() {

        if(themescamp_settings( 'performance_block_style' ) == false){
            wp_dequeue_style( 'wp-block-library' );
            wp_dequeue_style( 'wp-block-library-theme' );
            wp_dequeue_style( 'wc-block-style' );
        }

    }

    function remove_gsap_anim_scripts() {
        if(themescamp_settings( 'performance_scroll' ) == false){
            wp_dequeue_script( 'gsap-js' );
            wp_dequeue_script( 'gsap-st' ); 
            wp_dequeue_script( 'gsap-ss' ); 
            wp_dequeue_script( 'gsap-app' ); 
        }
    }

    function remove_smoke_cursor_scripts() {
        if(themescamp_settings( 'tcg_cursor_set' ) != 2){
            wp_dequeue_script( 'tcg-cursor-smoke' ); 
        }
    }

    function remove_scripts() {
        if(themescamp_settings( 'performance_scroll' ) == false){
            wp_dequeue_script( 'gsap-js' );
            wp_dequeue_script( 'gsap-st' ); 
            wp_dequeue_script( 'gsap-ss' ); 
            wp_dequeue_script( 'gsap-app' ); 
        }
        if(themescamp_settings( 'tcg_cursor_set' ) != 2){
            wp_dequeue_script( 'tcg-cursor-smoke' ); 
        }
        if(themescamp_settings( 'performance_elemnetor_animate' ) == false){
            wp_deregister_style( 'e-animations' );
            wp_dequeue_style( 'e-animations' );
        }
    }

    function remove_styles() {

        if(themescamp_settings( 'performance_fa' ) == false){
            foreach( [ 'solid', 'regular', 'brands' ] as $style ) {
                wp_deregister_style( 'elementor-icons-fa-' . $style  );
                wp_dequeue_style( 'elementor-icons-fa-' . $style );
            }
        }

        if(themescamp_settings( 'performance_eicon' ) == false){
            // Don't remove it in the backend
             if ( is_admin() || current_user_can( 'manage_options' ) ) {
                     return;
             }
            wp_deregister_style( 'elementor-icons' );
            wp_dequeue_style( 'elementor-icons' );
        }
    }

}
new Themescamp_Performance;