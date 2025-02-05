<?php
/**
 * Footer Tab For Theme Option.
 *
 * @package tcg 
 */

Redux::setSection($tcg_pre, array(
	'title'  => esc_html__( 'Footer', 'themescamp-core' ),
));

Redux::setSection($tcg_pre, array(
	"subsection" => false,
	'title' => esc_html__('Footer settings', 'themescamp-core'),
	'desc'    => esc_html__('If wish to use customization, please use the   ', 'themescamp-core').'<a href="' . esc_url( admin_url( 'edit.php?post_type=tcg_teb' ) ) . '">' . esc_html__( 'Custom builder.', 'themescamp-core' ) . '</a>',
	'icon' => 'el el-photo',
	'fields' => array(
		array(
			'id'       => 'tcg_footer_set',
			'type'     => 'button_set',
			'title'    => esc_html__('Footer type', 'themescamp-core'),
			'options' => array(
				'standard' => esc_html__('Standard Footer', 'themescamp-core'),
				'custom_footer' => esc_html__('Custom Footer', 'themescamp-core'),
				'no_footer' => esc_html__('No Footer', 'themescamp-core'),
			),
			'default' => 'standard',
		),    
	),
));

Redux::setSection($tcg_pre, array(
	'id' => 'logo',
	"subsection" => false,
	'title' => esc_html__('Footer logo', 'themescamp-core'),
	'desc' => esc_html__('Configuration the style settings', 'themescamp-core'),
	'icon' => 'fa-regular fa-image',
	'fields' => array(
		array(
			'id'       => 'tcg_footer_logo_white',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__('Logo White Text', 'themescamp-core'), 
			'subtitle' => esc_html__('Upload your logo for white text (standard) footer (Recommended size 240x80px)', 'themescamp-core'),
			
		),

		array(
			'id'       => 'tcg_footer_logo_dark',
			'type'     => 'media',
			'url'      => true,
			'title'    => esc_html__('Logo Dark Text', 'themescamp-core'), 
			'subtitle' => esc_html__('Upload your logo for dark text (standard) footer (Recommended size 240x80px)', 'themescamp-core'),
		), 
		array(
			'id'       => 'tcg_footer_text',
			'type'     => 'editor',
			'title'    => esc_html__('Footer Text', 'themescamp-core'), 
			'subtitle' => esc_html__('Upload your logo for dark text (standard) footer (Recommended size 240x80px)', 'themescamp-core'),
			'default' => '',
			'args'   => array('teeny'  => true,'textarea_rows'=> 10)
		), 
	)
));



Redux::setSection($tcg_pre, array(
	'id' => 'tcg_footer_social',
	"subsection" => false,
	'title' => esc_html__('Footer social', 'themescamp-core'),
	'desc' => esc_html__('Configuration the footer social icons', 'themescamp-core'),
	'icon' => 'fa-solid fa-share-nodes',
	'fields' => array(
		array(
			'id'       => 'tcg_footer_enable_social',
			'type'     => 'switch',
			'title'    => esc_html__('Enable Footer Social', 'themescamp-core'), 
			'default'  => true,
		), 
		array(
			'id'       => 'tcg_footer_facebook',
			'type'     => 'text',
			'title'    => esc_html__('Facebook Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input facebook link here', 'themescamp-core'),
			'required'  => array('tcg_footer_enable_social', 'equals',true),
		),  
		array(
			'id'       => 'tcg_footer_twitter',
			'type'     => 'text',
			'title'    => esc_html__('Twitter Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Twitter link here', 'themescamp-core'),
			'required'  => array('tcg_footer_enable_social', 'equals',true),
		), 
		array(
			'id'       => 'tcg_footer_instagram',
			'type'     => 'text',
			'title'    => esc_html__('Instagram Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Instagram link here', 'themescamp-core'),
			'required'  => array('tcg_footer_enable_social', 'equals',true),
		),  
		array(
			'id'       => 'tcg_footer_pinterest',
			'type'     => 'text',
			'title'    => esc_html__('Pinterest Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Pinterest link here', 'themescamp-core'),
			'required'  => array('tcg_footer_enable_social', 'equals',true),
		), 
		array(
			'id'       => 'tcg_footer_xing',
			'type'     => 'text',
			'title'    => esc_html__('Xing Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input Xing link here', 'themescamp-core'),
			'required'  => array('tcg_footer_enable_social', 'equals',true),
		),  
		array(
			'id'       => 'tcg_footer_linkedin',
			'type'     => 'text',
			'title'    => esc_html__('LinkedIn Link', 'themescamp-core'), 
			'subtitle' => esc_html__('Input LinkedIn link here', 'themescamp-core'),
			'required'  => array('tcg_footer_enable_social', 'equals',true),
		),  
	)
));



?>