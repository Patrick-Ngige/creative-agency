<?php
	if ( ! is_active_sidebar( 'main-sidebar' ) ) {
		return;
	}

	if ( (themescamp_settings( 'single_sidebar_def_width' ) =='9')) {
				$side_bar_width='col-md-3';
			}else{$side_bar_width='col-md-4';}
?>

<div class="<?php echo esc_attr($side_bar_width); ?> sidebar sidebar-1">
	<div class="tc-sticky-sidebar" <?php echo Themescamp_Sidebar_Helper::render_sidebars(); ?>>
		<?php  if ( function_exists( 'dynamic_sidebar' ) ){ 
			if ( is_active_sidebar( 'main-sidebar' ) ) { dynamic_sidebar( 'main-sidebar' );}
		} ?>
	</div><!--  End StickySidebar  -->
</div><!--  End Sidebar  -->  
