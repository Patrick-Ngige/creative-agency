<?php
/*
Single Header
*/
get_header(); ?>
    
    <?php while (have_posts()) : the_post(); ?>
        
        <div class="tcg-custom-header clearfix">
            <?php the_content(); ?>
        </div>

    <?php endwhile; ?>
        
<?php  get_footer(); ?>