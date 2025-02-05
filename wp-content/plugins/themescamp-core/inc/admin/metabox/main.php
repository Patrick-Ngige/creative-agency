<?php
/**
 * Main Metabox. 
 *
 * @package tcg
 */



// Initialize sections array
$sections = array();

// Check if 'dark_light_support' option is true
if (get_option('dark_light_support')) {
    $sections[] = array(
        'title'  => esc_html__( 'General', 'themescamp-core' ),
        'id'     => 'opt-general-options',
        'desc'   => esc_html__('Choose an option OR click "x" to revert to the global settings from Theme Options.', 'themescamp-core'),
        'fields' => array(
            array(
                'id'       => 'tcg_theme_mode',
                'type'     => 'select',
                'title'    => esc_html__('Webpage Dark/Light Mode', 'themescamp-core'),
                'options' => array(
                      'light_mode' => esc_html__( 'Light', 'themescamp-core' ),
                      'auto_mode' => esc_html__( 'Auto','themescamp-core'),
                      'dark_mode' => esc_html__( 'Dark', 'themescamp-core' )
                ),
                'default' => '',
            ),
            array(
                'id'    => 'tcg_mode_switcher',
                'type'  => 'select',
                'title'    => esc_html__('Color mode switcher', 'themescamp-core'),
                'options' => array(
                      'on' => esc_html__( 'On', 'themescamp-core' ),
                      'off' => esc_html__( 'Off','themescamp-core'),
                ),
                'default' => '',
            ),

        ),
    );
}

$sections[] = array(
	'title'  => esc_html__( 'Header', 'themescamp-core' ),
	'id'     => 'opt-header-options',
	'desc'    => esc_html__('The default settings are derived from the ', 'themescamp-core'). '<a href="' . esc_url( admin_url( 'admin.php?page=tcg_theme_settings' ) ) . '">' . esc_html__( 'Theme options', 'themescamp-core' ) . '</a>'.esc_html__(', While if wish to use customization, please use the   ', 'themescamp-core').'<a href="' . esc_url( admin_url( 'edit.php?post_type=tcg_teb' ) ) . '">' . esc_html__( 'Custom builder.', 'themescamp-core' ) . '</a>',
	// 'icon'   => 'el-icon-cogs',
	'fields' => array(
		array(
			'id'       => 'tcg_header_set',
			'type'     => 'button_set',
			'title'    => esc_html__('Header type', 'themescamp-core'),
			'options' => array(
				'' => esc_html__('Theme options', 'themescamp-core'),
				'custom_header' => esc_html__('Use Custom Header', 'themescamp-core'),
				'no_header' => esc_html__('No Header', 'themescamp-core'),
			),
			'default' => '',
		),

		array(
			'id'    => 'tcg_header_position',
			'type'  => 'select',
			'title'    => esc_html__('Header Position/Format', 'themescamp-core'),
			'options' => array(
				'head_white' => esc_html__( 'Relative Position with Background, ', 'themescamp-core' ),
				'head_trans' => esc_html__( 'Absolute Position, Transperant','themescamp-core'),
			),
			'default' => '',
		),
	),
);

$sections[] = array(
	'title'  => esc_html__( 'Footer', 'themescamp-core' ),
	'id'     => 'opt-footer-options',
	'desc'    => esc_html__('The default settings are derived from the ', 'themescamp-core'). '<a href="' . esc_url( admin_url( 'admin.php?page=tcg_theme_settings' ) ) . '">' . esc_html__( 'Theme options', 'themescamp-core' ) . '</a>'.esc_html__(', While if wish to use customization, please use the   ', 'themescamp-core').'<a href="' . esc_url( admin_url( 'edit.php?post_type=tcg_teb' ) ) . '">' . esc_html__( 'Custom builder.', 'themescamp-core' ) . '</a>',
	// 'icon'   => 'el-icon-cogs',
	'fields' => array(
		array(
			'id'       => 'tcg_footer_set',
			'type'     => 'button_set',
			'title'    => esc_html__('Footer type', 'themescamp-core'),
			
			'options' => array(
				'' => esc_html__('Theme options', 'themescamp-core'),
				'custom_footer' => esc_html__('Use Custom Footer', 'themescamp-core'),
				'no_footer' => esc_html__('No Footer', 'themescamp-core'),
			),
			'default' => '',
		),
				
	)
);


// Now use the sections array in your Redux_Metaboxes::set_box call
Redux_Metaboxes::set_box($tcg_pre, array(
    'id'         => 'opt-main-metaboxes',
    'title'      => esc_html__( 'Main Options', 'themescamp-core' ),
    'post_types' => array( 'page', 'post', 'portfolio' ),
    'position'   => 'normal', // normal, advanced, side.
    'priority'   => 'high',   // high, core, default, low.
    'sections'   => $sections
));



?>