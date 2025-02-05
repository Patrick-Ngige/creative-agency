<?php

namespace ThemescampPlugin\Elementor;

use Elementor\Controls_Manager;

defined('ABSPATH') || exit(); // Exit if accessed directly

/**
 *  Elementor extra features
 */
class TCG_Video_Widget_Extender
{

    public function __construct()
    {

        // theme builder controls
        add_action('elementor/element/video/section_video_style/after_section_end', [$this, 'register_tc_video_custom_size_controls'], 10, 3);
    }

    function register_tc_video_custom_size_controls($widget, $args)
    {

        $widget->start_controls_section(
            'tc_video_custom_size_settings',
            [
                'label' => __('Video Custom Size', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
			'tc_video_custom_width',
			[
				'label' => esc_html__( 'Width', 'themescamp-core' ),
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
				'size_units' => [ 'px', 'vw', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-video ' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $widget->add_responsive_control(
			'tc_video_custom_height',
			[
				'label' => esc_html__( 'Height', 'themescamp-core' ),
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
				'size_units' => [ 'px', 'vw', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-video ' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $widget->end_controls_section();
    }
}