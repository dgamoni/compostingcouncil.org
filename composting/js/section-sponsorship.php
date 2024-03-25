<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'sponsorship_init');

function sponsorship_init() {

	$args = array(
		'label' => __('Sponsor'),
		'labels' => array(
				'edit_item' => __('Edit Sponsor'),
				'add_new_item' => __('Add New'),
				'view_item' => __('View Sponsor'),
		),
		'singular_label' => __('Sponsor'),
		'public' => true,
		'show_ui' => true, // show in admin
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
		'capability_type' => 'conference_record',
		'hierarchical' => false,
		'rewrite' => array("slug" => "sponsorship"), // links
		'supports' => array('thumbnail')
	);

	register_post_type( 'sponsorship' , $args );

//	sponsorship_taxonomy(
//		'mtype',
//		'sponsorship',
//		array ('hierarchical' => false, 'label' => __('Sponsor tags'),
//				'singular_label' => __('Sponsor tags'),
//				'query_var' => 'mtype')
//	);
}

add_action("admin_init", 'sponsorship_admin_init');

function sponsorship_admin_init() {
	remove_meta_box('submitdiv', 'sponsorship', 'normal');
}

add_action('add_meta_boxes_sponsorship','sponsorship_boxes_setup');

function sponsorship_boxes_setup() {
	wp_enqueue_script('editor');
	wp_enqueue_script('forms_scrypt', get_template_directory_uri().'/js/forms.js');
	add_action('edit_form_advanced','sponsorship_form',1);
	add_action('post_edit_form_tag','sponsorship_form_enctype');
}

function sponsorship_form_enctype() {
	echo ' enctype="multipart/form-data" ';
}

$sponsorship_fields = explode(' ', 'name title address city state zipcode country phone fax email website');
$sponsorship_required = array_flip(explode(' ', 'name address city state zipcode country phone email'));
$sponsorship_cost_fields = explode(' ', 'promo_name promo_sum level event_1 event_2 event_3 event_4 event_4_quantity event_5 event_5_quantity event_6 event_7 event_7_quantity event_8 event_8_quantity event_9 equipment_1 equipment_2 equipment_3 equipment_4 equipment_5 equipment_6');

