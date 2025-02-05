<?php 
namespace ThemescampPlugin\TemplateParts;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

class Themescamp_404Template {

    function __construct() {
        //fallback to the default page template
        $this->post();
    }

    function post() {
 
        if (themescamp_settings( 'tcg_enable_custom_404' ) ==true && themescamp_settings( 'tcg_custom_404_page' ) !='' ) {

            $page_404_id =  themescamp_settings( 'tcg_custom_404_page' );  

            $tcg_404_page = new \WP_Query(array(
                'posts_per_page' => -1,
                'post_type' =>  'page',
                'p' => esc_html($page_404_id), 
            ));  
            
            if ($tcg_404_page->have_posts()) : 
                while  ($tcg_404_page->have_posts()) : $tcg_404_page->the_post();$page_404_id; ?>
                    <?php the_content(); ?>
                <?php endwhile; 
            endif; 
            wp_reset_postdata();
        } else {
            /*-- Default 404 Error Fallback if no theme options install --*/
            echo '<div class="tcg-theme">';
            ?>
            <div class="clearfix content page-content-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 news-list aligncenter">
                            <h2 class="error-title"><?php esc_html_e('404', 'themescamp-core'); ?></h2>
                            <p class="error-text"><?php esc_html_e('Oops..!!! Page not found!','themescamp-core') ?></p>
                            <div class="spc-40 clearboth"></div>
                            <a class="error-btn" href="<?php echo esc_url ( home_url('/') ); ?>">
                                <?php echo esc_html_e('Go Back Now!','themescamp-core') ?>
                                <span class="content-btn-align-icon-right content-btn-button-icon">
                                    <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                </span>
                            </a>
                        </div><!--/.col-md-8-->
                    </div><!--/.row-->
                </div><!--/.container-->
            </div><!--/.content-->
        <?php
        }

    }
}

?>
