<?php 
    $tcg_blog_layout  = themescamp_settings( 'blog_sidebar_layout', 'right' );  
    $tcg_pagination_loader  = themescamp_settings( 'tcg_pagination_loader' );
?>

<div class="content blog-wrapper blog-style-1">  
    <div class="container clearfix">
        <div class="row clearfix">
            <?php if ($tcg_blog_layout =='left') {(new Themescamp_Sidebars());}?>

            <div class="<?php if ($tcg_blog_layout== 'none' || !is_active_sidebar( 'main-sidebar' ) ){ 
                echo 'col-md-12';
            }else{echo 'col-md-8';} ?> blog-content">
                <div class="tcg-posts"> 
                <?php while (have_posts()) : the_post(); 
                    include('loop-post.php');
                    endwhile ?>

                </div>

                <?php if ($tcg_pagination_loader =='loader') { ?>

                    <a class="btn btn-lg tcg-show-more clearfix" data-page="1" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
                        <span class="icon"> <i class="fa-solid fa-rotate"></i> </span>
                        <span class="text"> <?php echo esc_html__( 'Show more', 'themescamp-core' ); ?> </span>
                    </a>

                <?php }else{ ?>
                    <ul class="pagination clearfix">
                        <li><?php  previous_posts_link( esc_html__( 'Previous Page', 'themescamp-core' ) ); ?></li>
                        <li><?php next_posts_link( esc_html__( 'Next Page', 'themescamp-core' ) ); ?> </li>
                    </ul>
                    <div class="spc-40 clearfix"></div>
            <?php } ?>

            </div><!--/.blog-content-->
            
            <!--SIDEBAR (RIGHT)-->
			<?php if ( $tcg_blog_layout =='right') {(new Themescamp_Sidebars());} ?>
            
        </div><!--/.row-->
    </div><!--/.container-->
</div><!--/.blog-wrapper-->
