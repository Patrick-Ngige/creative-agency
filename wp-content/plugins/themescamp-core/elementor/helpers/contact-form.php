<?php

add_action('wp_ajax_nopriv_tcg_contact_form', 'tcg_contact_form');
add_action('wp_ajax_tcg_contact_form', 'tcg_contact_form');

function is_valid_captcha()
{

    $tcg_contact_form_recaptcha_secret_key = get_option('tcg_contact_form_recaptcha_secret_key');

    if (isset($_POST['g-recaptcha-response']) and !empty($tcg_contact_form_recaptcha_secret_key)) {
        $request  = wp_remote_get('https://www.google.com/recaptcha/api/siteverify?secret=' . $tcg_contact_form_recaptcha_secret_key . '&response=' . esc_textarea($_POST["g-recaptcha-response"]) . '&remoteip=' . $_SERVER["REMOTE_ADDR"]);
        $response = wp_remote_retrieve_body($request);

        var_dump($response);

        $result = json_decode($response, TRUE);

        var_dump($result);

        if (isset($result['success']) && $result['success'] == 1) {
            // Captcha ok
            return true;
        } else {
            // Captcha failed;
            return false;
        }
    }
    return false;
}


function normalize_email($email)
{
    /**
     * Split the email into local part and domain
     */
    list($local, $domain) = explode('@', $email);

    /**
     * Remove any text after the plus sign in the local part
     */
    if (($plusPos = strpos($local, '+')) !== false) {
        $local = substr($local, 0, $plusPos);
    }

    /**
     * Return the normalized email
     */
    return $local . '@' . $domain;
}

