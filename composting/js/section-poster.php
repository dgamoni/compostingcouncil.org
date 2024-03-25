<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'poster_init');

function poster_init() {

	$args = array(
		'label' => __('Poster'),
		'labels' => array(
				'edit_item' => __('Edit Poster'),
				'add_new_item' => __('Add New'),
				'view_item' => __('View Poster'),
				
				'search_items' => __( 'Search Posters' ),  
		 	'not_found' => __( 'No Posters found' ),  
			'not_found_in_trash' => __( 'No Posters found in Trash' ),  
			'parent' => __( 'Parent Posters' ), 
		),
		'singular_label' => __('Poster'),
		'public' => true,
		'show_ui' => true, // show in admin
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array("slug" => "poster"), // links
		'supports' => array('thumbnail')
	);

	register_post_type( 'poster' , $args );

//	register_taxonomy(
//		'mtype',
//		'poster',
//		array ('hierarchical' => false, 'label' => __('Poster tags'),
//				'singular_label' => __('Poster tags'),
//				'query_var' => 'mtype')
//	);
}

add_action("admin_init", 'poster_admin_init');

function poster_admin_init() {
	remove_meta_box('submitdiv', 'poster', 'normal');
//	add_meta_box('poster-form', 'Add a new item', 'poster_form', 'poster', 'normal', 'low');
//	add_meta_box('poster-list', 'Poster list', 'poster_list', 'poster', 'advanced', 'low');
}

add_action('add_meta_boxes_poster','poster_boxes_setup');

function poster_boxes_setup() {
	wp_enqueue_script('editor');
	add_action('edit_form_advanced','poster_form',1);
	add_action('post_edit_form_tag','poster_form_enctype');
}

function poster_form_enctype() {
	echo ' enctype="multipart/form-data" ';
}

function poster_form() {
	global $post;

	echo __("<p>Please fill out the form below to add a poster item. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

	$post_type_object = get_post_type_object($post->post_type);

	if ( ( 0 == $post->ID ) )
		$poster_year = date_i18n( 'Y', strtotime( current_time('mysql') ) );
	else 
		$poster_year=get_post_meta($post->ID, 'poster_year',true);


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
			<label for="poster_year">
				<span>Year</span>
			</label>
		</td>
		<td>
				<div style="max-width:100%;width:100%;" class="misc-pub-section curtime misc-pub-section-last">
					<span id="timestamp">
						<select name="poster_year" id="poster_year">
							<option value="0">Select year</option>
				<?php
					for ($i=1900; $i<2100; $i++ ) {
						echo "<option value='$i' ".selected($i, $poster_year, false).">$i</option>";
					}
					?>	</select>
					</span>
				</div>
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="title">
				<span>Name</span>
			</label>
		</td>
		<td>
			<input type="text" name="post_title" size="80" tabindex="1" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="display-input">
				<span>Description</span>
			</label>
		</td>
		<td>
			<?php the_editor($post->post_content,'content','title',false); //printf($the_editor, $the_editor_content); ?>
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
		<td>
			<label for="filedesc">
				<span>File Description</span>
			</label>
		</td>
		<td>
			<input type="text" name="filedesc" size="80" id="filedesc" />
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<?php if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) : ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="5" accesskey="p" value="<?php esc_attr_e('Add Poster Item') ?>" />
			<?php else: ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="5" accesskey="p" value="<?php esc_attr_e('Update Poster Item') ?>" />
			<?php endif; ?>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>

	<?php
	

}

add_action('save_post','poster_save',1);

function poster_save() {
	global $post;

	if ($post->post_type != 'poster') return;

	if (isset($_POST['poster_year'])) {
		update_post_meta($post->ID, 'poster_year', esc_attr($_POST['poster_year']));
	}

	if ( !empty($_FILES) ) {
		add_filter('wp_read_image_metadata','poster_save_file_description');
		// Upload File button was clicked
		$id = media_handle_upload('userfile', $post->ID);
		unset($_FILES);
		if ( is_wp_error($id) ) {
			$errors['upload_error'] = $id;
			$id = false;
		}
	}


}

function poster_save_file_description($meta) {
	if (isset($_POST['filedesc'])) {
		$meta['caption'] = utf8_encode( trim( $_POST['filedesc'] ) );
	}
	return $meta;
}

add_filter('manage_edit-poster_columns', 'manage_edit_poster_columns');

function manage_edit_poster_columns($headers) {

	$headers['title']='Name';
	unset($headers['author']);
	unset($headers['date']);
	$headers['role']='Type';

	return $headers;
}

add_action('manage_posts_custom_column','manage_posts_poster_column');

function manage_posts_poster_column($cname) {
	global $post;

	if ($post->post_type != 'poster') return;
	
	switch($cname) {
		case 'role':
			$type=get_post_meta($post->ID, 'poster_year', true);
			echo $type;
			break;
	}
}