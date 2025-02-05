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
class Infolio_Creative_Blog_List extends Widget_Base {

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
        return 'infolio-creative-blog-list';
    }

    public function get_script_depends()
    {
        return ['isotope.min', 'infolio-demos-gallery'];
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
        return __( 'Infolio Creative Blog', 'infolio_plg' );
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
            'read_more_icon',
            [
                'label' => esc_html__( 'Read More Icon', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__( 'Read More Text', 'infolio_plg' ),
                'default' => esc_html__( 'Read More', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXT,
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
            'item_padding',
            [
                'label' => esc_html__('Item Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'info_margin',
            [
                'label' => esc_html__('Info Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .infolio-creative-blog-list .item',
                'separator' => 'before',
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

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .cont .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .infolio-creative-blog-list .item .cont .title a',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em','rem','custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .cont .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .infolio-creative-blog-list .item .cont .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $this->add_control(
            'categories_bg',
            [
                'label' => esc_html__( 'Categories Background', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .cont .categories a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'categories_color',
            [
                'label' => esc_html__( 'Categories Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .cont .categories a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .infolio-creative-blog-list .item .cont .categories a',
            ]
        );

        $this->add_responsive_control(
            'category_margin',
            [
                'label' => esc_html__('Category Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em','rem','custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .cont .categories a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .infolio-creative-blog-list .item .cont .categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

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
                'selector' => '{{WRAPPER}} .infolio-creative-blog-list .item .date',
            ]
        );

        $this->add_responsive_control(
            'date_margin',
            [
                'label' => esc_html__('Date Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em','rem','custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .infolio-creative-blog-list .item .date' => 'opacity: {{SIZE}};',
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
        $this->add_control(
            'overlay_opacity',
            [
                'label' => esc_html__( 'Image Overlay Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 10,
                        'min' => 1,
                        'step' => 1,
                    ],
                ],
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'author_settings',
            [
                'label' => __( 'Author Setting','infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'author_text_heading',
            [
                'label' => esc_html__('Author Title', 'infolio_plg'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_text_typography',
                'selector' => '{{WRAPPER}} .infolio-creative-blog-list .item .info .author-text',
            ]
        );

        $this->add_responsive_control(
            'author_text_margin',
            [
                'label' => esc_html__('Author Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em','rem','custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .info .author-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .infolio-creative-blog-list .item .info .author-text' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_control(
            'author_name_heading',
            [
                'label' => esc_html__('Author Name', 'infolio_plg'),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_name_typography',
                'selector' => '{{WRAPPER}} .infolio-creative-blog-list .item .info .author-name',
            ]
        );

        $this->add_responsive_control(
            'author_name_margin',
            [
                'label' => esc_html__('Author Name Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em','rem','custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .info .author-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'author_image_heading',
            [
                'label' => esc_html__('Author Image', 'infolio_plg'),
                'type' => Controls_Manager::HEADING,
                'separator'=>'before'
            ]
        );
        $this->add_control(
            'author_border_radius',
            [
                'label' => esc_html__('Author Image Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .info .author-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $this->add_control(
            'button_color',
            [
                'label' => esc_html__( 'Button Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .more a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__( 'Button Text Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .more a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .infolio-creative-blog-list .item .more svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .infolio-creative-blog-list .item .more i' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .infolio-creative-blog-list .item .more a',
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
                    '{{WRAPPER}} .infolio-creative-blog-list .item .more svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-creative-blog-list .item .more i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Button Icon Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em','rem','custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-creative-blog-list .item .more svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-creative-blog-list .item .more i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        <div class="infolio-creative-blog-list">
        <?php $itemCount=1;$animationDelay=0.1; while ($query->have_posts()) : $query->the_post(); ?>
            <div class="item <?php if (!($itemCount%2==0)) echo 'change-background'?>  wow fadeInUp" data-wow-delay="<?=doubleval($animationDelay)?>s">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="info">
                            <div class="d-flex align-items-center">
                                <div class="author">
                                    <div class="author-image">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 60); ?>
                                    </div>
                                </div>
                                <div class="author-info">
                                    <span class="author-text"><?=esc_html__('Posted by','infolio_plg')?></span>
                                    <h6 class="author-name"><?=esc_html(get_the_author()); ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="cont">
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
                        </div>
                    </div>
                    <div class="col-lg-3 d-flex align-items-center justify-end">
                        <div class="ml-auto">
                            <span class="date"><?php echo get_the_date(__('j F Y')); ?></span>
                        </div>
                    </div>
                </div>
                <div class="background bg-img valign text-center" data-background="<?php esc_url(the_post_thumbnail_url()); ?>" data-overlay-dark="<?=intval($settings['overlay_opacity'])?>">
                    <div class="more">
                        <a href="<?php esc_url(the_permalink()); ?>">
                            <span>
                                <?=esc_html($settings['read_more_text'])?>
                                <?php Icons_Manager::render_icon($settings['read_more_icon'], ['aria-hidden' => 'true']); ?>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        <?php $animationDelay+=0.2;$itemCount++; endwhile; wp_reset_postdata(); ?>
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



