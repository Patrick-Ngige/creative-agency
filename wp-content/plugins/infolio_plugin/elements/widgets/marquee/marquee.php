<?php
namespace InfolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\repeater;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;
use Elementor\Group_Control_Text_Shadow;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/**
 * @since 1.1.0
 */
class Infolio_Marquee extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve icon list widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'infolio-marquee';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon list widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Infolio Marquee', 'infolio_plg' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon list widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-slider-push';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'list' ];
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
     * Register icon list widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */

    protected function register_controls(){
        $this->start_controls_section(
            'content',
            [
                'label' => __('Content', 'infolio_plg')
            ]
        );
        $this->add_control(
            'marque_option',
            [
                'label' => __( 'Option', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'text' => __( 'Text', 'infolio_plg' ),
                    'images' => __( 'Images', 'infolio_plg' ),
                ],
                'default' => 'text',
            ]
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'text',
            [
                'label' => __('Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT
            ]
        );
        $repeater->add_control(
            'separator',
            [
                'label' => __('Separator', 'infolio_plg'),
                'type' => Controls_Manager::TEXT
            ]
        );
        $repeater->add_control(
            'link',
            [
                'label' => __('Link', 'infolio_plg'),
                'type' => Controls_Manager::URL
            ]
        );

        $repeater->add_control(
            'icon',
            [
                'label' => __('Icon', 'infolio_plg'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}} .infolio-marquee .main-marq {{CURRENT_ITEM}}.item h4 .text',
            ]
        );

        $repeater->add_control(
            'item_color',
            [
                'label' => __('Item Color', 'infolio_plg'),
                'separator' => 'before',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-marquee .main-marq {{CURRENT_ITEM}}.item h4 .text , {{WRAPPER}} .infolio-marquee .main-marq {{CURRENT_ITEM}}.item h4 .separator' => 'color: {{VALUE}}'
                ]
            ]
        );

        $repeater->add_control(
            'item_color_dark',
            [
                'label' => __('Item Color ( Dark Mode )', 'infolio_plg'),
                'separator' => 'before',
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-marquee .main-marq {{CURRENT_ITEM}}.item h4 .text' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-marquee .main-marq {{CURRENT_ITEM}}.item h4 .text' => 'color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-marquee .main-marq {{CURRENT_ITEM}}.item h4 .separator' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-marquee .main-marq {{CURRENT_ITEM}}.item h4 .separator' => 'color: {{VALUE}};',
                ]
            ]
        );

        $repeater->add_group_control(
            \Elementor\Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'item_text_stroke',
                'selector' => '{{WRAPPER}} .infolio-marquee .main-marq {{CURRENT_ITEM}}.item h4 .text , {{WRAPPER}} .infolio-marquee .main-marq {{CURRENT_ITEM}}.item h4 .separator',
            ]
        );
        $repeater->add_responsive_control(
            'item_separator_margin',
            [
                'label' => esc_html__( 'Margin', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-marquee .main-marq {{CURRENT_ITEM}}.item h4 .separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sep_typography',
                'label' => __('Separator Typography', 'infolio_plg'),
                'selector' => '{{WRAPPER}} .infolio-marquee .main-marq .item h4 .separator',
            ]
        );
        $this->add_control(
            'marquee_rep',
            [
                'label' => __('Margquee Repeater', 'infolio_plg'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'condition' => ['marque_option'=>'text'],
                'field_title' => '{{{text}}}'
            ]
        );
        $this->add_control(
            'curves',
            [
                'label'         => __( 'Curves', 'infolio_plg' ),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __( 'Yes', 'infolio_plg' ),
                'label_off'     => __( 'No', 'infolio_plg' ),
                'condition'     => ['marque_option'=>'images'],
                'return_value'  => 'yes',
                'default'  		=> 'yes',
            ]
        );
        $this->add_control(
            'gallery',
            [
                'label' => __('Choose Images', 'infolio_plg'),
                'condition' => ['marque_option'=>'images'],
                'type' => Controls_Manager::GALLERY
            ]
        );
        $this->add_control(
            'animation_speed',
            [
                'label' => esc_html__( 'Speed', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 200,
                        'min' => 80,
                        'step' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-marquee .main-marq .slide-har.st1 .box' => ' animation-duration: {{SIZE}}s;',
                ],
            ]
        );
        $this->add_control(
            'overflow',
            [
                'label' => esc_html__('Overflow Hidden', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'infolio_plg'),
                'label_on' => esc_html__('On', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'slide_option',
            [
                'label' => __('Slide Option', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'st1' => __('Slide Left', 'infolio_plg'),
                    'st2' => __('Slide Right', 'infolio_plg'),
                ],
                'default' => 'slide_right',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'styles',
            [
                'label' => __('Styles', 'infolio_plg'),
                'condition' => ['marque_option'=>'text'],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Item Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-marquee .main-marq .box .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'opacity',
            [
                'label' => esc_html__( 'Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-marquee .main-marq' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
			'rotate',
			[
				'label' => esc_html__( 'Rotate', 'infolio_plg' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infolio-marquee .main-marq' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);
        
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__('Background', 'infolio_plg'),
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .infolio-marquee .main-marq',
			]
		);
        
        $this->add_control(
            'background_dark_mode',
            [
                'label' => __('Background (Dark Mode)', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-marquee .main-marq' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-marquee .main-marq' => 'background-color: {{VALUE}};',
                ],
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'item_border',
				'label' => __( 'Item Border', 'infolio_plg' ),
				'selector' => '{{WRAPPER}} .infolio-marquee .main-marq',
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .infolio-marquee .main-marq' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
            'item_border_color_dark',
            [
                'label' => __('Item Border Color ( Dark Mode )', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-marquee .main-marq' => 'border-color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .infolio-marquee .main-marq' => 'border-color: {{VALUE}};',
				],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'images_styles',
            [
                'label' => __('Styles', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['marque_option'=>'images'],
            ]
        );
        $this->add_responsive_control(
            'item_images_padding',
            [
                'label' => esc_html__('Item Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-marquee .main-marq .box .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Image Width', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-marquee .main-marq .box .item .img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

    }

    protected function render(){
        $settings = $this->get_settings();
        ?>
        <div class="infolio-marquee">
           <?php if ($settings['marque_option']=='images' && $settings['curves']=='yes') : ?>
               <div class="curvtop"></div>
               <div class="curvbotm"></div>
            <?php endif;?>
            <div class="main-marq <?=$settings['marque_option']?> <?php if ($settings['overflow']=='yes')echo 'o-hidden'?>">
                <div class="slide-har <?=$settings['slide_option']?>">
                    <?php for ($i=0;$i<2;$i++) :?>
                        <div class="box">
                            <?php if ($settings['marque_option']=='text'):?>
                            <?php foreach($settings['marquee_rep'] as $item) : ?>
                                <div class="item <?php echo 'elementor-repeater-item-' . esc_attr( $item['_id'] ) . ''; ?>">
                                    <?php if (!empty($item['link']['url'])) : ?>
                                    <a href="<?=esc_url($item['link']['url'])?>" <?php if ( $item['link']['is_external'] ) echo'target="_blank"'; ?>>
                                    <?php endif;?>
                                    <h4 class="d-flex align-items-center"><span class="text"><?= esc_html($item['text']); ?></span>
                                        <?php Icons_Manager::render_icon($item['icon'], ['aria-hidden' => 'true']); ?>
                                        <?php if(!empty($item['separator'])): ?>
                                            <span class="separator"><?= esc_html($item['separator']) ?></span>
                                        <?php endif; ?>
                                    </h4>
                                    <?php if (!empty($item['link']['url'])) : ?>
                                    </a>
                                    <?php endif;?>
                                </div>
                            <?php endforeach; ?>
                            <?php else:?>
                                <?php foreach($settings['gallery'] as $image) : ?>
                                    <div class="item">
                                        <div class="img">
                                            <img src="<?= esc_url($image['url']); ?>" alt="<?php if (!empty($image['alt'])) echo esc_attr($image['alt']); ?>">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif;?>
                        </div>
                    <?php endfor;?>
                </div>
            </div>
        </div>
        <?php
    }
}