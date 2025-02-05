<?php
namespace ThemescampPlugin\Elementor\Elements\Widgets;


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


		
/**
 * @since 1.1.0
 */
class TCG_Nav_Menu extends Widget_Base {

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
		return 'tcg-nav-menu';
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
		return __( 'TC Menu', 'themescamp-core' );
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
		return 'fa fa-th-large';
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
		return [ 'themescamp-elements' ];
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
	protected function register_controls() {
	
		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Menu to Display', 'themescamp-core' ),
			]
		);

		$menus =themescamp_navmenu_navbar_menu_choices();
		if ( ! empty( $menus ) ) {
			$this->add_control(
				'tcg_menu',
				[
					'label'   => __( 'Select Menu', 'themescamp-core' ),
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
					'raw' => '<strong>' . __( 'There are no menus in your site.', 'themescamp-core' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'themescamp-core' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}
		
		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'themescamp-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => __( 'Horizontal', 'themescamp-core' ),
					'vertical' => __( 'Vertical', 'themescamp-core' ),
					'dropdown' => __( 'Dropdown', 'themescamp-core' ),
				],
				'frontend_available' => true,
			]
		);
		$this->add_control(
			'align_items',
			[
				'label' => __( 'Align', 'themescamp-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Left', 'themescamp-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'themescamp-core' ),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => __( 'Right', 'themescamp-core' ),
						'icon' => 'eicon-h-align-right',
					],
					'justify' => [
						'title' => __( 'Stretch', 'themescamp-core' ),
						'icon' => 'eicon-h-align-stretch',
					],
				],
				'prefix_class' => 'text-',
				'condition' => [
					'layout!' => 'dropdown',
				],
			]
		);
        
        $this->add_control(
			'hover_style',
			[
				'label' => __( 'Hover Style', 'themescamp-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => __( 'None', 'themescamp-core' ),
					'slide-up' => __( 'slide up', 'themescamp-core' ),
					'underline' => __( 'Underline', 'themescamp-core' ),
				],
				'default' => 'underline',
			]
		);
		
		$this->add_control(
			'menu_sticky',
			[
				'label' => __( 'Menu Sticky', 'themescamp-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'yes' => __( 'Yes', 'themescamp-core' ),
					'no' => __( 'No', 'themescamp-core' ),
				],
				'default' => 'yes',
			]
		);


		
		$this->add_control(
			'menu_type',
			[
				'label' => __( 'Drop Down Type', 'themescamp-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'left' => __( 'From Left', 'themescamp-core' ),
					'right' => __( 'From Right', 'themescamp-core' ),
				],
				'default' => 'left',
			]
		);

		
		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Parent Menu Align', 'themescamp-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'themescamp-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'themescamp-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'themescamp-core'),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .white-header, .custom-sticky' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'align_child',
			[
				'label' => __( 'Child Menu Align', 'themescamp-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'themescamp-core' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'themescamp-core' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'themescamp-core'),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .menu-box ul li ul' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'desktop_menu',
			[
				'label' => __( 'Desktop Menu', 'themescamp-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'inline-block' => __( 'Show', 'themescamp-core' ),
					'none' => __( 'Hide', 'themescamp-core' ),
				],
				'default' => 'inline-block',
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} .menu-box' => 'display: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'mobile_menu',
			[
				'label' => __( 'Mobile Menu', 'themescamp-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'inline-block' => __( 'Show', 'themescamp-core' ),
					'none' => __( 'Hide', 'themescamp-core' ),
				],
				'default' => 'inline-block',
				'label_block' => true,
				'selectors' => [
					'{{WRAPPER}} .box-mobile' => 'display: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_sticky_bg',
			[
				'label' => __( 'Sticky Background', 'themescamp-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{WRAPPER}} .is-sticky .stuck-nav' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section(); 


		$this->start_controls_section(
			'section_style_main-menu',
			[
				'label' => __( 'Main Menu', 'themescamp-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout!' => 'dropdown',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .tcg-nav .navigation li a',
			]
		);


		$this->start_controls_tabs( 'tabs_menu_item_style' );

		$this->start_controls_tab(
			'tab_menu_item_normal',
			[
				'label' => __( 'Normal', 'themescamp-core' ),
			]
		);

		$this->add_responsive_control(
			'padding_horizontal_menu_item',
			[
				'label' => __( 'Horizontal Padding', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li > a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'padding_vertical_menu_item',
			[
				'label' => __( 'Vertical Padding', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li > a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'margin_horizontal_menu_item',
			[
				'label' => __( 'Horizontal Margin', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'margin_vertical_menu_item',
			[
				'label' => __( 'Vertical Margin', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_space_between',
			[
				'label' => __( 'Space Between', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .elementor-nav-menu--layout-horizontal .elementor-nav-menu > li:not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-nav-menu--main:not(.elementor-nav-menu--layout-horizontal) .elementor-nav-menu > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'menu_dropdown_arrow_size',
			[
				'label' => __( 'Dropdown Arrow Size', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li a::after' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'menu_color',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tcg-nav .navigation > li a::after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_arrow_color',
			[
				'label' => __('Arrow Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li a::after' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tcg-nav .pages_links li a::after' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'menu_item_normal_dark_mode',
			[
				'label' => esc_html__( 'Dark Mode', 'themescamp-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'menu_color_dark_mode',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
                'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-nav .navigation > li a' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .tcg-nav .navigation > li a' => 'color: {{VALUE}};',
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-nav .navigation > li a::after' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .tcg-nav .navigation > li a::after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_arrow_color_dark_mode',
			[
				'label' => __('Arrow Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
                'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-nav .navigation > li a::after' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .tcg-nav .navigation > li a::after' => 'color: {{VALUE}};',
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-nav .pages_links li a::after' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .tcg-nav .pages_links li a::after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_border',
				'selector' => '{{WRAPPER}} .tcg-nav .navigation > li',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'menu_border_radius',
			[
				'label' => esc_html__('Border Radius', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_margin',
			[
				'label' => esc_html__('Item Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'menu_padding',
			[
				'label' => esc_html__('Item Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => __( 'Hover', 'themescamp-core' ),
			]
		);

		$this->add_responsive_control(
			'padding_underline_menu_item',
			[
				'label' => __( 'Underline position (px)', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .navigation > li.sfHover > a:before' => 'bottom: {{SIZE}}{{UNIT}};',
				],
			]
		); 

		$this->add_control(
			'menu_hover_opacity',
			[
				'label' => __( 'Opacity', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'step' => 0.1,
						'max' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li a:hover' => 'opacity: {{SIZE}};',
				],
			]
		); 

		$this->add_control(
			'menu_color_hover',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_arrow_color_hover',
			[
				'label' => __('Arrow Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li a:hover::after' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tcg-nav .pages_links li a:hover::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'menu_background_hover',
			[
				'label' => __('Background', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_border_hover',
				'selector' => '{{WRAPPER}} .tcg-nav .navigation > li:hover',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'menu_border_radius_hover',
			[
				'label' => esc_html__('Border Radius', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_active',
			[
				'label' => __( 'Active', 'themescamp-core' ),
			]
		);

		$this->add_control(
			'menu_background',
			[
				'label' => __('Background', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li.current-menu-item' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'menu_border_active',
				'selector' => '{{WRAPPER}} .tcg-nav .navigation > li.current-menu-item',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'menu_border_radius_active',
			[
				'label' => esc_html__('Border Radius', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .navigation > li.current-menu-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		
		

		$this->end_controls_section(); 

		$this->start_controls_section(
			'section_style_submain-menu',
			[
				'label' => __( 'Main Sub-Menu', 'themescamp-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout!' => 'dropdown',
				],

			]
		);


		$this->start_controls_tabs( 'tabs_submenu_item_style' );

		$this->start_controls_tab(
			'tab_submenu_item_normal',
			[
				'label' => __( 'Normal', 'themescamp-core' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'submenu_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .tcg-nav .menu-wrapper ul li ul li a',
			]
		);

		$this->add_control(
			'submenu_color',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .menu-wrapper ul li ul li a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .tcg-nav .menu-wrapper ul li ul li a::after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submenu_background',
			[
				'label' => __('Background', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
                'selectors' => [
					'{{WRAPPER}} .tcg-nav .menu-wrapper ul li ul.sub-menu' => 'background: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'submenu_item_normal_dark_mode',
			[
				'label' => esc_html__( 'Dark Mode', 'themescamp-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'submenu_color_dark_mode',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
                'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-nav .menu-wrapper ul li ul li a' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .tcg-nav .menu-wrapper ul li ul li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submenu_background_dark_mode',
			[
				'label' => __('Background', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
                'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-nav .menu-wrapper ul li ul.sub-menu' => 'background: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .tcg-nav .menu-wrapper ul li ul.sub-menu' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_submenu_item_hover',
			[
				'label' => __( 'Hover', 'themescamp-core' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'submenu_hover_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .tcg-nav .menu-wrapper ul li ul li a:hover',
			]
		);

		$this->add_control(
			'submenu_color_hover',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .menu-wrapper ul li ul li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'padding_vertical_submenu_item',
			[
				'label' => __( 'Top Position (px)', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 150,
					],
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .tcg-nav .menu-wrapper ul li ul' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		); 
        $this->add_control(
			'boxes_border_radius',
			[
				'label' => __('Border Radius', 'themescamp-core'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .menu-wrapper ul li ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->end_controls_section(); 

		$this->start_controls_section(
			'section_style_mobile-menu',
			[
				'label' => __( 'Mobile Menu', 'themescamp-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout!' => 'dropdown',
				],

			]
		);

		$this->add_control(
			'mobile_menu_color',
			[
				'label' => __('Mobile Icon Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .hamburger:not(.active) .hamburger__icon, {{WRAPPER}} .hamburger__icon:before, {{WRAPPER}} .hamburger__icon:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_menu_color_active',
			[
				'label' => __('Mobile Icon Active Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .hamburger.active .hamburger__icon:before, {{WRAPPER}} .hamburger.active .hamburger__icon:after' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .hamburger.active .hamburger__icon' => 'background-color: transparent;',
				],
			]
		);

        $this->add_control(
			'mobile_menu_dark_mode',
			[
				'label' => esc_html__( 'Dark Mode', 'themescamp-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mobile_menu_color_dark_mode',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
                'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .hamburger__icon' => 'background-color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .hamburger__icon' => 'background-color: {{VALUE}};',
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .hamburger__icon:before' => 'background-color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .hamburger__icon:before' => 'background-color: {{VALUE}};',
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .hamburger__icon:after' => 'background-color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .hamburger__icon:after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mobile_menu_color_active_dark_mode',
			[
				'label' => __('Background', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
                'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .hamburger.active .hamburger__icon:before' => 'background-color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .hamburger.active .hamburger__icon:before' => 'background-color: {{VALUE}};',
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .hamburger.active .hamburger__icon:after' => 'background-color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .hamburger.active .hamburger__icon:after' => 'background-color: {{VALUE}};',
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .hamburger.active .hamburger__icon' => 'background-color: transparent;',
					'} body.tcg-dark-mode {{WRAPPER}} .hamburger.active .hamburger__icon' => 'background-color: transparent;',
				],
			]
		);

		$this->add_control(
			'padding_top_mobile_menu',
			[
				'label' => __( 'Top position', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .fat-nav' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);	

		$this->add_control(
			'mobile_menu_wrapper',
			[
				'label' => esc_html__('Wrapper Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .fat-nav__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'section_style_mega-menu',
			[
				'label' => __( 'Mega Menu', 'themescamp-core' ),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_responsive_control(
			'mega_menu_width',
			[
				'label' => esc_html__( 'Width', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'vw',
                    'size' => 80
				],
				'tablet_default' => [
					'unit' => 'vw',
                    'size' => 80
				],
				'mobile_default' => [
					'unit' => 'vw',
                    'size' => 99
				],
				'size_units' => [ 'vw', 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => 310,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-mega-nav-item ' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'mega_menu_alignment',
			[
				'label' => esc_html__( 'Alignment', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'vw',
                    'size' => 10
				],
				'tablet_default' => [
					'unit' => 'vw',
                    'size' => 10
				],
				'mobile_default' => [
					'unit' => 'vw',
                    'size' => -3
				],
				'size_units' => [ 'vw', 'px', '%', 'custom' ],
				'range' => [
					'px' => [
						'min' => -1000,
						'max' => 1000,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-mega-nav-item ' => 'left: {{SIZE}}{{UNIT}};',
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
	protected function render() {
		$settings = $this->get_settings();


		if (isset($settings['tcg_menu']) ){

			$nav_menu = array( 'menu' => $settings['tcg_menu'],'echo' => true,'menu_id' => '','items_wrap' => '<ul id="%1$s" class="home-nav navigation %2$s">%3$s</ul>' );
		}else{
			return;
		}

		if($settings['hover_style'] != 'underline'){
			$nav_menu['menu_class'] = $settings['hover_style'];
		}
	?>
                        
	<div class="tcg-nav">

			<div class="main-menu menu-wrapper d-none d-md-block  <?php if ($settings['menu_type']=='right'){echo 'tcg-right-menu';} ?> ">
				<?php 
				if(!empty($settings['tcg_menu'])){
					wp_nav_menu( array_merge($nav_menu, array('walker' => new \Themescamp_Walker_Nav_Primary())) ); 
				}?>
			</div><!--/.menu-box -- hidden-xs hidden-sm-->
			<div class="mobile-wrapper d-block d-md-none"> <!-- hidden-lg hidden-md --> 
				<a href="#" class="hamburger"><div class="hamburger__icon"></div></a>
				<div class="fat-nav">
					<div class="fat-nav__wrapper">
						<?php 
						$menuParameters = array(
							'menu' => $settings['tcg_menu'],
							'container'       => true,
							'items_wrap'      => '<ul id="%1$s" class="mob-nav  %2$s">%3$s</ul>',
							'depth'           => 0,
							'walker' => new \Themescamp_Walker_Nav_Primary(),
						);
						?>
						<div class="fat-list"> <?php echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' ); ?></div>
					</div>
				</div>
			</div><!--/.box-mobile-->
		
    </div>                   
                            
     <?php
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


