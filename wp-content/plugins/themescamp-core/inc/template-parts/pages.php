<?php 

class Themescamp_Pages {

    function __construct() {
        //fallback to the default page template
        $this->page();
    }

    function page() {
        get_template_part('template-parts/offcanvas');  
        ?>
        <div class="content blog-wrapper">  
            <div class="container clearfix">
                <div class="row clearfix">
                    <div class="<?php if (is_active_sidebar('main-sidebar')){ echo 'col-md-8'; } 
                    else { echo 'col-md-12'; } ?> blog-content">
                    
                        <?php include('content-page.php'); ?>

                        <?php if (comments_open()) { ?>
                           <div id="comments" class="comments clearfix"><?php comments_template(); ?></div>
                        <?php } ?>
                        
                        <div class="spc-40 clearfix"></div>
                    </div><!--/.col-md-8-->
                    
                    <?php get_sidebar(); ?>
                </div><!--/.row-->
            </div><!--/.container-->
        </div><!--/.blog-wrapper-->
        <?php
    }
}

?>