function sponsorship_form() {
	global $post;

	echo __("<p>Please fill out the form below to add an Sponsor. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

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
		global $sponsorship_fields, $sponsorship_required;
		$tab_index = 3;

		foreach ($sponsorship_fields as $f ) {
			?>
			<tr>
				<td>
					<?php
					if (isset($sponsorship_required[$f])) echo "<span class='file-error'>*</span>";
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
				<span>Text</span>
			</label>
		</td>
		<td>
			<?php the_editor($post->post_content,'content','title',false, $tab_index++); //printf($the_editor, $the_editor_content); ?>
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
    <tr><td><label for="image">Company Logo</label></td>
        <td>
            <input type="file" id="image" name="image" tabindex="<?php echo $tab_index++; ?>" />
        </td>
    </tr>

	<tr><td colspan="2">
		<h2>Sponsorship Agreement</h2>
		<table>
		<tr><td>
			Please enter your company name as you wish to appear in promotional materials related to the Conference
		</td></tr>
		<tr><td>
			<input type="text" name="promo_name" id="promo_name" value="<?php echo esc_attr( htmlspecialchars( $post_data["promo_name"] ) ); ?>" tabindex="<?php echo $tab_index++; ?>" class="fill" />
		</td></tr>
		<tr><td>
			hereby agrees to contribute the sum of
			$ <input type="text" name="promo_sum" id="promo_sum" value="<?php echo esc_attr( htmlspecialchars( $post_data["promo_sum"] ) ); ?>" tabindex="<?php echo $tab_index++; ?>" class="fill w12h" />
			payable to the US Composting Council to become a "sponsor" of the Annual Conference to be held January 24-27, 2010, in Orlando, Florida.
		</td></tr>
		</table>

		<h2>Sponsorship Levels</h2>
		<dl class="full">
			<dd>
				<table>
				
          
                
                 <tr>
					<td width="22"><input type="radio" id="level_1" name="level" tabindex="<?php echo $tab_index++; ?>" <?php checked($post_data["level"],'1'); ?> value="1" /></td>
					<th width="200" align="left"><label for="level_1">Double Diamond</label></th>
					<td class="nowrap pad-right">Contribution of</td>
					<td class="nowrap">$25,000 or more</td>
				</tr>
                
                
                
                <tr>
					<td width="22"><input type="radio" id="level_2" name="level" tabindex="<?php echo $tab_index++; ?>" <?php checked($post_data["level"],'2'); ?> value="2" /></td>
					<th width="200" align="left"><label for="level_2">Double Platinum</label></th>
					<td class="nowrap pad-right">Contribution between</td>
					<td class="nowrap">$20,000-$24,999</td>
				</tr>
                
				<tr>
					<td><input type="radio" id="level_3" name="level" <?php checked($post_data["level"],'3'); ?> value="3"/></td>
					<th align="left"><label for="level_3">Double Gold</label></th>
					<td class="nowrap pad-right">Contribution between</td>
					<td class="nowrap">$15,000-$19,999</td>
				</tr>
                
                <tr>
					<td><input type="radio" id="level_4" name="level" <?php checked($post_data["level"],'4'); ?> value="4"/></td>
					<th align="left"><label for="level_4">Diamond</label></th>
					<td class="nowrap pad-right">Contribution between</td>
					<td class="nowrap">$10,000-$14,999</td>
				</tr>
                
                
                
                
				<tr>
					<td><input type="radio" id="level_5" name="level" <?php checked($post_data["level"],'5'); ?> value="5" /></td>
					<th align="left"><label for="level_5">Platinum Sponsor</label></th>
					<td class="nowrap pad-right">Contribution between</td>
					<td class="nowrap">$7,500 and $9,999</td>
				</tr>
				<tr>
					<td><input type="radio" id="level_6" name="level" <?php checked($post_data["level"],'6'); ?> value="6" /></td>
					<th align="left"><label for="level_6">Gold Sponsor</label></th>
					<td class="nowrap pad-right">Contribution between</td>
					<td class="nowrap">$5,000 and $7,499</td>
				</tr>
				<tr>
					<td><input type="radio" id="level_7" name="level" <?php checked($post_data["level"],'7'); ?> value="7" /></td>
					<th align="left"><label for="level_7">Silver Sponsor</label></th>
					<td class="nowrap pad-right">Contribution between</td>
					<td class="nowrap">$2,500 and $4,999</td>
				</tr>
				<tr>
					<td><input type="radio" id="level_8" name="level" <?php checked($post_data["level"],'8'); ?> value="8" /></td>
					<th align="left"><label for="level_8">Bronze Sponsor</label></th>
					<td class="nowrap pad-right">Contribution between</td>
					<td class="nowrap">$1,000 and $2,499</td>
				</tr>
				<tr>
					<td><input type="radio" id="level_9" name="level" <?php checked($post_data["level"],'9'); ?> value="9" /></td>
					<th align="left"><label for="level_9">Benefactor</label></th>
					<td class="nowrap pad-right">Contribution between</td>
					<td class="nowrap">$500 and $999</td>
				</tr>
				</table>
			</dd>
		</dl>

		<h2>Event Sponsorship</h2>
		<table id="events" width="100%">
		<tr>
			<td width="22">
				<input id="event_1" type="checkbox" name="event_1" <?php checked($post_data["event_1"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="event_1">Welcome Reception</label></th>
			<td width="85">$10,000*</td>
			<td width="65"></td>
		</tr>
		<tr>
			<td>
				<input id="event_2" type="checkbox" name="event_2" <?php checked($post_data["event_2"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="event_2">Exhibitors Reception</label></th>
			<td>$15,000*</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<input id="event_3" type="checkbox" name="event_3" <?php checked($post_data["event_3"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="event_3">Awards Luncheon</label></th>
			<td>$12,500*</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<input id="event_4" type="checkbox" name="event_4" <?php checked($post_data["event_4"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="event_4">Conference Breakfasts in Exhibit Hall</label></th>
			<td>$4,500 each**</td>
			<td>x <input type="text" id="event_4_quantity" name="event_4_quantity" tabindex="<?php echo $tab_index++; ?>" value="<?php echo esc_attr( htmlspecialchars( $post_data["event_4_quantity"] ) ); ?>" maxlength="4" class="fill w12h" /></td>
		</tr>
		<tr>
			<td>
				<input id="event_5" type="checkbox" name="event_5" <?php checked($post_data["event_5"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="event_5">Conference Breaks in Exhibit Hall</label></th>
			<td>$4,500 each**</td>
			<td>x <input type="text" id="event_5_quantity" name="event_5_quantity" tabindex="<?php echo $tab_index++; ?>" value="<?php echo esc_attr( htmlspecialchars( $post_data["event_5_quantity"] ) ); ?>" maxlength="4" class="fill w12h" /></td>
		</tr>
		<tr>
			<td>
				<input id="event_6" type="checkbox" name="event_6" <?php checked($post_data["event_6"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="event_6">Keynote Speaker</label></th>
			<td>$5,000</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<input id="event_7" type="checkbox" name="event_7" <?php checked($post_data["event_7"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="event_7">Networking Breakfasts</label></th>
			<td>$1,500 each<sup>&dagger;</sup></td>
			<td>x <input type="text" id="event_7_quantity" name="event_7_quantity" tabindex="<?php echo $tab_index++; ?>" value="<?php echo esc_attr( htmlspecialchars( $post_data["event_7_quantity"] ) ); ?>" maxlength="4" class="fill w12h" /></td>
		</tr>
		<tr>
			<td>
				<input id="event_8" type="checkbox" name="event_8" <?php checked($post_data["event_8"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="event_8">Pre-conference Training Courses &amp; Workshops</label></th>
			<td>$2,500 each<sup>&dagger;&dagger;</sup></td>
			<td>x <input type="text" id="event_8_quantity" name="event_8_quantity" tabindex="<?php echo $tab_index++; ?>" value="<?php echo esc_attr( htmlspecialchars( $post_data["event_8_quantity"] ) ); ?>" maxlength="4" class="fill w12h" /></td>
		</tr>
		<tr>
			<td>
				<input id="event_9" type="checkbox" name="event_9" <?php checked($post_data["event_9"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="event_9">Conference Attache</label></th>
			<td>$5,000</td>
			<td></td>
		</tr>
		</table><br />

		<table>
		<tr valign="top">
			<td align="right">*</td>
			<td>Co-Sponsorships Available</td>
		</tr>
		<tr valign="top">
			<td align="right">**</td>
			<td>4 Breaks &amp; 2 Breakfast Sponsors Available</td>
		</tr>
		<tr valign="top">
			<td align="right"><sup>&dagger;</sup></td>
			<td>In Breakout Rooms</td>
		</tr>
		<tr valign="top">
			<td align="right"><sup>&dagger;&dagger;</sup></td>
			<td>Training courses: 
			</td>
		</tr>
		</table>

		<h2>Equipment Demonstration Sponsorships</h2>
		<table id="equipment" width="100%">
		<tr>
			<td width="22">
				<input id="equipment_1" type="checkbox" name="equipment_1" <?php checked($post_data["equipment_1"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="equipment_1">Luncheon at Host Compost Facility</label></th>
			<td width="85">$5,000*</td>
			<td width="55"></td>
		</tr>
		<tr>
			<td>
				<input id="equipment_2" type="checkbox" name="equipment_2" <?php checked($post_data["equipment_2"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="equipment_2">Transportation (buses for attendees)</label></th>
			<td>$3,500*</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<input id="equipment_3" type="checkbox" name="equipment_3" <?php checked($post_data["equipment_3"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="equipment_3">Tent, tables and chairs</label></th>
			<td>$2,500*</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<input id="equipment_4" type="checkbox" name="equipment_4" <?php checked($post_data["equipment_4"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="equipment_4">Hard Hats</label></th>
			<td>$2,000*</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<input id="equipment_5" type="checkbox" name="equipment_5" <?php checked($post_data["equipment_5"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="equipment_5">Morning Refreshments (coffee, pastries, etc.)</label></th>
			<td>$1,000</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<input id="equipment_6" type="checkbox" name="equipment_6" <?php checked($post_data["equipment_6"],'1'); ?> value="1" tabindex="<?php echo $tab_index++; ?>"  />
			</td>
			<th align="left"><label for="equipment_6">Bottled Water</label></th>
			<td>$1,000</td>
			<td></td>
		</tr>
		</table><br />


	</td></tr>

	<tr>
		<td></td>
		<td>
			<?php if ( !in_array( $post->post_status, array('publish', 'future', 'private') ) || 0 == $post->ID ) : ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="<?php echo $tab_index; ?>" accesskey="r" value="<?php esc_attr_e('Add Sponsor') ?>" />
			<?php else: ?>
			<input type="submit" name="save" id="save-post" class="button-primary" tabindex="<?php echo $tab_index; ?>" accesskey="r" value="<?php esc_attr_e('Update Sponsor') ?>" />
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

function sponsorship_print_html($post) {

	ob_start();

	$post_type_object = get_post_type_object($post->post_type);

	$post_data = get_post_meta($post->ID, 'post_data', true);
	if (!$post_data) $post_data=array();

	?> <span>Company:</span> <?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?><br/><?php
		global $sponsorship_fields, $sponsorship_required;
		$tab_index = 3;

		foreach ($sponsorship_fields as $f ) {
			?> <span><?php echo ucfirst($f); ?>:</span> <?php echo $post_data[$f]; ?><br/><?php
		}
	?> <span>Text:</span> <?php echo $post->post_content; ?><br/><?php
	?> <span>Company Logo:</span> <?php

	$args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,
		'post_status' => null,
		'post_parent' => $post->ID
		);
	$attachments = get_posts($args);
	if ($attachments) {
		foreach ($attachments as $attachment) {
			the_attachment_link($attachment->ID, false);
			echo "<span class='clear alignleft'>{$attachment->post_content}</span><br/>";
		}
	}
	?>
<br/>
<h2>Sponsorship Levels</h2>
 <?php
	switch ($post_data["level"]) {
		case '1': echo "Double Diamond<br/>"; break;
		case '2': echo "Double Platinum<br/>"; break;
		case '3': echo "Double Gold<br/>"; break;
		case '4': echo "Diamond Sponsor<br/>"; break;
		case '5': echo "Platinum Sponsor<br/>"; break;
		case '6': echo "Gold Sponsor<br/>"; break;
		case '7': echo "Silver Sponsor<br/>"; break;
		case '8': echo "Bronze Sponsor<br/>"; break;
		case '9': echo "Benefactor<br/>"; break;
	}
 ?>
<br/>
<h2>Event Sponsorship</h2>
<?php
	if ($post_data["event_1"]=='1') echo " Welcome Reception ($10,000) <br/> ";
	if ($post_data["event_2"]=='1') echo " Exhibitors Reception ($15,000) <br/> ";
	if ($post_data["event_3"]=='1') echo " Awards Luncheon ($12,500) <br/> ";
	if ($post_data["event_4"]=='1') echo " Conference Breakfasts in Exhibit Hall ($4,500 x {$post_data["event_4_quantity"]}) <br/> ";
	if ($post_data["event_5"]=='1') echo " Conference Breaks in Exhibit Hall ($4,500 x {$post_data["event_5_quantity"]}) <br/> ";
	if ($post_data["event_6"]=='1') echo " Keynote Speaker ($5,000) <br/> ";
	if ($post_data["event_7"]=='1') echo " Networking Breakfasts ($1,500 x {$post_data["event_7_quantity"]}) <br/> ";
	if ($post_data["event_8"]=='1') echo " Pre-conference Training Courses &amp; Workshops ($2,500 x {$post_data["event_8_quantity"]}) <br/>  ";
	if ($post_data["event_9"]=='1') echo " Conference Attache ($5,000) <br/>  ";
?>
<br/>
<h2>Equipment Demonstration Sponsorships</h2>
<?php
	if ($post_data["equipment_1"]=='1') echo " Luncheon at Host Compost Facility ($5,000)<br/> ";
	if ($post_data["equipment_2"]=='1') echo " Transportation (buses for attendees) ($3,500)<br/> ";
	if ($post_data["equipment_3"]=='1') echo " Tent, tables and chairs ($2,500)<br/> ";
	if ($post_data["equipment_4"]=='1') echo " Hard Hats ($2,000)<br/> ";
	if ($post_data["equipment_5"]=='1') echo " Morning Refreshments (coffee, pastries, etc.) ($1,000)<br/> ";
	if ($post_data["equipment_6"]=='1') echo " Bottled Water ($1,000)<br/> ";
?>
<br/>
<h2>Sponsorship Agreement</h2>
 <?php echo esc_attr( htmlspecialchars( $post_data["promo_name"] ) ); ?> hereby agrees to contribute the sum of $<?php echo esc_attr( htmlspecialchars( $post_data["promo_sum"] ) ); ?>	payable to the US Composting Council<br/>  to become a "sponsor" of the Annual Conference.<br/>
<?php

	$ret = ob_get_contents();
	ob_end_clean();

	return $ret;

}

add_action('save_post','sponsorship_save',1);

function sponsorship_save($post_id) {

	if (!($post_id && isset($_POST['post_type']) && 'sponsorship'==$_POST['post_type'])) return;
	
	$post_data=array();
	
	global $sponsorship_fields, $sponsorship_required, $sponsorship_cost_fields;
	
	foreach ($sponsorship_fields as $f) {
		if (isset($_POST[$f])) $post_data[$f]=esc_attr($_POST[$f]);
		else $post_data[$f]='';
	}

	foreach ($sponsorship_cost_fields as $f) {
		if (isset($_POST[$f])) $post_data[$f]=esc_attr($_POST[$f]);
		else $post_data[$f]='';
	}

	update_post_meta($post_id, 'post_data', $post_data );

	if ( !empty($_FILES) ) {
		// Upload File button was clicked
		$id = media_handle_upload('image', $post_id);
		unset($_FILES);
		if ( is_wp_error($id) ) {
			$errors['upload_error'] = $id;
			$id = false;
		}
	}

	if (isset($_POST['_sponsorship_http_referer'])) {
		// WP e-Commerce integration
		if (function_exists('wpsc_insert_product')) {
			$uscc_number = '';
			if (is_user_logged_in()) {
				$uscc_number = 'uscc#'.wp_get_current_user()->uscc;
			}

			$product_data = array(
				'name' =>esc_attr($_POST['post_title'])." sponsorship $uscc_number",
				'description' => "level is {$post_data['level']}",

				'notax' => 1,
				'publish' => 1,
				'active' => 1,
				'no_shipping' => 1,

				'price' => $post_data['promo_sum']
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
			add_filter('redirect_post_location','redirect_to_cart_sponsorship',9999,2);
		} else {
			add_filter('redirect_post_location','redirect_frontend_sponsorship',9999,2);
		}
	}
}

function redirect_frontend_sponsorship($location, $post_id) {
	return get_home_url().'?post_type=sponsorship&p='.$post_id;
}
function redirect_to_cart_sponsorship($location, $post_id) {
	return get_option('shopping_cart_url');
}

add_action('wpsc_transaction_result_cart_item','sponsorship_track_transactions');

function sponsorship_track_transactions($data) {
	$product_id = $data['cart_item']['prodid'];
	$status = $data['purchase_log']['processed'];
	$posts = get_posts(array(
			'post_type' => 'sponsorship',
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

add_filter('manage_edit-sponsorship_columns', 'manage_edit_sponsorship_columns');

function manage_edit_sponsorship_columns($headers) {

	$headers['title']='Company';
	$headers['rel']='USCC #';
	$headers['role']='E-mail';
	unset($headers['date']);
	unset($headers['author']);
	return $headers;
}

add_action('manage_posts_custom_column','manage_posts_sponsorship_column',1);

function manage_posts_sponsorship_column($cname) {
	global $post;

	if ($post->post_type != 'sponsorship') return;
	$post_data = get_post_meta($post->ID, 'post_data', true);

	switch($cname) {

		case 'role':
			echo $post_data['email'];
			break;
		case 'rel':
			echo get_userdata($post->post_author)->uscc;
			break;
	}
}

add_filter('home_template','check_sponsorship_index');
add_filter('index_template','check_sponsorship_index');

function check_sponsorship_index($template) {
	if (strpos($_SERVER['REQUEST_URI'],'/sponsorship/')===0) {
		$template = locate_template(array('sponsorship_index.php'));
	}
	return $template;
}

add_shortcode('sponsorship_nonce', 'add_nonce_for_sponsorship');
function add_nonce_for_sponsorship() {
	return wp_nonce_field('add-sponsorship','_wpnonce', false , false );
}

?>