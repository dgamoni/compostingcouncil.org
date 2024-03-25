<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'exhibitors_init');

function exhibitors_init() {

	$args = array(
		'label' => __('Exhibitors'),
		'labels' => array(
				'edit_item' => __('Edit Exhibitors'),
				'add_new_item' => __('Add New'),
				'view_item' => __('View Exhibitors'),
				'search_items' => __( 'Search Exhibitors' ),  
		 	'not_found' => __( 'No Exhibitors found' ),  
			'not_found_in_trash' => __( 'No Exhibitors found in Trash' ),  
			'parent' => __( 'Parent Exhibitors' ), 
			
			
			
		),
		'singular_label' => __('Exhibitors'),
		'public' => true,
		'show_ui' => true, // show in admin
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'conference_record',
		'hierarchical' => false,
		'rewrite' => array("slug" => "exhibitors"), // links
		'supports' => array('thumbnail')
	);

	register_post_type( 'exhibitors' , $args );

//	exhibitors_taxonomy(
//		'mtype',
//		'exhibitors',
//		array ('hierarchical' => false, 'label' => __('Exhibitors tags'),
//				'singular_label' => __('Exhibitors tags'),
//				'query_var' => 'mtype')
//	);
}

add_action("admin_init", 'exhibitors_admin_init');

function exhibitors_admin_init() {
	remove_meta_box('submitdiv', 'exhibitors', 'normal');
}

add_action('add_meta_boxes_exhibitors','exhibitors_boxes_setup');

function exhibitors_boxes_setup() {
	wp_enqueue_script('editor');
	wp_enqueue_script('forms_scrypt', get_template_directory_uri().'/js/forms.js');
	add_action('edit_form_advanced','exhibitors_form',1);
//	add_action('post_edit_form_tag','exhibitors_form_enctype');
}

//function exhibitors_form_enctype() {
//	echo ' enctype="multipart/form-data" ';
//}

$exhibitors_fields = explode(' ', 'address city state zipcode country phone fax email website');
$exhibitors_contacts = array('name'=>'Name','email'=>'E-mail','phone'=>'Phone','reception'=>'Exhibitor Reception &iota; Wednesday, January 18', 'alunch'=>'Awards Lunch &iota; Thursday, January 19, $25','bpi'=>'BPI Reception &iota; Thursday, January 19', 'tour'=>'Tour &amp; Equipment Demonstrations &iota; Friday, January 20'   );
$exhibitors_required = array_flip(explode(' ', 'address city state zipcode country phone email'));
$exhibitors_cost_fields = explode(' ', 'display_type display_type_3_mult display_type_4_mult electrical additional_reps luncheon vegetarian equip_demo_vendor');

