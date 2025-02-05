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

class Infolio_Blog_Classic extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'infolio-blog-classic';
    }

    public function get_title()
    {
        return __('Infolio Blog Classic', 'infolio_plg');
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
                'label' => __('Blog List Settings', 'infolio_plg'),
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
                    '{{WRAPPER}} .infolio-blog-classic .item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
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
            'pagination',
            [
                'label' => esc_html__('Pagination', 'themescamp-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => false,
                'return' => 'yes'
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
            'content_margin',
            [
                'label' => esc_html__('Content Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .item .cont' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .item .cont' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .infolio-blog-classic .item .cont .title',
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .infolio-blog-classic .item .cont .post-date',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'date_border',
                'selector' => '{{WRAPPER}} .infolio-blog-classic .item .cont .post-date',
            ]
        );
        $this->add_control(
            'date_border_radius',
            [
                'label' => esc_html__('Border Radius', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .post-date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'date_margin',
            [
                'label' => esc_html__('Date Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .post-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'date_padding',
            [
                'label' => esc_html__('Date Padding', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .post-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_comment_style',
            [
                'label' => esc_html__('Comment Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'comment_opacity',
            [
                'label' => esc_html__( 'Opacity', 'infolio_plg' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .comment' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'comment_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-blog-classic .item .cont .comment',
            ]
        );
        $this->add_responsive_control(
            'comment_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'infolio_plg' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .comment svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .comment i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'comment_icon_margin',
            [
                'label' => esc_html__('Comment Icon Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .comment svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .comment i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_excerpt_style',
            [
                'label' => esc_html__('Excerpt Style', 'infolio_plg'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .infolio-blog-classic .item .cont .excerpt',
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
        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Button Margin', 'infolio_plg'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em' , 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .r-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .infolio-blog-classic .item .cont .r-more',
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
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .r-more svg' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .r-more i' => 'font-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .r-more svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .infolio-blog-classic .item .cont .r-more i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'pagination_style',
            [
                'label' => esc_html__('Pagination Style', 'themescamp-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pagination_alignment',
            [
                'label' => __('Pagination Alignment', 'themescamp-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'themescamp-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'themescamp-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'themescamp-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .pagination' => 'text-align: {{VALUE}};',
                ],
                'default' => 'center',
            ]
        );

        $this->add_control(
            'pagination_padding',
            [
                'label' => esc_html__('Pagination Padding', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .pagination a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_margin',
            [
                'label' => esc_html__('Pagination Margin', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .pagination a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'pagination_border',
                'selector' => '{{WRAPPER}} .infolio-blog-classic .pagination a',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pagination_border_radius',
            [
                'label' => esc_html__('Pagination Radius', 'themescamp-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .infolio-blog-classic .pagination a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


		$this->start_controls_tabs( 'tabs_pagination_item_style' );

		$this->start_controls_tab(
			'tab_pagination_item_normal',
			[
				'label' => __( 'Normal', 'themescamp-core' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .infolio-blog-classic .pagination a' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_background',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .infolio-blog-classic .pagination a',
                'exclude' => ['image']
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_menu_item_hover',
			[
				'label' => __( 'Hover', 'themescamp-core' ),
			]
		);

		$this->add_control(
			'pagination_color_hover',
			[
				'label' => __('Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .infolio-blog-classic .pagination a:hover' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'pagination_background_hover',
                'types' => ['classic', 'gradient', 'tcg_gradient'],
                'selector' => '{{WRAPPER}} .infolio-blog-classic .pagination a:hover',
                'exclude' => ['image']
            ]
        );

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
        
        if ($settings['pagination'] == 'yes'):
            $query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
        endif;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $query = new \WP_Query($query_args);
        ?>
        <div class="infolio-blog-classic">
           <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="item">
                <div class="img">
                    <img src="<?=esc_url(the_post_thumbnail_url()); ?>" alt="">
                </div>
                <div class="cont">
                    <div class="date-comment d-flex align-items-center">
                        <div class="post-date"><?php echo get_the_date(__('j F Y')); ?></div>
                        <div class="comment"><?php Icons_Manager::render_icon($settings['comments_icon'], ['aria-hidden' => 'true']); ?> <?=esc_html(get_comments_number()).' '.esc_html($settings['comments_text'])?></div>
                    </div>
                    <h4 class="title">
                        <a href="<?php esc_url(the_permalink()); ?>"><?=esc_html(get_the_title())?></a>
                    </h4>
                    <p class="excerpt"><?=get_the_excerpt()?></p>
                    <a href="<?php esc_url(the_permalink()); ?>" class="d-flex align-items-center r-more">
                        <?=esc_html($settings['read_more_text'])?>
                        <?php Icons_Manager::render_icon($settings['read_more_icon'], ['aria-hidden' => 'true']); ?>
                    </a>
                </div>
            </div>
           <?php endwhile;wp_reset_postdata(); ?>
            <?php if ($settings['pagination'] == 'yes'): ?>
                <div class="pagination">
                    <?php
                    $total_pages = $query->max_num_pages;
                    if ($total_pages > 1) {
                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo '<a href="' . esc_url(get_pagenum_link($i)) . '" ' . ($i == $paged ? 'class="current-page"' : '') . '>' . $i . '</a>';
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>
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


