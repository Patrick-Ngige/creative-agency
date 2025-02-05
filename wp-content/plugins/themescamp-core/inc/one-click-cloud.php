<?php
 use ThemescampPlugin\Admin\Themescamp_Admin_Panel;
//oneclick importer  

/*-----------ocdi_before_content_import ---------------------------*/ 
function ocdi_before_content_import($selected_import) {
    global $post;
    global $tcg_theme_settings;
    global $parent_demo_url;
        
    $theme_name=get_option('tcg_theme_name');

    if (!has_action('tcg_demos_link')) {
        $parent_demo_url='https://elements.themescamp.com/docs/'; 
    } else {
        do_action('tcg_demos_link');
    }

    $demos_url = $parent_demo_url . $theme_name . '/demo-data/elementor/';

    // Optional: Verify the result
    echo $demos_url;

    // Fetch JSON data from online source
    $response = wp_remote_get($demos_url . 'index.json');

    // Check if the request was successful
    if (is_array($response) && !is_wp_error($response)) {
        // Get the response body (JSON data)
        $body = wp_remote_retrieve_body($response);

        // Decode JSON data
        $demo_names = json_decode($body, true);

        // Check if JSON data is decoded successfully
        if ($demo_names !== null) {
            
            // Loop through each demo name
            foreach ($demo_names as $demo_name) {
                
                // Check if the demo name matches the selected import
                if ($demo_name === strtolower(str_replace(' ', '-', $selected_import['import_file_name']))) {
                    // URL of the ZIP file
                    $zip_url = $demos_url . strtolower(str_replace(' ', '-', $demo_name)) . '/custom-fonts.zip';

                    // Get the uploads directory
                    $upload_dir = wp_upload_dir();
                    // Target directory for extraction
                    $target_dir = $upload_dir['basedir'] . '/redux/'; // Target directory

                    // Check if the target directory exists, if not create it
                    if (!file_exists($target_dir)) {
                        wp_mkdir_p($target_dir);
                    }

                    // File name
                    $zip_file = $target_dir . 'custom-fonts.zip';

                    // Download the ZIP file
                    $response_zip = wp_safe_remote_get($zip_url);

                    if (!is_wp_error($response_zip) && wp_remote_retrieve_response_code($response_zip) === 200) {
                        // Save the ZIP file
                        if (file_put_contents($zip_file, wp_remote_retrieve_body($response_zip)) !== false) {
                            // Unzip the file
                            WP_Filesystem();
                            $unzipfile = unzip_file($zip_file, $target_dir);

                            if (is_wp_error($unzipfile)) {
                                echo "Failed to extract ZIP file: " . $unzipfile->get_error_message();
                            } else {
                                echo "ZIP file downloaded and extracted successfully.";

                                // Delete the ZIP file
                                unlink($zip_file);

                                // Path to the extracted fonts.css file
                                $fonts_css_path = $target_dir . 'custom-fonts/fonts.css';

                                if (file_exists($fonts_css_path)) {
                                    $fonts_css_content = file_get_contents($fonts_css_path);
                                    if ($fonts_css_content !== false) {
                                        $site_url = site_url();
                                        $pattern = "/src:url\('(.*?)\/redux\/custom-fonts\//";
                                        $replacement = "src:url('".$upload_dir['baseurl']."/redux/custom-fonts/";
                                        $new_fonts_css_content = preg_replace($pattern, $replacement, $fonts_css_content);

                                        if (file_put_contents($fonts_css_path, $new_fonts_css_content) === false) {
                                            echo 'Failed to update fonts.css file.';
                                        }
                                    } else {
                                        echo 'Failed to read fonts.css file.';
                                    }
                                } else {
                                    echo 'fonts.css file does not exist.';
                                }
                            }
                        } else {
                            echo "Failed to save ZIP file.";
                        }
                    } else {
                        echo "Failed to download ZIP file.";
                    }

                    // Stop the loop as we found the matching demo
                    break;
                }
            }
        } else {
            // If JSON decoding failed, log an error
            error_log('Failed to decode JSON data from ' . $demos_url);
        }
    } else {
        // If request failed, log an error
        error_log('Failed to fetch JSON data from ' . $demos_url);
    }
}

add_action('ocdi/before_content_import', 'ocdi_before_content_import');

