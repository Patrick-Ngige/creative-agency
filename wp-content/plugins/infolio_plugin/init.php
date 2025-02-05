<?php
namespace InfolioPlugin;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Plugin Class
 *
 * Register new elementor widget. 
 *
 * @since 1.0.0
 */
class InfolioPlugin {

	// Constructor
	public function __construct() {
		$this->add_actions();
	}
	const VERSION = '1.0.0';

	//register all widgets & assets 
	public function add_actions() {

		//register all widgets & scripts
		add_action( 'elementor/widgets/register', [ $this, 'on_widgets_registered' ] );

		//Global called scripts
        add_action( 'elementor/frontend/after_enqueue_scripts', function() {
            $js_dir = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/elements/assets/js/global/';
            $js_url = untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/elements/assets/js/global/';
            foreach( glob( $js_dir . '*.js' ) as $file ) {
                $file_url = str_replace( $js_dir, $js_url, $file );
                $handle = '' . basename( $file, '.js' );
                wp_enqueue_script( $handle, $file_url, array( 'jquery' ), null, true );
            }
        });

		//LIB Ready to call scripts
        add_action( 'elementor/frontend/after_register_scripts', function() {
            $js_dir = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/elements/assets/js/lib/';
            $js_url = untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/elements/assets/js/lib/';
            foreach( glob( $js_dir . '*.js' ) as $file ) {
                $file_url = str_replace( $js_dir, $js_url, $file );
                $handle = '' . basename( $file, '.js' );
                wp_register_script( $handle, $file_url, array( 'jquery' ), null, true );
            }
        });

		//ELEMENTS Ready to call scripts
	    add_action( 'elementor/frontend/after_register_scripts', function() {
		      $js_dir = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/elements/assets/js/';
		      $js_url = untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/elements/assets/js/';
		      foreach( glob( $js_dir . '*.js' ) as $file ) {
		          $file_url = str_replace( $js_dir, $js_url, $file );
		          $handle = 'infolio-' . basename( $file, '.js' );
		          wp_register_script( $handle, $file_url, array( 'jquery' ), null, true );
		      }
		} );


        //Global Lib called styles
		add_action( 'elementor/frontend/after_enqueue_styles', function() {
		    $css_dir = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/elements/assets/css/global/';
		    $css_url = untrailingslashit( plugin_dir_url( __FILE__ ) ) . '/elements/assets/css/global/';
		    
		    foreach( glob( $css_dir . '*.css' ) as $file ) {
		        $file_url = str_replace( $css_dir, $css_url, $file );
		        $handle = '' . basename( $file, '.css' );
		        wp_enqueue_style( $handle, $file_url, array(), null, 'all' );
		    }
		});

		//Theme style
		add_action( 'elementor/frontend/after_enqueue_styles', function() {  wp_enqueue_style('infolio-plg-style',INFOLIO_URL .'elements/assets/css/style.css', array(), '1.0.0', 'all'  );} ); 
	}

	//On Widgets Registered
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	//List of elements
	public function widgets() {
		$widgets_path    = dirname( __FILE__ ) . '/elements/widgets/';
		$infolio_widgets = array_diff(scandir($widgets_path), array('.', '..'));
		return $infolio_widgets;
	}

	//Includes
	private function includes() {
		foreach ( $this->widgets() as $widget_name ) {
			require_once( __DIR__ . '/elements/widgets/'.$widget_name.'/'.$widget_name.'.php' );
		}
	}
	

	//Register Widget
	private function register_widget() {
		// Register Widgets
		foreach ( $this->widgets() as $widget_name ) {
			$widget_name__ = str_replace( '-', '_', $widget_name );
				$class_name= str_replace( '_', ' ', $widget_name__ );
				$class_name	 =ucwords(strtolower($class_name));
				$class_name= str_replace( ' ', '_', $class_name );
				$class_name='InfolioPlugin\Widgets\Infolio_'.$class_name;
				\Elementor\Plugin::instance()->widgets_manager->register( new $class_name() );
		}
	}
}

new InfolioPlugin();


