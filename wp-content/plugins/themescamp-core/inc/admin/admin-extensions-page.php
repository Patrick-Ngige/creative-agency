<?php

use ThemescampPlugin\Admin\Themescamp_Admin_Panel;

/**
 * Extensions Template
 */

?>
<div class="extensions-page">

    <?php

    (new Themescamp_Admin_Panel())->dashboard_tabs();

    

    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'contact_form';
    ?>

    <div class="wrap">
        <h1><?php esc_html_e('Extensions', 'themescamp-core'); ?></h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=tcg_extensions&tab=contact_form" class="nav-tab <?php echo $active_tab == 'contact_form' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Contact Form', 'themescamp-core'); ?></a>
            <a href="?page=tcg_extensions&tab=mailchimp" class="nav-tab <?php echo $active_tab == 'mailchimp' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e('Mailchimp', 'themescamp-core'); ?></a>
        </h2>
        <div class="tcg-api-setting-wrapper">
            <form method="post" action="options.php">
                <?php
                if ($active_tab == 'contact_form') {
                ?>
                    <form method="post" action="options.php">
                        <?php settings_fields('tcg_contact_form_settings'); ?>
                        <?php do_settings_sections('tcg_contact_form_settings'); ?>

                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Contact Form Email', 'themescamp-core'); ?></th>
                                <td><input type="email" name="tcg_contact_form_email" value="<?php echo esc_attr(get_option('tcg_contact_form_email', get_bloginfo('admin_email'))); ?>" /></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('ReCaptcha Site key', 'themescamp-core'); ?></th>
                                <td><input type="text" name="tcg_contact_form_recaptcha_site_key" value="<?php echo esc_attr(get_option('tcg_contact_form_recaptcha_site_key')); ?>" /></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('ReCaptcha Secret key', 'themescamp-core'); ?></th>
                                <td><input type="text" name="tcg_contact_form_recaptcha_secret_key" value="<?php echo esc_attr(get_option('tcg_contact_form_recaptcha_secret_key')); ?>" /></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Spam Email List', 'themescamp-core'); ?></th>
                                <td><textarea placeholder="example@email.com, example2@email.com" name="tcg_contact_form_spam_email"><?php echo esc_textarea(get_option('tcg_contact_form_spam_email')); ?></textarea></td>
                            </tr>
                        </table>
                        <?php submit_button(); ?>
                    </form>
                <?php

                } elseif ($active_tab == 'mailchimp') {

                ?>
                    <form method="post" action="options.php">
                        <?php settings_fields('tcg_mailchimp_settings'); ?>
                        <?php do_settings_sections('tcg_mailchimp_settings'); ?>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Mailchimp API Key', 'themescamp-core'); ?></th>
                                <td><input type="text" name="tcg_mailchimp_api_key" value="<?php echo esc_attr(get_option('tcg_mailchimp_api_key')); ?>" /></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php esc_html_e('Audience ID', 'themescamp-core'); ?></th>
                                <td><input type="text" name="tcg_mailchimp_list_id" value="<?php echo esc_attr(get_option('tcg_mailchimp_list_id')); ?>" /></td>
                            </tr>
                        </table>
                        <?php submit_button(); ?>
                    </form>
                <?php
                }
                ?>
            </form>
        </div>
    </div>

</div>