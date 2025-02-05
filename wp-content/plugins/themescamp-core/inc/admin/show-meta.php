<?php

// Function to display the post's meta data in the metabox
function display_post_meta_in_metabox($post) {
    // Fetch all meta data for the post
    $meta_data = get_post_meta($post->ID);

    echo '<div class="post-meta-data-editor">';
    echo '<ul>';
    foreach ($meta_data as $key => $value) {
        // Skip hidden meta keys (those starting with an underscore)
        if (strpos($key, '_') !== 0) {
            echo '<li><strong>' . esc_html($key) . ':</strong> ' . esc_html(implode(', ', $value)) . '</li>';
        }
    }
    echo '</ul>';

    // Checkbox to delete all meta on post save
    echo '<p><label><input type="checkbox" name="_delete_all_meta_on_save" value="1"> ';
    _e('Delete all meta data on save?', 'your-textdomain');
    echo '</label></p>';
    
    echo '</div>';
}


// Function to register the metabox
function add_post_meta_metabox() {
    if(themescamp_settings('tcg_show_meta') == 'show'){
        // Get all public post types
        $post_types = get_post_types(array('public' => true), 'names');

        // Loop through each post type and add the metabox
        foreach ($post_types as $post_type) {
            add_meta_box(
                'post_meta_data_metabox',         // Unique ID
                'Post Meta Data',                 // Box title
                'display_post_meta_in_metabox',   // Content callback
                $post_type,                       // Post type
                'side',                           // Context
                'default'                         // Priority
            );
        }
    }
}

  add_action('add_meta_boxes', 'add_post_meta_metabox');


function handle_meta_data_deletion_on_save($post_id) {
    // Check if our nonce is set and verify it.
    if(!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'update-post_' . $post_id)) {
        return $post_id;
    }

    // Don't run on WP's autosave function
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Check the user's permissions.
    if(!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Check for checkbox and delete meta data accordingly
    if(isset($_POST['_delete_all_meta_on_save']) && $_POST['_delete_all_meta_on_save'] == '1') {
        $meta_data = get_post_meta($post_id);
        foreach ($meta_data as $key => $value) {
            // Skip hidden meta keys (those starting with an underscore)
            if (strpos($key, '_') !== 0) {
                delete_post_meta($post_id, $key);
            }
        }
    }

    // Check for button click and delete meta data accordingly
    if(isset($_POST['_delete_all_meta_now'])) {
        $meta_data = get_post_meta($post_id);
        foreach ($meta_data as $key => $value) {
            // Skip hidden meta keys (those starting with an underscore)
            if (strpos($key, '_') !== 0) {
                delete_post_meta($post_id, $key);
            }
        }
    }
}

add_action('save_post', 'handle_meta_data_deletion_on_save');
