<?php

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>
<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
	<meta charset="<?php bloginfo( 'charset' );?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head();?>

    <style>
        .elementor-add-section:not(.elementor-dragging-on-child) .elementor-add-section-inner {
            background-color: #fff;
        }
    </style>
</head>
<body <?php body_class();?>>

    <?php

        $meta = get_post_meta( get_the_ID());
        //var_dump($meta);
        //echo $meta;
        $width = 420;

        if ( array_key_exists( 'tcg_set_offcanvas_width', $meta ) ) {
            if ( $meta['tcg_set_offcanvas_width'][0] ) {
                $pre_width = maybe_unserialize ($meta['tcg_set_offcanvas_width'][0]) ;
                $width =$pre_width['width'];
            }
        }



ob_start();
Plugin::$instance->modules_manager->get_modules( 'page-templates' )->print_content();
$page_content = ob_get_clean();


// Extract style tags
$style_start = strpos($page_content, '<style>');
$style_end = strpos($page_content, '</style>') + strlen('</style>'); // include the closing tag

if ($style_start !== false && $style_end !== false) {
    $style_content = substr($page_content, $style_start, $style_end - $style_start);
    $page_content = str_replace($style_content, '', $page_content); // Remove the style from the content

    // Save style content to be added in head
    $GLOBALS['my_custom_plugin_styles'] = $style_content;
}


        ?>
<div class="tcg-offcanvas-wrapper">
    <div class="offcanvas-overly"></div>
    <div class="offcanvas-container" style="width: <?php echo esc_attr( $width ) ?>;">
        <div class="offcanvas-close 223"><i class="fal fa-times"></i></div>
        <?php 
        // Print the content without style tags
        echo $page_content;
        ?>
    </div>
</div>
        <?php
    

        wp_footer();
    ?>

</body>
</html>