<?php
namespace ThemescampPlugin\TemplateBuilder;

use ThemescampPlugin\TemplateParts\Themescamp_Standard_Blocks;
use ThemescampPlugin\TemplateParts\Themescamp_Blogs;
use ThemescampPlugin\TemplateParts\Themescamp_Author_Template;
use ThemescampPlugin\TemplateParts\Themescamp_Search_Template;
use ThemescampPlugin\TemplateParts\Themescamp_404Template;
use ThemescampPlugin\TemplateParts\Themescamp_Port_Archive;
use ThemescampPlugin\TemplateParts\Themescamp_Post;
use ThemescampPlugin\TemplateParts\Themescamp_Portfolio;
use ThemescampPlugin\TemplateParts\Themescamp_Header;
use ThemescampPlugin\TemplateParts\Themescamp_Switcher;


defined( 'ABSPATH' ) || exit;

/**
 * Builder Frontend Class
 *
 * @since 2.0.0
 */

	global $post;
	global $tcg_theme_settings;

class Themescamp_TemplateFrontend {



    protected $is_header;
    protected $header_id;

    protected $is_footer;
    protected $footer_id;

    protected $is_megamenu;
    protected $megamenu_id;

    protected $is_popup;
    protected $popup_id;

    protected $is_offcanvas;
    protected $offcanvas_id;

    protected $is_single;
    protected $single_id;

    protected $is_archive;
    protected $archive_id;

    /**
     * Construct functions 
     */
    public function __construct() {
        add_action( 'wp', function () {
            $this->init();

            add_action( 'themescamp_head_builder', [$this, 'header'], 5 );

            add_action( 'themescamp_foot_builder', [$this, 'footer'], 5 );

            add_action( 'themescamp_megamenu', [$this, 'megamenu'], 5 );

            add_action( 'themescamp_foot_builder', [$this, 'popup'], 5 );

            add_action( 'themescamp_head_builder', [$this, 'offcanvas'], 5 );

            add_action( 'themescamp_singular', [$this, 'single'], 5 ); 

            add_action( 'themescamp_portfolio', [$this, 'portfolio'], 5 );

            add_action( 'themescamp_archive', [$this, 'archive'], 5 );

            add_action( 'themescamp_author', [$this, 'author'], 5 );

            add_action( 'themescamp_404', [$this, 'err404'], 5 );

            add_action( 'themescamp_search_', [$this, 'search'], 5 );

            add_action( 'themescamp_porto_cats', [$this, 'port_taxo_cats'], 5 );

        } );

        add_shortcode('tcg-tb-block', [$this, 'blocks_shortcode']);
    }

    /**
     * Get Frontend Template to display
     *
     * @return void
     */
    function init() {
        $this->get_settings( 'footer' );
        $this->get_settings( 'header' );
        $this->get_settings( 'megamenu' );
        $this->get_settings( 'popup' );
        $this->get_settings( 'offcanvas' );
        $this->get_settings( 'single' );
        $this->get_settings( 'archive' );
    }

    /**
     * Get frontend Templates
     *
     * @param string $type Template Type
     *
     * @return void
     */
    function get_settings( $type ) {
        $templates = $this->get_template_id( $type );
        //var_dump($templates);
        $template  = ! is_array( $templates ) ? $templates : $templates[0];

        if ( '' !== $template ) {
            switch ( $type ) {

            case 'header':
                $this->is_header = true;
                $this->header_id = $template;
                break;

            case 'footer':
                $this->is_footer = true;
                $this->footer_id = $template;
                break;

            case 'megamenu':
                $this->is_megamenu = true;
                $this->megamenu_id = $template;
                break;

            case 'popup':
                $this->is_popup = true;
                $this->popup_id = $template;
                break;

            case 'offcanvas':
                $this->is_offcanvas = true;
                $this->offcanvas_id = $template;
                break;

            case 'single':
                $this->is_single = true;
                $this->single_id = $template;
                break;
            
            case 'archive':
                $this->is_archive = true;
                $this->archive_id = $template;
                //var_dump($template);
                break;
            }
        }
    }

    /**
     * Get Item ID to display is any
     *
     * @param string $type Template Type
     *
     * @return void
     */
    public function get_template_id( $type ) {
        $templates = Themescamp_TemplateRule::instance()->get_templates_by_condition();

        foreach ( $templates as $item ) {
            if ( $item['type'] === $type ) {
                return $item['id'];


            }
        }

        return '';
    }

    /**
     * Hook Header template in page
     *
     * @return void  
     */
    public function header() {


        (new Themescamp_Switcher())->themescamp_mode();
        (new Themescamp_Switcher())->themescamp_cursor();
        (new Themescamp_Switcher())->themescamp_loader();

        
        if ( $this->is_header ) {
            $this->display( 'header' );
        }elseif(themescamp_settings('tcg_header_set')=='no_header'){

            //display nothing
        }else{
            echo '<!-- Standared header start -->';
            //Themescamp_Standard_Blocks::standard_header();
            (new Themescamp_Header());
            echo '<!-- Standared header end -->';
        }
        echo '
            <div id="smooth-wrapper">
                <div id="smooth-content">

        '; 
    }

