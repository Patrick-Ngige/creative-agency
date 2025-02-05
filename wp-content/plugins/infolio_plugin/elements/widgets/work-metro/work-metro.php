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
class Infolio_Work_Metro extends Widget_Base
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
        return 'infolio-work-metro';
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
        return __('Infolio Work Metro', 'infolio_plg');
    }

    public function get_script_depends()
    {
        return ['infolio-work-metro'];
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
        return 'eicon-post-slider';
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
            'info_style',
            [
                'label' => __('Style', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'hover' => __('Caption On Cursor Hover', 'infolio_plg'),
                    'under' => __('Caption Under Image', 'infolio_plg'),
                ],
                'default' => 'hover',
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

        $this->end_controls_section();
        $this->start_controls_section(
            'section_portfolio_style',
            [
                'label' => esc_html__( 'Section Cursor Hover', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>['info_style'=>'hover'],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'portfolio_title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '.blank-builder .infolio-div-tooltip-tit',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '.blank-builder .infolio-div-tooltip-sub',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_under_style',
            [
                'label' => esc_html__( 'Section Title & Category', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'cont_section_margin',
            [
                'label' => esc_html__('Content Section Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-work-metro .item .cont' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'under_title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-work-metro .item .cont .title a',
            ]
        );
        $this->add_responsive_control(
            'under_title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-work-metro .item .cont .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'under_category_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-work-metro .item .cont .category',
            ]
        );
        $this->add_responsive_control(
            'under_category_margin',
            [
                'label' => esc_html__('Category Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-work-metro .item .cont .category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'container_height',
            [
                'label' => esc_html__( 'Container Image Height', 'infolio_plg' ),
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
                    '{{WRAPPER}} .infolio-work-metro .item .img' => 'height: {{SIZE}}{{UNIT}};',
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

        <div class="infolio-work-metro">
            <div class="row xxlg-marg justify-content-between">
                <?php $itemCount=1; if ($destudio_work->have_posts()) : while  ($destudio_work->have_posts()) : $destudio_work->the_post();
                global $post ; ?>
                <div class="<?= ($itemCount==1 || $itemCount== 4 || $itemCount==5 || $itemCount==8) ? 'col-lg-8':'col-lg-4'?> col-md-6">
                    <div class="item">
                        <?php if ($settings['info_style']=='hover') : ?>
                        <div class="img p-relative" data-tooltip-tit="<?= esc_html(get_the_title()); ?>" data-tooltip-sub="<?php
                                $destudio_taxonomy = 'portfolio_category';
                                $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy);
                                $count = 1;
                                foreach ($destudio_taxs as $destudio_tax) {
                                    if($count != 1) echo ', ';
                                    echo $destudio_tax->name;
                                    $count++;
                                }; ?>">
                            <a href="<?=esc_url(get_the_permalink())?>" class="plink"></a>
                            <?php else:?>
                            <div class="img">
                            <?php endif;?>
                            <img src="<?= esc_url(get_the_post_thumbnail_url()); ?>" alt="">
                        </div>
                        <?php if ($settings['info_style']=='under') : ?>
                            <div class="cont d-flex align-items-center">
                                <h5 class="title">
                                    <a href="<?=esc_url(get_the_permalink())?>"><?= esc_html(get_the_title()); ?></a>
                                </h5>
                                <p class="category">
                                    <?php
                                    $category_terms = wp_get_post_terms($post->ID, 'portfolio_category');

                                    $category_links = array_map(function ($term) {
                                        return '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
                                    }, $category_terms);

                                    $category_list = implode(', ', $category_links);
                                    ?>
                                    <?= $category_list; ?>
                                </p>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
                <?php if($itemCount==8){$itemCount=0;}$itemCount++; endwhile; endif; wp_reset_postdata(); ?>
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