function exhibitors_form() {
	global $post;

	echo __("<p>Please fill out the form below to add an Exhibitors. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

	$post_type_object = get_post_type_object($post->post_type);

	$post_data = get_post_meta($post->ID, 'post_data', true);
	if (!$post_data) $post_data=array();

	?>
	<div id="submitdiv"></div><!-- need for JS on posts data and submit -->
	<table class="form-table">
	<tr>
		<td>&nbsp;
			<label for="post_status">
				<span>Display</span>
			</label>
		</td>
		<td>
			<select name='post_status' id='post_status' tabindex='1'>
			<option<?php selected( $post->post_status, 'publish' ); ?> value='publish'><?php _e('Published') ?></option>
			<?php if ( 'private' == $post->post_status ) : ?>
			<option<?php selected( $post->post_status, 'private' ); ?> value='publish'><?php _e('Privately Published') ?></option>
			<?php elseif ( 'future' == $post->post_status ) : ?>
			<option<?php selected( $post->post_status, 'future' ); ?> value='future'><?php _e('Scheduled') ?></option>
			<?php endif; ?>
			<option<?php selected( $post->post_status, 'pending' ); ?> value='pending'><?php _e('Pending Review') ?></option>
			<?php if ( 'auto-draft' == $post->post_status ) : ?>
			<option<?php selected( $post->post_status, 'auto-draft' ); ?> value='draft'><?php _e('Draft') ?></option>
			<?php else : ?>
			<option<?php selected( $post->post_status, 'draft' ); ?> value='draft'><?php _e('Draft') ?></option>
			<?php endif; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="title">
				<span>Company</span>
			</label>
		</td>
		<td>
			<input type="text" name="post_title" size="80" tabindex="2" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
		</td>
	</tr>
	<?php
		global $exhibitors_fields, $exhibitors_required;
		$tab_index = 3;

		foreach ($exhibitors_fields as $f ) {
			?>
			<tr>
				<td>
					<?php
					if (isset($exhibitors_required[$f])) echo "<span class='file-error'>*</span>";
					else echo "&nbsp;"; ?>
					<label for="<?php echo $f; ?>"><span><?php echo ucfirst($f); ?></span></label>
				</td>
				<td><?php
					if ('state' == $f) { ?>
					<select name="state" id="state" tabindex="<?php echo $tab_index++; ?>" class="fill required w50">
						<option label="-- Please Select --" value="">-- Please Select --</option>
						<?php echo get_options_for_forms(array('id'=>'state','value'=>$post_data[$f])); ?>
					</select>
					<?php } else if ('country' == $f) { ?>
						<select name="country" id="country" class="fill required w50" tabindex="<?php echo $tab_index++; ?>" >
						<?php echo get_options_for_forms(array('id'=>'country','value'=>$post_data[$f])); ?>
						</select>
					<?php } else { ?>
					<input type="text" name="<?php echo $f; ?>" size="80" tabindex="<?php echo $tab_index++; ?>" value="<?php echo esc_attr( htmlspecialchars( $post_data[$f] ) ); ?>" id="<?php echo $f; ?>" />
					<?php } ?>
				</td>
			</tr>
			<?php
		}
	?>
	<tr>
		<td>
			<label for="display-input">
				<span>Description</span>
			</label>
		</td>
		<td>
			<?php the_editor($post->post_content,'content','title',false,$tab_index++);  ?>
		</td>
     </tr> 
     
     <tr> 
        <td>
        <input name="equip_demo_vendor" type="checkbox" id="equip_demo_vendor" value="1" <?php checked($post_data["equip_demo_vendor"],'1'); ?> />
          <label for="equip_demo_vendor">Will also be participating as a <br />
          Vendor at the Equipment Demonstrations <br />
          at Texas Disposal Systems on January 20th.</label>
        </td>
	</tr>




	<?php
		global $exhibitors_contacts;

		for($number=1; $number<=5; $number++) {
			?>
			<tr><td colspan="3">
					<h3><span>Company Rep #<?php echo $number; ?></span></h3>
			</td></tr>
			<?php
		foreach ($exhibitors_contacts as $k=>$f ) {
			$checkbox = ( $k=='tour' || $k=='alunch'  || $k=='bpi' || $k=='reception'     );
			?>
			<tr>
				<td>
					<?php
					if ($number==1&&!$checkbox) echo "<span class='file-error'>*</span>";
					else echo "&nbsp;";
					if (!$checkbox) {
					?>
					<label for="<?php echo $k; ?>"><span><?php echo $f; ?></span></label>
					<?php } ?>
				</td>
				<td><?php
					if ($checkbox) { ?>
						<label><input type="checkbox" name="<?php echo "rep{$number}_{$k}"; ?>" value="1" <?php checked($post_data["rep{$number}_{$k}"],'1'); ?>/><?php echo $f; ?></label>
					<?php } else { ?>
						<input type="text" name="<?php echo "rep{$number}_{$k}"; ?>" size="80" tabindex="<?php echo $tab_index++; ?>" value="<?php echo esc_attr( htmlspecialchars( $post_data["rep{$number}_{$k}"] ) ); ?>" id="<?php echo "rep{$number}_{$k}"; ?>" />
					<?php } ?>
				</td>
			</tr>
			<?php
		}
		}
	?>

	<tr><td colspan="3">
		<h2>Display Type &amp; Prices</h2>
		<p><em>Registration fee includes exhibit space, sessions and program book, breakfast, refreshment breaks, and the Exhibitors Reception.</em></p>
	</td></tr>

	<tr><td colspan="3">
		<h3><span>Floor Display</span></h3>
		<p><em>Each 8' x 10' includes 2 free attendees, draped cloth 6' table, 2 chairs, &amp; wastebasket</em></p>
		<dl class="full">
			<dd>
				<table>
				<tr>
					<th width="100" align="center">8' x 10'</th>
					<td width="22"><input id="display_type_3" type="radio" name="display_type" value="3" class="required" tabindex="<?php echo $tab_index++; ?>" <?php checked($post_data["display_type"],'3'); ?> /></td>
					<th width="150" align="left"><label for="display_type_3">Member</label></th>
					<td>$1075</td>
					<td>x <select id="display_type_3_mult" name="display_type_3_mult" maxlength="4" rel="1075" class="recalc_multiple display_type_3" <?php disabled($post_data["display_type"],'4'); ?>>
							<option value="1" <?php selected($post_data["display_type_3_mult"],'1'); ?>>1</option>
							<option value="2" <?php selected($post_data["display_type_3_mult"],'2'); ?>>2</option>
							<option value="3" <?php selected($post_data["display_type_3_mult"],'3'); ?>>3</option>
							<option value="4" <?php selected($post_data["display_type_3_mult"],'4'); ?>>4</option>
							<option value="5" <?php selected($post_data["display_type_3_mult"],'5'); ?>>5</option>
							<option value="6" <?php selected($post_data["display_type_3_mult"],'6'); ?>>6</option>
							<option value="7" <?php selected($post_data["display_type_3_mult"],'7'); ?>>7</option>
							<option value="8" <?php selected($post_data["display_type_3_mult"],'8'); ?>>8</option>
							<option value="9" <?php selected($post_data["display_type_3_mult"],'9'); ?>>9</option>
							<option value="10" <?php selected($post_data["display_type_3_mult"],'10'); ?>>10</option>
						  </select>
					</td>
				</tr>
				<tr>
					<th></th>
					<td><input type="radio" id="display_type_4" name="display_type" value="4" class="required" <?php checked($post_data["display_type"],'4'); ?> /></td>
					<th align="left"><label for="display_type_4">Non-Member</label></th>
					<td>$1345</td>
					<td>x <select id="display_type_4_mult" name="display_type_4_mult" maxlength="4" rel="1345" class="recalc_multiple display_type_4"  <?php disabled($post_data["display_type"],'3'); ?>>
							<option value="1" <?php selected($post_data["display_type_4_mult"],'1'); ?>>1</option>
							<option value="2" <?php selected($post_data["display_type_4_mult"],'2'); ?>>2</option>
							<option value="3" <?php selected($post_data["display_type_4_mult"],'3'); ?>>3</option>
							<option value="4" <?php selected($post_data["display_type_4_mult"],'4'); ?>>4</option>
							<option value="5" <?php selected($post_data["display_type_4_mult"],'5'); ?>>5</option>
							<option value="6" <?php selected($post_data["display_type_4_mult"],'6'); ?>>6</option>
							<option value="7" <?php selected($post_data["display_type_4_mult"],'7'); ?>>7</option>
							<option value="8" <?php selected($post_data["display_type_4_mult"],'8'); ?>>8</option>
							<option value="9" <?php selected($post_data["display_type_4_mult"],'9'); ?>>9</option>
							<option value="10" <?php selected($post_data["display_type_4_mult"],'10'); ?>>10</option>
						  </select>
					 </td>
				</tr>
				</table>
			</dd>
		</dl>
	</td></tr>

	<tr><td colspan="3">

		<h3><span>Additional</span></h3>
		<table>
		<tr>
			<td width="22"><input id="electrical" type="checkbox" name="electrical" value="1" tabindex="<?php echo $tab_index++; ?>" <?php checked($post_data["electrical"],'1'); ?> onclick="recalculate(this, 75);" /></td>
			<th align="left"><label for="electrical">Electrical Hookup</label></th>
			<td>$75</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<th align="left"><label for="additional_reps">Additional Firm Representatives</label></th>
			<td>$250 each</td>
			<td>x <input type="text" id="additional_reps" name="additional_reps" maxlength="4" class="fill w12h recalc_multiple" tabindex="<?php echo $tab_index++; ?>" value="250*<?php echo esc_attr( htmlspecialchars( $post_data["additional_reps"] ) ); ?>" /></td>
		</tr>
		<tr>
			<td></td>
			<th align="left"><label for="luncheon">Attending Awards Luncheon</label></th>
			<td>$25 each</td>
			<td>x <input type="text" id="luncheon" name="luncheon" maxlength="4" class="fill w12h recalc_multiple" tabindex="<?php echo $tab_index++; ?>" value="25*<?php echo esc_attr( htmlspecialchars( $post_data["luncheon"] ) ); ?>" /></td>
		</tr>
		<tr>
			<td></td>
			<th align="left"><label for="vegetarian">Number of vegetarian meals</label></th>
			<td colspan="2"><input type="text" id="vegetarian" name="vegetarian" maxlength="4" class="fill w12h" tabindex="<?php echo $tab_index++; ?>" value="<?php echo esc_attr( htmlspecialchars( $post_data["vegetarian"] ) ); ?>" /></td>
		</tr>
		</table>
	</td></tr>

	<tr>
		<td>
			<h3>Total</h3>
		</td>
		<td>
			<h2 id="total-display">$0</h2>
		</td>
	</tr>

	<tr>
		<td></td>
		<td>
			<?php if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) : ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="<?php echo $tab_index; ?>" accesskey="r" value="<?php esc_attr_e('Add Exhibitor') ?>" />
			<?php else: ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="<?php echo $tab_index; ?>" accesskey="r" value="<?php esc_attr_e('Update Exhibitor') ?>" />
			<?php endif; ?>

			<a href="/admin/wp-content/plugins/as-pdf/generate.php?post=<?php echo $post->ID; ?>" target="_blank">
				<img src="/admin/wp-content/themes/composting/images/icons/print.png"/>
			</a>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>

	<script type="text/javascript">
	//<![CDATA[
	(function($) {
	$(document).ready(function() {
		forms_init('post');
	});
	})(jQuery);
	//]]>
	</script>






	<?php
}

