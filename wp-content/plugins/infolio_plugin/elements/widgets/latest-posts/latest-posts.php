<?php
namespace InfolioPlugin\Widgets;

use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Frontend;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Image_Size;
use Elementor\Scheme_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH')) exit;

class Infolio_Latest_Posts extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'infolio-latest-posts';
    }

    public function get_title()
    {
        return __('Infolio Latest Posts', 'infolio_plg');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_categories()
    {
        return ['infolio-elements'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Latest Posts Settings', 'infolio_plg'),
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between Posts', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-latest-posts .item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'blog_post',
            [
                'label' => __('Blog Post to show', 'infolio_plg'),
                'type' => Controls_Manager::NUMBER,
                'default' => '3',

            ]
        );

        $this->add_control(
            'category',
            [
                'label' => __('Category', 'infolio_plg'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => $this->infolio_category_options(),
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
            'read_more_text',
            [
                'label' => __('Read More Button Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Read More',
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
            'comments_text',
            [
                'label' => __('Comments Text', 'infolio_plg'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Comments',
            ]
        );

        $this->add_control(
            'comments_icon',
            [
                'label' => esc_html__( 'Comments Icon', 'infolio_plg' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_card_style',
            [
                'label' => esc_html__('Content Card Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-latest-posts .item .cont' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-latest-posts .item .cont .title',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-latest-posts .item .cont .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_date_style',
            [
                'label' => esc_html__('Date Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-latest-posts .item .img .post-date',
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
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'selector' => '{{WRAPPER}} .infolio-latest-posts .item .cont .categories a',
            ]
        );
        $this->add_responsive_control(
            'cat_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'infolio_plg' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-latest-posts .item .cont .categories' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

    }
    protected function render() {
        $settings = $this->get_settings_for_display();
        $selected_tag = $settings['selected_tag'];
        $query_args = array(
            'posts_per_page' => $settings['blog_post'],
            'post_type' => 'post',
            'order' => $settings['post_order'],
        );

        if (!empty($settings['category'])) {
            $query_args['cat'] = $settings['category'];
        }
        if (!empty($selected_tag)) {
            $query_args['tag__in'] = $selected_tag;
        }

        $query = new \WP_Query($query_args);
        ?>
        <div class="infolio-latest-posts">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="item d-flex align-items-center">
                    <div>
                        <div class="img">
                            <a href="<?php esc_url(the_permalink()); ?>">
                                <img src="<?=esc_url(the_post_thumbnail_url()); ?>" alt="">
                                <span class="post-date">
                                    <span><?= esc_html(get_the_date('d')); ?> <?=esc_html__('/','infolio_plg')?> <br> <?= esc_html(get_the_date('M')); ?></span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="cont">
                        <span class="categories">
                           <?php $post_categories = get_the_category();
                           if ($post_categories) {
                               foreach ($post_categories as $post_category) {
                                   echo '<a href="' . esc_url(get_category_link($post_category->term_id)) . '">' . esc_html($post_category->name) . '</a>';
                               }
                           }
                           ?>
                        </span>
                        <h6 class="title"><a href="<?php esc_url(the_permalink()); ?>"><?=esc_html(get_the_title())?></a></h6>
                    </div>
                </div>
            <?php endwhile;wp_reset_postdata(); ?>
        </div>
        <?php
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


