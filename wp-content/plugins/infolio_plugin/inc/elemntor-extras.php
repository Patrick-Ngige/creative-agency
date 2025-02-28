<?php
namespace Elementor;

class Infolio_Extend_section {

    public function __construct() {

        /**
         * Section Controls
         */
        add_action( 'elementor/element/section/section_advanced/after_section_end', [$this, 'register_section_controls'] );
    }

    /**
     * Section Controls
     */
    public function register_section_controls( Controls_Stack $element ) {
        $element->start_controls_section(
            'infolio_onepagescroll_section',
            [
                'label'         => esc_html__( 'Infolio Sticky Settings', 'infolio_plg' ),
                'tab'           => Controls_Manager::TAB_ADVANCED,
                'hide_in_inner' => false,
            ]
        );
        // $element->add_control(
        //     'infolio_is_sticky',
        //     [
        //         'label'                 => esc_html__( 'Enable Sticky', 'infolio_plg' ),
        //         'type'                  => Controls_Manager::SWITCHER,
        //         'frontend_available'    => true,
        //         'return_value'          => 'section',
        //         'prefix_class'          => 'infolio-sticky-', 
        //     ]
        // );

		$element->add_control(
			'sticky',
			[
				'label' => __( 'Sticky', 'infolio_plg' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'infolio_plg' ),
					'top' => __( 'Top', 'infolio_plg' ),
				],
				'separator' => 'before',
				'render_type' => 'none',
				'frontend_available' => true,
				'prefix_class'          => 'infolio-sticky-',
			]
		);

        $element->add_control(
            'sticky_background',
            [
                'label'     => __( 'Background Scroll', 'infolio_plg' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-section.is-stuck' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'sticky' => 'top',
                ],
            ]
        );

        // $element->add_control(
        //     'sticky_background4',
        //     [
        //         'label'     => __( 'Background Scroll', 'infolio_plg' ),
        //         'type'      => Controls_Manager::COLOR,
        //         'selectors' => [
        //             '{{WRAPPER}}.elementor-section' => 'background: {{VALUE}};',
        //             '{{WRAPPER}}.elementor-section' => 'background: linear-gradient( #12c2e9, #c471ed, #f64f59);',
        //         ],
        //         'condition' => [
        //             'sticky' => 'top',
        //         ],
        //     ]
        // );
        
        $element->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'scroll_box_shadow',
                'label'     => __( 'Scroll Shadow', 'infolio_plg' ),
                'selector' => '{{WRAPPER}} .elementor-section.is-stuck',
            ]
        );


        $element->add_responsive_control(
            'offset_space',
            [
                'label' => __( 'Offset', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.is-stuck' => 'top: {{SIZE}}{{UNIT}};',
                    '.admin-bar {{WRAPPER}}.is-stuck' => 'top: calc({{SIZE}}{{UNIT}} + 32px);', 
                ],
                'condition' => [
                    'sticky' => 'top',
                ],
            ]
        );

        $element->add_control(
            'separator_panel_style',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $element->add_control(
            'enable_gradient',
            [
                'label' => __( 'Enable Gradient (3rd)', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __( 'Yes', 'infolio_plg' ),
                'label_off' => __( 'No', 'infolio_plg' ),
                'return_value' => 'yes',
                'default' => false,
            ]
        );

        $element->add_control(
            'color',
            [
                'label' => _x( 'Gradient Color', 'Background Control', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'title' => _x( 'Background Color', 'Background Control', 'infolio_plg' ),
                'condition' => [
                    'enable_gradient' => [ 'yes'],
                ],
            ]
        );


        $element->add_control(
            'color_stop', 
            [
                'label' => _x( 'Location', 'Background Control', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'render_type' => 'ui',
                'condition' => [
                    'enable_gradient' => [ 'yes'],
                ],
                'of_type' => 'gradient',
            ]
        );
        $element->add_control(
            'color_a',
            [
                'label' => _x( 'Second Color', 'Background Control', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f2295b',
                'render_type' => 'ui',
                'condition' => [
                    'enable_gradient' => [ 'yes'],
                ],
                'of_type' => 'gradient',
            ]
        );

        $element->add_control(
            'color_a_stop', 
            [
                'label' => _x( 'Location', 'Background Control', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'render_type' => 'ui',
                'condition' => [
                    'enable_gradient' => [ 'yes'],
                ],
                'of_type' => 'gradient',
            ]
        );

        $element->add_control(
            'color_b',
            [
                'label' => _x( 'Second Color', 'Background Control', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f2295b',
                'render_type' => 'ui',
                'condition' => [
                    'enable_gradient' => [ 'yes'],
                ],
                'of_type' => 'gradient',
            ]
        );

        $element->add_control(
            'color_b_stop', 
            [
                'label' => _x( 'Location', 'Background Control', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'render_type' => 'ui',
                'condition' => [
                    'enable_gradient' => [ 'yes'],
                ],
                'of_type' => 'gradient',
            ]
        );

        $element->add_control(
            'gradient_type', 
            [
                'label' => _x( 'Type', 'Background Control', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'linear' => _x( 'Linear', 'Background Control', 'infolio_plg' ),
                    'radial' => _x( 'Radial', 'Background Control', 'infolio_plg' ),
                ],
                'default' => 'linear',
                'render_type' => 'ui',
                'condition' => [
                    'enable_gradient' => [ 'yes'],
                ],
                'of_type' => 'gradient',
            ]
        );

        $element->add_control(
            'gradient_angle', 
            [
                'label' => _x( 'Angle', 'Background Control', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg' ],
                'default' => [
                    'unit' => 'deg',
                    'size' => 180,
                ],
                'range' => [
                    'deg' => [
                        'step' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-section' => 'background: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}},{{color_a.VALUE}} {{color_a_stop.SIZE}}{{color_a_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}});',
                ],

                'condition' => [
                    'enable_gradient' => [ 'yes'],
                    'gradient_type' => 'linear',
                ],
                'of_type' => 'gradient',
            ]
        );


        $element->end_controls_section();
    }
}
new Infolio_Extend_section();
?>