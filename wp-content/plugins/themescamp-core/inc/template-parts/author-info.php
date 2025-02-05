
<!--Author info--> 
<div class="tcg-author-info">
    <div class="tcg-author-avatar">
        <?php echo get_avatar( get_the_author_meta( 'ID' )); ?>
    </div>
    <div class="tcg-author-info-content"> 
        <div class="tcg-author-info-title">
            <div class="tcg-author-name">
                <?php the_author_posts_link(); ?>
            </div>
            <div class="tcg-author-role">

                <?php
                    $authorID = get_the_author_meta('ID');
                    $theAuthorDataRoles = get_userdata($authorID);
                    $theRolesAuthor = $theAuthorDataRoles -> roles;
                    echo implode(',',$theRolesAuthor);
                ?>
            </div>
        </div>
        <div class="tcg-author-info-text">
            <?php the_author_meta( 'description' ) ?>
        </div>

        <div class="tcg-author-social">
            <?php if ( class_exists('Themescamp_User_Social_Profiles')){?>
                <?php
                    $prefix_name_url = get_the_author_meta( 'name' );
                    $prefix_twitter_url = get_the_author_meta( 'twitter' );
                    $prefix_facebook_url = get_the_author_meta( 'facebook' );
                    $prefix_instagram_url = get_the_author_meta( 'instagram' );
                    $prefix_pinterest_url = get_the_author_meta( 'pinterest' );
                ?>
                <?php if ( ! empty( $prefix_twitter_url ) ) : ?><a href="<?php the_author_meta( 'twitter' ) ?>"><span class="fab fa-x-twitter"></span></a><?php endif; ?>
                <?php if ( ! empty( $prefix_facebook_url ) ) : ?><a href="<?php the_author_meta( 'facebook' ) ?>"><span class="fab fa-facebook-f"></span></a><?php endif; ?>
                <?php if ( ! empty( $prefix_instagram_url ) ) : ?><a href="<?php the_author_meta( 'instagram' ) ?>"><span class="fab fa-instagram"></span></a><?php endif; ?>
                <?php if ( ! empty( $prefix_pinterest_url ) ) : ?><a href="<?php the_author_meta( 'pinterest' ) ?>"><span class="fab fa-pinterest"></span></a><?php endif; ?>
            <?php } ?>
        </div>
    </div>
</div>