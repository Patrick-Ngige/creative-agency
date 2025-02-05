<?php

namespace infolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\repeater;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;
use Elementor\Group_Control_Text_Shadow;


if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.1.0 
 */
class infolio_Icon_List extends Widget_Base
{

	/**
	 * Get widget name.
	 *
	 * Retrieve icon list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'infolio-icon-list';
	}

	//script depend
	public function get_script_depends()
	{
		return ['infolio-icon-list'];
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve icon list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return esc_html__('infolio Icon List', 'infolio_plg');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve icon list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-bullet-list';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['infolio-elements'];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords()
	{
		return ['icon list', 'icon', 'list'];
	}

	/**
	 * Register icon list widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls()
	{
		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__('Icon List', 'infolio_plg'),
			]
		);
        $this->add_control(
            'line_hover_animation',
            [
                'label' => esc_html__('Hover Animation (Line Before)', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'infolio_plg'),
                'label_on' => esc_html__('On', 'infolio_plg'),
                'default' => 'no',
                'return_value' => 'yes'
            ]
        );

		$this->add_control(
			'view',
			[
				'label' => esc_html__('Layout', 'infolio_plg'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'traditional',
				'options' => [
					'traditional' => [
						'title' => esc_html__('Default', 'infolio_plg'),
						'icon' => 'eicon-editor-list-ul',
					],
					'inline' => [
						'title' => esc_html__('Inline', 'infolio_plg'),
						'icon' => 'eicon-ellipsis-h',
					],
				],
				'render_type' => 'template',
				'classes' => 'elementor-control-start-end',
				'style_transfer' => true,
				'prefix_class' => 'elementor-icon-list--layout-',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__('Text', 'infolio_plg'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__('List Item', 'infolio_plg'),
				'default' => esc_html__('List Item', 'infolio_plg'),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			[
				'label' => esc_html__('Icon', 'infolio_plg'),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'fa4compatibility' => 'icon',
			]
		);

		$repeater->add_control(
			'icon_class',
			[
				'label' => __('Icon Class', 'infolio_plg'),
				'type' => Controls_Manager::TEXT
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__('Link', 'infolio_plg'),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__('https://your-link.com', 'infolio_plg'),
			]
		);

		$this->add_control(
			'icon_list',
			[
				'label' => esc_html__('Items', 'infolio_plg'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => esc_html__('List Item #1', 'infolio_plg'),
						'selected_icon' => [
							'value' => 'fas fa-check',
							'library' => 'fa-solid',
						],
					],
					[
						'text' => esc_html__('List Item #2', 'infolio_plg'),
						'selected_icon' => [
							'value' => 'fas fa-times',
							'library' => 'fa-solid',
						],
					],
					[
						'text' => esc_html__('List Item #3', 'infolio_plg'),
						'selected_icon' => [
							'value' => 'fas fa-dot-circle',
							'library' => 'fa-solid',
						],
					],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->add_control(
			'link_click',
			[
				'label' => esc_html__('Apply Link On', 'infolio_plg'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'full_width' => esc_html__('Full Width', 'infolio_plg'),
					'inline' => esc_html__('Inline', 'infolio_plg'),
				],
				'default' => 'full_width',
				'separator' => 'before',
				'prefix_class' => 'elementor-list-item-link-',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_list',
			[
				'label' => esc_html__('List', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label' => esc_html__('Space Between', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body.rtl {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body:not(.rtl) {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
				],
			]
		);

		$this->add_responsive_control(
			'icon_align',
			[
				'label' => esc_html__('Alignment', 'infolio_plg'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'infolio_plg'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'infolio_plg'),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'infolio_plg'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'selectors' => [
					'{{WRAPPER}} .infolio-icon-list .elementor-icon-list-items' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'divider',
			[
				'label' => esc_html__('Divider', 'infolio_plg'),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__('Off', 'infolio_plg'),
				'label_on' => esc_html__('On', 'infolio_plg'),
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'content: ""',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label' => esc_html__('Style', 'infolio_plg'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'solid' => esc_html__('Solid', 'infolio_plg'),
					'double' => esc_html__('Double', 'infolio_plg'),
					'dotted' => esc_html__('Dotted', 'infolio_plg'),
					'dashed' => esc_html__('Dashed', 'infolio_plg'),
				],
				'default' => 'solid',
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-style: {{VALUE}}',
					'{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-style: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'divider_weight',
			[
				'label' => esc_html__('Weight', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child):after' => 'border-top-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label' => esc_html__('Width', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'condition' => [
					'divider' => 'yes',
					'view!' => 'inline',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_height',
			[
				'label' => esc_html__('Height', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%', 'px'],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'divider' => 'yes',
					'view' => 'inline',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => esc_html__('Color', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ddd',
				'condition' => [
					'divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__('Icon', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'with_back',
			[
				'label' => esc_html__('With Background', 'infolio_plg'),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => esc_html__('Off', 'infolio_plg'),
				'label_on' => esc_html__('On', 'infolio_plg'),
				'default' => 'no',
				'return_value' => 'yes'
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__('Height', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-icon-list .icon-background' => 'height: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'with_back' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__('Width', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-icon-list .icon-background' => 'width: {{SIZE}}{{UNIT}}'
				],
				'condition' => [
					'with_back' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__('Border Radius', 'infolio_plg'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .infolio-icon-list .icon-background' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'with_back' => 'yes'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .infolio-icon-list .icon-background',
				'condition' => [
					'with_back' => 'yes'
				],
			]
		);
        $this->add_control(
            'border_dark_mode',
            [
                'label' => esc_html__( 'Border Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'with_back' => 'yes'
                ],
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-icon-list .icon-background' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-icon-list .icon-background' => 'border-color: {{VALUE}};',
                ],
                'separator' => 'after'
            ]
        );
		$this->start_controls_tabs('icon_tabs');
		$this->start_controls_tab(
			'normal',
			[
				'label' => __('Normal', 'infolio_plg')
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__('Color', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .elementor-icon-list-icon svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_color_dark_mode',
			[
				'label' => esc_html__( 'Color (Dark Mode)', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .elementor-icon-list-icon i' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .elementor-icon-list-icon i' => 'color: {{VALUE}};',
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .elementor-icon-list-icon svg path' => 'fill: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .elementor-icon-list-icon svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_background',
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .infolio-icon-list .icon-background',
				'condition' => [
					'with_back' => 'yes'
				]
			]
		);
        $this->add_control(
            'icon_background_dark',
            [
                'label' => esc_html__('Background Color (Dark Mode)', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'with_back' => 'yes'
                ],
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-icon-list .icon-background' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-icon-list .icon-background' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => __('Hover', 'infolio_plg')
			]
		);

		$this->add_control(
			'transition',
			[
				'label' => __('Transition ( S )', 'infolio_plg'),
				'type' => Controls_Manager::NUMBER,
				'step' => '0.1',
				'default' => '0.3',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item .elementor-icon-list-icon i' => 'transition : all {{VALUE}}s ease',
					'{{WRAPPER}} .elementor-icon-list-item .elementor-icon-list-icon svg path' => 'transition : all {{VALUE}}s ease',
					'{{WRAPPER}} .infolio-icon-list .icon-background' => 'transition : all {{VALUE}}s ease'
				]
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__('Hover', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon svg path' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_background_hover',
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .elementor-icon-list-item:hover .icon-background',
				'condition' => [
					'with_back' => 'yes'
				]
			]
		);

        $this->add_control(
            'icon_background_dark_hover',
            [
                'label' => esc_html__('Background Color (Dark Mode)', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-icon-list:hover .icon-background' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-icon-list:hover .icon-background' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__('Size', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 6,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--e-icon-list-icon-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-icon-list-item .elementor-icon-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-icon-list-item .elementor-icon-list-icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$e_icon_list_icon_css_var = 'var(--e-icon-list-icon-size, 1em)';
		$e_icon_list_icon_align_left = sprintf('0 calc(%s * 0.25) 0 0', $e_icon_list_icon_css_var);
		$e_icon_list_icon_align_center = sprintf('0 calc(%s * 0.125)', $e_icon_list_icon_css_var);
		$e_icon_list_icon_align_right = sprintf('0 0 0 calc(%s * 0.25)', $e_icon_list_icon_css_var);

		$this->add_responsive_control(
			'icon_self_align',
			[
				'label' => esc_html__('Alignment', 'infolio_plg'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'infolio_plg'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'infolio_plg'),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'infolio_plg'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => '',
				'selectors_dictionary' => [
					'left' => sprintf('--e-icon-list-icon-align: left; --e-icon-list-icon-margin: %s;', $e_icon_list_icon_align_left),
					'center' => sprintf('--e-icon-list-icon-align: center; --e-icon-list-icon-margin: %s;', $e_icon_list_icon_align_center),
					'right' => sprintf('--e-icon-list-icon-align: right; --e-icon-list-icon-margin: %s;', $e_icon_list_icon_align_right),
				],
				'selectors' => [
					'{{WRAPPER}}' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__('Text', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('text_tabs');
		$this->start_controls_tab(
			'normal_text',
			[
				'label' => __('Normal', 'infolio_plg')
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography',
				'selector' => '{{WRAPPER}} .elementor-icon-list-item > .elementor-icon-list-text, {{WRAPPER}} .elementor-icon-list-item > a',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__('Text Color', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item > .elementor-icon-list-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-icon-list-item > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color_dark_mode',
			[
				'label' => esc_html__('Text Color (Dark Mode)', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-icon-list .elementor-icon-list-item > .elementor-icon-list-text' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .infolio-icon-list .elementor-icon-list-item > .elementor-icon-list-text' => 'color: {{VALUE}};',
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-icon-list .elementor-icon-list-item > a' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .infolio-icon-list .elementor-icon-list-item > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover_text',
			[
				'label' => __('Hover', 'infolio_plg')
			]
		);
		$this->add_control(
			'transition_text',
			[
				'label' => __('Transition ( S )', 'infolio_plg'),
				'type' => Controls_Manager::NUMBER,
				'step' => '0.1',
				'default' => '0.3',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item .elementor-icon-list-text' => 'transition : all {{VALUE}}s ease',
				]
			]
		);
		$this->add_control(
			'text_color_hover',
			[
				'label' => esc_html__('Hover', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-icon-list-item:hover > a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'icon_typography_hover',
				'selector' => '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'text_indent',
			[
				'label' => esc_html__('Text Indent', 'infolio_plg'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .elementor-icon-list-text',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();
		$fallback_defaults = [
			'fa fa-check',
			'fa fa-times',
			'fa fa-dot-circle-o',
		];
		$background = 'yes' == $settings['with_back'] ? ' icon-background' : '';
//        line_hover_animation
        $line_hover_text = 'yes' == $settings['line_hover_animation'] ? ' line-hover-anim' : '';

		$this->add_render_attribute('icon_list', 'class', 'elementor-icon-list-items');
		if ('inline' === $settings['view']) {
			$this->add_render_attribute('icon_list', 'class', 'elementor-inline-items');
		}
        $this->add_render_attribute('list_item', 'class', 'elementor-icon-list-item' . $line_hover_text);
?>
		<div class="infolio-icon-list">
			<ul <?php $this->print_render_attribute_string('icon_list'); ?>>
				<?php
				foreach ($settings['icon_list'] as $index => $item) :
					$repeater_setting_key = $this->get_repeater_setting_key('text', 'icon_list', $index);
					$this->add_inline_editing_attributes($repeater_setting_key);
					$migration_allowed = Icons_Manager::is_migration_allowed();
				?>
					<li <?php $this->print_render_attribute_string('list_item'); ?>>
						<?php
						if (!empty($item['link']['url'])) {
							$link_key = 'link_' . $index;

							$this->add_link_attributes($link_key, $item['link']);
						?>
							<a <?php $this->print_render_attribute_string($link_key); ?>>

							<?php
						}

						// add old default
						if (!isset($item['icon']) && !$migration_allowed) {
							$item['icon'] = isset($fallback_defaults[$index]) ? $fallback_defaults[$index] : 'fa fa-check';
						}

						$migrated = isset($item['__fa4_migrated']['selected_icon']);
						$is_new = !isset($item['icon']) && $migration_allowed;
						if (!empty($item['icon']) ||  !empty($item['icon_class']) || (!empty($item['selected_icon']['value']) && $is_new)) :
							?>
								<span class="elementor-icon-list-icon<?php echo $background; ?>">
									<?php
									if (!empty($item['icon_class'])) : ?>
										<i class="<?php echo esc_attr($item['icon_class']); ?>"></i>
										<?php else :
										if ($is_new || $migrated) {
											Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']);
										} else { ?>
											<i class="<?php echo esc_attr($item['icon']); ?>" aria-hidden="true"></i>
									<?php }
									endif;
									?>
								</span>
							<?php endif; ?>
							<span class="elementor-icon-list-text" <?php $this->print_render_attribute_string($repeater_setting_key); ?>><?php $this->print_unescaped_setting('text', 'icon_list', $index); ?></span>
							<?php if (!empty($item['link']['url'])) : ?>
							</a>
						<?php endif; ?>
					</li>
				<?php
				endforeach;
				?>
			</ul>
		</div>
<?php
	}

	/**
	 * Render icon list widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template()
	{
	}

	public function on_import($element)
	{
		return Icons_Manager::on_import_migration($element, 'icon', 'selected_icon', true);
	}
}
