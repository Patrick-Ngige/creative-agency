<?php
/**
 * Plugin Name: Infolio Theme Addons
 * Plugin URI: https://themeforest.net/user/themescamp/portfolio
 * Description: This is plugin bundle for Infolio WordPress Theme.
 * Author: themesCamp
 * Author URI: https://themeforest.net/user/themescamp
 * Version: 1.0.6
 * Text Domain: infolio_plg
 * Domain Path: /lang
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'INFOLIO__FILE__', __FILE__ );
define( 'INFOLIO_URL', plugins_url( '/', INFOLIO__FILE__ ) );
define( 'INFOLIO_PLUGIN_BASE', plugin_basename( INFOLIO__FILE__ ) );

//Global Theme Constants
define('TCG_THEME_PLG_VERSION', '1.0.5');
define('TCG_FRAMEWORK_PLG_VERSION', '2.0.5');
define('TCG_THEME_PLG_NAME', 'infolio');                       // used in core
define('TCG_THEME_PLG_DEMO_URL', 'infolio.themescamp.com'); // used in core
define('TCG_THEME_PLG_ID', '50200185');						// used in core
define('DARK_LIGHT_PLG_SUPPORT',true);                      // used in core
define('TCG_THEME_PLG_DEV_MOD',false);                      // used in core

/**
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */
function infolio_plg_load() {
	// Load localization file
	load_plugin_textdomain( 'infolio_plg' );

	// Require the main plugin file 
	require( __DIR__ . '/init.php' );

}
add_action( 'plugins_loaded','infolio_plg_load' );


function infolio_plg_fail_load_out_of_date() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$upgrade_link = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file_path, 'upgrade-plugin_' . $file_path );
	$message = '<p>' . __( 'Infolio Plugin is not working because you are using an old version of Elementor.', 'infolio_plg' ) . '</p>';
	$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $upgrade_link, __( 'Update Elementor Now', 'infolio_plg' ) ) . '</p>';

	echo '<div class="error">' . $message . '</div>';
}

//include elementor addon
include('inc/elementor-addon.php');

//include elementor addon
include('inc/elemntor-extras.php');

//included one click importer
//include('inc/one-click.php');

//plugin translation
function infolio_textdomain_translation() {
    load_plugin_textdomain('infolio_plg', false, dirname(plugin_basename(__FILE__)) . '/lang/');
} // end custom_theme_setup
add_action('after_setup_theme', 'infolio_textdomain_translation');

