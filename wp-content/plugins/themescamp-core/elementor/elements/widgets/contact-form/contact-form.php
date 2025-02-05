<?php

namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (! defined('ABSPATH'))
    exit; // Exit if accessed directly

class TCG_Contact_Form extends Widget_Base
{

    public function get_name()
    {
        return 'tcg-contact-form';
    }

    public function get_title()
    {
        return esc_html__('Contact Form', 'themescamp-core');
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
    }

    public function get_categories()
    {
        return ['themescamp-elements'];
    }

    //script depend
    public function get_script_depends()
    {
        if (!empty(themescamp_settings('tcg_contact_form_recaptcha_secret_key')) && !empty(themescamp_settings('tcg_contact_form_recaptcha_site_key'))) {
            return ['contact-form', 'recaptcha'];
        } else {
            return ['contact-form'];
        }
    }

    public function get_keywords()
    {
        return ['simple', 'contact', 'form', 'email'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'section_forms_layout',
            [
                'label' => esc_html__('Forms Layout', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'show_labels',
            [
                'label'   => esc_html__('Label', 'themescamp-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'     => esc_html__('Alignment', 'themescamp-core'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'     => [
                        'title' => esc_html__('Left', 'themescamp-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'   => [
                        'title' => esc_html__('Center', 'themescamp-core'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'themescamp-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.tcg-all-field-inline--yes .tcg-contact-form-form' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'all_field_inline' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label'     => esc_html__('Text Align', 'themescamp-core'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'left',
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-contact-form-form, {{WRAPPER}} .tcg-contact-form-form input, {{WRAPPER}} .tcg-contact-form-form textarea' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'field_usage_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => esc_html__('Note: Each field type can only be used once.', 'themescamp-core'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'field_type',
            [
                'label'   => esc_html__('Field Type', 'themescamp-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'name'     => esc_html__('Name', 'themescamp-core'),
                    'email'    => esc_html__('Email', 'themescamp-core'),
                    'subject'    => esc_html__('Subject', 'themescamp-core'),
                    'tel'      => esc_html__('Tel', 'themescamp-core'),
                    'message' => esc_html__('message', 'themescamp-core'),
                    'select'   => esc_html__('Select', 'themescamp-core'),
                    'checkbox' => esc_html__('Checkbox', 'themescamp-core'),
                ],
            ]
        );

        $repeater->add_control(
            'name_field_type',
            [
                'label'   => esc_html__('Name Field Type', 'themescamp-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'single',
                'options' => [
                    'single' => esc_html__('Single Field', 'themescamp-core'),
                    'double' => esc_html__('Double Field', 'themescamp-core'),
                ],
                'condition' => [
                    'field_type' => 'name',
                ],
            ]
        );

        $repeater->add_control(
            'field_label',
            [
                'label'   => esc_html__('Label', 'themescamp-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Field Label', 'themescamp-core'),
            ]
        );

        $repeater->add_control(
            'field_options',
            [
                'label'       => esc_html__('Options', 'themescamp-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => "Select 1,Select 2,Select 3",
                'description' => esc_html__('Seperate your options with comma ",".', 'themescamp-core'),
                'condition'   => [
                    'field_type' => 'select',
                ],
            ]
        );

        $repeater->add_control(
            'field_placeholder',
            [
                'label'   => esc_html__('Placeholder', 'themescamp-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Field Placeholder', 'themescamp-core'),
            ]
        );

        $repeater->add_control(
            'field2_placeholder',
            [
                'label'   => esc_html__('Field 2 Placeholder', 'themescamp-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Field Placeholder', 'themescamp-core'),
                'condition' => [
                    'field_type'        => 'name',
                    'name_field_type' => 'double',
                ],
            ]
        );

        $repeater->add_control(
            'field_required',
            [
                'label'   => esc_html__('Required', 'themescamp-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'form_fields',
            [
            'label'       => esc_html__('Form Fields', 'themescamp-core'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [
                'field_type'        => 'name',
                'field_label'       => esc_html__('Name', 'themescamp-core'),
                'field_placeholder' => esc_html__('Your Name', 'themescamp-core'),
                'field_required'    => 'yes',
                ],
                [
                'field_type'        => 'email',
                'field_label'       => esc_html__('Email', 'themescamp-core'),
                'field_placeholder' => esc_html__('Your Email', 'themescamp-core'),
                'field_required'    => 'yes',
                ],
                [
                'field_type'        => 'message',
                'field_label'       => esc_html__('Message', 'themescamp-core'),
                'field_placeholder' => esc_html__('Your Message', 'themescamp-core'),
                'field_required'    => 'yes',
                ],
            ],
            'title_field' => '{{{ field_label }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_submit_button',
            [
                'label' => esc_html__('Submit Button', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'   => esc_html__('Text', 'themescamp-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Send Message', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label'   => esc_html__('Size', 'themescamp-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''           => esc_html__('Default', 'themescamp-core'),
                    'full-width' => esc_html__('Full Width', 'themescamp-core'),
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'        => esc_html__('Alignment', 'themescamp-core'),
                'type'         => Controls_Manager::CHOOSE,
                'default'      => '',
                'options'      => [
                    'start'   => [
                        'title' => esc_html__('Left', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__('Center', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'end'     => [
                        'title' => esc_html__('Right', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'stretch' => [
                        'title' => esc_html__('Justified', 'themescamp-core'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-button-align-',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_forms_additional_options',
            [
                'label' => esc_html__('Additional Options', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'show_additional_message',
            [
                'label' => esc_html__('Additional Bottom Message', 'themescamp-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'additional_message',
            [
                'label'     => esc_html__('Message', 'themescamp-core'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('Note: You have to fill-up above all respective field, then click below button for send your message', 'themescamp-core'),
                'condition' => [
                    'show_additional_message' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_recaptcha',
            [
                'label'       => esc_html__('reCAPTCHA Enable', 'themescamp-core'),
                'description' => esc_html__('Make sure you set the invisible reCAPTCHA key in settings.', 'themescamp-core'),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'yes',
            ]
        );

        $this->add_control(
            'hide_recaptcha_badge',
            [
                'label'        => esc_html__('Hide reCAPTCHA Bagde', 'themescamp-core'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'tcg-hide-recaptcha-badge-',
                'condition'    => [
                    'show_recaptcha' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'message_rows',
            [
                'label'   => esc_html__('Message Rows', 'themescamp-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '1'  => '1',
                    '2'  => '2',
                    '3'  => '3',
                    '4'  => '4',
                    '5'  => '5',
                    '6'  => '6',
                    '7'  => '7',
                    '8'  => '8',
                    '9'  => '9',
                    '10' => '10',
                ],
            ]
        );

        $this->add_control(
            'redirect_after_submit',
            [
                'label'     => esc_html__('Redirect After Submit', 'themescamp-core'),
                'type'      => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'redirect_url',
            [
                'type'          => Controls_Manager::URL,
                'show_label'    => false,
                'show_external' => false,
                'separator'     => false,
                'placeholder'   => 'http://your-link.com/',
                'description'   => esc_html__('Note: Because of security reasons, you can ONLY use your current domain here.', 'themescamp-core'),
                'condition'     => [
                    'redirect_after_submit' => 'yes',
                ],
                'dynamic'       => ['active' => true],
            ]
        );

        $this->add_control(
            'reset_after_submit',
            [
                'label' => esc_html__('Reset After Submit', 'themescamp-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Form Style', 'themescamp-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label'     => esc_html__('Field Space', 'themescamp-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => '15',
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-field-group:not(:last-child)'               => 'margin-bottom: {{SIZE}}{{UNIT}};margin-top: 0;',
                    '{{WRAPPER}} .tcg-name-email-inline + .tcg-name-email-inline' => 'padding-left: {{SIZE}}px',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label' => esc_html__('Form Wrapper Style', 'themescamp-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'wrapper_background',
                'selector' => '{{WRAPPER}} .tcg-contact-form .tcg-contact-form-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wrapper_border',
                'selector' => '{{WRAPPER}} .tcg-contact-form .tcg-contact-form-wrapper',
            ]
        );

        $this->add_control(
            'wrapper_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-contact-form .tcg-contact-form-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'wrapper_box_shadow',
                'selector' => '{{WRAPPER}} .tcg-contact-form .tcg-contact-form-wrapper',
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => esc_html__('Padding', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-contact-form .tcg-contact-form-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label'      => esc_html__('Margin', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-contact-form .tcg-contact-form-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_labels',
            [
                'label'     => esc_html__('Label', 'themescamp-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_labels!' => '',
                ],
            ]
        );

        $this->add_control(
            'label_spacing',
            [
                'label'     => esc_html__('Spacing', 'themescamp-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-field-group > label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => esc_html__('Text Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-form-label' => 'color: {{VALUE}};',
                ],
                // 'scheme' => [
                // 	'type'  => Schemes\Color::get_type(),
                // 	'value' => Schemes\Color::COLOR_3,
                // ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_typography',
                'selector' => '{{WRAPPER}} .tcg-form-label',
                //'scheme'   => Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_field_style',
            [
                'label' => esc_html__('Fields', 'themescamp-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_field_style');

        $this->start_controls_tab(
            'tab_field_normal',
            [
                'label' => esc_html__('Normal', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'field_text_color',
            [
                'label'     => esc_html__('Text Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-field-group .tcg-input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-field-group textarea'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'field_placeholder_color',
            [
                'label'     => esc_html__('Placeholder Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-field-group .tcg-input::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-field-group textarea::placeholder'   => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'field_background_color',
            [
                'label'     => esc_html__('Background Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-field-group .tcg-input' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-field-group textarea'   => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'field_border',
                'label'       => esc_html__('Border', 'themescamp-core'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tcg-field-group .tcg-input, {{WRAPPER}} .tcg-field-group textarea',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'field_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-field-group .tcg-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-field-group textarea'   => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'field_box_shadow',
                'selector' => '{{WRAPPER}} .tcg-field-group .tcg-input, {{WRAPPER}} .tcg-field-group textarea',
            ]
        );

        $this->add_responsive_control(
            'field_padding',
            [
                'label'      => esc_html__('Padding', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-field-group .tcg-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
                    '{{WRAPPER}} .tcg-field-group textarea'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; height: auto;',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'field_typography',
                'label'     => esc_html__('Typography', 'themescamp-core'),
                //'scheme'    => Schemes\Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .tcg-field-group .tcg-input, {{WRAPPER}} .tcg-field-group textarea',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_field_focus',
            [
                'label' => esc_html__('Focus', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'field_focus_background',
            [
                'label'     => esc_html__('Background', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-field-group .tcg-input:focus' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-field-group textarea:focus'   => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'field_focus_border_color',
            [
                'label'     => esc_html__('Border Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-field-group .tcg-input:focus' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-field-group textarea:focus'   => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'field_border_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_submit_button_style',
            [
                'label' => esc_html__('Submit Button', 'themescamp-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
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
                    '{{WRAPPER}} .tcg-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                //'scheme'   => Schemes\Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .tcg-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'button_background_color',
                'separator' => 'before',
                'selector'  => '{{WRAPPER}} .tcg-button'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'button_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .tcg-button',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_text_padding',
            [
                'label'      => esc_html__('Padding', 'themescamp-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tcg-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
            'button_hover_color',
            [
                'label'     => esc_html__('Text Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'button_background_hover_color',
                'separator' => 'before',
                'selector'  => '{{WRAPPER}} .tcg-button:hover'
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .tcg-button:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'button_border_border!' => '',
                ],
            ]
        );

        $this->add_control(
            'button_hover_animation',
            [
                'label' => esc_html__('Animation', 'themescamp-core'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_additional_style',
            [
                'label'     => esc_html__('Additional Message', 'themescamp-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_additional_message!' => '',
                ],
            ]
        );

        $this->add_control(
            'additional_text_color',
            [
                'name'      => 'additional_text_color',
                'label'     => esc_html__('Color', 'themescamp-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-contact-form-additional-message' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'additional_text_typography',
                //'scheme'   => Schemes\Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .tcg-contact-form-additional-message',
            ]
        );

        $this->end_controls_section();
    }

    public function form_fields_render_attributes()
    {
        $settings        = $this->get_settings_for_display();
        $id              = $this->get_id();
        $tcg_contact_form_recaptcha_site_key = themescamp_settings('tcg_contact_form_recaptcha_site_key');
        $tcg_contact_form_recaptcha_secret_key = themescamp_settings('tcg_contact_form_recaptcha_secret_key');

        if (! empty($settings['button_size'])) {
            $this->add_render_attribute('button', 'class', 'tcg-button-' . $settings['button_size']);
        }

        if ($settings['button_hover_animation']) {
            $this->add_render_attribute('button', 'class', 'elementor-animation-' . $settings['button_hover_animation']);
        }

        $this->add_render_attribute(
            [
                'wrapper'             => [
                    'class' => [
                        'elementor-form-fields-wrapper',
                    ],
                ],
                'field-group'         => [
                    'class' => [
                        'tcg-field-group',
                        'tcg-width-1-1',
                    ],
                ],
                'submit-group'        => [
                    'class' => [
                        'elementor-field-type-submit',
                        'tcg-field-group',
                        'tcg-flex',
                        'tcg-width-1-1',
                    ],
                ],

                'button'              => [
                    'class' => [
                        'elementor-button',
                        'tcg-button',
                        'tcg-button-primary',
                    ],
                    'name'  => 'submit',
                ],
                'user_name_label'     => [
                    'for'   => 'user_name' . $id,
                    'class' => [
                        'tcg-form-label',
                    ]
                ],
                'contact_label'       => [
                    'for'   => 'contact' . $id,
                    'class' => [
                        'tcg-form-label',
                    ]
                ],
                'subject_label'       => [
                    'for'   => 'subject' . $id,
                    'class' => [
                        'tcg-form-label',
                    ]
                ],
                'email_address_label' => [
                    'for'   => 'email' . $id,
                    'class' => [
                        'tcg-form-label',
                    ]
                ],
                'message_label'       => [
                    'for'   => 'message' . $id,
                    'class' => [
                        'tcg-form-label',
                    ]
                ],
            ]
        );

        if (isset($settings['show_recaptcha']) && $settings['show_recaptcha'] == 'yes') {
            if (! empty($tcg_contact_form_recaptcha_site_key) and ! empty($tcg_contact_form_recaptcha_secret_key)) {
                $this->add_render_attribute('button', 'data-sitekey', $tcg_contact_form_recaptcha_site_key);
                $this->add_render_attribute('button', 'data-callback', 'tcgGICCB');
                $this->add_render_attribute('button', 'class', 'g-recaptcha');
            }
        }

        if (! $settings['show_labels']) {
            $this->add_render_attribute('label', 'class', 'elementor-screen-only');
        }

        $this->add_render_attribute('field-group', 'class', 'elementor-field-required')
            ->add_render_attribute('input', 'required', 'required')
            ->add_render_attribute('input', 'aria-required', 'true');
    }



    public function render()
    {
        $this->form_fields_render_attributes();

?>
        <div class="tcg-contact-form tcg-contact-form-skin-default">
            <div class="elementor-form-fields-wrapper">
                <?php $this->contact_form_html(); ?>
            </div>
        </div>
    <?php
    }

    public function contact_form_html()
    {
        $settings        = $this->get_settings_for_display();
        $tcg_contact_form_recaptcha_site_key = themescamp_settings('tcg_contact_form_recaptcha_site_key');
        $tcg_contact_form_recaptcha_secret_key = themescamp_settings('tcg_contact_form_recaptcha_secret_key');
        $id              = $this->get_id();
        $form_id         = ! empty($settings['_element_id']) ? 'tcg-sf-' . $settings['_element_id'] : 'tcg-sf-' . $id;

        $this->add_render_attribute('contact-form', 'class', ['tcg-contact-form-form', 'tcg-form-stacked', 'tcg-grid', 'tcg-grid-small']);
        $this->add_render_attribute('contact-form', 'data-tcg-grid', '');
        $this->add_render_attribute('contact-form', 'action', site_url() . '/wp-admin/admin-ajax.php');
        $this->add_render_attribute('contact-form', 'method', 'post');


        if (isset($settings['show_recaptcha']) && $settings['show_recaptcha'] == 'yes') {
            if (empty($tcg_contact_form_recaptcha_site_key) and empty($tcg_contact_form_recaptcha_secret_key)) {
                $this->add_render_attribute('contact-form', 'class', 'without-recaptcha');
            }
        } else {
            $this->add_render_attribute('contact-form', 'class', 'without-recaptcha');
        }


        $this->add_render_attribute('name-email-field-group', 'class', ['tcg-field-group', 'elementor-field-required']);

        if ($settings['name_email_field_inline']) {
            $this->add_render_attribute('name-email-field-group', 'class', ['tcg-width-1-2@m', 'tcg-name-email-inline']);
        } else {
            $this->add_render_attribute('name-email-field-group', 'class', 'tcg-width-1-1');
        }

    ?>
        <div class="tcg-contact-form-wrapper">
            <form <?php $this->print_render_attribute_string('contact-form'); ?>>

                <?php if ($settings['two_columns']) : ?>
                    <div class="tcg-width-1-2">
                    <?php endif; ?>

                    <?php 
                    $rendered_fields = [];
                    foreach ($settings['form_fields'] as $index => $item) :
                        
                        if (in_array($item['field_type'], $rendered_fields)) {
                            continue;
                        }

                        $rendered_fields[] = $item['field_type'];

                        $is_field_required = $item['field_required'] == 'yes' ? 'required="required"' : '';

                        if ($item['field_type'] == 'name' || $item['field_type'] == 'email') { ?>
                            <div <?php $this->print_render_attribute_string('name-email-field-group'); ?>>
                        <?php } else { ?>
                            <div <?php $this->print_render_attribute_string('field-group'); ?>>
                        <?php };
                            $field_id = 'field_' . $index . '_' . $item['_id'];

                            if ($settings['show_labels'] && $item['field_type'] != 'checkbox') {
                                echo '<label for="' . esc_attr($field_id) . '" class="tcg-form-label">' . esc_html($item['field_label']) . '</label>';
                            }
                            $name_field_double = '';
                            if($item['field_type'] == 'name' && $item['name_field_type'] == 'double') {
                                $name_field_double = ' name-field-double';
                            };

                            echo '<div class="tcg-form-controls tcg-form-control-'. $item['field_type'] . $name_field_double .'">';
                            switch ($item['field_type']) {
                                case 'message':
                                    echo '<textarea name="message" id="'. $field_id .'" placeholder="'. $item['field_placeholder'] .'" class="tcg-textarea" rows="5" '. $is_field_required .'></textarea>';
                                    break;
                                case 'name':
                                    echo '<input type="text" name="name" id="'. $field_id .'" placeholder="'. $item['field_placeholder'] .'" class="tcg-input" '. $is_field_required .'>';
                                    if($item['name_field_type'] == 'double') {
                                        echo '<input type="text" name="name2" id="'. $field_id .'" placeholder="'. $item['field_placeholder'] .'" class="tcg-input" '. $is_field_required .'>';
                                    }
                                    break;
                                case 'email':
                                    echo '<input type="email" name="email" id="'. $field_id .'" placeholder="'. $item['field_placeholder'] .'" class="tcg-input" '. $is_field_required .'>';
                                    break;
                                case 'tel':
                                    echo '<input type="tel" name="contact" id="'. $field_id .'" placeholder="'. $item['field_placeholder'] .'" class="tcg-input" '. $is_field_required .'>';
                                    break;
                                case 'subject':
                                    echo '<input type="text" name="subject" id="'. $field_id .'" placeholder="'. $item['field_placeholder'] .'" class="tcg-input" '. $is_field_required .'>';
                                    break;
                                case 'checkbox':
                                    echo '<input type="checkbox" name="checkbox" id="'. $field_id .'" placeholder="'. $item['field_placeholder'] .'" class="tcg-input" '. $is_field_required .'>';
                                    echo '<label for="'. $field_id .'" class="tcg-form-label">' . esc_html($item['field_label']) . '</label>';
                                    break;
                                case 'select':
                                    echo '<select name="select" id="'. $field_id .'" class="tcg-input" '. $is_field_required .'>';
                                    $options = explode(',', $item['field_options']);
                                    foreach ($options as $option) {
                                        $value = strtolower(str_replace(' ', '-', trim($option)));
                                        echo '<option value="' . esc_attr($value) . '">' . esc_html(trim($option)) . '</option>';
                                    }
                                    echo '</select>';
                                    break;
                                
                            }
                            echo '</div>';
                            ?>
                        </div>
                    <?php endforeach; ?>

                    

                    <?php if ('yes' === $settings['show_additional_message']) : ?>
                        <div <?php $this->print_render_attribute_string('field-group'); ?>>
                            <span class="tcg-contact-form-additional-message">
                                <?php echo wp_kses($settings['additional_message'], [
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
                            </span>
                        </div>
                    <?php endif; ?>


                    <?php if (($settings['redirect_after_submit'] == 'yes') && ! empty($settings['redirect_url']['url'])) :
                        $redirect_url      = $settings['redirect_url']['url'];
                        $redirect_extarnal = (isset($settings['redirect_url']['is_external']) && ($settings['redirect_url']['is_external']) == 'on') ? '_blank' : '_self';
                    ?>
                        <input type="hidden" name="redirect-url" value="<?php
                                                                        echo esc_url($redirect_url) ?>" />

                        <input type="hidden" name="is-external" value="<?php
                                                                        echo esc_html($redirect_extarnal) ?>" />

                    <?php endif; ?>

                    <?php if ($settings['reset_after_submit'] == 'yes') : ?>
                        <input type="hidden" name="reset-after-submit"
                            value="<?php echo wp_kses_post($settings['reset_after_submit']); ?>" />
                    <?php endif; ?>

                    <input type="hidden" class="widget_id" name="widget_id" value="<?php
                                                                                    echo esc_attr($id); ?>" />
                    <input type="hidden" name="<?php echo esc_attr($form_id); ?>" value="true" />
                    <input type="hidden" class="page_id" name="page_id" value="<?php echo esc_attr(get_the_ID()); ?>" />

                    <div <?php $this->print_render_attribute_string('submit-group'); ?>>
                        <button type="submit" <?php $this->print_render_attribute_string('button'); ?>>
                            <?php if (! empty($settings['button_text'])) : ?>
                                <span>
                                    <?php echo esc_html($settings['button_text']); ?>
                                </span>
                            <?php endif; ?>
                        </button>
                    </div>

                    <input name="recaptcha" value="<?php if (isset($settings['show_recaptcha']) && $settings['show_recaptcha'] == 'yes' && !empty($tcg_contact_form_recaptcha_site_key) && !empty($tcg_contact_form_recaptcha_secret_key)) echo esc_attr('true');
                                                    else echo esc_attr('false'); ?>" type="hidden">

                    <input name="_wpnonce" value="<?php echo esc_attr(wp_create_nonce("tcgContactForm")); ?>" type="hidden">

                    <input type="hidden" name="action" value="tcg_contact_form" />

                    <?php if ($settings['two_columns']) : ?>
                    </div>
                <?php endif; ?>

            </form>
        </div>
<?php
    }
}
