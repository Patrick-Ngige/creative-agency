<?php

/**************************************************
## DATA CONTROL FROM THEME-OPTIONS PANEL 
**************************************************/
if ( !function_exists( 'themescamp_settings' ) ) {
	 function themescamp_settings( $opt_id, $def_value='' )
	 {
		 global $tcg_theme_settings, $post;

		  $defval = '' != $def_value ? $def_value : false;
		  $opt_id = trim( $opt_id );
		  $opt    = isset( $tcg_theme_settings[ $opt_id ] ) ? $tcg_theme_settings[ $opt_id ] : $defval;

		  return $opt;
	 }
}


/* CSS custom option */
function themescamp_option_custom_css() {

	global $tcg_theme_settings, $post;
	$theme_style=get_option('tcg_theme_name');
	$core_style='themescamp-style';
	$options= themescamp_settings('tcg_custom_css');

	 //$options = get_option('your_option_name');  // Replace with your option name
	 if( isset($options) && !empty($options) ) {
		  wp_add_inline_style( $theme_style, $options );
		  wp_add_inline_style( $core_style, $options );
	 }
}
add_action( 'wp_enqueue_scripts', 'themescamp_option_custom_css', 100 );


/* Js custom option */
function themescamp__option_custom_js() {

    $options= themescamp_settings('tcg_custom_js');
    if( isset($options) && !empty($options) ) {
        echo '<script type="text/javascript">' . $options . '</script>';
    }
}
add_action('wp_footer', 'themescamp__option_custom_js');
