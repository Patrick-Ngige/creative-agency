
<?php

    use ThemescampPlugin\Admin\Themescamp_Admin_Panel;

/**
 * Template Welcome
*/

?>
<div class="init-page">

    <?php (new Themescamp_Admin_Panel())->dashboard_tabs();?>
    <div class="init-page-box">
        
        <div class="init-page-item">
            <div class="dashicons-before dashicons-welcome-learn-more" aria-hidden="true"><br></div>
            <h3> <?php echo esc_html__('Documentation','themescamp-core');?> </h3>
            <p> <?php echo esc_html__('Cut your learning curve and dive right in! Explore our comprehensively organized documentation for a smooth start.','themescamp-core');?> </p>
            <?php  
                if (!has_action('tcg_docs_link')) {
                    echo '<a href="https://fw.themescamp.com/docs-wp/" target="_blank">Start Reading</a>'; 
                } else {
                    do_action('tcg_docs_link');
                }
            ?>

        </div>



        <div class="init-page-item">
            <div class="dashicons-before dashicons-format-chat" aria-hidden="true"><br></div>
            <h3> <?php echo esc_html__(' Need Help?','themescamp-core');?> </h3>
            <p> <?php echo esc_html__('We have got your back, providing full support. We are excited to assist you in crafting a website that fills you with pride.','themescamp-core');?> </p>
            

            <?php  
                if (!has_action('tcg_help_link')) {
                    echo '<a href="https://themescamp.ticksy.com/" target="_blank"> Get Support </a>'; 
                } else {
                    do_action('tcg_help_link');
                }
            ?>

        </div>
        
        <?php 
            //Features availability cases (License)
            if (get_option('tcg_theme_status')=='active' || get_option('tcg_theme_dev_mod') || get_option('tcg_theme_elements')){
        ?>
        <div class="init-page-item">
            <div class="dashicons-before dashicons-admin-settings" aria-hidden="true"><br></div>
            <h3> <?php echo esc_html__('Theme Options','themescamp-core');?> </h3>
            <p> <?php echo esc_html__('Streamline your customization process! Check out our meticulously crafted theme options for a hassle-free start.','themescamp-core');?> </p>
            <a href="<?php echo admin_url('admin.php?page=tcg_theme_settings'); ?>">Handling ideas</a>
        </div>

            <div class="init-page-item">
                <div class="dashicons-before dashicons-image-filter" aria-hidden="true"><br></div>
                <h3> <?php echo esc_html__('Import demos','themescamp-core');?> </h3>
                <p> <?php echo esc_html__('Simplify your website setup with our one-click import demos! Dive for a seamless and quick starting.','themescamp-core');?> </p>
                <a href="<?php echo admin_url('admin.php?page=one-click-demo-import'); ?>">Click Now</a>
            </div>
        

        <div class="init-page-item">
            <div class="dashicons-before dashicons-admin-appearance" aria-hidden="true"><br></div>
            <h3> <?php echo esc_html__('Live Customizer','themescamp-core');?> </h3>
            <p> <?php echo esc_html__('Enhance your website customization experience with Live Customizer!, for a smooth and immediate start.','themescamp-core');?> </p>
            <a href="<?php echo admin_url('customize.php'); ?>">Live Customizer</a>
        </div>
        <?php }?>

        <div class="init-page-item">
            <div class="dashicons-before dashicons-arrow-right-alt" aria-hidden="true"><br></div>
            <h3> <?php echo esc_html__('Discover More','themescamp-core');?> </h3>
            <p> <?php echo esc_html__('Explore more WordPress themes today! Uncover a wide selection of options to find the perfect theme for your project.','themescamp-core');?> </p>
            
            <?php  
                if (!has_action('tcg_portfolio_link')) {
                    echo '<a href="https://www.themescamp.com/portfolios/" target="_blank"> More Themes </a>'; 
                } else {
                    do_action('tcg_portfolio_link');
                }
            ?>
        </div>

    </div>
</div>

