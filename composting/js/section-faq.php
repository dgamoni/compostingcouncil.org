<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'faq_init');

function faq_init() {

	$args = array(
		'label' => __('FAQ Manager'),
		'labels' => array(
				'edit_item' => __('Edit Question'),
				'add_new_item' => __('Add New'),
				'view_item' => __('View Question'),
				
				'search_items' => __( 'Search Questions' ),  
		 	'not_found' => __( 'No Questions found' ),  
			'not_found_in_trash' => __( 'No Questions found in Trash' ),  
			
		),
		'singular_label' => __('Questions'),
		'public' => true,
		'show_ui' => true, // show in admin
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array("slug" => "faq"), // links
		'supports' => array('thumbnail')
	);

	register_post_type( 'faq' , $args );

	register_taxonomy(
		'faq_category',
		'faq',
		array ('hierarchical' => false, 'label' => __('Question Categories'),
				'singular_label' => __('Question Categories'))
	);
}

add_action("admin_init", 'faq_admin_init');

function faq_admin_init() {
	remove_meta_box('submitdiv', 'faq', 'normal');
	remove_meta_box('tagsdiv-faq_category', 'faq', 'normal');
}

add_action('add_meta_boxes_faq','faq_boxes_setup');

function faq_boxes_setup() {
	wp_enqueue_script('editor');
	wp_enqueue_script('datepicker',get_bloginfo('template_directory').'/js/ui.datepicker.min.js',array('jquery-ui-core'),'1.7.3');
	wp_enqueue_style('jquery-ui-lightness',get_bloginfo('template_directory').'/js/'.JQUERY_UI_THEME.'/jquery-ui-1.7.3.custom.css');
	add_action('edit_form_advanced','faq_form',1);
}

function faq_form() {
	global $post;

	echo __("<p>Please fill out the form below to add a new item. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

	$post_type_object = get_post_type_object($post->post_type);
	$cats = get_terms('faq_category','hide_empty=0');
	$post_cats = wp_get_object_terms($post->ID, 'faq_category');
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
				<span>Question</span>
			</label>
		</td>
		<td>
			<input type="text" name="post_title" size="80" tabindex="1" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="content">
				<span>Answer</span>
			</label>
		</td>
		<td>
			<?php the_editor($post->post_content,'content','title',false);  ?>
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

add_filter('wp_insert_post_data','faq_update');

function faq_update($data) {
	if ($data['post_type']=='faq') {
		if (isset($_POST['posted'])) {
			$data['post_date'] = date_i18n( 'Y-m-d H:i:s', strtotime( preg_replace('/(\d+)\/(\d+)\/(\d+)/','$2-$1-$3',esc_attr($_POST['posted'])) ) );
			$data['post_date_gmt'] = get_gmt_from_date($data['post_date']);
		}
	}
	return $data;
}

add_action('save_post','faq_save',1);

function faq_save() {
	global $post;

	if ($post->post_type != 'faq') return;

	if (isset($_POST['category'])) {
		wp_set_object_terms($post->ID,esc_attr($_POST['category']),'faq_category');
	}
}

add_filter('manage_edit-faq_columns', 'manage_edit_faq_columns');

function manage_edit_faq_columns($headers) {

	$headers['title']='Question';
	$headers['rel']='Category';
	unset($headers['date']);
	unset($headers['author']);
	return $headers;
}

add_action('manage_posts_custom_column','manage_posts_faq_column',1);

function manage_posts_faq_column($cname) {
	global $post;

	if ($post->post_type != 'faq') return;

	switch($cname) {
		case 'rel':
			$tags = get_the_terms( $id, 'faq_category' );
			if ( !empty( $tags ) ) {
				$out = array();
				foreach ( $tags as $c )
					$out[] = esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'faq_category', 'display')) ;
				echo join( ', ', $out );
			} else {
				_e('No Tags');
			}
			break;

	}
}

add_action('restrict_manage_posts','restrict_manage_faq');

function restrict_manage_faq() {
	global $post_type;
	if ('faq' != $post_type) return;

	if ( !is_singular() ) {

		$cats = get_terms('faq_category','hide_empty=1');
		$t = isset($_GET['faq_category']) ? $_GET['faq_category'] : 0;
		?>
		<select name='faq_category'>
		<option<?php selected( $t, 0 ); ?> value='0'><?php _e('Show all categories'); ?></option>
		<?php
		foreach ($cats as $c) {
			echo "<option ".selected( $t, $c->slug )." value='{$c->slug}'>{$c->name}</option>";
		}
		?>
		</select>
	<?php }
}
