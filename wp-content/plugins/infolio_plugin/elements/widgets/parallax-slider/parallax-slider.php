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
class Infolio_Parallax_Slider extends Widget_Base
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
        return 'infolio-parallax-slider';
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
        return __('Infolio Parallax Slider', 'infolio_plg');
    }

    public function get_script_depends()
    {
        return ['infolio-parallax-slider'];
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
            'right_icon',
            [
                'label' => esc_html__( 'Next Icon', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $this->add_control(
            'right_text',
            [
                'label' => esc_html__( 'Next Text', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );
        $this->add_control(
            'left_icon',
            [
                'label' => esc_html__( 'Previous Icon', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::ICONS,
            ]
        );
        $this->add_control(
            'left_text',
            [
                'label' => esc_html__( 'Previous Text', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::TEXT,
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
            'section_portfolio_style',
            [
                'label' => esc_html__( 'Section Portfolio', 'infolio_plg' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'portfolio_color',
            [
                'label' => esc_html__( 'Title Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-parallax-slider .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'portfolio_title_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-parallax-slider .title',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-parallax-slider .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'category_color',
            [
                'label' => esc_html__( 'Category Color', 'infolio_plg' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .infolio-parallax-slider .category' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .infolio-parallax-slider .category',
            ]
        );
        $this->add_responsive_control(
            'category_margin',
            [
                'label' => esc_html__('Category Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-parallax-slider .category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'swiper_controls_typography',
                'label' => esc_html__('Swiper Controls', 'infolio_plg'),
                'separator'=>'before',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .infolio-parallax-slider .swiper-controls .swiper-text',
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
        <div class="infolio-parallax-slider swiper-container">
            <div class="swiper-wrapper">
            <?php $itemCount=1; if ($destudio_work->have_posts()) : while  ($destudio_work->have_posts()) : $destudio_work->the_post();
            global $post ; ?>
                <div class="swiper-slide">
                    <div class="bg-img valign" data-background="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" <?= ($itemCount==3) ? 'data-overlay-light="5"':'data-overlay-dark="3"'?>>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-11 offset-lg-1">
                                    <div class="caption">
                                        <h6 class="category <?php if ($itemCount==3)echo 'text-dark'?>" data-swiper-parallax="-1000"><?=esc_html('© ','infolio_plg')?> <?php echo get_the_date('Y'); ?>
                                            <br>
                                            <?php
                                            $destudio_taxonomy = 'portfolio_category';
                                            $destudio_taxs = wp_get_post_terms($post->ID, $destudio_taxonomy);
                                            $count = 1;
                                            foreach ($destudio_taxs as $destudio_tax) {
                                                if($count != 1) echo ', '; ?>
                                                <?php echo $destudio_tax->name; ?>
                                                <?php $count++;
                                            }; ?>
                                        </h6>
                                        <h1 class="title <?php if ($itemCount==3)echo 'text-dark'?>">
                                            <a href="<?=esc_url(get_the_permalink())?>">
                                                <?php if ($itemCount == 2 || $itemCount == 3 || $itemCount == 7) :
                                                    $title_parts = explode(' ', get_the_title(), 2);
                                                    ?>
                                                    <span data-swiper-parallax="-2000"><?= esc_html($title_parts[0]); ?></span>
                                                    <br>
                                                    <span data-swiper-parallax="-3000"><?= esc_html($title_parts[1]); ?></span>
                                                <?php else : ?>
                                                    <span data-swiper-parallax="-2000"><?= get_the_title(); ?></span>
                                                <?php endif; ?>
                                            </a>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php if ($itemCount==7){$itemCount=0;}$itemCount++; endwhile; endif; wp_reset_postdata(); ?>

            </div>
            <div class="swiper-controls">
                <div class="swiper-button-next swiper-nav-ctrl cursor-pointer">
                    <div>
                        <span class="swiper-text"><?=esc_html($settings['right_text'])?></span>
                    </div>
                    <div><?php Icons_Manager::render_icon($settings['right_icon'], ['aria-hidden' => 'true']); ?></div>
                </div>
                <div class="swiper-button-prev swiper-nav-ctrl cursor-pointer">
                    <div><?php Icons_Manager::render_icon($settings['left_icon'], ['aria-hidden' => 'true']); ?></div>
                    <div>
                        <span class="swiper-text"><?=esc_html($settings['left_text'])?></span>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
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
