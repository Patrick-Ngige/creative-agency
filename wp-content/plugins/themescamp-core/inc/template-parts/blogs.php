<?php 
namespace ThemescampPlugin\TemplateParts;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Themescamp_Blogs {

    function __construct() {
        
        echo '<!-- TCG-Core blog -->';
        $this->post();
    }

    function post() { 
        
        $tcg_blog_slider  = themescamp_settings( 'tcg_blog_slider', 'hide' );
        if ($tcg_blog_slider =='show') { include('slider-1.php');}

        $tcg_blog_popular  = themescamp_settings( 'tcg_blog_popular', 'hide' );
        if ($tcg_blog_popular =='show') { include('popular-1.php');} 


        $style = themescamp_settings( 'tcg_blog_article_layout' );
        
        include('blog-'.$style.'.php');

    }
}

?>
