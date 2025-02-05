<?php

namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use Elementor\POPOVER_TOGGLE;
use ThemescampPlugin\Elementor\Controls\Helper as ControlsHelper;
use Elementor\Group_Control_Border;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class TCG_Dynamic_Tabs extends Widget_Base
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
        return 'tcg-dynamic-tabs';
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
        return __('TC Dynamic Tabs', 'themescamp-plugin');
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
        return 'eicon-posts-ticker';
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
        return ['themescamp-plugin'];
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
        return ['bootstrap.bundle.min'];
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
    protected function register_controls()
    {
        $this->start_controls_section(
            'slides_section',
            [
                'label' => __('slides', 'themescamp-plugin'),
            ]
        );

        $tabs_repeater = new \Elementor\Repeater();

        $tabs_repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__('Tab Title', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Popular',
            ]
        );

        $tabs_repeater->add_control(
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
                ],
            ]
        );

        $tabs_repeater->add_control(
            'active_tab',
            [
                'label' => esc_html__('Active Tab', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => false,
                'return' => true,
            ]
        );

        $tabs_repeater->add_control(
            'edit_slider',
            [
                'label' => esc_html__('Edit Slide', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::BUTTON,
                'separator' => 'before',
                'button_type' => 'success',
                'text' => esc_html__('Edit', 'themescamp-plugin'),
                'event' => 'tcgDynamicTabEditor',
                'condition' => [
                    'tcg_select_block!' => '',
                ]
            ]
        );

        $this->add_control(
            'tcg_dynamic_tabs_repeater',
            [
                'label' => esc_html__('Tabs', 'themescamp-plugin'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $tabs_repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => esc_html__('Popular', 'themescamp-plugin'),
                        'active_tab' => 'yes',
                    ],
                    [
                        'tab_title' => esc_html__('Trending', 'themescamp-plugin'),
                    ],
                    [
                        'tab_title' => esc_html__('Latest', 'themescamp-plugin'),
                    ],
                ],
            ]
        );

        $this->add_control(
            'add_block',
            [
                'label' => esc_html__('Add Block', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::BUTTON,
                'separator' => 'before',
                'button_type' => 'success',
                'text' => esc_html__('Add Block', 'themescamp-plugin'),
                'event' => 'tcgAddDynamicBlock',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__('Content Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'content_overflow',
            [
                'label' => esc_html__('Overflow', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'themescamp-plugin'),
                    'auto' => esc_html__('Auto', 'themescamp-plugin'),
                    'hidden' => esc_html__('Hidden', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-content .tcg-dynamic-tab' => 'overflow: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_min_width',
            [
                'label' => esc_html__( 'Min Width', 'themescamp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-content .tcg-dynamic-tab' => 'min-width: {{SIZE}}{{UNIT}};',
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
        $this->add_responsive_control(
            'filters_display',
            [
                'label' => esc_html__('Filters Display', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => 'block',
                'options' => [
                    'block' => esc_html__('Block', 'themescamp-elements'),
                    'inline-block' => esc_html__('Inline Block', 'themescamp-elements'),
                    'inline-flex' => esc_html__('Inline Flex', 'themescamp-elements'),
                    'flex' => esc_html__('Flex', 'themescamp-elements'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'display: {{VALUE}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'filters_display_direction',
            [
                'label' => esc_html__( 'Flex Direction', 'themescamp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'before' => [
                        'title' => esc_html__( 'Before', 'themescamp-elements' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'after' => [
                        'title' => esc_html__( 'After', 'themescamp-elements' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'start' => [
                        'title' => esc_html__( 'Start', 'themescamp-elements' ),
                        'icon' => "eicon-h-align-right",
                    ],
                    'end' => [
                        'title' => esc_html__( 'End', 'themescamp-elements' ),
                        'icon' => "eicon-h-align-left",
                    ],
                ],
                'selectors_dictionary' => [
                    'before' => 'flex-direction: column;',
                    'after' => 'flex-direction: column-reverse;',
                    'start' => 'flex-direction: row;',
                    'end' => 'flex-direction: row-reverse;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => '{{VALUE}};'
                ],
                'condition'=>[
                    'filters_display'=>['flex','inline-flex']
                ],
            ]
        );
        $this->add_responsive_control(
            'filters_justify_content',
            [
                'label' => esc_html__( 'Justify Content', 'themescamp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'default' => '',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start','themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__( 'Space Around', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__( 'Space Evenly', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-space-evenly-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'justify-content: {{VALUE}};',
                ],
                'condition'=>[
                    'filters_display'=>['flex','inline-flex']
                ],
                'responsive' => true,
            ]
        );
        $this->add_responsive_control(
            'filters_align_items',
            [
                'label' => esc_html__( 'Align Items', 'themescamp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => '',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'align-items: {{VALUE}};',
                ],
                'condition'=>[
                    'filters_display'=>['flex','inline-flex']
                ],
                'responsive' => true,
            ]
        );
        $this->add_responsive_control(
            'info_container_flex_wrap',
            [
                'label' => esc_html__( 'Wrap', 'themescamp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'nowrap' => [
                        'title' => esc_html__( 'No Wrap', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-nowrap',
                    ],
                    'wrap' => [
                        'title' => esc_html__( 'Wrap', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-wrap',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'flex-wrap: {{VALUE}};',
                ],
                'condition'=>[
                    'filters_display'=>['flex','inline-flex']
                ],
            ]
        );
        $this->add_responsive_control(
            'filters_width',
            [
                'label' => esc_html__( 'Width', 'themescamp-elements' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filters_positioning',
            [
                'label' => esc_html__('Position', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'unset' => esc_html__('unset', 'themescamp-plugin'),
                    'absolute' => esc_html__('absolute', 'themescamp-plugin'),
                    'relative' => esc_html__('relative', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'relative',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'position: {{VALUE}};',
                ],
            ]
        );
        $start = is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');
        $end = !is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');

        $this->add_control(
            'filters_offset_orientation_h',
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
            'filters_offset_x',
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
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                ],
                'condition' => [
                    'filters_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'filters_offset_x_end',
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
                    'body:not(.rtl) {{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                ],
                'condition' => [
                    'filters_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'filters_offset_orientation_v',
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
            'filters_offset_y',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                ],
                'condition' => [
                    'filters_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'filters_offset_y_end',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                ],
                'condition' => [
                    'filters_offset_orientation_v' => 'end',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'filters_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters',
                'exclude' => ['image']
            ]
        );
        $this->add_responsive_control(
            'filters_padding',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filters_margin',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filters_border_radius',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_tabs_style',
            [
                'label' => esc_html__('Tabs Style', 'themescamp-plugin'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'tabs_container',
            [
                'label' => esc_html__('Tabs Container', 'themescamp-elements'),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control(
            'tabs_container_padding',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tabs_container_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills',
            ]
        );
        $this->add_responsive_control(
            'tabs_container_border_radius',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'tabs_container_style_dark_mode',
            [
                'label' => esc_html__( 'Dark Mode', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'tabs_container_border_color_dark_mode',
            [
                'label' => esc_html__('Border Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tab_heading',
            [
                'label' => esc_html__('Tab Options', 'themescamp-elements'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_typography',
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link',
            ]
        );
        $this->add_responsive_control(
            'tab_border_radius',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tab_padding',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tab_margin',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'small_style',
            [
                'label' => esc_html__('Small Style', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tab_small_typography',
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link small',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tab_small_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link small',
                'exclude' => ['image']
            ]
        );
        $this->add_control(
            'tab_small_color',
            [
                'label' => esc_html__('Small Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link small' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tab_small_border_radius',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link small' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tab_small_padding',
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
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link small' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'tab_tabs_heading',
            [
                'label' => esc_html__('Tabs', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
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
                'name' => 'tab_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link',
                'exclude' => ['image']
            ]
        );
        $this->add_control(
            'tab_color',
            [
                'label' => esc_html__('Tab Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tab_opacity',
            [
                'label' => esc_html__( 'Tab Opacity', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tabs_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link',
            ]
        );
        $this->add_control(
            'tabs_style_dark_mode',
            [
                'label' => esc_html__( 'Dark Mode', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'tab_color_dark_mode',
            [
                'label' => esc_html__('Tab Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tab_background_color_dark_mode',
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link',
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
            'tab_active_tab',
            [
                'label'   => esc_html__( 'Active', 'themescamp-plugin' ),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tab_background_active',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link.active',
                'exclude' => ['image']
            ]
        );
        $this->add_control(
            'tab_color_active',
            [
                'label' => esc_html__('Tab Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link.active' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tab_opacity_active',
            [
                'label' => esc_html__( 'Tab Opacity', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link.active' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tabs_border_active',
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link.active',
            ]
        );
        $this->add_control(
            'tabs_style_dark_mode_active',
            [
                'label' => esc_html__( 'Dark Mode', 'themescamp-plugin' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'tab_color_dark_mode_active',
            [
                'label' => esc_html__('Tab Color', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link.active' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link.active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tab_background_color_dark_mode_active',
                'selector' => '{{WRAPPER}} .tcg-dynamic-tabs .tcg-dynamic-tabs-filters .nav-pills .nav-item .nav-link',
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

    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $render_context = isset($GLOBALS['widget_render_context']) ? $GLOBALS['widget_render_context'] : uniqid();
        $dynamic_tabs_id = 'tcg-dynamic-tabs-' . $render_context;


?>

        <div id="<?php echo esc_attr($dynamic_tabs_id) ?>" class="tcg-dynamic-tabs">

            <div class="tcg-dynamic-tabs-filters">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <?php
                    $active_tab_filter_found = false;
                    foreach ($settings['tcg_dynamic_tabs_repeater'] as $index => $tab) :
                        if (!empty($tab['tcg_select_block'])) :
                            $active_tab = $tab['active_tab']; ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php if ($active_tab && !$active_tab_filter_found) { echo esc_attr('active'); $active_tab_filter_found = true; } ?>" id="pills-tab-<?php echo esc_attr($tab['tcg_select_block'].$render_context); ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-tab-<?php echo esc_attr($tab['tcg_select_block'].$render_context); ?>"><?php echo __($tab['tab_title'],'themescamp-plugin'); ?></button>
                            </li>
                    <?php endif;
                    endforeach; ?>
                </ul>
            </div>

            <div class="tcg-dynamic-tabs-content">
                <div class="tab-content" id="pills-tabContent">
                    <?php
                    $active_tab_content_found = false;
                    foreach ($settings['tcg_dynamic_tabs_repeater'] as $index => $tab) :
                        if (!empty($tab['tcg_select_block'])) :
                            $active_tab = $tab['active_tab']; ?>
                            <div class="tab-pane fade <?php if ($active_tab && !$active_tab_content_found) { echo esc_attr('show active'); $active_tab_content_found = true; } ?>" id="pills-tab-<?php echo esc_attr($tab['tcg_select_block'].$render_context); ?>">
                                <div class="tcg-dynamic-tab">
                                    <?php

                                    $frontend = new \Elementor\Frontend();
                                    $tab_ID  = $tab['tcg_select_block'];

                                    echo $frontend->get_builder_content_for_display($tab_ID);

                                    ?>
                                </div>
                            </div>
                        <?php endif;
                    endforeach; ?>
                </div>
            </div>

        </div>

    <?php
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function content_template()
    {
    ?>
<?php
    }
}
