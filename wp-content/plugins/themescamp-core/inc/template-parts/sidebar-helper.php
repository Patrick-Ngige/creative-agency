<?php

defined( 'ABSPATH' ) || exit;

/**
* Sidebar Helper
*
*
* @class        Themescamp_Sidebar_Helper
* @version      1.0
* @category     Class
* @author       ThemesCamp
*/

if (! class_exists('Themescamp_Sidebar_Helper')) {
	class Themescamp_Sidebar_Helper
	{
		public static function render_sidebars(){

			$sidebar_style = '';
			$sidebar_gap = themescamp_settings( 'single_sidebar_gap','0' );
			$layout = themescamp_settings( 'single_sidebar_layout' );

			if (isset($sidebar_gap) && $sidebar_gap != 'def' && $layout != 'default') {
				$layout_pos = $layout == 'left' ? 'right' : 'left';
				$sidebar_style = 'style="padding-'.$layout_pos.': '.$sidebar_gap.'px;"';
				return $sidebar_style;
			}
		}

	}
}