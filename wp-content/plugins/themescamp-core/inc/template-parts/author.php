<?php 
//namespace ThemescampPlugin\TemplateParts;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Themescamp_Author {

    function __construct() {
        //fallback to the default page template
        do_action( "themescamp_author" );
    }
}


?>
