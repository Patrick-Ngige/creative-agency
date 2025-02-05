<?php
/**
 * Header Tab For Theme Option. 
 *
 * @package tcg
 */
  // global $post;
  // global $tcg_theme_settings;
  // $slug=themescamp_settings( 'tcg_template_type');
  
Redux::setSection($tcg_pre, array(
	'title'  => esc_html__( 'Header', 'themescamp-core' ),
	'icon' => 'el el-credit-card',
));


Redux::setSection($tcg_pre, array(
	"subsection" => false,
	'title' => esc_html__('Header settings', 'themescamp-core'),
	'desc'    => esc_html__('If wish to use customization, please use the   ', 'themescamp-core').'<a href="' . esc_url( admin_url( 'edit.php?post_type=tcg_teb' ) ) . '">' . esc_html__( 'Custom builder.', 'themescamp-core' ) . '</a>',
	'icon' => 'fa-solid fa-heading',
	'fields' => [
		[
			'id'       => 'tcg_header_set', 
			'type'     => 'button_set',
			'title'    => esc_html__('Header type', 'themescamp-core'),
			'options' => array(
				'standard' => esc_html__('Standard Header', 'themescamp-core'),
				'custom_header' => esc_html__('Custom Header', 'themescamp-core'),
				'no_header' => esc_html__( 'No Header', 'themescamp-core' )
			),
			'default'     => 'standard',
		],  

		[
			'id'       => 'tcg_header_position',
			'type'     => 'select',
			'title'    => esc_html__('Header Position', 'themescamp-core'), 
			'options' => array(
				'head_white' => esc_html__( 'Relative Position with Background, ', 'themescamp-core' ),
				'head_trans' => esc_html__( 'Absolute Position, Transperant','themescamp-core'),
			), 
			'default'  => 'head_white',
			
		],

		[
			'id'       => 'tcg_menu_position',
			'type'     => 'select',
			'title'    => esc_html__('Menu Position', 'themescamp-core'), 
			'options' => array(
				'right' => esc_html__('Right', 'themescamp-core'),
				'center' => esc_html__('Center', 'themescamp-core'),
			), 
			'default'  => 'right',
		],

	]
));

Redux::setSection($tcg_pre, array(
	'id' => 'header_logo',
	"subsection" => false,
	'title' => esc_html__('Header logo', 'themescamp-core'),
	'desc' => esc_html__('Configuration the style settings', 'themescamp-core'),
	'icon' => 'fa-regular fa-image',
	'fields' => array(
		array(
			'id'       => 'tcg_header_logo_light',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__('Logo Dark Text', 'themescamp-core'), 
			'subtitle' => esc_html__('Upload your logo for white text (standard) header (Recommended size 240x80px)', 'themescamp-core'),
		), 
		array(
			'id'       => 'tcg_header_logo_drk',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__('Logo White Text', 'themescamp-core'), 
			'subtitle' => esc_html__('Upload your logo for dark text (standard) header (Recommended size 240x80px)', 'themescamp-core'),
		),
		array(
			'id'       => 'tcg_logo_dim',
			'type'     => 'dimensions',
			'height' => true,
             'width' => false,
			'units'    => array('em','px','%'),
			'title'    => esc_html__('Logo dimensions Height', 'themescamp-core'), 
			'subtitle' => esc_html__('Enable or disable any piece of this field. Width, Height, or Units.)', 'themescamp-core'),
			'default' => ['height' => 25], 
		), 
     
	)
));

