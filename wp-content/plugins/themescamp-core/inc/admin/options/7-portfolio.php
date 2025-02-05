<?php
/**
 * Portfolio Tab For Theme Option.
 *
 * @package tcg
 */
Redux::setSection($tcg_pre, array(
	'title'  => esc_html__( 'portfolio', 'themescamp-core' ),
	'icon'=>'el el-briefcase',
));
Redux::setSection($tcg_pre, array(
	"subsection" => false,
	'title' => esc_html__('Portfolio settings', 'themescamp-core'),
	'desc' => esc_html__('Configuration portfolio settings', 'themescamp-core'),
	'icon' => 'el el-briefcase',
	'fields' => array(
		array(
			'id'       => 'tcg_portfolio_slug',
			'type'     => 'text',
			'title'    => esc_html__('Portfolio Slug', 'themescamp-core'), 
			'subtitle' => esc_html__('Custom slug for portfolio like "projects"', 'themescamp-core'),
			'desc' => sprintf(
			    esc_html__('Make sure to update %1$sPermalink%2$s to Post name structure and "save changes".', 'themescamp-core'),
			    '<a href="' . esc_url(admin_url('options-permalink.php')) . '" target="_blank">',
			    '</a>'
			),

			'default'  => 'portfolio',
		), 
		array(
			'id'       => 'tcg_portfolio_category_slug',
			'type'     => 'text',
			'title'    => esc_html__('Portfolio category Slug', 'themescamp-core'), 
			'subtitle' => esc_html__('Custom slug for portfolio like "projects-cats"', 'themescamp-core'),
			'desc' => sprintf(
			    esc_html__('Make sure to update %1$sPermalink%2$s to Post name structure and "save changes".', 'themescamp-core'),
			    '<a href="' . esc_url(admin_url('options-permalink.php')) . '" target="_blank">',
			    '</a>'
			),

			'default'  => 'portfolio_category',
		), 
		array(
			'id'       => 'tcg_portfolio_tag_slug',
			'type'     => 'text',
			'title'    => esc_html__('Portfolio tag Slug', 'themescamp-core'), 
			'subtitle' => esc_html__('Custom slug for portfolio like "projects-tag"', 'themescamp-core'),
			'desc' => sprintf(
			    esc_html__('Make sure to update %1$sPermalink%2$s to Post name structure and "save changes".', 'themescamp-core'),
			    '<a href="' . esc_url(admin_url('options-permalink.php')) . '" target="_blank">',
			    '</a>'
			),

			'default'  => 'porto_tag',
		),
	),
));


?>