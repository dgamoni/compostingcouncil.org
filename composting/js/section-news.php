<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'news_init');

function news_init() {

	$args = array(
		'label' => __('News'),
		'labels' => array(
				'edit_item' => __('Edit News'),
				'add_new_item' => __('Add New'),
				'view_item' => __('View News'),
				
				'search_items' => __( 'Search News' ),  
		 		'not_found' => __( 'No News found' ),  
				'not_found_in_trash' => __( 'No News found in Trash' ),  
				'parent' => __( 'Parent News' ), 
		),
		'singular_label' => __('News'),
		'public' => true,
		'show_ui' => true, // show in admin
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'post',
		

	
		
		'supports' => array('thumbnail')
	);





register_post_type( 'news' , $args );

//	register_taxonomy(
//		'mtype',
//		'news',
//		array ('hierarchical' => false, 'label' => __('News tags'),
//				'singular_label' => __('News tags'),
//				'query_var' => 'mtype')
//	);
}





add_action("admin_init", 'news_admin_init');

function news_admin_init() {
	remove_meta_box('submitdiv', 'news', 'normal');
//	add_meta_box('news-form', 'Add a new item', 'news_form', 'news', 'normal', 'low');
//	add_meta_box('news-list', 'News list', 'news_list', 'news', 'advanced', 'low');
}

add_action('add_meta_boxes_news','news_boxes_setup');

function news_boxes_setup() {
	wp_enqueue_script('editor');
	wp_enqueue_script('datepicker',get_bloginfo('template_directory').'/js/ui.datepicker.min.js',array('jquery-ui-core'),'1.7.3');
	wp_enqueue_style('jquery-ui-lightness',get_bloginfo('template_directory').'/js/'.JQUERY_UI_THEME.'/jquery-ui-1.7.3.custom.css');
	add_action('edit_form_advanced','news_form',1);
//	add_action('edit_form_advanced','news_list',2);
	add_action('post_edit_form_tag','news_form_enctype');
}

function news_form_enctype() {
	echo ' enctype="multipart/form-data" ';
}

