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
class Infolio_Panel_Slider extends Widget_Base {

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
        return 'infolio-panel-slider';
    }
    public function get_script_depends() {
        return ['gsap.min','ScrollTrigger.min'];
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
        return __( 'Infolio Panel Slider', 'infolio_plg' );
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
        return 'eicon-slider-album';
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
            'panel_option',
            [
                'label' => __('Panel', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'img' => __('Images Only', 'infolio_plg'),
                    'cont' => __('Images & Titles', 'infolio_plg'),
                ],
                'default' => 'img',
            ]
        );
        $this->add_control(
            'sec_title',
            [
                'label' => __('Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Showcases', 'infolio_plg'),
                'condition'     => ['panel_option'=>'cont'],
            ]
        );
        $this->add_control(
            'gallery',
            [
                'label' => __('Gallery', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'condition'=>['panel_option'=>'img'],
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                ],
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Panel Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'ai' => [
                    'type' => 'text',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'placeholder' => esc_html__('Enter your title', 'infolio_plg'),
                'default' => esc_html__('Add Text Here', 'infolio_plg'),
            ]
        );
        $repeater->add_control(
            'image',
            [
                'label' => __('Panel Image', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
        $repeater->add_control(
            'link',
            [
                'label' => __('Panel Link', 'infolio_plg'),
                'type' => Controls_Manager::URL,
            ]
        );
        $this->add_control(
            'panels',
            [
                'label' => __('Panels', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'condition'=>['panel_option'=>'cont'],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Style', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,

            ]
        );
        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__( 'Item Margin', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'separator'=>'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-panel-slider .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Panel Title Typography', 'infolio_plg'),
                'name' => 'title_typography',
                'condition'=>['panel_option'=>'cont'],
                'selector' => '{{WRAPPER}} .infolio-panel-slider .panel .item .title',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Panel Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'condition'=>['panel_option'=>'cont'],
                'separator'=>'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-panel-slider .panel .item .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Background Text Typography', 'infolio_plg'),
                'name' => 'background_typography',
                'separator'=>'before',
                'selector' => '{{WRAPPER}} .infolio-panel-slider .text .text-bg',
            ]
        );
        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'separator'=>'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-panel-slider .text .text-bg' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'cont_height',
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
                    '{{WRAPPER}} .infolio-panel-slider .img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'cont_min_height',
            [
                'label' => __( 'Image Min height', 'infolio_plg' ),
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
                    '{{WRAPPER}} .infolio-panel-slider .img' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'cont_margin',
            [
                'label' => esc_html__( 'Image Margin', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-panel-slider .img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        ?>
        <div class="infolio-panel-slider tc-hscroll-container">
            <?php if ($settings['panel_option']=='img') : ?>
            <?php foreach ($settings['gallery'] as $image) :?>
                <div class="panel">
                    <div class="item">
                        <div class="img">
                            <img src="<?=esc_url($image['url'])?>" alt="<?php if (!empty($image['alt'])) echo esc_attr($image['alt']); ?>">
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            <?php else : ?>
                <div class="text">
                    <h2 class="text-bg"><?=esc_html__($settings['sec_title'],'infolio_plg')?></h2>
                </div>
            <?php foreach ($settings['panels'] as $panel) : ?>
                    <div class="panel">
                        <div class="item">
                            <div class="img">
                                <img src="<?=esc_url($panel['image']['url'])?>" alt="<?php if (!empty($image['alt'])) echo esc_attr($panel['image']['alt']); ?>">
                            </div>
                            <div class="text-center">
                                <h5 class="title"><?=esc_html($panel['title'])?></h5>
                            </div>
                            <a href="<?=esc_url($panel['link']['url'])?>" class="plink" <?php if ( $panel['link']['is_external'] ) echo'target="_blank"'; ?>></a>
                        </div>
                    </div>
            <?php endforeach;?>
            <?php endif;?>
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


