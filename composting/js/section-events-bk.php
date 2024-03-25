<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'events_init');

function events_init() {

	$args = array(
		'label' => __('Events'),
		'labels' => array(
				'edit_item' => __('Edit Events'),
				'add_new_item' => __('Add New'),
				'view_item' => __('View Events'),
			'search_items' => __( 'Search Events' ),  
		 	'not_found' => __( 'No Events found' ),  
			'not_found_in_trash' => __( 'No Events found in Trash' ),  
			'parent' => __( 'Parent Events' ), 
		),
		'singular_label' => __('Events'),
		'public' => true,
		'show_ui' => true, // show in admin
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'conference_record',
		'hierarchical' => false,
		'rewrite' => array("slug" => "events"), // links
		'supports' => array('thumbnail')
	);

	register_post_type( 'events' , $args );

//	register_taxonomy(
//		'mtype',
//		'events',
//		array ('hierarchical' => false, 'label' => __('Events tags'),
//				'singular_label' => __('Events tags'),
//				'query_var' => 'mtype')
//	);
}

add_action("admin_init", 'events_admin_init');

function events_admin_init() {
	remove_meta_box('submitdiv', 'events', 'normal');
}

add_action('add_meta_boxes_events','events_boxes_setup');

function events_boxes_setup() {
	wp_enqueue_script('editor');
	wp_enqueue_script('datepicker',get_bloginfo('template_directory').'/js/ui.datepicker.min.js',array('jquery-ui-core'),'1.7.3');
	wp_enqueue_style('jquery-ui-lightness',get_bloginfo('template_directory').'/js/'.JQUERY_UI_THEME.'/jquery-ui-1.7.3.custom.css');
	add_action('edit_form_advanced','events_form',1);
//	add_action('post_edit_form_tag','events_form_enctype');
}

//function events_form_enctype() {
//	echo ' enctype="multipart/form-data" ';
//}