/*-----------import_files ---------------------------*/
function ocdi_import_files() {

    global $post;
    global $tcg_theme_settings;
    global $parent_demo_url;

    $theme_name=get_option('tcg_theme_name');


    if (!has_action('tcg_demos_link')) {
        $parent_demo_url='https://elements.themescamp.com/docs/'; 
    } else {
        do_action('tcg_demos_link');
    }


    $demos_url = $parent_demo_url.$theme_name.'/demo-data/elementor';

    // Fetch JSON data from online source
    $response = wp_remote_get($demos_url.'/index.json');
    $filtered_demo_url = apply_filters( 'tcg_theme_demo_url', TCG_THEME_DEMO_URL );
    // Check if the request was successful
    if (is_array($response) && !is_wp_error($response)) {
        // Get the response body (JSON data)
        $body = wp_remote_retrieve_body($response);

        // Decode JSON data
        $demo_names = json_decode($body, true);

        // Check if JSON data is decoded successfully
        if ($demo_names !== null) {
            // Initialize an array to store demo imports
            $demo_imports = array();

            // Loop through each demo name
            foreach ($demo_names as $demo_name) {

                // Determine the category based on the folder name
                $is_inner = strpos(strtolower($demo_name), 'inner') !== false;
                $just_home = get_option('tcg_theme_demo_with_inner') ? array('Full Demo Templates') : array('Home Templates');
                $categories = $is_inner ? array('Inner Pages') : $just_home;

                // Construct the import settings for the demo
                $single_import = array(
                    'import_file_name'   => ucwords(str_replace('-', ' ', $demo_name)),
                    'categories'         => $categories,
                    'import_file_url'    => $demos_url . '/' . strtolower(str_replace(' ', '-', $demo_name)) . '/content.xml',
                    'import_notice'      => __( '<p>To prevent any error, please use the clean WordPress site to import the demo data. </p><p>Or you can use this plugin <a href="https://wordpress.org/plugins/wordpress-database-reset/" target="_blank">WordPress Database Reset</a> to reset/clear the database first.</p><p>After you import this demo, you will have to set up the Elementor page builder.</p>', 'bayone_plg' ),
                    'preview_url'        => $filtered_demo_url . '/' . $demo_name,
                    'import_preview_image_url'     => $demos_url . '/' . strtolower(str_replace(' ', '-', $demo_name)) . '/preview.jpg',
                );

                // Add additional settings for non-inner demos
                if (!$is_inner) {
                    $single_import['import_widget_file_url'] = $demos_url . '/' . strtolower(str_replace(' ', '-', $demo_name)) . '/widgets.wie';
                    $single_import['import_customizer_file_url'] = $demos_url . '/' . strtolower(str_replace(' ', '-', $demo_name)) . '/customizer.dat';
                    $single_import['import_redux'] = array(
                        array(
                            'file_url'    => $demos_url . '/' . strtolower(str_replace(' ', '-', $demo_name)) . '/redux.json',
                            'option_name' => 'tcg_theme_setting',
                        ),
                    );
                }

                // Add single import settings to the list
                $demo_imports[] = $single_import;
            }

            return $demo_imports;
        } else {
            // If JSON decoding failed, log an error and return empty array
            error_log('Failed to fetch data from ' . $demos_url);
            return array();
        }
    } else {
        // If request failed, log an error and return empty array
        error_log('Failed to fetch data from ' . $demos_url);
        return array();
    }
}

add_filter('pt-ocdi/import_files', 'ocdi_import_files');



/*-----------automatically assign "Front page", "Posts page" and menu locations ---------------------------*/ 

function ocdi_after_import( $selected_import ) {

    if (strpos($selected_import['import_file_name'], 'Inner') === false) {

    	// Assign menus to their locations. 
    	$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    	set_theme_mod( 'nav_menu_locations', array(
    			'primary_menu' => $main_menu->term_id, // replace 'main-menu' here with the menu location identifier from register_nav_menu() function
    		)
    	);

        // Set Default Kit for Elementor
        $kit_name = $selected_import['import_file_name']. ' Kit';
        $kit_page_array = get_posts([
            'title' => $kit_name,
            'post_type' => 'elementor_library',
        ]);

        //if (!empty($kit_page_array) && $kit_page_array[0]->post_title === $kit_name) {
            $kit_page_id = $kit_page_array[0];
            $kit_id = $kit_page_id->ID;
            update_option( 'elementor_active_kit', $kit_id ); 
        //}


    	// Assign front page.
    	$front_page_id = get_page_by_title( 'Home' );
    	update_option( 'show_on_front', 'page' );
    	update_option( 'page_on_front', $front_page_id->ID );

    }

    // Update the Dev-tools options for 'tcg_show_meta', 'tcg_show_block_edit', and 'tcg_mode_switcher'.
    $options = get_option( 'tcg_theme_setting' ); 

    if ( isset( $options['tcg_show_meta'] ) ) {
        $options['tcg_show_meta'] = 'hide';
    }

    if ( isset( $options['tcg_show_block_edit'] ) ) {
        $options['tcg_show_block_edit'] = 'hide';
    }

    if ( isset( $options['tcg_mode_switcher'] ) ) {
        $options['tcg_mode_switcher'] = 'off';
    }

    if ( isset( $options['tcg_feature_switcher'] ) ) {
        $options['tcg_feature_switcher'] = 'off';
    }

    update_option( 'tcg_theme_setting', $options );

    
}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import' );


/*------------------disable the ProteusThemes branding notice -----------------------------------*/

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
add_filter('ocdi_admin_notices', '__return_empty_array');


// Customize the import successful buttons based on the import type.
function custom_import_successful_buttons( $buttons ) {

    $buttons = [
        [
            'label'  => __( 'Import HomePages', 'themescamp-core' ),
            'class'  => 'button button-primary button-hero import-homes',
            'href'   => admin_url( 'admin.php?page=one-click-demo-import#hometemplates' ),
        ],
        [
            'label'  => __( 'Visit Site', 'themescamp-core' ),
            'class'  => 'button button-secondary button-hero',
            'href'   => get_home_url(),
            'target' => '_blank',
        ],
        [
            'label'  => __( 'Import Inner pages', 'themescamp-core' ),
            'class'  => 'button button-primary button-hero import-inners',
            'href'   => admin_url( 'admin.php?page=one-click-demo-import#innerpages' ),
        ],
    ];

    if(get_option('tcg_theme_demo_with_inner')) {
        $buttons = [
            [
                'label'  => __( 'Visit Site', 'themescamp-core' ),
                'class'  => 'button button-secondary button-hero',
                'href'   => get_home_url(),
                'target' => '_blank',
            ],
        ];
    }

    return $buttons;
}


add_filter( 'ocdi/import_successful_buttons', 'custom_import_successful_buttons' );


function ocdi_plugin_intro_text( $default_text ) {
	$default_text = esc_html((new Themescamp_Admin_Panel())->dashboard_tabs());

	return $default_text;
}
add_filter( 'ocdi/plugin_intro_text', 'ocdi_plugin_intro_text' );