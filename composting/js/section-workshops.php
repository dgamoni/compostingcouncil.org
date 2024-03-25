<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'workshops_init');

function workshops_init() {

	$args = array(
		'label' => __('Workshops'),
		'labels' => array(
				'edit_item' => __('Edit Workshops'),
				'add_new_item' => __('Add New'),
				'view_item' => __('View Workshops'),
				 'view' => __( 'View Workshops' ),  

   

				
         	'search_items' => __( 'Search Workshops' ),  
		 	'not_found' => __( 'No Workshops found' ),  
			'not_found_in_trash' => __( 'No Workshops found in Trash' ),  
			'parent' => __( 'Parent Workshops' ),  
		),
		'singular_label' => __('Workshops'),
		'public' => true,
		'show_ui' => true, // show in admin
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array("slug" => "workshops"), // links
		'supports' => array('thumbnail')
	);

	register_post_type( 'workshops' , $args );

//	register_taxonomy(
//		'mtype',
//		'workshops',
//		array ('hierarchical' => false, 'label' => __('Workshops tags'),
//				'singular_label' => __('Workshops tags'),
//				'query_var' => 'mtype')
//	);
}

add_action("admin_init", 'workshops_admin_init');

function workshops_admin_init() {
	remove_meta_box('submitdiv', 'workshops', 'normal');
}

add_action('add_meta_boxes_workshops','workshops_boxes_setup');

function workshops_boxes_setup() {
	wp_enqueue_script('editor');
	add_action('edit_form_advanced','workshops_form',1);
//	add_action('post_edit_form_tag','workshops_form_enctype');
}

//function workshops_form_enctype() {
//	echo ' enctype="multipart/form-data" ';
//}

function workshops_form() {
	global $post;

	echo __("<p>Please fill out the form below to add an workshop. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

	$post_type_object = get_post_type_object($post->post_type);

	$start_time=get_post_meta($post->ID, 'start_time', true);
	$end_time=get_post_meta($post->ID, 'end_time', true);
	$member=get_post_meta($post->ID, 'member', true);
	$non_member=get_post_meta($post->ID, 'non_member', true);
	$attends=get_post_meta($post->ID, 'attends', true);
	$instructor=get_post_meta($post->ID, 'instructor',true);
	$position=$post->menu_order; //get_post_meta($post->ID, 'position',true);

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
				<span>Title</span>
			</label>
		</td>
		<td>
			<input type="text" name="post_title" size="80" tabindex="2" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="position">
				<span>Position</span>
			</label>
		</td>
		<td>
			<select name='menu_order' id='position' tabindex='3'>
			<?php $positions = get_free_position($position);
			foreach ($positions as $p ) {
				echo "<option ". selected( $p, $position, false ) ." value='$p'>$p</option>";
			}
			?>
			</select>

		</td>
	</tr>
	<tr>
		<td>
			<label for="display-input">
				<span>Description</span>
			</label>
		</td>
		<td>
			<?php the_editor($post->post_content,'content','title',false,4);  ?>
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="year">
				<span>Year</span>
			</label>
		</td>
		<td>
			<input type="text" name="year" size="20" value="2011" id="year" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="start_time">
				<span>Start Time</span>
			</label>
		</td>
		<td>
			<input type="text" name="start_time" size="20" tabindex="5" value="<?php echo esc_attr( htmlspecialchars( $start_time ) ); ?>" id="start_time" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="end_time">
				<span>End Time</span>
			</label>
		</td>
		<td>
			<input type="text" name="end_time" size="20" tabindex="6" value="<?php echo esc_attr( htmlspecialchars( $end_time ) ); ?>" id="end_time" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="member">
				<span>Member Price</span>
			</label>
		</td>
		<td>
			$ <input type="text" name="member" size="20" tabindex="7" value="<?php echo esc_attr( htmlspecialchars( $member ) ); ?>" id="member" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="non_member">
				<span>Non-Member Price</span>
			</label>
		</td>
		<td>
			$ <input type="text" name="non_member" size="20" tabindex="8" value="<?php echo esc_attr( htmlspecialchars( $non_member ) ); ?>" id="non_member" />
		</td>
	</tr>



	<tr>
		<td><span class='file-error'>*</span>
			<label for="attends">
				<span>Max Attendees</span>
			</label>
		</td>
		<td>
			<input type="text" name="attends" size="20" tabindex="9" value="<?php echo esc_attr( htmlspecialchars( $attends ) ); ?>" id="attends" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="instructor">
				<span>Instructors</span>
			</label>
		</td>
		<td>
			<input type="text" name="instructor" size="80" tabindex="10" value="<?php echo esc_attr( htmlspecialchars( $instructor ) ); ?>" id="instructor" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="bios">
				<span>Bios</span>
			</label>
		</td>
		<td>
			<textarea rows="5" cols="90" name="bios" tabindex="11" id="bios"><?php echo get_post_meta($post->ID, 'bios', true); ?></textarea>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<?php if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) : ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="12" accesskey="p" value="<?php esc_attr_e('Add Workshop') ?>" />
			<?php else: ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="12" accesskey="p" value="<?php esc_attr_e('Update Workshop') ?>" />
			<?php endif; ?>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>

	<?php


}

add_action('save_post','workshops_save',1);

function workshops_save($post_id) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
     return;

	if (!($post_id && isset($_POST['post_type']) && 'workshops'==$_POST['post_type'])) return;

	$fields = explode(' ','year start_time end_time member non_member attends instructor bios position');

	foreach ($fields as $f) {
		if (isset($_POST[$f])) {
			update_post_meta($post_id, $f, esc_attr($_POST[$f]));
		}
	}

	if (!get_post_meta($post_id, 'current', true)) update_post_meta($post_id, 'current', 0);

	if (isset($_POST['_event_http_referer'])) {
		add_filter('redirect_post_location','redirect_frontend_workshops',9999,2);
	}
}

