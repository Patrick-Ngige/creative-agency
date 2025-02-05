<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Themescamp_Blank {

    function __construct() {
        //fallback to the default page template
        //(new Themescamp_Standard_Blocks())->standard_offcanvas();
        $this->post();
    }

    function post() {
        //page content
        echo'<div class="blank-builder tcg-core">';
        while (have_posts()) : the_post();
            the_content();
        endwhile;
        echo'</div>';
    }
}

?>
