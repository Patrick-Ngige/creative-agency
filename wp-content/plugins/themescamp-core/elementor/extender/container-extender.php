<?php

namespace ThemescampPlugin\Elementor;

if (!class_exists('Elementor\Group_Control_Background')) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Plugin;

defined('ABSPATH') || exit(); // Exit if accessed directly

/**
 *  Elementor extra features
 */
class TCG_Container_Extender
{

    public function __construct()
    {

        // add container 3 gradient colors background
        add_action('elementor/element/container/section_background/before_section_end', function ($stack) {

            $section_bg = Plugin::instance()->controls_manager->get_control_from_stack($stack->get_unique_name(), 'background_background');
            $section_bg['options']['tcg_gradient'] = [
                'title' => esc_html__('3 Colors Gradient', 'elementor'),
                'icon' => 'eicon-barcode',
            ];
            $stack->update_control('background_background', $section_bg);
        }, 10, 3);

        // add container parent hover background
        add_action('elementor/element/container/section_background/before_section_end', function ($stack) {
            $contaner_hover_bg = Plugin::instance()->controls_manager->get_control_groups('background');
            foreach ($contaner_hover_bg->get_fields() as $field_key => $field) {
                //var_dump($field_key);
                $control_id = 'background_hover_' . $field_key;
                $old_control_data = Plugin::instance()->controls_manager->get_control_from_stack($stack->get_unique_name(), $control_id);
                if (isset($old_control_data['selectors'])) {
                    $new_selectors = [];
                    foreach ($old_control_data['selectors'] as $selector => $style) {
                        $new_selectors['{{WRAPPER}}.tc-parent-container-hover-active'] = $style;
                    }

                    $old_control_data['selectors'] = array_merge($old_control_data['selectors'], $new_selectors);

                    $stack->update_control($control_id, $old_control_data);
                    //var_dump($old_control_data['selectors']);
                }
            }
        }, 10, 3);

        // add container 3 gradient colors background Overlay
        add_action('elementor/element/container/section_background_overlay/before_section_end', function ($stack) {

            $section_bg = Plugin::instance()->controls_manager->get_control_from_stack($stack->get_unique_name(), 'background_overlay_background');
            $section_bg['options']['tcg_gradient'] = [
                'title' => esc_html__('3 Colors Gradient', 'elementor'),
                'icon' => 'eicon-barcode',
            ];
            $stack->update_control('background_overlay_background', $section_bg);
        }, 10, 3);

        // container controls
        add_action('elementor/element/container/section_background/after_section_start', [$this, 'register_tc_container_background_controls_start'], 10, 3);
        add_action('elementor/element/container/section_background/before_section_end', [$this, 'register_tc_container_background_controls'], 10, 3);
        add_action('elementor/element/container/section_background_overlay/before_section_end', [$this, 'register_tc_container_background_overlay_controls'], 10, 3);
        add_action('elementor/element/container/section_border/before_section_end', [$this, 'register_tc_container_border_controls'], 10, 3);
        add_action('elementor/element/container/section_effects/after_section_end', [$this, 'register_tc_container_hover_controls'], 10, 3);
        add_action('elementor/element/container/section_layout_additional_options/before_section_end', [$this, 'register_tc_container_additional_options_controls'], 10, 3);
        add_action('elementor/element/container/section_background/before_section_end', [$this, 'register_tc_container_background_hover_controls'], 10, 3);
        add_action('elementor/element/container/section_background/before_section_end', [$this, 'register_tc_container_background_normal_controls'], 10, 3);
    }

    function register_tc_container_background_normal_controls($widget, $args)
    {

        $widget->start_injection([
            'at' => 'after',
            'of' => 'handle_slideshow_asset_loading',
        ]);

        $widget->add_control(
            'tc_container_background_blur_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $widget->add_control(
            'tc_container_background_blur_method',
            [
                'label' => esc_html__('TCG Background Blur Method', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'backdrop-filter' => 'backdrop-filter',
                    'filter' => 'filter',
                ],
                'default' => 'backdrop-filter',
                'selectors' => [
                    '{{WRAPPER}}' => '{{VALUE}}: blur({{tc_container_background_blur.SIZE}}px);',
                ],
            ]
        );

        $widget->add_control(
            'tc_container_background_blur',
            [
                'label' => esc_html__('TCG Background Blur', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 250,
                    ],
                ],
            ]
        );