function are_emails_same($email1, $email2)
{
    return normalize_email($email1) === normalize_email($email2);
}
function tcg_contact_form()
{

    $email               = get_bloginfo('admin_email');
    $error_empty         = esc_html__('Please fill in all the required fields.', 'themescamp-core');
    $error_noemail       = esc_html__('Please enter a valid e-mail.', 'themescamp-core');
    $error_same_as_admin = esc_html__('You can not use this e-mail due to security issues.', 'themescamp-core');
    $error_spam_email    = esc_html__('You are trying to send e-mail by banned e-mail. Multiple tries can ban you permanently!', 'themescamp-core');
    $result              = esc_html__('Unknown error! Please check your settings.', 'themescamp-core');
    $tcg_contact_form_recaptcha_site_key = get_option('tcg_contact_form_recaptcha_site_key');
    $tcg_contact_form_recaptcha_secret_key = get_option('tcg_contact_form_recaptcha_secret_key');
    $tcg_contact_form_email = get_option('tcg_contact_form_email');
    $tcg_contact_form_spam_email = get_option('tcg_contact_form_spam_email');

    if (!empty($tcg_contact_form_email)) {
        $email = $tcg_contact_form_email;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'tcgContactForm')) {
            $result = esc_html__('Security check failed!', 'themescamp-core');
            echo '<span class="tcg-text-warning">' . esc_html($result) . '</span>';
            wp_die();
        }

        $post_id   = sanitize_text_field($_REQUEST['page_id']);
        $widget_id = sanitize_text_field($_REQUEST['widget_id']);

        $error = false;

        // this part fetches everything that has been POSTed, sanitizes them and lets us use them as $form_data['subject']
        foreach ($_POST as $field => $value) {
            if (is_email($value)) {
                $value = sanitize_email($value);
            } else {
                $value = sanitize_textarea_field($value);
            }

            $form_data[$field] = strip_tags($value);
        }



        foreach ($form_data as $key => $value) {
            $value = trim($value);
            if (empty($value) && $key != 'submit') {
                $error  = true;
                $result = $error_empty;
            }
        }

        $success = sprintf(esc_html__('Hi, %s. We got your e-mail. We\'ll reply you very soon. Thanks for being with us...', 'themescamp-core'), $form_data['name']);

        // and if the e-mail is not valid, switch $error to TRUE and set the result text to the shortcode attribute named 'error_noemail'
        if (!is_email($form_data['email'])) {
            $error  = true;
            $result = $error_noemail;
        }

        /**
         * Stop spamming
         */
        if (!$error) {
            $admin_email = get_option('admin_email');
            if (are_emails_same(wp_kses_post(trim($form_data['email'])), $admin_email) || $admin_email == wp_kses_post(trim($form_data['email'])) || $email == wp_kses_post(trim($form_data['email']))) {
                $error  = true;
                $result = $error_same_as_admin;
            } else {
                if (isset($tcg_contact_form_spam_email)) {
                    $spam_email_list = $tcg_contact_form_spam_email;
                    $final_spam_list = explode(',', $spam_email_list);
                    foreach ($final_spam_list as $spam_email) {
                        if (trim($form_data['email']) == trim($spam_email)) {
                            $error  = true;
                            $result = $error_spam_email;
                            break;
                        }
                    }
                }
            }
        }

        /** Recaptcha*/

        if (!$error && $form_data['recaptcha'] != 'false') {
            if (!empty($tcg_contact_form_recaptcha_site_key) and !empty($tcg_contact_form_recaptcha_secret_key)) {
                if (!is_valid_captcha()) {
                    $error  = true;
                    $result = esc_html__("reCAPTCHA is invalid!", "themescamp-core");
                }
            }
        }


        $contact_number  = isset($form_data['contact']) ? esc_attr($form_data['contact']) : '';
        $contact_subject = isset($form_data['subject']) ? esc_attr($form_data['subject']) : '';
        $contact_name2 = isset($form_data['name2']) ? esc_attr($form_data['name2']) : '';
        $contact_select = isset($form_data['select']) ? esc_attr($form_data['select']) : '';

        // but if $error is still FALSE, put together the POSTed variables and send the e-mail!
        // ...existing code...

        if ($error == false) {
            // get the website's name and puts it in front of the subject
            $email_subject = "[" . get_bloginfo('name') . "] " . $contact_subject;
            // get the message from the form and add the IP address of the user below it
            $email_message = message_html($form_data['message'], $form_data['name'], $contact_name2, $form_data['email'], $contact_select, $contact_number);
            // set the e-mail headers with the user's name, e-mail address and character encoding
            $headers = "Reply-To: " . $form_data['name'] . $contact_name2 . " <" . $form_data['email'] . ">\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\n";
            $headers .= "Content-Transfer-Encoding: 8bit\n";
            // send the e-mail with the shortcode attribute named 'email' and the POSTed data
            wp_mail($email, html_entity_decode($email_subject), $email_message, $headers);
            // and set the result text to the shortcode attribute named 'success'
            $result = $success;
            // ...and switch the $sent variable to TRUE
            $sent = true;
        }

        $redirect_url = (isset($form_data['redirect-url']) && !empty($form_data['redirect-url'])) ? esc_url($form_data['redirect-url']) : 'no';
        $is_external  = (isset($form_data['is-external']) && !empty($form_data['is-external'])) ? esc_attr($form_data['is-external']) : 'no';
        $reset_status = (isset($form_data['reset-after-submit']) && ($form_data['reset-after-submit'] == 'yes')) ? 'yes' : 'no';

        $response = array(
            'success' => !$error,
            'message' => $result,
            'redirect_url' => $redirect_url,
            'is_external' => $is_external,
            'reset_status' => $reset_status,
            'data' => $form_data
        );

        // Debugging: Log the response before encoding
        error_log(print_r($response, true));

        // Ensure no additional output before JSON response
        if (ob_get_length()) ob_clean();

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;

    }

    die;
}

function message_html($message, $name, $name2, $email, $selection, $number = '')
{

    $fullmsg = "<html lang='en-US'><body style='background-color: #f5f5f5; padding: 35px;'>";
    $fullmsg .= "<div style='max-width: 768px; margin: 0 auto; background-color: #fff; padding: 50px 35px;'>";
    $fullmsg .= __('User Selection: ', 'themescamp-core').nl2br($selection);
    $fullmsg .= "<br><br>";
    $fullmsg .= nl2br($message);
    $fullmsg .= "<br><br>";
    $fullmsg .= "<b>" . esc_html($name) . ' ' . $name2 . "<b><br>";
    $fullmsg .= esc_html($email) . "<br>";
    $fullmsg .= ($number) ? esc_html($number) . "<br>" : "";
    $fullmsg .= "</div>";
    $fullmsg .= "</body></html>";

    return $fullmsg;
}
