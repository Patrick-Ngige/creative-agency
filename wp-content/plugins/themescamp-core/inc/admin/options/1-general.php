<?php
/**
 * Genaral Tab For Theme Option.
 *
 * @package tcg
 */

Redux::setSection($tcg_pre, array(
	'id' => 'general_top',
	'icon' => 'el el-home',
	'title' => esc_html__('General', 'themescamp-core'),
	'desc' => esc_html__('Welcome to the theme options', 'themescamp-core'),
));

// condition from the Theme function file : define('DARK_LIGHT_SUPPORT', false/true);
if (get_option('dark_light_support')):
	Redux::setSection($tcg_pre, array(
		'id' => 'tcg_mode',
		"subsection" => false,
		'title' => esc_html__('Tcg Mode', 'themescamp-core'),
		'icon' => 'el el-brush',
		'fields' => array(
			array(
				'id'       => 'tcg_theme_mode',
				'type'     => 'button_set',
				'customizer' => true,
				'title'    => esc_html__('Website Dark/Light Mode', 'themescamp-core'),
				'subtitle' => esc_html__('Enable dark color scheme for your website', 'themescamp-core'),
				'desc' => esc_html__('Auto: Mode at the Operating System of each user', 'themescamp-core'),
				'options' => array(
					'light_mode' => esc_html__( 'Light', 'themescamp-core' ),
					'auto_mode' => esc_html__( 'Auto','themescamp-core'),
					'dark_mode' => esc_html__( 'Dark','themescamp-core'),
					),
				'default' => 'light_mode',
			),
  
		),
	));
endif;

