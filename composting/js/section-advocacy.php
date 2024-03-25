<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'advocacy_init');

function advocacy_init() {

	$args = array(
		'label' => __('Advocacy'),
		'labels' => array(
				'edit_item' => __('Edit aAdvocacy'),
				'add_new_item' => __('Add New'),
				'view_item' => __('View Advocacy'),
				
				'search_items' => __( 'Search Advocacy' ),  
		 	'not_found' => __( 'No Advocacy found' ),  
			'not_found_in_trash' => __( 'No Advocacy found in Trash' ),  
			'parent' => __( 'Parent Advocacy' ), 
		),
		'singular_label' => __('Advocacy'),
		'public' => true,
		'show_ui' => true, // show in admin
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => array('thumbnail'),
		'rewrite' => array('slug'=>'advocacy','with_front'=>false)
	);

	register_post_type( 'advocacy' , $args );

	register_taxonomy(
		'advocacy_category',
		'advocacy',
		array ('hierarchical' => false, 'label' => __('Advocacy Categories'),
				'singular_label' => __('Advocacy Categories'))
	);
}

add_action("admin_init", 'advocacy_admin_init');

function advocacy_admin_init() {
	remove_meta_box('submitdiv', 'advocacy', 'normal');
	remove_meta_box('tagsdiv-advocacy_category', 'advocacy', 'normal');
}

add_action('add_meta_boxes_advocacy','advocacy_boxes_setup');

function advocacy_boxes_setup() {
	wp_enqueue_script('editor');
	wp_enqueue_script('datepicker',get_bloginfo('template_directory').'/js/ui.datepicker.min.js',array('jquery-ui-core'),'1.7.3');
	wp_enqueue_style('jquery-ui-lightness',get_bloginfo('template_directory').'/js/'.JQUERY_UI_THEME.'/jquery-ui-1.7.3.custom.css');
	add_action('edit_form_advanced','advocacy_form',1);
	add_action('post_edit_form_tag','advocacy_form_enctype');
}

function advocacy_form_enctype() {
	echo ' enctype="multipart/form-data" ';
}


function advocacy_form() {
	global $post;

	echo __("<p>Please fill out the form below to add a new item. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

	$post_type_object = get_post_type_object($post->post_type);

	$access=get_post_meta($post->ID, 'access',true);

	$cats = get_terms('advocacy_category','hide_empty=0');
	$post_cats = wp_get_object_terms($post->ID, 'advocacy_category');
	$post_cats_id=array();
	if (!empty($post_cats)) {
		foreach($post_cats as $c) $post_cats_id[$c->term_id]=true;
	}

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
			<select name='post_status' id='post_status' tabindex='4'>
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
		<td>&nbsp;
			<label for="access">
				<span>Access</span>
			</label>
		</td>
		<td>
			<select name="access" id="access">
				<option value="Public" <?php selected($access,'Public'); ?>>Public</option>
				<option value="Private" <?php selected($access,'Private'); ?>>Private</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="category">
				<span>Category</span>
			</label>
		</td>
		<td> 
			<select name="category" id="category">
			<?php
				foreach($cats as $c) {
					echo "<option id='{$c->name}'".selected(isset($post_cats_id[$c->term_id]),true,false)." >{$c->name}</option>";
				}
			?>
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
			<input type="text" name="post_title" size="80" tabindex="1" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="content">
				<span>Summary</span>
			</label>
		</td>
		<td>
			<?php the_editor($post->post_content,'content','title',false);  ?>
		</td>
	</tr>
	<?php

	$args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,
		'post_status' => null,
		'post_parent' => $post->ID
		);
	$attachments = get_posts($args);
	if ($attachments) {
		echo "<tr><td></td><td>";
		foreach ($attachments as $attachment) {
			echo "<div class='alignleft' style='margin:10px'><div class='alignleft'>";
			the_attachment_link($attachment->ID, false);
			echo "</div><span class='clear alignleft'>{$attachment->post_content}</span>";
			echo "<a href='" . wp_nonce_url( "post.php?action=delete&amp;post={$attachment->ID}", 'delete-attachment_' . $attachment->ID ) . "' id='delete-{$attachment->ID}' class='delbutton clear alignleft button'>" . __( 'Delete' ) . "</a>";
			echo "</div>";
		}
		echo "</td></tr>";
		?>
		<script type="text/javascript">
		//<![CDATA[
		(function($) {
		$(document).ready(function() {
			$('.delbutton').click(function() {
				$.post($(this).attr('href'));
				$(this).parent().hide();
				return false;
			})

		});
		})(jQuery);

		//]]>
		</script>

		<?php
	}

	?>
	<tr>
		<td>
			<label for="userfile">
				<span>File Upload</span>
			</label>
		</td>
		<td>
			<input type="file" name="userfile" size="80" id="userfile" />
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<?php if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) : ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="5" accesskey="p" value="<?php esc_attr_e('Add Item') ?>" />
			<?php else: ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="5" accesskey="p" value="<?php esc_attr_e('Update Item') ?>" />
			<?php endif; ?>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>

