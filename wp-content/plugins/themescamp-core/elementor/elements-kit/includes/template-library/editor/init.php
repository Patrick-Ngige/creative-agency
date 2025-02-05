<?php

namespace ElementKit\Includes\TemplateLibrary\Editor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly
class ElementKit_Template_Library_Editor_Init {

    private $dir;

    function __construct() {
        $this->dir = dirname(__FILE__) . '/';

        add_action('elementor/editor/before_enqueue_scripts', array($this, 'enqueue_scripts'), 1);

        // print views and tab variables on footer.
        add_action('elementor/editor/footer', array($this, 'admin_inline_js'));
        add_action('elementor/editor/footer', array($this, 'print_views'));

        // enqueue editor css.
        add_action('elementor/editor/after_enqueue_styles', array($this, 'editor_styles'));

        // enqueue modal's preview css.
        add_action('elementor/preview/enqueue_styles', array($this, 'preview_styles'));
    }

    public function enqueue_scripts() {

        wp_enqueue_script(
            'tc-template-library-editor-scripts',
            TCEK_URL . 'includes/template-library/editor/assets/js/editor-template-library.js',
            array('jquery', 'underscore', 'backbone-marionette'),
            TCEK_VER,
            true
        );
    }

    public function editor_styles() {
        $direction_suffix = is_rtl() ? '.rtl' : '';

        wp_enqueue_style(
            'tc-template-library-editor-style',
            TCEK_URL . 'includes/template-library/editor/assets/css/editor-template-library' . $direction_suffix . '.css',
            array(),
            TCEK_VER
        );
    }

    public function preview_styles() {

        $direction_suffix = is_rtl() ? '.rtl' : '';

        wp_enqueue_style(
            'tc-template-library-preview-style',
            TCEK_URL . 'includes/template-library/editor/assets/css/editor-template-preview' . $direction_suffix . '.css',
            array(),
            TCEK_VER
        );
    }

    public function admin_inline_js() { ?> 
        <script type="text/javascript">
            var ElementKitLibreryData = {
                "libraryButton": "Elements Button",
                "modalRegions": {
                    "modalHeader": ".dialog-header",
                    "modalContent": ".dialog-message"
                },
                "license": {
                    "activated": true,
                    "link": "https://google.com"
                },
                "tabs": {

                    "tcg_elementkit_all": {
                        "title": "All",
                        "data": [],
                        "settings": {
                            "show_title": false,
                            "show_keywords": true
                        }
                    },
                    "tcg_elementkit_block": {
                        "title": "Blocks",
                        "data": [],
                        "settings": {
                            "show_title": false,
                            "show_keywords": true
                        }
                    },
                    "tcg_elementkit_page": {
                        "title": "Pages",
                        "data": [],
                        "settings": {
                            "show_title": true,
                            "show_keywords": true
                        }
                    },
                    "tcg_elementkit_header": {
                        "title": "Header",
                        "data": [],
                        "settings": {
                            "show_title": false,
                            "show_keywords": true
                        }
                    },
                    "tcg_elementkit_footer": {
                        "title": "Footer",
                        "data": [],
                        "settings": {
                            "show_title": false,
                            "show_keywords": true
                        }
                    },
                    "tcg_elementkit_megamenu": {
                        "title": "MegaMenu",
                        "data": [],
                        "settings": {
                            "show_title": false,
                            "show_keywords": true
                        }
                    },
                   "tcg_elementkit_popup": {
                        "title": "Popup",
                        "data": [],
                        "settings": {
                            "show_title": false,
                            "show_keywords": true
                        }
                    },
                    "tcg_elementkit_single": {
                        "title": "Single",
                        "data": [],
                        "settings": {
                            "show_title": false,
                            "show_keywords": true
                        }
                    },
                    "tcg_elementkit_archive": {
                        "title": "Archive",
                        "data": [],
                        "settings": {
                            "show_title": false,
                            "show_keywords": true
                        }
                    },
                },
                "defaultTab": "tcg_elementkit_all",
                "new_demo_rang_date": "<?php echo date('Ymd', strtotime('-31 days')) ?>"
            };
        </script> <?php
                }
                public function print_views() {
                    foreach (glob($this->dir . 'views/editor/*.php') as $file) {
                        $name = basename($file, '.php');
                        ob_start();
                        include $file;
                        printf('<script type="text/html" id="view-tc-elementkit-%1$s">%2$s</script>', $name, ob_get_clean());
                    }
                }
            }

            new ElementKit_Template_Library_Editor_Init();
