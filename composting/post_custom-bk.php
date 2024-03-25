<?php
/* 
 *  (c) 2010 Wott (http://wott.net.ru/ , wott@gmail.com)
 */

$current_root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once($current_root_path . '/wp-load.php');

//$wp_object_cache->flush();

if (!is_user_logged_in() && (isset ($_POST['post_type'])) && (
		'register' == $_POST['post_type'] ||
		'exhibitors' == $_POST['post_type'] ||
		'sponsorship' == $_POST['post_type'] ||
		'abstracts' == $_POST['post_type']) ) {
	$special_user = (object)array(
		'ID' => 9999999,
		'user_login' => 'special_member',
		'user_pass' => '1234567890',
		'user_nicename' => 'special_member',
		'user_email' => 'special_member@example.org',
		'user_url' => '',
		'user_registered' => '',
		'user_activation_key' => '',
		'user_status' => 0,
		'display_name' => 'anonimous member',
		'uscc' => 0,
		'wp_user_level'=>0,
		'use_ssl' =>0,
		'wp_capabilities'=>array('subscriber'=>'1')

	);
	update_user_caches($special_user);

	$expiration = time()+24*3600;
	$old_key = wp_hash($special_user->user_login . substr($special_user->user_pass, 8, 4) . '|' . $expiration , 'auth');
	$new_cookie = "{$special_user->user_login}|$expiration";
	$_COOKIE[AUTH_COOKIE] = $new_cookie . '|'. hash_hmac('md5', $new_cookie, $old_key);

	wp_set_current_user($special_user->ID);
}

require_once(ABSPATH . 'wp-admin/includes/post.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

$post_id = write_post();
wp_redirect( apply_filters( 'redirect_post_location', '', $post_id ) );
?>
