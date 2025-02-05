

<!--Post style 2-->      
<?php 
	global $post;
	$tcg_single_layout  = themescamp_settings( 'tcg_single_sidebar_layout', 'right' );  
	$featured_image_type  = themescamp_settings( 'featured_image_type', 'default' ); 
?>
<div class="content blog-wrapper">  
	<div class="container clearfix">
		<div class="row clearfix">
		<?php if ($tcg_single_layout =='left') { (new Themescamp_Sidebars()); }?>

		<div class="<?php if ($tcg_single_layout== 'none' || !is_active_sidebar( 'main-sidebar' ) ){ 
			echo 'col-md-12';
		}else{echo 'col-md-8';} ?> blog-content">

				<!--BLOG POST START-->
				<?php while (have_posts()) : the_post(); ?>

					<article id="post-<?php  the_ID(); ?>" <?php  post_class('clearfix blog-post'); ?>>
						<!--if post is standard-->
						<?php  
							if ($featured_image_type =='default') {
								if ( get_post_meta($post->ID, 'post_format', true) == ''){ the_post_thumbnail(); }
							 }
						?>
						<?php  if ( get_post_meta($post->ID, 'post_format', true) == 'post_standard'){ ?>
							<?php the_post_thumbnail( 'full', array( 'class' => 'full-size-img' ) );?>
							<!--if post is gallery-->
						<?php } else if ( get_post_meta($post->ID, 'post_format', true) == 'post_gallery'){ 
							echo '<div class="blog-gallery clearboth clearfix">';
								$tcg_image_ids = get_post_meta(get_the_ID(), 'post_gallery_setting', true);
								$tcg_image_ids = explode( ',', $tcg_image_ids );
								foreach( $tcg_image_ids as $tcg_image_id ) {
									$tcg_image_title  = get_the_title( $tcg_image_id );
									$tcg_image_port = wp_get_attachment_image( $tcg_image_id, 'full' );
									$tcg_imageurl     =  wp_get_attachment_url( $tcg_image_id ); 
									echo '<div>
										<a class="blog-popup-img" href="' . esc_url( $tcg_imageurl) . '">
											<span>
												<i class="fa fa-search"></i>
											</span>
											' . $tcg_image_port . '
										</a>
									</div>';
								} 
							echo'</div>';

							//if post is slider 
						}else if ( get_post_meta($post->ID, 'post_format', true) == 'post_slider'){ ?>

							<div class="blog-slider ani-slider slider" data-slick='{"autoplaySpeed":<?php if (  themescamp_settings( 'tcg_blog_slide_delay' ) !='' ){
								echo esc_attr ( themescamp_settings( 'tcg_blog_slide_delay' ));} else {echo '8000'; } ?> }'>

								<?php $tcg_simage_ids = get_post_meta(get_the_ID(), 'post_slider_setting', true);
								$tcg_simage_ids = explode( ',', $tcg_simage_ids );
								foreach( $tcg_simage_ids as $tcg_simage_id ) {
									$tcg_simage_port = wp_get_attachment_image( $tcg_simage_id, 'full' );
									$tcg_simageurl     =  esc_url( wp_get_attachment_url( $tcg_simage_id )); ?>
									<div class="slide">
										<div class="slider-mask" data-animation="slideLeftReturn" data-delay="0.1s"></div>
										<div class="slider-img-bg blog-img-bg" data-animation="fadeIn" data-delay="0.2s" data-animation-duration="0.7s" data-background="<?php echo esc_url($tcg_simageurl); ?>"></div>
										<div class="blog-slider-box">
											<div class="slider-content"></div>
										</div><!--/.blog-slider-box-->
									</div><!--/.slide-->
								<?php }
							echo'</div>'; 


							//if post video 
						} else if ( get_post_meta($post->ID, 'post_format', true) == 'post_video'){ 
							echo'<div class="video"><iframe width="560" height="315" 
							src="'.esc_attr( get_post_meta($post->ID, 'post_video_setting', true)).'?wmode=opaque;rel=0;showinfo=0;controls=0;iv_load_policy=3"></iframe></div>';

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

						<?php  if ( get_post_meta($post->ID, 'post_format', true) == '' && has_post_thumbnail()){
						echo'<div class="spc-30 clearfix"></div>';
						}?> 
 						<h3 class="entry-title"><?php the_title(); ?></h3> 

						<ul class="post-detail">
							<li><i class="lnr lnr-user fw-600"></i> <?php the_author_posts_link(); ?> </li>
							<li><i class="lnr lnr-history"></i> <?php echo get_the_date(); ?> </li> 
			 				 <?php if(has_category()) { ?> 
			  				<li><i class="lnr lnr-book"></i> <?php the_category(', '); ?></li>
			  				<?php if(get_the_tag_list()) { ?>
  							<li><i class="lnr lnr-tag"></i><?php the_tags('', ', '); ?></li> 
  							<?php }?>
			  				<li>
			  					<i class="lnr lnr-bubble"></i> 
			  					<?php 
			  					if(get_comments_number()==1){
			  					echo esc_attr($post->comment_count).esc_attr__(' Comment','themescamp-core'); 
			  					}else{
		  						echo esc_attr($post->comment_count).esc_attr__(' Comments','themescamp-core'); 
		  						}

			  					?>
			  				</li>  
			  				<?php }?> 
			  					
		  				</ul>

		  				<div class="spc-20 clearfix"></div>

		  				<?php the_content(); ?>
		  				<div class="spc-20 clearfix"></div>
		  				<div class="post-pager clearfix">
							<?php wp_link_pages(); ?>
						</div>

						<?php if(function_exists('sharebox') || get_the_tag_list()) { ?>

							<div class="post-bottom">
							
								<?php if(get_the_tag_list()) { ?>
								<div class="tags-bottom"><?php the_tags('Tags:  ', '  '); ?></div><!--/.sharebox-->
								<?php }?>
								<div class="sharebox"></div><!--/.sharebox-->
								<div class="border-post clearfix"></div>
							</div>
						<?php }?>

						<!--RELATED POST-->
						<?php get_template_part( 'inc/related', 'posts' ); ?>
						<!--RELATED POST END--> 

							<?php   if ( !post_password_required() ) { //only show comment if post not password protected

							// If comments are open or we have at least one comment, load up the comment template.
							   if (  comments_open() || get_comments_number()) :
								   comments_template();

						   endif; }?>

					</article><!--/.blog-post-->
					<!--BLOG POST END-->    
				<?php endwhile; ?>
					<div class="img-pagination">
						<?php $tcg_prevPost = get_previous_post();
						if($tcg_prevPost) {?>
							<div class="pagi-nav-box previous">
								<?php $tcg_prevthumbnail = get_the_post_thumbnail($tcg_prevPost->ID, array(150,150) ); $tcg_prev = esc_html__('Previous post', 'themescamp-core'); ?>
								<?php previous_post_link('%link',"<div class='img-pagi'><i class='lnr lnr-arrow-left'></i> 
								$tcg_prevthumbnail</div>  <div class='imgpagi-box'><p>$tcg_prev</p> <h4 class='pagi-title'>%title</h4> </div>"); ?> 
							</div>

						<?php } $tcg_nextPost = get_next_post();  
						if($tcg_nextPost) { ?>
							<div class="pagi-nav-box next">
								<?php $tcg_nextthumbnail = get_the_post_thumbnail($tcg_nextPost->ID, array(150,150) ); $tcg_next = esc_html__('Next post', 'themescamp-core'); ?>
								<?php next_post_link('%link',"<div class='imgpagi-box'><p>$tcg_next</p><h4 class='pagi-title'>%title</h4> </div> <div class='img-pagi'><i class='lnr lnr-arrow-right'></i>
								$tcg_nextthumbnail</div> "); ?>
							</div>
						<?php } ?>
					</div><!--/.img-pagination-->

			</div><!--/.blog-content-->

			<!--SIDEBAR (RIGHT)-->
			<?php if ( $tcg_single_layout =='right') {(new Themescamp_Sidebars());} wp_reset_postdata(); ?>

		</div><!--/.row-->   
	</div><!--/.container-->
</div><!--/.blog-wrapper-->
