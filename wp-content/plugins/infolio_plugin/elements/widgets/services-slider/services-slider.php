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
class Infolio_Services_Slider extends Widget_Base
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
        return 'Infolio-services-slider';
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
        return __('Infolio Services Slider', 'infolio_plg');
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
        return 'eicon-carousel';
    }

    public function get_script_depends()
    {
        return ['swiper.min','infolio-services-slider'];
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
            'services_content',
            [
                'label' => __('Services Content', 'infolio_plg')
            ]
        );
        $this->add_control(
            'sec_head',
            [
                'label' => __('Section Heading', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'infolio_plg'),
                'label_off' => __('Hide', 'infolio_plg'),
                'return_value' => 'yes',
                'default' => 'yes'
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
                'default' => 'Comprehensive'
            ]
        );
        $this->add_control(
            'light_title',
            [
                'label' => __('Light Weight Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'condition'=>['sec_head'=>'yes'],
                'default' => 'Services.'
            ]
        );
        $this->add_control(
            'right_icon',
            [
                'label' => esc_html__( 'Right Icon', 'infolio_plg' ),
                'condition'=>['sec_head'=>'yes'],
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $this->add_control(
            'left_icon',
            [
                'label' => esc_html__( 'Left Icon', 'infolio_plg' ),
                'condition'=>['sec_head'=>'yes'],
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $repeater = new Repeater();

        $repeater->add_control(
            'service_icon',
            [
                'label' => __('Service Icon', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'service_title',
            [
                'label' => __('Service Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'service_description',
            [
                'label' => __('Service Description', 'infolio_plg'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'btn_switcher',
            [
                'label' => __('Read More Button', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'infolio_plg'),
                'label_off' => __('Hide', 'infolio_plg'),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __('Link', 'infolio_plg'),
                'type' => Controls_Manager::URL,
                'condition' => [
                    'btn_switcher' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'btn_text',
            [
                'label' => __('Button Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'btn_switcher' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'read_more_icon',
            [
                'label' => __('Read More Icon', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'btn_switcher' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'services',
            [
                'label' => __('Services Repeater', 'infolio_plg'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'field_title' => '{{{services_title}}}'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style',
            [
                'label' => __('Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .infolio-services .item-box h5',
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'title Color', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-services .item-box h5' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'selector' => '{{WRAPPER}} .infolio-services .item-box p',
                'separator' => 'after'
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-services .item-box p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'sec_head_style',
            [
                'label' => __('Section Heading Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'selector' => '{{WRAPPER}} .infolio-services .sec-head .sub-title',
            ]
        );

        $this->add_control(
            'sub_title_color',
            [
                'label' => esc_html__( 'Section Sub-title Color', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-services .sec-head .sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sec_title_typography',
                'selector' => '{{WRAPPER}} .infolio-services .sec-head h2',
            ]
        );

        $this->add_control(
            'sec_title_color',
            [
                'label' => esc_html__( 'Section Title Color', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-services .sec-head h2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $settings = $this->get_settings();
        $slider_id = uniqid();
        ?>
        <div class="infolio-services">
        <?php if ($settings['sec_head']=='yes') : ?>
            <div class="sec-head">
                    <h6 class="sub-title"><?=esc_html($settings['sub_title'])?></h6>
                    <div class="bord d-flex align-items-center">
                        <h2 class="d-rotate wow"><span class="rotate-text"><?=esc_html($settings['title'])?> <span class="light"> <?=esc_html($settings['light_title'])?></span></span></h2>
                        <div class="buttons">
                            <div class="swiper-arrow-control">
                                <div class="swiper-button-prev">
                                    <?php Icons_Manager::render_icon($settings['left_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                                <div class="swiper-button-next">
                                    <?php Icons_Manager::render_icon($settings['right_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php endif;?>
            <div class="infolio-serv-swiper">
                <div id="infolio-services-carousel-container-<?= $slider_id ?>" class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach($settings['services'] as $index => $item) : ?>
                            <div class="swiper-slide">
                                <div class="item-box">
                                    <div class="icon-img">
                                        <img src="<?= esc_url($item['service_icon']['url']); ?>" alt="<?php if (!empty($item['service_icon']['alt'])) echo esc_attr($item['service_icon']['alt']); ?>" >
                                    </div>
                                    <h5><?= esc_html($item['service_title']); ?></h5>
                                    <p><?= esc_html($item['service_description']); ?></p>
                                    <?php if($item['btn_switcher'] == 'yes') : ?>
                                        <a href="<?= esc_url($item['link']['url']); ?>" class="rmore" <?php if ( $item['link']['is_external'] ) echo'target="_blank"'; ?>>
                                            <span class="sub-title"><?=esc_html($item['btn_text']);?></span>
                                            <img src="<?=esc_url($item['read_more_icon']['url'])?>" alt="<?php if (!empty($item['read_more_icon']['alt'])) echo esc_attr($item['read_more_icon']['alt']); ?>" class="icon-img-20">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}