function redirect_frontend_workshops($location, $post_id) {
	return get_home_url().'?post_type=workshops&p='.$post_id;
}

add_filter('posts_orderby_request', 'workshop_posts_orderby_request', 9999, 2);

function workshop_posts_orderby_request($orderby, $t) {
	if ('workshops' == $t->query_vars['post_type']) {
		$orderby = 'menu_order';
	}
	return $orderby;
}

add_filter('manage_edit-workshops_columns', 'manage_edit_workshops_columns');

function manage_edit_workshops_columns($headers) {

	unset($headers['title']);
	unset($headers['date']);
	unset($headers['author']);
	$headers['year']='Year';
	$headers['title']='Title';
	$headers['current']='Att';
	$headers['attends']='Max';
	$headers['member']='Member Price';
	$headers['non_member']='Non-Member Price';
	$headers['date']='Posted';
	return $headers;
}

add_action('admin_head','add_styles_for_columns');

function add_styles_for_columns() {
	if (isset($_GET['post_type']) && ('workshops'==$_GET['post_type'] || 'register'==$_GET['post_type'] || 'exhibitors'==$_GET['post_type'])) {
		?>
	<style type="text/css">
		.column-year,
		.column-current,
		.column-attends {
			width:3em;
		}
		.column-uscc,
		.column-purchase,
		.column-member,
		.column-non_member {
			width:10%;
		}
	</style>
		<?php
	}
	return;
}

add_action('manage_posts_custom_column','manage_posts_workshops_column',1);

function manage_posts_workshops_column($cname) {
	global $post;

	if ($post->post_type != 'workshops') return;

	switch($cname) {
		case 'member':
		case 'non_member':
			echo '$'.get_post_meta($post->ID, $cname, true);
			break;
		default:
			echo get_post_meta($post->ID, $cname, true);
			break;
	}
}

add_filter('home_template','check_workshops_index');
add_filter('index_template','check_workshops_index');

function check_workshops_index($template) {
	if (strpos($_SERVER['REQUEST_URI'],'/workshops/')===0) {
		$template = locate_template(array('workshops_index.php'));
		add_filter('posts_where_request','check_m_for_workshops',1);
	}
	return $template;
}

add_shortcode('workshops', 'display_workshops');
function display_workshops($atts, $content='') {
	extract(shortcode_atts(array(
		'workshops' => array(),
		'show_table' => true,
		'workshop_rate' => '',
	), $atts ));

	$workshops = array_flip($workshops);

	$loop = get_workshops();
	$fields = explode(' ','year start_time end_time member non_member attends instructor bios current');

	$out='';
	if ($loop) {

		foreach ($loop as $post) {
			foreach ($fields as $f) {
				$post->$f = get_post_meta($post->ID, $f, true);
			}
			if ($show_table) { $out .= "
			
			<tr style=\"margin-top:12px;\" valign=\"top\" class=\"workshop\">
				<td>".(($post->attends > $post->current )?"<input type=\"checkbox\" id=\"workshop_{$post->ID}\" name=\"workshops[]\" value=\"{$post->ID}\" ".checked(isset($workshops[$post->ID]),true,false)." onclick=\"recalculate(this, {'member': {$post->member}, 'nonmember': {$post->non_member}});\" />":'')."</td>
				<td>
					<label for=\"workshop_{$post->ID}\" class=\"no-pad\"><strong>{$post->post_title}</strong></label><br />
					".(($post->instructor)?"Instructor(s): {$post->instructor} ({$post->start_time} - {$post->end_time})":'')."
				
			<br />
			Member:\${$post->member}<br />

			
				Non-Member:\${$post->non_member}
				<div id=\"dotline\"></div>
				</td>
				
			</tr>
			
			<div id=\"clear\" style=\"margin-top:6px;\"></div>
			";
			} else {
				if (isset($workshops[$post->ID])) {
					$out .= " <strong>{$post->post_title}</strong><br/>"
					.(($post->instructor)?" Instructor(s): {$post->instructor} ({$post->start_time} - {$post->end_time}) <br/>":'');
					if (isset($workshop_rate)) $out .= " Price $".(($workshop_rate=='member')?$post->member:$post->non_member)."<br/>";
				}
			}
		}
	}
	return $out;
}

function get_workshops() {
	return get_posts(array(
			'post_type' => 'workshops',
			'numberposts' => -1,
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC',
//			'suppress_filters'=> false,
			));
}

function calculate_workshops($data) {
	$cost = 0;
	$loop = get_workshops();
	$price = ('member' == $data['workshop_rate'])?'member':'non_member';
	
	if ($loop && $data['workshops'] && is_array($data['workshops'])) {
		$workshops = array_flip($data['workshops']);
		foreach($loop as $post) {
			if (isset($workshops[$post->ID])) $cost += get_post_meta($post->ID, $price, true);
		}
	}
	return $cost;
}

function get_free_position($id) {

	global $wpdb;
//	$existed_pos = $wpdb->get_col("SELECT DISTINCT meta_value
//		FROM {$wpdb->postmeta} as m JOIN {$wpdb->posts} as p on (p.ID=m.post_id)
//		WHERE m.meta_key='position' AND p.post_type='workshops'");
	$existed_pos = $wpdb->get_col("SELECT DISTINCT menu_order
		FROM {$wpdb->posts} as p
		WHERE p.post_type='workshops'
		ORDER BY menu_order ASC");

	$pos = array();
	$existed_pos = array_flip($existed_pos);
	for ($i=1; $i<21; $i++) {
		if ($i==$id || !isset($existed_pos[$i])) $pos[]=$i;
	}

	return $pos;
}
?>