<?php
/**
 * The template for displaying search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package ThemesCamp
 */

get_header();

if (class_exists('\ThemescampPlugin\ThemescampPlugin')) {

	(new Themescamp_Search());

}else{

?>
	
	<div class="content blog-wrapper tcg-theme">  
		<div class="container clearfix">
			 <div class="row clearfix">
				<div class="col-md-8 blog-content">

					<h3 class="search-title">
						<?php 
						$archive_title=sprintf(
							'%1$s %2$s',
							'<span class="color-accent">' . esc_html_e( 'Search result for:', 'infolio' ) . '</span>',
							'&ldquo;' . get_search_query() . '&rdquo;'
						);
						echo wp_kses_post( $archive_title ); 
						?>
					</h3>
					<!--BLOG POST START-->
					<?php if ( have_posts() ) : ?>
					
					<?php while (have_posts()) : the_post(); get_template_part( 'inc/loop', 'post' ); endwhile  ?>
					
					<?php  else: ?>
					<p><?php esc_html_e('We could not find any results for your search. You can give it another try through the search form below.','infolio'); ?></p> 
					<div class="no-search-results-form">
						<?php $infolio_unique_id = infolio_unique_id( 'search-form-' ); ?>
						<form role="search" method="get" id="<?php echo esc_attr( $infolio_unique_id ); ?>" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<input type="search" class="focus-input" placeholder="<?php echo esc_attr__('Type search keyword...','infolio'); ?>" value="<?php get_search_query()?>" name="s">
							<input type="submit" class="searchsubmit" value=""> 
						</form>
					</div>
					<?php endif; ?>
					<!--BLOG POST END-->
					
					<ul class="pagination clearfix">
						<li><?php  previous_posts_link();  ?></li>
						<li><?php next_posts_link(); ?> </li>
					</ul>
					<div class="spc-40 clearfix"></div>
				</div><!--/.col-md-8-->
				
            <!--SIDEBAR (RIGHT)-->
			<?php get_sidebar(); ?>

			 </div><!--/.row-->
		</div><!--/.container-->
	</div><!--/.blog-wrapper-->
	
<?php
} 
get_footer(); 
?>