<?php

namespace ThemescampPlugin\Elementor\Elements\Widgets;

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
use ThemescampPlugin\Elementor\Controls\Helper as ControlsHelper;


if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.1.0
 */
class TCG_Dynamic_Query extends Widget_Base
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
        return 'tcg-dynamic-query';
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
        return esc_html__('TC Dynamic Query', 'themescamp-plugin');
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
        return 'eicon-document-file';
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
        return ['posts', 'blogs', 'portfolio'];
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
        return ['themescamp-elements'];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['isotope.min', 'dynamic-query'];
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

        $post_types = ControlsHelper::get_post_types();
        $post_types['by_id'] = __('Manual Selection', 'themescamp-plugin');

        $taxonomies = get_taxonomies([], 'objects');

        $this->start_controls_section(
            'tcg_section_post_layout',
            [
                'label' => __('Layout', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'tcg_select_block',
            [
                'label' => esc_html__('Select Block', 'themescamp-plugin'),
                'type' => 'tcg-select2',
                'multiple' => false,
                'label_block' => true,
                'source_name' => 'block',
                'source_type' => 'tcg_teb',
                'meta_query' => [
                    [
                        'key' => 'template_type',
                        'value' => 'block',
                        'compare' => '='
                    ]
                ]
            ]
        );

        $this->add_control(
            'edit_block',
            [
                'label' => esc_html__('Edit Block', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::BUTTON,
                'separator' => 'before',
                'button_type' => 'success',
                'text' => esc_html__('Edit', 'themescamp-plugin'),
                'event' => 'tcgDynamicQueryEditor',
                'condition' => [
                    'tcg_select_block!' => '',
                ]
            ]
        );

        $this->add_control(
            'add_block',
            [
                'label' => esc_html__('Add Block', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::BUTTON,
                'button_type' => 'success',
                'text' => esc_html__('Add Block', 'themescamp-plugin'),
                'event' => 'tcgAddDynamicBlock',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '12' => '1 Column',
                    '6' => '2 Column',
                    '4' => '3 Column',
                    '3' => '4 Column',
                    '2' => '6 Column',
                ],
                'separator' => 'before',
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => '4',
                'tablet_default' => '6',
                'mobile_default' => '12',
                'default' => '4',
            ]
        );

        $this->add_control(
            'query_tabs',
            [
                'label' => esc_html__('Tabs', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => false,
                'return' => 'yes'
            ]
        );

        $this->add_control(
            'query_tabs_all_title',
            [
                'label' => esc_html__('All Items Title', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'All',
                'condition' => [
                    'query_tabs' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'post_display_style',
            [
                'label' => __('Display Style', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'columns' => esc_html__('Columns', 'themescamp-core'),
                    'masonry' => esc_html__('Masonry', 'themescamp-core')
                ],
                'default' => 'columns',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tcg_section_post__filters',
            [
                'label' => __('Query', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label' => __('Source', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $post_types,
                'default' => key($post_types),
            ]
        );

        $this->add_control(
            'tcg_global_dynamic_source_warning_text',
            [
                'type' => \Elementor\Controls_Manager::ALERT,
                'alert_type' => 'warning',
                'heading' => esc_html__('Warning', 'themescamp-core'),
                'content' => esc_html__('This option will only affect in <strong>Archive page of Elementor Theme Builder</strong> dynamically.', 'themescamp-core'),
                'condition' => [
                    'post_type' => 'source_dynamic',
                ]
            ]
        );

        $this->add_control(
            'posts_ids',
            [
                'label' => __('Search & Select', 'themescamp-plugin'),
                'type' => 'tcg-select2',
                'options' => ControlsHelper::get_post_list(),
                'label_block' => true,
                'multiple'    => true,
                'source_name' => 'post_type',
                'source_type' => 'any',
                'condition' => [
                    'post_type' => 'by_id',
                ],
            ]
        );

        $this->add_control(
            'authors',
            [
                'label' => __('Author', 'themescamp-plugin'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'default' => [],
                'options' => ControlsHelper::get_authors_list(),
                'condition' => [
                    'post_type!' => ['by_id', 'source_dynamic'],
                ],
            ]
        );

        foreach ($taxonomies as $taxonomy => $object) {
            if (!isset($object->object_type[0]) || !in_array($object->object_type[0], array_keys($post_types))) {
                continue;
            }

            $this->add_control(
                $taxonomy . '_ids',
                [
                    'label' => $object->label,
                    'type' => 'tcg-select2',
                    'label_block' => true,
                    'multiple' => true,
                    'source_name' => 'taxonomy',
                    'source_type' => $taxonomy,
                    'condition' => [
                        'post_type' => $object->object_type,
                    ],
                ]
            );
        }

        $this->add_control(
            'post__not_in',
            [
                'label'       => __('Exclude', 'themescamp-plugin'),
                'type'        => 'tcg-select2',
                'label_block' => true,
                'multiple'    => true,
                'source_name' => 'post_type',
                'source_type' => 'any',
                'condition'   => [
                    'post_type!' => ['by_id', 'source_dynamic'],
                ],
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'themescamp-plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
                'min' => '1',
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label' => esc_html__('Pagination', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => false,
                'return' => 'yes'
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => __('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
                'condition' => [
                    'orderby!' => 'rand',
                    'pagination!' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => ControlsHelper::get_post_orderby_options(),
                'default' => 'date',

            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
                'default' => 'desc',

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'posts_style',
            [
                'label' => esc_html__('Posts Style', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__('Space Between Posts (Vertical)', 'themescamp-core'),
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
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .row' => '--bs-gutter-y: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space_between_x',
            [
                'label' => esc_html__('Space Between Posts (Horizontal)', 'themescamp-core'),
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
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container .row:not(.gx-0):not(.gx-1):not(.gx-2):not(.gx-3):not(.gx-4):not(.gx-5)' => 'margin-right: -{{SIZE}}{{UNIT}}; margin-left: -{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-widget-container .row:not(.gx-0):not(.gx-1):not(.gx-2):not(.gx-3):not(.gx-4):not(.gx-5) > *' => 'padding-right: {{SIZE}}{{UNIT}}; padding-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'pagination_style',
            [
                'label' => esc_html__('Pagination Style', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pagination_alignment',
            [
                'label' => __('Pagination Alignment', 'themescamp-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'themescamp-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'themescamp-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'themescamp-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .pagination' => 'text-align: {{VALUE}};',
                ],
                'default' => 'center',
            ]
        );

        $this->add_control(
            'pagination_padding',
            [
                'label' => esc_html__('Pagination Padding', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .pagination a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_margin',
            [
                'label' => esc_html__('Pagination Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .pagination a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pagination_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .pagination a',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pagination_border_radius',
            [
                'label' => esc_html__('Pagination Radius', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .pagination a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


		$this->start_controls_tabs( 'tabs_pagination_item_style' );

		$this->start_controls_tab(
			'tab_pagination_item_normal',
			[
				'label' => __( 'Normal', 'themescamp-core' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tcg-dynamic-query .pagination a' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .pagination a',
                'exclude' => ['image']
            ]
        );

        $this->add_control(
            'pagination_style_dark_mode_normal',
            [
                'label' => esc_html__( 'Dark Mode', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pagination_color_dark_mode_normal',
            [
                'label' => __('Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-query .pagination a' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-query .pagination a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_border_color_dark_mode_normal',
            [
                'label' => __('Border Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-query .pagination a' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-query .pagination a' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_background_dark_mode_normal',
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .pagination a',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'fields_options' => [
                    'color' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                        ],
                    ],
                    'gradient_angle' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'gradient_position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'image' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                        ],
                    ],
                    'position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                        ],
                    ],
                    'xpos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'ypos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'attachment' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                            '} body.tcg-dark-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                        ],
                    ],
                    'repeat' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                        ],
                    ],
                    'size' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                        ],
                    ],
                    'bg_width' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                        ],
                    ],
                    'video_fallback' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                        ],
                    ],
                ]
            ]
        );

        $this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => __( 'Hover', 'themescamp-core' ),
			]
		);

		$this->add_control(
			'pagination_color_hover',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tcg-dynamic-query .pagination a:hover' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_background_hover',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .pagination a:hover',
                'exclude' => ['image']
            ]
        );

        $this->add_control(
            'pagination_style_dark_mode_hover',
            [
                'label' => esc_html__( 'Dark Mode', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pagination_color_dark_mode_hover',
            [
                'label' => __('Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-query .pagination a:hover' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-query .pagination a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_background_dark_mode_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .pagination a:hover',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'fields_options' => [
                    'color' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                        ],
                    ],
                    'gradient_angle' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'gradient_position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'image' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                        ],
                    ],
                    'position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                        ],
                    ],
                    'xpos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'ypos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'attachment' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                            '} body.tcg-dark-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                        ],
                    ],
                    'repeat' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                        ],
                    ],
                    'size' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                        ],
                    ],
                    'bg_width' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                        ],
                    ],
                    'video_fallback' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                        ],
                    ],
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_menu_item_active',
            [
                'label' => esc_html__( 'Active', 'themescamp-core' ),
            ]
        );

        $this->add_control(
            'pagination_color_active',
            [
                'label' => esc_html__('Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .pagination a.current-page' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_background_active',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .pagination a.current-page',
                'exclude' => ['image']
            ]
        );

        $this->add_control(
            'pagination_style_dark_mode_active',
            [
                'label' => esc_html__( 'Dark Mode', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pagination_color_dark_mode_active',
            [
                'label' => __('Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-query .pagination a.current-page' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-query .pagination a.current-page' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_background_dark_mode_active',
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .pagination a.current-page',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'fields_options' => [
                    'color' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                        ],
                    ],
                    'gradient_angle' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'gradient_position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'image' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                        ],
                    ],
                    'position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                        ],
                    ],
                    'xpos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'ypos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'attachment' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                            '} body.tcg-dark-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                        ],
                    ],
                    'repeat' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                        ],
                    ],
                    'size' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                        ],
                    ],
                    'bg_width' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                        ],
                    ],
                    'video_fallback' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                        ],
                    ],
                ]
            ]
        );

        $this->end_controls_tab();

		$this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'tabs_style',
            [
                'label' => esc_html__('Tabs Style', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tabs_padding',
            [
                'label' => esc_html__('Tabs Padding', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_margin',
            [
                'label' => esc_html__('Tabs Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
			'tabs_align',
			[
				'label' => esc_html__( 'Tabs Alignment', 'themescamp-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'themescamp-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'themescamp-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'themescamp-core' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters' => 'text-align: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();
        $this->start_controls_section(
            'section_filters_style',
            [
                'label' => esc_html__('Filters Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'filters_container',
            [
                'label' => esc_html__('Filters Container', 'themescamp-elements'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'filters_container_overflow',
            [
                'label' => esc_html__('Filters Container Overflow', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'themescamp-plugin'),
                    'hidden' => esc_html__('Hidden', 'themescamp-plugin'),
                    'visible' => esc_html__('Visible', 'themescamp-plugin'),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter' => 'overflow: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filters_width',
            [
                'label' => esc_html__('Width', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filters_container_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filters_container_padding',
            [
                'label' => esc_html__('Padding', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filters_container_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter',
            ]
        );
        $this->add_responsive_control(
            'filters_container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'filters_container_dark_mode',
            [
                'label' => esc_html__( 'Dark Mode Controls', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'none',
            ]
        );
        $this->add_control(
            'filters_container_border_dark_mode',
            [
                'label'     => esc_html__( 'Border', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_button_heading',
            [
                'label' => esc_html__('Filter Button Options', 'themescamp-elements'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'filter_button_display',
            [
                'label' => esc_html__('Filter Button Display', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => 'inline-block',
                'options' => [
                    'block' => esc_html__('Block', 'themescamp-elements'),
                    'inline-block' => esc_html__('Inline Block', 'themescamp-elements'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn' => 'display: {{VALUE}};'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter_button_typography',
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn',
            ]
        );
        $this->add_responsive_control(
            'filter_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filter_button_padding',
            [
                'label' => esc_html__('Padding', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filter_button_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'tabs_tab',
        );
        $this->start_controls_tab(
            'tab_normal_tab',
            [
                'label'   => esc_html__( 'Normal', 'themescamp-plugin' ),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'filter_button_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn',
                'exclude' => ['image']
            ]
        );
        $this->add_control(
            'filter_button_color',
            [
                'label' => esc_html__('Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_button_opacity',
            [
                'label' => esc_html__( 'Opacity', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filter_button_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn',
            ]
        );
        $this->add_control(
            'filter_button_style_dark_mode',
            [
                'label' => esc_html__( 'Dark Mode', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'filter_button_color_dark_mode',
            [
                'label' => esc_html__('Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'filter_button_background_color_dark_mode',
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'fields_options' => [
                    'color' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                        ],
                    ],
                    'gradient_angle' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'gradient_position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'image' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                        ],
                    ],
                    'position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                        ],
                    ],
                    'xpos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'ypos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'attachment' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                            '} body.tcg-dark-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                        ],
                    ],
                    'repeat' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                        ],
                    ],
                    'size' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                        ],
                    ],
                    'bg_width' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                        ],
                    ],
                    'video_fallback' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                        ],
                    ],
                    'background' => [
                        'label' => esc_html_x('Bullet Background', 'Background Control', 'themescamp-plugin'),
                    ]
                ]
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'filter_button_active_tab',
            [
                'label'   => esc_html__( 'Active', 'themescamp-plugin' ),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'filter_button_background_active',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn.active',
                'exclude' => ['image']
            ]
        );
        $this->add_control(
            'filter_button_color_active',
            [
                'label' => esc_html__('Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn.active' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_button_opacity_active',
            [
                'label' => esc_html__( 'Opacity', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn.active' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'filter_button_border_active',
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn.active',
            ]
        );
        $this->add_control(
            'filter_button_style_dark_mode_active',
            [
                'label' => esc_html__( 'Dark Mode', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'filter_button_color_dark_mode_active',
            [
                'label' => esc_html__('Tab Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn.active' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn.active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'filter_button_background_color_dark_mode_active',
                'selector' => '{{WRAPPER}} .tcg-dynamic-query .tcg-dynamic-query-filters .filter .filter-btn.active',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'fields_options' => [
                    'color' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: {{VALUE}};',
                        ],
                    ],
                    'gradient_angle' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'gradient_position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
                        ],
                    ],
                    'image' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-image: url("{{URL}}");',
                        ],
                    ],
                    'position' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{VALUE}};',
                        ],
                    ],
                    'xpos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'ypos' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}',
                        ],
                    ],
                    'attachment' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                            '} body.tcg-dark-mode (desktop+){{SELECTOR}}' => 'background-attachment: {{VALUE}};',
                        ],
                    ],
                    'repeat' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-repeat: {{VALUE}};',
                        ],
                    ],
                    'size' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{VALUE}};',
                        ],
                    ],
                    'bg_width' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background-size: {{SIZE}}{{UNIT}} auto',
                        ],
                    ],
                    'video_fallback' => [
                        'selectors' => [
                            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                            '} body.tcg-dark-mode {{SELECTOR}}' => 'background: url("{{URL}}") 50% 50%; background-size: cover;',
                        ],
                    ],
                    'background' => [
                        'label' => esc_html_x('Background', 'Background Control', 'themescamp-plugin'),
                    ]
                ]
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'column_overlay',
            [
                'label' => esc_html__('Overlay Style', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'items_selected',
            [
                'label' => esc_html__('Overlay Selectors', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => 'None',
                    'all' => 'All Items',
                    'last' => 'All Items Except Last Item',
                    'first' => 'All Items Except First Item',
                ],
                'default' => '',
            ]
        );
        $this->add_control(
            'overlay_opacity',
            [
                'label' => esc_html__( 'Overlay Opacity', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'overlay_height',
            [
                'label' => esc_html__('Height', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'overlay_width',
            [
                'label' => esc_html__('Width', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'overlay_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after,{{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after,{{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after',
                'exclude' => ['image']
            ]
        );
        $this->add_responsive_control(
            'overlay_positioning',
            [
                'label' => esc_html__('Position', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'unset' => esc_html__('unset', 'themescamp-plugin'),
                    'absolute' => esc_html__('absolute', 'themescamp-plugin'),
                    'relative' => esc_html__('relative', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'absolute',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after' => 'content:"";position: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after' => 'content:"";position: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after' => 'content:"";position: {{VALUE}};',
                ],
            ]
        );
        $start = is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');
        $end = !is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');

        $this->add_control(
            'overlay_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-plugin'),
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
            'overlay_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
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
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                ],
                'condition' => [
                    'overlay_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'overlay_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
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
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                ],
                'condition' => [
                    'overlay_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'overlay_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'overlay_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
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
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                ],
                'condition' => [
                    'overlay_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'overlay_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
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
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="all"] .row .tcg-dynamic-query-item::after' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="first"] .tcg-dynamic-query-item:not(:first-child)::after' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                    '{{WRAPPER}} .tcg-dynamic-query[data-items-selected="last"] .tcg-dynamic-query-item:not(:last-child)::after' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',                ],
                'condition' => [
                    'overlay_offset_orientation_v' => 'end',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings();
        $settings = ControlsHelper::fix_old_query($settings);
        $args = ControlsHelper::get_query_args($settings);
        $args = ControlsHelper::get_dynamic_args($settings, $args);
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $query = new \WP_Query($args);

        $columns_tablet = isset($settings['columns_tablet']) ? $settings['columns_tablet'] : 6;
        $columns_mobile = isset($settings['columns_mobile']) ? $settings['columns_mobile'] : 12;
        $items_selected = $settings['items_selected'];

        ?>
        <div class="tcg-dynamic-query" <?php if (!empty($settings['items_selected'])) :?> data-items-selected="<?php echo esc_attr($items_selected); ?>" <?php endif;?>>

            <?php if($settings['query_tabs'] == 'yes'): ?>
                <div class="tcg-dynamic-query-filters">
                    <div class="filter">
                        <span class="filter-btn active" data-filter='*'><?php echo esc_html($settings['query_tabs_all_title']); ?></span>
                        <?php
                        $categories = array();
                        if ($query->have_posts()) :
                            while ($query->have_posts()) :
                                $query->the_post();
                                $post_taxonomies = get_object_taxonomies(get_post_type());
                                foreach ($post_taxonomies as $taxonomy) {
                                    if ($taxonomy == 'category' || $taxonomy == 'portfolio_category') { // only retrieve categories
                                        $terms = get_the_terms(get_the_ID(), $taxonomy);
                                        if ($terms) {
                                            foreach ($terms as $term) {
                                                $categories[] = $term->slug;
                                            }
                                        }
                                    }
                                }
                            endwhile;
                        endif;

                        // Remove duplicates from the $categories array
                        $categories = array_unique($categories);

                        // Generate tabs for each category
                        foreach ($categories as $slug) {
                            foreach ($post_taxonomies as $taxonomy) {
                                if ($taxonomy == 'category' || $taxonomy == 'portfolio_category') {
                                    $category = get_term_by('slug', $slug, $taxonomy);
                                    if ($category) {
                                        $tab_title = $category->name;
                                    } else {
                                        $tab_title = ucfirst($slug); // Fallback to slug if category not found
                                    }
                                    ?>
                                    <span class="filter-btn" data-filter='.category-<?php echo esc_attr($slug); ?>'><?php echo esc_html($tab_title); ?></span>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row<?php if ($settings['query_tabs'] == 'yes' || $settings['post_display_style'] == 'masonry') echo esc_attr(' gallery'); ?>">
                <?php
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $post_taxonomies = get_object_taxonomies(get_post_type());
                        $category_classes = '';

                        foreach ($post_taxonomies as $taxonomy) {
                            if ($taxonomy == 'category' || $taxonomy == 'portfolio_category') {
                                $terms = get_the_terms(get_the_ID(), $taxonomy);
                                if ($terms) {
                                    foreach ($terms as $term) {
                                        $category_classes .= 'category-' . $term->slug . ' ';
                                    }
                                }
                            }
                        }
                        ?>
                        <div class="tcg-dynamic-query-item col-lg-<?php echo esc_attr($settings['columns']); ?> col-md-<?php echo esc_attr($columns_tablet); ?> col-<?php echo esc_attr($columns_mobile); ?> <?php echo esc_attr($category_classes); ?>">
                            <?php
                            $frontend = new \Elementor\Frontend();
                            $block_ID  = $settings['tcg_select_block'];
                            echo $frontend->get_builder_content_for_display($block_ID);
                            ?>
                        </div>
                        <?php

                    }

                    wp_reset_postdata();

                } else {
                    _e('<p class="no-posts-found">No posts found!</p>', 'themescamp-plugin');
                }
                ?>
            </div>

            <?php if ($settings['pagination'] == 'yes'): ?>
                <div class="pagination">
                    <?php
                    $total_pages = $query->max_num_pages;
                    if ($total_pages > 1) {
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo '<a href="' . esc_url(get_pagenum_link($i)) . '" ' . ($i == $paged ? 'class="current-page"' : '') . '>' . $i . '</a>';
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
