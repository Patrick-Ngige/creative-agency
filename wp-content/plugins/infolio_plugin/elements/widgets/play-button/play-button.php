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
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;


if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.0.0
 */
class Infolio_Play_Button extends Widget_Base
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
        return 'infolio-play-button';
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
        return __('Infolio Play Button', 'infolio_plg');
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
        return 'eicon-button';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently infolio_plg supports only one category.
     * When multiple categories passed, infolio_plg uses the first one.
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

    public function get_script_depends()
    {
        return ['Youtube-Popup.min','infolio-youtube-popup'];
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
    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__('Icon', 'infolio_plg'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin' => 'inline',
                'label_block' => false,
            ]
        );
        $this->add_control(
            'btn_link',
            [
                'label' => __('Button Link', 'infolio_plg'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#0',
                    'is_external' => true,
                ],
            ]
        );
        $this->add_control(
            'shap_left',
            [
                'label' => esc_html__('Left Top Edge', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'infolio_plg'),
                'label_on' => esc_html__('On', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'shap_right',
            [
                'label' => esc_html__('Right Bottom Edge', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'infolio_plg'),
                'label_on' => esc_html__('On', 'infolio_plg'),
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-play-button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-play-button' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'container_background_color',
            [
                'label' => esc_html__( 'Background Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-play-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'container_background_color_dark',
            [
                'label' => esc_html__( 'Background Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-play-button' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-play-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'infolio_plg' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'infolio_plg' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'infolio_plg' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'infolio_plg' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'infolio_plg' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .infolio-play-button' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'line_height',
            [
                'label' => esc_html__( 'Line Height', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ,'em','rem','vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-play-button' => 'line-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

//        style

        $this->start_controls_section(
            'button_section_style',
            [
                'label' => esc_html__( 'Button Style', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'button_icon_size',
            [
                'label' => esc_html__( 'Icon size', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ,'em' ,'rem' ,'%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-play-button .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-play-button .icon svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => __('Border', 'infolio_plg'),
                'selector' => '{{WRAPPER}} .infolio-play-button .vid',
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .infolio-play-button .icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-play-button .icon svg' => 'fill: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_SECONDARY,
                ],
            ]
        );
        $this->add_control(
            'icon_color_dark',
            [
                'label' => esc_html__( 'Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-play-button .icon i' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-play-button .icon i' => 'color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-play-button .icon svg' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-play-button .icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-play-button .vid' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_color_dark',
            [
                'label' => esc_html__( 'Background Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-play-button .vid' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-play-button .vid' => 'background-color: {{VALUE}};',
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
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="infolio-play-button">
            <a href="<?=esc_url($settings['btn_link']['url'])?>" class="vid" <?php if ( $settings['btn_link']['is_external'] ) echo'target="_blank"'; ?>>
                <div class="icon">
                    <?php Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']); ?>
                </div>
            </a>
            <?php if ($settings['shap_left']=='yes') : ?>
                <div class="shap-left-top">
                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"
                         class="w-11 h-11">
                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z"></path>
                    </svg>
                </div>
            <?php endif;?>
            <?php if ($settings['shap_right']=='yes') : ?>
                <div class="shap-right-bottom">
                    <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"
                         class="w-11 h-11">
                        <path d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z"></path>
                    </svg>
                </div>
            <?php endif;?>
        </div>
        <?php
    }

}
