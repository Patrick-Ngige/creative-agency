<?php
namespace ThemescampPlugin\Elementor\Elements\Widgets;
if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class TCG_Offcanvas extends Widget_Base {

    /**
     * Retrieve the widget name.
     */
	public function get_name(){
		return 'tcg-offcanvas';
	}

   //script depend
    public function get_script_depends() { 
        return [ 'offcanvas']; 
    }

    /**
     * Retrieve the widget title.
     */
	public function get_title(){
		return __('TC Offcanvas', 'themescamp-core');
	}

    /**
     * Retrieve the widget icon.
     */
	public function get_icon(){
		return 'eicon-button';
	}

    /**
     * Retrieve the list of categories the widget belongs to.
     */
	public function get_categories(){
		return ['themescamp-elements'];
	}

    /**
     * Get widget keywords.
     */
    public function get_keywords() {
        return ['themescamp', 'sidepanel', 'header', 'canvas', 'panel', 'slide'];
    }

    /**
     * Register the widget controls.
     */
	protected function register_controls(){


        $this->start_controls_section(
            'widget_content',
            [
                'label' => esc_html__( 'General', 'themescamp-core' ),
            ]
        );


		$offcanvas =themescamp_offcanvas_choices();

		if ( ! empty( $offcanvas ) ) {
			$this->add_control(
				'tcg_offcanvas_id',
				[
					'label'   => __( 'Select Offcanvas', 'themescamp-core' ),
					'type'    => Controls_Manager::SELECT, 
					'options' => $offcanvas,
					'default' => array_keys( $offcanvas )[0],
				]
			);
		}else {
			$this->add_control(
				'tcg_offcanvas_info',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . __( 'There are no Offcanvas in your site.', 'themescamp-core' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Theme Builder</a> to create one.', 'themescamp-core' ), admin_url( 'edit.php?post_type=tcg_teb' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}

       $this->add_control(
            'tcg_offcanvas_icons',
            [
                'label' => esc_html__('Select Icon', 'themescamp-core'),
                'fa4compatibility' => 'tcg_offcanvas_icon',
				'default' => [
					'value' => 'fas fa-th',
					'library' => 'fa-solid',
				],
                'label_block' => true,
                'type' => Controls_Manager::ICONS,

            ]
        );

        $this->add_control(
            'toggle_align',
            [
                'label'   => esc_html__( 'Toggle Alignment', 'themescamp-core' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'themescamp-core' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-core' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'themescamp-core' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'right',
                'toggle'  => false,
            ]
        );

        $this->add_control( 
            'canvas_position',
            [
                'label'   => esc_html__( 'Canvas Animation', 'themescamp-core' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'left'  => esc_html__( 'Slide Left', 'themescamp-core' ),
                    'right' => esc_html__( 'Slide Right', 'themescamp-core' ),
                    'fade' => esc_html__( 'Fade', 'themescamp-core' ),
                ],
                'default' => 'right',
            ]
        );

        $this->add_control(
            'toggle_side_content',
            [
                'label'   => esc_html__( 'Toggle Side Content', 'themescamp-core' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'none'   => [
                        'title' => esc_html__( 'None', 'themescamp-core' ),
                        'icon'  => 'eicon-ban',
                    ],
                    'text' => [
                        'title' => esc_html__( 'Text', 'themescamp-core' ),
                        'icon'  => 'eicon-heading',
                    ]
                ],
                'default' => 'none',
                'toggle'  => false,
            ]
        );

        $this->add_control(
            'toggle_side_content_text_position',
            [
                'label'   => esc_html__( 'Toggle Side Content', 'themescamp-core' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'themescamp-core' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'themescamp-core' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle'  => false,
                'condition' => [
                    'toggle_side_content' => 'text'
                ]
            ]
        );

		$this->add_control(
			'toggle_side_content_text',
			[
				'label' => __('Toggle Text', 'tcgbase_plg'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
				'default' => 'Menu',
                'condition' => [
                    'toggle_side_content' => 'text'
                ]
			]
		);


        $this->end_controls_section();


        $this->start_controls_section(
            'section_toggle_style',
            [
                'label' => esc_html__( 'Toggle', 'themescamp-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
			'toggle_size',
			[
				'label' => esc_html__( 'Toggle Size', 'themescamp-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'toggle_height',
			[
				'label' => esc_html__( 'Toggle Height', 'themescamp-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle svg' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'toggle_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'themescamp-core' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->start_controls_tabs( 'toggle_tab' );

        $this->start_controls_tab(
            'normal_tab',
            [
                'label' => esc_html__( 'Normal', 'themescamp-core' ),
            ]
        );

        $this->add_control(
            'toggle_color',
            [
                'label'     => esc_html__( 'Color', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle .offcanvas-button-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'toggle_bg',
            [
                'label'     => esc_html__( 'Background', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'toggle_border',
				'selector' => '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle',
			]
		);

		$this->add_responsive_control(
			'toggle_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'themescamp-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

        $this->add_control(
            'toggle_divider_dark_mode',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
			'toggle_title_dark_mode',
			[
				'label' => esc_html__( 'Dark Mode Controls', 'themescamp-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

        $this->add_control(
            'toggle_color_dark_mode',
            [
                'label'     => esc_html__( 'Color', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle svg path' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle svg path' => 'fill: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle i' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'toggle_bg_dark_mode',
            [
                'label'     => esc_html__( 'Background', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'toggle_border_dark_mode',
            [
                'label'     => esc_html__( 'Border', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover_tab',
            [
                'label' => esc_html__( 'Hover', 'themescamp-core' ),
            ]
        );

        $this->add_control(
            'toggle_hover_color',
            [
                'label'     => esc_html__( 'Color', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover .offcanvas-button-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'toggle_hover_bg',
            [
                'label'     => esc_html__( 'Background', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'toggle_border_hover',
				'selector' => '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover',
			]
		);

		$this->add_responsive_control(
			'toggle_border_radius_hover',
            [
                'label'      => esc_html__( 'Border Radius', 'themescamp-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

        $this->add_control(
            'toggle_title_dark_mode_hover',
            [
                'label' => esc_html__( 'Dark Mode Controls', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'toggle_color_dark_mode_hover',
            [
                'label'     => esc_html__( 'Color', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover svg path' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover svg path' => 'fill: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover i' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'toggle_bg_dark_mode_hover',
            [
                'label'     => esc_html__( 'Background', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'toggle_border_dark_mode_hover',
            [
                'label'     => esc_html__( 'Border', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-toggle:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'close_style',
            [
                'label' => esc_html__( 'Close', 'themescamp-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'close_width_height',
            [
                'label'      => esc_html__( 'Size', 'themescamp-core' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-close svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-close i' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'close_container_width_height',
            [
                'label'      => esc_html__( 'Close Container Size', 'themescamp-core' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'close_icon_width_height',
            [
                'label'      => esc_html__( 'Close Icon Size', 'themescamp-core' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-close svg' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-close i' => 'font-size: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_control(
            'close_bg',
            [
                'label'     => esc_html__( 'Background', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'close_color',
            [
                'label'     => esc_html__( 'Color', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'close_border',
                'selector' => '{{WRAPPER}} .tcg-offcanvas .offcanvas-close',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'close_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'close_divider_dark_mode',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
			'close_title_dark_mode',
			[
				'label' => esc_html__( 'Dark Mode Controls', 'themescamp-core' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'none',
			]
		);

        $this->add_control(
            'close_bg_dark_mode',
            [
                'label'     => esc_html__( 'Background', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'close_color_dark_mode',
            [
                'label'     => esc_html__( 'Color', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'fill: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'color: {{VALUE}};',
                ],
            ]
        );

        $start = is_rtl() ? esc_html__( 'Right', 'elementor' ) : esc_html__( 'Left', 'elementor' );
		$end = ! is_rtl() ? esc_html__( 'Right', 'elementor' ) : esc_html__( 'Left', 'elementor' );

		$this->add_control(
			'close_offset_orientation_h',
			[
				'label' => esc_html__( 'Horizontal Orientation', 'elementor' ),
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
			'close_offset_x',
			[
				'label' => esc_html__( 'Offset', 'elementor' ),
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
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'vh', 'custom' ],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'left: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'close_offset_orientation_h!' => 'end',
				],
			]
		);

		$this->add_responsive_control(
			'close_offset_x_end',
			[
				'label' => esc_html__( 'Offset', 'elementor' ),
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
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'vh', 'custom' ],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'left: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'close_offset_orientation_h' => 'end',
				],
			]
		);

		$this->add_control(
			'close_offset_orientation_v',
			[
				'label' => esc_html__( 'Vertical Orientation', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'toggle' => false,
				'default' => 'start',
				'options' => [
					'start' => [
						'title' => esc_html__( 'Top', 'elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'end' => [
						'title' => esc_html__( 'Bottom', 'elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'render_type' => 'ui',
			]
		);

		$this->add_responsive_control(
			'close_offset_y',
			[
				'label' => esc_html__( 'Offset', 'elementor' ),
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
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'close_offset_orientation_v!' => 'end',
				],
			]
		);

		$this->add_responsive_control(
			'close_offset_y_end',
			[
				'label' => esc_html__( 'Offset', 'elementor' ),
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
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .tcg-offcanvas .offcanvas-close' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'close_offset_orientation_v' => 'end',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'canvas_style',
            [
                'label' => esc_html__( 'Canvas', 'themescamp-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'overly_color',
            [
                'label'     => esc_html__( 'Overly Color', 'themescamp-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-offcanvas-wrapper .offcanvas-overly' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'canvas_width',
            [
                'label'       => esc_html__( 'Width', 'themescamp-core' ),
                'type'        => Controls_Manager::NUMBER,
                'label_block' => false,
                'min'         => 100,
                'max'         => 2000,
                'selectors'   => [
                    '{{WRAPPER}} .tcg-offcanvas-wrapper .offcanvas-container' => 'width: {{VALUE}}px;',
                ],
            ]
        );

        $start = is_rtl() ? esc_html__( 'Right', 'elementor' ) : esc_html__( 'Left', 'elementor' );
		$end = ! is_rtl() ? esc_html__( 'Right', 'elementor' ) : esc_html__( 'Left', 'elementor' );

		$this->add_control(
			'canvas_offset_orientation_h',
			[
				'label' => esc_html__( 'Horizontal Orientation', 'elementor' ),
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
			'canvas_offset_x',
			[
				'label' => esc_html__( 'Offset', 'elementor' ),
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
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'vh', 'custom' ],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .tcg-offcanvas .tcg-offcanvas-wrapper' => 'left: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .tcg-offcanvas .tcg-offcanvas-wrapper' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'canvas_offset_orientation_h!' => 'end',
				],
			]
		);

		$this->add_responsive_control(
			'canvas_offset_x_end',
			[
				'label' => esc_html__( 'Offset', 'elementor' ),
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
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'vh', 'custom' ],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .tcg-offcanvas .tcg-offcanvas-wrapper' => 'right: {{SIZE}}{{UNIT}}',
					'body.rtl {{WRAPPER}} .tcg-offcanvas .tcg-offcanvas-wrapper' => 'left: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'canvas_offset_orientation_h' => 'end',
				],
			]
		);

		$this->add_control(
			'canvas_offset_orientation_v',
			[
				'label' => esc_html__( 'Vertical Orientation', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'toggle' => false,
				'default' => 'start',
				'options' => [
					'start' => [
						'title' => esc_html__( 'Top', 'elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'end' => [
						'title' => esc_html__( 'Bottom', 'elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'render_type' => 'ui',
			]
		);

		$this->add_responsive_control(
			'canvas_offset_y',
			[
				'label' => esc_html__( 'Offset', 'elementor' ),
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
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .tcg-offcanvas .tcg-offcanvas-wrapper' => 'top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'canvas_offset_orientation_v!' => 'end',
				],
			]
		);

		$this->add_responsive_control(
			'canvas_offset_y_end',
			[
				'label' => esc_html__( 'Offset', 'elementor' ),
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
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'vw', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .tcg-offcanvas .tcg-offcanvas-wrapper' => 'bottom: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'canvas_offset_orientation_v' => 'end',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'side_content_text_style',
            [
                'label' => esc_html__( 'Text Style', 'themescamp-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'side_content_text_typography',
				'selector' => '{{WRAPPER}} .tcg-offcanvas .offcanvas-button-text',
			]
		);

		$this->add_responsive_control(
			'side_content_text_margin',
            [
                'label'      => esc_html__( 'Margin', 'themescamp-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-offcanvas .offcanvas-button-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
		);

        $this->end_controls_section();
	}

    /**
     * Render the widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( ! $settings['tcg_offcanvas_id'] ) {
            return;
        }

        // Retrieving the width from the post meta data
        $Post_meta = get_post_meta( $settings['tcg_offcanvas_id']);
        //$pre_width = maybe_unserialize($Post_meta['tcg_set_offcanvas_width'][0]);

        $pre_width = isset($Post_meta['tcg_set_offcanvas_width'][0]) 
        ? maybe_unserialize($Post_meta['tcg_set_offcanvas_width'][0]) 
        : 430;

        $width =$pre_width['width'] ?? '430px';

        $this->add_render_attribute( 'toggle', [
            'class' => 'offcanvas-toggle toggle-' . esc_attr( $settings['toggle_align'] ),
        ] );

        ?>
        <div class="tcg-offcanvas">
            <button type="button" <?php echo $this->get_render_attribute_string( 'toggle' ); ?>>
                <?php if($settings['toggle_side_content'] == 'text' && $settings['toggle_side_content_text_position'] == 'left'): ?>
                <span class="offcanvas-button-text"><?php esc_html_e($settings['toggle_side_content_text']) ?></span>
                <?php endif; ?>
            	<?php Icons_Manager::render_icon( $settings['tcg_offcanvas_icons'], [ 'aria-hidden' => 'true' ] );?>
                <?php if($settings['toggle_side_content'] == 'text' && $settings['toggle_side_content_text_position'] == 'right'): ?>
                <span class="offcanvas-button-text"><?php esc_html_e($settings['toggle_side_content_text']) ?></span>
                <?php endif; ?>
            </button>

    <?php

            ob_start();
            echo Plugin::$instance->frontend->get_builder_content_for_display( $settings['tcg_offcanvas_id'], true );
            $offcanvas_content = ob_get_clean();

            // Extract style tags
            $style_start = strpos($offcanvas_content, '<style>');
            $style_end = strpos($offcanvas_content, '</style>') + strlen('</style>'); // include the closing tag

            if ($style_start !== false && $style_end !== false) {
                $style_content = substr($offcanvas_content, $style_start, $style_end - $style_start);
                $offcanvas_content = str_replace($style_content, '', $offcanvas_content); // Remove the style from the content

                // Save style content to be added in head
                $GLOBALS['tcg_custom_offcanvas_styles'] = $style_content;
        }

    ?>

<div class="tcg-offcanvas-wrapper offcanvas-<?php echo esc_attr( $settings['canvas_position'] ) ?>">
    <div class="offcanvas-overly"></div>
    <div class="offcanvas-container" style="width: <?php echo esc_attr( $width ) ?>;">
        <div class="offcanvas-close 255"><i class="fal fa-times"></i></div>
        <?php 
        // Print the content without style tags
        echo $offcanvas_content;

        ?>
    </div>
</div>
        </div>
        <?php
	}

}