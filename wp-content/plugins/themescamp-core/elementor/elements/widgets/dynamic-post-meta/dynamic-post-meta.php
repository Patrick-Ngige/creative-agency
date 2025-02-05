<?php

namespace ThemescampPlugin\Elementor\Elements\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Css_Filter;
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


if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.1.0
 */
class TCG_Dynamic_Post_Meta extends Widget_Base
{

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
    public function get_name()
    {
        return 'tcg-dynamic-post-meta';
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
    public function get_title()
    {
        return esc_html__('TC Dynamic Post Meta', 'themescamp-plugin');
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
    public function get_icon()
    {
        return 'eicon-document-file';
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
    public function get_keywords()
    {
        return ['posts', 'blogs', 'portfolio'];
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
        return ['themescamp-core'];
    }

    /**
     * Retrieve the list of scripts the widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['container-hover'];
    }

    /**
     * Register icon list widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */

    protected function register_controls()
    {

        $this->start_controls_section(
            'tcg_section_post__filters',
            [
                'label' => __('Query', 'themescamp-plugin'),
            ]
        );

        $this->add_control(
            'data_type',
            [
                'label' => __('Data Type', 'themescamp-plugin'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'title' => 'Title',
                    'date' => 'Date',
                    'time' => 'Time',
                    'excerpt' => 'Excerpt',
                    'author' => 'Author',
                    'avatar' => 'Avatar',
                    'role' => 'Role',
                    'categories' => 'Categories',
                    'tags' => 'Tags',
                    'comments' => 'Comments',
                    'port-sec' => 'image-sec (portfolio)',
                    'woo-price' => 'Price (Woocommerce)',
                    'woo-reviews' => 'Reviews (Woocommerce)',
                ],
                'default' => 'title',

            ]
        );

        $this->add_control(
            'woo_reviews_text',
            [
                'label' => esc_html__('Review Text', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Reviews', 'themescamp-core'),
                'condition' => [
                    'data_type' => ['woo-reviews'],
                ],
            ]
        );
        $this->add_control(
            'woo_no_reviews_text',
            [
                'label' => esc_html__('No Reviews Text', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('No Reviews', 'themescamp-core'),
                'condition' => [
                    'data_type' => ['woo-reviews'],
                ],
            ]
        );

        $this->add_control(
            'meta_separator',
            [
                'label' => esc_html__('Categories/tags Separator', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'default' => ' / ',
                'condition' => [
                    'data_type' => ['categories', 'tags'],
                ],
            ]
        );

        $this->add_control(
            'date_format',
            [
                'label' => esc_html__('Date Format', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => 'Default',
                    '0' => _x('March 6, 2018 (F j, Y)', 'Date Format', 'themescamp-core'),
                    '1' => '2018-03-06 (Y-m-d)',
                    '2' => '03/06/2018 (m/d/Y)',
                    '3' => '06/03/2018 (d/m/Y)',
                    'custom' => esc_html__('Custom', 'themescamp-core'),
                ],
                'condition' => [
                    'data_type' => 'date',
                ],
            ]
        );

        $this->add_control(
            'custom_date_format',
            [
                'label' => esc_html__('Custom Date Format', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'F j, Y',
                'condition' => [
                    'data_type' => 'date',
                    'date_format' => 'custom',
                ],
                'description' => sprintf(
                    /* translators: %s: Allowed data letters (see: http://php.net/manual/en/function.date.php). */
                    __('Use the letters: %s', 'themescamp-core'),
                    'l D d j S F m M n Y y'
                ),
            ]
        );

        $this->add_control(
            'use_days_ago',
            [
                'label' => esc_html__('Use Days Ago', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'themescamp-core'),
                'label_off' => esc_html__('No', 'themescamp-core'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'data_type' => 'date',
                ],
            ]
        );

        $this->add_control(
            'custom_days_ago_text',
            [
                'label' => esc_html__('Days Ago Text', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Days ago', 'themescamp-core'),
                'placeholder' => esc_html__('Enter custom text', 'themescamp-core'),
                'condition' => [
                    'data_type' => 'date',
                    'use_days_ago' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'days_ago_limit',
            [
                'label' => esc_html__('Days Ago Limit', 'themescamp-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 7,
                'min' => 1,
                'max' => 365,
                'step' => 1,
                'condition' => [
                    'data_type' => 'date',
                    'use_days_ago' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'time_format',
            [
                'label' => esc_html__('Time Format', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => 'Default',
                    '0' => '3:31 pm (g:i a)',
                    '1' => '3:31 PM (g:i A)',
                    '2' => '15:31 (H:i)',
                    'custom' => esc_html__('Custom', 'themescamp-core'),
                ],
                'condition' => [
                    'data_type' => 'time',
                ],
            ]
        );

        $this->add_control(
            'custom_time_format',
            [
                'label' => esc_html__('Custom Time Format', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'default' => 'g:i a',
                'placeholder' => 'g:i a',
                'condition' => [
                    'data_type' => 'time',
                    'time_format' => 'custom',
                ],
                'description' => sprintf(
                    /* translators: %s: Allowed time letters (see: http://php.net/manual/en/function.time.php). */
                    __('Use the letters: %s', 'themescamp-core'),
                    'g G H i a A'
                ),
            ]
        );

        $this->add_control(
            'use_hours_ago',
            [
                'label' => esc_html__('Use Hours Ago', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'themescamp-core'),
                'label_off' => esc_html__('No', 'themescamp-core'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'data_type' => 'time',
                ],
            ]
        );
        $this->add_control(
            'custom_hours_ago_text',
            [
                'label' => esc_html__('Hours Ago Text', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('hours ago', 'themescamp-core'),
                'placeholder' => esc_html__('Enter custom text', 'themescamp-core'),
                'condition' => [
                    'use_hours_ago' => 'yes',
                    'data_type' => 'time',
                ],
            ]
        );

        $this->add_control(
            'hours_ago_limit',
            [
                'label' => esc_html__('Hours Ago Limit', 'themescamp-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 24,
                'min' => 1,
                'max' => 96,
                'step' => 1,
                'condition' => [
                    'use_hours_ago' => 'yes',
                    'data_type' => 'time',
                ],
            ]
        );

        $this->add_control(
            'excerpt',
            [
                'label' => __('Blog Excerpt Length', 'themescamp-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => '150',
                'min' => 10,
                'condition' => [
                    'data_type' => 'excerpt',
                ],
            ]
        );

        $this->add_control(
            'excerpt_after',
            [
                'label' => __('After Excerpt text/symbol', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'data_type' => 'excerpt',
                ],
                'default' => '...',
            ]
        );

        $this->add_control(
            'comments_custom_strings',
            [
                'label' => esc_html__('Custom Format', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => false,
                'condition' => [
                    'data_type' => 'comments',
                ],
            ]
        );

        $this->add_control(
            'string_no_comments',
            [
                'label' => esc_html__('No Comments', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('No Comments', 'themescamp-core'),
                'condition' => [
                    'comments_custom_strings' => 'yes',
                    'data_type' => 'comments',
                ],
            ]
        );

        $this->add_control(
            'string_one_comment',
            [
                'label' => esc_html__('One Comment', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('One Comment', 'themescamp-core'),
                'condition' => [
                    'comments_custom_strings' => 'yes',
                    'data_type' => 'comments',
                ],
            ]
        );

        $this->add_control(
            'string_comments',
            [
                'label' => esc_html__('Comments', 'themescamp-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('%s Comments', 'themescamp-core'),
                'condition' => [
                    'comments_custom_strings' => 'yes',
                    'data_type' => 'comments',
                ],
            ]
        );

        $this->add_control(
            'header_size',
            [
                'label' => esc_html__('HTML Tag', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'themescamp-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'themescamp-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'themescamp-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'themescamp-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'themescamp-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Text', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('heading_color');
        $this->start_controls_tab(
            'text_normal',
            [
                'label' => esc_html__('Normal', 'themescamp-core'),
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-text',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-text',
            ]
        );

        $this->add_control(
            'heading_opacity',
            [
                'label' => esc_html__('Opacity', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_padding',
            [
                'label' => esc_html__( 'Padding', 'themescamp-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'heading_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'heading_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-text',
                'exclude' => ['image']
            ]
        );

        $this->add_control(
            'heading_blur_method',
            [
                'label' => esc_html__('Heading Blur Method', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'backdrop-filter' => 'backdrop-filter',
                    'filter' => 'filter',
                ],
                'default' => 'backdrop-filter',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text' => '{{VALUE}}: blur({{heading_blur.SIZE}}px);',
                ],
            ]
        );

        $this->add_control(
            'heading_blur',
            [
                'label' => esc_html__('Blur', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 250,
                    ],
                ],
            ]
        );

        $this->add_control(
            'text_wrap',
            [
                'label' => esc_html__('Text Wrap', 'themescamp-elements'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Default', 'themescamp-elements'),
                    'wrap' => esc_html__('Wrap', 'themescamp-elements'),
                    'nowrap' => esc_html__('No Wrap', 'themescamp-elements'),
                    'balance' => esc_html__('Balance', 'themescamp-elements'),
                    'pretty' => esc_html__('Pretty', 'themescamp-elements'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text' => 'text-wrap: {{VALUE}};'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'text_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-text',
            ]
        );
        $this->add_control(
            'text_dark_mode_heading',
            [
                'label' => esc_html__('Dark Mode', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title_color_dark_mode',
            [
                'label' => esc_html__( 'Title Color', 'themescamp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-post-meta-text' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-post-meta-text' => 'color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-post-meta-text a' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-post-meta-text a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'text_hover',
            [
                'label' => esc_html__('Hover', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'title_style_overlay_selector',
            [
                'label' => esc_html__('Choose Selector', 'themescamp-plugin'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => esc_html__('Image', 'themescamp-plugin'),
                    'container'  => esc_html__('Parent Container', 'themescamp-plugin'),
                    'parent-container'  => esc_html__('Parent of Parent Container', 'themescamp-plugin'),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'hover_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-text:hover, .e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text, .e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-parent-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text',
            ]
        );
        $this->add_control(
            'hover_title_color',
            [
                'label' => esc_html__('Hover Text Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text a:hover' => 'color: {{VALUE}};',
                    '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text' => 'color: {{VALUE}};',
                    '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text a' => 'color: {{VALUE}};',
                    '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-parent-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text' => 'color: {{VALUE}};',
                    '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-parent-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'text_stroke_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-text:hover, .e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text, .e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-parent-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text',
            ]
        );
        $this->add_control(
            'heading_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'themescamp-core'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text:hover' => 'opacity: {{SIZE}};',
                    '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text' => 'opacity: {{SIZE}};',
                    '.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-parent-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'text_border_hover',
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-text:hover,.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text,.e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-parent-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text',
            ]
        );
        $this->add_control(
            'text_dark_mode_heading_hover',
            [
                'label' => esc_html__('Dark Mode', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title_color_dark_mode_hover',
            [
                'label' => esc_html__( 'Title Color', 'themescamp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-post-meta-text:hover' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-post-meta-text:hover' => 'color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode .e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode .e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text' => 'color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode .e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-parent-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode .e-con:hover .elementor-element-{{ID}}>.elementor-widget-container>.tcg-dynamic-post-meta.selector-type-parent-container.tcg-dynamic-post-meta-container-active .tcg-dynamic-post-meta-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'separator_border2',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-text',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label' => esc_html__('Blend Mode', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Normal', 'themescamp-core'),
                    'multiply' => esc_html__('Multiply', 'themescamp-core'),
                    'screen' => esc_html__('Screen', 'themescamp-core'),
                    'overlay' => esc_html__('Overlay', 'themescamp-core'),
                    'darken' => esc_html__('Darken', 'themescamp-core'),
                    'lighten' => esc_html__('Lighten', 'themescamp-core'),
                    'color-dodge' => esc_html__('Color Dodge', 'themescamp-core'),
                    'saturation' => esc_html__('Saturation', 'themescamp-core'),
                    'color' => esc_html__('Color', 'themescamp-core'),
                    'difference' => esc_html__('Difference', 'themescamp-core'),
                    'exclusion' => esc_html__('Exclusion', 'themescamp-core'),
                    'hue' => esc_html__('Hue', 'themescamp-core'),
                    'luminosity' => esc_html__('Luminosity', 'themescamp-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-text' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'themescamp-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'data_type' => 'avatar',
                ]
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label' => esc_html__('Max Width', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'object-fit',
            [
                'label' => esc_html__('Object Fit', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'height[size]!' => '',
                ],
                'options' => [
                    '' => esc_html__('Default', 'themescamp-core'),
                    'fill' => esc_html__('Fill', 'themescamp-core'),
                    'cover' => esc_html__('Cover', 'themescamp-core'),
                    'contain' => esc_html__('Contain', 'themescamp-core'),
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'object-position',
            [
                'label' => esc_html__('Object Position', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'center center' => esc_html__('Center Center', 'themescamp-core'),
                    'center left' => esc_html__('Center Left', 'themescamp-core'),
                    'center right' => esc_html__('Center Right', 'themescamp-core'),
                    'top center' => esc_html__('Top Center', 'themescamp-core'),
                    'top left' => esc_html__('Top Left', 'themescamp-core'),
                    'top right' => esc_html__('Top Right', 'themescamp-core'),
                    'bottom center' => esc_html__('Bottom Center', 'themescamp-core'),
                    'bottom left' => esc_html__('Bottom Left', 'themescamp-core'),
                    'bottom right' => esc_html__('Bottom Right', 'themescamp-core'),
                ],
                'default' => 'center center',
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-img' => 'object-position: {{VALUE}};',
                ],
                'condition' => [
                    'object-fit' => 'cover',
                ],
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs('image_effects');

        $this->start_controls_tab(
            'image_normal',
            [
                'label' => esc_html__('Normal', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label' => esc_html__('Opacity', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'image_hover',
            [
                'label' => esc_html__('Hover', 'themescamp-core'),
            ]
        );

        $this->add_control(
            'opacity_hover',
            [
                'label' => esc_html__('Opacity', 'themescamp-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .tcg-dynamic-post-meta-img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}}:hover .tcg-dynamic-post-meta-img',
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'themescamp-core') . ' (s)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'themescamp-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta-img',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'price_reviews_style',
            [
                'label' => esc_html__('Price & Reviews Style', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'data_type' => ['woo-reviews', 'woo-price'],
                ],
            ]
        );

        $this->add_control(
            'price_options',
            [
                'label' => esc_html__( 'Price Options', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sale_price_typography',
                'label' => esc_html__('Sale Price Typography', 'themescamp-core'),
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta .woo-price .sale-price',
            ]
        );
        $this->add_control(
            'sale_price_color',
            [
                'label' => esc_html__( 'Sale Price Color', 'themescamp-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta .woo-price .sale-price' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sale_price_margin',
            [
                'label' => esc_html__('Sale Price Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta .woo-price .sale-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'old_price_typography',
                'label' => esc_html__('Old Price Typography', 'themescamp-core'),
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta .woo-price  .old-price,{{WRAPPER}} .tcg-dynamic-post-meta .woo-price .old-price > *,{{WRAPPER}} .tcg-dynamic-post-meta .woo-price  .old-price .woocommerce-Price-currencySymbol',
            ]
        );
        $this->add_control(
            'old_price_color',
            [
                'label' => esc_html__( 'Old Price Color', 'themescamp-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta .woo-price .old-price' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'old_price_margin',
            [
                'label' => esc_html__('Old Price Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta .woo-price .old-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'rate_heading',
            [
                'label' => esc_html__( 'Rate Options', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rate_text_typography',
                'label' => esc_html__('Rate Text Typography', 'themescamp-core'),
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta .woo-reviews .txt',
            ]
        );
        $this->add_control(
            'rate_text_color',
            [
                'label' => esc_html__( 'Rate Text Color', 'themescamp-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta .woo-reviews .txt' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'stars_rate_icon_size',
            [
                'label' => esc_html__( 'Star Icon Size', 'themescamp-core' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' , 'custom' , 'rem' , 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta .woo-reviews .stars svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'stars_rate_icon_color',
            [
                'label' => esc_html__( 'Star Icon Color', 'themescamp-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta .woo-reviews .stars svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tags_categories_style',
            [
                'label' => esc_html__('Tags & Categories Style', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'data_type' => ['categories', 'tags'],
                ],
            ]
        );
        $this->add_control(
            'tags_categories_display',
            [
                'label' => esc_html__('Tags & Categories Display Type', 'themescamp-core'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('Default', 'themescamp-core'),
                    'block' => esc_html__('Block', 'themescamp-core'),
                    'inline-block' => esc_html__('Inline Block', 'themescamp-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a' => 'display: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a' => 'display: {{VALUE}};'
                ]
            ]
        );
        $this->add_responsive_control(
            'tags_categories_padding',
            [
                'label' => esc_html__('Tags & Categories Padding', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tags_categories_margin',
            [
                'label' => esc_html__('Tags & Categories Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tags_categories_border',
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a, {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'tags_categories_border_radius',
            [
                'label' => esc_html__('Border Radius', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'categories_tags_tabs',
        );
        $this->start_controls_tab(
            'categories_tags_normal_tab',
            [
                'label'   => esc_html__( 'Normal', 'themescamp-plugin' ),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tags_categories_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a, {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a',
                'exclude' => ['image']
            ]
        );
        $this->add_control(
            'category_tag_color',
            [
                'label' => esc_html__('Text Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'categories_tags_dark_mode_heading',
            [
                'label' => esc_html__('Dark Mode', 'themescamp-elements'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'categories_tags_color_dark_mode',
            [
                'label' => esc_html__( 'Color', 'themescamp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a' => 'color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'categories_tags_border_color_dark_mode',
            [
                'label' => esc_html__( 'Border Color', 'themescamp-elements' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a' => 'border-color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'categories_tags_hover_tab',
            [
                'label'   => esc_html__( 'Hover', 'themescamp-plugin' ),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tags_categories_background_hover',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a:hover, {{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a:hover',
                'exclude' => ['image']
            ]
        );
        $this->add_control(
            'category_tag_color_hover',
            [
                'label' => esc_html__('Text Color', 'themescamp-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-tags a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .tcg-dynamic-post-meta.tcg-meta-type-categories a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings(); ?>

        <div class="tcg-dynamic-post-meta tcg-meta-type-<?php echo $settings['data_type'] . ' ' . 'selector-type-' . $settings['title_style_overlay_selector'] ?>">

            <?php

            switch ($settings['data_type']) {
                case 'title':

                    $link_start = '';
                    $link_end = '';

                    if ($settings['link'] == 'yes') : $link_start = '<a href="' . esc_url(get_the_permalink()) . '">';
                        $link_end = '</a>';
                    endif;

            ?>
                    <<?= Utils::validate_html_tag($settings['header_size']) ?> class="tcg-dynamic-post-meta-text"><?= $link_start ?><?php the_title(); ?><?= $link_end ?></<?= Utils::validate_html_tag($settings['header_size']) ?>>
                <?php
                    break;
                case 'date':
                    $custom_date_format = empty($settings['custom_date_format']) ? 'F j, Y' : $settings['custom_date_format'];

                    $format_options = [
                        'default' => 'F j, Y',
                        '0' => 'F j, Y',
                        '1' => 'Y-m-d',
                        '2' => 'm/d/Y',
                        '3' => 'd/m/Y',
                        'custom' => $custom_date_format,
                    ];

                    $post_date = get_the_time('U');
                    $current_date = current_time('timestamp');
                    $days_diff = floor(($current_date - $post_date) / DAY_IN_SECONDS);

                    if ('yes' === $settings['use_days_ago'] && $days_diff <= $settings['days_ago_limit']) {
                        $title = sprintf(esc_html__('%s %s', 'themescamp-core'), $days_diff,$settings['custom_days_ago_text']);
                    } else {
                        $title = get_the_time($format_options[$settings['date_format']]);
                    }

                    $this->add_render_attribute('title', 'class', 'tcg-dynamic-post-meta-text');

                    $link_start = '';
                    $link_end = '';

                    if ($settings['link'] == 'yes') :
                        $link_start = '<a href="' . esc_url(get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'))) . '">';
                        $link_end = '</a>';
                    endif;

                    $title_html = sprintf('<%1$s %2$s>' . $link_start . '%3$s' . $link_end . '</%1$s>', Utils::validate_html_tag($settings['header_size']), $this->get_render_attribute_string('title'), $title);

                    echo $title_html;

                    break;
                case 'time':
                    $custom_time_format = empty($settings['custom_time_format']) ? 'g:i a' : $settings['custom_time_format'];

                    $format_options = [
                        'default' => 'g:i a',
                        '0' => 'g:i a',
                        '1' => 'g:i A',
                        '2' => 'H:i',
                        'custom' => $custom_time_format,
                    ];

                    $post_time = get_the_time('U');
                    $current_time = current_time('timestamp');
                    $hours_diff = floor(($current_time - $post_time) / HOUR_IN_SECONDS);

                    if ('yes' === $settings['use_hours_ago'] && $hours_diff <= $settings['hours_ago_limit']) {
                        $title = sprintf(esc_html__('%s %s', 'themescamp-core'), $hours_diff, $settings['custom_hours_ago_text']);
                    } else {
                        $title = get_the_time($format_options[$settings['time_format']]);
                    }

                    $this->add_render_attribute('title', 'class', 'tcg-dynamic-post-meta-text');

                    $link_start = '';
                    $link_end = '';

                    if ($settings['link'] == 'yes') :
                        $link_start = '<a href="' . esc_url(get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'))) . '">';
                        $link_end = '</a>';
                    endif;

                    $title_html = sprintf('<%1$s %2$s>' . $link_start . '%3$s' . $link_end . '</%1$s>', Utils::validate_html_tag($settings['header_size']), $this->get_render_attribute_string('title'), $title);

                    echo $title_html;

                    break;

                case 'excerpt':

                    $excerpt = get_the_excerpt();
                    $excerpt = substr($excerpt, 0, $settings['excerpt']);

                    $this->add_render_attribute('title', 'class', 'tcg-dynamic-post-meta-text');

                    $title = $excerpt . $settings['excerpt_after'];

                    $title_html = sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($settings['header_size']), $this->get_render_attribute_string('title'), $title);

                    // PHPCS - the variable $title_html holds safe data.
                    echo $title_html;

                    break;
                case 'comments':
                    if (comments_open()) {
                        $default_strings = [
                            'string_no_comments' => esc_html__('No Comments', 'themescamp-core'),
                            'string_one_comment' => esc_html__('%s Comment', 'themescamp-core'),
                            'string_comments' => esc_html__('%s Comments', 'themescamp-core'),
                        ];

                        if ('yes' === $settings['comments_custom_strings']) {
                            if (!empty($settings['string_no_comments'])) {
                                $default_strings['string_no_comments'] = $settings['string_no_comments'];
                            }

                            if (!empty($settings['string_one_comment'])) {
                                $default_strings['string_one_comment'] = $settings['string_one_comment'];
                            }

                            if (!empty($settings['string_comments'])) {
                                $default_strings['string_comments'] = $settings['string_comments'];
                            }
                        }

                        $num_comments = (int) get_comments_number(); // get_comments_number returns only a numeric value

                        $title = 'Comments will appear here';

                        if (0 === $num_comments) {
                            $title = $default_strings['string_no_comments'];
                        } else {
                            $title = sprintf(_n($default_strings['string_one_comment'], $default_strings['string_comments'], $num_comments, 'themescamp-core'), $num_comments);
                        }

                        $this->add_render_attribute('title', 'class', 'tcg-dynamic-post-meta-text');

                        $link_start = '';
                        $link_end = '';

                        if ($settings['link'] == 'yes') : $link_start = '<a href="' . esc_url(get_comments_link()) . '">';
                            $link_end = '</a>';
                        endif;

                        $title_html = sprintf('<%1$s %2$s>' . $link_start . '%3$s' . $link_end . '</%1$s>', Utils::validate_html_tag($settings['header_size']), $this->get_render_attribute_string('title'), $title);

                        // PHPCS - the variable $title_html holds safe data.
                        echo $title_html;
                    }
                    break;
                case 'avatar':
                    $link_start = '';
                    $link_end = '';

                    if ($settings['link'] == 'yes') : $link_start = '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">';
                        $link_end = '</a>';
                    endif;

                    $author_name = get_the_author_meta('display_name'); // Retrieve author name for alt text

                    echo $link_start . "<img class='tcg-dynamic-post-meta-img' src='" . get_avatar_url(get_the_author_meta('ID'), 96) . "' alt='" . esc_attr($author_name) . "'>" . $link_end;
                    break;
                case 'author':

                    $this->add_render_attribute('title', 'class', 'tcg-dynamic-post-meta-text');

                    $title = get_the_author_meta('display_name');

                    $link_start = '';
                    $link_end = '';

                    if ($settings['link'] == 'yes') : $link_start = '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">';
                        $link_end = '</a>';
                    endif;

                    $title_html = sprintf('<%1$s %2$s>' . $link_start . '%3$s' . $link_end . '</%1$s>', Utils::validate_html_tag($settings['header_size']), $this->get_render_attribute_string('title'), $title);

                    // PHPCS - the variable $title_html holds safe data.
                    echo $title_html;
                    break;
                case 'categories':
                    global $post;
                    $category = false;
                    $taxonomy_names = get_post_taxonomies();
                    if($taxonomy_names){
                        $category = get_the_terms($post->ID, $taxonomy_names[0]);
                    }

                ?>
                    <<?= Utils::validate_html_tag($settings['header_size']) ?> class="tcg-dynamic-post-meta-text">
                        <?php
                        $cat_counter = 0;
                        if($category){
                            foreach ($category as $cat) {
                                if ($cat_counter >= 1) echo $settings['meta_separator'];
                                echo '<a href="' . esc_url(get_term_link($cat)) . '">' . $cat->name . '</a>';
                                $cat_counter++;
                            };
                        } ?>
                    </<?= Utils::validate_html_tag($settings['header_size']) ?>>
                <?php

                    break;
                case 'tags':
                    global $post;
                    $tags = false;
                    $taxonomy_names = get_post_taxonomies();
                    if($taxonomy_names){
                        $tags = get_the_terms($post->ID, $taxonomy_names[1]);
                    };

                ?>
                    <<?= Utils::validate_html_tag($settings['header_size']) ?> class="tcg-dynamic-post-meta-text">
                        <?php
                        $tag_counter = 0;
                        if ($tags) {
                            foreach ($tags as $tag) {
                                if ($tag_counter >= 1) echo $settings['meta_separator'];
                                echo '<a href="' . esc_url(get_term_link($tag)) . '">' . $tag->name . '</a>';
                                $tag_counter++;
                            }
                        } ?>
                    </<?= Utils::validate_html_tag($settings['header_size']) ?>>
            <?php
                case 'woo-price':

                    ?>

                    <<?= Utils::validate_html_tag($settings['header_size']) ?> class="tcg-dynamic-post-meta-text woo-price">
                        <?php
                            global $product;
                            if(isset($product)){
                                if ( $product->is_type( 'variable' ) ) {
                                    echo $product->get_price_html();
                                } else {
                                    $regular_price = get_post_meta( get_the_ID(), '_regular_price', true );
                                    $sale_price = get_post_meta( get_the_ID(), '_sale_price', true );
                                    if ( $product->is_on_sale() ) {
                                        ?>
                                        <span class="sale-price"><?php echo wc_price( $sale_price ); ?></span><span class="old-price"><?php echo wc_price( $regular_price ); ?></span>
                                        <?php
                                    } else {
                                        echo wc_price( $regular_price );
                                    }
                                };
                            };
                        ?>
                    </<?= Utils::validate_html_tag($settings['header_size']) ?>>

                    <?php
                    break;
                case 'port-sec':
                        $secondary_image_id = get_post_meta(get_the_ID(), '_secondary_featured_image', true);

                        // Check if the secondary featured image is set
                        if ($secondary_image_id) {
                            // Display the secondary featured image
                            echo wp_get_attachment_image($secondary_image_id, 'thumbnail'); 
                        } else {
                            // Use Elementor's default placeholder image
                            $placeholder_url = \Elementor\Utils::get_placeholder_image_src();
                            
                            // Display the placeholder image
                            echo '<img src="' . esc_url($placeholder_url) . '" alt="Placeholder Image" />';
                        }

                        break;
                case 'woo-reviews': ?>
                    <div class="woo-reviews">
                        <?php
                        global $product;
                        if(isset($product)):
                            if ( $product->get_average_rating() ) : ?>
                                <div class="stars">
                                    <?php
                                    $rating = $product->get_average_rating();
                                    $stars = floor( $rating );
                                    for ( $i = 0; $i < $stars; $i++ ) {
                                        ?>
                                            <svg aria-hidden="true" class="e-font-icon-svg e-fas-star" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <span class="txt"> (<?php echo $product->get_rating_count().' '.$settings['woo_reviews_text']; ?>) </span>
                            <?php else : ?>
                                <span class="txt"><?=$settings['woo_no_reviews_text'];?></span>
                            <?php endif;
                        endif; ?>
                    </div>
                    <?php

                    break;
                case 'role':

                    $author_id = get_the_author_meta('ID'); // Get the post author's ID
                    $author_data = get_userdata($author_id); // Retrieve the author's user data

                    $this->add_render_attribute('title', 'class', 'tcg-dynamic-post-meta-text');

                    if (!empty($author_data->roles)) {
                        // Retrieve roles assigned to the post author
                        $roles = $author_data->roles;
                        // Display roles as a comma-separated string
                        $role_names = implode(', ', array_map('ucfirst', $roles));

                        $link_start = '';
                        $link_end = '';

                        if ($settings['link'] == 'yes') :
                            $link_start = '<a href="' . esc_url(get_author_posts_url($author_id)) . '">';
                            $link_end = '</a>';
                        endif;

                        // Output the role using header size
                        $title_html = sprintf('<%1$s %2$s>' . $link_start . '%3$s' . $link_end . '</%1$s>', Utils::validate_html_tag($settings['header_size']), $this->get_render_attribute_string('title'), esc_html($role_names));

                        // PHPCS - the variable $title_html holds safe data.
                        echo $title_html;

                    } else {
                        // Fallback if the author has no role
                        $fallback_role = __('No role assigned', 'themescamp-plugin');
                        $title_html = sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($settings['header_size']), $this->get_render_attribute_string('title'), esc_html($fallback_role));

                        echo $title_html;
                    }

                    break;

            }

            ?>

        </div>

<?php
    }
}