function exhibitors_print_html($post) {

	ob_start();

	$post_type_object = get_post_type_object($post->post_type);

	$post_data = get_post_meta($post->ID, 'post_data', true);
	if (!$post_data) $post_data=array();

	?><br/>
 <span>Company</span> <?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?><br/>
<?php
		global $exhibitors_fields, $exhibitors_required;
		$tab_index = 3;

		foreach ($exhibitors_fields as $f ) {
			echo " <span>".ucfirst($f).":</span> {$post_data[$f]}<br/> ";
		}
?> <span>Description</span> <?php echo esc_attr( htmlspecialchars( $post->post_content)); ?><br/><br/><?php
	global $exhibitors_contacts;

	for($number=1; $number<=5; $number++) {
		?><h3><span>Company Rep #<?php echo $number; ?></span></h3><?php
		foreach ($exhibitors_contacts as $k=>$f ) {
			$checkbox = ($k=='tour' || $k=='reception' || $k=='bpi' || $k=='alunch');
			if (!$checkbox) {
			?> <span><?php echo $f; ?>:</span> <?php echo esc_attr( htmlspecialchars( $post_data["rep{$number}_{$k}"] ) ); ?><br/><?php
			} else {
				if ($post_data["rep{$number}_{$k}"]=='1') echo " $f<br/>";
			}
		}
	}
?>
<br/>
<h3><span>Floor Display</span></h3>
 8' x 10' <?php
	if ($post_data["display_type"]=='3') echo "Member ($1075 x {$post_data["display_type_3_mult"]})<br/>";
	else echo "Non-Member ($245 x {$post_data["display_type_4_mult"]})<br/>"; ?><br/>
<h3><span>Additional</span></h3>
<?php
	if ($post_data["electrical"]=='1') echo " Electrical Hookup ($75)<br/> ";
	echo " Additional Firm Representatives ($250 x {$post_data["additional_reps"]})<br/> ";
	echo " Attending Awards Luncheon ($25 x {$post_data["luncheon"]})<br/> ";
	echo " Number of vegetarian meals: {$post_data["vegetarian"]}<br/> ";
	
	echo "<br/><h2>Total \${$post_data['cost']}</h2>";

	$ret = ob_get_contents();
	ob_end_clean();

	return $ret;
}

