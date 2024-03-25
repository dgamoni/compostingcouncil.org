<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'abstracts_init');

function abstracts_init() {

	$args = array(
		'label' => __('Abstract'),
		'labels' => array(
				'edit_item' => __('Edit Abstract'),
				'add_new_item' => __('Add New'),
				'view_item' => __('View Abstract'),
		),
		'singular_label' => __('Abstract'),
		'public' => true,
		'show_ui' => true, // show in admin
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'conference_record',
		'hierarchical' => false,
		'rewrite' => array("slug" => "abstracts"), // links
		'supports' => array('thumbnail')
	);

	register_post_type( 'abstracts' , $args );

//	abstracts_taxonomy(
//		'mtype',
//		'abstracts',
//		array ('hierarchical' => false, 'label' => __('Abstract tags'),
//				'singular_label' => __('Abstract tags'),
//				'query_var' => 'mtype')
//	);
}

add_action("admin_init", 'abstracts_admin_init');

function abstracts_admin_init() {
	remove_meta_box('submitdiv', 'abstracts', 'normal');
}

add_action('add_meta_boxes_abstracts','abstracts_boxes_setup');

function abstracts_boxes_setup() {
	wp_enqueue_script('editor');
	wp_enqueue_script('forms_scrypt', get_template_directory_uri().'/js/forms.js');
	add_action('edit_form_advanced','abstracts_form',1);
	add_action('post_edit_form_tag','abstracts_form_enctype');
}

function abstracts_form_enctype() {
	echo ' enctype="multipart/form-data" ';
}

$abstracts_fields = explode(' ', 'contact affiliation phone fax email address city state zipcode country additional ');
$abstracts_required = array_flip(explode(' ', 'contact phone email address city state zipcode country'));
$abstracts_cost_fields = explode(' ', 'consider present');

function abstracts_form() {
	global $post;

	echo __("<p>Please fill out the form below to add an Abstract. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

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
				<span>Presentation Title</span>
			</label>
		</td>
		<td>
			<input type="text" name="post_title" size="80" tabindex="2" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
		</td>
	</tr>
	<?php
		global $abstracts_fields, $abstracts_required;
		$tab_index = 3;

		foreach ($abstracts_fields as $f ) {
			?>
			<tr>
				<td>
					<?php
					if (isset($abstracts_required[$f])) echo "<span class='file-error'>*</span>";
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
		<td><span class='file-error'>*</span>
			<label for="display-input">
				<span>Brief</span>
			</label>
		</td>
		<td>
			<?php the_editor($post->post_content,'content','title',false, $tab_index++); //printf($the_editor, $the_editor_content); ?>
		</td>
	</tr>

	<tr><td colspan="2">
		<label>Would you like your paper to be considered for the Research Track<br />&nbsp;&nbsp;&nbsp;and Peer-reviewed publication?</label>
	</td></tr>
	<tr>
		<td></td>

        <td>
            <label><input type="radio" name="consider" value="1" <?php checked($post_data["consider"],'1'); ?> tabindex="<?php echo $tab_index++; ?>" /> Yes</label>
            <label><input type="radio" name="consider" value="0" <?php checked($post_data["consider"],'0'); ?> /> No</label>
        </td>
	</tr>
	<tr><td>
		<label>How do you wish<br />&nbsp;&nbsp;&nbsp;to present?</label>
		</td>
        <td>
            <select name="present" id="present" class="fill w50" tabindex="<?php echo $tab_index++; ?>" >
                <option label="-- Please Select --" value="">-- Please Select --</option>
                <option label="Oral only" value="oral" <?php selected($post_data["present"],'oral'); ?> >Oral only</option>
                <option label="Poster only" value="poster" <?php selected($post_data["present"],'poster'); ?> >Poster only</option>
                <option label="Oral &amp; Poster" value="both" <?php selected($post_data["present"],'both'); ?> >Oral &amp; Poster</option>
            </select>
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
    <tr><td><label for="file">Abstract</label></td>
        <td>
            <input type="file" id="file" name="file" tabindex="<?php echo $tab_index++; ?>" />
        </td>
    </tr>

	<tr>
		<td></td>
		<td>
			<?php if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) : ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="<?php echo $tab_index; ?>" accesskey="r" value="<?php esc_attr_e('Add Abstract') ?>" />
			<?php else: ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="<?php echo $tab_index; ?>" accesskey="r" value="<?php esc_attr_e('Update Abstract') ?>" />
			<?php endif; ?>
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

add_action('save_post','abstracts_save',1);

function abstracts_save($post_id) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
     return;

	if (!($post_id && isset($_POST['post_type']) && 'abstracts'==$_POST['post_type'])) return;

	if ($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'])) {
		$_SESSION['security_code'] = null;
		unset($_SESSION['security_code']);
	} else {
		wp_delete_post($post_id,true);
		wp_die('Security code input doesn\'t match the image. ');
	}
	
	$post_data=array();
	
	global $abstracts_fields, $abstracts_required, $abstracts_cost_fields;
	
	foreach ($abstracts_fields as $f) {
		if (isset($_POST[$f])) $post_data[$f]=esc_attr($_POST[$f]);
		else $post_data[$f]='';
	}

	foreach ($abstracts_cost_fields as $f) {
		if (isset($_POST[$f])) $post_data[$f]=esc_attr($_POST[$f]);
		else $post_data[$f]='';
	}

	update_post_meta($post_id, 'post_data', $post_data );

	if ( !empty($_FILES) ) {
		// Upload File button was clicked
		$id = media_handle_upload('file', $post_id);
		unset($_FILES);
		if ( is_wp_error($id) ) {
			$errors['upload_error'] = $id;
			$id = false;
		}
	}

	if (isset($_POST['_abstracts_http_referer'])) {
		add_filter('redirect_post_location','redirect_frontend_abstracts',9999,2);
	}
}

function redirect_frontend_abstracts($location, $post_id) {
	return get_home_url().'?post_type=abstracts&p='.$post_id;
}

add_filter('manage_edit-abstracts_columns', 'manage_edit_abstracts_columns');

function manage_edit_abstracts_columns($headers) {

	$headers['title']='Title';
	$headers['role']='E-mail';
	unset($headers['date']);
	unset($headers['author']);
	return $headers;
}

add_action('manage_posts_custom_column','manage_posts_abstracts_column',1);

function manage_posts_abstracts_column($cname) {
	global $post;

	if ($post->post_type != 'abstracts') return;
	$post_data = get_post_meta($post->ID, 'post_data', true);

	switch($cname) {

		case 'role':
			echo $post_data['email'];
			break;
	}
}

add_filter('home_template','check_abstracts_index');
add_filter('index_template','check_abstracts_index');

function check_abstracts_index($template) {
	if (strpos($_SERVER['REQUEST_URI'],'/abstracts/')===0) {
		$template = locate_template(array('abstracts_index.php'));
	}
	return $template;
}

add_shortcode('abstracts_nonce', 'add_nonce_for_abstracts');
function add_nonce_for_abstracts() {
	return wp_nonce_field('add-abstracts','_wpnonce', false , false );
}

?>