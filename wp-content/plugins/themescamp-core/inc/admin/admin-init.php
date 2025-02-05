<?php
namespace ThemescampPlugin\Admin;

/**
 * Load Theme Admin
 */
class Themescamp_Admin_Panel {

    protected static $instance = null;


    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    public function initialize() {

        add_action('admin_init', [$this,'tcg_register_mailchimp_settings']);

        add_action('admin_init', [$this,'tcg_register_contact_form_settings']);

        /* Add the registration custom page */ 
        add_action('admin_menu',[$this,'tcg_init_menu'],9);

        // Hook into the admin menu
        add_action('admin_menu', [$this,'system_page_submenu']);

        // Hook into the admin menu
        add_action('admin_menu', [$this,'themescamp_saved_options_submenu']);

        //add_action('admin_menu', [$this,'themescamp_saved_customizer_submenu']);

        if (get_option('tcg_theme_status')=='active' || get_option('tcg_theme_dev_mod')){
            add_filter( 'ocdi/plugin_page_setup', [$this,'ocdi_plugin_page_setup'] );
        }

        //include options admin 
        include('option-init.php');

    }

    public function tcg_register_contact_form_settings()
    {

        register_setting('tcg_contact_form_settings', 'tcg_contact_form_email');
        register_setting('tcg_contact_form_settings', 'tcg_contact_form_recaptcha_site_key');
        register_setting('tcg_contact_form_settings', 'tcg_contact_form_recaptcha_secret_key');
        register_setting('tcg_contact_form_settings', 'tcg_contact_form_spam_email');
    }

    public function tcg_register_mailchimp_settings()
    {

        register_setting('tcg_mailchimp_settings', 'tcg_mailchimp_api_key');
        register_setting('tcg_mailchimp_settings', 'tcg_mailchimp_list_id');
    }


    public function tcg_init_menu() {

        $menu_title = get_option('tcg_theme_name') ? ucfirst(get_option('tcg_theme_name')) : 'ThemesCamp';
        // $menu_title = 'ThemesCamp';

        
            add_menu_page(
                $menu_title,        // Page title
                $menu_title,        // Page title
                'manage_options',    // Capability to be displayed to the user
                'tcg_init',   // Menu slug : /admin.php?page=tcg_init
                [$this,'init_page'], // Callback of the function to be called to output the content for this page
                THEMESCAMP_URL . 'assets//img/dashboard-icon-tc.png',
                2 // Position
            );

            // Add the first submenu item as "Dashboard"
            add_submenu_page(
                'tcg_init',          // Parent slug
                esc_html__('Dashboard', 'themescamp-core'), // Page title
                esc_html__('Dashboard', 'themescamp-core'), // Menu title
                'manage_options',    // Capability
                'tcg_init',          // Menu slug (same as parent slug to make it the default page)
                [$this, 'init_page'] // Callback function to display the page content
            );
            if (!has_action('tcg_license')) { 
                if (get_option('tcg_theme_id')){
                    add_submenu_page(
                        'tcg_init',    // Parent slug (use an existing admin menu)
                        'License',                // Page title
                        'License',                // Menu title
                        'manage_options',          // Capability to be displayed to the user
                        'registration',            // Sub-menu slug
                        'tcg_registration_page' // Callback function to output the content for this page
                    );
               }
           }

        // Add custom body class for specific admin page
        add_filter('admin_body_class', function($classes) use ($menu_title) {
            // Check if we're on the specific admin menu page
            $screen = get_current_screen();
            
            // Construct the ID for the menu page
            $menu_page_id = strtolower($menu_title).'_page_tgmpa-install-plugins'; // 'toplevel_page_' is used for top-level menu pages

            if ($screen->id === $menu_page_id) {
                $classes .= ' tcg_page_tgmpa-install-plugins';
            }
            
            return $classes;
        });

    }

    // Add a submenu page without displaying it in the dashboard menu
    function system_page_submenu() {
        if (get_option('tcg_theme_status')=='active' || get_option('tcg_theme_dev_mod')){
            add_submenu_page(
                'tcg_init',          // Parent slug
                'System Status',            // Page title
                'System Status',            // Menu title
                'manage_options',           // Capability to be displayed to the user
                'system-settings-page',       // Sub-menu slug : /admin.php?page=systen-settings-page
                [$this,'system_page']    // Callback of the function to be called to output the content for this page
            );
        }
    }

    // Add a submenu page without displaying it in the dashboard menu
    public function themescamp_saved_options_submenu() {
        add_submenu_page(
            '', // Set this to null to avoid displaying in the dashboard menu
            'All Saved Options',
            'All Options',
            'manage_options',
            'all-saved-options',
            [$this,'display_options_page']
        );

        // Add the Extensions submenu
        add_submenu_page(
            'tcg_init',          // Parent slug
            esc_html__('Extensions', 'themescamp-core'), // Page title
            esc_html__('Extensions', 'themescamp-core'), // Menu title
            'manage_options',    // Capability
            'tcg_extensions',          // Menu slug (same as parent slug to make it the default page)
            [$this, 'extensions_page'], // Callback function to display the page content
            999999
        );  
    }

