<?php

namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.0.0
 */
class TCG_Portfolio_Advanced extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'tc-portfolio-advanced';
    }

    public function get_script_depends()
    {
        return ['isotope.min', 'mason-gallery'];
    }


    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('TC Portfolio Advanced', 'themescamp-core');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'fa fa-clone';
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
        return ['themescamp-core'];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */

    protected function register_controls(){
        $this->start_controls_section(
            'settings',
            [
                'label' => __('Settings', 'themescamp-core'),

            ]
        );

        $this->add_control(
            'portfolio_item',
            [
                'label' => __('Item to display', 'themescamp-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => '8',
            ]
        );

        $this->add_control(
            'portfolio_offset',
            [
                'label' => esc_html__( 'Offset', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'default' => 0,
                'description' => esc_html__( 'Number of posts to skip.', 'themescamp-core' ),
            ]
        );

        $this->add_control(
            'meta_separator',
            [
                'label' => esc_html__( 'Categories Separator', 'themescamp-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => ', ',
            ]
        );
        
        $this->add_control(
			'columns_number',
			[
				'label' => __( 'Columns number', 'themescamp-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'12' => __( '1 Column', 'themescamp-core' ),
					'6' => __( '2 Columns', 'themescamp-core' ),
					'4' => __( '3 Columns', 'themescamp-core' ),
					'3' => __( '4 Columns', 'themescamp-core' ),
				],
				'default' => '6',
			]
		);

        $this->add_control(
            'port_order',
            [
                'label' => __('Orders', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'DESC' => __('Descending', 'themescamp-core'),
                    'ASC' => __('Ascending', 'themescamp-core'),
                    'rand' => __('Random', 'themescamp-core'),
                ],
                'default' => 'DESC',
            ]
        );

        $this->add_control(
            'sort_cat',
            [
                'label' => __('Sort Portfolio by Portfolio Category', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Yes', 'themescamp-core'),
                'label_off' => __('No', 'themescamp-core'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'blog_cat',
            [
                'label'   => __('Category to Show', 'themescamp-core'),
                'type'    => Controls_Manager::SELECT2, 'options' => themescamp_tax_choice(),
                'condition' => [
                    'sort_cat' => 'yes',
                ],
                'multiple'   => 'true',
            ]
        );

        $this->add_control(
			'sort_tag',
			[
				'label' => __('Sort post by Tags', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __('Yes', 'themescamp-core'),
				'label_off' => __('No', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);

        $this->add_control(
			'blog_tag',
			[
				'label'   => __('Tags', 'themescamp-core'),
				'type'    => Controls_Manager::SELECT, 'options' => themescamp_portfolio_tag_choice(),
				'condition' => [
					'sort_tag' => 'yes',
				],
				'multiple'   => 'true',
			]
		);

        $this->add_control(
            'show_filter',
            [
                'label' => __('Show filter', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'label_on' => __('On', 'themescamp-core'),
                'label_off' => __('Off', 'themescamp-core'),
                'default' => ''
            ]
        );

        $this->add_control(
            'masonry_style',
            [
                'label' => __('Metro Style', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'label_on' => __('On', 'themescamp-core'),
                'label_off' => __('Off', 'themescamp-core'),
                'default' => ''
            ]
        );

        $this->add_control(
            'masonry_col_style',
            [
                'label' => __('Masonry Style', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'label_on' => __('On', 'themescamp-core'),
                'label_off' => __('Off', 'themescamp-core'),
                'default' => ''
            ]
        );

        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__('Icon', 'themescamp-core'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin' => 'inline',
                'label_block' => false,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'card_styles',
            [
                'label' => __('Card Styles', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'portfolio_widget_padding',
            [
                'label' => esc_html__('Portfolio Widget Padding', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'gallery_margin',
            [
                'label' => esc_html__('Gallery Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gallery' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'card_overflow_options',
            [
                'label' => esc_html__('Card Overflow', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'themescamp-core'),
                    'hidden' => esc_html__('Hidden', 'themescamp-core'),
                    'visible' => esc_html__('Visible', 'themescamp-core'),
                ],
                'label_block' => true,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .item-img' => 'overflow: {{VALUE}};',
                ],

            ]
        );

        $this->add_responsive_control(
			'card_margin',
			[
				'label' => esc_html__('Card Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tcg-portfolio-adv .items' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'card_padding',
			[
				'label' => esc_html__('Card Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .tcg-portfolio-adv .items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

        $this->add_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'tcgbase_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .inner img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        

        $this->end_controls_section();

        $this->start_controls_section(
            'filter_styles',
            [
                'label' => __('Filter Styles', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'filter_box_border',
                'label' => __( 'Filter Border', 'themescamp-core' ),
                'selector' => '{{WRAPPER}} .tcg-portfolio-adv .filtering .filter',
            ]
        );

        $this->add_control(
            'filter_text_color',
            [
                'label' => esc_html__('Filter text Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .filtering span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'portfolio_title_styling',
            [
                'label' => __('Portfolio Info', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'info_display',
            [
                'label' => esc_html__('Info Display Type', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'inline-block',
                'options' => [
                    'block' => esc_html__('Block', 'themescamp-core'),
                    'inline-block' => esc_html__('Inline Block', 'themescamp-core'),
                    'flex' => esc_html__('Flex', 'themescamp-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'display: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'info_display_justify_content',
            [
                'label' => esc_html__( 'Justify Content', 'themescamp-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'default' => '',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start','themescamp-core' ),
                        'icon' => 'eicon-flex eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-justify-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__( 'Space Around', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__( 'Space Evenly', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-justify-space-evenly-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'justify-content: {{VALUE}};',
                ],
                'condition'=> ['info_display' => 'flex'],
                'responsive' => true,
            ]
        );

        $this->add_responsive_control(
            'info_display_align_items',
            [
                'label' => esc_html__( 'Align Items', 'themescamp-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => '',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'align-items: {{VALUE}};',
                ],
                'condition'=> ['info_display' => 'flex'],
                'responsive' => true,
            ]
        );
        $this->add_responsive_control(
            'info_display_flex_wrap',
            [
                'label' => esc_html__( 'Wrap', 'themescamp-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'nowrap' => [
                        'title' => esc_html__( 'No Wrap', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-nowrap',
                    ],
                    'wrap' => [
                        'title' => esc_html__( 'Wrap', 'themescamp-core' ),
                        'icon' => 'eicon-flex eicon-wrap',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'flex-wrap: {{VALUE}};',
                ],
                'condition'=> ['info_display' => 'flex'],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_info_bg',
                'label' => esc_html__('item info Background', 'themescamp-core'),
                'types' => [ 'classic', 'gradient'],
                'exclude' => ['image'],
                'selector' => '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' ,
            ]
        );

        $this->add_responsive_control(
            'info_custom_opacity',
            [
                'label' => esc_html__( 'Opacity', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'info_custom_width',
            [
                'label' => __('Width Adjustment', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px','%','custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 240,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'info_custom_height',
            [
                'label' => __('Height Adjustment', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px','%','custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_info_padding', // Control name
            [
                'label' => __( 'Info Padding', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS, // Ensure the namespace is correct
                'size_units' => [ 'px', '%' ], // Array of allowed units
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'item_info_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'item_info_align',
			[
				'label' => __( 'Info Alignment', 'themescamp-core' ),
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
					'{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'text-align: {{VALUE}};',
				],
			]
		);
        $this->add_control(
            'info_outline',
            [
                'label' => esc_html__('Outline', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'themescamp-core'),
                'label_on' => esc_html__('Custom', 'themescamp-core'),
            ]
        );
        $this->start_popover();
        $this->add_control(
            'info_outline_type',
            [
                'label' => esc_html__('Border Type', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'themescamp-core'),
                    'none' => esc_html__('None', 'themescamp-core'),
                    'solid' => esc_html__('Solid', 'themescamp-core'),
                    'double' => esc_html__('Double', 'themescamp-core'),
                    'dotted' => esc_html__('Dotted', 'themescamp-core'),
                    'dashed' => esc_html__('Dashed', 'themescamp-core'),
                    'groove' => esc_html__('Groove', 'themescamp-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'outline-style: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'info_outline_width',
            [
                'label' => esc_html__('Bullet Width', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'condition' => [
                    'info_outline_type!' => ['', 'none'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'outline-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'info_outline_color',
            [
                'label' => esc_html__('Border Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'outline-color: {{VALUE}};',
                ],
                'condition' => [
                    'info_outline_type!' => ['', 'none'],
                ],
            ]
        );
        $this->add_responsive_control(
            'info_outline_offset',
            [
                'label' => esc_html__('Bullet Offset', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'condition' => [
                    'info_outline_type!' => ['', 'none'],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'outline-offset: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_popover();
        $this->add_control(
            'info_position_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $start = is_rtl() ? esc_html__('Right', 'themescamp-core') : esc_html__('Left', 'themescamp-core');
        $end = !is_rtl() ? esc_html__('Right', 'themescamp-core') : esc_html__('Left', 'themescamp-core');
        
        $this->add_control(
            'info_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'info_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                ],
                'condition' => [
                    'info_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'info_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                ],
                'condition' => [
                    'info_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'info_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'info_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                ],
                'condition' => [
                    'info_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'info_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                ],
                'condition' => [
                    'info_offset_orientation_v' => 'end',
                ],
            ]
        );

        $this->add_control(
            "info_transform_translate_popover",
            [
                'label' => esc_html__( 'Offset', 'themescamp-core' ),
                'type' => Controls_Manager::POPOVER_TOGGLE,
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            "info_transform_translateX_effect",
            [
                'label' => esc_html__( 'Offset X', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'condition' => [
                    "info_transform_translate_popover!" => '',
                ],
            ]
        );

        $this->add_responsive_control(
            "info_transform_translateY_effect",
            [
                'label' => esc_html__( 'Offset Y', 'themescamp-core' ),
                'description' => esc_html__( 'Do not leave Offset X empty set it to 0 to apply the style', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'condition' => [
                    "info_transform_translate_popover!" => '',
                ],
                'selectors' => [
                    "{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info" => 'transform: translate({{SIZE}}{{UNIT}}, {{info_transform_translateX_effect.SIZE}}{{info_transform_translateX_effect.UNIT}});',
                ],
            ]
        );

        $this->end_popover();

        $this->end_controls_section();
        $this->start_controls_section(
            'icon_style',
            [
                'label' => esc_html__('Icon Style', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'info_icon_position',
            [
                'label' => esc_html__('Position', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'unset' => esc_html__('unset', 'themescamp-core'),
                    'absolute' => esc_html__('absolute', 'themescamp-core'),
                    'relative' => esc_html__('relative', 'themescamp-core'),
                ],
                'label_block' => true,
                'default' => 'unset',
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => 'position: {{VALUE}};',
                ],
            ]
        );
        $start = is_rtl() ? esc_html__('Right', 'themescamp-core') : esc_html__('Left', 'themescamp-core');
        $end = !is_rtl() ? esc_html__('Right', 'themescamp-core') : esc_html__('Left', 'themescamp-core');

        $this->add_control(
            'info_icon_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
                'condition' => ['info_icon_position!' => 'unset']
            ]
        );

        $this->add_responsive_control(
            'info_icon_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                ],
                'condition' => [
                    'info_icon_offset_orientation_h!' => 'end',
                    'info_icon_position!' => 'unset'
                ],
            ]
        );

        $this->add_responsive_control(
            'info_icon_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                ],
                'condition' => [
                    'info_icon_offset_orientation_h' => 'end',
                    'info_icon_position!' => 'unset'
                ],
            ]
        );

        $this->add_control(
            'info_icon_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
                'condition' => ['info_icon_position!' => 'unset']
            ]
        );

        $this->add_responsive_control(
            'info_icon_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                ],
                'condition' => [
                    'info_icon_offset_orientation_v!' => 'end',
                    'info_icon_position!' => 'unset'
                ],
            ]
        );

        $this->add_responsive_control(
            'info_icon_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                ],
                'condition' => [
                    'info_icon_offset_orientation_v' => 'end',
                    'info_icon_position!' => 'unset'
                ],
            ]
        );
        $this->add_control(
            'info_icon_color',
            [
                'label' => __('Icon Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'info_icon_size',
            [
                'label' => __('Icon Size (px)', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info i' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'info_icon_margin',
            [
                'label' => esc_html__('Icon Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'info_icon_tabs',
        );
        
        $this->start_controls_tab(
            'info_icon_normal_tab',
            [
                'label'   => esc_html__( 'Normal', 'themescamp-core' ),
            ]
        );
        $this->add_control(
            'icon_transform_options',
            [
                'label' => esc_html__('Icon Transform', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'themescamp-core'),
                'label_on' => esc_html__('Custom', 'themescamp-core'),
            ]
        );
        $this->start_popover();
        $this->add_control(
            'icon_translate_y',
            [
                'label' => esc_html__( 'Icon Translate Y', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => '--e-transform-tcg-portfolio-adv-icon-translateY: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'icon_translate_x',
            [
                'label' => esc_html__( 'Icon Translate X', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => '--e-transform-tcg-portfolio-adv-icon-translateX: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();
        $this->end_controls_tab();
        $this->start_controls_tab(
            'info_icon_hover_tab',
            [
                'label'   => esc_html__( 'Hover', 'themescamp-core' ),
            ]
        );
        $this->add_control(
            'icon_transition',
            [
                'label' => esc_html__( 'Transition', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .icon' => 'transition: all {{SIZE}}s ease;',
                ],
            ]
        );
        $this->add_control(
            'icon_transform_options_hover',
            [
                'label' => esc_html__('Icon Transform', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'themescamp-core'),
                'label_on' => esc_html__('Custom', 'themescamp-core'),
            ]
        );
        $this->start_popover();
        $this->add_control(
            'icon_translate_y_hover',
            [
                'label' => esc_html__( 'Icon Translate Y', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img:hover .info .icon' => '--e-transform-tcg-portfolio-adv-icon-translateY: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'icon_translate_x_hover',
            [
                'label' => esc_html__( 'Icon Translate X', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img:hover .info .icon' => '--e-transform-tcg-portfolio-adv-icon-translateX: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_popover();
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title Style', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control(
            'title_white_space',
            [
                'label' => esc_html__('White Space', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Default', 'themescamp-elements'),
                    'normal' => esc_html__('Normal', 'themescamp-elements'),
                    'nowrap' => esc_html__('No Wrap', 'themescamp-elements'),
                    'break-spaces' => esc_html__('Break Spaces', 'themescamp-elements'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .title a' => 'white-space: {{VALUE}};'
                ]
            ]
        );
        $this->add_responsive_control(
            'title_break_line',
            [
                'label' => esc_html__('Break Line Tag Hidden', 'themescamp-elements'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'themescamp-elements'),
                'label_off' => esc_html__('No', 'themescamp-elements'),
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .title br' => 'display: none;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_title_typography',
                'selector' => '{{WRAPPER}} .tcg-portfolio-adv .title a',
            ]
        );
        $this->add_control(
            'item_title_color',
            [
                'label' => esc_html__('Title Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_title_margin',
            [
                'label' => esc_html__('Title Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'title_transform_options',
            [
                'label' => esc_html__('Title Transform', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'themescamp-core'),
                'label_on' => esc_html__('Custom', 'themescamp-core'),
            ]
        );
        $this->start_popover();
        $this->add_responsive_control(
            'title_translate_y',
            [
                'label' => esc_html__( 'Title Translate Y', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .title' => '--e-transform-tcg-portfolio-adv-title-translateY: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_translate_x',
            [
                'label' => esc_html__( 'Title Translate X', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .title' => '--e-transform-tcg-portfolio-adv-title-translateX: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_rotate',
            [
                'label' => esc_html__( 'Title Rotate', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg' ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .title' => '--e-transform-tcg-portfolio-adv-title-rotateZ: {{SIZE}}deg',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_transform_x',
            [
                'label' => esc_html__( 'Transform Origin X', 'themescamp-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'themescamp-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-core' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'themescamp-core' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .title' => '--e-transform-tcg-portfolio-adv-title-origin-x: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_transform_y',
            [
                'label' => esc_html__( 'Transform Origin Y', 'themescamp-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__( 'Top', 'themescamp-core' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-core' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__( 'Bottom', 'themescamp-core' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .info .title' => '--e-transform-tcg-portfolio-adv-title-origin-y: {{VALUE}}',
                ],
            ]
        );
        $this->end_popover();
        $this->end_controls_section();
        $this->start_controls_section(
            'portfolio_category_styling',
            [
                'label' => __('Portfolio Category', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'category_wrapper_style_options',
            [
                'label' => esc_html__('Category Wrapper Options', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control(
            'item_category_wrapper_display',
            [
                'label' => esc_html__('Display Type', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'block',
                'options' => [
                    'block' => esc_html__('Block', 'themescamp-core'),
                    'inline-block' => esc_html__('Inline Block', 'themescamp-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .tag' => 'display: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_category_wrapper_typography',
                'selector' => '{{WRAPPER}} .tcg-portfolio-adv .tag',
            ]
        );

        $this->add_control(
            'item_category_wrapper_color',
            [
                'label' => esc_html__('Category Wrapper Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .tag' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_category_wrapper_margin',
            [
                'label' => esc_html__('Category Wrapper Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .tag' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_category_wrapper_padding',
            [
                'label' => esc_html__('Category Wrapper Padding', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_category_wrapper_border_radius',
            [
                'label' => esc_html__('Category Wrapper Border Radius', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .tag' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'category_wrapper_background_color',
                'types' => [ 'classic', 'gradient', 'tcg_gradient' ],
                'selector' => '{{WRAPPER}} .tcg-portfolio-adv .tag',
            ]
        );
        $this->add_control(
            'category_item_style_options',
            [
                'label' => esc_html__('Category Link Item Options', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'item_category_color',
            [
                'label' => esc_html__('Category Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .tag a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_category_typography',
                'selector' => '{{WRAPPER}} .tcg-portfolio-adv .tag a',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'overlay_styling',
            [
                'label' => __('Overlay', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'overlay_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img:after',
                'exclude' => ['image']
            ]
        );

        $this->add_control(
            'overlay_blur_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'overlay_blur_method',
            [
                'label' => esc_html__('Background Blur Method', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'backdrop-filter' => 'backdrop-filter',
                    'filter' => 'filter',
                ],
                'default' => 'backdrop-filter',
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img:hover img' => '{{VALUE}}: blur({{overlay_background_blur.SIZE}}px);',
                ],
            ]
        );

        $this->add_control(
            'overlay_background_blur',
            [
                'label' => esc_html__('Background Blur', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 250,
                    ],
                ],
            ]
        );

        $this->add_control(
            'overlay_opacity_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->start_controls_tabs(
            'portfolio_advanced_overlay_tabs',
        );
        
        $this->start_controls_tab(
            'portfolio_advanced_overlay_normal_tab',
            [
                'label'   => esc_html__( 'Normal', 'themescamp-core' ),
            ]
        );
        $this->add_control(
            'overlay_opacity_normal',
            [
                'label' => esc_html__('Opacity', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img:after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'portfolio_advanced_overlay_hover_tab',
            [
                'label'   => esc_html__( 'Hover', 'themescamp-core' ),
            ]
        );
        $this->add_control(
            'overlay_opacity',
            [
                'label' => esc_html__('Opacity', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay:hover .item-img:after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__('Image Style', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'image_container_style_options',
            [
                'label' => esc_html__( 'Image Container Options', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control(
            'img_container_height',
            [
                'label' => esc_html__( 'Image Container Height', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units' => [ 'px', 'vh', '%', 'vw', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .inner' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'image_animations',
            [
                'label' => esc_html__('Animations', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Default', 'themescamp-core'),
                    'clippy-img wow' => esc_html__('Clippy Image', 'themescamp-core'),
                ],
            ]
        );
        $this->start_controls_tabs(
            'image_tabs',
        );
        
        $this->start_controls_tab(
            'image_normal_tab',
            [
                'label'   => esc_html__( 'Normal', 'themescamp-core' ),
            ]
        );
        $this->add_control(
            'image_transform_options',
            [
                'label' => esc_html__('Image Transform', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'themescamp-core'),
                'label_on' => esc_html__('Custom', 'themescamp-core'),
            ]
        );
        $this->start_popover();
        $this->add_responsive_control(
            'image_scale',
            [
                'label' => esc_html__( 'Image Scale', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .inner img' => '--e-transform-tcg-portfolio-adv-img-scale: {{SIZE}}',
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .inner .clippy-img.animated' => '--e-transform-tcg-portfolio-adv-img-scale: {{SIZE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_rotate',
            [
                'label' => esc_html__( 'Image Rotate', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg' ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .inner img' => '--e-transform-tcg-portfolio-adv-img-rotateZ: {{SIZE}}deg',
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .inner .clippy-img' => '--e-transform-tcg-portfolio-adv-img-rotateZ: {{SIZE}}deg',
                ],
            ]
        );
        $this->end_popover();
        $this->end_controls_tab();
        $this->start_controls_tab(
            'image_hover_tab',
            [
                'label'   => esc_html__( 'Hover', 'themescamp-core' ),
            ]
        );
        $this->add_control(
            'image_transition',
            [
                'label' => esc_html__( 'Transition', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .info-overlay .item-img .inner img' => 'transition: all {{SIZE}}s ease;',
                ],
            ]
        );
        $this->add_control(
            'image_transform_options_hover',
            [
                'label' => esc_html__('Image Transform', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label_off' => esc_html__('Default', 'themescamp-core'),
                'label_on' => esc_html__('Custom', 'themescamp-core'),
            ]
        );
        $this->start_popover();
        $this->add_responsive_control(
            'image_scale_hover',
            [
                'label' => esc_html__( 'Image Scale', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .item-img:hover .inner img' => '--e-transform-tcg-portfolio-adv-img-scale: {{SIZE}}',
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .item-img:hover .inner .clippy-img.animated' => '--e-transform-tcg-portfolio-adv-img-scale: {{SIZE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_rotate_hover',
            [
                'label' => esc_html__( 'Image Rotate', 'themescamp-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg' ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .item-img:hover .inner img' => '--e-transform-tcg-portfolio-adv-img-rotateZ: {{SIZE}}deg',
                    '{{WRAPPER}} .tcg-portfolio-adv .gridss .item-img:hover .inner .clippy-img.animated' => '--e-transform-tcg-portfolio-adv-img-rotateZ: {{SIZE}}deg',
                ],
            ]
        );
        $this->end_popover();
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render(){ 
        global $post;
        $settings = $this->get_settings();

        $migrated = isset($settings['__fa4_migrated']['selected_icon']);
        $is_new = empty($settings['icon']) && Icons_Manager::is_migration_allowed();
        if (!$is_new && empty($settings['icon_align'])) {
            $settings['icon_align'] = $this->get_settings('icon_align');
        }


         $tcg_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $categories = themescamp_tax_choice();
        $destudio_taxonomy = 'portfolio_category';
        $destudio_taxs = !empty($post) ? wp_get_post_terms($post->ID, $destudio_taxonomy) : array();
        if ($settings['port_order'] != 'rand') {
            $order = 'order';
            $ord_val = $settings['port_order'];
        } else {
            $order = 'orderby';
            $ord_val = 'rand';
        }

        $sort_cat = array(
            'taxonomy' => 'portfolio_category',   // taxonomy name
            'field' => 'term_id',
            'terms' => $settings['blog_cat'],           // term_id, slug or name                // term id, term slug or term name
        );

        $sort_tag = array(
            'taxonomy' => 'porto_tag',   // taxonomy name
            'field' => 'term_id',
            'terms' => $settings['blog_tag'],           // term_id, slug or name                // term id, term slug or term name
        );
        
        if ($settings['sort_cat']  == 'yes' || $settings['sort_tag']  == 'yes') {
            $query_args = array(
                'posts_per_page'   => $settings['portfolio_item'],
                'post_type' =>  'portfolio', 'themescamp-core',
                $order       =>  $ord_val,
                'tax_query' => array(
                    $settings['sort_cat'] == 'yes' ? $sort_cat : '',
                    $settings['sort_tag'] == 'yes' ? $sort_tag : ''
                )
            );
        } else {
            $query_args = array(
                'paged' => $tcg_paged,
                'posts_per_page'   => $settings['portfolio_item'],
                'post_type' =>  'portfolio', 'themescamp-core',
                $order       =>  $ord_val,
            );
        }

        // Get the category slug from the query variable (e.g., portfolio_category)
        $term = get_queried_object();
        if (isset($term->taxonomy)) {
            if ('portfolio_category' == $term->taxonomy) {
                $query_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'portfolio_category',
                        'field'    => 'slug',
                        'terms'    => $term->slug,
                    ),
                );
            } elseif ('porto_tag' == $term->taxonomy) {
                $query_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'porto_tag',
                        'field'    => 'slug',
                        'terms'    => $term->slug,
                    ),
                );
            }
        }

        if(!empty($settings['portfolio_offset'])){
            $offset = intval($settings['portfolio_offset']);
            $query_args['offset'] = $offset;
        }

        $destudio_work = new \WP_Query($query_args);

        ?>
        <div class="tcg-portfolio-adv <?php if($settings['masonry_style'] == 'yes' || $settings['masonry_col_style'] == 'yes') echo 'tcg-masonry'; if($settings['masonry_style'] == 'yes') echo ' tcg-metro'; ?> section-padding pb-40">
            <div class="row">

                <?php if($settings['show_filter'] == 'yes'): ?>
                <!-- filter links -->
                <div class="filtering col-12 mb-80 text-center">
                    <div class="filter">
                        <span class="text"><?php esc_html_e( 'Filter By :', 'themescamp-core' ) ?></span>
                        <span data-filter='*' class='active' data-count="08"><?php esc_html_e( 'All', 'themescamp-core' ) ?></span>
                        <?php 
                        $woo_cats_array = [];
                        if ($destudio_work->have_posts()) : while ( $destudio_work->have_posts() ) : $destudio_work->the_post(); global $post;
                        $woo_cats = get_the_terms( $post->ID, 'portfolio_category' );
                        if($woo_cats) {
                            foreach($woo_cats as $woo_cat) { $woo_cats_array[str_replace(' ', '-', strtolower($woo_cat->name))] = esc_html($woo_cat->name); }   
                        } 
                        endwhile; endif;
                        array_unique($woo_cats_array);
                        foreach($woo_cats_array as $cat => $cat_value): ?>
                                <span data-filter='.<?php echo str_replace(' ', '-', strtolower($cat)) ?>' data-count="03"><?php echo esc_html($cat_value); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif;?>
            </div>

            <div class="gallery justify-content-center <?php if($settings['masonry_style'] == 'yes') echo 'metro';  ?> " >
                <div class="row gridss max-margin">
                    <?php $i = 0; if ($destudio_work->have_posts()) : while  ($destudio_work->have_posts()) : $destudio_work->the_post();
                global $post ; $i++; ?>
                    <div class="items col-md-<?php echo esc_attr($settings['columns_number']) ?>  <?php if($settings['masonry_style'] == 'yes'){ if($i == 3 || $i == 5 || $i == 6) echo 'col-lg-6'; else echo 'col-lg-3'; } ?> <?php $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy); $count = 1; foreach ($destudio_taxs as $destudio_tax) { if($count != 1) echo ' '; echo strtolower(str_replace(' ', '-',$destudio_tax->name)); $count++; } ?> info-overlay">
                        <div class="item-img o-hidden">
                            <a href="<?php the_permalink(); ?>" class="imago">
                                <div class="inner">
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="image" class="<?php if (!empty($settings['image_animations'])) echo esc_attr($settings['image_animations'])?>">
                                </div>
                            </a>
                            <?php if($settings['masonry_style'] != 'yes') : ?>
                            <div class="info">
                                <div class="cont">
                                    <h6 class="sub-title tag">
                                             
                                            <?php if ($destudio_taxs && !is_wp_error($destudio_taxs)) : ?>
                                                <?php $count = 1; ?>
                                                <?php foreach ($destudio_taxs as $destudio_tax) : ?>
                                                    <?php if ($count != 1) echo $settings['meta_separator']; ?>
                                                    <a href="<?php echo esc_url(get_term_link($destudio_tax)); ?>">
                                                        <?php echo esc_html($destudio_tax->name); ?>
                                                    </a>
                                                    <?php $count++; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        
                                    </h6>
                                    <h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                </div>
                                <span class="icon" <?php $this->print_render_attribute_string('icon-align'); ?>>
                                    <?php if ($is_new || $migrated) :
                                        Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
                                    else : ?>
                                        <i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php else: ?>
                            <div class="info">
                                <h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>

                                <span class="sub-title category">
                                    <?php if ($destudio_taxs && !is_wp_error($destudio_taxs)) : ?>
                                        <?php $count = 1; ?>
                                        <?php foreach ($destudio_taxs as $destudio_tax) : ?>
                                            <?php if ($count != 1) echo $settings['meta_separator']; ?>
                                            <a href="<?php echo esc_url(get_term_link($destudio_tax)); ?>">
                                                <?php echo esc_html($destudio_tax->name); ?>
                                            </a>
                                            <?php $count++; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </span>


                                <?php $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy); $count = 1; foreach ($destudio_taxs as $destudio_tax) { 
                                    if($count != 1) echo $settings['meta_separator'];
                                    echo $destudio_tax->name;
                                    $count++;
                                }; ?></a></span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endwhile; endif; wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
        <?php
    }
}