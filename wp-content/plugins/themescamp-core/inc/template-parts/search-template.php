<?php 
namespace ThemescampPlugin\TemplateParts;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Themescamp_Search_Template {

    function __construct() {
        
        echo '<!-- TCG-Core Search -->';
        $this->post();
    }

    function post() { 
        
     $tcg_search_layout  = themescamp_settings( 'search_sidebar_layout', 'right' );  ?>
    
    <div class="content blog-wrapper">  
        <div class="container clearfix">
             <div class="row clearfix">
                <?php if ($tcg_search_layout =='left') { get_sidebar(); }?>
                <div class="<?php if ($tcg_search_layout== 'none' || !is_active_sidebar( 'main-sidebar' ) ){ 
                    echo 'col-md-12';
                }else{echo 'col-md-8';} ?> blog-content">

                    <h3 class="search-title">
                        <?php 
                        $archive_title=sprintf(
                            '%1$s %2$s',
                            '<span class="color-accent">' . esc_html_e( 'Search result for:', 'themescamp-core' ) . '</span>',
                            '&ldquo;' . get_search_query() . '&rdquo;'
                        );
                        echo wp_kses_post( $archive_title ); 
                        ?>
                    </h3>
                    <!--BLOG POST START-->
                    <?php if ( have_posts() ) : ?>
                    
                    <?php while (have_posts()) : the_post(); get_template_part( 'template-parts/loop', 'post' ); endwhile  ?>
                    
                    <?php  else: ?>
                    <p><?php esc_html_e('We could not find any results for your search. You can give it another try through the search form below.','themescamp-core'); ?></p> 
                    <div class="no-search-results-form">
                        <?php $tcg_unique_id = themescamp_unique_id( 'search-form-' ); ?>
                        <form role="search" method="get" id="<?php echo esc_attr( $tcg_unique_id ); ?>" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <input type="search" class="focus-input" placeholder="<?php echo esc_attr__('Type search keyword...','themescamp-core'); ?>" value="<?php get_search_query()?>" name="s">
                            <input type="submit" class="searchsubmit" value=""> 
                        </form>
                    </div>
                    <?php endif; ?>
                    <!--BLOG POST END-->
                    
                    <ul class="pagination clearfix">
                        <li><?php  previous_posts_link();  ?></li>
                        <li><?php next_posts_link(); ?> </li>
                    </ul>
                    <div class="spc-40 clearfix"></div>
                </div><!--/.col-md-8-->
                
            <!--SIDEBAR (RIGHT)-->
            <?php if ( $tcg_search_layout =='right') {get_sidebar();} ?>

             </div><!--/.row-->
        </div><!--/.container-->
    </div><!--/.blog-wrapper-->
    
<?php

    }
}

?>
