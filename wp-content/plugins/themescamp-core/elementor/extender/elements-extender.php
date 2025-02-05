<?php

namespace ThemescampPlugin\Elementor;

use Elementor\Controls_Manager;
use Elementor\Plugin;

defined('ABSPATH') || exit(); // Exit if accessed directly

/**
 *  Elementor extra features
 */
class TCG_Elements_Extender
{

    public function __construct()
    {

        // add elements 3 gradient colors background
        add_action('elementor/element/common/_section_background/before_section_end', function ($stack) {

            $section_bg = Plugin::instance()->controls_manager->get_control_from_stack($stack->get_unique_name(), '_background_background');
            $section_bg['options']['tcg_gradient'] = [
                'title' => esc_html__('3 Colors Gradient', 'elementor'),
                'icon' => 'eicon-barcode',
            ];
            $stack->update_control('_background_background', $section_bg);
        }, 10, 3);

        // elements controls
        add_action('elementor/element/before_section_end', [$this, 'register_tc_element_background_controls'], 10, 3);
        add_action('elementor/element/before_section_end', [$this, 'register_tc_element_border_controls'], 10, 3);
        add_action('elementor/element/after_section_end', [$this, 'register_tc_dark_mode_responsive_controls'], 10, 3);
    }

    function register_tc_element_background_controls($widget, $widget_id, $args)
    {
        static $widgets = [
            '_section_background', /* Section */
        ];

        if (!in_array($widget_id, $widgets)) {
            return;
        }

        $widget->add_control(
            'tc_element_background_divider_dark_mode',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $widget->add_control(
            'tc_element_background_title_dark_mode',
            [
                'label' => esc_html__('TCG Dark Mode Background', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'none',
            ]
        );

        $widget->start_controls_tabs('_tabs_tc_element_background_dark_mode');

        $widget->start_controls_tab(
            '_tab_tc_element_background_normal_dark_mode',
            [
                'label' => esc_html__('Normal', 'themescamp-core'),
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tc_element_background_dark_mode',
                'selector' => '{{WRAPPER}} > .elementor-widget-container',
				'types' => [ 'classic', 'gradient', 'tcg_gradient' ],
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
            '_tab_tc_element_background_hover_dark_mode',
            [
                'label' => esc_html__('Hover', 'themescamp-core'),
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tc_element_background_hover_dark_mode',
                'selector' => '{{WRAPPER}} > .elementor-widget-container:hover',
				'types' => [ 'classic', 'gradient', 'tcg_gradient' ],
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

        $widget->add_control(
            'tc_element_background_blur_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $widget->add_control(
            'tc_element_background_blur',
            [
                'label' => esc_html__('TCG Background Blur', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 250,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} > .elementor-widget-container' => 'backdrop-filter: blur({{SIZE}}px);',
                ],
            ]
        );
    }

    function register_tc_element_border_controls($widget, $widget_id, $args)
    {
        static $widgets = [
            '_section_border', /* Section */
        ];

        if (!in_array($widget_id, $widgets)) {
            return;
        }

        $widget->add_control(
            'tc_element_border_divider_dark_mode',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $widget->add_control(
            'tc_element_border_title_dark_mode',
            [
                'label' => esc_html__('TCG Dark Mode Border', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'none',
            ]
        );

        $widget->add_control(
            'tc_element_border_color_dark_mode',
            [
                'label' => esc_html__('Border Color (Dark Mode)', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} > .elementor-widget-container' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} > .elementor-widget-container' => 'border-color: {{VALUE}};',
                ],
            ]
        );
    }

    function register_tc_dark_mode_responsive_controls($widget, $widget_id, $args)
    {
        static $widgets = [
            '_section_responsive', /* Section */
        ];

        if (!in_array($widget_id, $widgets)) {
            return;
        }

        $widget->start_controls_section(
            'tc_dark_mode_responsive_section',
            [
                'label' => __('TCG Dark Mode Responsive', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );

        $widget->add_control(
            'tc_dark_mode_responsive_hide_in_dark',
            [
                'label' => esc_html__('Hide in Dark Mode', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themescamp-core'),
                'label_off' => esc_html__('Hide', 'themescamp-core'),
                'return_value' => 'yes',
                'default' => 'no',
                'frontend_available' => true,
            ]
        );

        $widget->add_control(
            'tc_dark_mode_responsive_hide_in_light',
            [
                'label' => esc_html__('Hide in Light Mode', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themescamp-core'),
                'label_off' => esc_html__('Hide', 'themescamp-core'),
                'return_value' => 'yes',
                'default' => 'no',
                'frontend_available' => true,
            ]
        );

        $widget->end_controls_section();
    }
}
