<?php
get_header(); // Gets the header.php file

if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); 
        the_title(); // Displays the title of the post
        the_content(); // This is the crucial part for Elementor
    endwhile; 
else : 
    echo 'No posts found';
endif;

get_footer(); // Gets the footer.php file
?>
