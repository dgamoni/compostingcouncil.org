<?php
define('OUTPUT_DATE_FORMAT','m/d/Y');
define('JS_DATE_FORMAT','mm/dd/yy');
define('JQUERY_UI_THEME','pepper-grinder');
define('WEEK_IN_SECOND',7*24*60*60);

add_editor_style();

add_theme_support( 'menus' ); 

add_action( 'init', 'register_my_menus' );
function register_my_menus() {
  register_nav_menus(
    array(
      'main-menu' => __( 'Main Menu' ),
      'top-menu' => __( 'Top Menu' )
    )
  );
}
























//* Add walker class that displays menu item descriptions
class Menu_With_Description extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '<br /><span class="description">' . $item->description . '</span>';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}






//include("js/adminstyle.php"); 4.0 some fucntions moved below, some take out
include("js/section-news.php"); 
include("js/section-joboffers.php");
include("js/section-jobwanted.php");
include("js/section-events.php");
//include("js/section-faq.php");
include("js/section-resources.php");
include("js/section-publication.php");
include("js/section-poster.php");
//include("js/section-register.php");
include("js/section-workshops.php");
//include("js/section-exhibitors.php");
//include("js/section-sponsorship.php");
//include("js/section-abstracts.php");
include("js/section-advocacy.php");




function uscc_slug_widgets_init() {
register_sidebar(array('name'=>'sidebar1',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<h4>',
'after_title' => '</h4>',
));
register_sidebar(array('name'=>'mainsub',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<div id="subtit">',
'after_title' => '</div>',
));
register_sidebar(array('name'=>'topsub',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<div id="subtit">',
'after_title' => '</div>',
));
register_sidebar(array('name'=>'homesub',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<div id="subtit">',
'after_title' => '</div>',
));


	
	
	
	
	
	
}
add_action( 'widgets_init', 'uscc_slug_widgets_init' );






add_filter('excerpt_length', 'my_excerpt_length');
function my_excerpt_length($length) {
return 15; }


function myfeed_request($qv) {
	if (isset($qv['feed']) && !isset($qv['post_type']))
		$qv['post_type'] = array('post', 'news', 'resources', 'joboffers', 'joboffers', 'jobswanted', 'events');
	return $qv;
}
add_filter('request', 'myfeed_request');












function my_post_type_link_filter_function( $post_link, $id = 0, $leavename = FALSE ) {
    if ( strpos('%issue_project%', $post_link) === FALSE ){
      return $post_link;
    }
    $post = get_post($id);
    if ( !is_object($post) || $post->post_type != 'issue' ) {
      return $post_link;
    }
    $terms = wp_get_object_terms($post->ID, 'issue_project');
    if ( !$terms ) {
      return str_replace('project/%issue_project%/', '', $post_link);
    }
    return str_replace('%issue_project%', $terms[0]->slug, $post_link);
  }


add_filter('post_type_link', 'my_post_type_link_filter_function', 1, 3);
















	





// Remove Product List RSS
remove_action('wp_head', 'wpsc_product_list_rss_feed');


show_admin_bar( false );






// old site maps and lists functions

function getWebsiteWithHttp($website)
{
    if (empty($website)) return '';

    if (!preg_match('/^http:\/\//', $website)) {
        $website = "http://" . $website;
    }
    return $website;
}


