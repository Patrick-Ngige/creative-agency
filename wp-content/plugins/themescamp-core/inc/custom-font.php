<?php

if ( ! function_exists( 'is_plugin_active' ) ) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( is_plugin_active( 'elementor/elementor.php' ) ) {

    /**
     * Add new font group (Custom) to the top of the list
     */
    add_filter('elementor/fonts/groups', function($font_groups) {
         $new_font_group = array('custom' => __('Custom', 'themescamp-core'));
        return array_merge($new_font_group, $font_groups);
    });

    /**
     * Add fonts to the new font group
     */
    add_filter('elementor/fonts/additional_fonts', function($additional_fonts) {

        global $tcg_theme_settings;

        if (isset($tcg_theme_settings['custom_fonts_typography']) && is_array($tcg_theme_settings['custom_fonts_typography'])) {

            $custom_fonts = $tcg_theme_settings['custom_fonts_typography'];

            foreach ($custom_fonts as $font) {
                if (isset($font['font-family']) && is_string($font['font-family'])) {
                    $additional_fonts[$font['font-family']] = 'custom';
                }
            }
        }

        return $additional_fonts;
    });
}










