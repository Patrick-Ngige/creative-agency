<?php
/**
 * Post Metabox.
 *
 * @package tcg 
 */


// Standard metabox.
Redux_Metaboxes::set_box($tcg_pre,array(
		'id'         => 'opt-themescamp-post-metaboxes',
		'title'      => esc_html__( 'Custom Template Options', 'themescamp-core' ),
		'post_types' => array('tcg_teb'),
		'position'   => 'normal', // normal, advanced, side.
		'priority'   => 'high',   // high, core, default, low.
		'full_width'  => true,
		'sections'   => array(

			array(
				'title'  => esc_html__( 'TEMPLATE TYPE', 'themescamp-core' ),
				'id'     => 'tcg_tb_settings',
				'full_width'  => true,
				'desc'    => esc_html__('This Rules here override meta options of page/post, ', 'themescamp-core'). '<a href="' . esc_url( admin_url( 'admin.php?page=tcg_theme_settings' ) ) . '">' . esc_html__( 'Theme options', 'themescamp-core' ) . '</a>'.esc_html__(' as well   ', 'themescamp-core'),
				'fields' => array(

					array(
						'id'       => 'template_type', 
						'type'     => 'select',
						'title'    => esc_html__('Template type', 'themescamp-core'),
						'options' => array(
							'header' => esc_html__( 'Header', 'themescamp-core' ),
							'footer' => esc_html__( 'Footer', 'themescamp-core' ),
							'megamenu' => esc_html__( 'Mega Menu', 'themescamp-core' ),
							'block' => esc_html__( 'Block', 'themescamp-core' ),
							'popup' => esc_html__( 'Popup', 'themescamp-core' ),
							'offcanvas' => esc_html__( 'Offcanvas', 'themescamp-core' ),
							'single' => esc_html__( 'Single', 'themescamp-core' ),
							'archive' => esc_html__( 'Archive', 'themescamp-core' ),
						),
						'default'     => '',
						'class'       => 'tcg-template-type', // Add a class to target this field with JavaScript

		
					),


					array(
						'id'          => 'tcg_popup_width',
                        'type'       => 'select',
                        'title'      => esc_html__( 'Popup Width', 'themescamp-core' ),
                        'subtitle'   => esc_html__( 'Select or type a value (PX)', 'themescamp-core' ),
                        'options'    => [
                            'full'   => esc_html__( 'Full', 'themescamp-core' ),
                            'custom' => esc_html__( 'Custom', 'themescamp-core' ),
                        ],
                        'default'    => 'custom',
                        'required' => ['template_type', '=', 'popup'],
					),

					array(
                        'id'         => 'tcg_set_popup_width',
                        'type'       => 'dimensions',
                        'title'      => esc_html__( 'Popup Width', 'themescamp-core' ),
                        'height'     => false,
                        'units'    => array('em','px','%'),
                        'default' => ['width' => 860],
                        'required' => ['tcg_popup_width', '=', 'custom'],

					),


					array(
                        'id'         => 'tcg_set_offcanvas_width',
                        'type'       => 'dimensions',
                        'title'      => esc_html__( 'Offcanvas Width', 'themescamp-core' ),
                        'height'     => false,
                        'units'    => array('em','px','%'),
                        'default' => ['width' => 430],
                        'required' => ['template_type', '=', 'offcanvas'],

					),

					array(
						'id'          => 'tcg_tb_select',
						'type'        => 'repeater',
						'title'       => esc_html__( 'Display rules:', 'your-textdomain-here' ),
						'full_width'  => true,
						'subtitle'    => esc_html__( 'Select the locations where this item should be visible.', 'your-textdomain-here' ),
						'item_name'   => '',
						'sortable'    => true,
						'active'      => false,
						//'group_values' => true,
						'collapsible' => false,
						'required' => array(['template_type', '!=', 'megamenu'],['template_type', '!=', 'offcanvas'],['template_type', '!=', 'block']),

						'fields'      => array(

							array(
								'id'       => 'tcg_tb_include',
								'type'     => 'select',
								'title'    => esc_html__('Display on', 'themescamp-core'),
								'options' => array(
                                'entire_website'     => esc_html__( 'Entire Website', 'themescamp-core' ),
                                'all_pages'          => esc_html__( 'All Pages', 'themescamp-core' ),
                                'front_page'         => esc_html__( 'Front Page', 'themescamp-core' ),
                                'post_page'          => esc_html__( 'Post Page', 'themescamp-core' ),
                                'post_details'       => esc_html__( 'Post Details', 'themescamp-core' ),
                                'all_archive'        => esc_html__( 'All Archive', 'themescamp-core' ),
                                'date_archive'       => esc_html__( 'Date Archive', 'themescamp-core' ),
                                'author_archive'     => esc_html__( 'Author Archive', 'themescamp-core' ),
                                'portfolio_archive'  => esc_html__( 'Portfolio Archive', 'themescamp-core' ),
                                'all_portfolios'     => esc_html__( 'All Portfolios', 'themescamp-core' ),
                                'search_page'        => esc_html__( 'Search Page', 'themescamp-core' ),
                                '404_page'           => esc_html__( '404 Page', 'themescamp-core' ),
                                'specific_pages'     => esc_html__( 'Specific Pages', 'themescamp-core' ),
                                'specific_posts'     => esc_html__( 'Specific Posts', 'themescamp-core' ),
                                'specific_portfolios'     => esc_html__( 'Specific Portfolios', 'themescamp-core' ),
								),
								'class' => 'tcg-display-on-select' // Add a class to target this select field
							),

							array(
									'id'       => 'pages_ids_include',
									'type'     => 'select',
									'data'     => 'pages',
								    'args' => array(
								        'posts_per_page' => -1
								    ),
									'multi'    => true,
									'title'    => esc_html__( 'Pages Multi Select Option', 'themescamp-core' ),
									'desc'     => esc_html__( 'This is the description field, again good for additional info.', 'themescamp-core' ),
									'default'=>'',
									'required' => ['tcg_tb_include', '=', 'specific_pages'],
								),

								array(
									'id'       => 'posts_ids_include',
									'type'     => 'select',
									'data'     => 'post',
								    'args' => array(
								        'posts_per_page' => -1
								    ),
									'multi'    => true,
									'title'    => esc_html__( 'Posts Multi Select Option', 'themescamp-core' ),
									'desc'     => esc_html__( 'This is the description field, again good for additional info.', 'themescamp-core' ),
									'required' => ['tcg_tb_include', '=', 'specific_posts'],
								),
								array(
									'id'       => 'portfolios_ids_include',
									'type'     => 'select',
							    	'data' => 'posts',
								    'args' => array(
								        'post_type' => 'portfolio',
								        'posts_per_page' => -1
								    ),
									'multi'    => true,
									'title'    => esc_html__( 'Portfolios Multi Select Option', 'themescamp-core' ),
									'desc'     => esc_html__( 'This is the description field, again good for additional info.', 'themescamp-core' ),
									'required' => ['tcg_tb_include', '=', 'specific_portfolios'],
								),


						),
					),

					array(
						'id'          => 'tcg_tb_hide',
						'type'        => 'repeater',
						'title'       => esc_html__( 'Exclusion rules:', 'your-textdomain-here' ),
						'full_width'  => true,
						'subtitle'    => esc_html__( 'Select the locations where this item should not be visible.', 'your-textdomain-here' ),
						'item_name'   => '',
						'sortable'    => true,
						'active'      => false,
						'collapsible' => true,
						//'group_values' => true,
						'required' => array(['template_type', '!=', 'megamenu'],['template_type', '!=', 'offcanvas'],['template_type', '!=', 'block']),
						'fields'      => array(

							array(
								'id'       => 'tcg_tb_exclude',
								'type'     => 'select',
								'title'    => esc_html__('Hide on', 'themescamp-core'),
								'options' => array(
	                                'entire_website'     => esc_html__( 'Entire Website', 'themescamp-core' ),
	                                'all_pages'          => esc_html__( 'All Pages', 'themescamp-core' ),
	                                'front_page'         => esc_html__( 'Front Page', 'themescamp-core' ),
	                                'post_page'          => esc_html__( 'Post Page', 'themescamp-core' ),
	                                'post_details'       => esc_html__( 'Post Details', 'themescamp-core' ),
	                                'all_archive'        => esc_html__( 'All Archive', 'themescamp-core' ),
	                                'all_portfolios'     => esc_html__( 'All Portfolios', 'themescamp-core' ),
	                                'date_archive'       => esc_html__( 'Date Archive', 'themescamp-core' ),
	                                'author_archive'     => esc_html__( 'Author Archive', 'themescamp-core' ),
									'portfolio_archive'  => esc_html__( 'Portfolio Archive', 'themescamp-core' ),
	                                'all_portfolios'     => esc_html__( 'All Portfolios', 'themescamp-core' ),
	                                'search_page'        => esc_html__( 'Search Page', 'themescamp-core' ),
	                                '404_page'           => esc_html__( '404 Page', 'themescamp-core' ),
	                                'specific_pages'     => esc_html__( 'Specific Pages', 'themescamp-core' ),
	                                'specific_posts'     => esc_html__( 'Specific Posts', 'themescamp-core' ),
	                                'specific_portfolios'     => esc_html__( 'Specific Portfolios', 'themescamp-core' ),
								),
							),

							array(
									'id'       => 'pages_ids_exclude',
									'type'     => 'select',
									'data'     => 'pages',
								    'args' => array(
								        'posts_per_page' => -1
								    ),
									'multi'    => true,
									'title'    => esc_html__( 'Pages Multi Select Option', 'themescamp-core' ),
									'desc'     => esc_html__( 'This is the description field, again good for additional info.', 'themescamp-core' ),
									'required' => ['tcg_tb_exclude', '=', 'specific_pages'],
								),

								array(
									'id'       => 'posts_ids_exclude',
									'type'     => 'select',
									'data'     => 'post',
								    'args' => array(
								        'posts_per_page' => -1
								    ),
									'multi'    => true,
									'title'    => esc_html__( 'Pages Multi Select Option', 'themescamp-core' ),
									'desc'     => esc_html__( 'This is the description field, again good for additional info.', 'themescamp-core' ),
									'required' => ['tcg_tb_exclude', '=', 'specific_posts'],
								),
								array(
									'id'       => 'portfolios_ids_exclude',
									'type'     => 'select',
							    	'data' => 'posts',
								    'args' => array(
								        'post_type' => 'portfolio',
								        'posts_per_page' => -1
								    ),
									'multi'    => true,
									'title'    => esc_html__( 'Portfolios Multi Select Option', 'themescamp-core' ),
									'desc'     => esc_html__( 'This is the description field, again good for additional info.', 'themescamp-core' ),
									'required' => ['tcg_tb_exclude', '=', 'specific_portfolios'],
								),

						),
					),

				),
			),
		),
	)
);







?>