<?php 
namespace ThemescampPlugin\TemplateParts;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Themescamp_Portfolio {

    function __construct() {
        //fallback to the default page template   
        $this->post();
    }

    function post() {
        global $tcg_theme_settings;
        global $post; 
        if ( have_posts() ) : while ( have_posts() ) : the_post();
            echo '<div class="tcg-single-portfolio trx clearfix">';
                the_content (); 
            echo '</div>';
        endwhile; endif; 

        wp_reset_postdata();
    }
}

?>
