<div class="img-pagination">
    <?php $infolio_prevPost = get_previous_post();
    if($infolio_prevPost) {?>
        <div class="pagi-nav-box previous">
            <?php $infolio_prevthumbnail = get_the_post_thumbnail($infolio_prevPost->ID, array(150,150) ); $infolio_prev = esc_html__('Previous post', 'infolio'); ?>
            <?php previous_post_link('%link',"<div class='img-pagi'><i class='lnr lnr-arrow-left'></i> 
            $infolio_prevthumbnail</div>  <div class='imgpagi-box'><p>$infolio_prev</p> <h4 class='pagi-title'>%title</h4> </div>"); ?> 
        </div>

    <?php } $infolio_nextPost = get_next_post();  
    if($infolio_nextPost) { ?>
        <div class="pagi-nav-box next">
            <?php $infolio_nextthumbnail = get_the_post_thumbnail($infolio_nextPost->ID, array(150,150) ); $infolio_next = esc_html__('Next post', 'infolio'); ?>
            <?php next_post_link('%link',"<div class='imgpagi-box'><p>$infolio_next</p><h4 class='pagi-title'>%title</h4> </div> <div class='img-pagi'><i class='lnr lnr-arrow-right'></i>
            $infolio_nextthumbnail</div> "); ?>
        </div>
    <?php } ?>
</div><!--/.img-pagination-->