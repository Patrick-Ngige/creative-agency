<?php
/*
Themescamp Custom Post
*/
get_header(); ?>
        
    <?php while (have_posts()) : the_post(); ?>
        
        <div class="tcg-custom-post clearfix">
            <?php 
            $template_type = get_post_meta( $post->ID, 'template_type', true );

            if ( 'popup' === $template_type ) { 
                echo '<div class="tcg-popup-wrapper tcg-popup-active-editor">
                <div class="tcg-popup-overlay"></div>
                <div class="tcg-popup">
                    <div class="tcg-popup-close"> <i class="eicon-close"></i> </div>';

                        the_content();

                    echo '</div></div>';
            } else{

                the_content(); 
            }

            ?>
        </div>

    <?php endwhile; ?>
        
<?php  get_footer(); ?>