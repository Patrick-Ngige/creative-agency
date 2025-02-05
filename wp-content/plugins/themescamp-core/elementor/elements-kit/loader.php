<?php

namespace ElementKit;

use Elementor\Plugin;
use Elementor\Core\Kits\Documents\Kit;


if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * Main class for element kit
 */
class Element_Kit_Loader {

    /**
     * @var Element_Kit_Loader
     */
    private static $_instance;

    /**
     * @return Element_Kit_Loader
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    private function _includes() {
        require_once(TCEK_INC_PATH . 'template-library/editor/init.php');
        require_once(TCEK_INC_PATH . 'template-library/template-library-base.php');
        require_once(TCEK_INC_PATH . 'template-library/editor/manager/api.php');
    }


    public function autoload($class) {
        if (0 !== strpos($class, __NAMESPACE__)) {
            return;
        }

        $class_to_load = $class;
        if (!class_exists($class_to_load)) {
            $filename = strtolower(
                preg_replace(
                    ['/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z0-9])/', '/_/', '/\\\/'],
                    ['', '$1-$2', '-', DIRECTORY_SEPARATOR],
                    $class_to_load
                )
            );

            $filename = TCEK_PATH . $filename . '.php';

            if (is_readable($filename)) {
                include($filename);
            }
        }
    }

    private function setup_hooks() { 
    }

    /**
     * Element_Kit_Loader constructor.
     */
    private function __construct() {
        // Register class automatically
        spl_autoload_register([$this, 'autoload']);
        // Include some backend files
        $this->_includes();
                // Finally hooked up all things here
        $this->setup_hooks();

    }
}

if (!defined('TCEK_TESTS')) {
    // In tests we run the instance manually.
    Element_Kit_Loader::instance();
}