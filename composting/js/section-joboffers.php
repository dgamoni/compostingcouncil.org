<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'joboffers_init');

function joboffers_init() {

	$args = array(
		'label' => __('Job Offers'),
		'labels' => array(
				'edit_item' => __('Edit Job Offers'),
				'add_new_item' => __('Add New'),
				'view_item' => __('View Job Offers'),
				
				'search_items' => __( 'Search Job Offers' ),  
		 	'not_found' => __( 'No Job Offers found' ),  
			'not_found_in_trash' => __( 'No Job Offers found in Trash' ),  
			
		),
		'singular_label' => __('Job Offers'),
		'public' => true,
		'show_ui' => true, // show in admin
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'conference_record',
		'hierarchical' => false,
		'rewrite' => array("slug" => "joboffers"), // links
		'supports' => array('thumbnail')
	);

	register_post_type( 'joboffers' , $args );

//	register_taxonomy(
//		'mtype',
//		'joboffers',
//		array ('hierarchical' => false, 'label' => __('Job Offers tags'),
//				'singular_label' => __('Job Offers tags'),
//				'query_var' => 'mtype')
//	);
}

add_action("admin_init", 'joboffers_admin_init');

function joboffers_admin_init() {
	remove_meta_box('submitdiv', 'joboffers', 'normal');
}

add_action('add_meta_boxes_joboffers','joboffers_boxes_setup');

function joboffers_boxes_setup() {
	wp_enqueue_script('editor');
	wp_enqueue_script('datepicker',get_bloginfo('template_directory').'/js/ui.datepicker.min.js',array('jquery-ui-core'),'1.7.3');
	wp_enqueue_style('jquery-ui-lightness',get_bloginfo('template_directory').'/js/'.JQUERY_UI_THEME.'/jquery-ui-1.7.3.custom.css');
	add_action('edit_form_advanced','joboffers_form',1);
	add_action('post_edit_form_tag','joboffers_form_enctype');
}

function joboffers_form_enctype() {
	echo ' enctype="multipart/form-data" ';
}

function joboffers_form() {
	global $post;

	echo __("<p>Please fill out the form below to add a job offer item. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

	$post_type_object = get_post_type_object($post->post_type);

	$location=get_post_meta($post->ID, 'location', true);
	$company=get_post_meta($post->ID, 'company', true);

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
		<td><span class='file-error'>*</span>
			<label for="posted">
				<span>Posted</span>
			</label>
		</td>
		<td>
			<?php

				if ( current_user_can($post_type_object->cap->publish_posts) ) {
					// Contributors don't get to choose the date of publish ?>
					<div style="max-width:100%;width:100%;" class="misc-pub-section curtime misc-pub-section-last">
						<span id="timestamp"><input name="posted" id="posted" size="10" value="<?php
							if ( ( 0 == $post->ID ) || ( '0000-00-00 00:00:00' == $post->post_date_gmt ) )
								echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( current_time('mysql') ) );
							else
								echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( $post->post_date ) );
						?>">
						</span>
					</div>
					<script type="text/javascript">
					//<![CDATA[
					(function($) {
					$(document).ready(function() {
						$("#posted").datepicker({ dateFormat: '<?php echo JS_DATE_FORMAT; ?>' });
					});
					})(jQuery);
					//]]>
					</script>

					<?php
				}
			?>
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="deadline">
				<span>Deadline</span>
			</label>
		</td>
		<td>
			<?php

				if ( current_user_can($post_type_object->cap->publish_posts) ) {
					// Contributors don't get to choose the date of publish ?>
					<div style="max-width:100%;width:100%;" class="misc-pub-section curtime misc-pub-section-last">
						<span id="timestamp"><input name="deadline" id="deadline" size="10" value="<?php
							if ( ( 0 == $post->ID ) || ( '0000-00-00 00:00:00' == $post->post_date_gmt ) )
								echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( current_time('mysql'))+WEEK_IN_SECOND  );
							else {
								$deadline = get_post_meta($post->ID, 'deadline', true);
								if ($deadline)
									echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( $deadline ) );
								else
									echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( $post->post_date )+WEEK_IN_SECOND  );
							}
						?>">
						</span>
					</div>
					<script type="text/javascript">
					//<![CDATA[
					(function($) {
					$(document).ready(function() {
						$("#deadline").datepicker({ dateFormat: '<?php echo JS_DATE_FORMAT; ?>' });
					});
					})(jQuery);
					//]]>
					</script>
					<?php
				}
			?>
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="company">
				<span>Company</span>
			</label>
		</td>
		<td>
			<input type="text" name="company" size="80" tabindex="4" value="<?php echo esc_attr( htmlspecialchars( $company ) ); ?>" id="company" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="title">
				<span>Job Title</span>
			</label>
		</td>
		<td>
			<input type="text" name="post_title" size="80" tabindex="1" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="display-input">
				<span>Job Description</span>
			</label>
		</td>
		<td>
			<?php the_editor($post->post_content,'content','title',false); //printf($the_editor, $the_editor_content); ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;
			<label for="location">
				<span>Location</span>
			</label>
		</td>
		<td>
			<input type="text" name="location" size="80" tabindex="5" value="<?php echo esc_attr( htmlspecialchars( $location ) ); ?>" id="location" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="contactinfo">
				<span>Contact Info</span>
			</label>
		</td>
		<td>
			<textarea rows="5" cols="90" name="contactinfo" tabindex="3" id="contactinfo"><?php echo get_post_meta($post->ID, 'contactinfo', true); ?></textarea>
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
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="5" accesskey="p" value="<?php esc_attr_e('Add Job Offer') ?>" />
			<?php else: ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="5" accesskey="p" value="<?php esc_attr_e('Update Job Offer') ?>" />
			<?php endif; ?>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>

	<?php


}

