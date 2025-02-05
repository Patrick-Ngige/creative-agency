<?php
/**
 * Post Metabox.
 *
 * @package tcg
 */

// Standard metabox. 
Redux_Metaboxes::set_box($tcg_pre,array(
		'id'         => 'opt-post-metaboxes',
		'title'      => esc_html__( 'Post Options', 'themescamp-core' ),
		'post_types' => array('post'),
		'position'   => 'normal', // normal, advanced, side.
		'priority'   => 'high',   // high, core, default, low.
		'sections'   => array(

			array(
				'title'  => esc_html__( 'Post Content', 'themescamp-core' ),
				'id'     => 'opt-post-content-options',
				'desc'    => esc_html__('Choose an option OR click "x" to revert to the global settings from Theme Options.', 'themescamp-core'),
				'icon'   => 'el-icon-cogs',
				'fields' => array(
					array(
						'id'       => 'tcg_single_type_layout', 
						'type'     => 'select',
						'title'    => esc_html__('Post Image', 'themescamp-core'),
						'options' => array(
							//'global' => esc_html__( 'Global', 'themescamp-core' ),
							'1' => esc_html__( 'Elegant', 'themescamp-core' ),
							'2' => esc_html__( 'Classic', 'themescamp-core' ),
							'3' => esc_html__( 'Overlay Image', 'themescamp-core' ),
						),
						//'default'     => 'global',
		
					),
				),
			),
			array(
				'title'  => esc_html__( 'Post Sidebar', 'themescamp-core' ),
				'id'     => 'opt-post-sidebar-options',
				'desc'    => esc_html__('Choose an option OR click "x" to revert to the global settings from Theme Options.', 'themescamp-core'),
				'icon'   => 'el-icon-cogs',
				'fields' => array(

					array(
						'id'       => 'tcg_sidebar_layout',
						'type'     => 'select',
						'title'    => esc_html__('Post Sidebar Layout', 'themescamp-core'),
						'options' => array(
							'1' => esc_html__( 'Clean Style', 'themescamp-core' ),
							'2' => esc_html__( 'Boundary Style', 'themescamp-core' ),
							'3' => esc_html__( 'Elegant Style', 'themescamp-core' ),
						),
						'default'     => '',
					),
					array(
						'id'       => 'tcg_single_sidebar_layout',
						'type'     => 'select',
						'title'    => esc_html__('Post Sidebar Position', 'themescamp-core'),
						'options' => array(
							'left' => esc_html__( 'Left', 'themescamp-core' ),
							'none' => esc_html__( 'None', 'themescamp-core' ),
							'right' => esc_html__( 'Right', 'themescamp-core' ),
						),
						'default'     => '',
					),

				),
			),


		),
	)
);







?>