    /**
     * Hook Footer template in page
     *
     * @return void
     */
    public function footer() {

        if ( $this->is_footer ) {
    	   $this->display( 'footer' );
        }elseif(themescamp_settings('tcg_footer_set')=='no_footer'){
            //display nothing
        }else{
            (new Themescamp_Standard_Blocks())->standard_footer();
        }
        


    }

    /**
     * Hook megamenu template in page
     *
     * @return void
     */
    public function megamenu() {

        if ( $this->is_megamenu ) {
            $this->display( 'megamenu' );
        }
    }


    /**
     * Hook popup template in page
     *
     * @return void
     */
    public function popup() {

        if ( $this->is_popup ) {
            $this->display( 'popup' );
        }
    }

    /**
     * Hook Offcanvas template in page
     *
     * @return void
     */
    public function offcanvas() {

        if ( $this->is_offcanvas ) {
            $this->display( 'offcanvas' );
        }elseif(themescamp_settings('tcg_offcanvas_set')=='no_offcanvas'){

            //display nothing
        }else{
            
            (new Themescamp_Standard_Blocks())->standard_offcanvas();
        }
    }
    /**
     * Hook Single template in page
     *
     * @return void
     */
    public function single() {

        if ( $this->is_single ) {

            echo '<!-- TCG post core builder -->';
            $this->display( 'single' );

        }else{

            echo '<!-- TCG post core options -->';
            (new Themescamp_Post());
        }
    }

    /**
     * Hook Single template in page
     *
     * @return void
     */
    public function portfolio() {

        if ( $this->is_single ) {
            $this->display( 'single' );

        }else{

            echo '<!-- TCG portfolio core options -->';
            (new Themescamp_Portfolio());
        }
    }
        /**
     * Hook Archive template in page
     *
     * @return void
     */
    public function archive() {

        if ( $this->is_archive ) {
            $this->display( 'archive' );
        }else{
            (new Themescamp_Blogs());
        }
    }

    public function author() {

        if ( $this->is_archive ) {
            $this->display( 'archive' );
        }else{
            (new Themescamp_Author_Template());
        }
    }

    public function err404() {

        if ( $this->is_single ) {
            $this->display( 'single' );
        }else{
            (new Themescamp_404Template());
        }

    }

    public function search() {

        if ($this->is_archive ) {
            $this->display( 'archive' );
        }else{
            (new Themescamp_Search_Template());
        }
    }

    public function port_taxo_cats() {

        if ( $this->is_archive ) {
            $this->display( 'archive' );
        }else{
            (new Themescamp_Port_Archive());
        }
    }