Redux::setSection($tcg_pre, array(
	'id' => 'tcg_header_social',
	"subsection" => false,
	'title' => esc_html__('Header social', 'themescamp-core'),
	'desc' => esc_html__('Configuration the header social icons', 'themescamp-core'),
	'icon' => 'fa-solid fa-share-nodes',
	'fields' => array( 
		array(
			'id'       => 'tcg_header_enable_topmenu',
			'type'     => 'select',
			'title'    => esc_html__('Enable Top Menu', 'themescamp-core'),
			'options' => array(
				'on' => esc_html__('On', 'themescamp-core'),
				'off' => esc_html__('Off', 'themescamp-core'),
			), 
			'default'  => 'off',
		), 
		array(
			'id'       => 'tcg_header_phone',
			'type'     => 'text',
			'title'    => esc_html__('Phone', 'themescamp-core'), 
			'subtitle' => esc_html__('Input phone number', 'themescamp-core'),
			'required'  => array('tcg_header_enable_topmenu', 'equals','on'),
		),
		array(
			'id'       => 'tcg_header_mail',
			'type'     => 'text',
			'title'    => esc_html__('Mail', 'themescamp-core'), 
			'subtitle' => esc_html__('Input mail address', 'themescamp-core'),
			'required'  => array('tcg_header_enable_topmenu', 'equals','on'),
		),
		array(
			'id'       => 'tcg_header_address',
			'type'     => 'text',
			'title'    => esc_html__('Address', 'themescamp-core'), 
			'subtitle' => esc_html__('Input address', 'themescamp-core'),
			'required'  => array('tcg_header_enable_topmenu', 'equals','on'),
		),
		array(
			'id'       => 'tcg_header_join',
			'type'     => 'text',
			'title'    => esc_html__('Join', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Join text', 'themescamp-core'),
			'required'  => array('tcg_header_enable_topmenu', 'equals','on'),
		),
		array(
			'id'       => 'tcg_header_joinlink',
			'type'     => 'text',
			'title'    => esc_html__('Join', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Join link', 'themescamp-core'),
			'required'  => array('tcg_header_enable_topmenu', 'equals','on'),
		),
		array(
			'id'       => 'tcg_header_enable_social',
			'type'     => 'select',
			'title'    => esc_html__('Enable Header Social', 'themescamp-core'),
			'options' => array(
				'on' => esc_html__('On', 'themescamp-core'),
				'off' => esc_html__('Off', 'themescamp-core'),
			), 
			'default'  => 'off',
		), 
		array(
			'id'       => 'tcg_header_social_new_tab',
			'type'     => 'select',
			'title'    => esc_html__('Enable Header Social New Tab', 'themescamp-core'),
			'options' => array(
				'on' => esc_html__('On', 'themescamp-core'),
				'off' => esc_html__('Off', 'themescamp-core'),
			), 
			'default'  => 'off',
			'required'  => array('tcg_header_enable_social', 'equals','on'),
		), 
		array(
			'id'       => 'tcg_header_facebook',
			'type'     => 'text',
			'title'    => esc_html__('Facebook Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input facebook link here', 'themescamp-core'),
			'required'  => array('tcg_header_enable_social', 'equals','on'),
		),  
		array(
			'id'       => 'tcg_header_twitter',
			'type'     => 'text',
			'title'    => esc_html__('Twitter Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Twitter link here', 'themescamp-core'),
			'required'  => array('tcg_header_enable_social', 'equals','on'),
		), 
		array(
			'id'       => 'tcg_header_instagram',
			'type'     => 'text',
			'title'    => esc_html__('Instagram Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Instagram link here', 'themescamp-core'),
			'required'  => array('tcg_header_enable_social', 'equals','on'),
		),  
		array(
			'id'       => 'tcg_header_pinterest',
			'type'     => 'text',
			'title'    => esc_html__('Pinterest Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Pinterest link here', 'themescamp-core'),
			'required'  => array('tcg_header_enable_social', 'equals','on'),
		), 
		array(
			'id'       => 'tcg_header_xing',
			'type'     => 'text',
			'title'    => esc_html__('Xing Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Xing link here', 'themescamp-core'),
			'required'  => array('tcg_header_enable_social', 'equals','on'),
		),  
		array(
			'id'       => 'tcg_header_linkedin',
			'type'     => 'text',
			'title'    => esc_html__('LinkedIn Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input LinkedIn link here', 'themescamp-core'),
			'required'  => array('tcg_header_enable_social', 'equals','on'),
		),   
		array(
			'id'       => 'tcg_header_youtube',
			'type'     => 'text',
			'title'    => esc_html__('Youtube Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Youtube link here', 'themescamp-core'),
			'required'  => array('tcg_header_enable_social', 'equals','on'),
		),  
		array(
			'id'       => 'tcg_header_search',
			'type'     => 'select',
			'title'    => esc_html__('Search Icon', 'themescamp-core'), 
			'subtitle' => esc_html__('To show search icon in header', 'themescamp-core'),
			'options' => array(
				'on' => esc_html__('On', 'themescamp-core'),
				'off' => esc_html__('Off', 'themescamp-core'),
			), 
			'default'  => 'off',
		),  
		array(
			'id'       => 'tcg_header_btn',
			'type'     => 'select',
			'title'    => esc_html__('Button', 'themescamp-core'), 
			'subtitle' => esc_html__('To show Button in header', 'themescamp-core'),
			'options' => array(
				'on' => esc_html__('On', 'themescamp-core'),
				'off' => esc_html__('Off', 'themescamp-core'),
			), 
			'default'  => 'off',
		), 
		array(
			'id'       => 'tcg_menu_btn',
			'type'     => 'text',
			'title'    => esc_html__('Button Text', 'themescamp-core'), 
			'required'  => array('tcg_header_btn', 'equals','on'),
		),
		array(
			'id'       => 'tcg_menu_btn_url',
			'type'     => 'text',
			'title'    => esc_html__('Button URL', 'themescamp-core'),
			'required'  => array('tcg_header_btn', 'equals','on'), 
		),
	)
));

?>