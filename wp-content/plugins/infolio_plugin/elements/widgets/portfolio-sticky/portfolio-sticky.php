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
class Infolio_Portfolio_Sticky extends Widget_Base
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
        return 'infolio-portfolio-sticky';
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
        return __('Infolio Portfolio Sticky', 'infolio_plg');
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
            'portfolio_item',
            [
                'label' => __('Item to display', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
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
                'type'    => Controls_Manager::SELECT,
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
        $this->add_control(
            'read_more_image',
            [
                'label' => __('Choose Image', 'infolio_plg'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ]
            ]
        );
        $this->add_control(
            'read_more_text',
            [
                'label' => __('Read More Text', 'infolio_plg'),
                'default' => esc_html__('Read More', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_portfolio_style',
            [
                'label' => esc_html__( 'Section Portfolio', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'content_border_radius',
            [
                'label' => esc_html__( 'Content Border Radius', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-sticky .item .cont' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Content Padding', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'separator'=>'after',
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-sticky .item .cont' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_margin',
            [
                'label' => esc_html__( 'Item Margin', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-sticky .items' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'label' => esc_html__( 'Item Border', 'infolio_plg' ),
                'selector' => '{{WRAPPER}} .infolio-portfolio-sticky .items',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Section Title & Category', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'title_heading',
            [
                'label' => esc_html__( 'Title Style', 'infolio_plg' ),
                'type' => Controls_Manager::HEADING,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'portfolio_title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-portfolio-sticky .items .cont h5',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-sticky .items .cont h5' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'cat_heading',
            [
                'label' => esc_html__( 'Category Style', 'infolio_plg' ),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );
        $this->add_control(
            'cat_opacity',
            [
                'label' => esc_html__( 'Category Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-sticky .items .cont h6' => 'opacity: {{SIZE}};',
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
                'selector' => '{{WRAPPER}} .infolio-portfolio-sticky .items .cont h6 ',
            ]
        );
        $this->add_responsive_control(
            'category_margin',
            [
                'label' => esc_html__('Category Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-sticky .items .cont h6' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'excerpt_heading',
            [
                'label' => esc_html__( 'Excerpt Style', 'infolio_plg' ),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-portfolio-sticky .items .cont p',
            ]
        );
        $this->add_responsive_control(
            'excerpt_margin',
            [
                'label' => esc_html__('Excerpt Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-sticky .items .cont p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_image_style',
            [
                'label' => esc_html__( 'Section Image', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__( 'Image Height', 'infolio_plg' ),
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
                    '{{WRAPPER}} .infolio-portfolio-sticky .items .img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-portfolio-sticky .items .img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'button_settings',
            [
                'label' => __( 'Read More Button Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-portfolio-sticky .items .cont .rmore .read-more-text',
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
                    '{{WRAPPER}} .infolio-portfolio-sticky .items .cont .rmore icon-img' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .infolio-portfolio-sticky .items .cont .rmore icon-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $infolio_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
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
                'paged' => $infolio_paged,
                'posts_per_page'   => $settings['portfolio_item'],
                'post_type' =>  'portfolio', 'infolio_plg',
                $order       =>  $ord_val
            ));
        }
        ?>
        <div class="infolio-portfolio-sticky">
            <div class="row">
            <?php $itemCount=1; if ($destudio_work->have_posts()) : while  ($destudio_work->have_posts()) : $destudio_work->the_post();
            global $post ; ?>
                <?php if ($itemCount%2==0) :?>
                    <div class="col-lg-4 items">
                        <div class="cont">
                            <div class="tc-sticky-item">
                                <h6>
                                    <?php
                                    $destudio_taxonomy = 'portfolio_category';
                                    $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy);
                                    $count = 1;
                                    foreach ($destudio_taxs as $destudio_tax) {
                                        if($count != 1) echo ', ';
                                        echo $destudio_tax->name;
                                        $count++;
                                    };
                                    ?>
                                </h6>
                                <h5><?= esc_html(get_the_title()); ?></h5>
                                <p><?= get_the_excerpt(); ?></p>
                                <a href="<?=esc_url(get_the_permalink())?>" class="rmore">
                                    <span class="read-more-text"><?=$settings['read_more_text']?></span>
                                    <img src="<?=$settings['read_more_image']['url']?>" alt="<?php if (!empty($settings['read_more_image']['alt'])) echo esc_attr($settings['read_more_image']['alt']); ?>" class="icon-img">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 items">
                        <div class="img">
                            <img src="<?= esc_url(get_the_post_thumbnail_url()); ?>" alt="">
                        </div>
                    </div>
                <?php else:?>
                    <div class="col-lg-8 items">
                        <div class="img">
                            <img src="<?= esc_url(get_the_post_thumbnail_url()); ?>" alt="">
                        </div>
                    </div>
                    <div class="col-lg-4 items">
                        <div class="cont">
                            <div class="tc-sticky-item">
                                <h6>
                                    <?php
                                    $destudio_taxonomy = 'portfolio_category';
                                    $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy);
                                    $count = 1;
                                    foreach ($destudio_taxs as $destudio_tax) {
                                        if($count != 1) echo ', ';
                                        echo $destudio_tax->name;
                                        $count++;
                                    };
                                    ?>
                                </h6>
                                <h5><?= esc_html(get_the_title()); ?></h5>
                                <p><?= get_the_excerpt(); ?></p>
                                <a href="<?=esc_url(get_the_permalink())?>" class="rmore">
                                    <span class="read-more-text"><?=$settings['read_more_text']?></span>
                                    <img src="<?=$settings['read_more_image']['url']?>" alt="<?php if (!empty($settings['read_more_image']['alt'])) echo esc_attr($settings['read_more_image']['alt']); ?>" class="icon-img">
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            <?php $itemCount++; endwhile; endif; wp_reset_postdata(); ?>
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
    private function get_taxonomy_terms() {
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
    private function get_tag_options() {
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