function events_form() {
	global $post;

	echo __("<p>Please fill out the form below to add an events item. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

	$post_type_object = get_post_type_object($post->post_type);

	$location=get_post_meta($post->ID, 'location', true);
	$category=get_post_meta($post->ID, 'category', true);
	if (!$category) $category = "conference";
	$training=get_post_meta($post->ID, 'training',true);
	if (!$training) $training="No";

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
		<td><span class='file-error'>*</span>
			<label for="title">
				<span>Title</span>
			</label>
		</td>
		<td>
			<input type="text" name="post_title" size="80" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" id="title" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="category">
				<span>Category</span>
			</label>
		</td>
		<td>
			<input type="radio" name="category" id="category-conference" value="conference" <?php checked( $category, 'conference' ); ?> /> <label for="category-conference" class="selectit"><?php _e('conference'); ?></label><br />
			<input type="radio" name="category" id="category-training" value="training" <?php checked( $category, 'training' ); ?> /> <label for="category-training" class="selectit"><?php _e('training'); ?></label><br />
			<input type="radio" name="category" id="category-ICAW" value="ICAW" <?php checked( $category, 'ICAW' ); ?> /> <label for="category-ICAW" class="selectit"><?php _e('ICAW'); ?></label><br />
			<input type="radio" name="category" id="category-meetings" value="meetings" <?php checked( $category, 'meetings' ); ?> /> <label for="category-meetings" class="selectit"><?php _e('meetings'); ?></label><br />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="location">
				<span>Location</span>
			</label>
		</td>
		<td>
			<input type="text" name="location" size="80" value="<?php echo esc_attr( htmlspecialchars( $location ) ); ?>" id="location" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="start">
				<span>Start Date</span>
			</label>
		</td>
		<td>
			<?php

				if ( current_user_can($post_type_object->cap->publish_posts) ) {
					// Contributors don't get to choose the date of publish ?>
					<div style="max-width:100%;width:100%;" class="misc-pub-section curtime misc-pub-section-last">
						<span id="timestamp"><input name="start" id="start" size="10" value="<?php
							if ( ( 0 == $post->ID )  )
								echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( current_time('mysql') ) );
							else {
								$start = get_post_meta($post->ID, 'start', true);
								if ($start)
									echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( $start ) );
								else
									echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( $post->post_date ) );
							}
						?>">
						</span>
					</div>
					<script type="text/javascript">
					//<![CDATA[
					(function($) {
					$(document).ready(function() {
						$("#start").datepicker({ dateFormat: '<?php echo JS_DATE_FORMAT; ?>' });
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
		<td>&nbsp;
			<label for="deadline">
				<span>End Date</span>
			</label>
		</td>
		<td>
			<?php

				if ( current_user_can($post_type_object->cap->publish_posts) ) {
					// Contributors don't get to choose the date of publish ?>
					<div style="max-width:100%;width:100%;" class="misc-pub-section curtime misc-pub-section-last">
						<span id="timestamp"><input name="deadline" id="deadline" size="10" value="<?php
							if ( ( 0 == $post->ID ) )
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
		<td>
			<label for="url">
				<span>URL</span>
			</label>
		</td>
		<td>
			<input type="text" name="url" size="80" value="<?php echo esc_attr( htmlspecialchars( get_post_meta($post->ID, 'url',true) ) ); ?>" id="url" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td>
			<label for="teaser">
				<span>Teaser Text</span>
			</label>
		</td>
		<td>
			<input type="text" name="teaser" size="80" value="<?php echo esc_attr( htmlspecialchars( get_post_meta($post->ID, 'teaser',true) ) ); ?>" id="teaser" autocomplete="off" />
		</td>
	</tr>
	<tr>
		<td><span class='file-error'>*</span>
			<label for="display-input">
				<span>Details</span>
			</label>
		</td>
		<td>
			<?php the_editor($post->post_content,'content','title',false, ''); //printf($the_editor, $the_editor_content); ?>
		</td>
	</tr>
	<tr>
		<td>
			<label for="contact">
				<span>Contact</span>
			</label>
		</td>
		<td>
			<textarea rows="5" cols="90" name="contact" id="contact"><?php echo get_post_meta($post->ID, 'contact', true); ?></textarea>
		</td>
	</tr>
	<tr>
		<td>&nbsp;
			<label for="type-radio-training">
				<span>Training</span>
			</label>
		</td>
		<td>
			<input type="radio" name="training" id="type-radio-training-no" value="No" <?php checked( $training, 'No' ); ?> /> <label for="type-radio-training-no" class="selectit"><?php _e('No'); ?></label><br />
			<input type="radio" name="training" id="type-radio-training-yes" value="Yes" <?php checked( $training, 'Yes' ); ?> /> <label for="type-radio-training-yes" class="selectit"><?php _e('Yes'); ?></label><br />
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<?php if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) : ?>
			<input type="submit" name="save" id="save-post" class="button-primary" accesskey="p" value="<?php esc_attr_e('Add Event') ?>" />
			<?php else: ?>
			<input type="submit" name="save" id="save-post" class="button-primary" accesskey="p" value="<?php esc_attr_e('Update Event') ?>" />
			<?php endif; ?>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>

	<?php


}

add_action('save_post','events_save',1);

function events_save($post_id) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
     return;

	if (!($post_id && isset($_POST['post_type']) && 'events'==$_POST['post_type'])) return;
	
	if (isset($_POST['location'])) {
		update_post_meta($post_id, 'location', esc_attr($_POST['location']));
	}

	if (isset($_POST['contact'])) {
		update_post_meta($post_id, 'contact', esc_attr($_POST['contact']));
	}

	if (isset($_POST['training'])) {
		update_post_meta($post_id, 'training', esc_attr($_POST['training']));
	}

	if (isset($_POST['start'])) {
		update_post_meta($post_id, 'start', date_i18n( 'Y-m-d H:i:s', strtotime( preg_replace('/(\d+)\/(\d+)\/(\d+)/','$2-$1-$3',esc_attr($_POST['start'])) ) ));
	}

	if (isset($_POST['deadline'])) {
		update_post_meta($post_id, 'deadline', date_i18n( 'Y-m-d H:i:s', strtotime( preg_replace('/(\d+)\/(\d+)\/(\d+)/','$2-$1-$3',esc_attr($_POST['deadline'])) ) ));
	}

	if (isset($_POST['category'])) {
		update_post_meta($post_id, 'category', esc_attr($_POST['category']) );
	}

	if (isset($_POST['url'])) {
		update_post_meta($post_id, 'url', esc_attr($_POST['url']));
	}

	if (isset($_POST['teaser'])) {
		update_post_meta($post_id, 'teaser', esc_attr($_POST['teaser']));
	}

	if (isset($_POST['_event_http_referer'])) {
		add_filter('redirect_post_location','redirect_frontend_events',9999,2);
	}
}

function redirect_frontend_events($location, $post_id) {
	$location = '/admin/?page_id=46&new='.$post_id;
	return $location;
}

add_filter('manage_edit-events_columns', 'manage_edit_events_columns');

function manage_edit_events_columns($headers) {

	$headers['title']='Events';
	$headers['rel']='Start Date';
	$headers['role']='End Date';
	unset($headers['date']);
	unset($headers['author']);
	return $headers;
}

add_action('manage_posts_custom_column','manage_posts_events_column',1);

function manage_posts_events_column($cname) {
	global $post;

	if ($post->post_type != 'events') return;

	switch($cname) {
		case 'rel':
			if ( ( 0 == $post->ID ) || ( '0000-00-00 00:00:00' == $post->post_date_gmt ) )
				echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( current_time('mysql') ) );
			else {
				$start = get_post_meta($post->ID, 'start', true);
				if ($start)
					echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( $start ) );
				else
					echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( $post->post_date ) );
			}
			break;

		case 'role':
			if ( ( 0 == $post->ID ) || ( '0000-00-00 00:00:00' == $post->post_date_gmt ) )
				echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( current_time('mysql'))+WEEK_IN_SECOND  );
			else {
				$deadline = get_post_meta($post->ID, 'deadline', true);
				if ($deadline)
					echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( $deadline ) );
				else
					echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( $post->post_date )+WEEK_IN_SECOND  );
			}
			break;
	}
}

