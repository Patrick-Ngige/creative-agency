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

if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.0.0
 */
class Infolio_Portfolio_Gallery extends Widget_Base
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
        return 'infolio-portfolio-gallery';
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
        return __('Infolio Portfolio Gallery', 'infolio_plg');
    }

    public function get_script_depends()
    {
        return ['isotope.min', 'infolio-gallery', 'infolio-filter'];
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
        return 'eicon-instagram-nested-gallery';
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
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Portfolio Settings.', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'row_margin',
            [
                'label' => __('Row Margin', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('Default', 'infolio_plg'),
                    'sm-marg' => __('Small', 'infolio_plg'),
                    'stand-marg' => __('Standard', 'infolio_plg'),
                ],
                'default' => 'sm-marg',
            ]
        );
        $this->add_control(
            'gallery_style',
            [
                'label' => __('Style', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style1' => __('Gallery', 'infolio_plg'),
                    'style2' => __('Masonry', 'infolio_plg'),
                    'style3' => __('Clean', 'infolio_plg'),
                    'style4' => __('Same Column Size', 'infolio_plg'),
                ],
                'default' => 'style1',
            ]
        );
        $this->add_control(
            'content_option',
            [
                'label' => __('How To Show Content', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['gallery_style' => 'style4'],
                'options' => [
                    'hover' => __('On Hover', 'infolio_plg'),
                    'under' => __('Under Image', 'infolio_plg'),
                ],
                'default' => 'hover',
            ]
        );
        $this->add_control(
            'show',
            [
                'label' => __('Choose Show Tag / Category', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'tag' => __('Tag', 'infolio_plg'),
                    'category' => __('Category', 'infolio_plg'),
                ],
                'default' => 'category',
            ]
        );
        $this->add_control(
            'image',
            [
                'label' => __('Image', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => ['gallery_style' => 'style3'],
            ]
        );
        $this->add_control(
            'portfolio_item',
            [
                'label' => __('Item to display', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
            ]
        );
        $this->add_control(
            'blur_effect',
            [
                'label' => __('Blur Effect', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'condition' => ['gallery_style' => 'style3'],
            ]
        );
        $this->add_control(
            'filters',
            [
                'label' => __('Filters', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'all_text',
            [
                'label' => __('All Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'condition' => ['filters' => 'yes'],
                'default' => 'Show All',
            ]
        );
        $this->add_control(
            'sort_cat',
            [
                'label' => __('Sort Portfolio by Portfolio Category', 'infolio_plg'),
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
                'label'   => __('Category to Show', 'infolio_plg'),
                'type'    => Controls_Manager::SELECT2,
                'options' => $this->get_taxonomy_terms(),

                'condition' => [
                    'sort_cat' => 'yes',
                ],
                'multiple'   => 'true',
            ]
        );

        $this->add_control(
            'sort_tag',
            [
                'label' => __('Sort post by Tags', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'blog_tag',
            [
                'label'   => __('Tags', 'infolio_plg'),
                'type'    => Controls_Manager::SELECT2,
                'options' => $this->get_tag_options(),
                'condition' => [
                    'sort_tag' => 'yes',
                ],
                'multiple'   => 'true',
            ]
        );

        $this->add_control(
            'port_order',
            [
                'label' => __('Orders', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'DESC' => __('Descending', 'infolio_plg'),
                    'ASC' => __('Ascending', 'infolio_plg'),
                    'rand' => __('Random', 'infolio_plg'),
                ],
                'default' => 'DESC',
            ]
        );

        $this->add_responsive_control(
            'portfolio_space_between',
            [
                'label' => esc_html__('Space Between', 'infolio_plg'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', 'custom'],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-gallery .items:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_portfolio_style',
            [
                'label' => esc_html__('Section Portfolio', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'portfolio_content_background',
            [
                'label' => esc_html__('Content Background Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-gallery .item .cont' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'portfolio_content_background_dark',
            [
                'label' => esc_html__('Content Background Color (Dark Mode)', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'default' => '#1d1d1d',
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-portfolio-gallery .item .cont' => 'background-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-portfolio-gallery .item .cont' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_border_radius',
            [
                'label' => esc_html__('Content Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-gallery .item .cont' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-gallery .item .cont' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Content Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-gallery .item .cont' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__('Item Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-gallery .item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'column_padding',
            [
                'label' => esc_html__('Column Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-gallery .items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'column_border',
                'label' => esc_html__('Column Border', 'infolio_plg'),
                'selector' => '{{WRAPPER}} .infolio-portfolio-gallery .items',
            ]
        );

        $this->add_control(
            'border_dark',
            [
                'label' => esc_html__('Border Color (Dark Mode)', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-portfolio-gallery .items' => 'border-color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-portfolio-gallery .items' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Section Title & Category', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'portfolio_title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-portfolio-gallery .item .cont h5 , {{WRAPPER}} .infolio-portfolio-gallery .item .cont h5 a',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-gallery .item .cont h5' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-portfolio-gallery .item .cont p , {{WRAPPER}} .infolio-portfolio-gallery .item .cont p a',
            ]
        );
        $this->add_responsive_control(
            'category_margin',
            [
                'label' => esc_html__('Category Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-gallery .item .cont p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_image_style',
            [
                'label' => esc_html__('Section Image', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vh', 'custom'],
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
                    '{{WRAPPER}} .infolio-portfolio-gallery .item .img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'infolio_plg'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-gallery .item .img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_filter_style',
            [
                'label' => esc_html__('Section Filter', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['filters' => 'yes']
            ]
        );
        $this->add_responsive_control(
            'filter_section_margin',
            [
                'label' => esc_html__('Filter Section Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'separator' => 'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-filtering' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'filter_text_color',
            [
                'label' => esc_html__('Color', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-filtering .link-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-filtering .link' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'filter_text_color_dark',
            [
                'label' => esc_html__('Color (Dark Mode)', 'infolio_plg'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-filtering .link-text' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-filtering .link-text' => 'color: {{VALUE}};',
                    '@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .infolio-filtering .link' => 'color: {{VALUE}};',
                    '} body.tcg-dark-mode {{WRAPPER}} .infolio-filtering .link' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter_title_typography',
                'label' => esc_html__('Filter Title', 'infolio_plg'),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-filtering .link-text',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'filter_link_typography',
                'label' => esc_html__('Filter Link', 'infolio_plg'),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-filtering .link',
            ]
        );
        $this->add_responsive_control(
            'link_margin',
            [
                'label' => esc_html__('Link Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-filtering .link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-filtering .link-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $settings = $this->get_settings();
        $categories = infolio_tax_choice();
        $destudio_taxonomy = 'portfolio_category';
        if ($settings['port_order'] != 'rand') {
            $order = 'order';
            $ord_val = $settings['port_order'];
        } else {
            $order = 'orderby';
            $ord_val = 'rand';
        }

        $sort_cat = array(
            'taxonomy' => 'portfolio_category',   // taxonomy name
            'field' => 'term_id',
            'terms' => $settings['blog_cat'],           // term_id, slug or name                // term id, term slug or term name
        );

        $sort_tag = array(
            'taxonomy' => 'porto_tag',   // taxonomy name
            'field' => 'term_id',
            'terms' => $settings['blog_tag'],           // term_id, slug or name                // term id, term slug or term name
        );

        if ($settings['sort_cat']  == 'yes' || $settings['sort_tag']  == 'yes') {
            $destudio_work = new \WP_Query(array(
                'posts_per_page'   => $settings['portfolio_item'],
                'post_type' =>  'portfolio', 'infolio_plg',
                $order       =>  $ord_val,
                'tax_query' => array(
                    $settings['sort_cat'] == 'yes' ? $sort_cat : '',
                    $settings['sort_tag'] == 'yes' ? $sort_tag : ''
                )
            ));
        } else {
            $destudio_work = new \WP_Query(array(
                'posts_per_page'   => $settings['portfolio_item'],
                'post_type' =>  'portfolio', 'infolio_plg',
                $order       =>  $ord_val,
            ));
        }
        $gallery_style = $settings['gallery_style'];
?>

        <div class="infolio-portfolio-gallery <?= esc_attr($gallery_style) . ' ' . esc_attr($settings['row_margin']) ?>">
            <?php if ($settings['filters'] == 'yes') : ?>
                <div class="row">
                    <!-- filter links -->
                    <div class="infolio-filtering col-12 text-center">
                        <div class="filter">
                            <span class="link-text"><?php esc_html_e('Filter By :', 'infolio_plg') ?></span>
                            <span class="active link" data-filter="*"><?= esc_html($settings['all_text']) ?></span>
                            <?php
                            $woo_cats_array = [];
                            if ($destudio_work->have_posts()) : while ($destudio_work->have_posts()) : $destudio_work->the_post();
                                    global $post;
                                    $woo_cats = get_the_terms($post->ID, 'portfolio_category');
                                    if ($woo_cats) {
                                        foreach ($woo_cats as $woo_cat) {
                                            $woo_cats_array[str_replace(array('&amp;', ' ', '.'), array('', '-', ''), strtolower($woo_cat->name))] = esc_html($woo_cat->name);
                                        }
                                    }
                                endwhile;
                            endif;
                            array_unique($woo_cats_array);
                            foreach ($woo_cats_array as $cat => $cat_value) : ?>
                                <span class="link" data-filter='.<?php echo str_replace(array('&amp;', ' ', '.'), array('', '-', ''), strtolower($cat)) ?>' data-count="03"><?php echo esc_html($cat_value); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="items-gallery row">
                <?php $itemCount = 1;
                if ($destudio_work->have_posts()) : while ($destudio_work->have_posts()) : $destudio_work->the_post();
                        global $post; ?>
                        <div class="<?php if ($gallery_style != 'style3') echo 'items ' ?><?php
                                                                                            if ($gallery_style == 'style4') echo 'col-lg-4 col-md-6' ?> <?php if ($gallery_style == 'style1' and $itemCount < 3) echo 'col-md-6 ';
                                                                                    elseif ($gallery_style == 'style1') echo 'col-12 ' ?><?php if ($gallery_style == 'style2' && ($itemCount >= 2 && $itemCount <= 5)) echo 'col-lg-3 width2 ';
                                                                                elseif ($gallery_style == 'style2') echo 'col-lg-6 ' ?><?php if ($gallery_style == 'style3' && $itemCount == 1) echo 'col-lg-5 ';
                                                                                elseif ($gallery_style == 'style3' && $itemCount == 2) echo 'col-lg-7 ';
                                                                                elseif ($gallery_style == 'style3') echo 'col-lg-4 ' ?><?php
                                                                                
                                                                                $destudio_taxonomy = 'portfolio_category';
                                                                                $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy);
                                                                                $count = 1;
                                                                                foreach ($destudio_taxs as $destudio_tax) {
                                                                                    if ($count != 1) echo ' ';
                                                                                    echo strtolower(str_replace(array('&amp;', ' ', '.'), array('', '-', ''), $destudio_tax->name));
                                                                                    $count++;
                                                                                } ?>">
                            <div class="item">
                                <div class="img">
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" alt="">
                                    <?php if ($gallery_style == 'style1' || $gallery_style == 'style2') : ?>
                                        <div class="cont <?php if (($gallery_style == 'style2' && !($itemCount > 1 && $itemCount < 6))) echo 'd-flex align-items-center';
                                                            elseif ($gallery_style == 'style1' and $itemCount > 2) echo 'd-flex align-items-center' ?>">
                                            <div>
                                                <h5>
                                                    <a href="<?php echo esc_url(the_permalink()) ?>"><?= esc_html(get_the_title()); ?></a>
                                                </h5>
                                            </div>
                                            <div class="<?php if (!($gallery_style == 'style2' && ($itemCount > 1 && $itemCount < 6))) echo 'ml-auto' ?>">
                                                <p>
                                                    <?php
                                                    if ($settings['show'] == 'tag') {
                                                        $destudio_taxonomy = 'porto_tag';
                                                        $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy);
                                                        foreach ($destudio_taxs as $destudio_tax) {
                                                            $tag_link = '<a href="' . esc_url(get_term_link($destudio_tax)) . '">' . esc_html($destudio_tax->name) . '</a>';
                                                            echo $tag_link;
                                                        }
                                                    } else {
                                                        $category_terms = wp_get_post_terms($post->ID, 'portfolio_category');
                                                        if (!empty($category_terms)) {
                                                            $first_category_link = '<a href="' . esc_url(get_term_link($category_terms[0])) . '">' . esc_html($category_terms[0]->name) . '</a>';
                                                            echo $first_category_link;
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php elseif ($gallery_style == 'style3') : ?>
                                        <div class="cont <?php if ($settings['blur_effect'] == 'yes') echo 'blur' ?> d-flex align-items-center">
                                            <div>
                                                <h5><?= esc_html(get_the_title()); ?></h5>
                                                <p>
                                                    <?php
                                                    if ($settings['show'] == 'tag') {
                                                        $destudio_taxonomy = 'porto_tag';
                                                        $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy);
                                                        foreach ($destudio_taxs as $destudio_tax) {
                                                            $tag_link = '<a href="' . esc_url(get_term_link($destudio_tax)) . '">' . esc_html($destudio_tax->name) . '</a>';
                                                            echo $tag_link;
                                                        }
                                                    } else {
                                                        $category_terms = wp_get_post_terms($post->ID, 'portfolio_category');
                                                        if (!empty($category_terms)) {
                                                            $first_category_link = '<a href="' . esc_url(get_term_link($category_terms[0])) . '">' . esc_html($category_terms[0]->name) . '</a>';
                                                            echo $first_category_link;
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="ml-auto">
                                                <a href="<?php echo esc_url(the_permalink()) ?>" class="rmore">
                                                    <img src="<?= esc_url($settings['image']['url']) ?>" alt="<?php if (!empty($settings['image']['alt'])) echo esc_attr($settings['image']['alt']); ?>" class="icon-img">
                                                </a>
                                            </div>
                                        </div>
                                    <?php elseif ($gallery_style == 'style4' && $settings['content_option'] == 'hover') : ?>
                                        <div class="cont d-flex justify-content-between align-items-center <?= $settings['content_option'] ?>">
                                            <div>
                                                <h5><a href="<?= esc_url(get_the_permalink()) ?>"><?= esc_html(get_the_title()); ?></a></h5>
                                                <p>
                                                    <?php
                                                    if ($settings['show'] == 'tag') {
                                                        $destudio_taxonomy = 'porto_tag';
                                                        $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy);
                                                        foreach ($destudio_taxs as $destudio_tax) {
                                                            $tag_link = '<a href="' . esc_url(get_term_link($destudio_tax)) . '">' . esc_html($destudio_tax->name) . '</a>';
                                                            echo $tag_link;
                                                        }
                                                    } else {
                                                        $category_terms = wp_get_post_terms($post->ID, 'portfolio_category');
                                                        if (!empty($category_terms)) {
                                                            $first_category_link = '<a href="' . esc_url(get_term_link($category_terms[0])) . '">' . esc_html($category_terms[0]->name) . '</a>';
                                                            echo $first_category_link;
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            <div>
                                                <a href="<?= esc_url(get_the_permalink()) ?>" class="picon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="17" viewBox="0 0 17 17">
                                                        <g>
                                                        </g>
                                                        <path d="M16 0.997v9.003h-1v-7.297l-10.317 10.297-0.707-0.708 10.315-10.295h-7.316v-1h9.025z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($gallery_style == 'style4' && $settings['content_option'] == 'under') : ?>
                                    <div class="cont <?= $settings['content_option'] ?>">
                                        <h5><a href="<?= esc_url(get_the_permalink()) ?>"><?= esc_html(get_the_title()); ?></a></h5>
                                        <p>
                                            <?php
                                            if ($settings['show'] == 'tag') {
                                                $destudio_taxonomy = 'porto_tag';
                                                $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy);
                                                foreach ($destudio_taxs as $destudio_tax) {
                                                    $tag_link = '<a href="' . esc_url(get_term_link($destudio_tax)) . '">' . esc_html($destudio_tax->name) . '</a>';
                                                    echo $tag_link;
                                                }
                                            } else {
                                                $category_terms = wp_get_post_terms($post->ID, 'portfolio_category');
                                                if (!empty($category_terms)) {
                                                    $first_category_link = '<a href="' . esc_url(get_term_link($category_terms[0])) . '">' . esc_html($category_terms[0]->name) . '</a>';
                                                    echo $first_category_link;
                                                }
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                <?php if ($itemCount == 3 && $gallery_style == 'style1') {
                            $itemCount = 0;
                        }
                        $itemCount++;
                    endwhile;
                endif;
                wp_reset_postdata(); ?>
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
    protected function content_template()
    {
    }
    private function get_taxonomy_terms()
    {
        $terms = get_terms(array(
            'taxonomy' => 'portfolio_category',
            'hide_empty' => true,
        ));

        $options = [];
        foreach ($terms as $term) {
            $options[$term->term_id] = $term->name;
        }

        return $options;
    }
    private function get_tag_options()
    {
        $tags = get_terms(array(
            'taxonomy' => 'porto_tag',
            'hide_empty' => true,
        ));

        $options = [];
        foreach ($tags as $tag) {
            $options[$tag->term_id] = $tag->name;
        }

        return $options;
    }
}
