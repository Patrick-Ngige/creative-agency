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
class Infolio_Services_Card extends Widget_Base
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
        return 'infolio-services-card';
    }
    //script depend

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
        return __('infolio Services Card', 'infolio_plg');
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
        return 'eicon-menu-card';
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
    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'infolio_plg' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'read_more_animation',
            [
                'label' => __('Top Read More Animation', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'read_more_animation_option',
            [
                'label' => esc_html__( 'Animations', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'condition' => ['read_more_animation' => 'yes'],
                'options' => [
                    'top-animation' => esc_html__( 'Position Absolute', 'infolio_plg' ),
                    'bottom-animation' => esc_html__( 'Display On Hover', 'infolio_plg' ),
                ],
                'default' => 'top-animation',
            ]
        );

        $this->add_control(
            'description_animation',
            [
                'label' => __('Description Animation', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'image',
            [
                'label' => __( 'Image', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => __( 'Heading', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Digital Marketing', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'text',
            [
                'label' => __( 'Text', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Live workshop where we define the main problems and challenges before building.', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'read_more_link',
            [
                'label' => esc_html__( 'Read More Link', 'infolio_plg' ),
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
            'read_more_image',
            [
                'label' => __( 'Read More Image', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'read_more_text',
            [
                'label' => __( 'Read More Button Text', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Read More', 'infolio_plg' ),
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_card',
            [
                'label' => esc_html__( 'Card', 'infolio_plg' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__( 'Card Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'card_background_color',
            [
                'label' => __('Card Background', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'card_background_color_dark',
            [
                'label' => __('Card Background (Dark Mode)', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-services-card' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-services-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'selector' => '{{WRAPPER}} .infolio-services-card',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'card_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
//        image
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__( 'Image', 'infolio_plg' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'image_opacity',
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
                    '{{WRAPPER}} .infolio-services-card .avatar' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_space',
            [
                'label' => esc_html__( 'Spacing', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .avatar' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__( 'Width', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 60,
                    'unit' => 'px',
                ],
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    '%' => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .avatar' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
//        content
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__( 'Text', 'infolio_plg' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
//        heading
        $this->add_control(
            'heading_main',
            [
                'label' => esc_html__( 'Heading', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_responsive_control(
            'title_bottom_space',
            [
                'label' => esc_html__( 'Spacing', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .infolio-services-card .title',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .title' => 'color: {{VALUE}};',
                ],
            ]
        );
//        description
        $this->add_control(
            'heading_description',
            [
                'label' => esc_html__( 'Description', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .infolio-services-card .description',
            ]
        );
        $this->add_control(
            'description_color',
            [
                'label' => esc_html__( 'Description Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .description' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Styled Text Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-heading span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'button_settings',
            [
                'label' => __( 'Read More Button Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'read_more_animation_option!' => 'top-animation'
                ],
            ]
        );
        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Button Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .read-more .sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );
     
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-services-card .read-more .sub-title',
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Read More Icon size', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .read-more svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-services-card .read-more img' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-services-card .read-more i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Button Icon Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .read-more img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-services-card .read-more svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-services-card .read-more i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'top_button_settings',
            [
                'label' => __( 'Top Read More Button','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'read_more_animation' => 'yes',
                    'read_more_animation_option' => 'top-animation'
                ],
            ]
        );
        $this->start_controls_tabs(
            'style_tabs'
        );
        
        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'top_button_bg',
            [
                'label' => esc_html__( 'Background', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .readmore-animate .arrow' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'top_button_icon_size',
            [
                'label' => esc_html__( 'Icon size', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .readmore-animate .arrow svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-services-card .readmore-animate .arrow  img' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-services-card .readmore-animate  .arrow i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'style_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'infolio_plg' ),
            ]
        );
        
       
        $this->add_control(
            'top_button_bg_hover',
            [
                'label' => esc_html__( 'Background Hover', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .readmore-animate:hover .arrow' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'top_button_icon_size_hover',
            [
                'label' => esc_html__( 'Icon size', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-services-card .readmore-animate:hover .arrow svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-services-card .readmore-animate:hover .arrow  img' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-services-card .readmore-animate:hover .arrow  i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        
        $this->end_controls_tab();
        $this->end_controls_tabs();
       
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
            <div class="infolio-services-card">
                <div>
                    <div class="avatar">
                        <img src="<?=esc_url($settings['image']['url'])?>" alt="<?php if (!empty($settings['image']['alt'])) echo esc_attr($settings['image']['alt']); ?>" >
                    </div>
                </div>
                <div class="<?php if ($settings['description_animation']=='yes')echo 'animate'?>">
                    <h5 class="title"><?=$settings['heading']?></h5>
                    <p class="description"><?=$settings['text']?></p>
                </div>
                <?php if ($settings['read_more_animation']=='yes' && $settings['read_more_animation_option']=='top-animation') : ?>
                    <a href="<?=esc_url($settings['read_more_link']['url'])?>" class="readmore-animate" <?php if ( $settings['read_more_link']['is_external'] ) echo'target="_blank"'; ?>>
                        <div class="arrow">
                            <img src="<?=esc_url($settings['read_more_image']['url'])?>" alt="<?php if (!empty($settings['read_more_image']['alt'])) echo esc_attr($settings['read_more_image']['alt']); ?>" class="read-more-image">
                        </div>
                        <div class="shap-left-top">
                            <svg viewBox="0 0 11 11" fill="none"
                                 xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                <path
                                    d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z">
                                </path>
                            </svg>
                        </div>
                        <div class="shap-right-bottom">
                            <svg viewBox="0 0 11 11" fill="none"
                                 xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                <path
                                    d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z">
                                </path>
                            </svg>
                        </div>
                    </a>
                <?php else: ?>
                <?php if ($settings['read_more_animation_option']=='bottom-animation') echo '<div class="o-hidden">'?>
                    <a href="<?=esc_url($settings['read_more_link']['url'])?>" class="read-more <?php if ($settings['read_more_animation_option']=='bottom-animation') echo 'to-in'?>" <?php if ( $settings['read_more_link']['is_external'] ) echo'target="_blank"'; ?>>
                        <span class="sub-title"><?=esc_html($settings['read_more_text'])?></span>
                        <img src="<?=esc_url($settings['read_more_image']['url'])?>" alt="<?php if (!empty($settings['read_more_image']['alt'])) echo esc_attr($settings['read_more_image']['alt']); ?>" class="icon-img">
                    </a>
                    <?php if ($settings['read_more_animation_option']=='bottom-animation') echo '</div>'?>
                <?php endif;?>
            </div>
        <?php
    }

}
