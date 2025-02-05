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
class Infolio_Work_Crus extends Widget_Base
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
        return 'infolio-work-crus';
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
        return __('Infolio Work Carsouel', 'infolio_plg');
    }

    public function get_script_depends()
    {
        return ['infolio-work-crus'];
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
            'section_content_slider',
            [
                'label' => __('Portfolio Slider Settings.', 'infolio_plg'),
            ]
        );
        $this->add_control(
            'loop',
            [
                'label' => __('Loop', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'center',
            [
                'label' => __('Center', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'space',
            [
                'label' => __('Space', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'default' => '40',
                'min' => '0',
                'max' => '100',
                'step' => '1'
            ]
        );
        $this->add_control(
            'items_per_slide_switch',
            [
                'label' => __('Items Per Slide', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );
        $this->add_control(
            'items_per_slide',
            [
                'label' => __('Items Per Slide', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'condition'=>['items_per_slide_switch'=>'yes'],
                'default' => '5',
                'min' => '0',
                'step' => '1',
            ]
        );
        $this->add_control(
            'different_width',
            [
                'label' => __('Different Width', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'infolio_plg'),
                'label_off' => __('No', 'infolio_plg'),
                'return_value' => 'yes',
            ]
        );
//        section heading
        $this->add_control(
            'sec_head',
            [
                'label' => __('Section Heading', 'infolio_plg'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'infolio_plg'),
                'label_off' => __('Hide', 'infolio_plg'),
                'return_value' => 'yes',
                'default' => 'yes'
            ]
        );
        $this->add_control(
            'sub_title',
            [
                'label' => __('Sub Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'condition'=>['sec_head'=>'yes'],
                'default' => 'OUR SPECIALIZE'
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'condition'=>['sec_head'=>'yes'],
                'default' => 'Our featured'
            ]
        );
        $this->add_control(
            'light_title',
            [
                'label' => __('Light Weight Title', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'condition'=>['sec_head'=>'yes'],
                'default' => 'projects'
            ]
        );
        $this->add_control(
            'right_icon',
            [
                'label' => esc_html__( 'Right Icon', 'infolio_plg' ),
                'condition'=>['sec_head'=>'yes'],
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $this->add_control(
            'left_icon',
            [
                'label' => esc_html__( 'Left Icon', 'infolio_plg' ),
                'condition'=>['sec_head'=>'yes'],
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $this->end_controls_section();

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

        $this->end_controls_section();
        $this->start_controls_section(
            'section_heading_style',
            [
                'label' => esc_html__( 'Section Heading', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>['sec_head'=>'yes'],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-work-carsouel .sec-head .sub-title',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-work-carsouel .sec-head h2',
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
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'portfolio_title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-work-carsouel .infolio-work-crus .item .cont h5',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-work-carsouel .infolio-work-crus .item .cont h5' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .infolio-work-carsouel .infolio-work-crus .item .cont span',
            ]
        );
        $this->add_responsive_control(
            'category_margin',
            [
                'label' => esc_html__('Category Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-work-carsouel .infolio-work-crus .item .cont span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .infolio-work-carsouel .infolio-work-crus .swiper-slide .item .img' => 'height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .infolio-work-carsouel .infolio-work-crus .swiper-slide .item .img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        <div class="infolio-work-carsouel">
            <?php if ($settings['sec_head']=='yes') : ?>
            <div class="container">
                <div class="sec-head">
                    <h6 class="sub-title"><?=esc_html($settings['sub_title'])?></h6>
                    <div class="bord d-flex align-items-center">
                        <h2 class="title"><?=esc_html($settings['title'])?> <span class="light-title"> <?=esc_html($settings['light_title'])?></span></h2>
                        <div class="buttons">
                            <div class="swiper-arrow-control">
                                <div class="swiper-button-prev">
                                    <?php Icons_Manager::render_icon($settings['left_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                                <div class="swiper-button-next">
                                    <?php Icons_Manager::render_icon($settings['right_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <div class="rest">
                <div class="infolio-work-crus out" data-swiper-speed="1000" <?php if ($settings['items_per_slide_switch']=='yes') :?> data-items="<?= esc_attr($settings['items_per_slide']) ?>"  <?php endif;?> <?php if ($settings['center']=='yes') : ?> data-center="center" <?php endif;?> <?php if ($settings['loop']=='yes') : ?> data-loop="true" <?php endif;?> data-space="<?= esc_attr($settings['space']); ?>">
                    <div id="content-carousel-container-unq-w" class="swiper-container"
                         data-swiper="container">
                        <div class="swiper-wrapper">
                            <?php if ($destudio_work->have_posts()) : while  ($destudio_work->have_posts()) : $destudio_work->the_post();
                                global $post ; ?>
                                <div class="swiper-slide">
                                    <div class="item">
                                        <div class="img">
                                            <img src="<?= esc_url(get_the_post_thumbnail_url()); ?>" alt="">
                                            <div class="cont">
                                                <span>
                                                    <?php
                                                    $destudio_taxonomy = 'portfolio_category';
                                                    $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy);
                                                    $count = 1;
                                                    foreach ($destudio_taxs as $destudio_tax) {
                                                        if($count != 1) echo ', '; ?>
                                                        <?php echo $destudio_tax->name; ?>
                                                        <?php $count++;
                                                    }; ?>
                                                </span>
                                                <h5><?= esc_html(get_the_title()); ?></h5>
                                            </div>
                                            <a href="<?=esc_url(get_the_permalink())?>" class="plink"></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; endif; wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
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
