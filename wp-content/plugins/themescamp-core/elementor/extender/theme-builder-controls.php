<?php

namespace ThemescampPlugin\Elementor;

use Elementor\Controls_Manager;

defined('ABSPATH') || exit(); // Exit if accessed directly

/**
 *  Elementor extra features
 */
class TCG_Theme_Builder_Controls
{

    public function __construct()
    {

        // theme builder controls
        if ((isset($_GET['post']) && get_post_type($_GET['post']) === 'tcg_teb') || !isset($_GET['action'])) :
            add_action('elementor/element/container/section_background/after_section_end', [$this, 'register_tc_theme_builder_header_controls'], 10, 3);
        endif;
        //add_action('elementor/element/container/section_background/after_section_end', [$this, 'register_tcg_sliding_container'], 10, 3);
    }

    function register_tc_theme_builder_header_controls($widget, $args)
    {

        $widget->start_controls_section(
            'tc_theme_builder_header_settings',
            [
                'label' => __('Header Settings', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );

        $widget->add_control(
            'tc_theme_builder_header_sticky',
            [
                'label' => esc_html__('Sticky Header', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('off', 'themescamp-core'),
                    'sticky' => __('Sticky', 'themescamp-core'),
                ],
                'separator' => 'before',
                'render_type' => 'none',
                'frontend_available' => true,
                'prefix_class' => 'tc-header-',
            ]
        );

        $widget->end_controls_section();
    }

    function register_tcg_sliding_container($widget, $args)
    {

        $widget->start_controls_section(
            'tcg_sliding_container_settings',
            [
                'label' => __('Sliding Settings', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_LAYOUT,
            ]
        );

        $widget->add_control(
            'tcg_sliding_container_type',
            [
                'label' => esc_html__('Container Sliding type', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'themescamp-core'),
                    'parent' => __('Slider (Parent)', 'themescamp-core'),
                    'child' => __('Slide (Child)', 'themescamp-core'),
                ],
                'separator' => 'before',
                'render_type' => 'none',
                'frontend_available' => true,
                'prefix_class' => 'tc-container-slide-',
            ]
        );


        $widget->end_controls_section();
    }
}