<?php

//change admin css
add_action('admin_head', 'my_custom_logo');

function my_custom_logo() {
    echo '
    <style type="text/css">
	
    #header-logo { background-image: url(' . get_bloginfo('template_directory') . '/images/custom-logo.gif) !important; display:none; visibility:hidden;}
	
	#footer-left{ display:none; visibility:hidden; }
	#favorite-actions{ display:none; visibility:hidden; }
	#contextual-help-link-wrap{ display:none; visibility:hidden; }
	#footer-upgrade,#footer-upgrade a:visited, #footer-upgrade a {color:#D9D9D9; }
	#wphead{background-color:#017337; color:#e6dfcf; background-image:none; }
	#wphead h1 a, #user_info, #user_info a:link, #user_info a:visited{color:#e6dfcf; }
	#post-body #normal-sortables{min-height:0px; }
	#wpsc_quarterly_dashboard_widget{ display:none; visibility:hidden; }
	#wpsc_dashboard_4months_widget{ display:none; visibility:hidden; }
	#wpsc_dashboard_widget{ display:none; visibility:hidden; }
	#linkxfndiv{ display:none; visibility:hidden; }
	#linkadvanceddiv{ display:none; visibility:hidden; }
	
	#wpsc_getshopped_news{ display:none; visibility:hidden; }
	#dashboard_right_now{ display:none; visibility:hidden; }
	
	#amember_sectionid{ display:none; visibility:hidden; }
	/*#amember_shordcodes_sectionid{ display:none; visibility:hidden; }*/
	#edit-slug-box{ display:none; visibility:hidden; }
	#tagcloud { display:none; visibility:hidden; }
	#parent_id, #menu_order { display:none; visibility:hidden; }
	#pageparentdiv p{ display:none; visibility:hidden; }
	#revisionsdiv-off{ display:none; visibility:hidden; }


      </style>
	  
	  
   ';
}


//remove page meta boxes


function remove_page_excerpt_field() {
    //remove_meta_box( 'pageparentdiv' , 'page' , 'normal' );
    remove_meta_box('postcustom', 'page', 'normal');
    remove_meta_box('commentstatusdiv', 'page', 'normal');
    remove_meta_box('commentsdiv', 'page', 'normal');
    remove_meta_box('authordiv', 'page', 'normal');

}

add_action('admin_menu', 'remove_page_excerpt_field');


function remove_post_excerpt_field() {

    /*remove_meta_box( 'postexcerpt' , 'post' , 'normal' ); */
    /*remove_meta_box( 'commentstatusdiv' , 'post' , 'normal' ); */
    /*remove_meta_box( 'trackbacksdiv' , 'post' , 'normal' ); */
    /*remove_meta_box( 'authordiv' , 'post' , 'normal' ); */
    /*remove_meta_box( 'postcustom' , 'post' , 'normal' ); */

}

add_action('admin_menu', 'remove_post_excerpt_field');


//remove dashboard edits


add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
    global $wp_meta_boxes;

    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

    wp_add_dashboard_widget('custom_help_widget', 'Help', 'custom_dashboard_help');
}

function custom_dashboard_help() {
    echo '';
}

// set page size in admin

add_filter('edit_posts_per_page', 'my_edit_posts_per_page');
function my_edit_posts_per_page() {
    return 100;
}


add_filter('login_redirect', 'login_redirect');

function login_redirect() {
    global $user;

    if (is_wp_error($user) && isset($_REQUEST['redirect_to']) && $_REQUEST['redirect_to'] && !isset($_REQUEST['reauth'])) {

        //to triger ammeber show error message.
        $_SESSION['_amember_login'] = 'error';
        $_SESSION['_amember_pass'] = 'error';

        header('Location: ' . $_REQUEST['redirect_to']);
        exit;

    }
}