add_action('save_post','exhibitors_save',1);

function exhibitors_save($post_id) {

 	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
     return;

	if (!($post_id && isset($_POST['post_type']) && 'exhibitors'==$_POST['post_type'])) return;
	
	$post_data=array();
	
	global $exhibitors_fields, $exhibitors_required, $exhibitors_contacts, $exhibitors_cost_fields;
	
	foreach ($exhibitors_fields as $f) {
		if (isset($_POST[$f])) $post_data[$f]=esc_attr($_POST[$f]);
		else $post_data[$f]='';
	}

	foreach ($exhibitors_contacts as $f=>$ff) {
		for ($i=1; $i<=5; $i++) {
			if (isset($_POST["rep{$i}_{$f}"])) $post_data["rep{$i}_{$f}"]=esc_attr($_POST["rep{$i}_{$f}"]);
			else $post_data["rep{$i}_{$f}"]='';
		}
	}

	foreach ($exhibitors_cost_fields as $f) {
		if (isset($_POST[$f])) $post_data[$f]=esc_attr($_POST[$f]);
		else $post_data[$f]='';
	}

	$post_data['cost'] = exhibitors_calculate($post_data,$post_id);

	update_post_meta($post_id, 'post_data', $post_data );

	if (isset($_POST['_exhibitors_http_referer'])) {
		// WP e-Commerce integration
		if (function_exists('wpsc_insert_product')) {
			$uscc_number = '';
			if (is_user_logged_in()) {
				$uscc_number = 'uscc#'.wp_get_current_user()->uscc;
			}

			$product_data = array(
				'name' =>esc_attr($_POST['post_title'])." exhibitor $uscc_number",
				'description' => "{$_POST['post_content']}, display type is {$post_data['display_type']}, electrical is {$post_data['electrical']}, additional_reps is {$post_data['additional_reps']}, luncheon is {$post_data['luncheon']}",

				'notax' => 1,
				'publish' => 1,
				'active' => 1,
				'no_shipping' => 1,

				'price' => $post_data['cost']
			);

			if ($product_id = get_post_meta($post_id, 'product_id',true)) {
				$product_data['product_id'] = $product_id;
			}
			update_post_meta($post_id, 'product_id', $product_id = wpsc_insert_product($product_data));

			global $wpsc_cart;
			$wpsc_cart->set_item($product_id,array(
				'quantity' => 1,
				'variation_values' => null,
				'is_customisable' => false,
				'file_data' => null,
				'provided_price' => null,
				'comment' => null,
				'time_requested' => null,
				'custom_message' => null,
				'meta' => null,
			));
			add_filter('redirect_post_location','redirect_to_cart_exhibitors',9999,2);
		} else {
			add_filter('redirect_post_location','redirect_frontend_exhibitors',9999,2);
		}
	}
}

