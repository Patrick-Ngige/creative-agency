<?php

//oneclick importer  

/*-----------ocdi_before_content_import ---------------------------*/
function ocdi_before_content_import( $selected_import ) {
    global $post;
    global $tcg_theme_settings;
    
    $theme_name = get_option('tcg_theme_name');
    $demos_url = get_option('tcg_theme_demo_url');

    $other_plugin_base = WP_PLUGIN_DIR . '/' . $theme_name . '_plugin/';
    $demos_directory_path = $other_plugin_base . 'inc/demo-data/elementor/';
    $demos_directory_url = str_replace(WP_PLUGIN_DIR, WP_PLUGIN_URL, $demos_directory_path);

    // Scan the directory for folders (demos)
    $folders = array_filter(glob($demos_directory_path . '*'), 'is_dir');

    // Construct the import settings for each demo
    $demo_imports = array();
    
    foreach ($folders as $folder_path) {
        // Get the folder name from the folder path
        $folder_name = basename($folder_path);

        // Construct the demo name by replacing dashes with spaces and uppercase each word
        $demo_name = ucwords(str_replace('-', ' ', $folder_name));

        // Check if the demo name matches the selected import
        if ($demo_name === $selected_import['import_file_name']) {
            // URL of the ZIP file
            $zip_url = $demos_directory_url . "{$folder_name}/custom-fonts.zip";
            
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
            $response = wp_safe_remote_get($zip_url);

            if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
                // Save the ZIP file
                if (file_put_contents($zip_file, wp_remote_retrieve_body($response)) !== false) {
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
        }
    }
}

add_action('ocdi/before_content_import', 'ocdi_before_content_import');


/*-----------import_files ---------------------------*/
function ocdi_import_files() {

	global $post ;
	global $tcg_theme_settings;
	$theme_name=get_option('tcg_theme_name');
	$demos_url=get_option('tcg_theme_demo_url');

	$other_plugin_base = WP_PLUGIN_DIR . '/'.$theme_name.'_plugin/';
	
	$demos_directory_path = $other_plugin_base . 'inc/demo-data/elementor/';

    $other_plugin_base_url = plugin_dir_url($other_plugin_base .$theme_name.'_plugin.php'); 
    $demos_directory_path = $other_plugin_base . 'inc/demo-data/elementor/';
    $demos_directory_url = str_replace(WP_PLUGIN_DIR, WP_PLUGIN_URL, $demos_directory_path);


   	// Scan the directory for folders (demos)
    $folders = array_filter(glob($demos_directory_path . '*'), 'is_dir');

    // Construct the import settings for each demo
    $demo_imports = array();

    foreach ($folders as $folder_path) {
        // Get the folder name from the folder path
        $folder_name = basename($folder_path);

        // Construct the demo name by replacing dashes with spaces and uppercase each word
        $demo_name = ucwords(str_replace('-', ' ', $folder_name));

        // Determine the category based on the folder name
        $categories = (strpos($folder_name, 'inner') !== false) ? array('Inner Pages') : array('Home Templates');

        $single_import = array(
            'import_file_name'             => $demo_name,
            'categories'                   => $categories,
            'import_file_url'              => $demos_directory_url . "{$folder_name}/content.xml",
            'import_widget_file_url'       => $demos_directory_url . "{$folder_name}/widgets.wie",
            'import_customizer_file_url'   => $demos_directory_url . "{$folder_name}/customizer.dat",
            'import_redux'                 => array(
                array(
                    'file_url'    => $demos_directory_url . "{$folder_name}/redux.json",
                    'option_name' => 'tcg_theme_setting',
                ),
            ),
            'import_preview_image_url'     => $demos_directory_url . "{$folder_name}/preview.jpg",
            'import_notice'               => __( '<p>To prevent any error, please use the clean WordPress site to import the demo data. </p><p>Or you can use this plugin 
            <a href="https://wordpress.org/plugins/wordpress-database-reset/" target="_blank">WordPress Database Reset</a> to reset/clear the database first.</p><p>After you import this demo, you will have to set up the Elementor page builder.</p>', 'bayone_plg' ),
            'preview_url'                  => "{$demos_url}/{$folder_name}",
        );

        // Add single import settings to the list
        $demo_imports[] = $single_import;
    }

    return $demo_imports;
}


add_filter( 'pt-ocdi/import_files', 'ocdi_import_files' );

/*-----------automatically assign "Front page", "Posts page" and menu locations ---------------------------*/

function ocdi_after_import( $selected_import ) {

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
    $kit_page_id = $kit_page_array[0];
    $kit_id = $kit_page_id->ID;
    update_option( 'elementor_active_kit', $kit_id ); 


	// Assign front page.
	$front_page_id = get_page_by_title( 'Home' );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'elementor_container_width', 1200 );
    
}
add_action( 'pt-ocdi/after_import', 'ocdi_after_import' );




/*------------------disable the ProteusThemes branding notice -----------------------------------*/

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

