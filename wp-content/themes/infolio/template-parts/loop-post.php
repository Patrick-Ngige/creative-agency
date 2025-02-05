<?php
/**
 * Blog Post Loop
 */
?>
<!--BLOG POST START-->      
<article id="post-<?php  the_ID(); ?>" <?php  post_class('clearfix blog-post'); ?>> 
 
	<!--if post is standard-->
	
	<?php  if ( get_post_meta($post->ID, 'post_format', true) == '' && has_post_thumbnail()){
		echo'<div class="img-post">';
		the_post_thumbnail(); 
		echo'</div>';
	}

	if ( get_post_meta($post->ID, 'post_format', true) == 'post_standard'){
		the_post_thumbnail( 'full', array( 'class' => 'full-size-img' ) );
		//post is gallery
	} else if ( get_post_meta($post->ID, 'post_format', true) == 'post_gallery'){ 
		echo '<div class="blog-gallery clearboth clearfix">';
			$infolio_image_ids = get_post_meta(get_the_ID(), 'post_gallery_setting', true);
			$infolio_image_ids = explode( ',', $infolio_image_ids );
			foreach( $infolio_image_ids as $infolio_image_id ) {
				$infolio_image_title  = get_the_title( $infolio_image_id );
				$infolio_image_port = wp_get_attachment_image( $infolio_image_id, 'full' );
				$infolio_imageurl     =   wp_get_attachment_url( $infolio_image_id ); 
				echo '<div>
					<a class="blog-popup-img" href="' . esc_url( $infolio_imageurl ) . '">
						<span>
						<i class="fa fa-search"></i>
						</span>
						' . $infolio_image_port . '
					</a>
				</div>';
			} 
		echo'</div>';
	
	}  ?>

	<a href="<?php the_permalink(); ?>">
		<h3 class="entry-title"><?php the_title(); ?></h3>
	</a>

	<ul class="post-detail">
			<li>
				<i class="lnr lnr-user fw-600"></i> <?php the_author_posts_link(); ?> 
			</li>
			<li>
				<i class="lnr lnr-history"></i> <?php echo get_the_date(); ?> 
			</li>
		<?php if(has_category()) { ?> 
			<li>
				<i class="lnr lnr-book"></i> <?php the_category(', '); ?>
			</li>
		<?php }?>

		<?php if(get_the_tag_list()) { ?>  
			<li>
				<i class="lnr lnr-tag"></i><?php the_tags('', ', '); ?>
			</li>
		<?php }?>

			<li>
				<i class="lnr lnr-bubble"></i> 
  					<?php 
  					if(get_comments_number()==1){
  					echo esc_attr($post->comment_count).esc_attr__(' Comment','infolio'); 
  					}else{
						echo esc_attr($post->comment_count).esc_attr__(' Comments','infolio'); 
						}
  					?>
			</li> 
	</ul>

	<div class="spc-20 clearfix"></div>
	<?php the_excerpt(); ?>
	<div class="spc-10 clearfix"></div>
	<a class="content-btn infolio-gradient-border" href="<?php the_permalink(); ?>">
		<?php echo esc_html_e('Continue Reading','infolio') ?>
		<span class="content-btn-align-icon-right content-btn-button-icon">
			<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
		</span>
	</a>
	<div class="border-post clearfix"></div>
	<div class="clearboth spc-40"></div>
</article><!--/.blog-post-->
<!--BLOG POST END-->