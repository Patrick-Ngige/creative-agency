<?php
namespace InfolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/**
 * @since 1.0.0
 */
class Infolio_Blog extends Widget_Base {

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
        return 'infolio-blog';
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
        return __( 'Infolio Blog', 'infolio_plg' );
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
        return 'eicon-posts';
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
                'label' => __( 'Posts Settings.', 'infolio_plg' ),
            ]
        );
        $this->add_control(
            'number_of_blogs',
            [
                'label' => __('Number Of Blogs To Show In Single Row', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'col-lg-6' => __('2', 'infolio_plg'),
                    'col-lg-4' => __('3', 'infolio_plg'),
                ],
                'default' => 'col-lg-6',
            ]
        );
        $this->add_control(
            'post_order',
            [
                'label' => __('Post Order', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'DESC' => __('Descending', 'infolio_plg'),
                    'ASC' => __('Ascending', 'infolio_plg'),
                    'rand' => __('Random', 'infolio_plg'),
                ],
                'default' => 'DESC',
            ]
        );

        $this->add_control(
            'blog_post',
            [
                'label' => __('Blog Post to show', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'default' => '2',
            ]
        );

        $this->add_control(
            'sort_cat',
            [
                'label' => __('Sort post by Category', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'blog_cat',
            [
                'label'   => __('Category', 'infolio_plg'),
                'type'    => Controls_Manager::SELECT2,
                'options' => $this->infolio_category_options(),
                'condition' => [
                    'sort_cat' => 'yes',
                ],
                'multiple'   => 'true',
            ]
        );

        $this->add_control(
            'selected_tag',
            [
                'label' => __('Select Tag', 'infolio_plg'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->get_tag_options(),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'show_cat',
            [
                'label' => __('Show Category', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'infolio_plg'),
                'label_off' => __('Hide', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'image_option',
            [
                'label' => __('Image Position Options', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'side' => __('Left Side', 'infolio_plg'),
                    'up' => __('Up', 'infolio_plg'),
                    'half-side' => __('half-side', 'infolio_plg'),
                ],
                'default' => 'side',
            ]
        );
        $this->add_control(
            'author_section',
            [
                'label' => __('Author', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition'=>['image_option'=>['side','half-side']],
                'label_on' => __('Show', 'infolio_plg'),
                'label_off' => __('Hide', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'read_more',
            [
                'label' => __('Read More', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'infolio_plg'),
                'label_off' => __('Hide', 'infolio_plg'),
                'condition'=>['image_option'=>'up']
            ]
        );
        $this->add_control(
            'read_more_icon',
            [
                'label' => esc_html__( 'Read More Icon', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'condition'=>['read_more'=>'yes']
            ]
        );
        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__( 'Read More Text', 'infolio_plg' ),
                'default' => esc_html__( 'Read More', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'condition'=>['read_more'=>'yes']
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'item_settings',
            [
                'label' => __( 'item Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Item Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between items', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .row .col-lg-6:not(:last-child) .item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .infolio-blog .row .col-lg-4:not(:last-child) .item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Item Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_content_padding',
            [
                'label' => esc_html__('Content Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .item .cont' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .infolio-blog .item',
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'item_border_radius',
            [
                'label' => esc_html__('Item Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'item_bg',
            [
                'label' => esc_html__( 'Item Background', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .item' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'item_bg_dark',
            [
                'label' => esc_html__( 'Item Background (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-blog .item' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-blog .item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_settings',
            [
                'label' => __( 'Title Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_title_style');

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => esc_html__('Normal', 'infolio_plg'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .infolio-blog .title a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => esc_html__('Hover', 'infolio_plg'),
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography_hover',
                'selector' => '{{WRAPPER}} .infolio-blog .title a:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Title Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'category_settings',
            [
                'label' => __( 'Category Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'category_border',
            [
                'label' => esc_html__('Category Border', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .infolio-blog .categories a , .infolio-blog .categories span',
            ]
        );

        $this->add_responsive_control(
            'category_wrapper_margin',
            [
                'label' => esc_html__('Category Wrapper Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'category_margin',
            [
                'label' => esc_html__('Category Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-blog .categories span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'category_padding',
            [
                'label' => esc_html__('Category Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-blog .categories span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cat_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-blog .categories span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs('tabs_cat_style');

        $this->start_controls_tab(
            'tab_cat_normal',
            [
                'label' => esc_html__('Normal', 'infolio_plg'),
            ]
        );

        $this->add_control(
            'category_color',
            [
                'label' => esc_html__( 'Category Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-blog .categories span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_wrapper_bg',
            [
                'label' => esc_html__( 'Category Wrapper Background', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'condition'=>['image_option'=>'up'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'category_bg_dark',
            [
                'label' => esc_html__( 'Category Wrapper Background (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'condition'=>['image_option'=>'up'],
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-blog .categories' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-blog .categories' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'shape_color',
            [
                'label' => esc_html__( 'Shape Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'condition'=>['image_option'=>'up'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'shape_color_dark',
            [
                'label' => esc_html__( 'Shape Color (Dark Mode)', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'condition'=>['image_option'=>'up'],
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-blog .categories svg path' => 'fill: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-blog .categories svg path' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_cat_hover',
            [
                'label' => esc_html__('Hover', 'infolio_plg'),
            ]
        );

        $this->add_control(
            'category_hover_color',
            [
                'label' => esc_html__( 'Category Hover Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-blog .categories span:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_wrapper_hover_bg',
            [
                'label' => esc_html__( 'Category Wrapper Hover Background', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'condition'=>['image_option'=>'up'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'category_hover_bg',
            [
                'label' => esc_html__( 'Category Hover Background', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'condition'=>['image_option'=>'up'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .categories a:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-blog .categories span:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();


        $this->end_controls_section();

        $this->start_controls_section(
            'date_settings',
            [
                'label' => __( 'Date Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'selector' => '{{WRAPPER}} .infolio-blog .date',
            ]
        );

        $this->add_responsive_control(
            'date_margin',
            [
                'label' => esc_html__('Date Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'date_opacity',
            [
                'label' => esc_html__( 'Date Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .date' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_settings',
            [
                'label' => __( 'Image Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Image Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .item .img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'min_height',
            [
                'label' => esc_html__( 'Min Height', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 800,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .item .img' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'author_settings',
            [
                'label' => __( 'Author Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>['image_option'=>'side']
            ]
        );

        $this->add_control(
            'author_color',
            [
                'label' => esc_html__( 'Author Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .author-text ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_typography',
                'selector' => '{{WRAPPER}} .infolio-blog .author-text',
            ]
        );

        $this->add_responsive_control(
            'author_margin',
            [
                'label' => esc_html__('Author Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .author-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'author_opacity',
            [
                'label' => esc_html__( 'Author Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .author-text .title' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'author_border_radius',
            [
                'label' => esc_html__('Author Image Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .author-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'button_settings',
            [
                'label' => __( 'Read More Button Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>['read_more'=>'yes']
            ]
        );
        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Button Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .cont .r-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Button Content Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog .cont .r-more' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-blog .cont .r-more svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-blog .cont .r-more i' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .infolio-blog .cont .r-more',
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
                    '{{WRAPPER}} .infolio-blog .cont .r-more svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-blog .cont .r-more i' => 'font-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .infolio-blog .cont .r-more svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-blog .cont .r-more i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $query_args = array(
            'posts_per_page' => $settings['blog_post'],
            'post_type' => 'post',
            'order' => $settings['post_order'],
        );

        if (!empty($settings['selected_tag'])) {
            $query_args['tag__in'] = $settings['selected_tag'];
        }

        if ($settings['sort_cat'] == 'yes') {
            $query_args['cat'] = $settings['blog_cat'];
        }

        $query = new \WP_Query($query_args);
        ?>

        <div class="infolio-blog">
            <div class="row">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="<?=$settings['number_of_blogs']?>">
                    <div class="item">
                        <?php if ($settings['image_option']=='side' || $settings['image_option']=='half-side') : ?>
                        <div class="row <?php if ($settings['image_option']=='side')echo 'rest'?>">
                            <div class="col-lg-6 col-md-5 img <?=$settings['image_option']?> rest">
                                <img src="<?php esc_url(the_post_thumbnail_url()); ?>" alt="" class="<?php if ($settings['image_option']=='side')echo 'img-post'?>">
                                <?php if ($settings['author_section']=='yes') : ?>
                                <div class="author d-flex align-items-center">
                                    <div>
                                        <div class="author-image">
                                            <?php echo get_avatar(get_the_author_meta('ID'), 50); ?>
                                        </div>
                                    </div>
                                    <div class="author-text">
                                        <div><span class="title"><?=__('Posted by','infolio_plg')?></span><br> <?=esc_html(get_the_author()); ?></div>
                                    </div>
                                </div>
                                <?php endif;?>
                            </div>
                            <div class="col-lg-6 col-md-7 cont valign">
                                <div>
                                    <?php if ($settings['image_option']=='side') : ?>
                                    <div class="categories">
                                        <?php $post_categories = get_the_category();
                                        if ($post_categories) {
                                            foreach ($post_categories as $post_category) {
                                                echo '<a href="' . esc_url(get_category_link($post_category->term_id)) . '">' . esc_html($post_category->name) . '</a>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <h5 class="title">
                                        <a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a>
                                    </h5>
                                    <span class="date"><?php echo get_the_date(__('F j, Y')); ?></span>
                                    <?php else:?>
                                        <span class="date"><?php echo get_the_date(__('F j, Y')); ?></span>
                                        <h5 class="title">
                                            <a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a>
                                        </h5>
                                        <div class="categories">
                                            <?php $post_categories = get_the_category();
                                            if ($post_categories) {
                                                foreach ($post_categories as $post_category) {
                                                    echo '<a href="' . esc_url(get_category_link($post_category->term_id)) . '">' . esc_html($post_category->name) . '</a>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <?php elseif ($settings['image_option']=='up') : ?>
                            <div class="img">
                                <img src="<?php esc_url(the_post_thumbnail_url()); ?>" alt="">
                                <div class="categories absolute">
                                    <span>
                                     <?php $post_categories = get_the_category();
                                     if ($post_categories) {
                                         foreach ($post_categories as $post_category) {
                                             echo esc_html($post_category->name);
                                         }
                                     }
                                     ?>
                                    </span>
                                    <div class="shap-right-bottom">
                                        <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"
                                             class="w-11 h-11">
                                            <path
                                                    d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z"
                                                    fill="#242424"></path>
                                        </svg>
                                    </div>
                                    <div class="shap-left-bottom">
                                        <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg"
                                             class="w-11 h-11">
                                            <path
                                                    d="M11 1.54972e-06L0 0L2.38419e-07 11C1.65973e-07 4.92487 4.92487 1.62217e-06 11 1.54972e-06Z"
                                                    fill="#242424"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="cont">
                                <div class="date">
                                    <a href="<?php esc_url(the_permalink()); ?>"><?php echo get_the_date(__('j F Y')); ?></a>
                                </div>
                                <h5 class="title">
                                    <a href="<?php esc_url(the_permalink()); ?>"><?=esc_html(get_the_title())?></a>
                                </h5>
                                <?php if ($settings['read_more']=='yes') : ?>
                                    <a href="<?php esc_url(the_permalink()); ?>" class="r-more d-flex align-items-center">
                                        <?=esc_html($settings['read_more_text'])?>
                                        <?php Icons_Manager::render_icon($settings['read_more_icon'], ['aria-hidden' => 'true']); ?>
                                    </a>
                                <?php endif?>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
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
    private function infolio_category_options() {
        $categories = get_categories();
        $category_options = ['' => __('All Categories', 'infolio_plg')];

        foreach ($categories as $category) {
            $category_options[$category->term_id] = $category->name;
        }

        return $category_options;
    }
    private function get_tag_options() {
        $tags = get_tags();
        $tag_options = [];

        foreach ($tags as $tag) {
            $tag_options[$tag->term_id] = $tag->name;
        }

        return $tag_options;
    }
}



