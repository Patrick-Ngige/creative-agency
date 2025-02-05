<?php 
/*
* Read more blog button
*/
add_action ('wp_ajax_nopriv_tcg_load_more', 'tcg_load_more');
add_action ('wp_ajax_tcg_load_more', 'tcg_load_more');

function tcg_load_more(){

	$style = themescamp_settings( 'tcg_blog_article_layout' );

	$paged=$_POST["page"]+1;
	$query=new WP_Query(array(
		'post_type'=>'post',
		'post_status'=>'publish',
		'paged'=>$paged

	));

	if($query->have_posts()):
		while($query->have_posts()): $query->the_post();
			if($style=='3'):
				require_once('template-parts/loop-3.php');
			else:
				require_once('template-parts/loop-post.php');
			endif;
		endwhile;
	endif;
	wp_reset_postdata();
	die();

}

