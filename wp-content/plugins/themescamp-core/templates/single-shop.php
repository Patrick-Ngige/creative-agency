<?php
/*
Template Name: Shop Page template
Template Post Type: page
Description:One Page template for with container for cart, checkout, account and order tracking.
*/
get_header(); 
		
?>

<div class="content shop-wrapper">  
	<div class="container clearfix">
		<div class="row clearfix">
			<div class="col-md-12 shop-content">

			<?php
			//page content
			echo'<div class="blank-shop">';
			while (have_posts()) : the_post();
				the_content();
			endwhile;
			echo'</div>';
			?>
			</div><!--/.col-md-12-->
			
		</div><!--/.row-->
	</div><!--/.container-->
</div><!--/.blog-wrapper-->

<?php get_footer(); ?>