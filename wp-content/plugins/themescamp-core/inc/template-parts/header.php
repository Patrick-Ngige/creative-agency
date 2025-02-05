<?php 
namespace ThemescampPlugin\TemplateParts;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Themescamp_Header {

    function __construct() {
        //fallback to the default page template  
        $this->post();
    }

    function post() { ?>

        <div class="default-header clearfix tcg-core">
            <nav class="header apply-header not-custom-menu clearfix  <?php if ( themescamp_settings( 'tcg_header_position' ) =='head_trans'){ echo 'custom-absolute-menu';}else{ echo 'white-header';}?> shadow-header .">
                <div class="nav-box">
                    <div class="stuck-nav">
                        <div class="header-top d-none d-md-block" > <!-- hidden-xs hidden-sm -->
                            <div class="container-fluid">
                                <div class="col"> 
                                    <?php 
                                            if ( themescamp_settings( 'tcg_header_enable_topmenu' ) == 'on' && themescamp_settings( 'tcg_header_phone') ) :  ?>
                                    <h6><i class="fa fa fa-mobile-phone"> </i><?php echo esc_attr( themescamp_settings( 'tcg_header_phone')); ?></h6>
                                    <?php endif; ?>

                                    <?php 
                                            if ( themescamp_settings( 'tcg_header_enable_topmenu' ) == 'on' && themescamp_settings( 'tcg_header_mail') ) :  ?>
                                    <h6><i class="fa fa fa-envelope-o"> </i><?php echo esc_attr( themescamp_settings( 'tcg_header_mail')); ?></h6>
                                    <?php endif; ?>

                                    <?php 
                                            if ( themescamp_settings( 'tcg_header_enable_topmenu' ) == 'on' && themescamp_settings( 'tcg_header_address') ) :  ?>

                                    <h6><i class="fa fa fa-map-marker"> </i><?php echo esc_attr( themescamp_settings( 'tcg_header_address')); ?></h6>
                                    <?php endif; ?>

                                    <?php 
                                            if ( themescamp_settings( 'tcg_header_enable_topmenu' ) == 'on' && themescamp_settings( 'tcg_header_join') ) :  ?>
                                    <h6 class="pull-right"><a href="<?php  echo esc_url( themescamp_settings( 'tcg_header_joinlink') ); ?>"> <i class="fa fa-user"> </i><?php echo esc_attr( themescamp_settings( 'tcg_header_join')); ?></a></h6>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                         <div class="container-fluid">


                            <?php 

                                   
                                /*
                                * LOGO
                                * Header Menu Loop
                                */
                                global $tcg_theme_settings;
                                global $post;   
                                
                                    $logo_height= themescamp_settings('tcg_logo_dim');
                                    $logo_height = $logo_height['height'];
                                    $logo_height_css = 'height:'.$logo_height;
                                    $logo_height_style = !empty($logo_height_css) ? ' style='.$logo_height_css : ''; 

                                    
                                    $tcg_header_logo_light= themescamp_settings('tcg_header_logo_light');
                                    //var_dump($tcg_header_logo_light);
                                    //$tcg_header_logo_light= $tcg_header_logo_light['url']; 

                                    $tcg_header_logo_light = isset($tcg_header_logo_light['url']) && $tcg_header_logo_light['url'] ? $tcg_header_logo_light['url'] : '';


                                    $tcg_header_logo_drk= themescamp_settings('tcg_header_logo_drk');
                                    $tcg_header_logo_drk = isset($tcg_header_logo_drk['url']) && $tcg_header_logo_drk['url'] ? $tcg_header_logo_drk['url'] : '';
                                
                            ?> 

                                <div class="top-logo <?php echo '33 '.$tcg_header_logo_light;?>"> 
                                    <?php if( !empty($tcg_header_logo_light) && !empty($tcg_header_logo_drk) ): ?>
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"> 
                                            <?php if ( themescamp_settings( 'tcg_header_position' ) =='head_trans'){ ?> 
                                                <img alt="<?php esc_attr_e ('Logo','themescamp-core'); ?>" class="logo1 logo-l-mode 1" <?php echo esc_html($logo_height_style); ?> 
                                                        src="<?php  echo esc_url($tcg_header_logo_light); ?>">

                                                <img alt="<?php esc_attr_e ('Logo','themescamp-core'); ?>" class="logo1 logo-d-mode 2" <?php echo esc_html($logo_height_style); ?> 
                                                        src="<?php  echo esc_url($tcg_header_logo_drk); ?>">

                                                
                                                <?php } else { ?>


                                                <img alt="<?php esc_attr_e ('Logo','themescamp-core'); ?>" class="logo1 logo-dark 3 " <?php echo esc_html($logo_height_style); ?> 
                                                        src="<?php  echo esc_url($tcg_header_logo_drk); ?>"> 

                                                <img alt="<?php esc_attr_e ('Logo','themescamp-core'); ?>" class="logo1 logo-white 4" <?php echo esc_html($logo_height_style); ?> 
                                                    src="<?php  echo esc_url($tcg_header_logo_light); ?>">

                                            <?php } ?>    
                                        </a>
                                    <?php else:?> <p class="site-title"><a href='<?php echo esc_url( home_url( '/' ) ); ?>' rel="home"><?php bloginfo( 'name' ); ?></a></p> 
                                    <?php endif; ?>
                                </div><!--End Logo-->




  
                            
                            <div class="header-wrapper <?php  if (  (themescamp_settings( 'tcg_menu_position' ) =='center')) { echo 'dflex';}?> d-none d-md-block" > <!-- hidden-xs hidden-sm -->
                                <div class="main-menu menu-wrapper"> 
                                    <?php themescamp_custom_menu_page ('tcg_header_menu');  ?>
                                </div><!-- End menu-wrapper -->




                                    <?php
                                    /*
                                    * ICONS
                                    * Header Menu Loop
                                    */
                                    global $tcg_theme_settings;
                                    global $post;  
                                    
                                        $logo_height= themescamp_settings('tcg_logo_dim');
                                        $logo_height = $logo_height['height'];
                                        $logo_height_css = 'height:'.$logo_height;
                                        $logo_height_style = !empty($logo_height_css) ? ' style='.$logo_height_css : ''; 
                                    
                                    ?> 



                                        <ul class="header-icon d-none d-md-block 34">  <!-- hidden-sm hidden-xs --> 

                                        <?php 
                                            $tcg_open_social_new_tab  = themescamp_settings( 'tcg_header_social_new_tab', 'on' );
                                            if($tcg_open_social_new_tab == 'on'):
                                                $open_new_tab = ' target="_blank"'; 
                                            else:
                                                $open_new_tab = ''; 
                                            endif; ?>

                                            <?php 
                                                if ( themescamp_settings( 'tcg_header_enable_social' ) == 'on' && themescamp_settings( 'tcg_header_facebook') ) :  ?>
                                                    <li>
                                                        <a href="<?php  echo esc_url( themescamp_settings( 'tcg_header_facebook' ) ); ?>" <?php echo esc_attr($open_new_tab); ?>>
                                                            <i class="fab fa-facebook-f"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; 
                                            ?>

                                            <?php 
                                                if ( themescamp_settings( 'tcg_header_enable_social' ) == 'on' && themescamp_settings( 'tcg_header_twitter' ) ) :  ?>
                                                    <li>
                                                        <a href="<?php  echo esc_url( themescamp_settings( 'tcg_header_twitter' ) ); ?>" <?php echo esc_attr($open_new_tab); ?>>
                                                            <i class="fab fa-x-twitter"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; 
                                            ?>

                                            <?php 
                                                if ( (themescamp_settings( 'tcg_header_enable_social' ) == 'on') && themescamp_settings( 'tcg_header_instagram' ) ) :  ?>
                                                    <li>
                                                        <a href="<?php  echo esc_url( themescamp_settings( 'tcg_header_instagram' ) ); ?>" <?php echo esc_attr($open_new_tab); ?>>
                                                            <i class="fab fa-instagram"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; 
                                             ?>

                                            <?php 
                                                if ( themescamp_settings( 'tcg_header_enable_social' ) == 'on' && themescamp_settings( 'tcg_header_pinterest') ) :  ?>
                                                    <li>
                                                        <a href="<?php  echo esc_url(themescamp_settings( 'tcg_header_pinterest') ); ?>" <?php echo esc_attr($open_new_tab); ?>>
                                                            <i class="fab fa-pinterest"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; 
                                             ?>

                                            <?php 
                                                if ( themescamp_settings('tcg_header_enable_social') == 'on' && themescamp_settings( 'tcg_header_xing')) :  ?>
                                                    <li>
                                                        <a href="<?php  echo esc_url( themescamp_settings( 'tcg_header_xing') ); ?>" <?php echo esc_attr($open_new_tab); ?>>
                                                            <i class="fab fa-xing"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; 
                                             ?>

                                            <?php 
                                                if ( themescamp_settings('tcg_header_enable_social') == 'on' && themescamp_settings( 'tcg_header_linkedin')) :  ?>
                                                    <li>
                                                        <a href="<?php  echo esc_url( themescamp_settings( 'tcg_header_linkedin') ); ?>" <?php echo esc_attr($open_new_tab); ?>>
                                                            <i class="fab fa-linkedin-in"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; 
                                             ?>

                                            <?php 
                                                if ( themescamp_settings('tcg_header_enable_social') == 'on' && themescamp_settings( 'tcg_header_youtube')) :  ?>
                                                    <li>
                                                        <a href="<?php  echo esc_url( themescamp_settings( 'tcg_header_youtube') ); ?>" <?php echo esc_attr($open_new_tab); ?>>
                                                            <i class="fab fa-youtube"></i>
                                                        </a>
                                                    </li>
                                                <?php endif; 
                                             ?>

                                        </ul><!-- top Socials -->



                                <div class="search-icon-header d-none d-md-block" > <!-- hidden-xs hidden-sm -->
                                    <?php  if ( (themescamp_settings( 'tcg_header_search' ) =='on')) { ?>
                                    <a class="search"  href="#">
                                        <i class="fa fa-search"></i>
                                    </a>
                                    <div class="black-search-block">
                                        <div class="black-search-table">
                                            <div class="black-search-table-cell">
                                                <div>
                                                    <?php $tcg_unique_id = wp_unique_id( 'search-form-' ); ?>
                                                    <form role="search" method="get" id="<?php echo esc_attr( $tcg_unique_id ); ?>" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                                        <input type="search" class="focus-input" placeholder="<?php echo esc_attr__('Type search keyword...','themescamp-core'); ?>" value="<?php get_search_query()?>" name="s">
                                                        <input type="submit" class="searchsubmit" value="">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="close-black-block"><a href="#"><i class="fa fa-times"></i></a></div>
                                    </div>
                                    <?php } ?>                      

                                    <?php  if ( (themescamp_settings( 'tcg_header_btn' ) =='on')) { ?>

                                    <?php if ( themescamp_settings( 'tcg_menu_btn') && themescamp_settings( 'tcg_menu_btn_url') ) { ?>

                                        <div class="btn-nav-top">
                                            <a  href="<?php  echo esc_url( themescamp_settings( 'tcg_menu_btn_url') ); ?>">
                                            <?php echo esc_attr( themescamp_settings( 'tcg_menu_btn')); ?>
                                             </a>
                                        </div>


                                    <?php } ?>
                                    <?php }?>
                                </div>
                                
                            </div><!-- header-wrapper -->  

                            <div class="mobile-wrapper d-block d-md-none "> <!-- hidden-lg hidden-md -->
                                <a href="#" class="hamburger"><div class="hamburger__icon"></div></a>
                                <div class="fat-nav">
                                    <div class="fat-nav__wrapper">
                                        <div class="fat-list"> <?php themescamp_custom_flat_menu_page ('tcg_header_menu'); ?></div>
                                    </div>
                                </div>
                            </div><!-- End mobile-wrapper -->  
                            
                        </div><!-- container-fluid -->  
                    </div><!-- stuck-nav -->
                </div><!-- nav-box -->
            </nav><!-- header -->
        </div>


        <?php
    }
}

?>
