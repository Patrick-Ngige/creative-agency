<?php

namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

if (! defined('ABSPATH'))
    exit; // Exit if accessed directly

class TCG_Mailchimp extends Widget_Base
{

    public function get_name()
    {
        return 'tcg-mailchimp';
    }

    public function get_title()
    {
        return esc_html__('Mailchimp', 'themescamp-core');
    }

    public function get_icon()
    {
        return 'eicon-mailchimp';
    }

    public function get_categories()
    {
        return ['element-pack'];
    }

    public function get_keywords()
    {
        return ['mailchimp', 'email', 'marketing', 'newsletter'];
    }

    public function get_script_depends()
    {
        return ['mailchimp'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_content_layout',
            [
                'label' => esc_html__('Layout', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'show_before_icon',
            [
                'label' => esc_html__('Show Before Icon', 'themescamp-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'before_icon_inline',
            [
                'label'        => esc_html__('Inline Before Icon', 'themescamp-core'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'tcg-before-icon-inline--',
                'render_type'  => 'template',
                'condition'    => [
                    'show_before_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mailchimp_before_icon',
            [
                'label'            => esc_html__('Choose Icon', 'themescamp-core'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'before_icon',
                'default'          => [
                    'value'   => 'far fa-envelope-open',
                    'library' => 'fa-regular',
                ],
                'condition'        => [
                    'show_before_icon' => 'yes'
                ],
                'label_block'      => false,
                'skin'             => 'inline'
            ]
        );

        $this->add_control(
            'show_fname',
            [
                'label' => esc_html__('Show Name', 'themescamp-core'),
                'type'  => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_checkbox',
            [
                'label' => esc_html__('Show Checkbox', 'themescamp-core'),
                'type'  => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'checkbox_label',
            [
                'label' => __('Checkbox Label', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('I agree to all terms and policies', 'plugin-name'),
                'condition' => [
                    'show_checkbox' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'fname_field_placeholder',
            [
                'label'       => esc_html__('Name Field Placeholder', 'themescamp-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'label_block' => true,
                'default'     => esc_html__('Name ', 'themescamp-core'),
                'placeholder' => esc_html__('Name ', 'themescamp-core'),
                'condition'   => [
                    'show_fname' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'email_field_placeholder',
            [
                'label'       => esc_html__('Email Field Placeholder', 'themescamp-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'label_block' => true,
                'default'     => esc_html__('Email *', 'themescamp-core'),
                'placeholder' => esc_html__('Email *', 'themescamp-core'),
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'before_text',
            [
                'label'       => esc_html__('Before Text', 'themescamp-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'placeholder' => esc_html__('Before Text', 'themescamp-core'),
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'after_text',
            [
                'label'       => esc_html__('After Text', 'themescamp-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'placeholder' => esc_html__('After Text', 'themescamp-core'),
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'        => esc_html__('Text Alignment', 'themescamp-core'),
                'type'         => Controls_Manager::CHOOSE,
                'prefix_class' => 'elementor%s-align-',
                'default'      => '',
                'options'      => [
                    'left'    => [
                        'title' => esc_html__('Left', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__('Center', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__('Right', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'conditions'   => [
                    'relation' => 'or',
                    'terms'    => [
                        [
                            'name'     => 'before_text',
                            'operator' => '!=',
                            'value'    => '',
                        ],
                        [
                            'name'     => 'after_text',
                            'operator' => '!=',
                            'value'    => '',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'fullwidth_input',
            [
                'label'        => esc_html__('Fullwidth Fields', 'themescamp-core'),
                'type'         => Controls_Manager::SWITCHER,
                'separator'    => 'before',
            ]
        );

        $this->add_responsive_control(
            'flex_direction',
            [
                'label'     => esc_html__('Fields Direction', 'themescamp-core'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'column',
                'options'   => [
                    'row'    => [
                        'title' => esc_html__('Row', 'themescamp-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'column' => [
                        'title' => esc_html__('Column', 'themescamp-core'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                ],
                'condition' => [
                    'fullwidth_input' => 'yes',
                ],
                'selectors_dictionary' => [
                    'row' => 'flex-direction: row; align-items: center;',
                    'column' => 'flex-direction: column; align-items: flex-start;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-mailchimp' => '{{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'fullwidth_button',
            [
                'label'     => esc_html__('Fullwidth Button', 'themescamp-core'),
                'type'      => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper' => 'width: 100%;',
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'width: 100%;',
                ],
                'condition' => [
                    'fullwidth_input' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_alignment',
            [
                'label'     => esc_html__('Button Alignment', 'themescamp-core'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'     => [
                        'title' => esc_html__('Left', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'   => [
                        'title' => esc_html__('Center', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors_dictionary' => [
                    'left' => 'align-items: flex-start;',
                    'center' => 'align-items: center;',
                    'flex-end' => 'align-items: flex-end;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => '{{VALUE}}',
                ],
                'condition' => [
                    'fullwidth_input'  => 'yes',
                    'fullwidth_button' => '',
                ],
            ]
        );

        $this->add_control(
            'space',
            [
                'label'   => esc_html__('Space Between', 'themescamp-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''         => esc_html__('Default', 'themescamp-core'),
                    'small'    => esc_html__('Small', 'themescamp-core'),
                    'medium'   => esc_html__('Medium', 'themescamp-core'),
                    'large'    => esc_html__('Large', 'themescamp-core'),
                    'collapse' => esc_html__('Collapse', 'themescamp-core'),
                    'custom'   => esc_html__('Custom', 'themescamp-core'),
                ],
                'selectors_dictionary' => [
                    ''         => 'gap: 10px;',
                    'small'    => 'gap: 15px;',
                    'medium'   => 'gap: 30px;',
                    'large'    => 'gap: 70px;',
                    'collapse' => 'gap: 0;',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-mailchimp' => '{{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'gap_custom',
            [
                'label'      => esc_html__('Custom Gap', 'themescamp-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-mailchimp' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'space' => 'custom',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_button',
            [
                'label' => esc_html__('Signup Button', 'themescamp-core'),
            ]
        );
        $this->add_control(
            'button_position',
            [
                'label' => __('Button Position', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'end_of_form',
                'options' => [
                    'inside_inputs' => __('Inside Inputs', 'plugin-name'),
                    'end_of_form' => __('End of Form', 'plugin-name'),
                ],
            ]
        );
        $this->add_control(
            'button_text',
            [
                'label'       => esc_html__('Button Text', 'themescamp-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'placeholder' => esc_html__('SIGNUP', 'themescamp-core'),
                'default'     => esc_html__('SIGNUP', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'mailchimp_button_icon',
            [
                'label'            => esc_html__('Icon', 'themescamp-core'),
                'type'             => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'label_block'      => false,
                'skin'             => 'inline'
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label'     => esc_html__('Icon Position', 'themescamp-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'right',
                'options'   => [
                    'left'   => esc_html__('Left', 'themescamp-core'),
                    'right'  => esc_html__('Right', 'themescamp-core'),
                    'top'    => esc_html__('Top', 'themescamp-core'),
                    'bottom' => esc_html__('Bottom', 'themescamp-core'),
                ],
                'condition' => [
                    'mailchimp_button_icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label'     => esc_html__('Icon Spacing', 'themescamp-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default'   => [
                    'size' => 8,
                ],
                'condition' => [
                    'mailchimp_button_icon[value]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-btn .tcg-flex-align-right'  => is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-newsletter-btn .tcg-flex-align-left'   => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-newsletter-btn .tcg-flex-align-top'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-newsletter-btn .tcg-flex-align-bottom' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_before_icon',
            [
                'label'     => esc_html__('Before Icon', 'themescamp-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_before_icon'              => 'yes',
                    'mailchimp_before_icon[value]!' => '',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_before_icon_style');

        $this->start_controls_tab(
            'tab_before_icon_normal',
            [
                'label' => esc_html__('Normal', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'before_icon_color',
            [
                'label'     => esc_html__('Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-before-icon'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-newsletter-before-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'before_icon_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .tcg-newsletter-before-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'before_icon_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tcg-newsletter-before-icon',
            ]
        );

        $this->add_responsive_control(
            'before_icon_radius',
            [
                'label'      => esc_html__('Border Radius', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-before-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'before_icon_padding',
            [
                'label'      => esc_html__('Padding', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-before-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'before_icon_margin',
            [
                'label'      => esc_html__('Margin', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-before-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'before_icon_shadow',
                'selector' => '{{WRAPPER}} .tcg-newsletter-before-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'before_icon_typography',
                'selector' => '{{WRAPPER}} .tcg-newsletter-before-icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_before_icon_hover',
            [
                'label' => esc_html__('Hover', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'before_icon_hover_color',
            [
                'label'     => esc_html__('Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-before-icon:hover'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-newsletter-before-icon:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'before_icon_hover_background',
                'selector' => '{{WRAPPER}} .tcg-newsletter-before-icon:hover',
            ]
        );

        $this->add_control(
            'before_icon_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'before_icon_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-before-icon:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->start_controls_section(
            'checkbox_style_section',
            [
                'label' => __('Checkbox Style', 'plugin-name'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_checkbox' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'checkbox_margin',
            [
                'label' => esc_html__('Margin', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
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
                    '{{WRAPPER}} .tcg-newsletter-checkbox-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'checkbox_display',
            [
                'label' => esc_html__('Checkbox Display', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => 'block',
                'options' => [
                    'block' => esc_html__('Block', 'themescamp-elements'),
                    'flex' => esc_html__('Flex', 'themescamp-elements'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-checkbox-wrapper' => 'display: {{VALUE}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'checkbox_justify_content',
            [
                'label' => esc_html__( 'Justify Content', 'themescamp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'default' => '',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start','themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__( 'Space Around', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__( 'Space Evenly', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-space-evenly-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-checkbox-wrapper' => 'justify-content: {{VALUE}};',
                ],
                'condition'=>[
                    'checkbox_display'=>['flex']
                ],
                'responsive' => true,
            ]
        );
        $this->add_responsive_control(
            'checkbox_align_items',
            [
                'label' => esc_html__( 'Align Items', 'themescamp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => '',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-checkbox-wrapper' => 'align-items: {{VALUE}};',
                ],
                'condition'=>[
                    'checkbox_display' => ['flex']
                ],
                'responsive' => true,
            ]
        );
        $this->add_control(
            'checkbox_size',
            [
                'label' => __('Checkbox Size', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-checkbox-wrapper input[type="checkbox"]' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'checkbox_border_color',
                'selector' => '{{WRAPPER}} .tcg-newsletter-checkbox-wrapper input[type="checkbox"]',
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'checkbox_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .tcg-newsletter-checkbox-wrapper input[type="checkbox"]',
            ]
        );
// Checkbox Label Color
        $this->add_control(
            'checkbox_label_color',
            [
                'label' => __('Label Color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-checkbox-wrapper label' => 'color: {{VALUE}};',
                ],
            ]
        );

// Checkbox Label Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'checkbox_label_typography',
                'label' => __('Label Typography', 'plugin-name'),
                'selector' => '{{WRAPPER}} .tcg-newsletter-checkbox-wrapper label',
            ]
        );

// Spacing Between Checkbox and Label
        $this->add_control(
            'checkbox_label_spacing',
            [
                'label' => __('Spacing', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-checkbox-wrapper label' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_input',
            [
                'label' => esc_html__('Field', 'themescamp-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'field_input_margin',
            [
                'label'      => esc_html__('Input Margin', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper input[type*="text"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-newsletter-wrapper input[type*="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'input_placeholder_color',
            [
                'label'     => esc_html__('Placeholder Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper input[type*="email"]::placeholder, {{WRAPPER}} .tcg-newsletter-wrapper input[type*="text"]::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label'     => esc_html__('Text Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_background',
            [
                'label'     => esc_html__('Background', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'placeholder_typography',
                'label'    => esc_html__('Typography', 'themescamp-core'),
                'selector' => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-input',
            ]
        );

        $this->add_control(
            'input_border_show',
            [
                'label'     => esc_html__('Border Style', 'themescamp-core'),
                'type'      => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'input_border',
                'label'       => esc_html__('Border', 'themescamp-core'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-input',
                'condition'   => [
                    'input_border_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_radius',
            [
                'label'      => esc_html__('Border Radius', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => esc_html__('Padding', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Sign Up Button', 'themescamp-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $start = is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');
        $end = !is_rtl() ? esc_html__('Right', 'themescamp-plugin') : esc_html__('Left', 'themescamp-plugin');

        $this->add_control(
            'signup_button_positioning',
            [
                'label' => esc_html__('Position', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'unset' => esc_html__('unset', 'themescamp-plugin'),
                    'absolute' => esc_html__('absolute', 'themescamp-plugin'),
                    'relative' => esc_html__('relative', 'themescamp-plugin'),
                ],
                'label_block' => true,
                'default' => 'unset',
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'position: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'signup_button_offset_orientation_h',
            [
                'label' => esc_html__('Horizontal Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => $start,
                        'icon' => 'eicon-h-align-left',
                    ],
                    'end' => [
                        'title' => $end,
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'classes' => 'elementor-control-start-end',
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'signup_button_offset_x',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                    'body.rtl {{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                ],
                'condition' => [
                    'signup_button_offset_orientation_h!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'signup_button_offset_x_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'vh', 'custom'],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
                    'body.rtl {{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
                ],
                'condition' => [
                    'signup_button_offset_orientation_h' => 'end',
                ],
            ]
        );

        $this->add_control(
            'signup_button_offset_orientation_v',
            [
                'label' => esc_html__('Vertical Orientation', 'themescamp-plugin'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'default' => 'start',
                'options' => [
                    'start' => [
                        'title' => esc_html__('Top', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'end' => [
                        'title' => esc_html__('Bottom', 'themescamp-plugin'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'render_type' => 'ui',
            ]
        );

        $this->add_responsive_control(
            'signup_button_offset_y',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
                ],
                'condition' => [
                    'signup_button_offset_orientation_v!' => 'end',
                ],
            ]
        );

        $this->add_responsive_control(
            'signup_button_offset_y_end',
            [
                'label' => esc_html__('Offset', 'themescamp-plugin'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vh' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
                ],
                'condition' => [
                    'signup_button_offset_orientation_v' => 'end',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_content_display',
            [
                'label' => esc_html__('Button Content Display', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => 'block',
                'options' => [
                    'block' => esc_html__('Block', 'themescamp-elements'),
                    'flex' => esc_html__('Flex', 'themescamp-elements'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-content-wrapper' => 'display: {{VALUE}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'button_content_justify_content',
            [
                'label' => esc_html__( 'Justify Content', 'themescamp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => true,
                'default' => '',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start','themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-start-h',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-center-h',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-end-h',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Space Between', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-space-between-h',
                    ],
                    'space-around' => [
                        'title' => esc_html__( 'Space Around', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-space-around-h',
                    ],
                    'space-evenly' => [
                        'title' => esc_html__( 'Space Evenly', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-justify-space-evenly-h',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-content-wrapper' => 'justify-content: {{VALUE}};',
                ],
                'condition'=>[
                    'button_content_display'=>['flex']
                ],
                'responsive' => true,
            ]
        );
        $this->add_responsive_control(
            'button_content_align_items',
            [
                'label' => esc_html__( 'Align Items', 'themescamp-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => '',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-start-v',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-center-v',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-end-v',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Stretch', 'themescamp-elements' ),
                        'icon' => 'eicon-flex eicon-align-stretch-v',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-content-wrapper' => 'align-items: {{VALUE}};',
                ],
                'condition'=>[
                    'button_content_display' => ['flex']
                ],
                'responsive' => true,
            ]
        );
        $this->start_controls_tabs('tabs_button_style');
        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__('Text Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label'     => esc_html__('Background', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border',
                'label'       => esc_html__('Border', 'themescamp-core'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button',
            ]
        );

        $this->add_responsive_control(
            'radius',
            [
                'label'      => esc_html__('Border Radius', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label'      => esc_html__('Padding', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label'      => esc_html__('Width', 'themescamp-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'custom'],
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                    ],
                    '%'  => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-newsletter-signup-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-newsletter-signup-wrapper button' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'fullwidth_button' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_shadow',
                'selector' => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'label'    => esc_html__('Typography', 'themescamp-core'),
                'selector' => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'hover_color',
            [
                'label'     => esc_html__('Text Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label'     => esc_html__('Background', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'themescamp-core'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label'     => esc_html__('Signup Button Icon', 'themescamp-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mailchimp_button_icon[value]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_icon_width',
            [
                'label'      => esc_html__('Icon Size', 'themescamp-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw', 'custom'],
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                    ],
                    '%'  => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_signup_btn_icon_style');

        $this->start_controls_tab(
            'tab_signup_btn_icon_normal',
            [
                'label' => esc_html__('Normal', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'signup_btn_icon_color',
            [
                'label'     => esc_html__('Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'signup_btn_icon_background',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'signup_btn_icon_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon',
            ]
        );

        $this->add_responsive_control(
            'signup_btn_icon_radius',
            [
                'label'      => esc_html__('Border Radius', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'signup_btn_icon_padding',
            [
                'label'      => esc_html__('Padding', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'signup_btn_icon_margin',
            [
                'label'      => esc_html__('Margin', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'signup_btn_icon_shadow',
                'selector' => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'signup_btn_icon_typography',
                'selector'  => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_signup_btn_icon_hover',
            [
                'label' => esc_html__('Hover', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'signup_btn_icon_hover_color',
            [
                'label'     => esc_html__('Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon'     => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper .tcg-newsletter-btn-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'signup_btn_icon_hover_background',
                'selector' => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button:hover .tcg-newsletter-btn-icon',
            ]
        );

        $this->add_control(
            'icon_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'signup_btn_icon_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-mailchimp .tcg-newsletter-signup-wrapper button:hover .tcg-newsletter-btn-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_before_text',
            [
                'label'     => esc_html__('Before Text', 'themescamp-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'before_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'before_text_color',
            [
                'label'     => esc_html__('Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-newsletter-before-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'before_text_spacing',
            [
                'label'     => esc_html__('Spacing', 'themescamp-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-newsletter-before-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'before_text_typography',
                'label'    => esc_html__('Typography', 'themescamp-core'),
                'selector' => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-newsletter-before-text',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_after_text',
            [
                'label'     => esc_html__('After Text', 'themescamp-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'after_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'after_text_color',
            [
                'label'     => esc_html__('Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-newsletter-after-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'after_text_spacing',
            [
                'label'     => esc_html__('Spacing', 'themescamp-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-newsletter-after-text' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'after_text_typography',
                'label'    => esc_html__('Typography', 'themescamp-core'),
                'selector' => '{{WRAPPER}} .tcg-newsletter-wrapper .tcg-newsletter-after-text',
            ]
        );

        $this->end_controls_section();
    }

    public function render_text($settings)
    {

        $this->add_render_attribute('content-wrapper', 'class', 'tcg-newsletter-btn-content-wrapper');

        if ('left' == $settings['icon_align'] or 'right' == $settings['icon_align']) {
            $this->add_render_attribute('content-wrapper', 'class', 'tcg-flex tcg-flex-middle tcg-flex-center');
        }

        $this->add_render_attribute('content-wrapper', 'class', ('top' == $settings['icon_align']) ? 'tcg-flex tcg-flex-column tcg-flex-center' : '');
        $this->add_render_attribute('content-wrapper', 'class', ('bottom' == $settings['icon_align']) ? 'tcg-flex tcg-flex-column-reverse tcg-flex-center' : '');

        $this->add_render_attribute('icon-align', 'class', 'elementor-align-icon-' . $settings['icon_align']);
        $this->add_render_attribute('icon-align', 'class', 'tcg-newsletter-btn-icon');

        $this->add_render_attribute('text', 'class', ['tcg-newsletter-btn-text', 'tcg-display-inline-block']);
        $this->add_inline_editing_attributes('text', 'none');

        if (! isset($settings['icon']) && ! Icons_Manager::is_migration_allowed()) {
            // add old default
            $settings['icon'] = 'fas fa-arrow-right';
        }

        $migrated = isset($settings['__fa4_migrated']['mailchimp_button_icon']);
        $is_new   = empty($settings['icon']) && Icons_Manager::is_migration_allowed();

?>
        <div <?php $this->print_render_attribute_string('content-wrapper'); ?>>
            <?php if (! empty($settings['mailchimp_button_icon']['value'])) : ?>
                <div class="tcg-newsletter-btn-icon tcg-flex-align-<?php echo esc_attr($settings['icon_align']); ?>">

                    <?php if ($is_new || $migrated) :
                        Icons_Manager::render_icon($settings['mailchimp_button_icon'], ['aria-hidden' => 'true', 'class' => 'fa-fw']);
                    else : ?>
                        <i class="<?php echo esc_attr($settings['icon']); ?>" aria-hidden="true"></i>
                    <?php endif; ?>

                </div>
            <?php endif; ?>
            <div <?php $this->print_render_attribute_string('text'); ?>>
                <?php echo wp_kses($settings['button_text'], [
                    'a'      => [
                        'href'  => [],
                        'title' => [],
                        'class' => [],
                    ],
                    'br'     => [],
                    'em'     => [],
                    'strong' => [],
                    'hr'     => [],
                ]); ?>
            </div>
        </div>
        <?php
    }

    public function render_before_icon()
    {
        $settings = $this->get_settings_for_display();

        $migrated = isset($settings['__fa4_migrated']['mailchimp_before_icon']);
        $is_new   = empty($settings['before_icon']) && Icons_Manager::is_migration_allowed();

        if ($settings['show_before_icon'] and ! empty($settings['mailchimp_before_icon']['value'])) : ?>
            <div class="tcg-before-icon">
                <div class="tcg-newsletter-before-icon">

                    <?php if ($is_new || $migrated) :
                        Icons_Manager::render_icon($settings['mailchimp_before_icon'], ['aria-hidden' => 'true', 'class' => 'fa-fw']);
                    else : ?>
                        <i class="<?php echo esc_attr($settings['before_icon']); ?>" aria-hidden="true"></i>
                    <?php endif; ?>

                </div>
            </div>
        <?php endif;
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        $id       = 'tcg-mailchimp-' . $this->get_id();

        // $space = ( '' !== $settings['space'] ) ? ' tcg-grid-' . $settings['space'] : '';

        if ($settings['button_text']) {
            $button_text = $settings['button_text'];
        } else {
            $button_text = esc_html__('Subscribe', 'themescamp-core');
        }

        $this->add_render_attribute('input-wrapper', 'class', 'tcg-newsletter-input-wrapper');

        // if ( $settings['fullwidth_input'] ) {
        // 	$this->add_render_attribute( 'input-wrapper', 'class', 'tcg-width-1-1' );
        // } else {
        // 	$this->add_render_attribute( 'input-wrapper', 'class', 'tcg-width-expand' );
        // }

        if (! isset($settings['before_icon']) && ! Icons_Manager::is_migration_allowed()) {
            // add old default
            $settings['before_icon'] = 'fas fa-envelope-open';
        }

        $form_id = ! empty($settings['_element_id']) ? 'tcg-sf-' . $settings['_element_id'] : 'tcg-sf-' . $id;

        ?>
        <div class="tcg-newsletter-wrapper">

            <?php if (! empty($settings['before_text'])) : ?>
                <div class="tcg-newsletter-before-text">
                    <?php echo esc_html($settings['before_text']); ?>
                </div>
            <?php endif; ?>

            <form action="<?php echo esc_url(site_url()); ?>/wp-admin/admin-ajax.php" class="tcg-mailchimp tcg-flex">

                <?php if ($settings['before_icon_inline'] !== 'yes') {
                    $this->render_before_icon();
                } ?>

                <?php if ($settings['show_fname'] == 'yes') : ?>
                    <div <?php $this->print_render_attribute_string('input-wrapper'); ?>>
                        <div class="tcg-position-relative">
                            <?php if ($settings['before_icon_inline'] == 'yes') {
                                if ($settings['show_before_icon'] and ! empty($settings['mailchimp_before_icon']['value'])) : ?>
                                    <div class="tcg-width-auto tcg-before-icon">
                                        <div class="tcg-newsletter-before-icon">
                                            <i class="ep-icon-user-circle-o" aria-hidden="true"></i>
                                        </div>
                                    </div>
                            <?php endif;
                            } ?>
                            <input type="text" name="fname" placeholder="<?php echo esc_html($settings['fname_field_placeholder']); ?>" class="tcg-input" />

                        </div>
                    </div>
                <?php endif; ?>

                <div <?php $this->print_render_attribute_string('input-wrapper'); ?>>
                    <div class="tcg-position-relative">
                        <?php if ($settings['before_icon_inline'] == 'yes') {
                            $this->render_before_icon();
                        } ?>
                        <input type="email" name="email" placeholder="<?php echo esc_html($settings['email_field_placeholder']); ?>"
                            required class="tcg-input" />
                        <input type="hidden" name="action" value="tcg_mailchimp_subscribe" />
                        <input type="hidden" name="<?php echo esc_attr($form_id); ?>" value="true" />
                        <!-- we need action parameter to receive ajax request in WordPress -->
                        <?php if ($settings['button_position'] === 'inside_inputs') : ?>
                            <div class="tcg-newsletter-signup-wrapper">
                                <button type="submit" <?php $this->print_render_attribute_string('signup_button'); ?>>
                                    <?php $this->render_text($settings); ?>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Add Checkbox -->
                <?php if ('yes' === $settings['show_checkbox']) : ?>
                    <div class="tcg-newsletter-checkbox-wrapper form-check">
                        <input type="checkbox" class="form-check-input" id="tcg-newsletter-checkbox-<?php echo esc_attr($id); ?>" name="agree_terms" required />
                        <label for="tcg-newsletter-checkbox-<?php echo esc_attr($id); ?>" class="tcg-newsletter-checkbox-label">
                            <?php echo esc_html($settings['checkbox_label']); ?>
                        </label>
                    </div>
                <?php endif; ?>
                <?php


                $this->add_render_attribute('signup_button', 'class', ['tcg-newsletter-btn', 'tcg-button', 'tcg-button-primary', 'tcg-width-1-1']);

                if ($settings['hover_animation']) {
                    $this->add_render_attribute('signup_button', 'class', 'elementor-animation-' . $settings['hover_animation']);
                }

                ?>
                <?php if ($settings['button_position'] === 'end_of_form') : ?>
                    <div class="tcg-newsletter-signup-wrapper">
                        <button type="submit" <?php $this->print_render_attribute_string('signup_button'); ?>>
                            <?php $this->render_text($settings); ?>
                        </button>
                    </div>
                <?php endif; ?>
            </form>

            <!-- after text -->
            <?php if (! empty($settings['after_text'])) : ?>
                <div class="tcg-newsletter-after-text">
                    <?php echo esc_html($settings['after_text']); ?>
                </div>
            <?php endif; ?>

        </div><!-- end newsletter-signup -->


<?php
    }
}
