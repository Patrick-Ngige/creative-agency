<?php

namespace InfolioPlugin\Widgets;

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
class Infolio_Slides extends Widget_Base
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
		return 'infolio-slides';
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
		return __('infolio Slides', 'infolio_plg');
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
		return 'eicon-slides';
	}

    public function get_script_depends()
    {
        return ['infolio-slides'];
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
                'label' => __('Content', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'overlay_opacitiy',
            [
                'label' => __('Overlay Opacity', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'min' => '0',
                'max' => '1',
                'step' => '0.1',
                'selectors' => [
                    '{{WRAPPER}} .infolio-slides [data-overlay-dark]:before' => 'opacity: {{VALUE}}'
                ]
            ]
        );


        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Minimalest Architectures', 'infolio_plg'),
            ]
        );

        $repeater->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => __('We developed strong relationships with contractors and specialist companies', 'infolio_plg'),
            ]
        );
        
        $repeater->add_control(
            'image',
            [
                'label' => __('Background Image', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );
        $repeater->add_control(
            'btn_text',
            [
                'label' => __('Button Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Type your button text', 'infolio_plg' ),

            ]
        );
        
		$repeater->add_control(
			'btn_link',
			[
				'label' => esc_html__( 'Link', 'infolio_plg' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'label_block' => true,
			]
		);
        $this->add_control(
            'controls',
            [
                'label' => __('Slider Controls', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'infolio_plg'),
                'label_off' => __('Hide', 'infolio_plg'),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );
        $this->add_control(
            'next_text',
            [
                'label' => __('Next Text', 'infolio_plg'),
                'condition'=>['controls'=>'yes'],
                'type' => Controls_Manager::TEXT,
                'default' => __('Next', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'prev_text',
            [
                'label' => __('Prev Text', 'infolio_plg'),
                'condition'=>['controls'=>'yes'],
                'type' => Controls_Manager::TEXT,
                'default' => __('Prev', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'sep',
            [
                'label' => __('Seperator', 'infolio_plg'),
                'condition'=>['controls'=>'yes'],
                'type' => Controls_Manager::TEXT,
                'default' => __('/', 'infolio_plg'),
            ]
        );
       
        $this->add_control(
            'slides',
            [
                'label' => __('Slides', 'infolio_plg'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
					[
						'title' => esc_html__( 'Minimalest Architectures', 'infolio_plg' ),
						'sub_title' => esc_html__( 'We developed strong relationships with contractors and specialist companies', 'infolio_plg' ),
					],
					[
						'title' => esc_html__( 'Minimalest Architectures', 'infolio_plg' ),
						'sub_title' => esc_html__( 'We developed strong relationships with contractors and specialist companies', 'infolio_plg' ),
					],
				],
                'title_field' => '{{{title}}}'
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'styles',
            [
                'label' => __('Text Styles', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
                'label' => __('Title', 'infolio_plg'),
				'selector' => '{{WRAPPER}} .infolio-slides .title',
			]
		);

        $this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-slides .title' => 'color: {{VALUE}}'
                ],
                'separator' => 'after'
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
                'label' => __('Text', 'infolio_plg'),
				'selector' => '{{WRAPPER}} .infolio-slides .sub-title',
			]
		);

        $this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-slides .sub-title' => 'color: {{VALUE}}'
                ],
                'separator' => 'after'
			]
		);
        $this->end_controls_section();
        
        $this->start_controls_section(
            'Button_style',
            [
                'label' => __('Button', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
                'label' => __('button', 'infolio_plg'),
				'selector' => '{{WRAPPER}} .infolio-slides .btn',
			]
		);
        $this->start_controls_tabs(
            'style_tabs'
        );
        
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'textdomain' ),
            ]
        );
        $this->add_control(
			'btn_color',
			[
				'label' => esc_html__( 'Text Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-slides .btn' => 'color: {{VALUE}}'
                ],
                'default' => '#fff'
			]
		);
        $this->add_control(
			'btn_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-slides .btn' => 'background-color: {{VALUE}}'
                ],
                'default' => '#FFFFFF00'
			]
		);
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'textdomain' ),
            ]
        );
        $this->add_control(
			'btn_color_hover',
			[
				'label' => esc_html__( 'Text Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-slides .btn:hover' => 'color: {{VALUE}}'
                ],
                'default' => '#000'
			]
		);
        $this->add_control(
			'btn_bg_color_hover',
			[
				'label' => esc_html__( 'Background Color', 'infolio_plg' ),
				'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-slides .btn:hover' => 'background-color: {{VALUE}}'
                ],
                'default' => '#fff'
			]
		);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        
        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'btn_border',
				'selector' => '{{WRAPPER}} .infolio-slides .btn',
                'separator' => 'before',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => false,
                        ],
                    ],
                    'color' => [
                        'default' => '#fff',
                    ],
                ],
			]
		);
        $this->add_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 50,
					'right' => 50,
					'bottom' => 50,
					'left' => 50,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-slides .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
        $this->add_control(
			'btn_margin',
			[
				'label' => esc_html__( 'Margin', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 20,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-slides .btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'btn_paddingg',
			[
				'label' => esc_html__( 'Padding', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 10,
					'right' => 30,
					'bottom' => 10,
					'left' => 30,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-slides .btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->end_controls_section();
    }

    protected function render(){
        $settings = $this->get_settings();
        ?>
        <div class="infolio-slides slider-prlx">
            <div class="swiper-container parallax-slider">
                <div class="swiper-wrapper">
                <?php foreach($settings['slides'] as $item) : ?>
                    <div class="swiper-slide">
                        <div class="bg-img valign" data-background="<?=esc_url($item['image']['url'])?>" data-overlay-dark="<?=esc_attr($settings['overlay_opacity'])?>">
                            <div class="container">
                                <div class="caption text-center">
                                    <h2 class="sub-title" data-swiper-parallax="-2000"><?=esc_html($item['sub_title'])?></h2>
                                    <h1 class="title">
                                        <span data-swiper-parallax="-1000"><?=esc_html($item['title'])?></span>
                                    </h1>
                                    <?php 
                                        if(!empty($item["btn_text"])){ ?>
                                            <a href="<?=esc_attr($item['btn_link']["url"])?>" class="btn"> <?=esc_html($item['btn_text'])?></a>
                                        <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
                </div>
            </div>
            <!-- slider setting -->
            <?php if ($settings['controls']=='yes') : ?>
            <div class="slider-control">
                <div class="swiper-button-prev swiper-nav-ctrl cursor-pointer">
                    <div>
                        <span><?=esc_html($settings['prev_text'])?></span>
                    </div>
                </div>
                <div class="sep">
                    <span><?=esc_html($settings['sep'])?></span>
                </div>
                <div class="swiper-button-next swiper-nav-ctrl cursor-pointer">
                    <div>
                        <span><?=esc_html($settings['next_text'])?></span>
                    </div>
                </div>
                <div class="shap-left-bottom">
                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                        <path
                                d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z"
                               ></path>
                    </svg>
                </div>
                <div class="shap-right-top">
                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                        <path
                                d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z"
                               ></path>
                    </svg>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <?php endif;?>
        </div>
        <?php
    }
}