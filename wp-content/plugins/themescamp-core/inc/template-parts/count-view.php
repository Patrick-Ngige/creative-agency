<?php
function themescamp_get_post_view($slug="") {
    $count = get_post_meta( get_the_ID(), 'post_views_count', true );
    if(empty($slug)){
        if($count==""){return esc_html("0");}
        else{ return esc_html($count);}
    }else{
        if($count==""){return esc_html__("0 Views", 'themescamp-core');}
        elseif($count==1){return $count.esc_html__(" View ", 'themescamp-core');}
        else{ return $count.esc_html__(" Views ", 'themescamp-core');}
    }

}
function themescamp_set_post_view() {
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta( $post_id, $key, true );
    $count++;
    update_post_meta( $post_id, $key, $count );
}

function themescamp_posts_column_views( $columns ) {
    $columns['post_views'] = esc_html__(' Views ', 'themescamp-core');
    return $columns;
}
function themescamp_posts_custom_column_views( $column ) {
    if ( $column === 'post_views') {
        echo themescamp_get_post_view();
    }
}
add_filter( 'manage_posts_columns', 'themescamp_posts_column_views' );
add_action( 'manage_posts_custom_column', 'themescamp_posts_custom_column_views' );

add_action( 'wp_head', 'themescamp_set_post_view');
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/* Function which displays your post date in time ago format */
function themescamp_time_ago() {
    return human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ).' '.__( 'ago', 'themescamp-core');
}