    /**
     * Display item
     *
     * @param string $type Template Type

     * @return void
     */
    public function display( $type ) {




        if ( $type === 'header' ) {
            $id = $this->header_id;
            if( $id ) {
                // Start output buffering to capture the HTML content
                ob_start();
                echo self::get_elementor_content( $id );
                $header_content = ob_get_clean();

                // Extract style tags
                $style_start = strpos($header_content, '<style>');
                $style_end = strpos($header_content, '</style>') + strlen('</style>'); // include the closing tag
                if ($style_start !== false && $style_end !== false) {
                    $style_content = substr($header_content, $style_start, $style_end - $style_start);
                    $header_content = str_replace($style_content, '', $header_content); // Remove the style from header
                    
                    // Save style content to be added in head
                    $GLOBALS['tcg_custom_header_styles'] = $style_content;
                }

                if (class_exists("\\Elementor\\Plugin")) {
                    $pluginElementor = \Elementor\Plugin::instance();
                    $contentElementor = $pluginElementor->frontend->get_builder_content($id);
                    $contentElementor = $pluginElementor->frontend->get_builder_content($id, $with_css = true);
                    echo '<header class="site-header 53">' . $contentElementor . '</header>';
                } else {
                    // Print the header content without style tags
                    echo '<header class="site-header 53">' . $header_content . '</header>';
                };
            }
        }


        if ( $type === 'footer' ) {
            $id = $this->footer_id;
            if( $id ) {
                // Start output buffering to capture the HTML content
                ob_start();
                echo self::get_elementor_content( $id );
                $footer_content = ob_get_clean();

                // Extract style tags
                $style_start = strpos($footer_content, '<style>');
                $style_end = strpos($footer_content, '</style>') + strlen('</style>'); // include the closing tag
                if ($style_start !== false && $style_end !== false) {
                    $style_content = substr($footer_content, $style_start, $style_end - $style_start);
                    $footer_content = str_replace($style_content, '', $footer_content); // Remove the style from footer
                    
                    // Save style content to be added in head
                    $GLOBALS['tcg_custom_footer_styles'] = $style_content;
                }

                // Print the footer content without style tags
                echo '<footer class="site-footer">';

                    
                    if (class_exists("\\Elementor\\Plugin")) {
                        $pluginElementor = \Elementor\Plugin::instance();
                        $contentElementor = $pluginElementor->frontend->get_builder_content($id);
                        $contentElementor = $pluginElementor->frontend->get_builder_content($id, $with_css = true);
                        echo $contentElementor;
                    } else {
                        // Print the header content without style tags
                        echo $footer_content;
                    };


                 echo '</footer>';
                 echo '</div></div> <!-- #smooth-wrapper -->';
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
        }
        
        if ( $type === 'megamenu' ) {
            $id = $this->megamenu_id;
            if( $id ) {
            ?>
            <div class="site-megamenu">

			    <?php 
			    	echo self::get_elementor_content( $id ); 
			    ?>
		    </div>
            <?php
            }
        }

        if ( $type === 'popup' ) {
            $id = $this->popup_id;
            if( $id ) {
            ?>

            <script>
            
            jQuery( document ).ready(function() {
                jQuery('.tcg-popup-close, .tcg-popup-overlay').on('click', function(){
                    jQuery(this).closest('.tcg-popup-active').removeClass('tcg-popup-active');
                    document.body.setAttribute("style","overflow:unset;");
                    if (window.gsap && window.ScrollTrigger) {
                        ScrollTrigger.refresh();
                    }
                })
            })
            </script>

                    <?php 
                        if( $id && ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
                            $content = self::get_elementor_content( $id ); 
                            self::popup_markup( $content, $id );
                        }
                    ?>

            <?php
            }
        }

        if ( $type === 'offcanvas' ) {
            $id = $this->offcanvas_id;
            if( $id ) {
                // Start output buffering to capture the HTML content
                ob_start();
                echo self::get_elementor_content( $id );
                $offcanvas_content = ob_get_clean();

                // Extract style tags
                $style_start = strpos($offcanvas_content, '<style>');
                $style_end = strpos($offcanvas_content, '</style>') + strlen('</style>'); // include the closing tag
                if ($style_start !== false && $style_end !== false) {
                    $style_content = substr($offcanvas_content, $style_start, $style_end - $style_start);
                    $offcanvas_content = str_replace($style_content, '', $offcanvas_content); // Remove the style from offcanvas
                    
                    // Save style content to be added in head
                    $GLOBALS['tcg_custom_offcanvas_styles'] = $style_content;
                }

                // Print the offcanvas content without style tags
                //echo '<offcanvas class="site-offcanvas">' . $offcanvas_content . '</offcanvas>';
            }
        }

        if ( $type === 'single' ) {
            $id = $this->single_id;
            if( $id ) {
            ?>
            <div class="site-single gg">

                <?php 
                    echo self::get_elementor_content( $id ); 
                ?>
            </div>
            <?php
            }
        }

        if ( $type === 'archive' ) {
            $id = $this->archive_id;
            if( $id ) {
            ?>
            <div class="site-archive">

                <?php 
                    echo self::get_elementor_content( $id ); 
                ?>
            </div>
            <?php
            }
        }
    }

    /**
     * Get Elementor content for display
     *
     * @param int $content_id
     */
    public static function get_elementor_content( $content_id ) {
        $content = '';
        if ( \class_exists( '\Elementor\Plugin' ) ) {
        	//echo '<!-- Elementor from tcg -->';
            $elementor_instance = \Elementor\Plugin::instance();

            $content = $elementor_instance->frontend->get_builder_content_for_display( $content_id, true );

        }
        return $content;
    }



    /**
     * Popup Markup
     *
     * @param $content
     * @param $id
     *
     * @return void
     */
    public static function popup_markup( $content, $id, $editing = false ) {
        echo '<!-- popup custom style start '.$id.' -->';

        $all_meta = get_post_meta($id);
        $container_style = '';

        if ( isset($all_meta['tcg_popup_width'][0]) && isset($all_meta['tcg_set_popup_width'][0]) ) { 
            $tcg_popup_width = maybe_unserialize($all_meta['tcg_popup_width'][0]);
            $tcg_set_popup_width = maybe_unserialize($all_meta['tcg_set_popup_width'][0]);
            
            // Initialize an empty string to store container styles.
            $container_style = '';
            
            if ( 'custom' === $tcg_popup_width && !empty($tcg_set_popup_width['width']) ) {
                $container_style .= 'width: ' . $tcg_set_popup_width['width'];
            } elseif ( 'full' === $tcg_popup_width ) {
                $container_style .= 'width: 100%;';
            }
        }

        ?>
        <div class="tcg-popup-wrapper tcg-popup-active">
            <div class="tcg-popup-overlay"></div>
            <div class="tcg-popup" style="<?php echo esc_attr( $container_style ) ?>">
                <div class="tcg-popup-close"> <i class="fa fa-close"></i> </div>

                <?php 
                    echo $content;
                ?>
            </div>
        </div>

        <?php
    }


    public function blocks_shortcode( $atts ) {
        $attr = shortcode_atts(
            [
                'id' => false,
            ],
            $atts
        );

        if ( $attr['id'] ) {
            return self::get_elementor_content( $attr['id'] );
        }
    }

 }

new Themescamp_TemplateFrontend();



