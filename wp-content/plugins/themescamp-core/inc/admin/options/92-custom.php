<?php
/**
 * Custom Tab For Theme Option.
 *
 * @package tcg
 */


Redux::setSection($tcg_pre, array(
	'id' => 'tcg_custom_code',
	//"subsection" => false,
	'title' => esc_html__('Custom', 'themescamp-core'),
	'icon' => 'fa-solid fa-code',
	'fields' => array( 

	    array(
	        'id'       => 'tcg_custom_css',
	        'type'     => 'ace_editor',
	        'title'    => __('Custom CSS', 'themescamp-core'),
	        'subtitle' => __('Paste your CSS code here.', 'themescamp-core'),
	        'desc' => __( 'Set your custom CSS code. overwrite theme/plugin style..', 'themescamp-core' ),
	        'mode'     => 'css',
	        'theme'    => 'monokai',
	        'default'  => " /* CUSTOM CSS */ "
	    ),

        array(
            'id'       => 'tcg_custom_js',
            'type'     => 'ace_editor',
            'title'    => __( 'JavaScript Code', 'themescamp-core' ),
            'subtitle' => __( 'Paste your JS code here.', 'themescamp-core' ),
            'desc' => __( 'Set your custom JavaScript code. Loaded before </body> tag. <script> tags are automatically added..', 'themescamp-core' ),
            'mode'     => 'javascript',
            'theme'    => 'chrome',
            'default'  => "// Custom js ",
        ),
	)
));

?>