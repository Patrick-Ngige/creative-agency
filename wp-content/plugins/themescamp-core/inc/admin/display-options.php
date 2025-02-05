<?php

// Define a function to display the admin page content

    $options = wp_load_alloptions();

    // Output the HTML for the admin page
    echo '<div class="wrap">';
    echo '<h2>All Saved Options</h2>';
    echo '<table class="widefat">';
    echo '<thead><tr><th>Option Name</th><th>Option Value</th></tr></thead>';
    echo '<tbody>';
    foreach ($options as $key => $value) {
        echo '<tr><td>' . esc_html($key) . '</td><td>';
        
        // Check if the option is serialized data
        if (is_serialized($value)) {
            // Unserialize the data and format it for human reading
            $unserialized_data = unserialize($value);
            if ($unserialized_data !== false) {
                // Convert the unserialized data to JSON for readability
                $formatted_value = json_encode($unserialized_data, JSON_PRETTY_PRINT);
                echo '<pre>' . esc_html($formatted_value) . '</pre>';
            } else {
                echo esc_html($value);
            }
        } else {
            echo esc_html($value);
        }
        
        echo '</td></tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
