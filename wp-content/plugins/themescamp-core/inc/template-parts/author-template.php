<?php 
namespace ThemescampPlugin\TemplateParts;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Themescamp_Author_Template {

    function __construct() {
        //fallback to the default page template
        $this->post();
    }

    function post() { ?>

        <!-- Author title -->
        <div class="tcg-author">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1>   <?php echo esc_html__( 'Author: ', 'themescamp-core' ).'<span>'.esc_html(get_the_author_meta('display_name')).'</span>'; ?> </h1> 
                    </div>
                </div>
            </div>
        </div>


        <?php

        $style = themescamp_settings( 'tcg_blog_article_layout' );
        include('blog-'.$style.'.php');
    }
}

?>
