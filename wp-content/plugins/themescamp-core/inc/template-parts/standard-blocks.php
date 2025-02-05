<?php 
namespace ThemescampPlugin\TemplateParts;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly  

class Themescamp_Standard_Blocks {

    public function standard_footer() { 

            $tcg_footer_logo_white= themescamp_settings('tcg_footer_logo_white'); 

        ?>

        <!-- display optional footer  --> 
        <footer class="footer tcg-core">
            <div class="container-fluid">
                
                <?php if ( !empty($tcg_footer_logo_white['url']) ) : ?>
                    <img class="footer-img" src="<?php echo esc_url ( $tcg_footer_logo_white['url']); ?>" alt="<?php esc_attr_e ('LogoWhite','themescamp-core'); ?>">
                <?php endif; ?>

                <div class="clearboth clearfix"></div>

                <ul class="footer-icon d-none d-md-block">  <!-- hidden-sm hidden-xs -->
                    <?php 
                        if ( themescamp_settings( 'tcg_footer_enable_social' ) == true && themescamp_settings( 'tcg_footer_facebook' )) : ?>
                            <li><a href="<?php  echo esc_url( themescamp_settings( 'tcg_footer_facebook' ) ); ?>">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    

                    <?php 
                        if ( themescamp_settings( 'tcg_footer_enable_social' ) == true && themescamp_settings( 'tcg_footer_twitter' ) ) : ?>
                            <li>
                                <a href="<?php  echo esc_url(themescamp_settings( 'tcg_footer_twitter' )); ?>">
                                    <i class="fab fa-x-twitter"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    

                    <?php 
                            if (themescamp_settings('tcg_footer_enable_social') == true && themescamp_settings( 'tcg_footer_instagram' )) :  ?>
                                <li>
                                    <a href="<?php  echo esc_url(themescamp_settings( 'tcg_footer_instagram' )); ?>">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                    

                    <?php 
                            if (themescamp_settings('tcg_footer_enable_social') == true && themescamp_settings( 'tcg_footer_pinterest')) :  ?>
                                <li>
                                    <a href="<?php  echo esc_url(themescamp_settings( 'tcg_footer_pinterest') ); ?>">
                                        <i class="fab fa-pinterest"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                    

                    <?php
                            if ( themescamp_settings( 'tcg_footer_enable_social' ) == true && themescamp_settings( 'tcg_footer_xing' ) ) : ?>
                                <li>
                                    <a href="<?php  echo esc_url(themescamp_settings( 'tcg_footer_xing') ); ?>">
                                        <i class="fab fa-xing"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                    

                    <?php 
                            if ( themescamp_settings( 'tcg_footer_enable_social' ) == true && themescamp_settings( 'tcg_footer_linkedin' ) ) : ?>
                                <li>
                                    <a href="<?php  echo esc_url(themescamp_settings( 'tcg_footer_linkedin') ); ?>">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                    
                </ul><!-- /.footer-icon -->

                <?php 
                $footer_default_text = '<p>' . sprintf( esc_html__( 'Copyright %s by ThemesCamp All Rights Reserved.', 'themescamp-core' ), date('Y') ) . '</p>';

                // Apply filter to replace the specific footer text
                $footer_default_text = apply_filters('tcg_footer_text', $footer_default_text);

                if ( themescamp_settings( 'tcg_footer_text' ) ) { 
                    $tcg_footer_text = themescamp_settings( 'tcg_footer_text' );
                    echo wp_kses_post( $tcg_footer_text ); 
                } else {
                    echo $footer_default_text;
                } 
                ?>

            </div><!--/.container-fluid-->
        </footer><!--/.footer--> 
        <?php echo '</div> <!-- tcg-smooth-wrapper -->';
        
        $tcg_backtotop = themescamp_settings( 'tcg_backtotop_set' );
        if ($tcg_backtotop == 'show_home') {
            if (is_front_page() ){
                echo '
                    <!--to top button-->
                    <div class="progress-wrap cursor-pointer">
                        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
                        </svg>
                    </div>
                ';
            };
        } else if ($tcg_backtotop == 'show_all') {
            echo '
                <!--to top button-->
                <div class="progress-wrap cursor-pointer">
                    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                    <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
                    </svg>
                </div>
            ';
        };

    }

    public function standard_offcanvas() { 

        //custom side panel 
        if ( themescamp_settings( 'tcg_offcanvas_set')) { 
            echo'<div class="side-panel">';
            echo'<div class="close-black-block-offcanvas"><a href="#"><i class="fa fa-times"></i></a></div>';
            //do_action('tcg-custom-offcanvas','themescamp_offcanvas_start'); 
            do_action( "themescamp_offcanvas" );
            echo'</div>';
        }



    }


}

?>
