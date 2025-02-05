<?php
/**
 * Blog Tab For Theme Option.
 *
 * @package tcg
 */

// -> START Blog Options
Redux::setSection($tcg_pre, array(
        'title' => esc_html__('Blog', 'themescamp-core'),
        'id' => 'blog-option',
        'icon' => 'el-icon-th',
)); 
Redux::setSection($tcg_pre, array(
	'id' => 'blog',
	"subsection" => false,
	'title' => esc_html__('Blog setting', 'themescamp-core'),
	'desc' => esc_html__('Configuration blog settings:', 'themescamp-core'),
    'icon' => 'el-icon-th',
	'fields' => array(

        [
            'id' => 'tcg_blog_article_layout', 
            'type' => 'button_set',
            'title' => esc_html__('Default Blog Article Layout', 'themescamp-core'),
            'desc' => esc_html__('Note: each Style can be additionally customized within the chiled theme.', 'themescamp-core'),
            'options' => [
                '1' => esc_html__('Clean Style', 'themescamp-core'),
                '2' => esc_html__('Boundary Style', 'themescamp-core'),
                '3' => esc_html__('Elegant Style', 'themescamp-core'),
            ],
            'default' => '1'
        ],
        
		array(
			'id'       => 'tcg_related_image', 
			'type'     => 'select',
			'title'    => esc_html__('Featured Image in Related Posts', 'themescamp-core'),
			'options' => array(
					'show' => esc_html__('Show', 'themescamp-core'),
					'hide' => esc_html__('Hide', 'themescamp-core'),
			),
			'default'  => 'hide',
		),

		array( 
			'id'       => 'tcg_blog_slide_delay',
			'type'     => 'slider',
			'title'    => esc_html__('Blog Slider Delay', 'themescamp-core'), 
			'desc' => esc_html__('Insert the slider delay for slider in blog sidebar,blog wide and single blog post here. The default value 8000', 'themescamp-core'),
			'default'  => 8000,
			"min"       => 1,
			"step"      => 1,
			"max"       => 10000,
			'display_value' => 'label'
		), 
		
        array(
			'id'       => 'tcg_blog_button_text',
			'type'     => 'text',
			'title'    => esc_html__('Blog Button text (Continue Reading)', 'themescamp-core'), 
			'default'  => 'Continue Reading',
		),

        [
            'id' => 'blog_article',
            'type' => 'section',
            'title' => esc_html__('Blog Articles', 'themescamp-core'),
            'indent' => true,
        ],

		array(
			'id'       => 'tcg_pagination_loader',
			'type'     => 'button_set',
			'title'    => esc_html__('Pagination type', 'themescamp-core'),
			'options' => array(
					'paged' => esc_html__('Next/Previous', 'themescamp-core'),
					'loader' => esc_html__('Load More', 'themescamp-core'),
			),
			'default'  => 'paged',
		),

		array(
			'id'       => 'tcg_blog_slider',
			'type'     => 'button_set',
			'title'    => esc_html__('Show latest blog slider', 'themescamp-core'),
			'options' => array(
					'show' => esc_html__('Show', 'themescamp-core'),
					'hide' => esc_html__('Hide', 'themescamp-core'),
			),
			'default'  => 'hide',
		),

		array(
			'id'       => 'tcg_blog_slider_title',
			'type'     => 'text',
			'title'    => esc_html__('Blog slider title', 'themescamp-core'), 
			'default'  => 'Our Journal',
			'required' => array( 'tcg_blog_slider', '=', 'show')
		),
		array(
			'id'       => 'tcg_blog_slider_subtitle',
			'type'     => 'text',
			'title'    => esc_html__('Blog slider sub-title', 'themescamp-core'), 
			'default'  => 'Get the latest articles from our journal, writing, discuss and share',
			'required' => array( 'tcg_blog_slider', '=', 'show')
		),

		array(
			'id'       => 'tcg_blog_popular',
			'type'     => 'button_set',
			'title'    => esc_html__('Show Popular blog', 'themescamp-core'),
			'options' => array(
					'show' => esc_html__('Show', 'themescamp-core'),
					'hide' => esc_html__('Hide', 'themescamp-core'),
			),
			'default'  => 'hide',
		),
		array(
			'id'       => 'tcg_blog_popular_title',
			'type'     => 'text',
			'title'    => esc_html__('Blog popular title', 'themescamp-core'), 
			'default'  => 'Popular Posts',
			'required' => array( 'tcg_blog_popular', '=', 'show')
		),

        array(
			'id'       => 'tcg_blog_tags',
			'type'     => 'button_set',
			'customizer' => true,
			'title'    => esc_html__('Blog Tags', 'themescamp-core'),
			'subtitle' => esc_html__('Enable Tags', 'themescamp-core'),
			'options' => array(
				'on' => esc_html__( 'Show', 'themescamp-core' ),
				'off' => esc_html__( 'Hide','themescamp-core'),
				),
			'default' => 'on',
            'required' => array( 'tcg_blog_article_layout', '=', '3' )
		), 
        array(
			'id'       => 'tcg_blog_button',
			'type'     => 'button_set',
			'customizer' => true,
			'title'    => esc_html__('Blog Button (Continue Reading)', 'themescamp-core'),
			'subtitle' => esc_html__('Enable Blog Button (Continue Reading)', 'themescamp-core'),
			'options' => array(
				'on' => esc_html__( 'Show', 'themescamp-core' ),
				'off' => esc_html__( 'Hide','themescamp-core'),
				),
			'default' => 'on',
            'required' => array( 'tcg_blog_article_layout', '=', '3' )
		),
        array(
            'title' => esc_html__( 'Post Excerpt Size (max word count)', 'themescamp-core' ),
            'subtitle' => esc_html__( 'You can control blog post excerpt size with this option.', 'themescamp-core' ),
            'id' => 'excerpt_size',
            'type' => 'slider',
            'default' => 100,
            'min' => 0,
            'step' => 1,
            'max' => 300,
            'display_value' => 'text',
            'required' => array( 'tcg_blog_article_layout', '=', '3' )
        ),
	),

));

?>