add_filter('wp_insert_post_data','joboffers_update',9999);

function joboffers_update($data) {
	if ($data['post_type']=='joboffers') {
		if (isset($_POST['posted'])) {
			$data['post_date'] = date_i18n( 'Y-m-d H:i:s', strtotime( preg_replace('/(\d+)\/(\d+)\/(\d+)/','$2-$1-$3',esc_attr($_POST['posted'])) ) );
			$data['post_date_gmt'] = get_gmt_from_date($data['post_date']);
		}
	}
	return $data;
}

add_action('save_post','joboffers_save',1);

function joboffers_save($post_id) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
     return;

	if (!($post_id && isset($_POST['post_type']) && 'joboffers'==$_POST['post_type'])) return;

	if (isset($_POST['company'])) {
		update_post_meta($post_id, 'company', esc_attr($_POST['company']));
	}

	if (isset($_POST['location'])) {
		update_post_meta($post_id, 'location', esc_attr($_POST['location']));
	}

	if (isset($_POST['contactinfo'])) {
		update_post_meta($post_id, 'contactinfo', esc_attr($_POST['contactinfo']));
	}

	if (isset($_POST['deadline'])) {
		update_post_meta($post_id, 'deadline', date_i18n( 'Y-m-d H:i:s', strtotime( preg_replace('/(\d+)\/(\d+)\/(\d+)/','$2-$1-$3',esc_attr($_POST['deadline'])) ) ));
	}

	if ( !empty($_FILES) ) {
		add_filter('wp_read_image_metadata','joboffers_save_file_description');
		// Upload File button was clicked
		$id = media_handle_upload('userfile', $post_id);
		unset($_FILES);
		if ( is_wp_error($id) ) {
			$errors['upload_error'] = $id;
			$id = false;
		}
	}

	if (isset($_POST['_joboffers_http_referer'])) {
		add_filter('redirect_post_location','redirect_frontend_joboffers',9999,2);
	}
}

function redirect_frontend_joboffers($location, $post_id) {
	$location = '/admin/?page_id=62&new='.$post_id;
	return $location;
}

function joboffers_save_file_description($meta) {
	if (isset($_POST['filedesc'])) {
		$meta['caption'] = utf8_encode( trim( $_POST['filedesc'] ) );
	}
	return $meta;
}

add_filter('manage_edit-joboffers_columns', 'manage_edit_joboffers_columns');

function manage_edit_joboffers_columns($headers) {

	$headers['title']='Job Title';
	$headers['date']='Posted';
	return $headers;
}

add_shortcode('joboffers_nonce', 'add_nonce_for_joboffers');

function add_nonce_for_joboffers() {
	return wp_nonce_field('add-joboffers','_wpnonce', false , false );
}
