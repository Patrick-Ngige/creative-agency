<?php
namespace ThemescampPlugin\TemplateBuilder;

use ThemescampPlugin\Admin\Themescamp_Admin_Panel;

class Themescamp_TemplateAdmin {

    /**
     * Constructor
     */
    public function __construct() {

        add_action( 'admin_menu', [$this, 'themescamp_themebuilder_menu'],9 );
        add_action('all_admin_notices', [$this, 'show_dashboard_tabs_before_title']);
        add_filter( 'manage_tcg_teb_posts_columns', [$this, 'custom_columns'] );
        add_filter( 'manage_tcg_teb_posts_custom_column', [$this, 'display_custom_columns'] );
        add_filter( 'views_edit-tcg_teb', [$this, 'admin_print_tabs'] );
        add_action( 'pre_get_posts', [$this, 'filter_posts_by_template_type'] );

    }

    /**
     * Register admin menu
     */
	public function themescamp_themebuilder_menu(){
		add_menu_page(
		    __( 'Theme Builder', 'themescamp-core' ),
		    __( 'Theme Builder', 'themescamp-core' ),
		    'manage_options',
		    'edit.php?post_type=tcg_teb',
		    '',THEMESCAMP_URL . 'assets//img/theme-builder-icon-tc.png'
		    ,
		    3
		);
	}

    /**
     * Add Custom Columns in admin view table
     *
     * @param [type] $columns
     * @return void
     */
    public function custom_columns( $columns ) {
        $columns['type'] = __( 'Type', 'themescamp-core' );
        $columns['info'] = __( 'Info', 'themescamp-core' );

        return $columns;
    }

    /**
     * Admin Custom Columns view table content
     *
     * @param [type] $name
     *
     * @return void
     */
    public function display_custom_columns( $name ) {
        global $post;

        switch ( $name ) {
        case 'type':
            echo ucwords( str_replace( '_', ' ', $this->get_template_type( $post->ID ) ) );
            break;
        case 'info':
            echo $this->get_item_info( $post->ID );
            break;
        }
    }

    /**
     * Get Template Type
     *
     * @param int $post_id
     *
     * @return string
     */
    public function get_template_type( $post_id ) { 

        $meta = get_post_meta( $post_id, 'template_type', true );

        if ( isset( $meta ) ) {
            $template_type = $meta;
        } else {
            $template_type = '';
        }

        return $template_type;
    }

    /**
     * Get Item Info to Display in admin table
     *
     * @param int $post_id
     *
     * @return void
     */
    public function get_item_info( $post_id ) {

        $type = $this->get_template_type( $post_id );
        $info = '';

        if ( $type == 'block' ) {
            $info = '<input class="wp-ui-text-highlight code widefat" type="text" onfocus="this.select();" readonly="readonly" value="[tcg-tb-block id=&quot;' . $post_id . '&quot;]">';
        } else {
            $info = $this->get_pretty_condition( 'include', $post_id ) . '</br>' . $this->get_pretty_condition( 'exclude', $post_id );
        }

        return $info;
    }


    /**
     * Get pretty condition to display in admin table
     *
     */
    public function get_pretty_condition( $type, $post_id ) {
        $info    = null;
        $include = get_post_meta( $post_id, 'tcg_tb_' . $type, true );

        if ( is_array( $include ) ) {
            $lastKey = array_keys( $include );
            $lastKey = \end( $lastKey );
            $info .= '<b>' . ucfirst( $type ) . ': </b>';
            $index = 0;

            foreach ( $include as $rule ) {
                $index++;

                if ( $index != 1 ) {
                    $info .= ', ';
                }
                $info .= ucwords( str_replace( '_', ' ', $rule ) );
            }
        }

        return $info;

    }

    public function show_dashboard_tabs_before_title() {
        global $typenow;

        if ($typenow === 'tcg_teb') {
            echo '<div class="tcg-builder-tabs">';
            (new Themescamp_Admin_Panel())->dashboard_tabs();
            echo '</div>';
        }
    }

    /**
     * To display Tabs
     *
     */

    public function admin_print_tabs( $views ) 
    { 
        $types = array('All', 'Header', 'Footer', 'Megamenu', 'Popup', 'Offcanvas', 'Single', 'Archive', 'Block'); // Specific template types

        $current_type = empty($_GET['template_type']) ? 'all' : sanitize_key($_GET['template_type']);
        $baseurl = admin_url('edit.php?post_type=tcg_teb');

        echo '<div class="tcg-teb-tabs">';
        foreach ( $types as $type ) {
            $type_key = strtolower($type); // Convert to lowercase for comparison and URL
            $class = ($type_key === $current_type) ? ' class="current"' : '';
            $url = ($type == 'All') ? $baseurl : add_query_arg('template_type', $type_key, $baseurl);
            echo "<a href='{$url}'{$class}>{$type}</a> ";
        }
        echo '</div>';

        return $views;
    }



    private function get_all_template_types()
    {
        $args = array(
            'post_type'  => 'tcg_teb',
            'meta_key'   => 'template_type',
            'posts_per_page' => -1,
            'fields'      => 'ids',
        );

        $query = new \WP_Query($args);
        $posts = $query->posts;

        $template_types = array();
        foreach ($posts as $post_id) {
            $meta_value = get_post_meta($post_id, 'template_type', true);
            // Check if the template type is not empty and not already in the array.
            if (!empty($meta_value) && !in_array(ucfirst($meta_value), $template_types)) {
                $template_types[] = ucfirst($meta_value);
            }
        }

        return $template_types;
    }

    public function filter_posts_by_template_type( $query ) {
        // Check if we are in admin and it's the main query and post type is tcg_teb
        if( is_admin() && $query->is_main_query() && $query->get( 'post_type' ) == 'tcg_teb' ) {

            // Check if template_type is set in the URL
            if( isset($_GET['template_type']) && !empty($_GET['template_type']) ) {

                // Sanitize the input
                $template_type = sanitize_key( $_GET['template_type'] );

                // Modify the query
                $meta_query = array(
                    array(
                        'key'     => 'template_type',
                        'value'   => $template_type,
                        'compare' => '=',
                    ),
                );

                $query->set( 'meta_query', $meta_query );
            }
        }
    }


}

new Themescamp_TemplateAdmin();