<?php


}

add_action('save_post','advocacy_save',1);

function advocacy_save() {
	global $post;

	if ($post->post_type != 'advocacy') return;

	if (isset($_POST['access'])) {
		update_post_meta($post->ID, 'access', esc_attr($_POST['access']));
	}

	if (isset($_POST['category'])) {
		wp_set_object_terms($post->ID,esc_attr($_POST['category']),'advocacy_category');
	}

	if ( !empty($_FILES) ) {
		// add_filter('wp_read_image_metadata','advocacy_save_file_description');
		// Upload File button was clicked
		$id = media_handle_upload('userfile', $post->ID);
		unset($_FILES);
		if ( is_wp_error($id) ) {
			$errors['upload_error'] = $id;
			$id = false;
		}
	}
}

add_filter('manage_edit-advocacy_columns', 'manage_edit_advocacy_columns');

function manage_edit_advocacy_columns($headers) {

	unset($headers['title']);
	unset($headers['date']);
	unset($headers['author']);
	$headers['role']='Access';
	$headers['title']='Title';
	$headers['rel']='Category';
	return $headers;
}

add_action('manage_posts_custom_column','manage_posts_advocacy_column',1);

function manage_posts_advocacy_column($cname) {
	global $post;

	if ($post->post_type != 'advocacy') return;

	switch($cname) {
		case 'rel':
			$tags = get_the_terms( $id, 'advocacy_category' );
			if ( !empty( $tags ) ) {
				$out = array();
				foreach ( $tags as $c )
					$out[] = esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'advocacy_category', 'display')) ;
				echo join( ', ', $out );
			} else {
				_e('No Tags');
			}
			break;
		case 'role':
			$type=get_post_meta($post->ID, 'access', true);
			echo $type;
			break;

	}
}

add_filter('home_template','check_advocacy_index');
add_filter('index_template','check_advocacy_index');

function check_advocacy_index($template) {
	if (strpos($_SERVER['REQUEST_URI'],'/advocacy/')===0) {
		$template = locate_template(array('advocacy_index.php'));
		add_filter('widget_categories_args','use_advocacy_category',1);
		add_filter('wp_list_categories','remove_advocacy_from_home_url',1);
		add_filter('widget_categories_dropdown_args','use_advocacy_category',1);
//		add_filter('wp_dropdown_cats','remove_advocacy_from_home_url',1);

	}
	return $template;
}

function use_advocacy_category($cat_args) {
	add_filter('option_home','add_advocacy_to_home_url');
	$cat_args['taxonomy']='advocacy_category';
	return $cat_args;
}

function remove_advocacy_from_home_url($out) {
	remove_filter('option_home','add_advocacy_to_home_url');
	return $out;
}

function add_advocacy_to_home_url($url) {
		return $url.'/advocacy';
}

add_filter('posts_where_request','check_for_post_type_is_advocacy',1);

function check_for_post_type_is_advocacy($where) {
	if (strpos($where,".taxonomy = 'post_tag'")) $where=str_replace(".taxonomy = 'post_tag'", ".taxonomy = 'advocacy_category'", $where);
	return $where;
}