function getCompanyInforDetail($user)
{
    $category_html = '';
    $category = $user['category'];
    $product_category = $user['product_category'];

    $sqlC = "select * from compos_amember.amember_categories where id='$category' ";
    //    echo $sqlC;
    //    global $db;
    $resC = mysql_query($sqlC);
    $categoryarr = mysql_fetch_array($resC);

    $category_html = $categoryarr['name'];

    /////////////////////sub category///////////
    $sub_category_html = '';
    $sqlPCat = "select * from compos_amember.amember_product_categories ";
    $resC = mysql_query($sqlPCat);

    while ($categoryarr = mysql_fetch_array($resC)) {
        $product_cats[$categoryarr['code']] = $categoryarr['title'];
    }

    if (!empty($product_category)) {
        $sub_cat = json_decode($product_category);
        $exits_sub_cat = '';
        if (count($sub_cat) > 0) {
            foreach ($sub_cat as $i) {
                $k = $i;
                $v = $product_cats[$i];

                $exits_sub_cat .= $v . "<br/>";

            }
            $sub_category_html = "<div style='margin-left:20px;'>$exits_sub_cat</div>";
        }
    }

    $mem_id = $user["member_id"];

    $sql = "SELECT *
FROM `amember_members_locations` where member_id='$mem_id'";

    $res = mysql_query($sql);

    $locations_html = "";

    while ($locations = mysql_fetch_array($res)) {
        if (empty($locations_html)) {
            $locations_html = '   <div style="font-size:12px; font-weight:bold;">Multiple Address</div>  ';
        }
        $locations_html .= ' <div>  ' . $locations['facility_name'] . '</div>';
        $locations_html .= ' <div>  ' . $locations['facility_address'] . '</div>';
        $locations_html .= '                  <br/>';

    }

    $company_info = '<div style="width:200px; float:left; margin-right:20px;">';
    if (!empty($user['logo'])) {
        $company_info .=
                '<img id="upload_img" src="/amember/upload/' . $user['logo'] . '" alt="" width="200" style="padding:5px; border:1px solid  #E3E3DD" />';
    }

    global $org_detail;

    $address = $user ['street'] . ", " . $user ['city'] . ", " . $user ['state'] . " " . $user ['zip'];

    $direction_url = "http://maps.google.com/maps?f=d&z=4&utm_campaign=en&utm_medium=ha&utm_source=en-ha-na-us-bk-dd&utm_term=driving%20directions&daddr=" .
                     urlencode($address);
    $company_info .= '  <div id="map1" style="width: 195px; height: 150px"></div>

       <a href="' . $direction_url . '" >  Get Directions </a>

  </div>

        <div style=" float:left; width:300px; font-size:11px; margin-right:8px;" >
              ' . $org_detail . '
                             <h1>' . $user['organization'] . '</h1>





               ' . $user['description'] . '

               <div style="margin-top:17px;font-weight:bold">

                 ' . $user['street'] . '
               </div>

               <div style="font-weight:bold">
                 ' . $user['city'] . '
                 ' . $user['state'] . '
                 ' . $user['zip'] . '
                 ' . $user['country'] . '
               </div>

               <div style="font-weight:bold">
                 ' . $user['phone'] . '
                 ' . $user['phone_ex'] . '
               </div>

               <a href="' . getWebsiteWithHttp($user['website']) . '">
               ' . getWebsiteWithHttp($user['website']) . '
               </a>

               <br/>
               <br/>
'.$locations_html.'

</div>


<div style="float:left;" >

               <h3>Contact Person</h3>
               ' . $user['name_f'] . " " . $user['name_l'] . '
               <div> <a href="mailto:' . $user['email'] . '">
                 ' . $user['email'] . '
                 </a> </div>




             </div> <br />


			 ';

    $company_info = preg_replace('/"/', "'", $company_info);
    $company_info = preg_replace('/(\r|\n)/', "", $company_info);
    return $company_info;
}