function news_form() {
	global $post;

	echo __("<p>Please fill out the form below to add a news item. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

	$post_type_object = get_post_type_object($post->post_type);

	$type=get_post_meta($post->ID, 'news_type',true);
	if (!$type) $type="News";

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
			<select name='post_status' id='post_status'>
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
			<label for="type-radio-news">
				<span>Type</span>
			</label>
		</td>
		<td>
			<input type="radio" name="news_type" id="type-radio-news" value="News" <?php checked( $type, 'News' ); ?> /> <label for="type-radio-news" class="selectit"><?php _e('News'); ?></label><br />
			<input type="radio" name="news_type" id="type-radio-newsletter" value="Newsletter" <?php checked( $type, 'Newsletter' ); ?> /> <label for="type-radio-newsletter" class="selectit"><?php _e('Newsletter'); ?></label><br />
			<input type="radio" name="news_type" id="type-radio-press-release" value="Press Release" <?php checked( $type, 'Press Release' ); ?> /> <label for="type-radio-press-release" class="selectit"><?php _e('Press Release'); ?></label><br />
            
            <input type="radio" name="news_type" id="type-radio-homepage" value="Homepage" <?php checked( $type, 'Homepage' ); ?> /> <label for="type-radio-homepage" class="selectit"><?php _e('Homepage'); ?></label><br />
            
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="title">
				<span>Headline</span>
			</label>
		</td>
		<td>
			<input type="text" name="post_title" size="80" tabindex="1" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;
			<label for="posted">
				<span>Date</span>
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
		<td>
			<label for="url">
				<span>URL</span>
			</label>
		</td>
		<td>
			<input type="text" name="url" size="80" tabindex="2" value="<?php echo esc_attr( htmlspecialchars( get_post_meta($post->ID, 'url',true) ) ); ?>" id="url" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="teaser">
				<span>Teaser Text</span>
			</label>
		</td>
		<td>
			<input type="text" name="teaser" size="80" tabindex="3" value="<?php echo esc_attr( htmlspecialchars( get_post_meta($post->ID, 'teaser',true) ) ); ?>" id="teaser" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="display-input">
				<span>Text</span>
			</label>
		</td>
		<td>
			<?php the_editor($post->post_content,'content','title',false,4); //printf($the_editor, $the_editor_content); ?>
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
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="5" accesskey="p" value="<?php esc_attr_e('Add News Item') ?>" />
			<?php else: ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="5" accesskey="p" value="<?php esc_attr_e('Update News Item') ?>" />
			<?php endif; ?>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>

	<?php
	

}

function news_list() {
	global $wp_the_query,$wp;

	unset($GLOBALS['p']);
	wp_edit_posts_query(array('post_type'=>'news'));
	$posts = &$wp_the_query->posts;

//	foreach($GLOBALS as $k=>$v) {
//		if (!is_array($v) && !is_object($v)) echo "$k => $v\n";
//	}

//	var_export($wp);

	?>
	<table class="widefat fixed" >
		<thead>
			<tr>
				<th scope="col" class="check-column"></th>
				<th scope="col"><?php echo __('Headline');?></th>
				<th scope="col" class="column-tags"><?php echo __('Type');?></th>
				<th scope="col" class="column-tags"><?php echo __('Date');?></th>
				<th scope="col" class="check-column"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ( $posts as $post ) {
				$type=get_post_meta($post->ID, 'news_type', true);
				if (!$type) $type="News";
				if ( ( 0 == $post->ID ) || ( '0000-00-00 00:00:00' == $post->post_date_gmt ) )
					$date = date_i18n( OUTPUT_DATE_FORMAT, strtotime( current_time('mysql') ) );
				else
					$date = date_i18n( OUTPUT_DATE_FORMAT, strtotime( $post->post_date ) );
				echo "
			<tr>
				<td scope='row' class='check-column'></td>
				<td scope='row'><a href='post.php?post={$post->ID}&action=edit'>{$post->post_title}</a></td>
				<td scope='row'>$type</td>
				<td scope='row'>$date</td>
				<td scope='row' class='check-column'></td>
			</tr>
				";
			}
			?>
		</tbody>
	</table>
	<?php
}

add_filter('wp_insert_post_data','news_update');

function news_update($data) {
	if ($data['post_type']=='news') {
		if (isset($_POST['posted'])) {
			$data['post_date'] = date_i18n( 'Y-m-d H:i:s', strtotime( preg_replace('/(\d+)\/(\d+)\/(\d+)/','$2-$1-$3',esc_attr($_POST['posted'])) ) );
			$data['post_date_gmt'] = get_gmt_from_date($data['post_date']);
		}
	}
	return $data;
}

add_action('save_post','news_save',1);

function news_save() {
	global $post;

	if ($post->post_type != 'news') return;

	if (isset($_POST['news_type'])) {
		update_post_meta($post->ID, 'news_type', esc_attr($_POST['news_type']));
	}

	if (isset($_POST['url'])) {
		update_post_meta($post->ID, 'url', esc_attr($_POST['url']));
	}

	if (isset($_POST['teaser'])) {
		update_post_meta($post->ID, 'teaser', esc_attr($_POST['teaser']));
	}

	if ( !empty($_FILES) ) {
		add_filter('wp_read_image_metadata','news_save_file_description');
		// Upload File button was clicked
		$id = media_handle_upload('userfile', $post->ID);
		unset($_FILES);
		if ( is_wp_error($id) ) {
			$errors['upload_error'] = $id;
			$id = false;
		}
	}


}

function news_save_file_description($meta) {
	if (isset($_POST['filedesc'])) {
		$meta['caption'] = utf8_encode( trim( $_POST['filedesc'] ) );
	}
	return $meta;
}

add_filter('manage_edit-news_columns', 'manage_edit_news_columns');

function manage_edit_news_columns($headers) {

	$headers['title']='Headline';
	unset($headers['author']);
	unset($headers['date']);
	$headers['role']='Type';
	$headers['date']='Date';

	return $headers;
}

add_action('manage_posts_custom_column','manage_posts_news_column');

function manage_posts_news_column($cname) {
	global $post;

	if ($post->post_type != 'news') return;
	
	switch($cname) {
		case 'role':
			$type=get_post_meta($post->ID, 'news_type', true);
			if (!$type) $type="News";
			echo $type;
			break;
	}
}

add_action('restrict_manage_posts','restrict_manage_news');

function restrict_manage_news() {
	global $post_type;
	if ('news' != $post_type) return;

	if ( !is_singular() ) {

		$types = array('News', 'Newsletter', 'Press Release' );
		$t = isset($_GET['news_type']) ? $_GET['news_type'] : 0;
		?>
		<select name='news_type'>
		<option<?php selected( $t, 0 ); ?> value='0'><?php _e('Show all types'); ?></option>
		<?php
		foreach ($types as $type) {
			echo "<option ".selected( $t, $type )." value='$type'>$type</option>";
		}
		?>
		</select>
		<?php
		$sorting = array('Title');
		$s = isset($_GET['news_sort']) ? $_GET['news_sort'] : 0;
		?>
		<select name='news_sort'>
		<option<?php selected( $s, 0 ); ?> value='0'><?php _e('Sort by Date'); ?></option>
		<?php
		foreach ($sorting as $sort) {
			echo "<option ".selected( $s, $sort )." value='$sort'>Sort by $sort</option>";
		}
		?>
		</select>
	<?php }
}

add_action('pre_get_posts','pre_get_posts_news');

function pre_get_posts_news(&$t) {
	if (is_admin()
		&& isset($_GET['post_type']) && $_GET['post_type']=='news'
		&& isset($_GET['news_type']) && $_GET['news_type']
		) {

		$t->query_vars['meta_key']='news_type';
		$t->query_vars['meta_value']=esc_attr($_GET['news_type']);
	}
	if (is_admin()
		&& isset($_GET['post_type']) && $_GET['post_type']=='news'
		&& isset($_GET['news_sort']) && $_GET['news_sort']
		) {

		if ('Title'==$_GET['news_sort']) {
			$t->query_vars['orderby']='title';
			$t->query_vars['order']='ASC';
		}
	}
}