    // Add a submenu page without displaying it in the dashboard menu
    public function themescamp_saved_customizer_submenu() {
        add_submenu_page(
            'tcg_init',  // Parent slug 
            'Live Customizer', // Page title
            'Live Customizer', // Menu title
            'manage_options', // Capability to be displayed to the user
            'customize.php?return=' . urlencode(admin_url('admin.php?page=tcg_init')) // Callback
        );
    }

    public function ocdi_plugin_page_setup( $default_settings ) {
        $default_settings['parent_slug'] = 'tcg_init';
        $default_settings['page_title']  = esc_html__( 'One Click Demo Import' , 'one-click-demo-import' );
        $default_settings['menu_title']  = esc_html__( 'Import Demo' , 'one-click-demo-import' );
        $default_settings['capability']  = 'import';
        $default_settings['menu_slug']   = 'one-click-demo-import';
     
        return $default_settings;
    }

    public function init_page(){

        require_once('admin-welcome-page.php');

    }

    public function extensions_page(){

        require_once('admin-extensions-page.php');

    }

    public function system_page(){
        require_once('admin-status-page.php');
    }

    public function display_options_page(){
        require_once('display-options.php');
    }


    /**
     * Let to Number
     *
     * @return void
     */
    public function let_to_num( $v ) {
        $l   = substr( $v, -1 );
        $ret = substr( $v, 0, -1 );
        switch ( strtoupper( $l ) ) {
        case 'P':$ret *= 1024;
        case 'T':$ret *= 1024;
        case 'G':$ret *= 1024;
        case 'M':$ret *= 1024;
        case 'K':$ret *= 1024;
            break;
        }

        return $ret;
    }

    /**
     * Memory Limit
     *
     * @return void
     */
    public function memory_limit() {
        $limit = $this->let_to_num( WP_MEMORY_LIMIT );
        if ( function_exists( 'memory_get_usage' ) ) {
            $limit = max( $limit, $this->let_to_num( @ini_get( 'memory_limit' ) ) );
        }

        return $limit;
    }

    public function dashboard_tabs() {
    ?>
        <div class="tcg-admin-header">
            <div class="init-page-title">
                <h2><?php printf(__('Welcome to %s', 'themescamp-core'), ucfirst(get_option('tcg_theme_name'))); ?></h2>
                <p><?php printf(__('Thank you for installing %s Theme! Everything in the theme is streamlined to make your website building experience as simple and intuitive as possible. We hope you\'ll turn it into a powerful marketing asset that brings customers to your digital doorstep.', 'themescamp-core'), ucfirst(get_option('tcg_theme_name'))); ?></p>
            </div>

            <div class="tcg-admin-tabs"> 
                <ul>
                    <li class="dashboard-tab"><a href="<?php echo admin_url('admin.php?page=tcg_init'); ?>"><?php _e('Dashboard', 'themescamp-core'); ?></a></li>
                    <?php if (!has_action('tcg_license')) { ?>
                        <li class="license-tab"><a href="<?php echo admin_url('admin.php?page=registration'); ?>"><?php _e('License', 'themescamp-core'); ?></a></li>
                    <?php }?>
                     
                    <?php if (get_option('tcg_theme_status')=='active' || get_option('tcg_theme_dev_mod')){?>
                        <li class="plugins-tab"><a href="<?php echo esc_url_raw(admin_url('admin.php?page=tgmpa-install-plugins')); ?>"><?php _e('Plugins', 'themescamp-core'); ?></a></li>

                        <li class="import-tab"><a href="<?php echo admin_url('admin.php?page=one-click-demo-import'); ?>"><?php _e('Import Demos', 'themescamp-core'); ?></a></li>
                        <li class="system-tab"><a href="<?php echo admin_url('admin.php?page=system-settings-page'); ?>"><?php _e('System status', 'themescamp-core'); ?></a></li>
                        <li class="extensions-tab"><a href="<?php echo admin_url('admin.php?page=tcg_extensions'); ?>"><?php _e('Extensions', 'themescamp-core'); ?></a></li>
                        <?php }?>
                        <li class="options-tab"><a href="<?php echo admin_url('admin.php?page=tcg_theme_settings'); ?>"><?php _e('Theme Options', 'themescamp-core'); ?></a></li>
                        <li class="builder-tab"><a href="<?php echo admin_url('edit.php?post_type=tcg_teb'); ?>"><?php _e('Theme Builder', 'themescamp-core'); ?></a></li>
                    
                    <!-- <li class="customize-tab"><a href="<?php //echo admin_url('customize.php'); ?>">Live Customizer</a></li> -->
                    
                    <!-- <li class="options-tab"><a href="<?php //echo esc_url( self::get_site_settings_link() ) ; ?>">Site settings</a></li> -->
                     
                </ul>
            </div>
        </div>
    <?php
    }

    public static function get_site_settings_link() { 
        $kit_id = get_option( 'elementor_active_kit' );
        $site_settings_url = '';

        if ( $kit_id ) {
            $site_settings_url = \Elementor\Plugin::$instance->documents->get( $kit_id )->get_edit_url();
        }

        return $site_settings_url;
    }

}
Themescamp_Admin_Panel::instance()->initialize();