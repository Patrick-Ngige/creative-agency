<?php 
namespace ThemescampPlugin\TemplateParts;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Themescamp_Post {

    function __construct() {
        //fallback to the default page template   
        $this->post();
    }

    function post() {
        global $tcg_theme_settings;
        global $post; 
        $style = themescamp_settings( 'tcg_single_type_layout','2' );
        include('post-'.$style.'.php');
    }
}

?>
