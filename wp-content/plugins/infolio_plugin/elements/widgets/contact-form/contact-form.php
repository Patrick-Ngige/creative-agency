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

if (!defined('ABSPATH')) {
    exit;
}

class  Infolio_Contact_Form extends Widget_Base {

    public function get_name() {
        return 'infolio-contact-form';
    }

    public function get_title() {
        return __('Infolio Contact Form', 'infolio_plg');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_categories() {
        return ['infolio-elements'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'Form Widget'),
            ]
        );

        $this->add_control(
            'form_id',
            [
                'label' => __( 'Select contact form', 'infolio_plg' ),
                'type' => Controls_Manager::SELECT,
                'default' => array_keys($this->infolio_contact_forms())[0],
                'options' => $this->infolio_contact_forms(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'Input_space',
            [
                'label' => esc_html__('Space Between Inputs', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form .form-group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Input Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input,.infolio-contact-form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'input_text_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-contact-form input,.infolio-contact-form textarea',
            ]
        );
        $this->start_controls_tabs('tabs_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'background',
            [
                'label' => esc_html__( 'Input Background', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input , {{WRAPPER}} .infolio-contact-form textarea' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .infolio-contact-form input,.infolio-contact-form textarea',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'border_dark',
            [
                'label' => esc_html__( 'Border Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-contact-form input' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-contact-form input' => 'border-color: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-contact-form textarea' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-contact-form textarea' => 'border-color: {{VALUE}};',

                ],
            ]
        );
        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input,.infolio-contact-form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_focus',
            [
                'label' => esc_html__('Focus', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'background_focus',
            [
                'label' => esc_html__( 'Input Background', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input:focus,.infolio-contact-form textarea:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_focus',
                'selector' => '{{WRAPPER}} .infolio-contact-form input:focus,.infolio-contact-form textarea:focus',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'border_focus_dark',
            [
                'label' => esc_html__( 'Border Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-contact-form input:focus' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-contact-form input:focus' => 'border-color: {{VALUE}};',

                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-contact-form textarea:focus' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-contact-form textarea:focus' => 'border-color: {{VALUE}};',

                ],
            ]
        );
        $this->add_control(
            'border_radius_focus',
            [
                'label' => esc_html__('Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input:focus,.infolio-contact-form textarea:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__('Button Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_text_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-contact-form input[type="submit"]',
            ]
        );
        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Button Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Button Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('button_tabs_style');

        $this->start_controls_tab(
            'button_tab_button_normal',
            [
                'label' => esc_html__('Normal', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'button_background',
            [
                'label' => esc_html__( 'Button Background', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_background__dark',
            [
                'label' => esc_html__( 'Button Background (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label' => esc_html__( 'Button Text Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_text_dark',
            [
                'label' => esc_html__( 'Button Text Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .infolio-contact-form input[type="submit"]',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'button_border_dark',
            [
                'label' => esc_html__( 'Border Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'background_hover',
            [
                'label' => esc_html__( 'Button Background', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input[type="submit"]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_background_hover_dark',
            [
                'label' => esc_html__( 'Button Background (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]:hover' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_text_hover',
            [
                'label' => esc_html__( 'Button Text Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input[type="submit"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_text_hover_dark',
            [
                'label' => esc_html__( 'Button Text Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]:hover' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_hover',
                'selector' => '{{WRAPPER}} .infolio-contact-form input[type="submit"]:hover',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'button_border_hover_dark',
            [
                'label' => esc_html__( 'Border Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]:hover' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-contact-form input[type="submit"]:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-contact-form input[type="submit"]:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
            <div class="infolio-contact-form">
                <?= do_shortcode('[contact-form-7 id="' . $settings['form_id']  .'"]');?>
            </div>
        <?php
    }

    public function infolio_contact_forms(){
        $formlist = array();
        $forms_args = array( 'posts_per_page' => -1, 'post_type'=> 'wpcf7_contact_form' );
        $forms = get_posts( $forms_args );
        if( $forms ){
            foreach ( $forms as $form ){
                $formlist[$form->ID] = $form->post_title;
            }
        }else{
            $formlist['0'] = __('Form not found', 'infolio_plg');
        }
        return $formlist;
    }
}