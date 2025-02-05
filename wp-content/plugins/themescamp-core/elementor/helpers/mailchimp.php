<?php


add_action('wp_ajax_tcg_mailchimp_subscribe', 'mailchimp_subscribe');
add_action('wp_ajax_nopriv_tcg_mailchimp_subscribe', 'mailchimp_subscribe');

/**
 * subscribe mailchimp with api key
 * @param  string $email        any valid email
 * @param  string $status       subscribe or unsubscribe
 * @param  array  $merge_fields First name and last name of subscriber
 * @return [type]               [description]
 */
function mailchimp_subscriber_status($email, $status, $merge_fields = array('FNAME' => '', 'LNAME' => ''))
{

    $list_id = (!empty(get_option('tcg_mailchimp_list_id'))) ? get_option('tcg_mailchimp_list_id') : ''; // Your list is here
    $api_key = (!empty(get_option('tcg_mailchimp_api_key'))) ? get_option('tcg_mailchimp_api_key') : ''; // Your mailchimp api key here

    $args = array(
        'method' => 'PUT',
        'headers' => array(
            'Authorization' => 'Basic ' . base64_encode('user:' . $api_key)
        ),
        'body' => json_encode(array(
            'email_address' => $email,
            'status'        => $status,
            'merge_fields'  => $merge_fields
        ))
    );
    $response = wp_remote_post('https://' . substr($api_key, strpos($api_key, '-') + 1) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($email)), $args);

    $body = json_decode($response['body']);

    return $body;
}


function mailchimp_subscribe()
{

    $fname = (isset($_POST['fname']) && !empty($_POST['fname'])) ? sanitize_text_field($_POST['fname']) : '';
    $result  = mailchimp_subscriber_status(sanitize_text_field($_POST['email']), 'subscribed', ['FNAME' => $fname, 'LNAME' => '']);

    if ($result->status == 400) {
        if (isset($result->detail) && !empty($result->detail)) {
            echo '<div class="tcg-text-warning">' . esc_html($result->detail) . '</div>';
        } else {
            echo '<div class="tcg-text-warning">' . esc_html_x('Your request could not be processed', 'Mailchimp String', 'bdthemes-element-pack') . '</div>';
        }
    } elseif ($result->status == 401) {
        echo '<div class="tcg-text-warning">' . esc_html_x('Error: You did not set the API keys or List ID in admin settings!', 'Mailchimp String', 'bdthemes-element-pack') . '</div>';
    } elseif ($result->status == 200 || $result->status == 'subscribed') {
        echo '<span tcg-icon="icon: check" class="tcg-icon"></span> ' . esc_html_x('Thank you, You have subscribed successfully', 'Mailchimp String', 'bdthemes-element-pack');
    } else {
        echo '<div class="tcg-text-danger">' . esc_html_x('An unexpected internal error has occurred. Please contact Support for more information.', 'Mailchimp String', 'bdthemes-element-pack') . '</div>';
    }
    die;
}
