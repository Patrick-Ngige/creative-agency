<?php
 use ThemescampPlugin\Admin\Themescamp_Admin_Panel;

define("ITEM_THEME_NAME",get_option('tcg_theme_name')); 
define("item_id",get_option('tcg_theme_id')); 
define("item_theme_version",get_option('tcg_theme_version'));




class Tcg_Register_Page {
	public function deactivate_license_link() {
		if ( isset($_GET['deactivate_license']) && $_GET['deactivate_license'] == '1') {
			update_option('license_status', 'Inactive');
			update_option('saved_license_key', '');
			update_option('license_type', '');
		}
		$saved_license_key = get_option('saved_license_key', ''); // Default to empty string

		$revoke_url = "https://doc.themescamp.com/support/?license_key={".$saved_license_key."}&blog=" . urlencode(site_url());

		return apply_filters("deactivate_license_link", add_query_arg(
			array(
				'license_key' => $saved_license_key,
				'deactivate-license' => true,
			),
			$revoke_url
		));
	}
}


function tcg_registration_page() {
	

	$is_successful = isset($_GET['success']) && $_GET['success'] == '1';
	$token = isset($_GET['token']) ? sanitize_text_field($_GET['token']) : '';

	if (!empty($token) & $is_successful) {
		update_option('saved_license_key', $token);
		update_option('license_status', 'Active');  // Set the license status to 'Active'
		update_option('license_type', 'key');  
	}
	global $license_status;
	$saved_license_key = get_option('saved_license_key', '');
	$license_status = get_option('license_status', '');  // Get the license status from the database


	if ($license_status == 'Active') {
		$intro = esc_html__('Thank you for choosing '.ITEM_THEME_NAME.'! Your product is already registered, so you have access to:','themescamp-core');
		$title = esc_html__('Congratulations! Your product is registered now.','themescamp-core');
		$icon  = 'yes';
		$class = 'is-registered';
	}else {
		$intro = esc_html__('Thank you for choosing '.ITEM_THEME_NAME.'! Registering your product allows you to:','themescamp-core');
		$title = esc_html__('Click on the button below to begin the registration process.','themescamp-core');
		$icon  = 'no';
		$class = 'not-registered';
	}
?>
    <div class="tcg-license-container">     <?php (new Themescamp_Admin_Panel())->dashboard_tabs(); ?> </div>
	<div id="tcg-registration-wrap" class="tcg-demos-container  <?php echo esc_attr($class)?>">

		<div class="tcg-dash-container tcg-dash-container-medium">
			<div class="postbox">
				<h2><span><?php echo esc_html__('Welcome to',ITEM_THEME_NAME).' '.ITEM_THEME_NAME.'!';?></span></h2>


				<div class="inside">
					<div class="main">
						<h3 class="tcg-dash-margin-remove"><span class="dashicons dashicons-<?php echo esc_attr($icon);?> library-icon-key"></span> <?php echo ($title);?></h3>


								<?php
									if ($is_successful) {
										echo '<div class="notice notice-success">Registration Successful!</div>';
									}

									if ($license_status == 'Active' && get_option('license_type') === 'key') {
										echo '<p>Your License Key <small> ( purchase code )</small>: <strong>' . esc_html($saved_license_key) . '</strong></p>';
									}

								?>

						<p class="tcg-dash-text-lead"><?php echo ($intro);?></p>
						<ul>
							<li><i class="dashicons dashicons-update"></i><?php echo esc_html__('An update mechanism','themescamp-core')?></li>
							<li class="tcg-license-support <?php echo (get_option('license_type') === 'token') ? 'hidden' : ''; ?>"><i class="dashicons dashicons-businessman "></i><a target="_blank" href="https://themescamp.ticksy.com/"><?php echo esc_html__('Access to support','themescamp-core')?></a></li>
						</ul>

						<div>
							<?php if (get_option('tcg_theme_elements')){ ?>
							<input type="checkbox" id="tcg-envato-elements-cb" name="tcg_envato_elements" value="code" <?php echo (get_option('license_type') === 'token') ? 'checked="checked"' : ''; ?>>
							<span class="elements-license-select"><?php esc_attr_e('I downloaded the theme from Envato Elements.', 'themescamp-core'); ?></span>
							<?php }?>
							<form method="post" action="" id="tcg-elements-token" class="<?php echo (get_option('license_type') !== 'token') ? 'hidden' : ''; ?>">
								<?php wp_nonce_field('customer_plugin_nonce', 'customer_plugin_nonce_field'); ?>
								<table class="form-table">
									<tr valign="top">
										<th scope="row" class="elements-license-select"><?php esc_html_e('Enter your Envato Elements Token*', 'customer-plugin'); ?></th>
										<td>
											<input type="text" name="token" value="<?php echo esc_attr(get_option('customer_plugin_token')); ?>" class="token" placeholder="XXXXXX-XXX-XXXX-XXXX-XXXXXXXX"> 
											<input type="text" name="tcg_token_email" value="<?php echo esc_attr(get_option('tcg_token_email')); ?>" placeholder="<?php esc_attr_e('Your e-mail', 'themescamp-core'); ?>" class="token-email">
											<p id="tcg-code-help-elements" class="">
												<?php
												$extension_id = md5(get_site_url());
												$activation_link = sprintf(
													'<a href="https://api.extensions.envato.com/extensions/begin_activation?extension_id=%s&amp;extension_type=envato-wordpress&amp;extension_description=WPTheme" target="_blank">Follow this link to generate a new Envato Elements Token.</a>',
													$extension_id
												);
												echo $activation_link;
												?>
											</p>
											<input type="checkbox" name="tcg_addons_user_agree" value="1" checked="checked">
											<?php
												echo sprintf(
														wp_kses( __('Your data is processed in accordance with our %s.', 'themescamp-core'), 'tcg_addons_kses_content' ),
														'<a class="tcg-policy-link" href="' . apply_filters('tcg_addons_filter_privacy_url', '//themescamp.com/terms-policy/#privacy-policy') . '" target="_blank">' . esc_html__('Privacy Policy', 'themescamp-core') . '</a>'
														);
											?>
										</td>
									</tr>
								</table>

								<div <?php echo (get_option('license_status') === 'Active') ? 'class="hidden"' : ''; ?>> 
									<?php submit_button('Activate License Token'); ?> 
								</div>

							</form>
						</div>
					</div>
				</div>
				<div id="license-footer" class="community-events-footer">

					<?php if ($license_status == 'Active' /*|| get_option('tcg_theme_dev_mod') == true*/) {   global $item_updater; $item_updater = new Tcg_Register_Page(); update_option('tcg_theme_status','active'); ?>
						<div class="tcg-support-status tcg-support-status-active">
							<?php esc_html_e('License Status:', 'themescamp-core'); ?> <span><?php echo esc_html($license_status); ?></span>

							<a class="button <?php echo (get_option('license_type') === 'token') ? 'hidden' : ''; ?>" href="<?php echo $item_updater->deactivate_license_link(); ?>"><?php esc_html_e('Revoke License Key', 'themescamp-core'); ?></a>

							<a class="button <?php echo (get_option('license_type') === 'key' || get_option('license_type') === 'Pkey') ? 'hidden' : ''; ?>" href="<?php echo esc_url(add_query_arg('revoke_elements_token', '1')); ?>"><?php esc_html_e('Revoke Elements Token', 'themescamp-core'); ?></a>

						</div>

					<?php } else { delete_option('tcg_theme_status'); ?>
						<div class="tcg-registration-wrap">
							<a href="<?php echo tcg_activate_link();?>" class="button button-primary tcg-register"><?php esc_html_e('Register Now!', 'themescamp-core'); ?></a>
							<div>
								<input type="checkbox" id="tcg-envato-market-key-cb" name="tcg_envato_elements" value="code" <?php echo (get_option('license_type') === 'token') ? 'checked="checked"' : ''; ?>>
								<span class="elements-license-select"><?php esc_attr_e('Verify via purchase code (Alternative of Register).', 'themescamp-core'); ?></span>
							</div>
							<form method="post" action="" id="tcg-market-key" class="<?php echo (get_option('license_type') !== 'Pkey') ? 'hidden' : ''; ?>">
								<?php wp_nonce_field('purchase_key_nonce', 'purchase_key_nonce_field'); ?>
								<table class="form-table">
									<tr valign="top">
										<th scope="row" class="elements-license-select"><?php esc_html_e('Enter your Purchase code*', 'customer-plugin'); ?></th>
										<td>
											<input type="text" name="purchase_key" value="<?php echo esc_attr(get_option('tcg_purchase_key')); ?>" class="token" placeholder="XXXXXX-XXX-XXXX-XXXX-XXXXXXXX"> 
											<input type="text" name="purchase_key_email" value="<?php echo esc_attr(get_option('tcg_purchase_key_email')); ?>" placeholder="<?php esc_attr_e('Your e-mail', 'themescamp-core'); ?>" class="token-email">
											<p id="tcg-code-help-elements" class="">
												<?php
												$extension_id = md5(get_site_url());
												$activation_link = sprintf(
													'<a href="https://prnt.sc/MZ1yPEGKtNfG" target="_blank">Here You can find the Purchase code from Your downloads.</a>',
													$extension_id
												);
												echo $activation_link;
												?>
											</p>
											<input type="checkbox" name="tcg_addons_user_agree" value="1" checked="checked">
											<?php
												echo sprintf(
														wp_kses( __('Your data is processed in accordance with our %s.', 'themescamp-core'), 'tcg_addons_kses_content' ),
														'<a class="tcg-policy-link" href="' . apply_filters('tcg_addons_filter_privacy_url', '//themescamp.com/terms-policy/#privacy-policy') . '" target="_blank">' . esc_html__('Privacy Policy', 'themescamp-core') . '</a>'
														);
											?>
										</td>
									</tr>
								</table>

								<div <?php echo (get_option('license_status') === 'Active') ? 'class="hidden"' : ''; ?>> 
									<?php submit_button('Activate License'); ?> 
								</div>

							</form>
						</div>

						<?php 
					}?>
				</div>
			</div>
		</div>
	</div>
	<?php


}

