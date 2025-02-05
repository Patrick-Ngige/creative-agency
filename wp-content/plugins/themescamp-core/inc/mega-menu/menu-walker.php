<?php



class Themescamp_Walker_Nav_Primary extends Walker_Nav_Menu{

	/**
	* Starts the list before the elements are added. 
	*
	* @since 3.0.0
	*
	* @see Walker::start_lvl()
	*
	* @param string $output Passed by reference. Used to append additional content.
	* @param int    $depth  Depth of menu item. Used for padding.
	* @param array  $args   An array of wp_nav_menu() arguments.
	*/

	function start_lvl(&$output, $depth = 0, $args = NULL){ //<ul>

        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"tcg-nav-item sub-menu depth_$depth\">\n"; 
	}


	/**
     * @see Walker::start_el()
     * @param string $output Passed by reference. Used to append additional content.
     * @param string $item Represents the current menu item being processed.
     * @param string $depth Represents the depth of the menu item.
     * @param string $args An array of arguments, typically provided by wp_nav_menu().   
     * @param string $id The ID of the current menu item.
     */

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {


		$item_html = $is_fullwidth = $badge_color = '';//$args->link_after = $args->link_before = '';

		if ( !isset( $args->link_before )){
			return;
		}


		$args->link_before = '';

		if( !empty( $item->themescamp_megaprofile ) ) {
			if ( is_plugin_active( 'elementor/elementor.php' ) ){
				$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
				$page_settings_model = $page_settings_manager->get_model( $item->themescamp_megaprofile );
				$is_fullwidth = $page_settings_model->get_settings( 'megamenu_fullwidth' );
			} else {
				$is_fullwidth = get_post_meta( $item->themescamp_megaprofile, 'megamenu-fullwidth', true );
			}
			if( 'yes' === $is_fullwidth ) {
				$item->classes[] = 'megamenu v menu-item-has-children megamenu-fullwidth';
			}
			else {
				$item->classes[] = 'megamenu tcg-buga-fat menu-item-has-children';
			}
		}


		 parent::start_el( $item_html, $item, $depth, $args, $id );


		if( !empty( $item->themescamp_megaprofile ) ) {
			$item_html .= $this->get_megamenu( $item->themescamp_megaprofile );
		}

		$output .= $item_html;
	}


	function get_megamenu( $id ) {

		$post = get_post( $id );
		$content = $post->post_content;


		$content = do_shortcode( $content );

		$style = $css = '';

		if ( ! is_plugin_active( 'elementor/elementor.php' )){
			return $css . '<div class="nav-item-childrenn"><div class="tcg-mega-menu-wrap megamenu-container container" '. $style . '>' . $content . '</div></div>';
		} else {
			return $css . '<div class="tcg-mega-nav-item tcg-buga"><div class="megamenu-container" '. $style . '>' . \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id )  . '</div></div>';
		} 
	}


}

