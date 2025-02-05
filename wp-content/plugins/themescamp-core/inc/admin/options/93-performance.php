<?php
/**
 * Performance Tab For Theme Option. 
 *
 * @package tcg
 */


Redux::setSection($tcg_pre, array(
	'id' => 'tcg_performance',
	//"subsection" => false,
	'title' => esc_html__('Performance', 'themescamp-core'),
	'icon' => 'fa-solid fa-gauge',
	'fields' => array( 
		
		array(
			'id'       => 'performance_block_style',
			'type'     => 'switch',
			'customizer' => true,
			'title'    => esc_html__('Default WP Block Styles', 'themescamp-core'),
			'desc'    => esc_html__('Turn off to disable the default styles from Gutenberg block library.', 'themescamp-core'),
			'default' => true,
		),

		array(
			'id'       => 'performance_emojy',
			'type'     => 'switch',
			'customizer' => true,
			'title'    => esc_html__('Emoji Script', 'themescamp-core'),
			'desc'    => esc_html__('Turn off to disable the Emoji script (wp-emoji-release.min.js).', 'themescamp-core'),
			'default' => true,
		),

		array(
			'id'       => 'performance_fa',
			'type'     => 'switch',
			'customizer' => true,
			'title'    => esc_html__('Font Awesome (fa)', 'themescamp-core'),
			'desc'    => esc_html__('Turn off to disable Font Awesome icon pack.', 'themescamp-core'),
			'default' => true,
		),

		array(
			'id'       => 'performance_eicon',
			'type'     => 'switch',
			'customizer' => true,
			'title'    => esc_html__('Elementor Icons (eicon)', 'themescamp-core'),
			'desc'    => esc_html__('Turn off to disable the default Elementor icon pack.', 'themescamp-core'),
			'default' => true,
		),

		array(
			'id'       => 'performance_elemnetor_animate',
			'type'     => 'switch',
			'customizer' => true,
			'title'    => esc_html__('Elementor Animations', 'themescamp-core'),
			'desc'    => esc_html__('Turn off to disable all animations.', 'themescamp-core'),
			'default' => true,
		),



	)
));

?>