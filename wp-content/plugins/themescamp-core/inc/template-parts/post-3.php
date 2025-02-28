

<!--Post style 3-->      
<?php 
	global $post;
	$tcg_single_layout  = themescamp_settings( 'tcg_single_sidebar_layout', 'right' );  
?>

<div class="content blog-wrapper post-style-3 <?php echo $tcg_single_layout;?>">  
	<div class="container clearfix">
		<div class="row clearfix">
		<?php if ($tcg_single_layout =='left') { (new Themescamp_Sidebars()); }?>

		<div class="<?php if ($tcg_single_layout== 'none' || !is_active_sidebar( 'main-sidebar' ) ){ 
			echo 'col-md-12';
		}else{echo 'col-md-8';} ?> blog-content">

				<!--BLOG POST START-->
				<?php while (have_posts()) : the_post(); ?>

					<article id="post-<?php  the_ID(); ?>" <?php  post_class('clearfix blog-post'); ?>>
						<div class="entry-header" >
							<!--if post is standard-->
						<?php 
						$media=get_the_post_thumbnail_url();
						if ( get_post_meta($post->ID, 'post_format', true) == ''){ echo '<div class="blog-post_bg_media" style="background-image:url('.esc_url($media).')"'.'></div>';}
						?>

							<div class="entery-header-data">
								<span class="post-date tcg-gradient-border-drk "> <?php the_time('<\s\p\a\n>d</\s\p\a\n> F'); ?> </span>
								<?php if(has_category()) { ?>
								<span class="post-category"> <?php the_category(' / '); ?></span>
								<?php }?>
		 						<h3 class="entry-title"><?php the_title(); ?></h3> 

								<ul class="post-detail">
									<li><i class="lnr lnr-user fw-600"></i> <?php the_author_posts_link(); ?> </li>
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
					  					
				  				</ul>
			  				</div>
						</div>

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
			<?php if ( $tcg_single_layout =='right') {(new Themescamp_Sidebars());} ?>

		</div><!--/.row-->   
	</div><!--/.container-->
</div><!--/.blog-wrapper-->
