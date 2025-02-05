<?php 
namespace ThemescampPlugin\TemplateParts;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use WP_Query;

class Themescamp_Port_Archive {

    function __construct() {
        echo '<!-- TCG-Core blog -->';
        $this->post();
    }

    function post() { 
    $term = get_queried_object();

    // Define the base query arguments 
    $args = array(
        'post_type' => 'portfolio',
        'posts_per_page' => -1 // Get all posts, adjust as needed
    );

    // Check if it's a taxonomy archive for portfolio_category or porto_tag
    if (isset($term->taxonomy)) {
        if ('portfolio_category' == $term->taxonomy) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'portfolio_category',
                    'field'    => 'slug',
                    'terms'    => $term->slug,
                ),
            );
        } elseif ('porto_tag' == $term->taxonomy) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'porto_tag',
                    'field'    => 'slug',
                    'terms'    => $term->slug,
                ),
            );
        }
    }

    // Run the query
    $query = new WP_Query( $args );

        get_header();

        $tcg_blog_layout  = themescamp_settings( 'blog_sidebar_layout', 'right' );

        ?>

        <div class="content blog-wrapper portfolio-style-1">  
        <div class="container clearfix">
            <div class="row clearfix">
                <?php if ($tcg_blog_layout == 'left') { get_sidebar(); }?>

                <div class="<?php echo ($tcg_blog_layout == 'none' || !is_active_sidebar( 'main-sidebar' ) ) ? 'col-md-12' : 'col-md-8'; ?> blog-content">

                    <?php 
                    if ( $query->have_posts() ) : 
                        while ( $query->have_posts() ) : $query->the_post(); 
                            include( 'loop-portfolio.php' ); 
                        endwhile;
                        ?>
                        <ul class="pagination clearfix">
                            <li><?php previous_posts_link( esc_html__( 'Previous Page', 'themescamp-core' ) ); ?></li>
                            <li><?php next_posts_link( esc_html__( 'Next Page', 'themescamp-core' ) ); ?> </li>
                        </ul>
                        <?php
                    else :
                        echo '<p>' . esc_html__( 'No portfolios found.', 'themescamp-core' ) . '</p>';
                    endif;
                    ?>

                    <div class="spc-40 clearfix"></div>
                </div><!--/.blog-content-->
                
                <!--SIDEBAR (RIGHT)-->
                <?php if ( $tcg_blog_layout == 'right') { get_sidebar(); } ?>
                
            </div><!--/.row-->
        </div><!--/.container-->
        </div><!--/.blog-wrapper-->

        <?php 
        get_footer(); 
        wp_reset_postdata();
    }
}
?>
