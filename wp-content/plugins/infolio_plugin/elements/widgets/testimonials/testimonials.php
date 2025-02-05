<?php

namespace infolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;


if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.0.0
 */
class infolio_Testimonials extends Widget_Base
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
		return 'infolio-testimonials';
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
		return __('infolio Testimonials', 'infolio_plg');
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
		return 'eicon-testimonial-carousel';
	}

    public function get_script_depends()
    {
        return ['infolio-testimonials'];
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
		return ['infolio-elements'];
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
            'content',
            [
                'label' => __('Content', 'infolio_plg')
            ]
        );
//        number of test card
        $this->add_control(
            'number_of_testimonials_cards',
            [
                'label' => __('number of testimonials cards', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => __('1', 'infolio_plg'),
                    '2' => __('2', 'infolio_plg'),
                ],
                'default' => '1',
            ]
        );
//        quote position
        $this->add_control(
            'quote_option',
            [
                'label' => __('Quote Position Options', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'absolute' => __('Behind Testimonial Text', 'infolio_plg'),
                    'down' => __('Down', 'infolio_plg'),
                    'top-right' => __('Top Right', 'infolio_plg'),
                    'top-left' => __('Top left', 'infolio_plg'),
                ],
                'default' => 'absolute',
            ]
        );

//        section heading
        $this->add_control(
            'sec_head',
            [
                'label' => __('Section Heading', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'infolio_plg'),
                'label_off' => __('Hide', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'curved_image',
            [
                'label' => __('Curved Image', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('yes', 'infolio_plg'),
                'label_off' => __('no', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'condition'=>['sec_head'=>'yes'],
                'default' => 'OUR SPECIALIZE'
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'condition'=>['sec_head'=>'yes'],
                'default' => 'Our featured'
            ]
        );
        $this->add_control(
            'light_title',
            [
                'label' => __('Light Weight Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'condition'=>['sec_head'=>'yes'],
                'default' => 'projects'
            ]
        );
        $this->add_control(
            'sec_right_icon',
            [
                'label' => esc_html__( 'Right Icon', 'infolio_plg' ),
                'condition'=>['sec_head'=>'yes'],
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $this->add_control(
            'sec_left_icon',
            [
                'label' => esc_html__( 'Left Icon', 'infolio_plg' ),
                'condition'=>['sec_head'=>'yes'],
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
//        swiper controllers
        $this->add_control(
            'swiper_controller',
            [
                'label' => __('Swiper Controls ', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'infolio_plg'),
                'label_off' => __('Hide', 'infolio_plg'),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'right_icon',
            [
                'label' => esc_html__( 'Right Icon', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition'=>['swiper_controller'=>'yes'],
            ]
        );
        $this->add_control(
            'left_icon',
            [
                'label' => esc_html__( 'Left Icon', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition'=>['swiper_controller'=>'yes'],
            ]
        );
        $repeater = new Repeater();

        $repeater->add_control(
            'quote_sub_title',
            [
                'label' => __('Quote Sub Title (Optional)', 'infolio_plg'),
                'type' => Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'quote',
            [
                'label' => __('Quote', 'infolio_plg'),
                'default' => __('I have been hiring people in this space for a number of years and I have never seen this level of professionalism. It really feels like you are working with a team that can get the job done.', 'infolio_plg'),
                'type' => Controls_Manager::TEXTAREA
            ]
        );

        $repeater->add_control(
            'author_name',
            [
                'label' => __('Author Name', 'infolio_plg'),
                'default' => __('Adam Beckley', 'infolio_plg'),
                'type' => Controls_Manager::TEXT
            ]
        );

        $repeater->add_control(
            'author_position',
            [
                'label' => __('Position', 'infolio_plg'),
                'default' => __('Founder & CEO', 'infolio_plg'),
                'type' => Controls_Manager::TEXT
            ]
        );
        $repeater->add_control(
            'author_photo',
            [
                'label' => __('Author Photo', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
            ]
        );
        $this->add_control(
            'stars_icon',
            [
                'label' => esc_html__( 'Stars Icon', 'infolio_plg' ),
                'type' => Controls_Manager::ICONS,
            ]
        );
        $repeater->add_control(
            'rate',
            [
                'label' => __('Rating', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5,
                'default' => 0,
            ]
        );

        $this->add_control(
			'sliders',
			[
				'label' => __('Sliders', 'infolio_plg'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
                'default' => [
					[
						'author_name' => esc_html__( 'adrian parody', 'infolio_plg' ),
						'author_position' => esc_html__( 'Co-Founder', 'infolio_plg' ),
					],
					[
						'author_name' => esc_html__( 'adrian parody', 'infolio_plg' ),
						'author_position' => esc_html__( 'Co-Founder', 'infolio_plg' ),
					],
				],
                'title_field' => '{{{author_name}}}'
			]
		);
        $this->end_controls_section();

        $this->start_controls_section(
			'quote_style',
			[
				'label' => esc_html('Quote Style', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		$this->add_control(
			'quote_color',
			[
				'label' => esc_html__('Quote Color', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-testimonials .item .quote' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Quote Typography', 'infolio_plg'),
				'name' => 'quote_typography',
				'selector' => '{{WRAPPER}} .infolio-testimonials .item .quote',
			]
		);

		$this->add_control(
			'quote_align',
			[
				'label' => __('Quote Align', 'infolio_plg'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'infolio_plg'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'infolio_plg'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'infolio_plg'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .infolio-testimonials .item .quote' => 'text-align: {{VALUE}}'
				]
			]
		);
        $this->add_responsive_control(
            'quote__margin',
            [
                'label' => esc_html__( 'Quote Margin', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .item .quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'text_padding',
            [
                'label' => esc_html__( 'Text Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .item .text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'quote_sub_title_border_radius',
            [
                'label' => esc_html__('Quote Sub Title Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .item .qout-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'quote_sub_title_color',
            [
                'label' => esc_html__('Quote Sub Title Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .item .qout-title' => 'color: {{VALUE}}',
                ]
            ]
        );
        $this->add_control(
            'quote_sub_title_color_dark',
            [
                'label' => esc_html__('Quote Sub Title Color (Dark Mode)', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-testimonials .item .qout-title' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-testimonials .item .qout-title' => 'color: {{VALUE}};',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Quote Sub Title Typography', 'infolio_plg'),
                'name' => 'quote_sub_title_typography',
                'selector' => '{{WRAPPER}} .infolio-testimonials .item .qout-title',
            ]
        );

        $this->add_responsive_control(
            'quote_sub_title_margin',
            [
                'label' => esc_html__( 'Quote Sub Title Margin', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .item .qout-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'quote_sub_title_padding',
            [
                'label' => esc_html__( 'Quote Sub Title Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .item .qout-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
			'client_style',
			[
				'label' => esc_html('Client Style', 'infolio_plg'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'info_border',
                'selector' => '{{WRAPPER}} .infolio-testimonials .swiper-slide .item .info',
                'separator' => 'after',
            ]
        );

        $this->add_responsive_control(
            'info_padding',
            [
                'label' => esc_html__( 'Info Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .swiper-slide .item .info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'info_margin',
            [
                'label' => esc_html__( 'Info Margin', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .swiper-slide .item .info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_control(
			'client_name_color',
			[
				'label' => esc_html__('Client Name Color', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-testimonials .item .info .name' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'client_position_color',
			[
				'label' => esc_html__('Client Position Color', 'infolio_plg'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infolio-testimonials .item .info .position' => 'color: {{VALUE}};',
				]
			]
		);

        $this->add_control(
            'client_position_dark',
            [
                'label' => esc_html__('Client Position Color (Dark Mode)', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-testimonials .item .info .position' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-testimonials .item .info .position' => 'color: {{VALUE}};',
                ]
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Client name Typography', 'infolio_plg'),
				'name' => 'client_name_typography',
				'selector' => '{{WRAPPER}} .infolio-testimonials .item .info .name',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Client Position Typography', 'infolio_plg'),
				'name' => 'client_position_typography',
				'selector' => '{{WRAPPER}} .infolio-testimonials .item .info .position',
			]
		);

        $this->add_control(
            'position_opacity',
            [
                'label' => esc_html__( 'Position Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .item .info .position' => 'opacity: {{SIZE}};',
                ],
            ]
        );

		$this->end_controls_section();
        $this->start_controls_section(
            'item_style',
            [
                'label' => esc_html('Item & Swiper Slide Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'item_background_color',
            [
                'label' => esc_html__( 'Item Background Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .swiper-slide .item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'item_background_color_dark',
            [
                'label' => esc_html__( 'Item Background Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-testimonials .swiper-slide .item' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-testimonials .swiper-slide .item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'item_border_radius',
            [
                'label' => esc_html__('Item Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .swiper-slide .item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .infolio-testimonials .swiper-slide .item',
                'separator' => 'after',
            ]
        );
        $this->add_control(
            'item_border_color_dark',
            [
                'label' => esc_html__( 'Item Border Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-testimonials .swiper-slide .item' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-testimonials .swiper-slide .item' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__( 'Item Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .swiper-slide .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'swiper_slide_padding',
            [
                'label' => esc_html__( 'Swiper Slide Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'swiper_controls_position',
            [
                'label' => esc_html__( 'Swiper Controls Bottom Position', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .control-abslout' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_heading_style',
            [
                'label' => esc_html__( 'Section Heading', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>['sec_head'=>'yes'],
            ]
        );
        $this->add_control(
            'sub_title_color',
            [
                'label' => esc_html__( 'Sub Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .sec-head .sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-testimonials .sec-head .sub-title',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials h2' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-testimonials .sec-head h2',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'author_image_background',
            [
                'label' => esc_html__( 'Section Curved Image', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>['curved_image'=>'yes'],
            ]
        );
        $this->add_control(
            'background_curved',
            [
                'label' => esc_html__( 'Background Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .info .img-curv' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-testimonials .info .img-curv .shap-left-top svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-testimonials .info .img-curv .shap-right-bottom svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_curved_dark',
            [
                'label' => esc_html__( 'Background Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-testimonials .info .img-curv' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-testimonials .info .img-curv' => 'background-color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-testimonials .info .img-curv .shap-left-top svg path' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-testimonials .info .img-curv .shap-left-top svg path' => 'fill: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-testimonials .info .img-curv .shap-right-bottom svg path' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-testimonials .info .img-curv .shap-right-bottom svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'stars_style',
            [
                'label' => esc_html__( 'Rating', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'rate_color',
            [
                'label' => esc_html__( 'Icon Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .item .rate-stars i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-testimonials .item .rate-stars svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'rate_background_color',
            [
                'label' => esc_html__( 'Background Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .item .rate-stars' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-testimonials .item .rate-stars .shap-left-top svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-testimonials .item .rate-stars .shap-right-bottom svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'rate_background_color_dark',
            [
                'label' => esc_html__( 'Background Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-testimonials .item .rate-stars' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-testimonials .item .rate-stars' => 'background-color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-testimonials .item .rate-stars .shap-left-top svg path' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-testimonials .item .rate-stars .shap-left-top svg path' => 'fill: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-testimonials .item .rate-stars .shap-right-bottom svg path' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-testimonials .item .rate-stars .shap-right-bottom svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between Stars', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials .item .rate-stars i:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render(){
        $settings = $this->get_settings();
        ?>
        <div class="infolio-testimonials">
            <?php if ($settings['sec_head']=='yes') : ?>
                <div class="sec-head">
                    <h6 class="sub-title"><?=esc_html($settings['sub_title'])?></h6>
                    <div class="bord d-flex align-items-center">
                        <h2 class="title"><?=esc_html($settings['title'])?> <span class="light-title"> <?=esc_html($settings['light_title'])?></span></h2>
                        <div class="buttons">
                            <div class="swiper-arrow-control">
                                <div class="swiper-button-prev">
                                    <?php Icons_Manager::render_icon($settings['sec_left_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                                <div class="swiper-button-next">
                                    <?php Icons_Manager::render_icon($settings['sec_right_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <div class="infolio-testim-init <?php if ($settings['number_of_testimonials_cards']=='1')echo "infolio-testim-swiper";else echo 'infolio-testim-swiper2';?>" data-carousel="swiper" data-loop="true" data-space="30">
                <div id="content-carousel-container-unq-testim" class="swiper-container"
                     data-swiper="container">
                    <div class="swiper-wrapper">
                    <?php foreach ($settings['sliders'] as $item) : ?>
                        <div class="swiper-slide">
                            <div class="item">
                                <div>
                                    <?php if (!empty($item['rate'])):?>
                                        <div class="rate-stars">
                                            <span class="rate">
                                                <?php
                                                $rating = intval($item['rate']);
                                                for ($i = 1; $i <= $rating; $i++) {
                                                    \Elementor\Icons_Manager::render_icon($settings['stars_icon'], ['aria-hidden' => 'true']);
                                                }
                                                ?>
                                            </span>
                                            <div class="shap-left-top">
                                                <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                                    <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z"></path>
                                                </svg>
                                            </div>
                                            <div class="shap-right-bottom">
                                                <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                                    <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                    <?php if ($settings['quote_option']=='top-left') : ?>
                                        <svg class="top-left-svg" xmlns="http://www.w3.org/2000/svg" width="256.721" height="208.227" viewBox="0 0 256.721 208.227">
                                            <path data-name="Path 76570" d="M-23.723-530.169v97.327H-121.05v-68.7q0-40.076,13.359-73.472T-62.845-639.9l36.259,28.625Q-63.8-570.244-68.57-530.169Zm158.395,0v97.327H37.345v-68.7q0-40.076,13.359-73.472T95.55-639.9l36.259,28.625Q94.6-570.244,89.825-530.169Z" transform="translate(121.55 640.568)" fill="none" stroke-width="1" opacity="0.322">
                                            </path>
                                        </svg>
                                    <?php endif?>
                                    <div class="text">
                                        <?php if ($settings['quote_option']=='absolute') : ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="256.721"
                                             height="208.227" viewBox="0 0 256.721 208.227"
                                             class="qout-svg">
                                            <path data-name="Path 76570"
                                                  d="M-23.723-530.169v97.327H-121.05v-68.7q0-40.076,13.359-73.472T-62.845-639.9l36.259,28.625Q-63.8-570.244-68.57-530.169Zm158.395,0v97.327H37.345v-68.7q0-40.076,13.359-73.472T95.55-639.9l36.259,28.625Q94.6-570.244,89.825-530.169Z"
                                                  transform="translate(121.55 640.568)"
                                                  stroke-width="1" opacity="0.322">
                                            </path>
                                        </svg>
                                        <?php endif;?>
                                        <?php if (isset($item['quote_sub_title']) && ($settings['quote_option']=='down' || $settings['quote_option']=='top-left')) : ?>
                                            <span class="qout-title"><?=esc_html($item['quote_sub_title'])?></span>
                                        <?php endif;?>
                                        <?php if (isset($item['quote_sub_title']) && $settings['quote_option']=='top-right') : ?>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <span class="qout-title"><?=esc_html($item['quote_sub_title'])?></span>
                                                </div>
                                                <div class="<?=esc_attr($settings['quote_option'])?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="256.721" height="208.227" viewBox="0 0 256.721 208.227">
                                                        <path data-name="Path 76570" d="M-23.723-530.169v97.327H-121.05v-68.7q0-40.076,13.359-73.472T-62.845-639.9l36.259,28.625Q-63.8-570.244-68.57-530.169Zm158.395,0v97.327H37.345v-68.7q0-40.076,13.359-73.472T95.55-639.9l36.259,28.625Q94.6-570.244,89.825-530.169Z" transform="translate(121.55 640.568)" fill="none" stroke-width="1" opacity="0.322">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                        <?php endif;?>
                                        <p class="quote"><?=esc_html($item['quote'])?></p>
                                    </div>
                                    <div class="info d-flex align-items-center">
                                        <?php if (!empty($item['author_photo']['url'])) : ?>
                                        <div>
                                            <?php if ($settings['curved_image']=='yes') : ?>
                                            <div class="img-curv">
                                                <div class="img">
                                                    <img src="<?=esc_url($item['author_photo']['url'])?>" alt="<?php if (!empty($item['author_photo']['alt'])) echo esc_attr($item['author_photo']['alt']); ?>">
                                                </div>
                                                <div class="shap-left-top">
                                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#1a1a1a"></path>
                                                    </svg>
                                                </div>
                                                <div class="shap-right-bottom">
                                                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z" fill="#1a1a1a"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <?php else:?>
                                                <div class="photo">
                                                    <img src="<?=esc_url($item['author_photo']['url'])?>" alt="<?php if (!empty($item['author_photo']['alt'])) echo esc_attr($item['author_photo']['alt']); ?>">
                                                </div>
                                            <?php endif;?>
                                        </div>
                                        <?php endif;?>
                                        <div class="<?php if (!empty($item['author_photo']['url']))echo 'ml-20'?>">
                                            <h5 class="name"><?=esc_html($item['author_name'])?></h5>
                                            <span class="position"><?=esc_html($item['author_position'])?></span>
                                        </div>
                                        <?php if ($settings['quote_option']=='down') : ?>
                                        <div class="ml-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="256.721" height="208.227" viewBox="0 0 256.721 208.227" class="qout-svg">
                                                <path data-name="Path 76570" d="M-23.723-530.169v97.327H-121.05v-68.7q0-40.076,13.359-73.472T-62.845-639.9l36.259,28.625Q-63.8-570.244-68.57-530.169Zm158.395,0v97.327H37.345v-68.7q0-40.076,13.359-73.472T95.55-639.9l36.259,28.625Q94.6-570.244,89.825-530.169Z" transform="translate(121.55 640.568)" fill="none"  stroke-width="1" opacity="0.322">
                                                </path>
                                            </svg>
                                        </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php if ($settings['swiper_controller']=='yes') : ?>
            <div class="swiper-arrow-control control-abslout">
                <div class="swiper-button-prev">
                    <?php Icons_Manager::render_icon($settings['left_icon'], ['aria-hidden' => 'true']); ?>
                </div>
                <div class="swiper-button-next">
                    <?php Icons_Manager::render_icon($settings['right_icon'], ['aria-hidden' => 'true']); ?>
                </div>
            </div>
            <?php endif;?>
        </div>
        <?php
    }
}