<?php

namespace infolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.0.0
 */
class infolio_Testimonials_Rating extends Widget_Base
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
		return 'infolio-testimonials-rating';
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
		return __('infolio Testimonials Rating', 'infolio_plg');
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
        return ['infolio-testimonials-rating'];
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
        $this->add_control(
            'stars_icon',
            [
                'label' => esc_html__( 'Stars Icon', 'infolio_plg' ),
                'type' => Controls_Manager::ICONS,
            ]
        );
        $repeater = new Repeater();

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
            'rate',
            [
                'label' => __('Rating', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5,
                'default' => 0,
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Quote Typography', 'infolio_plg'),
				'name' => 'quote_typography',
				'selector' => '{{WRAPPER}} .infolio-testimonials-rating .item .quote',
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
					'{{WRAPPER}} .infolio-testimonials-rating .item .quote' => 'text-align: {{VALUE}}'
				]
			]
		);
        $this->add_responsive_control(
            'quote_margin',
            [
                'label' => esc_html__( 'Quote Margin', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials-rating .item .quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_responsive_control(
            'info_padding',
            [
                'label' => esc_html__( 'Info Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials-rating .swiper-slide .item .info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .infolio-testimonials-rating .swiper-slide .item .info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Client Name Typography', 'infolio_plg'),
				'name' => 'client_name_typography',
				'selector' => '{{WRAPPER}} .infolio-testimonials-rating .item .info .name',
			]
		);

        $this->add_control(
            'client_name_colorr',
            [
                'label' => esc_html__( 'Client Name Color', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials-rating .item .info .name' => 'color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__('Client Position Typography', 'infolio_plg'),
				'name' => 'client_position_typography',
				'selector' => '{{WRAPPER}} .infolio-testimonials-rating .item .info .position',
			]
		);

        $this->add_control(
            'client_position_color',
            [
                'label' => esc_html__( 'Client Position Color', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials-rating .item .info .position' => 'color: {{VALUE}};',
                ],
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
                    '{{WRAPPER}} .infolio-testimonials-rating .item .info .position' => 'opacity: {{SIZE}};',
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
            'item_border_radius',
            [
                'label' => esc_html__('Item Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials-rating .swiper-slide .item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .infolio-testimonials-rating .swiper-slide .item',
                'separator' => 'after',
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__( 'Item Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials-rating .swiper-slide .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_container',
            [
                'label' => esc_html__( 'Content Container Margin', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-testimonials-rating .swiper-slide .item .cont' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    protected function render(){
        $settings = $this->get_settings();
        ?>
        <div class="infolio-testimonials-rating">
            <div class="infolio-testim-rate-swiper" data-carousel="swiper" data-loop="true" data-space="30">
                <div id="content-carousel-container-unq-testim-rate" class="swiper-container"
                     data-swiper="container">
                    <div class="swiper-wrapper">
                    <?php foreach ($settings['sliders'] as $item) : ?>
                        <div class="swiper-slide">
                            <div class="item d-flex align-items-center">
                                <div>
                                    <div class="fit-img circle">
                                        <img src="<?=esc_url($item['author_photo']['url'])?>" alt="<?php if (!empty($item['author_photo']['alt'])) echo esc_attr($item['author_photo']['alt']); ?>">
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="text">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="256.721" height="208.227" viewBox="0 0 256.721 208.227" class="qout-svg">
                                            <path data-name="Path 76570" d="M-23.723-530.169v97.327H-121.05v-68.7q0-40.076,13.359-73.472T-62.845-639.9l36.259,28.625Q-63.8-570.244-68.57-530.169Zm158.395,0v97.327H37.345v-68.7q0-40.076,13.359-73.472T95.55-639.9l36.259,28.625Q94.6-570.244,89.825-530.169Z" transform="translate(121.55 640.568)" fill="none" stroke-width="1" opacity="0.322">
                                            </path>
                                        </svg>
                                        <h4 class="quote"><?=esc_html($item['quote'])?></h4>
                                    </div>
                                    <div class="info d-flex align-items-center">
                                        <div>
                                            <h5 class="name"><?=esc_html($item['author_name'])?></h5>
                                            <span class="position"><?=esc_html($item['author_position'])?></span>
                                        </div>
                                        <div class="ml-auto">
                                            <div class="rate-stars">
                                                <span class="rate">
                                                    <?php
                                                    $rating = intval($item['rate']);
                                                    for ($i = 1; $i <= $rating; $i++) {
                                                        \Elementor\Icons_Manager::render_icon($settings['stars_icon'], ['aria-hidden' => 'true']);
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
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