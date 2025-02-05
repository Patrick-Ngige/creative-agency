<?php
namespace ThemescampPlugin\TemplateParts;   

   class Themescamp_Switcher{

		function themescamp_cursor () {
			if ( themescamp_settings( 'tcg_cursor_set' ) == '1') {
				echo '<div class="mouse-cursor cursor-outer"></div>';
				echo '<div class="mouse-cursor cursor-inner"></div>';
			} elseif(themescamp_settings( 'tcg_cursor_set' ) == '2') {
                echo '<canvas class="tcg-smoke-cursor" id="tcg-smoke-cursor" data-smoke-type="'. themescamp_settings( 'tcg_cursor_smoke_type' ) .'"></canvas>';
            }
		}

		 function themescamp_mode () {

		   if ( is_front_page() && themescamp_settings( 'tcg_mode_switcher' ) =="on") { ?>
								
				<!-- Frontend dev. switcher -->
                <div class="fixed-controls">
                                        <div class="toggel-icon">
                        <i class="fal fa-gear"></i>
                    </div>
                    <div class="toggel-content-card">
                        <div class="toggel-card">
                            <h5> Cursor </h5>
                            <div class="btns" id="cursor-btns">
                                
                                <a href="#0" class="standerd"> default </a>
                                <a href="#0" class="animated active"> animated </a>
                            </div>
                        </div>
                        <div class="toggel-card">
                            <h5> Smooth scroll</h5>
                            <div class="btns" id="smooth-btns">
                                
                                <a href="#0" class="stop"> default </a>
                                <a href="#0" class="activated active"> animated </a>
                            </div>
                        </div>
                    </div>

                </div>
                <?php } 
                    if ( is_front_page() && themescamp_settings( 'tcg_feature_switcher' ) =="on") {
                 ?>

                <div class="tcg-dev-options">
                    <?php 
                    global $tcg_theme_settings;
                    $tcg_features_texts = $tcg_theme_settings['tcg_side_text'];
                    $tcg_features_links = $tcg_theme_settings['tcg_side_link'];
                    $tcg_features_imgs  = $tcg_theme_settings['tcg_side_img'];
                    
                    $num = 0;

                    foreach ($tcg_features_links as $link) {
                        $text = isset($tcg_features_texts[$num]) ? $tcg_features_texts[$num] : '';
                        $img_url = isset($tcg_features_imgs[$num]['url']) ? $tcg_features_imgs[$num]['url'] : '';
                        
                        if (!empty($link)) { ?>
                            <a href="<?php echo esc_url($link); ?>" class="item" target="_blank">
                                <?php if (!empty($img_url)) {
                                    echo '<img src="' . esc_url($img_url) . '" alt="' . esc_attr($text) . '">';
                                } ?>
                                <span class="tcg-tooltip"><?php echo esc_html($text); ?>
                                    <span class="triangle-tooltip"></span>
                                </span>
                            </a>
                        <?php }
                        $num++;
                    }?>

                </div>
			 <?php } 
		}

        function themescamp_loader () {

            $svg_html = '';
            
                if (themescamp_settings( 'tcg_preloader_set')) :  
                 $tcg_preload = themescamp_settings( 'tcg_preloader_set' ); 
                 $tcg_preloader_type = themescamp_settings( 'tcg_preloader_type' ); 
                 $tcg_preloader_logo = themescamp_settings( 'tcg_preloader_logo' );
                 $tcg_preloader_text = str_split(themescamp_settings( 'tcg_preloader_text' ));
                 $tcg_svg_url = get_template_directory_uri().'/assets/images/loader-svgs'; 
                    if ( $tcg_preloader_type == "circle" ) { 
                        $svg_html = '<div class="pre-loading"><div class="load-circle"></div></div>';
                    } else if ($tcg_preloader_type == "progress"){
                        $svg_html = '<div id="preloader"> </div>';
                    }else if ( $tcg_preloader_type == "animated_logo" ) {

                        $svg_html = '<div class="svg-pre-loading"><div class="pre-loader"> <object data="'.$tcg_svg_url.'/loader.svg" type="image/svg+xml"></object></div></div>';
                    }else if ( $tcg_preloader_type == "text-logo" ) {
                        add_filter( 'safe_style_css', function( $styles ) {
                            $styles[] = 'stop-color';
                            return $styles;
                        } );
                        $svg_html .= '
                            <div class="loader-wrap">
                                <svg viewBox="0 0 1000 1000" preserveAspectRatio="none" width="100%" height="100%">
                                    <defs>
                                    <linearGradient id="path-gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color: '. themescamp_settings( 'tcg_loader_color' ) .'" />
                                        <stop offset="100%" style="stop-color: '. themescamp_settings( 'tcg_loader_color_2' ) .'" />
                                    </linearGradient>
                                    </defs>
                                    <path id="tcg-loader-svg" d="M0,1005S175,995,500,995s500,5,500,5V0H0Z" fill="url(#path-gradient)"></path>
                                </svg>
                        
                                <div class="loader-wrap-heading">
                                    <div class="load-logo cont">
                                        <img src="'.$tcg_preloader_logo['url'].'" alt="" class="">
                                    </div>
                                    <div class="load-text">
                        ';
                        foreach($tcg_preloader_text as $char) {
                            $svg_html .= '<span>'.$char.'</span>';
                        }
                        $svg_html .= '
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                    $allow_html= 
                        array(
                            'div' => array(
                                'class'  => array(),
                                'id'     => array(),
                            ), 
                            'img' => array(
                                'class'  => true,
                                'id'     => true,
                                'src'     => true,
                                'alt'     => true,
                            ), 
                            'span' => array(
                                'class'  => true,
                                'id'     => true,
                            ), 
                            'stop' => array(
                                'offset'  => true,
                                'style'     => true,
                            ),
                            'defs' => array(),
                            'lineargradient' => array(
                                'id'       => true,
                                'x1'       => true,
                                'x2'       => true,
                                'y1'       => true,
                                'y2'       => true,
                            ),
                            'svg'     => array(
                                'viewBox' => true,
                                'id'          => true,
                                'id'          => true,
                                'class'       => true,
                                'xmlns'       => true,
                                'width'       => true,
                                'height'      => true,
                                'preserveaspectratio' => true,
                                'viewbox'     => true,
                                'aria-hidden' => true,
                                'role'        => true,
                                'focusable'   => true,
                            ),
                            'path'    => array(
                                'fill'      => true,
                                'stroke'    => true,
                                'stroke-miterlimit' => true,
                                'fill-rule' => true,
                                'd'         => true,
                                'id'         => true,
                                'transform' => true,
                                'class'     => true,
                                'stroke-width' => true,
                            ),
                            'object'=> array(
                                'data'=> array(
                                    array(
                                        'svg'     => array(
                                            'class'       => true,
                                            'xmlns'       => true,
                                            'width'       => true,
                                            'height'      => true,
                                            'preserveAspectRatio' => true,
                                            'viewbox'     => true,
                                            'aria-hidden' => true,
                                            'role'        => true,
                                            'focusable'   => true,
                                        ),
                                        'path'    => array(
                                            'fill'      => true,
                                            'stroke'    => true,
                                            'stroke-miterlimit' => true,
                                            'fill-rule' => true,
                                            'd'         => true,
                                            'transform' => true,
                                            'class'     => true,
                                            'stroke-width' => true,
                                        ),
                                        'polygon' => array(
                                            'fill'      => true,
                                            'fill-rule' => true,
                                            'points'    => true,
                                            'transform' => true,
                                            'focusable' => true,
                                        ),
                                        'style' => array(
                                            'data-made-with'   => true,
                                        ),
                                    ),
                                ),
                                'type'=> array(),
                            ),
                        );

                     if ($tcg_preload == 'show_home') {  ?> 
                        <?php  if (is_front_page() ){ echo wp_kses($svg_html,$allow_html); }     
                    } else if ($tcg_preload == 'show_all') {echo wp_kses($svg_html,$allow_html); } 
                endif ;
             
        }



   }
?>