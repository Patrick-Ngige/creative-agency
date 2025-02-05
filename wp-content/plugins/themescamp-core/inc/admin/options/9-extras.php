<?php
/**
 * Extras Tab For Theme Option.
 *
 * @package tcg
 */

Redux::setSection($tcg_pre, array(
	'title'  => esc_html__( 'Extras', 'themescamp-core' ),
	'icon' => 'el el-plus-sign',
));

Redux::setSection($tcg_pre, array( 
	'id' => 'page_404',
	"subsection" => false,
	'title' => esc_html__('404 Page', 'themescamp-core'),
	'icon' => 'fa-solid fa-hands-bound',
	'fields' => array(
		array(
			'id'       => 'tcg_enable_custom_404',
			'type'     => 'switch',
			'customizer' => true,
			'title'    => esc_html__('Enable custom 404 page', 'themescamp-core'),
			'default' => false,
		),  
		array(
			'id'       => 'tcg_custom_404_page',
			'type'     => 'select',
			'customizer' => true,
			'title'    => esc_html__('Custom 404 page', 'themescamp-core'),
			'data'  => 'pages',

			'required' => array('tcg_enable_custom_404','=',true),
		),
	),
));


?>