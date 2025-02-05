<?php
// Registers the new post type  

function themescamp_post_type() {

  // global $post;
  // global $tcg_theme_settings; 
  // $slug=themescamp_settings( 'tcg_template_type');


	register_post_type( 'tcg_teb',
		array(
			'labels' => array(
				'name' => __( 'Theme Builder', 'themescamp-core' ),
				'singular_name' => __( 'Builder Template' , 'themescamp-core'),
				'add_new' => __( 'Add New', 'themescamp-core' ),
				'add_new_item' => __( 'Add New.', 'themescamp-core' ),
				'edit_item' => __( 'Edit Post', 'themescamp-core' ),
				'new_item' => __( 'Add New..', 'themescamp-core' ),
				'view_item' => __( 'View Post', 'themescamp-core' ),
				'search_items' => __( 'Search Post', 'themescamp-core' ),
				'not_found' => __( 'No Posts found', 'themescamp-core' ),
				'not_found_in_trash' => __( 'No Posts found in trash', 'themescamp-core' )
			),
			'public' => true,
			'supports' => array( 'title'),
			'capability_type' => 'post',
			'rewrite' => array("slug" => 'tcg_teb'), // Permalinks format
			'menu_position' => 3,
			'menu_icon'           => 'dashicons-align-center',
			'exclude_from_search' => true,
            'show_in_menu'        => false,
            'show_in_admin_bar'   => true,
		)
	);

}

add_action( 'init', 'themescamp_post_type' ); 





class Template_CPT {
    /**
     * @var string
     *
     * Set post type params
     */
    private $type = 'tcg_teb';

    /**
     * Class Constructor
     */
    public function __construct() {
        add_filter( 'single_template', [$this, 'custom_templates'] );
    }


    /**
     * Custom Template
     *
     * @param $single_template
     * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/single_template;
     */
    public function custom_templates( $single_template ) {
        global $post;

        if ( $post->post_type == $this->type ) {
            $meta = get_post_meta( $post->ID, 'template_type', true ); 

            if ( isset( $meta ) ) {
                $template_type = $meta;
            } else {
                $template_type = '';
            }

            if ( 'offcanvas' === $template_type ) {
                $single_template = untrailingslashit( plugin_dir_path(  __FILE__ )  ) . '/templates/offcanvas.php';
            }else{
                $single_template = untrailingslashit( plugin_dir_path(  __FILE__ )  ) . '/templates/canvas.php';
            }
        }

        return $single_template;
    }
}

new Template_CPT();



