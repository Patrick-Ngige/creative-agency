<?php
namespace ThemescampPlugin;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Main Plugin Class (scripts & styles)
 */
class ThemescampPlugin {


	public function __construct() {

		// enqueue_scripts : Loaded script & register_scripts : Ready to load script when called (like in widget).

		// Backend scripts globally load. 
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );

		// Backend styles globally load. 
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_styles' ] );


		// Frontend scripts globally load.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

		// Frontend styles globally load. 
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );


		// Frontend scripts Elementor load.
        add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'elementor_enqueue_scripts' ] );

        // Frontend styles Elementor load.
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'elementor_enqueue_styles' ] );

        // Editor icons Elementor load.
		add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'elementor_enqueue_icons' ] );

		// Icons lib scripts Elementor load.
		add_filter( 'elementor/icons_manager/additional_tabs',  [$this, 'flaticon_tabs'] );
		add_filter( 'elementor/icons_manager/additional_tabs',  [$this, 'peicon_tab']);

	    //custom color schecmes script 
	    add_action( 'wp_enqueue_scripts', [$this, 'color_scheme'],99 );

	    //custom cursor
	    add_action( 'wp_enqueue_scripts', [$this, 'custom_cursor'],99 );

	    //preloader styles.
	    add_action( 'wp_enqueue_scripts', [$this, 'preloader_set'] );

	    //preloader script.
	    add_action( 'wp_enqueue_scripts', [$this, 'preloader'] );

	}


	public function enqueue_admin_scripts(){
       wp_enqueue_script( 'admin-scripts', THEMESCAMP_URL.'assets/js/admin-scripts.js', [ 'jquery' ], VERSION, true );
	}

	public function enqueue_admin_styles(){
		wp_enqueue_style('admin-tcg-styles', THEMESCAMP_URL.'assets/css/admin.css');
	}


	public function enqueue_scripts(){
       wp_enqueue_script( 'scripts', THEMESCAMP_URL.'assets/js/scripts.js', [ 'jquery' ], VERSION, true );
       wp_enqueue_script( 'social-share', THEMESCAMP_URL.'assets/js/social-share.js', [ 'jquery' ], VERSION, true );


		// The core GSAP library
		wp_enqueue_script( 'gsap-js', THEMESCAMP_URL.'assets/js/gsap.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'gsap-st', THEMESCAMP_URL.'assets/js/ScrollTrigger.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'gsap-stp', THEMESCAMP_URL.'assets/js/ScrollToPlugin.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'gsap-ss', THEMESCAMP_URL.'assets/js/ScrollSmoother.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'gsap-spt', THEMESCAMP_URL.'assets/js/SplitText.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'gsap-app', THEMESCAMP_URL.'assets/js/app-animation.js', array('gsap-js'), false, true ); 
		wp_enqueue_script( 'tcg-cursor-smoke', THEMESCAMP_URL.'assets/js/smoke.js', false, true ); 
		wp_enqueue_script( 'skicky-kit-js', THEMESCAMP_URL.'assets/js/sticky-kit.min.js', array('gsap-js'), false, true ); 
		wp_enqueue_script( 'skicky-kit-app', THEMESCAMP_URL.'assets/js/sticky.js', array('gsap-js', 'skicky-kit-js'), false, true ); 
	}


	public function enqueue_styles(){ 

		// Icon fonts
		wp_enqueue_style('linea_arrows', THEMESCAMP_URL . '/assets/fonts/linea/arrows/css/style.css', array(), '', 'all');
		wp_enqueue_style('linea_basic', THEMESCAMP_URL . '/assets/fonts/linea/basic/css/style.css', array(), '', 'all');
		wp_enqueue_style('linea_basic_2', THEMESCAMP_URL . '/assets/fonts/linea/basic_ela/css/style.css', array(), '', 'all');
		wp_enqueue_style('linea_ecommerce', THEMESCAMP_URL . '/assets/fonts/linea/basic/css/style.css', array(), '', 'all');
		wp_enqueue_style('linea_music', THEMESCAMP_URL . '/assets/fonts/linea/basic/css/style.css', array(), '', 'all');
		wp_enqueue_style('linea_software', THEMESCAMP_URL . '/assets/fonts/linea/software/css/style.css', array(), '', 'all');
		wp_enqueue_style('linea_weather', THEMESCAMP_URL . '/assets/fonts/linea/weather/css/style.css', array(), '', 'all');

		// Main style
        if( is_rtl() ) {
		    wp_enqueue_style('themescamp-style-rtl', THEMESCAMP_URL . 'assets/css/style-rtl.css', array(), '', 'all');
        } else {
            wp_enqueue_style('themescamp-style', THEMESCAMP_URL . 'assets/css/style.css', array(), '', 'all');
        }

	}
	

	public function elementor_enqueue_scripts(){
		// custom-scripts
       wp_enqueue_script( 'themescamp-addons-custom-scripts', THEMESCAMP_URL.'assets/js/scripts.js', [ 'jquery' ], VERSION, true );
	
		// The core GSAP library
		wp_enqueue_script( 'gsap-js', THEMESCAMP_URL.'assets/js/gsap.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'gsap-st', THEMESCAMP_URL.'assets/js/ScrollTrigger.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'gsap-stp', THEMESCAMP_URL.'assets/js/ScrollToPlugin.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'gsap-ss', THEMESCAMP_URL.'assets/js/ScrollSmoother.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'gsap-spt', THEMESCAMP_URL.'assets/js/SplitText.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'gsap-app', THEMESCAMP_URL.'assets/js/app-animation.js', array('gsap-js'), false, true ); 
		wp_enqueue_script( 'tcg-cursor-smoke', THEMESCAMP_URL.'assets/js/smoke.js', false, true ); 
		wp_enqueue_script( 'tcg-parallaxie', THEMESCAMP_URL.'assets/js/parallaxie.js', false, true ); 
	}

	public function elementor_enqueue_styles(){

		
        if( !is_rtl() ) {
            wp_enqueue_style('bootstrap',THEMESCAMP_URL .'assets/css/bootstrap.min.css', array(), null, 'all'  );
        } else {
            wp_enqueue_style('bootstrap-rtl',THEMESCAMP_URL .'assets/css/bootstrap.rtl.min.css', array(), null, 'all'  );
        }
		wp_enqueue_style('themescamp-style-addons',THEMESCAMP_URL .'assets/fonts/flaticon/flaticon.css', array(), null, 'all'  );
		wp_enqueue_style('peicon-style-addons',THEMESCAMP_URL .'assets/fonts/peicon/pe-icon-7-stroke.css', array(), null, 'all'  );
		wp_enqueue_style('fontawesome-style-addons',THEMESCAMP_URL .'assets/fonts/fa/css/fontawesome.min.css', array(), null, 'all'  );
		wp_enqueue_style('bootstrap-icons',THEMESCAMP_URL .'assets/fonts/bootstrap-icons/bootstrap-icons.css', array(), null, 'all'  );

		// Main widget style
        if( is_rtl() ) {
		    wp_enqueue_style('themescamp-elements-style-rtl',THEMESCAMP_URL.'/elementor/elements/assets/css/style-rtl.css', array(), '', 'all'  );
        } else {
            wp_enqueue_style('themescamp-elements-style',THEMESCAMP_URL.'/elementor/elements/assets/css/style.css', array(), '', 'all'  );
        }
	}

	public function elementor_enqueue_icons(){

		wp_enqueue_style('themescamp-style-addons',THEMESCAMP_URL .'assets/fonts/flaticon/flaticon.css', array(), null, 'all'  );
		wp_enqueue_style('peicon-style-addons',THEMESCAMP_URL .'assets/fonts/peicon/pe-icon-7-stroke.css', array(), null, 'all'  );

	}

	public function flaticon_tabs($tabs) {

		$json_url =THEMESCAMP_URL.'assets/fonts/flaticon/flaticon-new.json';
		$flaticon = [
		  'name'          => 'flaticon',
		  'label'         => esc_html__( 'Themescamp Icons', 'themescamp-core' ),
		  'url'           => false,
		  'enqueue'       => false,
		  'prefix'        => '',
		  'displayPrefix' => '',
		  'labelIcon'     => 'fab fa-font-awesome-alt',
		  'ver'           => '1.0.0',
		  'fetchJson'     => $json_url,
		];
		array_push( $tabs, $flaticon);


		return $tabs;
	}


	public function peicon_tab($petab) {

		$pe_json_url =THEMESCAMP_URL.'assets/fonts/peicon/peicon.json';
		$peicon = [
		  'name'          => 'peicon',
		  'label'         => esc_html__( 'Pe Icons', 'themescamp-core' ),
		  'url'           => false,
		  'enqueue'       => false,
		  'prefix'        => '',
		  'displayPrefix' => '',
		  'labelIcon'     => 'fab fa-font-awesome-alt',
		  'ver'           => '1.0.0',
		  'fetchJson'     => $pe_json_url,
		];
		array_push( $petab, $peicon);


		return $petab;
	}


	//color schemes 
	public function color_scheme() {
		  
			global $post ;
			global $tcg_theme_settings;
			$theme_style=get_option('tcg_theme_name');
			$core_style='themescamp-style';

			//Theme color options
			$main_col = themescamp_settings( 'tcg_main_color' );
			$primary_col = themescamp_settings( 'tcg_primary_color' );
			$secondary_col = themescamp_settings( 'tcg_secondary_color' );
			$ternary_col = themescamp_settings( 'tcg_ternary_color' ); 
			$color_general = "
				:root{
					--color-main:$main_col;
					--color-primary:$primary_col;
					--color-secondary:$secondary_col;
					--color-ternary: $ternary_col;
				}
			";   

			if (  themescamp_settings( 'tcg_main_color' ) ) {           
				wp_add_inline_style( $theme_style, $color_general );
				wp_add_inline_style( $core_style, $color_general );
			}

			//hovers color
			$hovers = themescamp_settings( 'tcg_custom_hovers' );
			if (  themescamp_settings( 'tcg_custom_hovers' ) ) {  
				$custom_hovers = "a:hover{color:$hovers;}";         
				wp_add_inline_style( $theme_style, $custom_hovers );
				wp_add_inline_style( $core_style, $custom_hovers );
			}

			//scheme color
			$color = themescamp_settings( 'tcg_color_scheme' );
			if (  themescamp_settings( 'tcg_color_scheme' ) ) {  
				$custom_colorx = "a{color:$color;}";   
				wp_add_inline_style( $theme_style, $custom_colorx );
				wp_add_inline_style( $core_style, $custom_colorx );
			}
			
			//heading color 
			$heading = themescamp_settings( 'tcg_heading_color' );
			if (  themescamp_settings( 'tcg_heading_color' ) ) { 
				$heading_color = "h1, h2, h3, h4, h5, h6{color:$heading;} ";   
				wp_add_inline_style( $theme_style, $heading_color );
				wp_add_inline_style( $core_style, $heading_color );
			}

			//body color
			$general = themescamp_settings( 'tcg_general_color' );   
			if (  themescamp_settings( 'tcg_general_color' ) ) { 
				$general_color = "body{color:$general;}";          
				wp_add_inline_style( $theme_style, $general_color );
				wp_add_inline_style( $core_style, $general_color );
			}
			
			//footer color
			$footer = themescamp_settings( 'tcg_footer_color' );
			if (  themescamp_settings( 'tcg_footer_color' ) ) {   
				$footer_color = ".footer{background-color:$footer;}";   
				wp_add_inline_style( $theme_style, $footer_color );
				wp_add_inline_style( $core_style, $footer_color );
			}

			//Main menu background
			$main_menu = themescamp_settings( 'tcg_main_menu' );
			if (  themescamp_settings( 'tcg_main_menu' ) ) {  
				$color_menu = ".white-header{background: $main_menu;}";   
				wp_add_inline_style( $theme_style, $color_menu );
				wp_add_inline_style( $core_style, $color_menu );
			}
			//Main menu color
			$main_menu = themescamp_settings( 'tcg_main_menu_hover' );
			if (  themescamp_settings( 'tcg_main_menu_hover' ) ) {  
				$color_menu = ".white-header .navigation li a{color: $main_menu;}";   
				wp_add_inline_style( $theme_style, $color_menu );
				wp_add_inline_style( $core_style, $color_menu );
			}
			
			//Sticky menu background
			$menu = themescamp_settings( 'tcg_stick_menu_bg' );
			if (  themescamp_settings( 'tcg_stick_menu_bg' ) ) {  
				$color_menu = ".white-header .is-sticky .stuck-nav{background: $menu;}";   
				wp_add_inline_style( $theme_style, $color_menu );
				wp_add_inline_style( $core_style, $color_menu );
			}

			//menu2 color
			$menu2 = themescamp_settings( 'tcg_stick_menu_color' );
			if (  themescamp_settings( 'tcg_stick_menu_color' ) ) { 
				$color_menu2 = ".white-header .is-sticky .navigation li a{color: $menu2;}";   
				wp_add_inline_style( $theme_style, $color_menu2 );
				wp_add_inline_style( $core_style, $color_menu2 );
			}

			//menu border color
			$menu_border = themescamp_settings( 'tcg_menu_border' );
			if (  themescamp_settings( 'tcg_menu_border' ) ) { 
				$color_border = ".custom-absolute-menu{border-color: $menu_border;}";   
				wp_add_inline_style( $theme_style, $color_border );
				wp_add_inline_style( $core_style, $color_border );
			} 

			//To top color
			$tcg_to_top_color = themescamp_settings( 'tcg_to_top_color' );
			if (  themescamp_settings( 'tcg_to_top_color' ) ) { 
				$to_top_color = "
					.progress-wrap svg.progress-circle path{stroke: $tcg_to_top_color;} 
					.progress-wrap::after{color: $tcg_to_top_color;}
				";   
				wp_add_inline_style( $theme_style, $to_top_color );
				wp_add_inline_style( $core_style, $to_top_color );
			} 

			//Preloader text color
			$tcg_loader_text_color = themescamp_settings( 'tcg_loader_text_color' );
			if (  themescamp_settings( 'tcg_loader_text_color' ) ) { 
				$to_top_color = "
					.loader-wrap .loader-wrap-heading .load-text{color: $tcg_loader_text_color;} 
				";   
				wp_add_inline_style( $theme_style, $to_top_color );
				wp_add_inline_style( $core_style, $to_top_color );
			} 
	}


	public  function custom_cursor() {
		$theme_style=get_option('tcg_theme_name');
		$core_style='themescamp-style';


	    /* CSS to output */ 
	    $custom_css = '';
	    // if ( themescamp_settings( 'tcg_cursor_set' ) == '1') {
	    // 	$custom_css = "body {cursor: none;}"; 
	    // }
	    wp_add_inline_style($theme_style, $custom_css);
	    wp_add_inline_style($core_style, $custom_css);
	}

	//preloader custom setting
	public function preloader_set() {
		
		$color =  themescamp_settings( 'tcg_loader_color' );
		$loader_bg = "
		.load-circle{border-top-color: $color;}
		";   
		if (themescamp_settings( 'tcg_loader_color' )) {           
			wp_add_inline_style( 'theme-style', $loader_bg );
		}
		
	} 

	public function preloader() {
		
		$preload = themescamp_settings( 'tcg_preloader_set' );
		if ($preload == 'show_home') {
		    wp_enqueue_script( 'preloader', THEMESCAMP_URL.'assets/js/loader.js',array(),'', 'in_footer');
		}

		if ($preload == 'show_all') {
		    wp_enqueue_script( 'preloader', THEMESCAMP_URL.'assets/js/loader.js',array(),'', 'in_footer');
		}
	}  

}

new ThemescampPlugin();