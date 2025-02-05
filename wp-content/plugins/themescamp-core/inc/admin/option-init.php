<?php
use ThemescampPlugin\Admin\Themescamp_Admin_Panel;
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if (! class_exists('Redux' )) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $tcg_pre = "tcg_theme_setting";

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $tcg_theme = wp_get_theme(); // For use with some settings. Not necessary.

    $tcg_options_args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name' => $tcg_pre,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name' => $tcg_theme->get('Name' ),
        // Name that appears at the top of your panel
        'display_version' => $tcg_theme->get('Version' ),
        // Version that appears at the top of your panel
        'menu_type' => 'submenu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu' => true,
        // Show the sections below the admin menu item or not
        'menu_title' => esc_html__( 'Theme Options', 'themescamp-core' ),
        'page_title' => esc_html__( 'Theme Options', 'themescamp-core' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key' => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography' => false,
        // Use a asynchronous font on the front end or font string
        'admin_bar' => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon' => 'dashicons-admin-generic',
        // Choose an icon for the admin bar menu
        'admin_bar_priority' => 50,
        // Choose an priority for the admin bar menu
        'global_variable' => 'tcg_theme_settings',
        // Set a different name for your global variable other than the tcg_pre
        'dev_mode' => false,
        // Show the time the page took to load, etc
        'update_notice' => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer' => false, 
        // Enable basic customizer support

        // OPTIONAL -> Give you extra features
        'page_priority' => 99,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent' => 'tcg_init',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions' => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon' => '',
        // Specify a custom URL to an icon
        'last_tab' => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon' => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug' => 'tcg_theme_settings',
        // Page slug used to denote the panel, will be based off page title then menu title then tcg_pre if not provided
        'save_defaults' => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show' => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark' => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export' => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time' => 60 * MINUTE_IN_SECONDS,
        'output' => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag' => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database' => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn' => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
		'hints' => array(
			'icon'              => 'icon-question-sign',
			'icon_position'     => 'right',
			'icon_color'        => 'lightgray',
			'icon_size'         => 'normal',

			'tip_style'         => array(
				'color'     => 'light',
				'shadow'    => true,
				'rounded'   => false,
				'style'     => '',
			),
			'tip_position'      => array(
				'my' => 'top left',
				'at' => 'bottom right',
			),
			'tip_effect' => array(
				'show' => array(
					'effect'    => 'slide',
					'duration'  => '500',
					'event'     => 'mouseover',
				),
				'hide' => array(
					'effect'    => 'slide',
					'duration'  => '500',
					'event'     => 'click mouseleave',
				),
			),
		),

        'search'                    => true,
    );


    // Add content after the form.
    $tcg_options_args['footer_text'] = esc_html__( 'If you need help please read docs and open a ticket on our support center.', 'themescamp-core' );

    Redux::setArgs($tcg_pre, $tcg_options_args);

/*
*  tcg Options Tabs 
*/

$path = plugin_dir_path( __FILE__ ) . '/options/';
$files = glob($path . "*.php");

foreach($files as $file) {
    include_once $file;
}

/*
*  tcg Meta-box Tabs 
*/

$path = plugin_dir_path( __FILE__ ) . '/metabox/';
$files = glob($path . "*.php");

foreach($files as $file) {
    include_once $file;
}


Redux::get_extensions( $tcg_pre );
Redux::get_extensions( $tcg_pre, 'options_object' );

function tcg_custom_redux_header() {
    (new Themescamp_Admin_Panel())->dashboard_tabs();
}
add_action('redux/page/tcg_theme_setting/form/before', 'tcg_custom_redux_header');





    

