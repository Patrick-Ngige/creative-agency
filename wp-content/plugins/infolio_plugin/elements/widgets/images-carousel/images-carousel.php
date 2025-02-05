<?php
namespace InfolioPlugin\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\repeater;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


		
/**
 * @since 1.0.0
 */
class Infolio_Images_Carousel extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'infolio-images-carousel';
	}
    public function get_script_depends() {
        return ['swiper.min','infolio-swiper-images-carousel'];
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
	public function get_title() {
		return __( 'Infolio Images Carousel', 'infolio_plg' );
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
	public function get_icon() {
		return 'eicon-blockquote';
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
	public function get_categories() {
		return [ 'infolio-elements' ];
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
	protected function _register_controls() {
	
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Gallery Images', 'infolio_plg' ),
			]
		);
        $this->add_control(
            'overflow',
            [
                'label' => esc_html__('Swiper Container Overflow Hidden', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Yes', 'infolio_plg'),
                'label_on' => esc_html__('No', 'infolio_plg'),
                'default'=>'yes'
            ]
        );
        $this->add_control(
            'clip_path',
            [
                'label' => esc_html__('Clip Path', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Yes', 'infolio_plg'),
                'label_on' => esc_html__('No', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'space',
            [
                'label' => __('Space', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'default' => '40',
                'min' => '0',
                'max' => '100',
                'step' => '1'
            ]
        );
        $this->add_control(
            'items_per_slide_switch',
            [
                'label' => __('Items Per Slide', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );
        $this->add_control(
            'auto_play',
            [
                'label' => __('Auto Play', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'default' => 'no'
            ]
        );
        $this->add_control(
            'center',
            [
                'label' => __('Center', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
            ]
        );
        $this->add_responsive_control(
            'items_per_slide',
            [
                'label' => __('Items Per Slide', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'condition'=>['items_per_slide_switch'=>'yes'],
                'default' => '5',
                'min' => '0',
                'step' => '1',
            ]
        );
        $this->add_control(
            'opacity_change',
            [
                'label' => __('Change Opacity On Hover', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
            ]
        );

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'infolio_plg' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
			]
		);

        $this->add_control(
            'gallery',
            [
                'label' => __('Images', 'infolio_plg'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __( 'Image style', 'infolio_plg' ),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_responsive_control(
			'img_width',
			[
				'label' => __( 'Image Width', 'infolio_plg' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
					'{{WRAPPER}} .infolio-images-carousel .icon-image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'img_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-images-carousel .icon-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->add_responsive_control(
			'img_height',
			[
				'label' => __( 'Image height', 'infolio_plg' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
					'{{WRAPPER}} .infolio-images-carousel .icon-image' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .infolio-images-carousel-center .icon-image' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label' => esc_html__( 'Margin', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' , 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-images-carousel .icon-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .infolio-images-carousel-center .icon-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	    $this->start_controls_section(
			'section_style_container',
			[
				'label' => __( 'Container / Slider Style', 'infolio_plg' ),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .infolio-images-carousel .item',
            ]
        );
        $this->add_control(
            'border_color_dark',
            [
                'label' => esc_html__( 'Border Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-images-carousel .item' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-images-carousel .item' => 'border-color: {{VALUE}};',
                ],
            ]
        );
		$this->add_responsive_control(
			'cont_height',
			[
				'label' => __( 'Container height', 'infolio_plg' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
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
					'{{WRAPPER}} .infolio-images-carousel .item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cont_padding',
			[
				'label' => esc_html__( 'Padding', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' , 'custom' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-images-carousel .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();



	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();
        $slider_id = uniqid();
        if (empty($settings['items_per_slide'])) $items='auto';else $items=$settings['items_per_slide'];
        $mobile_items = 1;
        $tablet_items = 3;
        if(isset($settings['items_per_slide_mobile'])){
            $mobile_items = $settings['items_per_slide_mobile'];
        };
        if(isset($settings['items_per_slide_tablet'])){
            $tablet_items = $settings['items_per_slide_tablet'];
        };
	?>
        <div class="infolio-images-carousel-init <?php if ($settings['clip_path']=='yes')echo 'clip-path '?><?= ($settings['center']=='yes') ? 'infolio-images-carousel-center':'infolio-images-carousel'?>" <?php if ($settings['auto_play']=='yes') echo 'data-autoplay="true"'?> <?php if ($settings['center']=='yes') echo 'data-center="true"'?> data-carousel="swiper" data-loop="true" <?php if ($settings['items_per_slide_switch']=='yes') echo 'data-items="'.esc_attr($items).'" data-mobile-items="'.esc_attr($mobile_items).'" data-tablet-items="'.esc_attr($tablet_items).'"' ?> data-space="<?= esc_attr($settings['space']);?>" >
            <div id="infolio-images-carousel-container-<?= $slider_id ?>" class="swiper-container <?php if ($settings['overflow']=='yes') echo 'o-hidden'?>" data-swiper="container">
                <div class="swiper-wrapper">
                    <?php foreach($settings['gallery'] as $item): ?>
                    <div class="swiper-slide">
                        <div class="item <?php if ($settings['opacity_change']=='yes')echo 'change-opacity'?>">
                            <div class="icon-image">
                                <?php if (!empty($item['link']['url'])) : ?>
                                    <a href="<?=esc_url($item['link']['url'])?>" <?php if ( $item['link']['is_external'] ) echo'target="_blank"'; ?>>
                                <?php endif;?>
                                    <img src="<?=esc_url($item['image']['url'])?>" alt="<?php if (!empty($item['image']['alt'])) echo esc_attr($item['image']['alt']); ?>">
                                <?php if (!empty($item['link']['url'])) : ?>
                                    </a>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
	 <?php
		}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function content_template() {
		
		
	}
}