function getCompanyInforInListing($user)
{

    $sta_product = array("43", "44", "45", "46");

    $product_id = $user['p_product_id'];

    $products = explode(",", $product_id);

    $is_sta = false;
    foreach ($sta_product as $sp) {

        if (in_array($sp, $products)) {
            $is_sta = true;
            break;
        }
    }


    $category_html = '';
    $category = $user['category'];
    $product_category = $user['product_category'];

    $sqlC = "select * from compos_amember.amember_categories where id='$category' ";
    //    echo $sqlC;
    //    global $db;
    $resC = mysql_query($sqlC);
    $categoryarr = mysql_fetch_array($resC);

    $category_html = $categoryarr['name'];

    /////////////////////sub category///////////
    $sub_category_html = '';
    $sqlPCat = "select * from compos_amember.amember_product_categories ";
    $resC = mysql_query($sqlPCat);

    while ($categoryarr = mysql_fetch_array($resC)) {
        $product_cats[$categoryarr['code']] = $categoryarr['title'];
    }

    if (!empty($product_category)) {
        $sub_cat = json_decode($product_category);
        $exits_sub_cat = '';
        if (count($sub_cat) > 0) {
            foreach ($sub_cat as $i) {
                $k = $i;
                $v = $product_cats[$i];

                $exits_sub_cat .= $v . "<br/>";

            }
            $sub_category_html = "<div style='margin-left:20px;'>$exits_sub_cat</div>";
        }
    }

    $mem_id = $user["member_id"];

    $sql = "SELECT *
FROM `amember_members_locations` where member_id='$mem_id'";

    $res = mysql_query($sql);

    $locations_html = "";

    while ($locations = mysql_fetch_array($res)) {
        if (empty($locations_html)) {
            $locations_html = '   <div style="font-size:12px; font-weight:bold;">Multiple Address</div>  ';
        }
        $locations_html .= ' <div>  ' . $locations['facility_name'] . '</div>';
        $locations_html .= ' <div>  ' . $locations['facility_address'] . '</div>';
        $locations_html .= '                  <br/>';

    }

    $company_info = '';
    if (!empty($user['logo'])) {
        $company_info .=
                '<div style="width:230px; "><img id="upload_img" src="/amember/upload/' . $user['logo'] . '" alt="" width="200" style="padding:5px; border:1px solid  #E3E3DD" /></div>';
    }

    $sta_image = "";
    if ($is_sta) {
        $sta_imag = "<img src='/wp/wp-content/themes/composting/images/yellow-dot.png'/>";
    }

    $company_info .= '

        <div style=" float:left; width:300px; font-size:11px; " >
               <h1 style="font-size:14px; " >' . $sta_imag . $user['organization'] . '</h1>' . "<a href='javascript:showonthemap(" . $user['lat'] . "," . $user['longitude'] . ");'>show in the map</a><br/><br/>" . '

                <div style="margin-top:-10px; font-style:italic;" >  ' . $category_html . '</div>


             <div> ' . $sub_category_html . '</div>
               ' . $user['description'] . '

               <div>
                 ' . $user['street'] . '
               </div>

               <div>
                 ' . $user['city'] . '
                 ' . $user['state'] . '
                 ' . $user['zip'] . '
                 ' . $user['country'] . '
               </div>

               <div>
                 ' . $user['phone'] . '
                 ' . $user['phone_ex'] . '
               </div>

               <a href="' . getWebsiteWithHttp($user['website']) . '">
               ' . getWebsiteWithHttp($user['website']) . '
               </a>
</div>


<div style="float:left; font-size:11px;" >

               <div style="font-size:12px; font-weight:bold;">Contact Person</div>
              <div>  ' . $user['name_f'] . " " . $user['name_l'] . '</div>
               <div> <a href="mailto:' . $user['email'] . '">
                 ' . $user['email'] . '
                 </a> </div>
                 <br/>


             ' . $locations_html . '

             </div><br />
 <br /><hr />';

    $company_info = preg_replace('/"/', "'", $company_info);
    $company_info = preg_replace('/(\r|\n)/', "", $company_info);
    return $company_info;

}