        $widget->end_injection();
    }

    function register_tc_container_background_hover_controls($widget, $args)
    {
        $widget->start_injection([
            'at' => 'before',
            'of' => 'background_hover_transition',
        ]);
        // add a control
        $widget->add_control(
            'tc_container_background_hover_blur_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $widget->add_control(
            'tc_container_background_hover_blur_method',
            [
                'label' => esc_html__('TCG Background Blur Method', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'backdrop-filter' => 'backdrop-filter',
                    'filter' => 'filter',
                ],
                'default' => 'backdrop-filter',
                'selectors' => [
                    '{{WRAPPER}}:hover' => '{{VALUE}}: blur({{tc_container_background_hover_blur.SIZE}}px);',
                    '{{WRAPPER}}.tc-parent-container-hover-active' => '{{VALUE}}: blur({{tc_container_background_hover_blur.SIZE}}px);',
                ],
            ]
        );

        $widget->add_control(
            'tc_container_background_hover_blur',
            [
                'label' => esc_html__('TCG Background Blur', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 250,
                    ],
                ],
            ]
        );

        $widget->end_injection();
    }

    public function tc_selectors_refactor(array $selectors, string $value)
    {
        foreach ($selectors as $key => $selector) {
            $selectors[$key] = $value;
        }
        return $selectors;
    }
    function register_tc_container_background_controls_start($widget, $args)
    {

        $widget->add_control(
            'tc_container_hover_selector',
            [
                'label' => esc_html__('Choose Selector', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'container',
                'options' => [
                    'container'  => esc_html__('Container', 'themescamp-elements'),
                    'parent-container'  => esc_html__('Parent Container', 'themescamp-elements'),
                ],
                'render_type' => 'ui',
                'frontend_available' => true,
            ]
        );
    }

    function register_tc_container_hover_controls($widget, $args)
    {


        $widget->start_controls_section(
            'tcg_advanced_hover_section',
            [
                'label' => __('TCG Advanced Hover', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'tcg_advanced_hover',
            [
                'label' => esc_html__('TCG Advanced Hover', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'no' => esc_html__('Off', 'themescamp-core'),
                    'yes' => esc_html__('On', 'themescamp-core'),
                ],
                'default' => 'no',
                'render_type' => 'ui',
                'frontend_available' => true,
                'responsive' => [
                    'desktop' => [
                        'default' => 'no',
                    ],
                    'tablet' => [
                        'default' => 'no',
                    ],
                    'mobile' => [
                        'default' => 'no',
                    ],
                ],
            ]
        );

        $widget->add_control(
            'tcg_advanced_hover_transition',
            [
                'label' => esc_html__('Advanced Hover Transition', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 10,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}}.tc-container-advanced-hover' => 'animation: fadeOut {{SIZE}}s;',
                    '{{WRAPPER}}.tcg-container-adv-hover-active' => 'animation: fadeIn {{SIZE}}s;',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    function register_tc_container_background_controls($widget, $args)
    {

        $widget->add_control(
            'tc_container_background_parallax_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $widget->add_control(
            'tc_container_background_parallax',
            [
                'label' => esc_html__('TCG Background Parallax', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'themescamp-core'),
                'label_off' => esc_html__('Off', 'themescamp-core'),
                'return_value' => 'yes',
                'default' => 'no',
                'render_type' => 'ui',
                'frontend_available' => true,
            ]
        );

        $widget->add_control(
            'tc_container_background_divider_dark_mode',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $widget->add_control(
            'tc_container_background_title_dark_mode',
            [
                'label' => esc_html__('TCG Dark Mode Background', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'none',
            ]
        );

        $widget->start_controls_tabs('_tabs_tc_container_background_dark_mode');

        $widget->start_controls_tab(
            '_tab_tc_container_background_normal_dark_mode',
            [
                'label' => esc_html__('Normal', 'themescamp-core'),
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tc_container_background_dark_mode',
                'selector' => '{{WRAPPER}}',
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

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            '_tab_tc_container_background_hover_dark_mode',
            [
                'label' => esc_html__('Hover', 'themescamp-core'),
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tc_container_background_hover_dark_mode',
                'selector' => '{{WRAPPER}}:hover',
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

        $widget->end_controls_tab();

        $widget->end_controls_tabs();
    }

    function register_tc_container_background_overlay_controls($widget, $args)
    {

        $widget->add_control(
            'tc_container_background_overlay_divider_dark_mode',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $widget->add_control(
            'tc_container_background_overlay_title_dark_mode',
            [
                'label' => esc_html__('TCG Dark Mode Background Overlay', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'none',
            ]
        );

        $widget->start_controls_tabs('_tabs_tc_container_background_overlay');

        $widget->start_controls_tab(
            '_tab_tc_container_background_overlay_normal_dark_mode',
            [
                'label' => esc_html__('Normal', 'themescamp-core'),
            ]
        );

        $tc_container_background_overlay_selectors = [
            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}::before' => 'background-color: {{VALUE}};',
            '} body.tcg-dark-mode {{WRAPPER}}::before' => 'background-color: {{VALUE}};',

            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} > .elementor-background-video-container::before' => 'background-color: {{VALUE}};',
            '} body.tcg-dark-mode {{WRAPPER}} > .elementor-background-video-container::before' => 'background-color: {{VALUE}};',

            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} > .e-con-inner > .elementor-background-video-container::before' => 'background-color: {{VALUE}};',
            '} body.tcg-dark-mode {{WRAPPER}} > .e-con-inner > .elementor-background-video-container::before' => 'background-color: {{VALUE}};',

            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} > .e-con-inner > .elementor-background-slideshow::before' => 'background-color: {{VALUE}};',
            '} body.tcg-dark-mode {{WRAPPER}} > .e-con-inner > .elementor-background-slideshow::before' => 'background-color: {{VALUE}};',

            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} > .elementor-motion-effects-container > .elementor-motion-effects-layer::before' => 'background-color: {{VALUE}};',
            '} body.tcg-dark-mode {{WRAPPER}} > .elementor-motion-effects-container > .elementor-motion-effects-layer::before' => 'background-color: {{VALUE}};',
        ];

        $background_overlay_selector = '{{WRAPPER}}::before, {{WRAPPER}} > .elementor-background-video-container::before, {{WRAPPER}} > .e-con-inner > .elementor-background-video-container::before, {{WRAPPER}} > .elementor-background-slideshow::before, {{WRAPPER}} > .e-con-inner > .elementor-background-slideshow::before, {{WRAPPER}} > .elementor-motion-effects-container > .elementor-motion-effects-layer::before';

        $widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tc_container_background_overlay_dark_mode',
                'selector' => '{{WRAPPER}} > .elementor-element-populated >  .elementor-background-overlay',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'fields_options' => [
                    'background' => [
                        'selectors' => [
                            // Hack to set the `::before` content in order to render it only when there is a background overlay.
                            $background_overlay_selector => '--background-overlay: \'\';',
                        ],
                    ],
                    'color' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-color: {{VALUE}};'),
                    ],
                    'gradient_angle' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})'),
                    ],
                    'gradient_position' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})'),
                    ],
                    'image' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-image: url("{{URL}}");'),
                    ],
                    'position' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-position: {{VALUE}};'),
                    ],
                    'xpos' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}'),
                    ],
                    'ypos' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-position: {{xpos.SIZE}}{{xpos.UNIT}} {{SIZE}}{{UNIT}}'),
                    ],
                    'attachment' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-attachment: {{VALUE}};'),
                    ],
                    'repeat' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-repeat: {{VALUE}};'),
                    ],
                    'size' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-size: {{VALUE}};'),
                    ],
                    'bg_width' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background-size: {{SIZE}}{{UNIT}} auto'),
                    ],
                    'video_fallback' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, 'background: url("{{URL}}") 50% 50%; background-size: cover;'),
                    ],
                ]
            ]
        );

        $widget->add_responsive_control(
            'tc_container_background_overlay_opacity_dark_mode',
            [
                'label' => esc_html__('Opacity', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => .5,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_selectors, '--overlay-opacity: {{SIZE}};'),
                'condition' => [
                    'tc_container_background_overlay_dark_mode_background' => ['classic', 'gradient'],
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            '_tab_tc_container_background_overlay_hover_dark_mode',
            [
                'label' => esc_html__('Hover', 'themescamp-core'),
            ]
        );

        $tc_container_background_overlay_hover_selectors = [
            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}:hover::before' => 'background-color: {{VALUE}};',
            '} body.tcg-dark-mode {{WRAPPER}}:hover::before' => 'background-color: {{VALUE}};',

            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}:hover > .elementor-background-video-container::before' => 'background-color: {{VALUE}};',
            '} body.tcg-dark-mode {{WRAPPER}}:hover > .elementor-background-video-container::before' => 'background-color: {{VALUE}};',

            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}:hover > .e-con-inner > .elementor-background-video-container::before' => 'background-color: {{VALUE}};',
            '} body.tcg-dark-mode {{WRAPPER}}:hover > .e-con-inner > .elementor-background-video-container::before' => 'background-color: {{VALUE}};',

            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} > .e-con-inner > .elementor-background-slideshow:hover::before' => 'background-color: {{VALUE}};',
            '} body.tcg-dark-mode {{WRAPPER}} > .e-con-inner > .elementor-background-slideshow:hover::before' => 'background-color: {{VALUE}};',

            '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} > .elementor-motion-effects-container > .elementor-motion-effects-layer:hover::before' => 'background-color: {{VALUE}};',
            '} body.tcg-dark-mode {{WRAPPER}} > .elementor-motion-effects-container > .elementor-motion-effects-layer:hover::before' => 'background-color: {{VALUE}};',
        ];

        $background_overlay_hover_selector = '{{WRAPPER}}:hover::before, {{WRAPPER}}:hover > .elementor-background-video-container::before, {{WRAPPER}}:hover > .e-con-inner > .elementor-background-video-container::before, {{WRAPPER}} > .elementor-background-slideshow:hover::before, {{WRAPPER}} > .e-con-inner > .elementor-background-slideshow:hover::before';

        $widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tc_container_background_overlay_hover_dark_mode',
                'selector' => '{{WRAPPER}}:hover > .elementor-element-populated >  .elementor-background-overlay',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'fields_options' => [
                    'background' => [
                        'selectors' => [
                            // Hack to set the `::before` content in order to render it only when there is a background overlay.
                            $background_overlay_hover_selector => '--background-overlay: \'\';',
                        ],
                    ],
                    'color' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-color: {{VALUE}};'),
                    ],
                    'gradient_angle' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})'),
                    ],
                    'gradient_position' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})'),
                    ],
                    'image' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-image: url("{{URL}}");'),
                    ],
                    'position' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-position: {{VALUE}};'),
                    ],
                    'xpos' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-position: {{SIZE}}{{UNIT}} {{ypos.SIZE}}{{ypos.UNIT}}'),
                    ],
                    'ypos' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-position: {{xpos.SIZE}}{{xpos.UNIT}} {{SIZE}}{{UNIT}}'),
                    ],
                    'attachment' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-attachment: {{VALUE}};'),
                    ],
                    'repeat' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-repeat: {{VALUE}};'),
                    ],
                    'size' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-size: {{VALUE}};'),
                    ],
                    'bg_width' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background-size: {{SIZE}}{{UNIT}} auto'),
                    ],
                    'video_fallback' => [
                        'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, 'background: url("{{URL}}") 50% 50%; background-size: cover;'),
                    ],
                ]
            ]
        );

        $widget->add_responsive_control(
            'tc_container_background_overlay_opacity_hover_dark_mode',
            [
                'label' => esc_html__('Opacity', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => .5,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => $this->tc_selectors_refactor($tc_container_background_overlay_hover_selectors, '--overlay-opacity: {{SIZE}};'),
                'condition' => [
                    'tc_container_background_overlay_hover_dark_mode_background' => ['classic', 'gradient'],
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();
    }

    function register_tc_container_border_controls($widget, $args)
    {

        $widget->add_control(
            'advanced_border_popover-toggle',
            [
                'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
                'label' => esc_html__('Custom Border Settings', 'themescamp-elements'),
                'label_off' => esc_html__('Default', 'themescamp-elements'),
                'label_on' => esc_html__('Custom', 'themescamp-elements'),
                'return_value' => 'yes',
            ]
        );

        $widget->start_popover();
        $widget->add_control(
            'advanced_border_top_style',
            [
                'label' => esc_html__('Border Top Style', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'themescamp-elements'),
                    'none' => esc_html__('None', 'themescamp-elements'),
                    'solid' => esc_html__('Solid', 'themescamp-elements'),
                    'double' => esc_html__('Double', 'themescamp-elements'),
                    'dashed' => esc_html__('Dashed', 'themescamp-elements'),
                    'dotted' => esc_html__('Dotted', 'themescamp-elements'),
                    'groove' => esc_html__('Groove', 'themescamp-elements'),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'border-top-style: {{VALUE}};',
                ],
            ]
        );
        $widget->add_control(
            'advanced_border_top_color',
            [
                'label' => esc_html__('Border Top Color', 'themescamp-elements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );
        $widget->add_control(
            'advanced_border_top_width',
            [
                'label' => esc_html__('Border Top Width', 'themescamp-elements'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}' => 'border-top-width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
            ]
        );
        $widget->add_control(
            'border_bottom_separator_border',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );
        $widget->add_control(
            'advanced_border_bottom_style',
            [
                'label' => esc_html__('Border Bottom Style', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'themescamp-elements'),
                    'none' => esc_html__('None', 'themescamp-elements'),
                    'solid' => esc_html__('Solid', 'themescamp-elements'),
                    'double' => esc_html__('Double', 'themescamp-elements'),
                    'dashed' => esc_html__('Dashed', 'themescamp-elements'),
                    'dotted' => esc_html__('Dotted', 'themescamp-elements'),
                    'groove' => esc_html__('Groove', 'themescamp-elements'),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'border-bottom-style: {{VALUE}};',
                ],
            ]
        );
        $widget->add_control(
            'advanced_border_bottom_color',
            [
                'label' => esc_html__('Border Bottom Color', 'themescamp-elements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );
        $widget->add_control(
            'advanced_border_bottom_width',
            [
                'label' => esc_html__('Border Bottom Width', 'themescamp-elements'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
            ]
        );
        $widget->add_control(
            'border_right_separator_border',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );
        $widget->add_control(
            'advanced_border_right_style',
            [
                'label' => esc_html__('Border Right Style', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'themescamp-elements'),
                    'none' => esc_html__('None', 'themescamp-elements'),
                    'solid' => esc_html__('Solid', 'themescamp-elements'),
                    'double' => esc_html__('Double', 'themescamp-elements'),
                    'dashed' => esc_html__('Dashed', 'themescamp-elements'),
                    'dotted' => esc_html__('Dotted', 'themescamp-elements'),
                    'groove' => esc_html__('Groove', 'themescamp-elements'),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'border-right-style: {{VALUE}};',
                ],
            ]
        );
        $widget->add_control(
            'advanced_border_right_color',
            [
                'label' => esc_html__('Border Right Color', 'themescamp-elements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => 'border-right-color: {{VALUE}};',
                ],
            ]
        );
        $widget->add_control(
            'advanced_border_right_width',
            [
                'label' => esc_html__('Border Right Width', 'themescamp-elements'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}' => 'border-right-width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
            ]
        );
        $widget->add_control(
            'border_left_separator_border',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );
        $widget->add_control(
            'advanced_border_left_style',
            [
                'label' => esc_html__('Border Left Style', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'themescamp-elements'),
                    'none' => esc_html__('None', 'themescamp-elements'),
                    'solid' => esc_html__('Solid', 'themescamp-elements'),
                    'double' => esc_html__('Double', 'themescamp-elements'),
                    'dashed' => esc_html__('Dashed', 'themescamp-elements'),
                    'dotted' => esc_html__('Dotted', 'themescamp-elements'),
                    'groove' => esc_html__('Groove', 'themescamp-elements'),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'border-left-style: {{VALUE}};',
                ],
            ]
        );
        $widget->add_control(
            'advanced_border_left_color',
            [
                'label' => esc_html__('Border Left Color', 'themescamp-elements'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => 'border-left-color: {{VALUE}};',
                ],
            ]
        );
        $widget->add_control(
            'advanced_border_left_width',
            [
                'label' => esc_html__('Border Left Width', 'themescamp-elements'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}' => 'border-left-width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
            ]
        );

        $widget->end_popover();

        $widget->add_control(
            'tc_container_border_divider_dark_mode',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $widget->add_control(
            'tc_container_border_title_dark_mode',
            [
                'label' => esc_html__('TCG Dark Mode Border', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'none',
            ]
        );
        $widget->start_controls_tabs('_tabs_tc_container_border_dark_mode');
        $widget->start_controls_tab(
            '_tab_tc_container_border_normal_dark_mode',
            [
                'label' => esc_html__('Normal', 'themescamp-core'),
            ]
        );
        $widget->add_control(
            'tc_container_border_color_dark_mode',
            [
                'label' => esc_html__('Border Color (Dark Mode)', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}}' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $widget->end_controls_tab();
        $widget->start_controls_tab(
            '_tab_tc_container_border_hover_dark_mode',
            [
                'label' => esc_html__('Hover', 'themescamp-core'),
            ]
        );
        $widget->add_control(
            'tc_container_border_color_dark_mode_hover',
            [
                'label' => esc_html__('Border Color (Dark Mode)', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}}:hover' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}}:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $widget->end_controls_tab();
        $widget->end_controls_tabs();
    }

    function register_tc_container_additional_options_controls($widget, $args)
    {

        $widget->add_control(
            'tc_container_pointers_events',
            [
                'label' => esc_html__('Pointer Events', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''  => esc_html__('Default', 'themescamp-elements'),
                    'auto'  => esc_html__('Auto', 'themescamp-elements'),
                    'none'  => esc_html__('None', 'themescamp-elements'),
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'pointer-events: {{VALUE}};',
                ],
            ]
        );
    }
}