Redux::setSection($tcg_pre, array(
	'id' => 'style',
	"subsection" => false,
	'title' => esc_html__('Global Color', 'themescamp-core'),
	'desc' => esc_html__('Configuration the style settings', 'themescamp-core'),
	'icon' => 'fa-solid fa-palette',
	'fields' => array(
		array(
			'id'       => 'tcg_main_color', 
			'type'     => 'color',
			'title'    => esc_html__('Main Color Scheme', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color scheme (default: #501E9C).', 'themescamp-core'),
			'default'  => '#501E9C',
			'validate' => 'color',
		),
		array(
			'id'       => 'tcg_primary_color', 
			'type'     => 'color',
			'title'    => esc_html__('primary Color Scheme', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color scheme (default: #8169F1).', 'themescamp-core'),
			'default'  => '#8169F1',
			'validate' => 'color',
		), 
		array(
			'id'       => 'tcg_secondary_color',
			'type'     => 'color',
			'title'    => esc_html__('Secondary Color Scheme', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color scheme (default: #A44CEE).', 'themescamp-core'),
			'default'  => '#A44CEE',
			'validate' => 'color',
		), 
		array(
			'id'       => 'tcg_ternary_color',
			'type'     => 'color',
			'title'    => esc_html__('Ternary Color Scheme', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color scheme (default: #FF847F).', 'themescamp-core'),
			'default'  => '#FF847F',
			'validate' => 'color',
		), 
		array(
			'id'       => 'tcg_color_scheme',
			'type'     => 'color',
			'title'    => esc_html__('Hyperlink Color', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color for hyperlink. Default color is black #999999', 'themescamp-core'),
			'default'  => '#999999',
			'validate' => 'color',
		), 
		array(
			'id'       => 'tcg_custom_hovers',
			'type'     => 'color',
			'title'    => esc_html__('Hyperlink color on hover state', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color for hover state in hyperlink. Default color is #12c2e9', 'themescamp-core'),
			'default'  => '#12c2e9',
			'validate' => 'color',
		),  
		array(
			'id'       => 'tcg_heading_color',
			'type'     => 'color',
			'title'    => esc_html__('Color on Heading', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color for heading text. Default color is black #000000', 'themescamp-core'),
			'default'  => '#000000',
			'validate' => 'color',
		), 
		array(
			'id'       => 'tcg_general_color',
			'type'     => 'color',
			'title'    => esc_html__('Color on General Paragraph', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color for general paragraph text. Default color is black #666', 'themescamp-core'),
			'default'  => '#666666',
			'validate' => 'color', 
		), 
		array(
			'id'       => 'tcg_stick_menu',
			'type'     => 'color',
			'title'    => esc_html__('Sticky Menu Background color (for menu with black background & All Sticky Custom Menu)', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your background color for sticky menu in white text header. Default color is #fff', 'themescamp-core'),
			'default'  => '#ffffff',
			'validate' => 'color',
		), 
		array(
			'id'       => 'tcg_stick_menu2',
			'type'     => 'color',
			'title'    => esc_html__('Sticky Menu Background color (for menu with white background)', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your background color for sticky menu in white text header. Default color is #ffffff', 'themescamp-core'),
			'default'  => '#ffffff',
			'validate' => 'color',
		), 
		 array(
			'id'       => 'tcg_menu_border',
			'type'     => 'color',
			'title'    => esc_html__('Sticky Menu BBorder color (for menu with transparent background)', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your border color for sticky menu in transparent text header. Default color is #ffffff', 'themescamp-core'),
			'default'  => '#ffffff',
			'validate' => 'color',
		),

		 array(
			'id'       => 'tcg_to_top_color',
			'type'     => 'color',
			'title'    => esc_html__('To top color', 'themescamp-core'), 
			'subtitle' => esc_html__('To top color icon in footer', 'themescamp-core'),
			'validate' => 'color',
		),

		array(
			'id'       => 'tcg_footer_color',
			'type'     => 'color',
			'title'    => esc_html__('Standard Footer Background color', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your background color for standard footer. Default color is black #202020', 'themescamp-core'),
			'default'  => '#13161D',
			'validate' => 'color',
		),
	),
));

Redux::setSection($tcg_pre, array(
	'id' => 'preloader',
	"subsection" => false,
	'title' => esc_html__('Preloader', 'themescamp-core'),
	'desc' => esc_html__('Configuration the style settings', 'themescamp-core'),
	'icon' => 'fa-solid fa-spinner',
	'fields' => array(
		array(
			'id'       => 'tcg_preloader_set',
			'type'     => 'button_set',
			'title'    => esc_html__('Preloader Setting', 'themescamp-core'),
			'options' => array(
					'show_all' => esc_html__('Show in All pages', 'themescamp-core'),
					'show_home' => esc_html__('Show in Home page only', 'themescamp-core'),
					'not_show' => esc_html__('Hide in all pages', 'themescamp-core'),
				),
		),
		array(
			'id'       => 'tcg_preloader_type',
			'type'     => 'button_set',
			'title'    => esc_html__('Preloader Type', 'themescamp-core'),
			'options' => array(
					'circle' => esc_html__('Circle', 'themescamp-core'),
					'progress' => esc_html__('Progress', 'themescamp-core'),
					'text-logo' => esc_html__('Text & Logo', 'themescamp-core'),
				),
			'default'  => 'progress',
		),
		array(
			'id'       => 'tcg_preloader_logo',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__('Preloader Logo', 'themescamp-core'), 
			'subtitle' => esc_html__('Upload your logo for preloader', 'themescamp-core'),
			'required'  => array('tcg_preloader_type', 'equals', 'text-logo'),
		), 
		array(
			'id'       => 'tcg_preloader_text',
			'type'     => 'text',
			'title'    => esc_html__('Preloader Text', 'themescamp-core'), 
			'subtitle' => esc_html__('Preloader Text Filter for all categories', 'themescamp-core'),
			'desc' => esc_html__('Insert your text for preloader', 'themescamp-core'),
			'default'  => 'WordPress Theme',
			'required'  => array('tcg_preloader_type', 'equals', 'text-logo'),
		),  
		array(
			'id'       => 'tcg_loader_text_color',
			'type'     => 'color',
			'title'    => esc_html__('Text Color', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color scheme (default: #ffffff).', 'themescamp-core'),
			'default'  => '#ffffff',
			'validate' => 'color',
		),   
		array(
			'id'       => 'tcg_loader_color',
			'type'     => 'color',
			'title'    => esc_html__('Color Scheme', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color scheme (default: #12c2e9).', 'themescamp-core'),
			'default'  => '#12c2e9',
			'validate' => 'color',
		),    
		array(
			'id'       => 'tcg_loader_color_2',
			'type'     => 'color',
			'title'    => esc_html__('Color Scheme', 'themescamp-core'), 
			'subtitle' => esc_html__('Pick your color scheme (default: #8169F1).', 'themescamp-core'),
			'default'  => '#8169F1',
			'validate' => 'color',
			'required'  => array('tcg_preloader_type', 'equals', 'text-logo'),
		),     
	),
)); 

Redux::setSection($tcg_pre, array(
	'id' => 'backtotop',
	"subsection" => false,
	'title' => esc_html__('Back to Top', 'themescamp-core'),
	'desc' => esc_html__('Configuration the style settings', 'themescamp-core'),
	'icon' => 'fa-solid fa-angle-up',
	'fields' => array(
		array(
			'id'       => 'tcg_backtotop_set',
			'type'     => 'button_set',
			'title'    => esc_html__('Preloader Setting', 'themescamp-core'),
			'options' => array(
					'show_all' => esc_html__('Show in All pages', 'themescamp-core'),
					'show_home' => esc_html__('Show in Home page only', 'themescamp-core'),
					'not_show' => esc_html__('Hide in all pages', 'themescamp-core'),
				),
                'default'  => 'show_all',
		),
    ),
));
Redux::setSection($tcg_pre, array(
	'id' => 'cursor',
	"subsection" => false,
	'title' => esc_html__('Cursor', 'themescamp-core'),
	'desc' => esc_html__('Select your cursor type', 'themescamp-core'),
	'icon' => 'fa-solid fa-arrow-pointer', 
	'fields' => array(
		array(
			'id'       => 'tcg_cursor_set',
			'type'     => 'button_set',
			'customizer' => true,
			'title'    => esc_html__('Theme Cursor Style', 'themescamp-core'),
			'options' => array(
					'none' => esc_html__('None', 'themescamp-core'),
					'1' => esc_html__('Circle style', 'themescamp-core'),
					'2' => esc_html__('Smoke effect', 'themescamp-core'),
				),
			'default' => 'none',
		),   
        array(
			'id'       => 'tcg_cursor_smoke_type',
			'type'     => 'button_set',
			'customizer' => true,
			'title'    => esc_html__('Smoke Color', 'themescamp-core'),
			'options' => array(
					'auto' => esc_html__('Auto', 'themescamp-core'),
					'dark' => esc_html__('Dark', 'themescamp-core'),
					'light' => esc_html__('Light', 'themescamp-core'),
				),
			'default' => 'auto',
			'required'  => array('tcg_cursor_set', 'equals', '2'),
		),    
	),
));

Redux::setSection($tcg_pre, array(
	"subsection" => false,
	'title'  => esc_html__( 'Typography', 'themescamp-core' ),
	'icon' => 'el el-fontsize',
	'fields' => array(

		array(
			'title' => esc_html__( 'Body', 'themescamp-core' ),
			'subtitle' => esc_html__("Choose Size and Style for Body", 'themescamp-core' ),
			'id' => 'font_body',
			'type' => 'typography',
			'font-backup' => false,
			'letter-spacing' => true,
			'text-transform' => true,
			'all_styles' => true,
			'output' => array( 'body' ),
			'default' => array(
				'font-family' =>'',
				'color' =>"",
				'font-style' =>'',
				'font-size' =>'',
				'line-height' =>''
			),
		),

        array(
            'title' => esc_html__( 'Paragraph', 'themescamp-core' ),
            'subtitle' => esc_html__("Choose Size and Style for paragraph", 'themescamp-core' ),
            'id' => 'font_p',
            'type' => 'typography',
            'font-backup' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'all_styles' => true,
            'output' => array( 'p, body.has-paragraph-style p' ),
            'default' => array(
                'font-family' =>'',
                'color' =>"",
                'font-style' =>'',
                'font-size' =>'',
                'line-height' =>''
            ),
        ),

        array(
            'title' => esc_html__( 'H1 Headings', 'themescamp-core' ),
            'subtitle' => esc_html__("Choose Size and Style for h1", 'themescamp-core' ),
            'id' => 'font_h1',
            'type' => 'typography',
            'font-backup' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'all_styles' => true,
            'output' => array( 'h1' ),
            'default' => array(
                'color' => '',
                'font-style' => '',
                'font-family' => '',
                'google' => true,
                'font-size' => '',
                'line-height' => ''
            ),
        ),
        array(
            'title' => esc_html__( 'H2 Headings', 'themescamp-core' ),
            'subtitle' => esc_html__("Choose Size and Style for h2", 'themescamp-core' ),
            'id' => 'font_h2',
            'type' => 'typography',
            'font-backup' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'all_styles' => true,
            'output' => array( 'h2' ),
            'default' => array(
                'color' => '',
                'font-style' => '',
                'font-family' => '',
                'google' => true,
                'font-size' => '',
                'line-height' => ''
            ),
        ),
        array(
            'title' => esc_html__( 'H3 Headings', 'themescamp-core' ),
            'subtitle' => esc_html__("Choose Size and Style for h3", 'themescamp-core' ),
            'id' => 'font_h3',
            'type' => 'typography',
            'font-backup' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'all_styles' => true,
            'output' => array( 'h3' ),
            'default' => array(
                'color' => '',
                'font-style' => '',
                'font-family' => '',
                'google' => true,
                'font-size' => '',
                'line-height' => ''
            ),
        ),
        array(
            'title' => esc_html__( 'H4 Headings', 'themescamp-core' ),
            'subtitle' => esc_html__("Choose Size and Style for h4", 'themescamp-core' ),
            'id' => 'font_h4',
            'type' => 'typography',
            'font-backup' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'all_styles' => true,
            'output' => array( 'h4' ),
            'default' => array(
                'color' => '',
                'font-style' => '',
                'font-family' => '',
                'google' => true,
                'font-size' => '',
                'line-height' => ''
            ),
        ),
        array(
            'title' => esc_html__( 'H5 Headings', 'themescamp-core' ),
            'subtitle' => esc_html__("Choose Size and Style for h5", 'themescamp-core' ),
            'id' => 'font_h5',
            'type' => 'typography',
            'font-backup' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'all_styles' => true,
            'output' => array( 'h5' ),
            'default' => array(
                'color' => '',
                'font-style' => '',
                'font-family' => '',
                'google' => true,
                'font-size' => '',
                'line-height' => ''
            ),
        ),
        array(
            'title' => esc_html__( 'H6 Headings', 'themescamp-core' ),
            'subtitle' => esc_html__("Choose Size and Style for h6", 'themescamp-core' ),
            'id' => 'font_h6',
            'type' => 'typography',
            'font-backup' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'all_styles' => true,
            'output' => array( 'h6' ),
            'units' => 'px',
            'default' => array(
                'color' => '',
                'font-style' => '',
                'font-family' => '',
                'google' => true,
                'font-size' => '',
                'line-height' => ''
            ),
        ),
		
	),

));

Redux::set_section(
	$tcg_pre,
	array(
		'title'      => __( 'Custom fonts', 'themescamp-core' ),
		"subsection" => false,
		'icon' => 'fa-solid fa-text-height', 
		'fields'     => array(

			array(
				'id'   => 'custom_fonts',
				'type' => 'custom_fonts',
				'convert' => false,
				'title'       => esc_html__( 'List of uploaded Fonts', 'themescamp-core' ),
				'subtitle'    => esc_html__( 'Choose Font file(.woff) or ZIP of font files (if like .ttf).', 'themescamp-core' ),
			),


			array(
				'id'          => 'repeater-field-id',
				'type'        => 'repeater',
				'title'       => esc_html__( 'List of dedicated Fonts for Elementor Builder ', 'themescamp-core' ),
				'full_width'  => true,
				'subtitle'    => esc_html__( 'Elementor custom fonts', 'themescamp-core' ),
				'item_name'   => '',
				'sortable'    => true,
				'active'      => false,
				'collapsible' => false,
				'fields'      => array(

					array(
						'id'          => 'custom_fonts_typography', 
						'type'        => 'typography',
						'title'       => esc_html__( 'Custom Fonts Typography', 'themescamp-core' ),
						'subtitle'    => 'This will modify the font family of the .entry-title classes.',
						'output'      => '.site-title, .widget-title, .entry-title, .wp-block-site-title',
						'font-weight'   => false,
						'font-size'   => false,
						'line-height' => false,
						'text-align'  => false,
						'subsets' => false,
						'color' => false,
						'all_styles' => false,
						'font-style' => false,
					),

				),
			),
		),
	)
);
 
 Redux::setSection($tcg_pre, array(
	'id' => 'tcg_animation',
	//"subsection" => false,
	'title' => esc_html__('Animation', 'themescamp-core'),
	'icon' => 'fa-solid fa-wand-sparkles',
	'fields' => array( 

		array(
			'id'       => 'performance_scroll',
			'type'     => 'switch',
			'customizer' => true,
			'title'    => esc_html__('Smooth Scroll animation.', 'themescamp-core'),
			'desc'    => esc_html__('Turn off to disable Smooth Scroll.', 'themescamp-core'),
			'default' => false,
		),

	)
));

Redux::setSection($tcg_pre, array( 
	'id' => 'dev_tools',
	"subsection" => false,
	'title' => esc_html__('Dev Tools', 'themescamp-core'),
	'icon' => 'fa-regular fa-file-code',
	'fields' => array(

		array(
			'id'       => 'tcg_show_meta',
			'type'     => 'button_set',
			'title'    => esc_html__('Show Post Meta data ', 'themescamp-core'),
			'options' => array(
					'show' => esc_html__('Show', 'themescamp-core'),
					'hide' => esc_html__('Hide', 'themescamp-core'),
				),
			'default'  => 'hide',
		),  
		array(
			'id'       => 'tcg_show_block_edit',
			'type'     => 'button_set',
			'title'    => esc_html__('Show Blocks in "Edit with Elementor" bar ', 'themescamp-core'),
			'options' => array(
					'show' => esc_html__('Show', 'themescamp-core'),
					'hide' => esc_html__('Hide', 'themescamp-core'),
				),
			'default'  => 'hide',
		),

		array(
			'id'       => 'tcg_mode_switcher', 
			'type'     => 'button_set',
			'customizer' => true,
			'title'    => esc_html__('Front mode switcher', 'themescamp-core'),
			'desc' => esc_html__('Enable front mode switcher for your website', 'themescamp-core'),
			'options' => array(
				'on' => esc_html__( 'On', 'themescamp-core' ),
				'off' => esc_html__( 'Off','themescamp-core'),
				),
			'default' => 'off',
		),
		array(
			'id'       => 'tcg_feature_switcher', 
			'type'     => 'button_set',
			'customizer' => true,
			'title'    => esc_html__('Features switcher', 'themescamp-core'),
			'desc' => esc_html__('Enable front mode switcher for your website', 'themescamp-core'),
			'options' => array(
				'on' => esc_html__( 'On', 'themescamp-core' ),
				'off' => esc_html__( 'Off','themescamp-core'),
				),
			'default' => 'off',
		),
		array(
		    'id'          => 'tcg_side_switcher',
		    'type'        => 'repeater',
		    'title'       => esc_html__('List of Features for website', 'themescamp-core'),
		    'full_width'  => false,
		    'item_name'   => '',
		    'sortable'    => true,
		    'active'      => false,
		    'collapsible' => false,
		    'required'  => array('tcg_feature_switcher', 'equals','on'),
		    'fields'      => array(
		        array(
		            'id'       => 'tcg_side_text',
		            'type'     => 'text',
		            'title'    => esc_html__('Features Text', 'themescamp-core'), 
		            'subtitle' => esc_html__('Input features text here', 'themescamp-core'),
		            'default'  => esc_html__('Support', 'themescamp-core'), 
		        ),
		        array(
		            'id'       => 'tcg_side_link',
		            'type'     => 'text',
		            'title'    => esc_html__('Features Link', 'themescamp-core'), 
		            'subtitle' => esc_html__('Input features link here', 'themescamp-core'),
		            'default'  => 'https://themescamp.ticksy.com/',
		        ),
		        array(
		            'id'       => 'tcg_side_img',
		            'type'     => 'media',
		            'url'      => true,
		            'title'    => esc_html__('Icon', 'themescamp-core'), 
		            'subtitle' => esc_html__('Upload your icon (Recommended size 18x18px)', 'themescamp-core'),
		        ),
		    ),
		),
 
		array(
			'id'       => 'tcg_system_opt',
			'desc' => esc_html__('For full saved options, visit: ', 'themescamp-core') . '<a href="' . admin_url('admin.php?page=all-saved-options') . '" target="_blank">Link</a>',
			'type'  => 'info',
			'style' => 'info',
			'customizer' => true,
			'title'    => esc_html__('Showing the system saved options', 'themescamp-core'),
			'default' => false,
		), 

		array(
		    'id'       => 'tcg_usefull_attributes',
		    'desc'     => 
		                  esc_html__('For animation character class, use: ', 'themescamp-core') . '<code>.tc-anim-char</code>' . '<br>' .
		                  esc_html__('For animation line class, use: ', 'themescamp-core') . '<code>.tc-anim-lines</code>' . '<br>' .
                          esc_html__('For animation parallax class, use: ', 'themescamp-core') . '<code>.tc-anim-parallax</code>',
		    'type'     => 'info',
		    'style'    => 'info',
		    'customizer' => true,
		    'title'    => esc_html__('Elementor useful classes', 'themescamp-core'),
		    'default'  => false,
		),


	),
));

?>