function getCompanyMapLocationJs($r)
{
    $sta_product = array("43", "44", "45", "46");

    $lat = $r['lat'];

    $member_id = $r['member_id'];

    $longitude = $r['longitude'];

    $org = $r['organization'];

    $blueIcon_img = "";
    $product_id = $r['p_product_id'];

    $products = explode(",", $product_id);

    $is_sta = false;
    foreach ($sta_product as $sp) {
        if (in_array($sp, $products)) {
            $is_sta = true;
            break;
        }
    }

    if ($r['is_sta'] == 1) {
          $is_sta = true;
      }

    $blueIcon_img = "  image = '/amember/images/red-dot.png';";
    if ($is_sta) {
        $blueIcon_img = "  image =  '/wp/wp-content/themes/composting/images/yellow-dot.png';";
    }


    $coompany_map_js = "

              point = new google.maps.LatLng($lat, $longitude);

                                 // Set up our GMarkerOptions object
                                $blueIcon_img

              var marker_$member_id = new google.maps.Marker({
                      position:point,
                      map:map1,
                      draggable:false,
                      icon:image
                  });

                              var tootip_html= \"$org\";



                               marker_$member_id.tooltip = new Tooltip(marker_$member_id,tootip_html);


               google.maps.event.addListener(marker_$member_id, 'mouseover', function () {
                                     marker_$member_id.tooltip.show();
                                  });




               google.maps.event.addListener(marker_$member_id, 'click', function() {

                      window.location.href = ' /wp/compostmap_detail.php?mem_id=$member_id';

                  });

                             google.maps.event.addListener(marker_$member_id, 'mouseout', function() {
                                  marker_$member_id.tooltip.hide();
                              });


                ";

    $p_multile_locations = $r['p_multile_locations'];

    if (!empty($p_multile_locations)) {
        $multile_locations = explode(",", $p_multile_locations);

        foreach ($multile_locations as $multiple_location_id) {

            $sql = "select * from amember_members_locations where id='$multiple_location_id';";
            //            echo $sql . "<br/>" . count($multile_locations);
            $res = mysql_query($sql);

            while ($row_location = mysql_fetch_array($res)) {

                $lat = $row_location['facility_address_lat'];
                $longitude = $row_location['facility_address_long'];
                $org = $row_location['facility_name'];

                $coompany_map_js .= "

                 point = new google.maps.LatLng($lat, $longitude);

                                   // Set up our GMarkerOptions object
                                  $blueIcon_img

                var marker_$multiple_location_id = new google.maps.Marker({
                        position:point,
                        map:map1,
                               draggable:false,
                        icon:image
                    });




                google.maps.event.addListener(marker_$multiple_location_id, \"mouseover\", function() {

                 marker_$multiple_location_id.tooltip = new Tooltip(marker_$multiple_location_id,tootip_html);

                    marker_$multiple_location_id.tooltip.show();

                });


google.maps.event.addListener(marker_$multiple_location_id, 'click', function() {

        window.location.href = ' /wp/compostmap_detail.php?mem_id=$member_id&multiple_location_id=$multiple_location_id';
//        marker_$multiple_location_id.tooltip = new Tooltip(marker_$multiple_location_id,\"$org_detail\");

                    marker_$multiple_location_id.tooltip.show();

    });

                google.maps.event.addListener(marker_$multiple_location_id, 'mouseout', function() {



                    marker_$multiple_location_id.tooltip.hide();

                });





                ";
            }

        }
    }
    return $coompany_map_js;
}




function getCompostMapCondition()
{
    $sql = "

    AND active_map=1

AND (category=1 OR p.product_id in (43,44,45,46) OR m.sta=1)

AND (m.disable_in_compostmap is null
OR m.disable_in_compostmap = '0')

 and lat is not null and longitude is not null



AND  ADDDATE(p.expire_date, 90)>now()

 ";
    return $sql;
}





function is_sta_member() {
        $cone = mysql_connect('localhost', 'compos_amember', 'fjY45ou35t_glkj');

        if (!$cone) {

            die('not');
        }
        mysql_select_db('compos_amember', $cone) or die(mysql_error());

        $user = wp_get_current_user();

        $user_login = $user->user_login;

        $sql = "select count(*) FROM amember_payments p
        INNER JOIN amember_members m on p.member_id=m.member_id
        WHERE m.login='$user_login' AND p.product_id in (43,44,45,46);";

        $resC = mysql_query($sql, $cone) or die(mysql_error() . $sql);

        $row = mysql_fetch_array($resC);

//        print_r($row);
//        die;
//        return true;

        return $row[0] > 0;
    }



    function is_in_90_day() {
        $cone = mysql_connect('localhost', 'compos_amember', 'fjY45ou35t_glkj');

        if (!$cone) {

            die('not');
        }
        mysql_select_db('compos_amember', $cone) or die(mysql_error());

        $user = wp_get_current_user();

        $user_login = $user->user_login;

//        $user_login='ronald';
        
        $sql = "select max(expire_date) FROM amember_payments p
        INNER JOIN amember_members m on p.member_id=m.member_id
        WHERE m.login='$user_login' group by m.member_id;";

        $resC = mysql_query($sql, $cone) or die(mysql_error() . $sql);

        $row = mysql_fetch_array($resC);

        $date= $row[0];
        if(empty($date)){
            return false;
        }else{
           $time_expire= strtotime("+90 days",strtotime($date));
          return $time_expire>time();
        }
    }