function tcg_activate_link(){

	$redirect_url = urlencode(admin_url('admin.php?page=registration&envato_verify_purchase=1'));
	$initiate_url = "https://doc.themescamp.com/support/?item={".item_id."}&blog=" . urlencode(site_url()) . "&redirect_url={$redirect_url}";

	return apply_filters( "activate_license_link", add_query_arg(
		array(
			'item'         => item_id,
		),
		$initiate_url
	));
}


 

add_action('admin_init', 'customer_plugin_handle_token');

function customer_plugin_handle_token() {
	if (isset($_POST['customer_plugin_nonce_field']) && wp_verify_nonce($_POST['customer_plugin_nonce_field'], 'customer_plugin_nonce')) {
		if (isset($_POST['token'])) {
			$token = sanitize_text_field($_POST['token']);
			$token_email = sanitize_text_field($_POST['tcg_token_email']);
			update_option('customer_plugin_token', $token);
			update_option('tcg_token_email', $token_email);

			$extension_id = md5(get_site_url());
			$url_token =get_site_url();
			$theme_id =item_id;
			$item_name =ITEM_THEME_NAME;


			$response = wp_remote_post('https://doc.themescamp.com/wp-json/envato-elements/v1/verify-token', array(
				'body' => array(
					'token' => $token,
					'token_email' => $token_email,
					'extension_id' => $extension_id, // Include extension ID here
					'url_token' => $url_token,
					'theme_id' => $theme_id,
					'item_name' => $item_name,
				),
				'timeout' => 15,
			));

			if (is_wp_error($response)) {
				add_settings_error('customer_plugin_messages', 'customer_plugin_message', __('Token verification failed.', 'customer-plugin'), 'error');
			} else {
				$body = wp_remote_retrieve_body($response);
				$result = json_decode($body, true);

				if (isset($result['success']) && $result['success']) {
					add_settings_error('customer_plugin_messages', 'customer_plugin_message', __('Token verified successfully.', 'customer-plugin'), 'updated');
					update_option('license_status', 'Active');  // Set the license status to 'Active'
					update_option('license_type', 'token');  // Set the license status to 'Active'

				} else {
					$error_message = isset($result['message']) ? $result['message'] : __('Invalid Token key.', 'customer-plugin');
					add_settings_error('customer_plugin_messages', 'customer_plugin_message', $error_message, 'error');
					update_option('license_status', '');  // Set the license status to 'Active'
					update_option('license_type', '');  // Set the license status to 'Active'
					//update_option('customer_plugin_token', '');
				}
			}
		}
	}
}


