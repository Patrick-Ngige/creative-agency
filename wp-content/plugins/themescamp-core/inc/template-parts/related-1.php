<?php
/*
* Related Post 
*/ 
?>
<?php $tcg_single_layout  = themescamp_settings( 'single_sidebar_layout', 'right' );  ?>
<?php $tcg_related_posts  = themescamp_settings( 'Single_related_posts', 2 );  ?>


<?php 
wp_reset_postdata();
$related = themescamp_related_post( get_the_ID(), $tcg_related_posts );

if( $related->have_posts() ):
?>
	<div class="related-bottom">
		<div class="container clearfix">
			<div class="row">
				<div class="col">
					<!--RELATED POST-->
					<div id="related_posts" class="clearfix">
						<h4 class="title-related-post">
							<?php  esc_html_e('Related Posts', 'themescamp-core'); ?>
						</h4>
						<div class="row"> 
							<?php 
							while( $related->have_posts() ):
								$related->the_post();?>
								<div class="<?php if ($tcg_related_posts==2 ){ echo 'col-sm-6 col-xs-12';}else{echo 'col-sm-4 col-xs-6';}?>"> 
									
									<?php if ( (themescamp_settings( 'tcg_related_image' ) =='show')) {  ?>
									<a href="<?php  the_permalink()  ?>" rel="bookmark" title="<?php  echo esc_attr( the_title_attribute()); ?>">
										<?php 
										if ( has_post_thumbnail() ) {
											the_post_thumbnail( 'tcg-related-post' );
										} ?>
									</a>
					
									<?php } ?>
									
									<div class="related-inner clerfix">
										<div>
											<ul class="post-detail">
												<li>
													<i class="lnr lnr-user fw-600"></i> <?php the_author_posts_link(); ?> 
												</li>
												<li>
													<i class="lnr lnr-history"></i> <?php echo get_the_date(); ?> 
												</li>
											</ul>
											<a href="<?php the_permalink(); ?>"><h3 class="related-title"><?php the_title(); ?></h3></a>
											<?php if( '' !== get_post()->post_content ){?>
											<p class="excerpt">
												<?php $excerpt = get_the_excerpt();
												$excerpt = substr( $excerpt , 0,'95'); 
												echo esc_html($excerpt.' ..');?> 
											</p>
											<?php } ?>
										</div> 
									</div>
								</div><!--/.col-sm-4-->  
							<?php  endwhile; ?>
						</div><!--/.row--> 
					</div><!--related-post-->
				</div>
			</div>
		</div>
	</div>
<?php endif;
wp_reset_postdata(); ?>