//add_filter('home_template','check_events_index');
//add_filter('index_template','check_events_index');
//
//function check_events_index($template) {
//	if (strpos($_SERVER['REQUEST_URI'],'/events/')===0) {
//		$template = locate_template(array('events_index.php'));
//		add_filter('posts_where_request','check_m_for_events',1);
//	}
//	return $template;
//}

add_filter('posts_where_request','check_m_for_events',1);

function check_m_for_events ($where) {
	global $wpdb;
	
	if ( isset($_GET['event_date']) && strpos($where, "posts.post_type = 'events'")!==false ) { //&& strpos($where,".meta_key = 'start'")!==false) {

		$m = '' . preg_replace('|[^0-9]|', '', absint($_GET['event_date']));
		$where .= " AND YEAR($wpdb->postmeta.meta_value)=" . substr($m, 0, 4);
		if ( strlen($m) > 5 )
			$where .= " AND MONTH($wpdb->postmeta.meta_value)=" . substr($m, 4, 2);
		if ( strlen($m) > 7 )
			$where .= " AND DAYOFMONTH($wpdb->postmeta.meta_value)=" . substr($m, 6, 2);
		if ( strlen($m) > 9 )
			$where .= " AND HOUR($wpdb->postmeta.meta_value)=" . substr($m, 8, 2);
		if ( strlen($m) > 11 )
			$where .= " AND MINUTE($wpdb->postmeta.meta_value)=" . substr($m, 10, 2);
		if ( strlen($m) > 13 )
			$where .= " AND SECOND($wpdb->postmeta.meta_value)=" . substr($m, 12, 2);
	}
	return $where;
}

