<?php

namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class TCG_Post_Image extends Widget_Base
{


    public function get_name()
    {
        // `theme` prefix is to avoid conflicts with a dynamic-tag with same name.
        return 'tcg-post-featured-image';
    }

    public function get_title()
    {
        return esc_html__('TC Post Image', 'themescamp-core');
    }

    public function get_icon()
    {
        return 'eicon-featured-image';
    }

    public function get_categories()
    {
        return ['themescamp-elements'];
    }

    public function get_keywords()
    {
        return ['image', 'featured', 'thumbnail'];
    }

    public function get_inline_css_depends()
    {
        return [
            [
                'name' => 'image',
                'is_core_dependency' => true,
            ],
        ];
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
        return ['container-hover'];
    }


    protected function register_controls()
    {

        $this->start_controls_section(
            'image_settings',
            [
                'label' => __('Image Settings', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'link_to',
            [
				'label' => esc_html__( 'Link', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'elementor'),
                    'custom' => esc_html__('Custom URL', 'elementor'),
                    'post-url' => esc_html__('Post URL', 'elementor'),
                ],
            ]
        );

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

        $this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
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
					'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => esc_html__( 'Max Width', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
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
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-fit',
			[
				'label' => esc_html__( 'Object Fit', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'height[size]!' => '',
				],
				'options' => [
					'' => esc_html__( 'Default', 'elementor' ),
					'fill' => esc_html__( 'Fill', 'elementor' ),
					'cover' => esc_html__( 'Cover', 'elementor' ),
					'contain' => esc_html__( 'Contain', 'elementor' ),
					'scale-down' => esc_html__( 'Scale Down', 'elementor' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-position',
			[
				'label' => esc_html__( 'Object Position', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'center center' => esc_html__( 'Center Center', 'elementor' ),
					'center left' => esc_html__( 'Center Left', 'elementor' ),
					'center right' => esc_html__( 'Center Right', 'elementor' ),
					'top center' => esc_html__( 'Top Center', 'elementor' ),
					'top left' => esc_html__( 'Top Left', 'elementor' ),
					'top right' => esc_html__( 'Top Right', 'elementor' ),
					'bottom center' => esc_html__( 'Bottom Center', 'elementor' ),
					'bottom left' => esc_html__( 'Bottom Left', 'elementor' ),
					'bottom right' => esc_html__( 'Bottom Right', 'elementor' ),
				],
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} img' => 'object-position: {{VALUE}};',
				],
				'condition' => [
					'height[size]!' => '',
					'object-fit' => [ 'cover', 'contain', 'scale-down' ],
				],
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'elementor' ),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => esc_html__( 'Opacity', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} img',
			]
		);

        $this->add_control(
            'additional_hover_controls',
            [
                'label' => esc_html__('Additional Hover Options', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'post_image_translate_y',
            [
                'label' => esc_html__( 'Translate Y', 'themescamp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'custom'],
            ]
        );
        $this->add_control(
            'post_image_rotate',
            [
                'label' => esc_html__( 'Rotate', 'themescamp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg', 'custom'],
                'default' => [
                    'unit' => 'deg',
                    'size' => '0',
                ],
            ]
        );
        $this->add_control(
            'post_image_translate_x',
            [
                'label' => esc_html__( 'Translate X', 'themescamp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image' => 'transform:  rotate({{post_image_rotate.SIZE}}{{post_image_rotate.UNIT}}) translate({{post_image_translate_x.SIZE}}{{post_image_translate_x.UNIT}},{{post_image_translate_y.SIZE}}{{post_image_translate_y.UNIT}})',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'elementor' ),
			]
		);
		$this->add_control(
			'opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover img' => 'opacity: {{SIZE}};',
                    '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-post-image.selector-type-container.tcg-post-image-container-active img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}}:hover img',
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'elementor' ) . ' (s)',
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'transition-duration: {{SIZE}}s',
					'{{WRAPPER}} .tcg-post-image' => 'transition-duration: {{SIZE}}s',
                    '{{WRAPPER}} img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

        $this->add_control(
            'additional_hover_controls_hover',
            [
                'label' => esc_html__('Additional Hover Options', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'post_image_translate_y_hover',
            [
                'label' => esc_html__( 'Translate Y', 'themescamp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'custom'],
            ]
        );
        $this->add_control(
            'post_image_rotate_hover',
            [
                'label' => esc_html__( 'Rotate', 'themescamp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'deg', 'custom'],
                'default' => [
                    'unit' => 'deg',
                    'size' => '0',
                ],
            ]
        );
        $this->add_control(
            'post_image_translate_x_hover',
            [
                'label' => esc_html__( 'Translate X', 'themescamp-elements' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image:hover' => 'transform: rotate({{post_image_rotate_hover.SIZE}}{{post_image_rotate_hover.UNIT}}) translate({{post_image_translate_x_hover.SIZE}}{{post_image_translate_x_hover.UNIT}},{{post_image_translate_y_hover.SIZE}}{{post_image_translate_y_hover.UNIT}})',
                    '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-post-image.selector-type-container.tcg-post-image-container-active' => 'transform:  rotate({{post_image_rotate_hover.SIZE}}{{post_image_rotate_hover.UNIT}}) translate({{post_image_translate_x_hover.SIZE}}{{post_image_translate_x_hover.UNIT}},{{post_image_translate_y_hover.SIZE}}{{post_image_translate_y_hover.UNIT}})',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'selectors' => [
					'{{WRAPPER}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label' => esc_html__( 'Caption', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'image[url]!' => '',
					'caption_source!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'caption_align',
			[
				'label' => esc_html__( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
			]
		);

		$this->add_control(
			'caption_background_color',
			[
				'label' => esc_html__( 'Background Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .widget-image-caption',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'caption_text_shadow',
				'selector' => '{{WRAPPER}} .widget-image-caption',
			]
		);

		$this->add_responsive_control(
			'caption_space',
			[
				'label' => esc_html__( 'Spacing', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
					'rem' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
            'image_hover_section',
            [
                'label' => __('Image Hover', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_hover_overlay',
            [
                'label' => esc_html__('Hover Overlay', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'themescamp-core'),
                'label_off' => esc_html__('Hide', 'themescamp-core'),
                'return_value' => 'yes',
                'default' => 'no',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'image_hover_overlay_selector',
            [
                'label' => esc_html__('Choose Selector', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => esc_html__('Image', 'themescamp-plugin'),
                    'container'  => esc_html__('Parent Container', 'themescamp-plugin'),
                ],
            ]
        );

        $this->add_control(
            'image_hover_overlay_index',
            [
                'label' => esc_html__('Overlay z-index', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'z-index: {{SIZE}};',
                ],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_hover_overlay_width',
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
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_hover_overlay_height',
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
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_hover_overlay_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-elements'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'image_hover_overlay_transition',
            [
                'label' => esc_html__('Transition', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'transition: all {{SIZE}}s ease;',
                ],
            ]
        );

        $this->start_controls_tabs(
            'image_hover_overlay_tabs',
        );

        $this->start_controls_tab(
            'image_hover_overlay_normal_tab',
            [
                'label'   => esc_html__('Normal', 'themescamp-plugin'),
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'image_hover_overlay_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-elements'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Start', 'themescamp-elements'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => esc_html__('End', 'themescamp-elements'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ],
            ]
        );
        $this->add_responsive_control(
            'image_hover_overlay_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-elements'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
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
                'default' => [
                    'size' => 0,
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'left: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'image_hover_overlay_offset_orientation_h' => 'start',
                    'image_hover_overlay' => 'yes'
                ],
            ]
        );
        $this->add_responsive_control(
            'image_hover_overlay_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-elements'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
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
                'default' => [
                    'size' => 0,
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'right: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'image_hover_overlay_offset_orientation_h' => 'end',
                    'image_hover_overlay' => 'yes'
                ],
            ]
        );
        $this->add_control(
            'image_hover_overlay_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-elements'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-elements'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-elements'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );
        $this->add_responsive_control(
            'image_hover_overlay_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-elements'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
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
                'default' => [
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'image_hover_overlay_offset_orientation_v' => 'start',
                    'image_hover_overlay' => 'yes'
                ],
            ]
        );
        $this->add_responsive_control(
            'image_hover_overlay_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-elements'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
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
                'default' => [
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'bottom: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'image_hover_overlay_offset_orientation_v' => 'end',
                    'image_hover_overlay' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'image_hover_overlay_display',
            [
                'label' => esc_html__('Image Hover Overlay Display Type', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'block' => esc_html__('Block', 'themescamp-elements'),
                    'none' => esc_html__('none', 'themescamp-elements'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'display: {{VALUE}};',
                ],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'image_hover_overlay_bg',
                'selector' => '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_hover_overlay_border',
                'selector' => '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after',
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_hover_overlay_opacity',
            [
                'label' => esc_html__('Opacity', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .tcg-post-image-wrapper::after' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'image_hover_overlay_hover_tab',
            [
                'label'   => esc_html__('Hover', 'themescamp-plugin'),
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'image_hover_overlay_display_hover',
            [
                'label' => esc_html__('Image Hover Overlay Display Type', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => 'block',
                'options' => [
                    'block' => esc_html__('Block', 'themescamp-elements'),
                    'none' => esc_html__('none', 'themescamp-elements'),
                ],
                'selectors' => [
                    '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-post-image.selector-type-container.tcg-post-image-container-active .tcg-post-image-wrapper:after' => 'display: {{VALUE}};',
                    '{{WRAPPER}} .tcg-post-image.selector-type-image:hover .tcg-post-image-wrapper:after' => 'display: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'image_hover_overlay_bg_hover',
                'selector' => '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-post-image.selector-type-container.tcg-post-image-container-active .tcg-post-image-wrapper:after ,{{WRAPPER}} .tcg-post-image.selector-type-image:hover .tcg-post-image-wrapper:after',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_hover_overlay_border_hover',
                'selector' => '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-post-image.selector-type-container.tcg-post-image-container-active .tcg-post-image-wrapper:after , {{WRAPPER}} .tcg-post-image.selector-type-image:hover .tcg-post-image-wrapper:after',
            ]
        );

        $this->add_responsive_control(
            'image_hover_overlay_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-post-image.selector-type-container.tcg-post-image-container-active .tcg-post-image-wrapper:after' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .tcg-post-image.selector-type-image:hover .tcg-post-image-wrapper:after' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'image_hover_overlay' => 'yes'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->add_control(
            'image_hover_overlay_content_divider',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'image_hover_overlay_content',
            [
                'label' => esc_html__('Select Content', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'themescamp-plugin'),
                    'media'  => esc_html__('Media', 'themescamp-plugin'),
                ],
            ]
        );

        $this->add_control(
            'media_type',
            [
                'label' => esc_html__('Media Type', 'themescamp-elements'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'icon' => [
                        'title' => esc_html__('Icon', 'themescamp-elements'),
                        'icon' => 'eicon-favorite',
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'themescamp-elements'),
                        'icon' => 'eicon-image',
                    ],
                ],
                'default' => 'icon',
                'condition' => ['image_hover_overlay_content' => 'media'],
            ]
        );

        $this->add_control(
            'media_type_icon',
            [
                'label' => esc_html__('Icon', 'themescamp-elements'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin' => 'inline',
                'label_block' => false,
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                    'media_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'media_type_image',
            [
                'label' => esc_html__('Choose Image', 'textdomain'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                    'media_type' => 'image',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_container_height',
            [
                'label' => esc_html__('Icon Height', 'themescamp-elements'),
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
                'size_units' => ['px', 'vh', '%', 'vw', 'rem', 'custom'],
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
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media svg' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media img' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['image_hover_overlay_content!' => 'none'],
            ]
        );

        $this->add_responsive_control(
            'icon_container_width',
            [
                'label' => esc_html__('Icon Width', 'themescamp-elements'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => ['%', 'px', 'vw', 'rem', 'custom'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 150,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media svg' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['image_hover_overlay_content!' => 'none'],
            ]
        );

        $this->add_control(
            'media_container_advanced_options',
            [
                'label' => esc_html__( 'Media Container Options', 'themescamp-elements' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_container_display',
            [
                'label' => esc_html__('Media Container Display Type', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => 'block',
                'options' => [
                    'block' => esc_html__('Block', 'themescamp-elements'),
                    'inline-block' => esc_html__('Inline Block', 'themescamp-elements'),
                    'inline-flex' => esc_html__('Inline Flex', 'themescamp-elements'),
                    'flex' => esc_html__('Flex', 'themescamp-elements'),
                ],
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media' => 'display: {{VALUE}};'
                ]
            ]
        );
        $this->add_responsive_control(
            'media_container_display_position',
            [
                'label' => esc_html__( 'Display Position', 'themescamp-elements' ),
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
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media' => '{{VALUE}}',
                ],
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                    'media_container_display' => ['flex','inline-flex']
                ],
            ]
        );
        $this->add_responsive_control(
            'media_container_display_justify_content',
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
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                    'media_container_display' => ['flex','inline-flex']
                ],
                'responsive' => true,
            ]
        );
        $this->add_responsive_control(
            'media_container_display_align_items',
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
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media' => 'align-items: {{VALUE}};',
                ],
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                    'media_container_display' => ['flex','inline-flex']
                ],
                'responsive' => true,
            ]
        );
        $this->add_responsive_control(
            'media_container_display_flex_wrap',
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
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media' => 'flex-wrap: {{VALUE}};',
                ],
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                    'media_container_display' => ['flex','inline-flex']
                ],
            ]
        );

        $this->add_responsive_control(
            'media_container_height',
            [
                'label' => esc_html__('Media Container Height', 'themescamp-elements'),
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
                'size_units' => ['px', 'vh', '%', 'vw', 'rem', 'custom'],
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
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_container_width',
            [
                'label' => esc_html__('Media Container Width', 'themescamp-elements'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => ['%', 'px', 'vw', 'rem', 'custom'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 150,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                ],
            ]
        );

        $this->add_responsive_control(
            'media_container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-elements'),
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
                    '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'media_container_background',
                'types' => [ 'classic', 'gradient', 'tcg_gradient' ],
                'selector' => '{{WRAPPER}} .tcg-post-image .image-hover-container .tc-hover-media',
                'condition' => [
                    'image_hover_overlay_content' => 'media',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
?>

	<div class="tcg-post-image <?php echo 'selector-type-' . esc_attr($settings['image_hover_overlay_selector']); ?>">

	    <?php
	    // Check if the post has a featured image.
	    if (has_post_thumbnail()) {
	        $post_thumbnail_id = get_post_thumbnail_id();
	        $post_thumbnail_url = wp_get_attachment_image_url($post_thumbnail_id, 'full'); // Keep full size for the featured image

	        $link_start = '<div class="tcg-post-image-wrapper">';
	        $link_end = '</div>';

	        if ($settings['link_to'] == 'post-url') {
	            $link_start = '<a class="tcg-post-image-wrapper" href="' . esc_url(get_the_permalink()) . '">';
	            $link_end = '</a>';
	        }

	        echo $link_start;
	        ?>
	        <img src="<?php echo esc_url($post_thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
	        <?php
	        echo $link_end;
	    } else {
	        // Use Elementor's default placeholder image if no featured image is set
	        $placeholder_url = \Elementor\Utils::get_placeholder_image_src();

	        $link_start = '<div class="tcg-post-image-wrapper">';
	        $link_end = '</div>';

	        if ($settings['link_to'] == 'post-url') {
	            $link_start = '<a class="tcg-post-image-wrapper" href="' . esc_url(get_the_permalink()) . '">';
	            $link_end = '</a>';
	        }

	        echo $link_start;
	        ?>
	        <!-- Set fixed size for the placeholder image -->
	        <img src="<?php echo esc_url($placeholder_url); ?>" alt="<?php esc_attr_e('Placeholder Image', 'textdomain'); ?>" width="200" height="200">
	        <?php
	        echo $link_end;
	    }

	    if ($settings['image_hover_overlay_content'] != 'none') : ?>
	        <div class="image-hover-container">
	            <?php if ($settings['image_hover_overlay_content'] == 'media' && $settings['media_type'] == 'icon') : ?>
	                <div class="tc-hover-media">
	                    <?php \Elementor\Icons_Manager::render_icon($settings['media_type_icon'], ['aria-hidden' => 'true']); ?>
	                </div>
	            <?php endif; ?>
	            <?php if ($settings['image_hover_overlay_content'] == 'media' && $settings['media_type'] == 'image') : ?>
	                <div class="tc-hover-media">
                        <img src="<?=esc_url($settings['media_type_image']['url'])?>" alt="<?php if (!empty($settings['media_type_image']['alt'])) echo esc_attr($settings['media_type_image']['alt']); ?>">
	                </div>
	            <?php endif; ?>
	        </div>
	    <?php endif; ?>
	</div>



<?php }
}
