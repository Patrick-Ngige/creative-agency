<?php

/**
* Themescamp Themes Framework
* The Themescamp_Mega_Menu_Manager class
*/

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

// Load front-end menu walker
include( 'menu-walker.php' );

class Themescamp_Mega_Menu_Manager {

	function __construct() {

		// Custom Fields - Add
		$this->add_filter( 'wp_setup_nav_menu_item',  'setup_nav_menu_item' );

		// Custom Fields - Save
		$this->add_action( 'wp_update_nav_menu_item', 'update_nav_menu_item', 100, 3 );

		// Custom Walker - Edit
		$this->add_filter( 'wp_edit_nav_menu_walker', 'edit_nav_menu_walker', 100, 2 );
	}

	public function add_action( $hook, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		add_action( $hook, array( &$this, $function_to_add ), $priority, $accepted_args );
	}

	public function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
		add_filter( $tag, array( &$this, $function_to_add ), $priority, $accepted_args );
	}


	// Custom Fields - Add 
    function setup_nav_menu_item( $menu_item ) {

		$menu_item->themescamp_megaprofile = get_post_meta( $menu_item->ID, '_menu_item_themescamp_megaprofile', true );

        return $menu_item;
    }

	// Custom Fields - Save
	function update_nav_menu_item( $menu_id, $menu_item_db_id, $menu_item_data ) {

		if ( isset( $_REQUEST['menu-item-themescamp-megaprofile'][$menu_item_db_id]) ) {
			update_post_meta($menu_item_db_id, '_menu_item_themescamp_megaprofile', $_REQUEST['menu-item-themescamp-megaprofile'][$menu_item_db_id]);
		}	
	}

	// Custom Backend Walker - Edit
	function edit_nav_menu_walker( $walker, $menu_id ) {

		if ( ! class_exists( 'Themescamp_Mega_Menu_Edit_Walker' ) ) {
			require_once( 'menu-walker-edit.php' );
		}

		return 'Themescamp_Mega_Menu_Edit_Walker';
	}
}
new Themescamp_Mega_Menu_Manager;