class WP_Widget_Events_Calendar extends WP_Widget_Calendar {
	function WP_Widget_Events_Calendar() {
		$widget_ops = array('classname' => 'widget_events_calendar', 'description' => __( 'A calendar of your site&#8217;s events') );
		$this->WP_Widget('events_calendar', __('Events Calendar'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '&nbsp;' : $instance['title'], $instance, $this->id_base);
		echo $before_widget;
		echo '<h3 style="position:absolute;  margin-bottom:-30px; margin-left:179px; color:#333;">Events</h3>';
		echo '<div id="calendar_wrap">';
		$this->get_calendar();
		echo '</div>';
		echo $after_widget;
	}

	function add_events_to_home_url($url) {
		return preg_replace('/&event_date=\d+/', '', $_SERVER['REQUEST_URI']);
	}

	function get_calendar($initial = true, $echo = true) {
		global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;

		if ( isset($_GET['event_date']))
			$m = '' . preg_replace('|[^0-9]|', '', absint($_GET['event_date']));

		add_filter('option_home',array(&$this,'add_events_to_home_url'));
		$cache = array();
		$key = md5( $m . $monthnum . $year );
		if ( $cache = wp_cache_get( 'events_get_calendar', 'calendar' ) ) {
			if ( is_array($cache) && isset( $cache[ $key ] ) ) {
				if ( $echo ) {
					echo apply_filters( 'events_get_calendar',  $cache[$key] );
					return;
				} else {
					return apply_filters( 'events_get_calendar',  $cache[$key] );
				}
			}
		}

		if ( !is_array($cache) )
			$cache = array();

		// Quick check. If we have no posts at all, abort!
		if ( !$posts ) {
			$gotsome = $wpdb->get_var("SELECT 1 as test FROM $wpdb->posts WHERE post_type = 'events' AND post_status = 'publish' LIMIT 1");
			if ( !$gotsome ) {
				$cache[ $key ] = '';
				wp_cache_set( 'events_get_calendar', $cache, 'calendar' );
				return;
			}
		}

		if ( isset($_GET['w']) )
			$w = ''.intval($_GET['w']);

		// week_begins = 0 stands for Sunday
		$week_begins = intval(get_option('start_of_week'));

		// Let's figure out when we are
		if ( !empty($monthnum) && !empty($year) ) {
			$thismonth = ''.zeroise(intval($monthnum), 2);
			$thisyear = ''.intval($year);
		} elseif ( !empty($w) ) {
			// We need to get the month from MySQL
			$thisyear = ''.intval(substr($m, 0, 4));
			$d = (($w - 1) * 7) + 6; //it seems MySQL's weeks disagree with PHP's
			$thismonth = $wpdb->get_var("SELECT DATE_FORMAT((DATE_ADD('${thisyear}0101', INTERVAL $d DAY) ), '%m')");
		} elseif ( !empty($m) ) {
			$thisyear = ''.intval(substr($m, 0, 4));
			if ( strlen($m) < 6 )
					$thismonth = '01';
			else
					$thismonth = ''.zeroise(intval(substr($m, 4, 2)), 2);
		} else {
			$thisyear = gmdate('Y', current_time('timestamp'));
			$thismonth = gmdate('m', current_time('timestamp'));
		}

		$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear);

		// Get the next and previous month and year with at least one post
		$previous = $wpdb->get_row("SELECT DISTINCT MONTH(meta_value) AS month, YEAR(meta_value) AS year
			FROM $wpdb->posts
			JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id)
			WHERE TIMESTAMP(meta_value) < TIMESTAMP('$thisyear-$thismonth-01')
			AND $wpdb->postmeta.meta_key = 'start'
			AND post_type = 'events' AND post_status = 'publish'
				ORDER BY meta_value DESC
				LIMIT 1");
		$next = $wpdb->get_row("SELECT	DISTINCT MONTH(meta_value) AS month, YEAR(meta_value) AS year
			FROM $wpdb->posts
			JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id)
			WHERE TIMESTAMP(meta_value) > TIMESTAMP('$thisyear-$thismonth-01')
			AND $wpdb->postmeta.meta_key = 'start'
			AND MONTH( meta_value ) != MONTH( '$thisyear-$thismonth-01' )
			AND post_type = 'events' AND post_status = 'publish'
				ORDER	BY meta_value ASC
				LIMIT 1");

		/* translators: Calendar caption: 1: month name, 2: 4-digit year */
		$calendar_caption = _x('%1$s %2$s', 'calendar caption');
		$calendar_output = '<table id="wp-calendar" summary="' . esc_attr__('Calendar') . '">
		<caption>' . sprintf($calendar_caption, $wp_locale->get_month($thismonth), date('Y', $unixmonth)) . '</caption>
		<thead>
		<tr>';

		$myweek = array();

		for ( $wdcount=0; $wdcount<=6; $wdcount++ ) {
			$myweek[] = $wp_locale->get_weekday(($wdcount+$week_begins)%7);
		}

		foreach ( $myweek as $wd ) {
			$day_name = (true == $initial) ? $wp_locale->get_weekday_initial($wd) : $wp_locale->get_weekday_abbrev($wd);
			$wd = esc_attr($wd);
			$calendar_output .= "\n\t\t<th scope=\"col\" title=\"$wd\">$day_name</th>";
		}

		$calendar_output .= '
		</tr>
		</thead>

		<tfoot>
		<tr>';

		if ( $previous ) {
			$calendar_output .= "\n\t\t".'<td colspan="3" id="prev"><a href="' . $this->adopt_url(get_month_link($previous->year, $previous->month)) . '" title="' . sprintf(__('View posts for %1$s %2$s'), $wp_locale->get_month($previous->month), date('Y', mktime(0, 0 , 0, $previous->month, 1, $previous->year))) . '">&laquo; ' . $wp_locale->get_month_abbrev($wp_locale->get_month($previous->month)) . '</a></td>';
		} else {
			$calendar_output .= "\n\t\t".'<td colspan="3" id="prev" class="pad">&nbsp;</td>';
		}

		$calendar_output .= "\n\t\t".'<td class="pad">&nbsp;</td>';

		if ( $next ) {
			$calendar_output .= "\n\t\t".'<td colspan="3" id="next"><a href="' . $this->adopt_url(get_month_link($next->year, $next->month)) . '" title="' . esc_attr( sprintf(__('View posts for %1$s %2$s'), $wp_locale->get_month($next->month), date('Y', mktime(0, 0 , 0, $next->month, 1, $next->year))) ) . '">' . $wp_locale->get_month_abbrev($wp_locale->get_month($next->month)) . ' &raquo;</a></td>';
		} else {
			$calendar_output .= "\n\t\t".'<td colspan="3" id="next" class="pad">&nbsp;</td>';
		}

		$calendar_output .= '
		</tr>
		</tfoot>

		<tbody>
		<tr>';

		// Get days with posts
		$dayswithposts = $wpdb->get_results("SELECT DISTINCT DAYOFMONTH(meta_value)
			FROM $wpdb->posts
			JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id)
			WHERE MONTH(meta_value) = '$thismonth'
			AND YEAR(meta_value) = '$thisyear'
			AND post_type = 'events' AND post_status = 'publish'
			AND $wpdb->postmeta.meta_key = 'start'
			AND post_date < '" . current_time('mysql') . '\'', ARRAY_N);
		if ( $dayswithposts ) {
			foreach ( (array) $dayswithposts as $daywith ) {
				$daywithpost[] = $daywith[0];
			}
		} else {
			$daywithpost = array();
		}

