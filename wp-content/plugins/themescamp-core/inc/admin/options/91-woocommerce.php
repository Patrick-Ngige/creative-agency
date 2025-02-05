<?php
/**
 * Woocommerce Tab For Theme Option.
 *
 * @package tcg
 */

Redux::setSection($tcg_pre, array(
	'id' => 'tcg_woocommerce_config',
	//"subsection" => false,
	'title' => esc_html__('Woo-Shop', 'themescamp-core'),
	'desc' => esc_html__('Configuration the Woocommerce', 'themescamp-core'),
	'icon' => 'el-icon-shopping-cart',
	'fields' => array( 

		array(
			'id'       => 'tcg_header_cart',
			'type'     => 'select',
			'title'    => esc_html__('Cart Icon', 'themescamp-core'), 
			'subtitle' => esc_html__('To show Cart icon in header', 'themescamp-core'),
			'options' => array(
				'on' => esc_html__('On', 'themescamp-core'),
				'off' => esc_html__('Off', 'themescamp-core'),
			), 
			'default'  => 'off',
		),


	)
));

?>