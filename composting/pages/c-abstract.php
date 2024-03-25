<?php

$post_data = array();

if (is_user_logged_in()) {

    $user_data = wp_get_current_user();

    $post_data['name'] = get_user_meta($user_data->ID, 'first_name', true) . ' ' . get_user_meta($user_data->ID, 'last_name', true);

    $post_data['cf7_field_7'] = $user_data->user_email;

    $post_data['website'] = $user_data->user_url;

    //        echo __FILE__.__LINE__.'<BR/>';


    global $amember_api;

    if ($amember_api && $user_data->_amember_id && ($amember_api->connection_tested || !($err = $amember_api->connect()))) {

        $amember_user = $amember_api->get_user($user_data->_amember_id);

        //			echo "user data: {}"; var_export($amember_user);
        //        echo '<pre>';
        //        print_r($amember_user);
        //        echo '</pre>';

        //            echo __FILE__.__LINE__.'<BR/>';

        $post_data['cf6_field_2'] = "{$amember_user['name_f']} {$amember_user['name_l']}";
        $post_data['cf7_field_3'] = "{$amember_user['name_f']} {$amember_user['name_l']}";

        $post_data['company'] = $amember_user['organization'];

        $post_data['cf7_field_6'] = $amember_user['email'];

        $post_data['cf7_field_7'] = $amember_user['street'];

        $post_data['city'] = $amember_user['city'];

        $post_data['state'] = $amember_user['state'];

        $post_data['zipcode'] = $amember_user['zip'];

        $post_data['country'] = $amember_user['country'];

        $post_data['website'] = $amember_user['website'];


    }

}

?>



<?php the_content(); ?>