		if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'camino') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'safari') !== false)
			$ak_title_separator = "\n";
		else
			$ak_title_separator = ', ';

		$ak_titles_for_day = array();
		$ak_post_titles = $wpdb->get_results("SELECT ID, post_title, DAYOFMONTH(meta_value) as dom "
			."FROM $wpdb->posts "
			."JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id)"
			."WHERE YEAR(meta_value) = '$thisyear' "
			."AND MONTH(meta_value) = '$thismonth' "
			."AND post_date < '".current_time('mysql')."' "
			."AND post_type = 'events' AND post_status = 'publish' "
			."AND $wpdb->postmeta.meta_key = 'start' "
		);
		if ( $ak_post_titles ) {
			foreach ( (array) $ak_post_titles as $ak_post_title ) {

					$post_title = esc_attr( apply_filters( 'the_title', $ak_post_title->post_title, $ak_post_title->ID ) );

					if ( empty($ak_titles_for_day['day_'.$ak_post_title->dom]) )
						$ak_titles_for_day['day_'.$ak_post_title->dom] = '';
					if ( empty($ak_titles_for_day["$ak_post_title->dom"]) ) // first one
						$ak_titles_for_day["$ak_post_title->dom"] = $post_title;
					else
						$ak_titles_for_day["$ak_post_title->dom"] .= $ak_title_separator . $post_title;
			}
		}


		// See how much we should pad in the beginning
		$pad = calendar_week_mod(date('w', $unixmonth)-$week_begins);
		if ( 0 != $pad )
			$calendar_output .= "\n\t\t".'<td colspan="'. esc_attr($pad) .'" class="pad">&nbsp;</td>';

		$daysinmonth = intval(date('t', $unixmonth));
		for ( $day = 1; $day <= $daysinmonth; ++$day ) {
			if ( isset($newrow) && $newrow )
				$calendar_output .= "\n\t</tr>\n\t<tr>\n\t\t";
			$newrow = false;

			if ( $day == gmdate('j', current_time('timestamp')) && $thismonth == gmdate('m', current_time('timestamp')) && $thisyear == gmdate('Y', current_time('timestamp')) )
				$calendar_output .= '<td id="today">';
			else
				$calendar_output .= '<td>';

			if ( in_array($day, $daywithpost) ) // any posts today?
					$calendar_output .= '<a href="' . $this->event_url(get_day_link($thisyear, $thismonth, $day)) . "\" title=\"" . esc_attr($ak_titles_for_day[$day]) . "\">$day</a>";
			else
				$calendar_output .= $day;
			$calendar_output .= '</td>';

			if ( 6 == calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins) )
				$newrow = true;
		}

		$pad = 7 - calendar_week_mod(date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear))-$week_begins);
		if ( $pad != 0 && $pad != 7 )
			$calendar_output .= "\n\t\t".'<td class="pad" colspan="'. esc_attr($pad) .'">&nbsp;</td>';

		$calendar_output .= "\n\t</tr>\n\t</tbody>\n\t</table>";

		$cache[ $key ] = $calendar_output;
		wp_cache_set( 'events_get_calendar', $cache, 'calendar' );

		remove_filter('option_home',array(&$this,'add_events_to_home_url'));

		if ( $echo )
			echo apply_filters( 'events_get_calendar',  $calendar_output );
		else
			return apply_filters( 'events_get_calendar',  $calendar_output );

	}

	function adopt_url($url) {
		return str_replace('/?m=', '/?page_id=46&event_date=', $url);
	}

	function event_url($url) {
		return preg_replace('/\/\?.*=/', '/?page_id=46&event_date=', $url);
	}

}

register_widget('WP_Widget_Events_Calendar');

add_shortcode('event_nonce', 'add_nonce_for_events');

function add_nonce_for_events() {
	return wp_nonce_field('add-events','_wpnonce', false , false );
}