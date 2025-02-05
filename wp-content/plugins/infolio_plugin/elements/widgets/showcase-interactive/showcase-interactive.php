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
class Infolio_Showcase_Interactive extends Widget_Base
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
        return 'infolio-showcase-interactive';
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
        return __('Infolio Showcase Interactive', 'infolio_plg');
    }

    public function get_script_depends()
    {
        return ['infolio-interactive-work'];
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
        return 'eicon-image-before-after';
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
                'label' => __('Portfolio Tabs Settings.', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'display_option',
            [
                'label' => __('Display', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'full' => __('Full', 'infolio_plg'),
                    'vertical' => __('Vertical', 'infolio_plg'),
                ],
                'default' => 'full',
            ]
        );
        $this->add_control(
            'portfolio_item',
            [
                'label' => __('Item to display', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'default' => '8',
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
            'show_tags',
            [
                'label' => __('Show Tags', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'slider_settings',
            [
                'label' => __( 'Slider Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'overlay_opacity',
            [
                'label' => esc_html__( 'Image Overlay Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-inter-links-center [data-overlay-dark]:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .infolio-inter-links-center .title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em','rem'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-inter-links-center .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        <section class="infolio-inter-links-center <?=esc_attr($settings['display_option'])?>">
            <div class="container-xxl">
                <div class="row">
                    <div class="col-12 d-flex align-items-center <?php if ($settings['display_option']=='vertical')echo 'justify-content-center'?>">
                        <div class="links-text">
                            <ul class="rest">
                            <?php $itemCount=1; if ($destudio_work->have_posts()) : while  ($destudio_work->have_posts()) : $destudio_work->the_post();
                            global $post ; ?>
                                <li data-tab="tab-<?=$itemCount?>">
                                    <h2 class="title">
                                        <span class="num"><?=($itemCount<10) ? "0$itemCount":"$itemCount"?>.</span>
                                        <a href="<?=esc_url(get_the_permalink())?>"><span class="text f-bold"><?=esc_html(get_the_title())?></span> </a>
                                    </h2>
                                </li>
                            <?php $itemCount++; endwhile; endif; wp_reset_postdata(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="links-img">
            <?php $itemCount=1; if ($destudio_work->have_posts()) : while  ($destudio_work->have_posts()) : $destudio_work->the_post();
            global $post ; ?>
                <div class="img" id="tab-<?=$itemCount?>" data-overlay-dark="3">
                    <img src="<?=esc_url(get_the_post_thumbnail_url());?>" alt="">
                </div>
            <?php $itemCount++; endwhile; endif; wp_reset_postdata(); ?>
            </div>
        </section>
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
