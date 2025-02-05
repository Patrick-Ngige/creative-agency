<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Register new elementor widget. 
 */
class ThemesCampElements
{

    // Constructor
    public function __construct()
    {
        $this->add_actions();
    }

    //register all widgets & assets 
    public function add_actions()
    {

        //register all widgets & scripts
        add_action('elementor/widgets/register', [$this, 'on_widgets_registered']);


        //Admin Global called scripts
        function enqueue_glob_admin_scripts()
        {
            $js_dir = untrailingslashit(plugin_dir_path(__FILE__)) . '/elements/assets/js/global-admin/';
            $js_url = untrailingslashit(plugin_dir_url(__FILE__)) . '/elements/assets/js/global-admin/';
            foreach (glob($js_dir . '*.js') as $file) {
                $file_url = str_replace($js_dir, $js_url, $file);
                $handle = 'adg' . basename($file, '.js');
                wp_enqueue_script($handle, $file_url, array('jquery'), null, true);
            }
        }
        add_action('elementor/editor/after_enqueue_scripts', 'enqueue_glob_admin_scripts');


        //Front Global called scripts
        function enqueue_global_scripts()
        {
            $js_dir = untrailingslashit(plugin_dir_path(__FILE__)) . '/elements/assets/js/global-front/';
            $js_url = untrailingslashit(plugin_dir_url(__FILE__)) . '/elements/assets/js/global-front/';
            foreach (glob($js_dir . '*.js') as $file) {
                $file_url = str_replace($js_dir, $js_url, $file);
                $handle = basename($file, '.js');
                wp_enqueue_script($handle, $file_url, array('jquery'), null, true);
            }
        }
        add_action('elementor/frontend/after_enqueue_scripts', 'enqueue_global_scripts');

        //Front ELEMENTS Ready to call scripts
        add_action('elementor/frontend/after_register_scripts', function () {
            $js_dir = untrailingslashit(plugin_dir_path(__FILE__)) . '/elements/assets/js/tcg-depends/';
            $js_url = untrailingslashit(plugin_dir_url(__FILE__)) . '/elements/assets/js/tcg-depends/';
            foreach (glob($js_dir . '*.js') as $file) {
                $file_url = str_replace($js_dir, $js_url, $file);
                $handle = '' . basename($file, '.js');
                wp_register_script($handle, $file_url, array('jquery'), null, true);

                // Enqueue a specific file, e.g. "my-script.js"
                if ( $handle === 'container' ) {
                    wp_enqueue_script( $handle );
                }
            }
            wp_register_script('recaptcha', 'https://www.google.com/recaptcha/api.js', ['jquery'], null, true);
        });
    }

    //On Widgets Registered
    public function on_widgets_registered()
    {
        $this->includes();
        $this->register_widget();
    }

    //List of elements
    public function widgets()
    {
        $widgets_path    = dirname(__FILE__) . '/elements/widgets/';
        $tcgbase_widgets = array_diff(scandir($widgets_path), array('.', '..'));
        return $tcgbase_widgets;
    }

    //Includes
    private function includes()
    {
        foreach ($this->widgets() as $widget_name) {
            require_once(__DIR__ . '/elements/widgets/' . $widget_name . '/' . $widget_name . '.php');
        }
    }


    //Register Widget
    private function register_widget()
    {
        // Register Widgets
        foreach ($this->widgets() as $widget_name) {
            $widget_name__ = str_replace('-', '_', $widget_name);
            $class_name = str_replace('_', ' ', $widget_name__);
            $class_name     = ucwords(strtolower($class_name));
            $class_name = str_replace(' ', '_', $class_name);
            $class_name = 'ThemescampPlugin\Elementor\Elements\Widgets\TCG_' . $class_name;
            //$class_name='ThemescampPlugin\Elementor\Elements\Widgets\TCG_Button_Animate';
            \Elementor\Plugin::instance()->widgets_manager->register(new $class_name());
        }
    }
}

new ThemesCampElements();
