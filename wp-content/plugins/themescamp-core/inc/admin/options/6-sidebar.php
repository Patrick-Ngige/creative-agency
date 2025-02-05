<?php
/**
 * Extras Tab For Theme Option.
 *
 * @package tcg
 */
Redux::setSection($tcg_pre, array(
	'title' => esc_html__('Sidebar', 'themescamp-core'),
	'id' => 'sidebar-option',
	'icon' => 'el el-pause',
));

Redux::setSection($tcg_pre, array(
	'title'  => esc_html__( 'Sidebar Settings', 'themescamp-core' ),
	"subsection" => false,
	'icon' => 'el el-pause',
	'desc' => esc_html__('Note: each Style can be additionally customized within the chiled theme.', 'themescamp-core'),

	'fields' => array(

		array(
			'id' => 'style_sidebar-start',
			'type' => 'section',
			'title' => esc_html__('Style', 'themescamp-core'),
			'indent' => true,
		),

		array(
            'id' => 'tcg_sidebar_layout',
            'type' => 'button_set',
            'title' => esc_html__('Default Sidebar Layout', 'themescamp-core'),
			'subtitle' => esc_html__('Select the style for Sidebar', 'themescamp-core'),
            'options' => [
                '1' => esc_html__('Clean Style', 'themescamp-core'),
                '2' => esc_html__('Boundary Style', 'themescamp-core'),
                '3' => esc_html__('Elegant Style', 'themescamp-core'),
            ],
            'default' => '1'
		),

		array(
			'id' => 'style_sidebar-end',
			'type' => 'section',
			'indent' => false,
		),


		array(
			'id' => 'blog_single_sidebar-start',
			'type' => 'section',
			'title' => esc_html__('Layout', 'themescamp-core'),
			'indent' => true,
		),

		array(
			'id' => 'tcg_single_sidebar_layout',
			'type' => 'button_set',
			'title' => esc_html__('Post Sidebar Layout', 'themescamp-core'),
			'options' => [
				'left' => esc_html__('Left', 'themescamp-core'),
                'none' => esc_html__('None', 'themescamp-core'),
                'right' => esc_html__('Right', 'themescamp-core'),
			],
			'default' => 'right'
		),

		array(
			'id' => 'blog_sidebar_layout',
			'type' => 'image_select',
			'title' => esc_html__('Blog Sidebar Layout', 'themescamp-core'),
			'options' => [

				'left' => [
					'alt' => 'Left',
					'img' => get_template_directory_uri() . '/assets/images/2cl.png'
				],
				'none' => [
					'alt' => 'None',
					'img' => get_template_directory_uri() . '/assets/images/1co.png'
				],
				'right' => [
					'alt' => 'Right',
					'img' => get_template_directory_uri() . '/assets/images/2cr.png'
				]
			],
			'default' => 'right'
		),

		array(
			'id' => 'search_sidebar_layout',
			'type' => 'image_select',
			'title' => esc_html__('Search Sidebar Layout', 'themescamp-core'),
			'options' => [

				'left' => [
					'alt' => 'Left',
					'img' => get_template_directory_uri() . '/assets/images/2cl.png'
				],
				'none' => [
					'alt' => 'None',
					'img' => get_template_directory_uri() . '/assets/images/1co.png'
				],
				'right' => [
					'alt' => 'Right',
					'img' => get_template_directory_uri() . '/assets/images/2cr.png'
				]
			],
			'default' => 'right'
		),

		array(
			'id' => 'blog_single_sidebar-end',
			'type' => 'section',
			'indent' => false,
		)
	),

));

?>