add_action('admin_notices', 'customer_plugin_admin_notices');

function customer_plugin_admin_notices() {
	settings_errors('customer_plugin_messages');
}

function handle_revoke_elements_token() {
	if (isset($_GET['revoke_elements_token']) && $_GET['revoke_elements_token'] == '1') {
		// Update the license status to 'Inactive'
		update_option('license_status', 'Inactive');
		update_option('license_type', '');  // Set the license status to 'Active'
		
		// Optionally, you can also clear the saved license key
		update_option('customer_plugin_token', '');
		
		// Redirect to remove the query parameter from the URL and avoid repeated actions on refresh
		wp_redirect(remove_query_arg('revoke_elements_token'));
		exit;
	}
}
add_action('admin_init', 'handle_revoke_elements_token');





add_action('admin_init', 'tcg_handle_purchase_key');

function tcg_handle_purchase_key() {
	if (isset($_POST['purchase_key_nonce_field']) && wp_verify_nonce($_POST['purchase_key_nonce_field'], 'purchase_key_nonce')) {
		if (isset($_POST['purchase_key'])) {
			$purchase_key = sanitize_text_field($_POST['purchase_key']);
			$purchase_key_email = sanitize_text_field($_POST['purchase_key_email']);
			update_option('tcg_purchase_key', $purchase_key);
			update_option('tcg_purchase_key_email', $purchase_key_email);

			$url_pkey =get_site_url();
			$theme_id =item_id;
			$item_name =ITEM_THEME_NAME;

			$pkey_response = wp_remote_post('https://doc.themescamp.com/wp-json/envato-market/v1/verify-key', array(
				'body' => array(
					'purchase_key' => $purchase_key,
					'purchase_key_email' => $purchase_key_email,
					'url_pkey' => $url_pkey,
					'theme_id' => $theme_id,
					'item_name' => $item_name,
				),
				'timeout' => 15,
			));

			if (is_wp_error($pkey_response)) {
				add_settings_error('customer_plugin_messages', 'customer_plugin_message', __('Purchase code verification failed.', 'themescamp-core'), 'error');
			} else {
				$body = wp_remote_retrieve_body($pkey_response);
				$result = json_decode($body, true);

				if (isset($result['success']) && $result['success'] && isset($result['data']['item']['id']) && $result['data']['item']['id'] == $theme_id) {
					add_settings_error('customer_plugin_messages', 'customer_plugin_message', __('Purchase code verified successfully.', 'themescamp-core'), 'updated');
					update_option('license_status', 'Active');  // Set the license status to 'Active'
					update_option('license_type', 'Pkey');  // Set the license status to 'Active'

				} else {
					$error_message = isset($result['message']) ? $result['message'] : __('Invalid Purchase code.', 'themescamp-core');
					add_settings_error('customer_plugin_messages', 'customer_plugin_message', $error_message, 'error');
					update_option('license_status', '');  // Set the license status to 'Active'
					update_option('license_type', '');  // Set the license status to 'Active'
					//update_option('customer_plugin_token', '');
				}
			}
		}
	}
}
