<?php
/**
 * Blog Post Loop
 */
global $post
?>

<!--BLOG POST START-->      
<article id="post-<?php  the_ID(); ?>" <?php  post_class('clearfix blog-post border-bottom brd-gray pb-30 mb-30'); ?>> 
<div class="row">
 
	<!--if post is standard-->
	<div class="col-lg-5">
		<?php  if ( get_post_meta($post->ID, 'post_format', true) == '' && has_post_thumbnail()){
			echo' <div class="post-img">';
				echo'<div class="img-post">';
					the_post_thumbnail(); 
				echo'</div>';
			echo'</div>';
		}
		
		if ( get_post_meta($post->ID, 'post_format', true) == 'post_standard'){
			the_post_thumbnail( 'full', array( 'class' => 'full-size-img' ) );
			//post is gallery
		} else if ( get_post_meta($post->ID, 'post_format', true) == 'post_gallery'){ 
			echo '<div class="blog-gallery clearboth clearfix">';
				$tcg_image_ids = get_post_meta(get_the_ID(), 'post_gallery_setting', true);
				$tcg_image_ids = explode( ',', $tcg_image_ids );
				foreach( $tcg_image_ids as $tcg_image_id ) {
					$tcg_image_title  = get_the_title( $tcg_image_id );
					$tcg_image_port = wp_get_attachment_image( $tcg_image_id, 'full' );
					$tcg_imageurl     =   wp_get_attachment_url( $tcg_image_id ); 
					echo '<div>
						<a class="blog-popup-img" href="' . esc_url( $tcg_imageurl ) . '">
							<span>
							<i class="fa fa-search"></i>
							</span>
							' . $tcg_image_port . '
						</a>
					</div>';
				} 
			echo'</div>';

		
		//if post is slider
		} else if ( get_post_meta($post->ID, 'post_format', true) == 'post_slider'){ ?>
		
			<div class="blog-slider ani-slider slider" data-slick='{"autoplaySpeed":<?php if (  themescamp_settings( 'tcg_blog_slide_delay' ) !='' ){echo esc_attr ( themescamp_settings( 'tcg_blog_slide_delay' ));} else {echo '8000'; } ?> }'>
				<?php $tcg_simage_ids = get_post_meta(get_the_ID(), 'post_slider_setting', true);
				$tcg_simage_ids = explode( ',', $tcg_simage_ids );
				foreach( $tcg_simage_ids as $tcg_simage_id ) {
					$tcg_simage_port = wp_get_attachment_image( $tcg_simage_id, 'full' );
					$tcg_simageurl =  esc_url( wp_get_attachment_url( $tcg_simage_id )); ?>
					<div class="slide">
						<div class="slider-mask" data-animation="slideLeftReturn" data-delay="0.1s">
						</div>
						<div class="slider-img-bg blog-img-bg" data-animation="fadeIn" data-delay="0.2s" data-animation-duration="0.7s"data-background="<?php echo esc_url($tcg_simageurl); ?>">
						</div>
						<div class="blog-slider-box">
							<div class="slider-content"></div>
						</div><!--/.blog-slider-box-->
					</div><!--/.slide-->
				<?php }
			echo'</div>'; 

		//if post video 
		} else if ( get_post_meta($post->ID, 'post_format', true) == 'post_video'){

			echo'<div class="video"><iframe width="560" height="315" src="'.esc_attr( get_post_meta($post->ID, 'post_video_setting', true)).'?wmode=opaque;rel=0;showinfo=0;controls=0;iv_load_policy=3"></iframe></div>';
					
		//if post audio
		} else if ( get_post_meta($post->ID, 'post_format', true) == 'post_audio'){ ?>
			<div class="audio">
				<?php $tcg_audio =get_post_meta($post->ID, 'post_audio_setting', true);
				echo wp_kses( $tcg_audio, array( 
					'iframe' => array(
						'src' => array(),
						'width' => array(),
						'height' => array(),
						'scrolling' => array(),
						'frameborder' => array(),
					),
				) ); ?>
			</div>
		<?php }?>
	</div>

	<div class="col-lg-7">
		<div class="post-details">

			<ul class="post-detail">

					<?php if(has_category()) { ?> 
							<li class="post-cat">
								<?php the_category(', '); ?>
							</li>
						<?php }?>

					<li class="post-date"><i class="bi bi-clock me-1"></i> <?php echo esc_html(themescamp_time_ago()); ?> </li>  	


					<?php 
					if ( themescamp_settings( 'tcg_blog_tags' ) =="on") {
						if(get_the_tag_list()) { ?>  
							<li>
								<i class="lnr lnr-tag"></i><?php the_tags('', ', '); ?>
							</li>
						<?php
						} 
					}
					?> 
			</ul>
			<a href="<?php the_permalink(); ?>">
				<h3 class="entry-title"><?php the_title(); ?></h3>
			</a>

			<p class="excerpt">
				<?php 
					$excerpt = get_the_excerpt();
					$excerpt_size = themescamp_settings( 'excerpt_size');
					$excerpt = substr($excerpt, 0, $excerpt_size);
					echo esc_attr($excerpt.' [...]');
				?>
			</p>
			<ul class="post-detail post-bot">
				<li class="post-auth"><i class="lnr lnr-user fw-600"></i> <?php the_author_posts_link(); ?> </li>

				<li>
					<div class="com" >
					<i class="bi bi-chat-left-text me-1"></i>  
						<?php 
						if(get_comments_number()==1){
						echo esc_attr($post->comment_count); 
						}else{
							echo esc_attr($post->comment_count); 
							}
						?>
					</div>
					<div class="count"> <i class="bi bi-eye me-1"></i> <?php echo esc_html( themescamp_get_post_view()); ?> </div> 
				</li>
				
			</ul>

			<div class="spc-10 clearfix"></div>
			<?php if ( themescamp_settings( 'tcg_blog_button' ) =="on") { ?>
				<a class="content-btn tcg-gradient-border" href="<?php the_permalink(); ?>">
					<?php echo esc_html_e(themescamp_settings( 'tcg_blog_button_text' ),'themescamp-core') ?>
					<span class="content-btn-align-icon-right content-btn-button-icon">
						<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
					</span>
				</a>
			<?php } ?>
		</div>
	</div>
</div>
</article><!--/.blog-post-->
<!--BLOG POST END-->
