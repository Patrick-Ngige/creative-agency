<?php
namespace infolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
include_once('menu-walker.php');

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/**
 * @since 1.1.0
 */
class infolio_Menu extends Widget_Base {

    /**
     * Retrieve the widget name.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'infolio-menu';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'infolio Menu', 'infolio_plg' );
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-nav-menu';
    }
    public function get_script_depends() {
        return ['infolio-menu'];
    }
    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'infolio-menu-elements' ];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Menu to Display', 'infolio_plg' ),
            ]
        );

        $menus =infolio_navmenu_navbar_menu_choices();
        if ( ! empty( $menus ) ) {
            $this->add_control(
                'infolio_menu',
                [
                    'label'   => __( 'Select Menu', 'infolio_plg' ),
                    'type'    => Controls_Manager::SELECT,
                    'options' => $menus,
                    'default' => array_keys( $menus )[0],
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<strong>' . __( 'There are no menus in your site.', 'infolio_plg' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'infolio_plg' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
                    'separator' => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
        $this->add_control(
            'menu',
            [
                'label' => __( 'Menu Options', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                        'default' => __( 'Default', 'infolio_plg' ),
                        'animation' => __( 'Rolling Text Animation', 'infolio_plg' ),
                        'navigation' => __( 'List', 'infolio_plg' ),
                ],
                'default' => 'default',
            ]
        );
        $this->add_control(
            'color',
            [
                'label' => __( 'Style', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'dark' => __( 'Dark', 'infolio_plg' ),
                    'light' => __( 'Light', 'infolio_plg' ),
                ],
                'default' => 'light',
                'condition'=>['menu'=>['default','animation']]
            ]
        );
        $this->end_controls_section();
//        menu style
        $this->start_controls_section(
            'section_style_main-menu',
            [
                'label' => __( 'Main Menu', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'menu_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-menu .navbar .nav-link,{{WRAPPER}} .infolio-menu .menu-list  .navigation > .menu-item a',
            ]
        );
        $this->start_controls_tabs('tabs_menu_links_style');
        $this->start_controls_tab(
            'tab_menu_normal',
            [
                'label' => esc_html__('Normal', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'menu_color',
            [
                'label' => __('Main Menu Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar .nav-link' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-menu .menu-list  .navigation > .menu-item a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_menu_hover',
            [
                'label' => esc_html__('Hover', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'menu_color_hover',
            [
                'label' => esc_html__( 'Main Menu Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar-nav .nav-link:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-menu .menu-list  .navigation > .menu-item a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-menu .navbar-nav .nav-link:focus' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tabs();
        $this->add_control(
            'separator_border',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );
        $this->add_responsive_control(
            'navbar_margin',
            [
                'label' => esc_html__('Navbar Menu Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'navbar_padding',
            [
                'label' => esc_html__('Navbar Menu Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'menu_item_navbar_margin',
            [
                'label' => esc_html__('Margin Menu Items', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar-nav .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-menu .menu-list  .navigation > .menu-item a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'menu_item_navbar_padding',
            [
                'label' => esc_html__('Padding Menu Items', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar-nav .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-menu .menu-list  .navigation > .menu-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'toggler_margin',
            [
                'label' => esc_html__('Navbar Toggler Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar-toggler' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style_drop',
            [
                'label' => __( 'Drop Down Items', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'drop_down_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-menu .navbar-nav .dropdown-menu .dropdown-item,{{WRAPPER}} .infolio-menu .menu-list  .navigation .infolio-nav-item .menu-item a',
            ]
        );
        $this->add_control(
            'drop_down_color',
            [
                'label' => __('Drop Down Items Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar-nav .dropdown-menu .dropdown-item' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-menu .menu-list  .navigation .infolio-nav-item .menu-item a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_dropdown_color',
            [
                'label' => __('Background Drop Down Items Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar-nav .dropdown-menu .dropdown-item' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-menu .menu-list  .navigation .infolio-nav-item .menu-item a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'drop_items_padding',
            [
                'label' => esc_html__('Drop Down Items Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar-nav .dropdown-menu .dropdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-menu .menu-list  .navigation .infolio-nav-item .menu-item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'drop_margin',
            [
                'label' => esc_html__('Drop Down Items Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-menu .navbar-nav .dropdown-menu .dropdown-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-menu .menu-list .navigation .infolio-nav-item .menu-item a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings();
        $selected_menu = isset($settings['infolio_menu']) ? $settings['infolio_menu'] : '';
        $animation='';
        $id=uniqid('navbar-');
        $menu_class="navbar-nav ".$settings['menu'];
        $walker = class_exists('Infolio_Walker_Nav') ? new \Infolio_Walker_Nav() : ''; // Check if class is exists
        if (!empty($selected_menu)) {
            $menu_args = array(
                'menu' => $selected_menu,
                'menu_class' => $menu_class,
                'echo' => false,
//                'fallback_cb' => 'Winfolio_Menu_Navwalker::fallback',
                'walker' => $walker

            );
            $menu_html = wp_nav_menu($menu_args);
            ?>
            <div class="infolio-menu">
                <?php if ($settings['menu']=='navigation') : ?>
                    <div class='menu-list'>
                        <?=$menu_html?>
                    </div>
                <?php else:?>
                <div class='navbar navbar-<?=esc_attr($settings['menu'])?> navbar-expand-lg default'>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#<?=esc_attr($id)?>" aria-controls="<?=esc_attr($id)?>" aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="icon-bar"><i class="fas fa-bars"></i></span>
                    </button>
                    <div class="collapse navbar-collapse" id="<?=esc_attr($id)?>">
                        <?=$menu_html?>
                    </div>
                </div>
            <?php endif;?>
            </div>
            <?php
        }
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $item_html = $is_fullwidth = $badge_color = '';

        if (!isset($args->link_before)) {
            return;
        }

        $args->link_before = '';

        if (!empty($item->themescamp_megaprofile)) {
            // Check if the menu item is a mega menu
            $is_mega_menu = $this->is_mega_menu_item($item);

            if ($is_mega_menu) {
                // Handle mega menu item differently
                $item_html .= $this->get_megamenu($item->themescamp_megaprofile);
            } else {
                // Handle regular menu item
                parent::start_el($item_html, $item, $depth, $args, $id);
            }
        }

        $output .= $item_html;
    }

    function is_mega_menu_item($item) {
        // Adjust this condition based on how you identify mega menu items (using a class, property, etc.)
        return in_array('mega-menu-item', $item->classes);
    }


    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function content_template() {

    }
}


