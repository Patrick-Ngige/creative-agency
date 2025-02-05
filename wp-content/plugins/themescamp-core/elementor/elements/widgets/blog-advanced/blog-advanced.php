<?php

namespace ThemescampPlugin\Elementor\Elements\Widgets;

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


if (!defined('ABSPATH')) exit; // Exit if accessed directly



/**
 * @since 1.0.0
 */
class TCG_Blog_Advanced extends Widget_Base
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
		return 'tcg-blog-advanced';
	}

    //script depend
	public function get_script_depends() { 
        return [ 'blog-advanced' ]; 
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
		return __('TC Blog advanced', 'themescamp-core');
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
		return 'eicon-document-file';
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
		return ['themescamp-elements'];
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

	protected function register_controls()
	{
		$this->start_controls_section(
			'post-list',
			[
				'label' => esc_html__('Post List', 'themescamp-core')
			]
		);
		$this->add_control(
			'posts_view',
			[
				'label' => __('Posts View', 'themescamp-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'row_view' => __('Row View', 'themescamp-core'),
					'column_view' => __('Column View', 'themescamp-core')
				],
				'default' => 'row_view'
			]
		);

        $this->add_control('masonry',[
				'label' => __( 'Masonry', 'themescamp-core' ),
				'type' => Controls_Manager::SWITCHER,
                'frontend_available' => true,
                'default'  => 'no',
                'return_value' => 'tcg-masonry',
				'condition' => [
					'posts_view' => 'row_view'
				]
			]
		);

		$this->add_control(
			'separator',
			[
				'label' => __('Separator', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __('Yes', 'themescamp-core'),
				'label_off' => __('No', 'themescamp-core'),
				'return_value' => 'yes',
				'condition' => [
					'posts_view' => 'column_view'
				]
			]
		);		

		$this->add_control(
			'show_image',
			[
				'label' => __('Show Post Image', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Yes', 'themescamp-core'),
				'label_off' => __('No', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'posts_to_show',
			[
				'label' => __('Posts To Show', 'themescamp-core'),
				'type' => Controls_Manager::NUMBER,
				'default' => '3',
			]
		);
		$this->add_control(
			'sort_cat',
			[
				'label' => __('Sort post by Category', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __('Yes', 'themescamp-core'),
				'label_off' => __('No', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'blog_cat',
			[
				'label'   => __('Category', 'themescamp-core'),
				'type'    => Controls_Manager::SELECT2, 'options' => themescamp_category_choice(),
				'condition' => [
					'sort_cat' => 'yes',
				],
				'multiple'   => 'true',
			]
		);

		$this->add_control(
			'paged_on',
			[
				'label' => __('Always show the same list on every page(not paged).', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'label_block' => true,
				'default' => '',
				'label_on' => __('Yes', 'themescamp-core'),
				'label_off' => __('No', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
			'sort_tag',
			[
				'label' => __('Sort post by Tag', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __('Yes', 'themescamp-core'),
				'label_off' => __('No', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'blog_tag',
			[
				'label'   => __('Tag', 'themescamp-core'),
				'type'    => Controls_Manager::SELECT2, 'options' => themescamp_post_tag_choice(),
				'condition' => [
					'sort_tag' => 'yes',
				],
				'multiple'   => 'true',
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__('Order By', 'themescamp-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ASC' => esc_html__('Ascending', 'themescamp-core'),
					'DESC' => esc_html__('Descending', 'themescamp-core')
				],
				'default' => 'ASC'
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __('Show Title', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Show', 'themescamp-core'),
				'label_off' => __('Hide', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => __('Show Exerpt', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Show', 'themescamp-core'),
				'label_off' => __('Hide', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);
        
		$this->add_control(
			'excerpt',
			[
				'label' => __('Blog Excerpt Length', 'themescamp-core'),
				'type' => Controls_Manager::NUMBER,
				'default' => '150',
				'min' => 10,
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_after',
			[
				'label' => __('After Excerpt text/symbol', 'themescamp-core'),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'show_excerpt' => 'yes',
				],
				'default' => '...',
			]
		);

		$this->add_control(
			'show_main_cat',
			[
				'label' => __('Show Main Category', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Show', 'themescamp-core'),
				'label_off' => __('Hide', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);

		// $this->add_control(
		// 	'category_date',
		// 	[
		// 		'label' => __('Show Category & Date Inlined', 'themescamp-core'),
		// 		'type' => Controls_Manager::SWITCHER,
		// 		'default' => 'no',
		// 		'label_on' => __('Show', 'themescamp-core'),
		// 		'label_off' => __('Hide', 'themescamp-core'),
		// 		'return_value' => 'yes',
		// 	]
		// );


		$this->add_responsive_control(
			'cat_date_margin',
			[
				'label' => __('Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .category-date' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'columns_number',
			[
				'label' => __('Columns number', 'themescamp-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'12' => __('1 Column', 'themescamp-core'),
					'6' => __('2 Columns', 'themescamp-core'),
					'4' => __('3 Columns', 'themescamp-core'),
					'3' => __('4 Columns', 'themescamp-core'),
				],
				'default' => '4',
				'condition' => [
					'posts_view' => 'row_view'
				]
			]
		);

		$this->add_control(
			'date',
			[
				'label' => __('Show date', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Show', 'themescamp-core'),
				'label_off' => __('Hide', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'category_date',
			[
				'label' => __('Show Category & Date Inlined', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __('Show', 'themescamp-core'),
				'label_off' => __('Hide', 'themescamp-core'),
				'return_value' => 'yes',
				'condition' => [
					'date' => 'yes',
					'show_main_cat' => 'yes'
				]
			]
		);

		$this->add_control(
			'separator_type',
			[
				'label' => __( 'Separator Type', 'themescamp-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'icon' => __( 'Icon', 'themescamp-core' ),
					'text' => __( 'Text', 'themescamp-core' ),
				],
				'default' => 'text',
				'condition' => [
					'category_date' => 'yes'
				]
			]
		);

		$this->add_control(
			'text_separator',
			[
				'label' => __('Text Separator', 'themescamp-core'),
				'type' => Controls_Manager::TEXT,
				'default' => __(' /', 'themescamp-core'),
				'condition' => [
					'separator_type' => 'text',
					'category_date' => 'yes'
				]
			]
		);

		$this->add_control(
			'image_separator',
			[
				'label' => __('Image Separator', 'themescamp-core'),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'separator_type' => 'icon',
					'category_date' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'separator_margin',
			[
				'label' => __('Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card .category-date .tags .icon' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'date_type',
			[
				'label' => __('Date Type', 'themescamp-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'show_date_ago' => esc_html__('Time ago', 'themescamp-core'),
					'show_date_time' => esc_html__('Date-Time', 'themescamp-core'),
					'month_day_year' => esc_html__('Month Day, Year', 'themescamp-core')
				],
				'condition' => [
					'date' => 'yes'
				]
			]
		);

		$this->add_control(
			'author',
			[
				'label' => __('Show Author', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Show', 'themescamp-core'),
				'label_off' => __('Hide', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'author_style',
			[
				'label' => __('Author Style', 'themescamp-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style1' => __('Default', 'themescamp-core'),
					'style2' => __('Style 2', 'themescamp-core')
				],
				'default' => 'style1',
				'condition' => [
					'author' => 'yes',
					'category_date' => 'yes'
				]
			]
		);

		$this->add_control(
			'posted_by_text',
			[
				'label' => __('Posted By', 'themescamp-core'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Posted By'
			]
		);

		$this->add_control(
			'author_date_pos',
			[
				'label' => esc_html__( 'Author & Date Position', 'themescamp-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'down',
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'themescamp-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'down' => [
						'title' => esc_html__( 'Bottom', 'themescamp-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'condition' => [
					'show_author' => 'yes',
					'show_date' => 'yes'
				]
			]
		);

		$this->add_control(
			'read_more',
			[
				'label' => __('Read More', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
				'label_on' => __('Show', 'themescamp-core'),
				'label_off' => __('Hide', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'card_style',
			[
				'label' => __('Card Style', 'themescamp-core'),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);



		$this->add_control(
			'display',
			[
				'label' => __('Display', 'themescamp-core'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'column' => __('Column', 'themescamp-core'),
					'row'    => __('Row', 'themescamp-core')
				],
				'default' => 'column',
				'condition' => [
					'show_image!' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'post_info_offset',
			[
				'label' => esc_html__( 'Post Info Offset', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -200,
						'max' => 200,
					],
				],
				'size_units' => [ 'px', '%' ],
				'default' => [
					'size' => '0',
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .post-info' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover',
				'label' => esc_html__( 'Box Shadow', 'plugin-name' ),
				'selector' => '{{WRAPPER}} .blog-card',
			]
		);

		$this->add_responsive_control(
			'card_margin',
			[
				'label' => __('Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' => __('Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .card_container' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'card_border_radius',
			[
				'label' => __('Border Radius', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .card_container' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tcg-post-list .card_container .blog-card' => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'inf_padding',
			[
				'label' => __('Info Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .btm-inf' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'inf_margin',
			[
				'label' => __('Info Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .btm-inf' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_settings',
			[
				'label' => __('Title Setting', 'themescamp-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'title_margins',
			[
				'label' => __('Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .card_container .blog-card-title' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'title_pos',
			[
				'label' => esc_html__( 'Title Position', 'themescamp-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'themescamp-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'down' => [
						'title' => esc_html__( 'Down', 'themescamp-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
			]
		);

		$this->start_controls_tabs('tabs_title');
		$this->start_controls_tab(
			'tite_normal',
			[
				'label' => __('Normal', 'themescamp-core')
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Title Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card .info .blog-card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .tcg-post-list .blog-card .info .blog-card-title',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'title_hover',
			[
				'label' => __('Hover', 'themescamp-core')
			]
		);
		$this->add_control(
			'title_color_hover',
			[
				'label' => esc_html__('Title Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card .info .blog-card-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography_hover',
				'selector' => '{{WRAPPER}} .tcg-post-list .blog-card .info .blog-card-title:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();


		$this->end_controls_section();

		$this->start_controls_section(
			'category_settings',
			[
				'label' => __('Category Setting', 'themescamp-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'before_dot',
			[
				'label' => __('Before Dot', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __('Yes', 'themescamp-core'),
				'label_off' => __('No', 'themescamp-core'),
				'return_value' => 'yes',
				'condition' => [
					'category_date' => 'yes'
				]
			]
		);

		$this->add_control(
			'border',
			[
				'label' => esc_html__( 'Border', 'themescamp-core' ),
				'type' => Controls_Manager::NUMBER,
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card .tags a' => 'border: {{VALUE}}px solid',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'themescamp-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card .tags a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cat_padding',
			[
				'label' => __('Container Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .card_container .post-info .tags' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .tcg-post-list .card_container .tags' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'cat_item_padding',
			[
				'label' => __('Item Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .card_container .post-info .tags a' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					'{{WRAPPER}} .tcg-post-list .card_container .tags a' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'category_border_color',
			[
				'label' => esc_html__('Border Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card .tags a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => esc_html__('Category Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card .tags a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cat_pos',
			[
				'label' => esc_html__( 'Category Position', 'themescamp-core' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'themescamp-core' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'themescamp-core' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card .img .tags' => '{{VALUE}}: 30px !important'
				],
				'condition' => [
					'show_image' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'cat_pos_left',
			[
				'label' => esc_html__( 'Position', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'cat_pos' => 'left',
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card .img .tags' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'cat_pos_right',
			[
				'label' => esc_html__( 'Position', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'condition' => [
					'cat_pos' => 'right',
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .blog-card .img .tags' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);


		// $this->add_control(
		// 	'category_bg',
		// 	[
		// 		'label' => esc_html__( 'Category Background', 'themescamp-core' ),
		// 		'type' => Controls_Manager::COLOR,
		// 		'selectors' => [
		// 			'{{WRAPPER}} .tcg-post-list .blog-card .img .tags a' => 'background-color: {{VALUE}};',
		// 		],
		// 	]
		// );

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'category_background',
				'label' => __('Category Background', 'themescamp-core'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .tcg-post-list .blog-card .tags a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'selector' => '{{WRAPPER}} .tcg-post-list .blog-card .tags a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'date_settings',
			[
				'label' => __('Date Setting', 'themescamp-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'before_date_icon',
			[
				'label' => __('Before Icon', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __('Yes', 'themescamp-core'),
				'label_off' => __('No', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'date_color',
			[
				'label' => esc_html__('Date Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .date' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'date_color_dark_mode',
			[
				'label' => esc_html__('Date Color (Dark Mode)', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-post-list .date' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .tcg-post-list .date' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				'selector' => '{{WRAPPER}} .tcg-post-list .date',
			]
		);

		// $this->add_responsive_control(
		// 	'date_padding',
		// 	[
		// 		'label' => __('Padding', 'themescamp-core'),
		// 		'type' => Controls_Manager::DIMENSIONS,
		// 		'size_units' => ['px', '%'],
		// 		'selectors' => [
		// 			'{{WRAPPER}} .tcg-post-list .date' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
		// 		],
		// 	]
		// );

		$this->add_control(
			'with_background',
			[
				'label' => __('With Background', 'themescamp-core'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __('Yes', 'themescamp-core'),
				'label_off' => __('No', 'themescamp-core'),
				'return_value' => 'yes',
			]
		);
		
		$this->add_responsive_control(
			'date_margin',
			[
				'label' => esc_html__('Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'date_border',
				'selector' => '{{WRAPPER}} .tcg-post-list .date',
			]
		);

		$this->add_responsive_control(
			'date_padding',
			[
				'label' => esc_html__('Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'with_background' => 'yes'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'date_background',
				'label' => __('Date Background', 'themescamp-core'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .tcg-post-list .date',
				'condition' => [
					'with_background' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'date_border_radius',
			[
				'label' => esc_html__('Border Radius', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'with_background' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'author_settings',
			[
				'label' => __('Author Setting', 'themescamp-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'author_color',
			[
				'label' => esc_html__('Author Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .author-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'author_color_dark_mode',
			[
				'label' => esc_html__('Author Color (Dark Mode)', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-post-list .author-name a' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .tcg-post-list .author-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'postedby_color',
			[
				'label' => esc_html__('Posted By Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .posted-by' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'postedby_color_dark_mode',
			[
				'label' => esc_html__('Posted By Color (Dark Mode)', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'@media (prefers-color-scheme: dark){ body.tcg-auto-mode {{WRAPPER}} .tcg-post-list .posted-by' => 'color: {{VALUE}};',
					'} body.tcg-dark-mode {{WRAPPER}} .tcg-post-list .posted-by' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'postedby_typography',
				'selector' => '{{WRAPPER}} .tcg-post-list .posted-by',
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_typography',
				'label' => __('Author Typography' , 'themescamp-core'),
				'selector' => '{{WRAPPER}} .tcg-post-list .author-name, {{WRAPPER}} .tcg-post-list .author-name a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'excerpt_settings',
			[
				'label' => __('Excerpt Setting', 'themescamp-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'excerpt_margin',
			[
				'label' => __('Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .info .text' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => esc_html__('Excerpt Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .tcg-post-list .text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'image_settings',
			[
				'label' => __('Post Image Setting', 'themescamp-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'vh', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__('Border Radius', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_Padding',
			[
				'label' => esc_html__('Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_img',
				'label' => esc_html__( 'Box Shadow', 'plugin-name' ),
				'selector' => '{{WRAPPER}} .tcg-post-list .img',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'content_settings',
			[
				'label' => __('Post Content Setting', 'themescamp-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'themescamp-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'vw', '%' ],
				'range' => [
					'px' => [
						'min' => 310,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .info ' => 'width: {{SIZE}}{{UNIT}} !important; max-width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => esc_html__( 'Text Alignment', 'themescamp-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'themescamp-core' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'themescamp-core' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'themescamp-core' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'themescamp-core' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .info .cont' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .info' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .info' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'post_content_background',
				'label' => __('Background', 'themescamp-core'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .info',
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'cont_border',
				'selector' => '{{WRAPPER}} .info',
			]
		);


		$this->add_responsive_control(
			'content_border_radius',
			[
				'label' => esc_html__('Border Radius', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				// 'condition' => [
				// 	'overlayed_image_content' => 'with'
				// ]
			]
		);

		$this->add_control(
			'separator_border',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_responsive_control(
			'info_padding',
			[
				'label' => esc_html__('Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_margins',
			[
				'label' => __('Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .info' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label' => esc_html__('Posted By Color', 'themescamp-core'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .separator' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'separator_typography',
				'selector' => '{{WRAPPER}} .tcg-post-list .separator',
			]
		);

		$this->add_responsive_control(
			'separator_padding',
			[
				'label' => __('Separator Padding', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .separator' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->add_responsive_control(
			'_separator_margin',
			[
				'label' => esc_html__('Separator Margin', 'themescamp-core'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'rem'],
				'selectors' => [
					'{{WRAPPER}} .tcg-post-list .separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings();

		$row_view = 'row_view' == $settings['posts_view'] ? 'col-lg-' . $settings['columns_number'] : '';
		$before_dot = 'yes' == $settings['before_dot'] ? ' before_dot' : '';
		$column_view = 'column_view' == $settings['posts_view'] ? 'col-lg-12' : '';
		$category_date = 'yes' == $settings['category_date'] ? true : false;
		if ($settings['paged_on']  != 'yes') {
			$tcg_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		} else {
			$tcg_paged = '';
		}
		if ($settings['sort_cat']  == 'yes' || $settings['sort_tag']  == 'yes') {
			$query_args = array(
				'posts_per_page'   => $settings['posts_to_show'],
				'paged' => $tcg_paged,
				'post_type' => 'post',
				'cat' => $settings['blog_cat'],
				'tag' => $settings['blog_tag'],
				'order' => $settings['order'],
			);
		} else {
			$query_args = array(
				'posts_per_page'   => $settings['posts_to_show'],
				'paged' => $tcg_paged,
				'post_type' => 'post',
				'order' => $settings['order'],
			);
		}

		if ($settings['date_type'] == 'show_date_ago') {
			$date = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago';
		} elseif ($settings['date_type'] == 'show_date_time') {
			$date = get_the_date(__('j M Y'));
		} else {
			$date = get_the_date(__('M j, Y'));
		}



	    // Add author to the query if available - for ThemeBuilder-Archive
	    $author = get_user_by('slug', get_query_var('author_name'));
	    $author_id = null;
        if ( is_author() && $author ) { $author_id = $author->ID; } 
        if ($author_id) { $query_args['author__in'] = $author_id;}


		// Get the category from the query variable (e.g., category_name) - for ThemeBuilder-Archive
		$category_slug = get_query_var('category_name');
		$category_id = null;
		if ($category_slug) {
		    $category = get_category_by_slug($category_slug);
		    if ($category) {
		        $category_id = $category->term_id;
		    }
		}
		// Add the category ID to the query arguments if it exists
		if ($category_id) {
		    $query_args['cat'] = $category_id;
		}

		// Get the tag from the query variable (e.g., tag)
		$tag_slug = get_query_var('tag');
		$tag_id = null;
		if ($tag_slug) {
		    $tag = get_term_by('slug', $tag_slug, 'post_tag');
		    if ($tag) {
		        $tag_id = $tag->term_id;
		    }
		}
		// Add the tag ID to the query arguments if it exists - for ThemeBuilder-Archive
		if ($tag_id) {
		    $query_args['tag_id'] = $tag_id;
		}

		// Get the date parameters (year, month, day) - for ThemeBuilder-Archive
		$year  = get_query_var('year');
		$month = get_query_var('monthnum');
		$day   = get_query_var('day');
		// Add date parameters to the query arguments if they exist
		if ($year) {
		    $query_args['year'] = $year;
		}
		if ($month) {
		    $query_args['monthnum'] = $month;
		}
		if ($day) {
		    $query_args['day'] = $day;
		}

        $query = new \WP_Query($query_args);

?>
<section class="tcg-post-list <?php echo $settings['masonry'] ?>">
    <div class="row gx-lg-5">

        <?php 
        while ($query->have_posts()) : $query->the_post();
					global $post;
					// get video button url
					$video_button = '';
					foreach(parse_blocks($post->post_content) as $block):
						if($block['blockName'] == 'core/embed'):
							$video_button = esc_url($block['attrs']['url']);
							break;
						elseif(preg_match('(.mp4|youtube.com/watch|vimeo.com/|dailymotion.com/video/)', $block['innerHTML']) === 1):
							preg_match_all('!https?://\S+!', $block['innerHTML'], $matches);
							$content_urls = $matches[0];
							$video_url = '';

							foreach($content_urls as $content_url){
								if(preg_match('(.mp4|youtube.com/watch|vimeo.com/|dailymotion.com/video/)', $content_url) === 1) {
									$video_url = $content_url;
									if(str_contains($video_url, '<')){
										$video_url = substr($video_url, 0, strpos($video_url, "<"));
									}
								}
							}
							
							$video_button = $video_url;
						endif;
					endforeach; ?>
        <div class="grid-item <?php echo esc_attr($row_view) . ' ' . esc_attr($column_view) ?> card_container">
            <div
                class="blog-card <?php if($settings['separator'] == 'yes'){echo 'separator';} ?> <?php if($settings['display'] == 'row'){echo 'display_row';} ?>">
                <?php if($settings['show_image'] == 'yes') : ?>
                <div class="img img-cover">
                    <?php if(!$category_date) : ?>
                    <?php if ($settings['show_main_cat'] == 'yes') : ?>
                    <div class="tags">
                        <?php the_category(' '); ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <img src="<?php esc_url(the_post_thumbnail_url()); ?>" alt="post-image">
                    <?php if(!empty($video_button)): ?>
                    <a href="<?php echo esc_url($video_button); ?>" class="vid-btn icon-60" data-lity>
                        <i class="ion-arrow-right-b"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <?php else : ?>
                <div class="post-info">
                    <?php if ($settings['show_main_cat'] == 'yes') : ?>
                    <div>
                        <div class="tags">
                            <?php the_category(' '); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($settings['separator'] == 'yes'){echo __('|', 'themescamp-core');} ?>
                    <div>
                        <?php if ($settings['date'] == 'yes') : ?><a class="date"
                            href="<?php echo esc_url(get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'))); ?>">
                            <?php if($settings['before_date_icon'] == 'yes') : ?>
                            <i class="far fa-calendar-alt"></i>
                            <?php endif; ?>
                            <?php
						if ($settings['date_type'] == 'show_date_ago') {
							$date = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago';
						} elseif ($settings['date_type'] == 'show_date_time') {
							$date = get_the_date(__('j M Y'));
						} elseif ($settings['date_type'] == 'month_day_year') {
							$date = get_the_date(__('F j, Y'));
						} else {
							$date = get_the_date(__('M j, Y'));
						}
						echo $date; ?></a>
						<?php if($settings['separator_type'] == 'text' && $settings['category_date'] == 'yes') {
									echo '<span class="separator">' .$settings['text_separator'] . '</span>';
								} elseif($settings['image_separator'] && $settings['category_date'] == 'yes') {
									echo '<span class="icon mx-3"><img class="icon-10" src="' . $settings['image_separator']['url'] . '" /></span>';
								}
							?>
						<?php endif; ?>
                        <?php if ('yes' == $settings['author']) : ?><span
                            class="posted-by"><?php echo wp_kses_post($settings['posted_by_text'], 'themescamp-core') ?></span>
                        <span class="author-name"><?php the_author_posts_link(); ?></span><?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="info <?php if($column_view) { echo esc_attr('mt-10'); } ?>">
                    <?php if($category_date) : ?>
                    <div class="category-date <?php echo esc_attr($before_dot); ?>">
                        <div class="tags">
                            <?php the_category(' '); ?>
                            <?php if($settings['separator_type'] == 'text' && $settings['category_date'] == 'yes') {
									echo '<span class="separator">' .$settings['text_separator'] . '</span>';
								} elseif($settings['image_separator'] && $settings['category_date'] == 'yes') {
									echo '<span class="icon mx-3"><img class="icon-10" src="' . $settings['image_separator']['url'] . '" /></span>';
								}
							?>
                        </div>
                        <a class="date"
                            href="<?php echo esc_url(get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'))); ?>">
                            <?php if($settings['before_date_icon'] == 'yes') : ?>
                            <i class="far fa-calendar-alt"></i>
                            <?php endif; ?>
                            <?php
						if ($settings['date_type'] == 'show_date_ago') {
							$date = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago';
						} elseif ($settings['date_type'] == 'show_date_time') {
							$date = get_the_date(__('j M Y'));
						} elseif ($settings['date_type'] == 'month_day_year') {
							$date = get_the_date(__('F j, Y'));
						} else {
							$date = get_the_date(__('M j, Y'));
						}
						echo $date; ?></a>
                    </div>
                    <?php endif; ?>
                    <?php if(!$category_date && $settings['author_date_pos'] == 'top') : ?>
                    <?php if($settings['show_image'] == 'yes') : ?>
                    <div class="btm-inf fsz-12 color-000 text-uppercase">
                        <?php if ($settings['date'] == 'yes') : ?><a class="date"
                            href="<?php echo esc_url(get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'))); ?>">
                            <?php if($settings['before_date_icon'] == 'yes') : ?>
                            <i class="far fa-calendar-alt"></i>
                            <?php endif; ?>
                            <?php
						if ($settings['date_type'] == 'show_date_ago') {
							$date = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago';
						} elseif ($settings['date_type'] == 'show_date_time') {
							$date = get_the_date(__('j M Y'));
						} elseif ($settings['date_type'] == 'month_day_year') {
							$date = get_the_date(__('F j, Y'));
						} else {
							$date = get_the_date(__('M j, Y'));
						}
						echo $date; ?></a><?php endif; ?>
                        <?php if($settings['separator_type'] == 'text' && $settings['category_date'] == 'yes') {
								echo '<span class="separator">' .$settings['text_separator'] . '</span>';
							} elseif($settings['image_separator'] && $settings['category_date'] == 'yes') {
								echo '<span class="icon mx-3"><img class="icon-10" src="' . $settings['image_separator']['url'] . '" /></span>';
							}
						?>
                        <?php if ('yes' == $settings['author']) : ?><span
                            class="posted-by"><?php echo wp_kses_post($settings['posted_by_text'], 'themescamp-core') ?></span>
                        <span class="author-name"><?php the_author_posts_link(); ?></span><?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($settings['show_title'] == 'yes' && $settings['title_pos'] == 'top') : ?> <a href="<?php esc_url(the_permalink()); ?>"
                        class="blog-card-title"><?php the_title(); ?></a> <?php endif; ?>
                    <?php if ($settings['show_excerpt'] == 'yes') : ?>
                    <div class="text">
                        <?php $excerpt = get_the_excerpt();
										$excerpt = substr($excerpt, 0, $settings['excerpt']);
										echo $excerpt;
										echo esc_attr($settings['excerpt_after']) ?>
                    </div>
                    <?php endif; ?>
                    <?php if(!$category_date && $settings['author_date_pos'] == 'down') : ?>
                    <?php if($settings['show_image'] == 'yes') : ?>
                    <div class="btm-inf mb-15 fsz-12 color-000 text-uppercase mt-30">
                        <?php if ($settings['date'] == 'yes') : ?><a class="date"
                            href="<?php echo esc_url(get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j'))); ?>">
                            <?php if($settings['before_date_icon'] == 'yes') : ?>
                            <i class="far fa-calendar-alt"></i>
                            <?php endif; ?>
                            <?php
						if ($settings['date_type'] == 'show_date_ago') {
							$date = human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago';
						} elseif ($settings['date_type'] == 'show_date_time') {
							$date = get_the_date(__('j M Y'));
						} elseif ($settings['date_type'] == 'month_day_year') {
							$date = get_the_date(__('F j, Y'));
						} else {
							$date = get_the_date(__('M j, Y'));
						}
						echo $date; ?></a><?php endif; ?>
                        <?php if($settings['separator_type'] == 'text' && $settings['category_date'] == 'yes') {
								echo '<span class="separator">' .$settings['text_separator'] . '</span>';
							} elseif($settings['image_separator'] && $settings['category_date'] == 'yes') {
								echo '<span class="icon mx-3"><img class="icon-10" src="' . $settings['image_separator']['url'] . '" /></span>';
							}
						?>
						
                        <?php if ('yes' == $settings['author']) : ?>
							<span class="posted-by"><?php echo esc_html($settings['posted_by_text'], 'themescamp-core') ?></span>
                        	<span class="author-name"><?php the_author_posts_link(); ?></span>
						<?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
					<?php if($settings['show_title'] == 'yes' && $settings['title_pos'] == 'down') : ?> <a href="<?php esc_url(the_permalink()); ?>"
                        class="blog-card-title"><?php the_title(); ?></a> <?php endif; ?>
                    <?php if($settings['author'] == 'yes' && $settings['category_date'] =='yes') :  ?>
						<?php if($settings['author_style'] == 'style1') : ?>
							<div class="row mt-30 align-items-center">
								<div class="col-10">
									<div class="author d-flex align-items-center">
										<div class="icon-50 rounded-circle overflow-hidden img-cover me-20 flex-shrink-0">
											<img src="<?php echo esc_url(get_avatar_url($post->post_author)) ?>" alt="">
										</div>
										<div class="inf">
											<h6 class="text-uppercase mb-1 posted-by">
												<?php echo __($settings['posted_by_text'], 'themescamp-core'); ?>
											</h6>
											<h4 class="author-name text-capitalize fw-bold"><?php the_author_posts_link(); ?>
											</h4>
										</div>
									</div>
								</div>
								<div class="col-2 text-lg-end">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="" class="d-none" id="flexCheckDefault">
										<label class="form-check-label" for="flexCheckDefault">
											<i class="far fa-heart"></i>
										</label>
									</div>
								</div>
							</div>
						<?php elseif($settings['author_style'] == 'style2') : ?>
							<a href="#" class="author2 d-flex align-items-center mt-20">
								<div class="icon img-cover icon-30 rounded-circle overflow-hidden me-3 flex-shrink-0">
									<img src="<?php echo esc_url(get_avatar_url($post->post_author)) ?>" alt="">
								</div>
								<div class="inf color-999">
									<p> <span class="posted-by"><?php echo __($settings['posted_by_text'], 'themescamp-core'); ?></span><span class="author-name"><?php the_author_posts_link(); ?></span> </p>
								</div>
							</a>
                    	<?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if($settings['read_more'] == 'yes'): ?>
                <a href="<?php the_permalink(); ?>" class="more-btn"> Read More </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
</section>
<?php
	}

	protected function content_template()
	{
	}
}