function redirect_frontend_exhibitors($location, $post_id) {
	return get_home_url().'?post_type=exhibitors&p='.$post_id;
}
function redirect_to_cart_exhibitors($location, $post_id) {
	return get_option('shopping_cart_url');
}

add_action('wpsc_transaction_result_cart_item','exhibitors_track_transactions');

function exhibitors_track_transactions($data) {
	$product_id = $data['cart_item']['prodid'];
	$status = $data['purchase_log']['processed'];
	$posts = get_posts(array(
			'post_type' => 'exhibitors',
			'post_status' => 'any',
			'numberposts' => 1,
			'meta_key' => 'product_id',
			'meta_value' => $product_id,
			));
	if (!$posts) {
		foreach ($posts as $post) {
			switch($status) {
				case '2': $status = 'publish';	break;
				case '4': $status = 'draft';		break;
				default:  $status = 'pending';		break;
			}

			global $wpdb;
			$wpdb->update( $wpdb->posts, array( 'post_status' => $status ), array( 'ID' => $post->ID ) );
		}
	}
	return;
}

function exhibitors_calculate($data,$post_id) {
	$cost=0;
	$post = get_post($post_id);
	$early = (strtotime(get_option('discount_date'))>strtotime($post->post_date));
	switch  ($data['display_type']) {
		case '3': $cost += 1075*$data['display_type_3_mult']; break;
		case '4': $cost += 1345*$data['display_type_4_mult']; break;
	}
	if ($data['electrical']=='1') $cost += 75;
	$cost += $data['additional_reps']*250;
	$cost += $data['luncheon']*25;

	return $cost;
}

add_filter('manage_edit-exhibitors_columns', 'manage_edit_exhibitors_columns');

function manage_edit_exhibitors_columns($headers) {

	$headers['title']='Company';
	$headers['uscc']='USCC #';
	$headers['role']='E-mail';
	$headers['rel']='Cost';
	unset($headers['date']);
	unset($headers['author']);
	return $headers;
}

add_action('manage_posts_custom_column','manage_posts_exhibitors_column',1);

function manage_posts_exhibitors_column($cname) {
	global $post;

	if ($post->post_type != 'exhibitors') return;
	$post_data = get_post_meta($post->ID, 'post_data', true);

	switch($cname) {
		case 'rel':
			echo $post_data['cost'];
			break;
		case 'role':
			echo $post_data['email'];
			break;
		case 'uscc':
			echo get_userdata($post->post_author)->uscc;
			break;
	}
}

add_filter('home_template','check_exhibitors_index');
add_filter('index_template','check_exhibitors_index');

function check_exhibitors_index($template) {
	if (strpos($_SERVER['REQUEST_URI'],'/exhibitors/')===0) {
		$template = locate_template(array('exhibitors_index.php'));
	}
	return $template;
}

add_shortcode('exhibitors_nonce', 'add_nonce_for_exhibitors');
function add_nonce_for_exhibitors() {
	return wp_nonce_field('add-exhibitors','_wpnonce', false , false );
}



?>