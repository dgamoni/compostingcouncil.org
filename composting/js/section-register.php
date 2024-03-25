<?php
/*
 add extra fields while writing your post content - with inputs, textareas, etc
*/

add_action('init', 'register_init');

function register_init()
{

    $args = array(
        'label' => __('Registrant'),
        'labels' => array(
            'edit_item' => __('Edit Registrant'),
            'add_new_item' => __('Add New'),
            'view_item' => __('View Registrant'),

            'search_items' => __('Search Registrant'),
            'not_found' => __('No Registrant found'),
            'not_found_in_trash' => __('No Registrant found in Trash'),

        ),
        'singular_label' => __('Registrant'),
        'public' => true,
        'show_ui' => true, // show in admin
        '_builtin' => false,
        '_edit_link' => 'post.php?post=%d',
        'capability_type' => 'conference_record',
        'hierarchical' => false,
        'rewrite' => array("slug" => "register"), // links
        'supports' => array('thumbnail')
    );

    register_post_type('register', $args);

    //	register_taxonomy(
    //		'mtype',
    //		'register',
    //		array ('hierarchical' => false, 'label' => __('Registrant tags'),
    //				'singular_label' => __('Registrant tags'),
    //				'query_var' => 'mtype')
    //	);
}

add_action("admin_init", 'register_admin_init');

function register_admin_init()
{
    remove_meta_box('submitdiv', 'register', 'normal');
}

add_action('add_meta_boxes_register', 'register_boxes_setup');

function register_boxes_setup()
{
    wp_enqueue_script('editor');
    wp_enqueue_script('forms_scrypt', get_template_directory_uri() . '/js/forms.js');
    add_action('edit_form_advanced', 'register_form', 1);
    //	add_action('post_edit_form_tag','register_form_enctype');
}

//function register_form_enctype() {
//	echo ' enctype="multipart/form-data" ';
//}

$register_fields = explode(' ', 'phone fax company address city state zipcode country email website emergency_name emergency_phone');
$register_required = array_flip(explode(' ', 'phone company address city state zipcode country email'));
$register_cost_fields = explode(' ', 'registration_option rate tour reception reception2 luncheon vegetarian day exam workshop_rate facility-tour');

function register_form()
{
    global $post;

    echo __("<p>Please fill out the form below to add an Registrant. Mandatory fields are marked (<span class='file-error'>*</span>)</p>");

    $post_type_object = get_post_type_object($post->post_type);

    $post_data = get_post_meta($post->ID, 'post_data', true);
    if (!$post_data) $post_data = array();

    if ((0 == $post->ID) || ('0000-00-00 00:00:00' == $post->post_date_gmt)) {
        $publish_date = time();
    } else $publish_date = strtotime($post->post_date);

    if (!$post_data['registration_option'] && !$post_data['exam'] && !$post_data['workshop_rate']) {
        $post_data['registration_option'] = 'full';
        $post_data['exam'] = 'no';
        $post_data['workshop_rate'] = 'nonmember';
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
        <select name='post_status' id='post_status' tabindex='1'>
            <option<?php selected($post->post_status, 'publish'); ?> value='publish'><?php _e('Published') ?></option>
            <?php if ('private' == $post->post_status) : ?>
            <option<?php selected($post->post_status, 'private'); ?>
                    value='publish'><?php _e('Privately Published') ?></option>
            <?php elseif ('future' == $post->post_status) : ?>
            <option<?php selected($post->post_status, 'future'); ?> value='future'><?php _e('Scheduled') ?></option>
            <?php endif; ?>
            <option<?php selected($post->post_status, 'pending'); ?>
                    value='pending'><?php _e('Pending Review') ?></option>
            <?php if ('auto-draft' == $post->post_status) : ?>
            <option<?php selected($post->post_status, 'auto-draft'); ?> value='draft'><?php _e('Draft') ?></option>
            <?php else : ?>
            <option<?php selected($post->post_status, 'draft'); ?> value='draft'><?php _e('Draft') ?></option>
            <?php endif; ?>
        </select>
    </td>
</tr>
<tr>
    <td><span class='file-error'>*</span>
        <label for="title">
            <span>Name</span>
        </label>
    </td>
    <td>
        <input type="text" name="post_title" size="80" tabindex="2"
               value="<?php echo esc_attr(htmlspecialchars($post->post_title)); ?>" id="title" autocomplete="off"/>
    </td>
</tr>
    <?php
        global $register_fields, $register_required;
    $tab_index = 3;

    foreach ($register_fields as $f) {
        ?>
    <tr>
        <td>
            <?php
                    if (isset($register_required[$f])) echo "<span class='file-error'>*</span>";
        else echo "&nbsp;"; ?>
            <label for="<?php echo $f; ?>"><span><?php echo ucfirst($f); ?></span></label>
        </td>
        <td><?php
                    if ('state' == $f) {
            ?>
            <select name="state" id="state" tabindex="<?php echo $tab_index++; ?>" class="fill required w50">
                <option label="-- Please Select --" value="">-- Please Select --</option>
                <?php echo get_options_for_forms(array('id' => 'state', 'value' => $post_data[$f])); ?>
            </select>
            <?php } else if ('country' == $f) { ?>
            <select name="country" id="country" class="fill required w50" tabindex="<?php echo $tab_index++; ?>">
                <?php echo get_options_for_forms(array('id' => 'country', 'value' => $post_data[$f])); ?>
            </select>
            <?php } else { ?>
            <input type="text" name="<?php echo $f; ?>" size="80" tabindex="<?php echo $tab_index++; ?>"
                   value="<?php echo esc_attr(htmlspecialchars($post_data[$f])); ?>" id="<?php echo $f; ?>"/>
            <?php } ?>
        </td>
    </tr>
            <?php

    }
    ?>

<tr>
<td colspan="2">
<table cellpadding="0" cellspacing="0" width="100%" style="font-size: 135%">
<tr valign="top">
    <td><input type="radio" id="registration_option_full" name="registration_option"
               value="full" <?php checked($post_data['registration_option'], 'full'); ?>/></td>
    <td>
        <h3><label for="registration_option_full">Full Conference Registration</label></h3>

        <p><em>Includes sessions and session abstracts, exhibits, breakfasts, refreshment breaks, receptions &amp;
            equipment demonstrations &amp; tours</em></p>
    </td>
</tr>
<tr valign="top">
    <td></td>
    <td class="if-full">
        <table>
            <tr>
                <td colspan="3">
                    <h3><span>Prior to <?php echo date_i18n('F j', strtotime(get_option('discount_date')));?></span>
                    </h3>
                </td>
            </tr>
            <tr>
                <td width="22"><?php if ($publish_date < strtotime(get_option('discount_date'))) { ?><input type="radio"
                                                                                                            id="full-member"
                                                                                                            name="rate"
                                                                                                            value="member"
                                                                                                            onclick="recalculate(this, 375);"
                                                                                                            class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'], 'member'); ?> /><?php } ?>
                </td>
                <th width="300" align="left"><label for="full-member">Member</label></th>
                <td>$375</td>
            </tr>
            <tr>
                <td><?php if ($publish_date < strtotime(get_option('discount_date'))) { ?><input type="radio"
                                                                                                 id="full-nonmember"
                                                                                                 name="rate"
                                                                                                 value="nonmember"
                                                                                                 onclick="recalculate(this, 445);"
                                                                                                 class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'], 'nonmember'); ?> /><?php } ?>
                </td>
                <th align="left"><label for="full-nonmember">Non-Member</label></th>
                <td>$445</td>
            </tr>
            <tr>
                <td><?php if ($publish_date < strtotime(get_option('discount_date'))) { ?><input type="radio"
                                                                                                 id="full-speaker"
                                                                                                 name="rate"
                                                                                                 value="speaker"
                                                                                                 onclick="recalculate(this, 250);"
                                                                                                 class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'], 'speaker'); ?> /><?php } ?>
                </td>
                <th align="left"><label for="full-speaker">Conference Speaker</label></th>
                <td>$250</td>
            </tr>
            <tr>
                <td colspan="3">
                    <h3><span>After <?php echo date_i18n('F j', strtotime(get_option('discount_date')));?></span></h3>
                </td>
            </tr>
            <tr>
                <td width="22"><?php if ($publish_date >= strtotime(get_option('discount_date'))) { ?><input
                        type="radio" id="full-member" name="rate" value="member" onclick="recalculate(this, 395);"
                        class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'], 'member'); ?> /><?php } ?>
                </td>
                <th width="150" align="left"><label for="full-member">Member</label></th>
                <td>$395</td>
            </tr>
            <tr>
                <td><?php if ($publish_date >= strtotime(get_option('discount_date'))) { ?><input type="radio"
                                                                                                  id="full-nonmember"
                                                                                                  name="rate"
                                                                                                  value="nonmember"
                                                                                                  onclick="recalculate(this, 495);"
                                                                                                  class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'], 'nonmember'); ?> /><?php } ?>
                </td>
                <th align="left"><label for="full-nonmember">Non-Member</label></th>
                <td>$495</td>
            </tr>
            <tr>
                <td><?php if ($publish_date >= strtotime(get_option('discount_date'))) { ?><input type="radio"
                                                                                                  id="full-speaker"
                                                                                                  name="rate"
                                                                                                  value="speaker"
                                                                                                  onclick="recalculate(this, 250);"
                                                                                                  class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'], 'speaker'); ?> /><?php } ?>
                </td>
                <th align="left"><label for="full-speaker">Conference Speaker</label></th>
                <td>$250</td>
            </tr>
            <tr>
                <td colspan="3">
                    <h3><span>Facility Tours</span></h3>
                </td>
            </tr>
            <tr valign="top">
                <td width="22"><input type="checkbox" id="tours" name="tour" value="yes"
                                      class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['tour'], 'yes'); ?> />
                </td>
                <th align="left"><label for="tours">Attending Composting Equipment Demonstrations &amp; Tour</label>
                </th>
                <td>(Included)</td>
            </tr>
            <tr>
                <td colspan="3">
                    <h3><span>Receptions (included)</span></h3>
                </td>
            </tr>
            <tr>
                <td width="22"><input type="checkbox" id="reception" name="reception" value="yes"
                                      class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['reception'], 'yes'); ?> />
                </td>
                <th align="left" width="350" colspan="2"><label for="reception">Exhibitors Reception | Wednesday,
                    January 18</label></th>
            </tr>
            <tr>
                <td width="22"><input type="checkbox" id="reception2" name="reception2" value="yes"
                                      class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['reception2'], 'yes'); ?> />
                </td>
                <th align="left" width="350" colspan="2"><label for="reception2">BPI Reception | Thursday, January
                    19</label></th>
            </tr>
            <tr>
                <td colspan="3">
                    <h3>Awards Luncheon | Tuesday, Jan 25</h3>
                </td>
            </tr>
            <tr valign="top">
                <td width="22"><input type="checkbox" id="luncheon" name="luncheon" value="yes"
                                      onclick="recalculate(this, 25);"
                                      class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['luncheon'], 'yes'); ?> />
                </td>
                <th align="left"><label for="luncheon">Awards Luncheon</label></th>
                <td>$25</td>
            </tr>
            <tr valign="top">
                <td width="22"><input type="checkbox" id="vegetarian" name="vegetarian" value="yes"
                                      class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['vegetarian'], 'yes'); ?> />
                </td>
                <th align="left" colspan="2"><label for="vegetarian">Vegetarian Luncheon?</label></th>
            </tr>
        </table>
        <br/>
    </td>
</tr>

<tr valign="top">
    <td><input type="radio" id="registration_option_one-day" name="registration_option"
               value="one-day" <?php checked($post_data['registration_option'], 'one-day'); ?> /></td>
    <td>
        <h3><label for="registration_option_one-day">Conference Registration 1 Day</label></h3>

        <p><em>Includes sessions and session abstracts, exhibits, breakfasts, refreshment breaks &amp; receptions</em>
        </p>
    </td>
</tr>
<tr valign="top">
    <td></td>
    <td class="if-one-day">
        <table>
            <tr>
                <td colspan="3">
                    <h3><span>One Day Pass</span></h3>
                </td>
            </tr>
            <tr>
                <td width="22"><input type="radio" id="one-day-1" name="day" value="1"
                                      class="registration_option_one-day" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['day'], '1'); ?> />
                </td>
                <th width="150" align="left">Wednesday, January 18</th>
                <td></td>
            </tr>
            <tr>
                <td><input type="radio" id="one-day-2" name="day" value="2"
                           class="registration_option_one-day" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['day'], '2'); ?> />
                </td>
                <th align="left">Thursday, January 19</th>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <h3><span>Prior to <?php echo date_i18n('F j', strtotime(get_option('discount_date')));?></span>
                    </h3>
                </td>
            </tr>
            <tr>
                <td width="22"><?php if ($publish_date < strtotime(get_option('discount_date'))) { ?><input type="radio"
                                                                                                            id="one-day-member"
                                                                                                            name="rate"
                                                                                                            value="one-day-member"
                                                                                                            onclick="recalculate(this, 225);"
                                                                                                            class="registration_option_one-day" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['rate'], 'one-day-member'); ?> /><?php } ?>
                </td>
                <th width="150" align="left"><label for="one-day-member">Member</label></th>
                <td>$225</td>
            </tr>
            <tr>
                <td><?php if ($publish_date < strtotime(get_option('discount_date'))) { ?><input type="radio"
                                                                                                 id="one-day-nonmember"
                                                                                                 name="rate"
                                                                                                 value="one-day-nonmember"
                                                                                                 onclick="recalculate(this, 255);"
                                                                                                 class="registration_option_one-day" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['rate'], 'one-day-nonmember'); ?> /><?php } ?>
                </td>
                <th align="left"><label for="one-day-nonmember">Non-Member</label></th>
                <td>$255</td>
            </tr>
            <tr>
                <td colspan="3">
                    <h3><span>After <?php echo date_i18n('F j', strtotime(get_option('discount_date')));?></span></h3>
                </td>
            </tr>
            <tr>
                <td width="22"><?php if ($publish_date >= strtotime(get_option('discount_date'))) { ?><input
                        type="radio" id="one-day-member" name="rate" value="one-day-member"
                        onclick="recalculate(this, 245);"
                        class="registration_option_one-day" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['rate'], 'one-day-member'); ?> /><?php } ?>
                </td>
                <th width="150" align="left"><label for="one-day-member">Member</label></th>
                <td>$245</td>
            </tr>
            <tr>
                <td><?php if ($publish_date >= strtotime(get_option('discount_date'))) { ?><input type="radio"
                                                                                                  id="one-day-nonmember"
                                                                                                  name="rate"
                                                                                                  value="one-day-nonmember"
                                                                                                  onclick="recalculate(this, 280);"
                                                                                                  class="registration_option_one-day" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['rate'], 'one-day-nonmember'); ?> /><?php } ?>
                </td>
                <th align="left"><label for="one-day-nonmember">Non-Member</label></th>
                <td>$280</td>
            </tr>
            <tr>
                <td colspan="3">
                    <h3><span>Receptions (included)</span></h3>
                </td>
            </tr>
            <tr>
                <td><input type="checkbox" id="reception" name="reception" value="yes"
                           class="registration_option_one-day one-day-1" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['reception'], 'yes'); ?> />
                </td>
                <th align="left" colspan="2"><label for="reception">Exhibitors Reception | Wednesday, January 18</label>
                </th>
            </tr>
            <tr>
                <td><input type="checkbox" id="reception2" name="reception2" value="yes"
                           class="registration_option_one-day one-day-2" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['reception2'], 'yes'); ?> />
                </td>
                <th align="left" colspan="2"><label for="reception2">BPI Reception | Thursday, January 19</label></th>
            </tr>
            <tr>
                <td colspan="3">

        </table>
        <br/>
    </td>
</tr>

<tr valign="top">
    <td><input type="radio" id="registration_option_tour" name="registration_option"
               value="tour" <?php checked($post_data['registration_option'], 'tour'); ?> /></td>
    <td>
        <h3>
            <label for="registration_option_tour">Equipment Demonstrations &amp; Facility Tour Only | Jan 20</label>
        </h3>

        <p>
            <em>For TOUR ONLY, includes transportation, equipment demonstrations, lunch &amp; facility tour.</em><br/>
            <em>NOTE that the facility tour is INCLUDED in conference registration fees</em>
        </p>
    </td>
</tr>
<tr valign="top" class="if-tour">
    <td></td>
    <td>
        <table>
            <tr>
                <td width="22"><input type="radio" id="rate-tour-only" name="rate" value="tour-only"
                                      onclick="recalculate(this, 55);"
                                      class="registration_option_tour" <?php if ('tour' == $post_data['registration_option']) checked($post_data['rate'], 'tour-only'); ?> />
                </td>
                <th width="150" align="left"><label for="rate-tour-only">Demonstrations &amp; Tour</label></th>
                <td>$55</td>
            </tr>
        </table>
        <br/>
    </td>
</tr>

<tr valign="top">
    <td><input type="radio" id="registration_option_tradeshow" name="registration_option"
               value="tradeshow" <?php checked($post_data['registration_option'], 'tradeshow'); ?> /></td>
    <td>
        <h3><label for="registration_option_tradeshow">Trade Show Only</label></h3>

        <p><em>Includes program guide, exhibits, refreshment breaks &amp; receptions</em></p>
    </td>
</tr>
<tr valign="top" class="if-tradeshow">
    <td></td>
    <td>
        <table>
            <tr>
                <td width="22"><input type="radio" id="rate-tradeshow-one" name="rate" value="tradeshow-one"
                                      onclick="recalculate(this, 85);"
                                      class="registration_option_tradeshow" <?php if ('tradeshow' == $post_data['registration_option']) checked($post_data['rate'], 'tradeshow-one'); ?> />
                </td>
                <th width="150" align="left"><label for="rate-tradeshow-one">One day pass</label></th>
                <td>$85</td>
            </tr>
            <tr>
                <td width="22"></td>
                <td width="22"><input type="radio" id="tradeshow-day-1" name="day" value="1"
                                      class="registration_option_tradeshow rate-tradeshow-one" <?php if (('tradeshow' == $post_data['registration_option']) && ('tradeshow-one' == $post_data['rate'])) checked($post_data['day'], '1'); ?> />
                </td>
                <th width="150" align="left">Wednesday, January 18</th>
            </tr>
            <tr>
                <td width="22"></td>
                <td><input type="radio" id="tradeshow-day-2" name="day" value="2"
                           class="registration_option_tradeshow rate-tradeshow-one" <?php if (('tradeshow' == $post_data['registration_option']) && ('tradeshow-one' == $post_data['rate'])) checked($post_data['day'], '2'); ?> />
                </td>
                <th align="left">Thursday, January 19</th>
            </tr>
            <tr>
                <td width="22"><input type="radio" id="rate-tradeshow-two" name="rate" value="tradeshow-two"
                                      onclick="recalculate(this, 170);"
                                      class="registration_option_tradeshow" <?php if ('tradeshow' == $post_data['registration_option']) checked($post_data['rate'], 'tradeshow-two'); ?> />
                </td>
                <th width="150" align="left"><label for="rate-tradeshow-two">Two day pass</label></th>
                <td>$170</td>
            </tr>
            <tr>
                <td colspan="3">
                    <h3><span>Receptions (included)</span></h3>
                </td>
            </tr>
            <tr>
                <td width="22"><input type="checkbox" id="reception" name="reception" value="yes"
                                      class="registration_option_tradeshow" <?php if ('tradeshow' == $post_data['registration_option']) checked($post_data['reception'], 'yes'); ?> />
                </td>
                <th align="left" colspan="2"><label for="reception">Exhibitors Reception | Wednesday, January 18</label>
                </th>
            </tr>
            <tr>
                <td width="22"><input type="checkbox" id="reception2" name="reception2" value="yes"
                                      class="registration_option_tradeshow" <?php if ('tradeshow' == $post_data['registration_option']) checked($post_data['reception2'], 'yes'); ?> />
                </td>
                <th align="left" colspan="2"><label for="reception2">BPI Reception | Thursday, January 19</label></th>
            </tr>
        </table>
        <br/>
    </td>
</tr>
</table>
</td>
</tr>

<tr>
    <td colspan="2">
        <h3>Certification Exam | Thursday, January 19</h3>

        <p>
            <strong>Certification Exam for Manager of Compost Programs</strong>
            <br/>(3:30 - 6:30 PM)
        </p>
        <table>
            <tr valign="top">
                <td width="22"><input type="radio" name="exam" value="no"
                                      onclick="recalculate(this, 0);" <?php checked($post_data['exam'], 'no'); ?> />
                </td>
                <th width="150" align="left">None</th>
                <td></td>
            </tr>
            <tr valign="top">
                <td><input type="radio" name="exam" value="member"
                           onclick="recalculate(this, 175);" <?php checked($post_data['exam'], 'member'); ?> /></td>
                <th align="left">USCC or SWANA Member</th>
                <td>$175</td>
            </tr>
            <tr valign="top">
                <td><input type="radio" name="exam" value="nonmember"
                           onclick="recalculate(this, 275);" <?php checked($post_data['exam'], 'nonmember'); ?> /></td>
                <th align="left">Non-Member</th>
                <td>$275</td>
            </tr>
        </table>
        <br/>
    </td>
</tr>

<tr>
    <td colspan="2">
        <h3>Pre-Conference Training &amp; Workshops | Tuesday, Jan 17</h3>
        <table id="workshops">
            <tr>
                <th colspan="2"></th>
                <th align="right" style="white-space:nowrap;width:100px"><label><input type="radio"
                                                                                       id="workshop_rate_memeber"
                                                                                       name="workshop_rate"
                                                                                       value="member" <?php checked($post_data['workshop_rate'], 'member'); ?> />
                    Member</label></th>
                <th align="right" style="white-space:nowrap;width:100px"><label><input type="radio"
                                                                                       id="workshop_rate_nonmemeber"
                                                                                       name="workshop_rate"
                                                                                       value="nonmember" <?php checked($post_data['workshop_rate'], 'nonmember'); ?> />
                    Non-Member</label></th>
            </tr>
            <?php echo display_workshops($post_data); ?>
        </table>
    </td>
</tr>

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
        <?php if (!in_array($post->post_status, array('publish', 'future', 'private')) || 0 == $post->ID) : ?>
        <input type="submit" name="save" id="save-post" class="button-primary" tabindex="<?php echo $tab_index; ?>"
               accesskey="r" value="<?php esc_attr_e('Add Registrant') ?>"/>
        <?php else: ?>
        <input type="submit" name="save" id="save-post" class="button-primary" tabindex="<?php echo $tab_index; ?>"
               accesskey="r" value="<?php esc_attr_e('Update Registrant') ?>"/>
        <?php endif; ?>

        <a href="/admin/wp-content/plugins/as-pdf/generate.php?post=<?php echo $post->ID; ?>" target="_blank">
            <img src="/admin/wp-content/themes/composting/images/icons/print.png"/>
        </a>
    </td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
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

function register_print_html($post)
{

    ob_start();

    $post_type_object = get_post_type_object($post->post_type);

    $post_data = get_post_meta($post->ID, 'post_data', true);
    if (!$post_data) $post_data = array();

    if ((0 == $post->ID) || ('0000-00-00 00:00:00' == $post->post_date_gmt)) {
        $publish_date = time();
    } else $publish_date = strtotime($post->post_date);

    if (!$post_data['registration_option'] && !$post_data['exam'] && !$post_data['workshop_rate']) {
        $post_data['registration_option'] = 'full';
        $post_data['exam'] = 'no';
        $post_data['workshop_rate'] = 'nonmember';
    }

    ?> <span>Name:</span> <?php echo esc_attr(htmlspecialchars($post->post_title)); ?>
<br/><?php
        global $register_fields, $register_required;
    $tab_index = 3;

    foreach ($register_fields as $f) {
        ?> <span><?php echo ucfirst($f); ?>:</span> <?php
            echo $post_data[$f]; ?> <br/><?php

    }

    echo "<br/>";

    if ($post_data['registration_option'] == 'full') {
        echo "<h2>Full Conference Registration</h2>";

        if ($publish_date < strtotime(get_option('discount_date'))) {
            //			echo "	<h3>Prior to ".date_i18n('F j', strtotime(get_option('discount_date')))."</h3>";

            switch ($post_data['rate']) {
                case 'member':
                    echo " $375 Member<br/>";
                    break;
                case 'nonmember':
                    echo " $445 Non-Member<br/>";
                    break;
                case 'speaker':
                    echo " $250 Conference Speaker<br/>";
                    break;
            }
        } else {
            //			echo "	<h3>After ".date_i18n('F j', strtotime(get_option('discount_date')))."</h3>";

            switch ($post_data['rate']) {
                case 'member':
                    echo " $395 Member<br/>";
                    break;
                case 'nonmember':
                    echo " $495 Non-Member<br/>";
                    break;
                case 'speaker':
                    echo " $250 Conference Speaker<br/>";
                    break;
            }
        }

        if ($post_data['tour'] == 'yes') echo " Attending Composting Equipment Demonstrations &amp; Tour<br/>";
        if ($post_data['reception'] == 'yes') echo " Exhibitors Reception | Wednesday, January 18<br/>";
        if ($post_data['reception2'] == 'yes') echo " BPI Reception | Thursday, January 19<br/>";
        if ($post_data['luncheon'] == 'yes') echo " Awards Luncheon<br/>";
        if ($post_data['vegetarian'] == 'yes') echo " Vegetarian Luncheon<br/>";
    } else if ($post_data['registration_option'] == 'one-day') {
        echo "<h2>Conference Registration 1 Day</h2>";

        if ($post_data['day'] == '1') echo " Wednesday, January 18<br/>";
        if ($post_data['day'] == '2') echo " Thursday, January 19<br/>";

        if ($publish_date < strtotime(get_option('discount_date'))) {
            //			echo "	<h3>Prior to ".date_i18n('F j', strtotime(get_option('discount_date')))."</h3>";

            switch ($post_data['rate']) {
                case 'one-day-member':
                    echo " $225 Member<br/>";
                    break;
                case 'one-day-nonmember':
                    echo " $255 Non-Member<br/>";
                    break;
            }
        } else {
            //			echo "	<h3>After ".date_i18n('F j', strtotime(get_option('discount_date')))."</h3>";

            switch ($post_data['rate']) {
                case 'one-day-member':
                    echo " $245 Member<br/>";
                    break;
                case 'one-day-nonmember':
                    echo " $280 Non-Member<br/>";
                    break;
            }
        }
        if ($post_data['reception'] == 'yes') echo " Exhibitors Reception | Wednesday, January 18<br/>";
        if ($post_data['reception2'] == 'yes') echo " BPI Reception | Thursday, January 19<br/>";

        if ($post_data['facility-tour'] == 'yes') echo " Equipment Demonstrations &amp; Facility Tour | Jan 26 ($55) <br/>";
    } else if ($post_data['registration_option'] == 'tour') {
        echo "<h2>Equipment Demonstrations &amp; Facility Tour Only | Jan 20</h2>";
        if ($post_data['rate'] == 'tour-only') echo " Demonstrations &amp; Tour ($55) <br/>";
    } else if ($post_data['registration_option'] == 'tradeshow') {
        echo "<h2>Trade Show Only</h2>";
        switch ($post_data['rate']) {
            case 'tradeshow-one':
                echo " One day pass ($85) ";
                switch ($post_data['day']) {
                    case '1':
                        echo "Wednesday, January 18";
                        break;
                    case '2':
                        echo "Thursday, January 19";
                        break;
                }
                echo "<br/>";
                break;
            case 'tradeshow-two':
                echo " Two day pass ($170)<br/>";
        }
        if ($post_data['reception'] == 'yes') echo " Exhibitors Reception | Wednesday, January 18<br/>";
        if ($post_data['reception2'] == 'yes') echo " BPI Reception | Thursday, January 19<br/>";
    }

    if ($post_data['exam'] == 'member' || $post_data['exam'] == 'nonmember') {
        echo "<br/><h2>Certification Exam for Manager of Compost Programs</h2>";
        echo " Thursday, January 19 (3:30 - 6:30 PM)<br/>";

        if ($post_data['exam'] == 'member') echo " $175 USCC or SWANA Member<br/>";
        else echo " $275 Non-Member<br/>";
    }

    if ($post_data['workshops']) {
        echo "<br/><h2>Pre-Conference Training &amp; Workshops</h2>";
        echo " Tuessday Jan 20<br/>";

        $post_data['show_table'] = false;
        echo display_workshops($post_data);
    }

    echo "<br/><h2>Total \${$post_data['cost']}</h2>";

    $ret = ob_get_contents();
    ob_end_clean();

    return $ret;
}


add_action('trash_post', 'trash_register', 1);
function trash_register($post_id)
{
    $old_post_data = get_post_meta($post_id, 'post_data', true);
    $old_post_status = $old_post_data['old_post_status'];

    if (is_array($old_post_data) && isset($old_post_data['workshops']) && is_array($old_post_data['workshops'])) {
        foreach ($old_post_data['workshops'] as $w) {
            if ($old_post_status == 'publish') {
                update_post_meta($w, 'current', get_post_meta($w, 'current', true) - 1);
            }
        }
    }

}

add_action('untrash_post', 'untrash_register', 1);
function untrash_register($post_id)
{
    $old_post_data = get_post_meta($post_id, 'post_data', true);
    $old_post_status = $old_post_data['old_post_status'];

    if (is_array($old_post_data) && isset($old_post_data['workshops']) && is_array($old_post_data['workshops'])) {
        foreach ($old_post_data['workshops'] as $w) {
            if ($old_post_status == 'publish') {
                update_post_meta($w, 'current', get_post_meta($w, 'current', true) + 1);
            }
        }
    }
}

add_action('save_post', 'register_save', 0);

function register_save($post_id)
{
    ///////////////////////data fixed
    //     update_post_meta(5249, 'current', 0);
    //     update_post_meta(5299, 'current', 0);
    //     update_post_meta(5337, 'current', 0);
    //     update_post_meta(5340, 'current', 0);
    //     update_post_meta(5342, 'current', 0);
    //     update_post_meta(5344, 'current', 0);
    //     update_post_meta(5347, 'current', 0);
    ///////////////////////////////////////

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
     return;

	if (!($post_id && isset($_POST['post_type']) && 'register' == $_POST['post_type'])) return;

    $post_data = array();

    global $register_fields, $register_required, $register_cost_fields;

    foreach ($register_fields as $f) {
        if (isset($_POST[$f])) $post_data[$f] = esc_attr($_POST[$f]);
        else $post_data[$f] = '';
    }

    foreach ($register_cost_fields as $f) {
        if (isset($_POST[$f])) $post_data[$f] = esc_attr($_POST[$f]);
        else $post_data[$f] = '';
    }

    if (isset($_POST['workshops']) && is_array($_POST['workshops'])) {
        $old_post_data = get_post_meta($post_id, 'post_data', true);
        $old_post_status = $old_post_data['old_post_status'];

        if (is_array($old_post_data) && isset($old_post_data['workshops']) && is_array($old_post_data['workshops'])) {
            foreach ($old_post_data['workshops'] as $w) {
                if ($old_post_status == 'publish') {
                    update_post_meta($w, 'current', get_post_meta($w, 'current', true) - 1);
                }
            }
        }

        $post_data['workshops'] = array();

        foreach ($_POST['workshops'] as $w) {
            $w = esc_attr($w);
            $post_data['workshops'][] = $w;
            if ($_POST['post_status'] == 'publish') {
                update_post_meta($w, 'current', get_post_meta($w, 'current', true) + 1);
            }
        }
    }

    $post_data['cost'] = register_calculate($post_data, $post_id);
    $post_data['old_post_status'] = $_POST['post_status'];

    update_post_meta($post_id, 'post_data', $post_data);

    if (isset($_POST['_register_http_referer'])) {
        // WP e-Commerce integration
        if (function_exists('wpsc_insert_product')) {
            $uscc_number = '';
            global $current_user;
            if (is_user_logged_in() && $current_user->uscc) {
                $uscc_number = 'uscc#' . $current_user->uscc;
            }
            $product_data = array(
                'name' => esc_attr($_POST['post_title']) . " {$post_data['registration_option']} registration $uscc_number",
                'description' => "rate is {$post_data['rate']}, exam is {$post_data['rate']}, workshops is " . @implode(',', $post_data['workshops']),

                'notax' => 1,
                'publish' => 1,
                'active' => 1,
                'no_shipping' => 1,

                'price' => $post_data['cost']
            );

            if ($product_id = get_post_meta($post_id, 'product_id', true)) {
                $product_data['product_id'] = $product_id;
            }
            update_post_meta($post_id, 'product_id', $product_id = wpsc_insert_product($product_data));

            global $wpsc_cart;
            $wpsc_cart->set_item($product_id, array(
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
            if ('cart' == $_POST['_register_http_referer']) {
                add_filter('redirect_post_location', 'redirect_to_cart_register', 9999, 2);
            } elseif ('back' == $_POST['_register_http_referer']) {
                add_filter('redirect_post_location', 'redirect_to_back_register', 9999, 2);
            }
        } else {
            add_filter('redirect_post_location', 'redirect_frontend_register', 9999, 2);
        }
    }
}

function redirect_frontend_register($location, $post_id)
{
    return get_home_url() . '?post_type=register&p=' . $post_id;
}

function redirect_to_cart_register($location, $post_id)
{
    return get_option('shopping_cart_url');
}

function redirect_to_back_register($location, $post_id)
{
    return get_home_url() . '?page_id=18&get_data_from=' . $post_id;
}

add_action('wpsc_transaction_result_cart_item', 'register_track_transactions');

function register_track_transactions($data)
{
    $product_id = $data['cart_item']['prodid'];
    $status = $data['purchase_log']['processed'];
    $posts = get_posts(array(
                            'post_type' => 'register',
                            'post_status' => 'any',
                            'numberposts' => 1,
                            'meta_key' => 'product_id',
                            'meta_value' => $product_id,
                       ));
    if (!$posts) {
        foreach ($posts as $post) {
            switch ($status) {
                case '2':
                    $status = 'publish';
                    break;
                case '4':
                    $status = 'draft';
                    break;
                default:
                    $status = 'pending';
                    break;
            }

            global $wpdb;
            $wpdb->update($wpdb->posts, array('post_status' => $status), array('ID' => $post->ID));
        }
    }
    return;
}

function register_calculate($data, $post_id)
{
    $cost = 0;
    $post = get_post($post_id);
    $early = (strtotime(get_option('discount_date')) > strtotime($post->post_date));
    switch ($data['registration_option']) {
        case 'full':
            if ($early) {
                switch ($data['rate']) {
                    case 'member':
                        $cost += 375;
                        break;
                    case 'nonmember':
                        $cost += 445;
                        break;
                    case 'speaker':
                        $cost += 250;
                        break;
                }
            } else {
                switch ($data['rate']) {
                    case 'member':
                        $cost += 395;
                        break;
                    case 'nonmember':
                        $cost += 495;
                        break;
                    case 'speaker':
                        $cost += 250;
                        break;
                }
            }
            if ('yes' == $data['luncheon']) $cost += 25;
            break;
        case 'one-day':
            if ($early) {
                switch ($data['rate']) {
                    case 'one-day-member':
                        $cost += 225;
                        break;
                    case 'one-day-nonmember':
                        $cost += 255;
                        break;
                }
            } else {
                switch ($data['rate']) {
                    case 'one-day-member':
                        $cost += 245;
                        break;
                    case 'one-day-nonmember':
                        $cost += 280;
                        break;
                }
            }
            if ($data['facility-tour'] == 'yes') $cost += 55;
            break;
        case 'tour':
            if ('tour-only' == $data['rate']) $cost += 55;
            break;
        case 'tradeshow':
            switch ($data['rate']) {
                case 'tradeshow-one':
                    $cost += 85;
                    break;
                case 'tradeshow-two':
                    $cost += 170;
                    break;
            }
            break;
    }
    switch ($data['exam']) {
        case 'member':
            $cost += 175;
            break;
        case 'nonmember':
            $cost += 275;
            break;
    }

    return $cost + calculate_workshops($data);
}

add_filter('manage_edit-register_columns', 'manage_edit_register_columns');

function manage_edit_register_columns($headers)
{

    $headers['title'] = 'Registrant';
    $headers['purchase'] = 'Status';
    $headers['rel'] = 'Company';
    $headers['uscc'] = 'USCC #';
    $headers['role'] = 'E-mail';
    unset($headers['date']);
    unset($headers['author']);
    return $headers;
}

add_action('manage_posts_custom_column', 'manage_posts_register_column', 1);

function manage_posts_register_column($cname)
{
    global $post, $wpdb;

    if ($post->post_type != 'register') return;
    $post_data = get_post_meta($post->ID, 'post_data', true);

    switch ($cname) {
        case 'purchase':
            $product_id = get_post_meta($post->ID, 'product_id', true);
            $tables = array('pl' => WPSC_TABLE_PURCHASE_LOGS, 'cc' => WPSC_TABLE_CART_CONTENTS, 'ps' => WPSC_TABLE_PURCHASE_STATUSES);
            $product_log = $wpdb->get_row("SELECT pl.id,ps.name FROM {$tables['pl']} as pl join {$tables['cc']} as cc on (pl.id=cc.id) join {$tables['ps']} as ps on (pl.processed=ps.id) where cc.prodid=$product_id");
            if ($product_log)
                echo "<a href='/admin/wp-admin/admin.php?page=wpsc-sales-logs&purchaselog_id={$product_log->id}'>{$product_log->name}</a>";
            break;

        case 'rel':
            echo $post_data['company'];
            break;

        case 'role':
            echo $post_data['email'];
            break;
        case 'uscc':
            echo get_userdata($post->post_author)->uscc;
            break;
    }
}

add_filter('home_template', 'check_register_index');
add_filter('index_template', 'check_register_index');


//add_option( 'discount_date', '2011-12-24 00:00:00', '', 'yes' ); 


function check_register_index($template)
{
    if (strpos($_SERVER['REQUEST_URI'], '/register/') === 0) {
        $template = locate_template(array('register_index.php'));
    }
    return $template;
}

add_shortcode('register_nonce', 'add_nonce_for_register');
function add_nonce_for_register()
{
    return wp_nonce_field('add-register', '_wpnonce', false, false);
}

add_shortcode('discount_date', 'display_discount_date');
function display_discount_date()
{
    $date = get_option('discount_date');
    return date_i18n(get_option('date_format'), strtotime($date));
}


add_shortcode('if_early', 'condition_early_discount_date');
function condition_early_discount_date($attr, $content)
{
    $date = get_option('discount_date');
    if (time() < strtotime($date)) return $content;
    else return '';
}

add_shortcode('if_late', 'condition_late_discount_date');
function condition_late_discount_date($attr, $content)
{
    $date = get_option('discount_date');
    if (time() >= strtotime($date)) return $content;
    else return '';
}

add_shortcode('options', 'get_options_for_forms');
function get_options_for_forms($atts, $content = '')
{
    extract(shortcode_atts(array(
                                'id' => '',
                                'value' => '',
                           ), $atts));

    switch ($id) {
        case 'state':
            return '<optgroup label="United States">
<option label="Alabama" value="AL" ' . selected('AL', $value, false) . '>Alabama</option>
<option label="Alaska" value="AK" ' . selected('AK', $value, false) . '>Alaska</option>
<option label="Arizona" value="AZ" ' . selected('AZ', $value, false) . '>Arizona</option>
<option label="Arkansas" value="AR" ' . selected('AR', $value, false) . '>Arkansas</option>
<option label="California" value="CA" ' . selected('CA', $value, false) . '>California</option>
<option label="Colorado" value="CO" ' . selected('CO', $value, false) . '>Colorado</option>
<option label="Connecticut" value="CT" ' . selected('CT', $value, false) . '>Connecticut</option>
<option label="Delaware" value="DE" ' . selected('DE', $value, false) . '>Delaware</option>
<option label="District of Columbia" value="DC" ' . selected('DC', $value, false) . '>District of Columbia</option>
<option label="Florida" value="FL" ' . selected('FL', $value, false) . '>Florida</option>
<option label="Georgia" value="GA" ' . selected('GA', $value, false) . '>Georgia</option>
<option label="Hawaii" value="HI" ' . selected('HI', $value, false) . '>Hawaii</option>
<option label="Idaho" value="ID" ' . selected('ID', $value, false) . '>Idaho</option>
<option label="Illinois" value="IL" ' . selected('IL', $value, false) . '>Illinois</option>
<option label="Indiana" value="IN" ' . selected('IN', $value, false) . '>Indiana</option>
<option label="Iowa" value="IA" ' . selected('IA', $value, false) . '>Iowa</option>
<option label="Kansas" value="KS" ' . selected('KS', $value, false) . '>Kansas</option>
<option label="Kentucky" value="KY" ' . selected('KY', $value, false) . '>Kentucky</option>
<option label="Louisiana" value="LA" ' . selected('LA', $value, false) . '>Louisiana</option>
<option label="Maine" value="ME" ' . selected('ME', $value, false) . '>Maine</option>
<option label="Maryland" value="MD" ' . selected('MD', $value, false) . '>Maryland</option>
<option label="Massachusetts" value="MA" ' . selected('MA', $value, false) . '>Massachusetts</option>
<option label="Michigan" value="MI" ' . selected('MI', $value, false) . '>Michigan</option>
<option label="Minnesota" value="MN" ' . selected('MN', $value, false) . '>Minnesota</option>
<option label="Mississippi" value="MS" ' . selected('MS', $value, false) . '>Mississippi</option>
<option label="Missouri" value="MO" ' . selected('MO', $value, false) . '>Missouri</option>
<option label="Montana" value="MT" ' . selected('MT', $value, false) . '>Montana</option>
<option label="Nebraska" value="NE" ' . selected('NE', $value, false) . '>Nebraska</option>
<option label="Nevada" value="NV" ' . selected('NV', $value, false) . '>Nevada</option>
<option label="New Hampshire" value="NH" ' . selected('NH', $value, false) . '>New Hampshire</option>
<option label="New Jersey" value="NJ" ' . selected('NJ', $value, false) . '>New Jersey</option>
<option label="New Mexico" value="NM" ' . selected('NM', $value, false) . '>New Mexico</option>
<option label="New York" value="NY" ' . selected('NY', $value, false) . '>New York</option>
<option label="North Carolina" value="NC" ' . selected('NC', $value, false) . '>North Carolina</option>
<option label="North Dakota" value="ND" ' . selected('ND', $value, false) . '>North Dakota</option>
<option label="Ohio" value="OH" ' . selected('OH', $value, false) . '>Ohio</option>
<option label="Oklahoma" value="OK" ' . selected('OK', $value, false) . '>Oklahoma</option>
<option label="Oregon" value="OR" ' . selected('OR', $value, false) . '>Oregon</option>
<option label="Pennsylvania" value="PA" ' . selected('PA', $value, false) . '>Pennsylvania</option>
<option label="Puerto Rico" value="PR" ' . selected('PR', $value, false) . '>Puerto Rico</option>
<option label="Rhode Island" value="RI" ' . selected('RI', $value, false) . '>Rhode Island</option>
<option label="South Carolina" value="SC" ' . selected('SC', $value, false) . '>South Carolina</option>
<option label="South Dakota" value="SD" ' . selected('SD', $value, false) . '>South Dakota</option>
<option label="Tennessee" value="TN" ' . selected('TN', $value, false) . '>Tennessee</option>
<option label="Texas" value="TX" ' . selected('TX', $value, false) . '>Texas</option>
<option label="Utah" value="UT" ' . selected('UT', $value, false) . '>Utah</option>
<option label="Vermont" value="VT" ' . selected('VT', $value, false) . '>Vermont</option>
<option label="Virginia" value="VA" ' . selected('VA', $value, false) . '>Virginia</option>
<option label="Washington" value="WA" ' . selected('WA', $value, false) . '>Washington</option>
<option label="West Virginia" value="WV" ' . selected('WV', $value, false) . '>West Virginia</option>
<option label="Wisconsin" value="WI" ' . selected('WI', $value, false) . '>Wisconsin</option>
<option label="Wyoming" value="WY" ' . selected('WY', $value, false) . '>Wyoming</option>
<option label="Virgin Islands" value="VI" ' . selected('VI', $value, false) . '>Virgin Islands</option>
</optgroup>
<optgroup label="Canada">
<option label="Alberta" value="AB" ' . selected('AB', $value, false) . '>Alberta</option>
<option label="British Columbia" value="BC" ' . selected('BC', $value, false) . '>British Columbia</option>
<option label="Manitoba" value="MB" ' . selected('MB', $value, false) . '>Manitoba</option>
<option label="New Brunswick" value="NB" ' . selected('NB', $value, false) . '>New Brunswick</option>
<option label="Newfoundland and Labrador" value="NL" ' . selected('NL', $value, false) . '>Newfoundland and Labrador</option>
<option label="Northwest Territories" value="NT" ' . selected('NT', $value, false) . '>Northwest Territories</option>
<option label="Nova Scotia" value="NS" ' . selected('NS', $value, false) . '>Nova Scotia</option>
<option label="Nunavut" value="NU" ' . selected('NU', $value, false) . '>Nunavut</option>
<option label="Ontario" value="ON" ' . selected('ON', $value, false) . '>Ontario</option>
<option label="Prince Edward Island" value="PE" ' . selected('PE', $value, false) . '>Prince Edward Island</option>
<option label="Quebec" value="QC" ' . selected('QC', $value, false) . '>Quebec</option>
<option label="Saskatchewan" value="SK" ' . selected('SK', $value, false) . '>Saskatchewan</option>
<option label="Yukon" value="YT" ' . selected('YT', $value, false) . '>Yukon</option>
</optgroup>
<option label="Other / N/A" value="NA" ' . selected('NA', $value, false) . '>Other / N/A</option>
';
        case 'country':
            return '<option label="United States" value="US" ' . selected('US', $value, false) . '>United States</option>
<option label="Canada" value="CA" ' . selected('CA', $value, false) . '>Canada</option>
<option label="Afghanistan" value="AF" ' . selected('AF', $value, false) . '>Afghanistan</option>
<option label="Albania" value="AL" ' . selected('AL', $value, false) . '>Albania</option>
<option label="Algeria" value="DZ" ' . selected('DZ', $value, false) . '>Algeria</option>
<option label="American Samoa" value="AS" ' . selected('AS', $value, false) . '>American Samoa</option>
<option label="Andorra" value="AD" ' . selected('AD', $value, false) . '>Andorra</option>
<option label="Angola" value="AO" ' . selected('AO', $value, false) . '>Angola</option>
<option label="Anguilla" value="AI" ' . selected('AI', $value, false) . '>Anguilla</option>
<option label="Antarctica" value="AQ" ' . selected('AQ', $value, false) . '>Antarctica</option>
<option label="Antigua And Barbuda" value="AG" ' . selected('AG', $value, false) . '>Antigua And Barbuda</option>
<option label="Argentina" value="AR" ' . selected('AR', $value, false) . '>Argentina</option>
<option label="Armenia" value="AM" ' . selected('AM', $value, false) . '>Armenia</option>
<option label="Aruba" value="AW" ' . selected('AW', $value, false) . '>Aruba</option>
<option label="Australia" value="AU" ' . selected('AU', $value, false) . '>Australia</option>
<option label="Austria" value="AT" ' . selected('AT', $value, false) . '>Austria</option>
<option label="Azerbaijan" value="AZ" ' . selected('AZ', $value, false) . '>Azerbaijan</option>
<option label="Bahamas" value="BS" ' . selected('BS', $value, false) . '>Bahamas</option>
<option label="Bahrain" value="BH" ' . selected('BH', $value, false) . '>Bahrain</option>
<option label="Bangladesh" value="BD" ' . selected('BD', $value, false) . '>Bangladesh</option>
<option label="Barbados" value="BB" ' . selected('BB', $value, false) . '>Barbados</option>
<option label="Belarus" value="BY" ' . selected('BY', $value, false) . '>Belarus</option>
<option label="Belgium" value="BE" ' . selected('BE', $value, false) . '>Belgium</option>
<option label="Belize" value="BZ" ' . selected('BZ', $value, false) . '>Belize</option>
<option label="Benin" value="BJ" ' . selected('BJ', $value, false) . '>Benin</option>
<option label="Bermuda" value="BM" ' . selected('BM', $value, false) . '>Bermuda</option>
<option label="Bhutan" value="BT" ' . selected('BT', $value, false) . '>Bhutan</option>
<option label="Bolivia" value="BO" ' . selected('BO', $value, false) . '>Bolivia</option>
<option label="Bosnia And Herzegowina" value="BA" ' . selected('BA', $value, false) . '>Bosnia And Herzegowina</option>
<option label="Botswana" value="BW" ' . selected('BW', $value, false) . '>Botswana</option>
<option label="Bouvet Island" value="BV" ' . selected('BV', $value, false) . '>Bouvet Island</option>
<option label="Brazil" value="BR" ' . selected('BR', $value, false) . '>Brazil</option>
<option label="British Indian Ocean Territory" value="IO" ' . selected('IO', $value, false) . '>British Indian Ocean Territory</option>
<option label="Brunei Darussalam" value="BN" ' . selected('BN', $value, false) . '>Brunei Darussalam</option>
<option label="Bulgaria" value="BG" ' . selected('BG', $value, false) . '>Bulgaria</option>
<option label="Burkina Faso" value="BF" ' . selected('BF', $value, false) . '>Burkina Faso</option>
<option label="Burundi" value="BI" ' . selected('BI', $value, false) . '>Burundi</option>
<option label="Cambodia" value="KH" ' . selected('KH', $value, false) . '>Cambodia</option>
<option label="Cameroon" value="CM" ' . selected('CM', $value, false) . '>Cameroon</option>
<option label="Cape Verde" value="CV" ' . selected('CV', $value, false) . '>Cape Verde</option>
<option label="Cayman Islands" value="KY" ' . selected('KY', $value, false) . '>Cayman Islands</option>
<option label="Central African Republic" value="CF" ' . selected('CF', $value, false) . '>Central African Republic</option>
<option label="Chad" value="TD" ' . selected('TD', $value, false) . '>Chad</option>
<option label="Chile" value="CL" ' . selected('CL', $value, false) . '>Chile</option>
<option label="China" value="CN" ' . selected('CN', $value, false) . '>China</option>
<option label="Christmas Island" value="CX" ' . selected('CX', $value, false) . '>Christmas Island</option>
<option label="Cocos (Keeling) Islands" value="CC" ' . selected('CC', $value, false) . '>Cocos (Keeling) Islands</option>
<option label="Colombia" value="CO" ' . selected('CO', $value, false) . '>Colombia</option>
<option label="Comoros" value="KM" ' . selected('KM', $value, false) . '>Comoros</option>
<option label="Congo" value="CG" ' . selected('CG', $value, false) . '>Congo</option>
<option label="Congo, The Democratic Republic Of The" value="CD" ' . selected('CD', $value, false) . '>Congo, The Democratic Republic Of The</option>
<option label="Cook Islands" value="CK" ' . selected('CK', $value, false) . '>Cook Islands</option>
<option label="Costa Rica" value="CR" ' . selected('CR', $value, false) . '>Costa Rica</option>
<option label="Cote D' . "'" . 'Ivoire" value="CI" ' . selected('CI', $value, false) . '>Cote D' . "'" . 'Ivoire</option>
<option label="Croatia (Hrvatska)" value="HR" ' . selected('HR', $value, false) . '>Croatia (Hrvatska)</option>
<option label="Cuba" value="CU" ' . selected('CU', $value, false) . '>Cuba</option>
<option label="Cyprus" value="CY" ' . selected('CY', $value, false) . '>Cyprus</option>
<option label="Czech Republic" value="CZ" ' . selected('CZ', $value, false) . '>Czech Republic</option>
<option label="Denmark" value="DK" ' . selected('DK', $value, false) . '>Denmark</option>
<option label="Djibouti" value="DJ" ' . selected('DJ', $value, false) . '>Djibouti</option>
<option label="Dominica" value="DM" ' . selected('DM', $value, false) . '>Dominica</option>
<option label="Dominican Republic" value="DO" ' . selected('DO', $value, false) . '>Dominican Republic</option>
<option label="East Timor" value="TP" ' . selected('TP', $value, false) . '>East Timor</option>
<option label="Ecuador" value="EC" ' . selected('EC', $value, false) . '>Ecuador</option>
<option label="Egypt" value="EG" ' . selected('EG', $value, false) . '>Egypt</option>
<option label="El Salvador" value="SV" ' . selected('SV', $value, false) . '>El Salvador</option>
<option label="Equatorial Guinea" value="GQ" ' . selected('GQ', $value, false) . '>Equatorial Guinea</option>
<option label="Eritrea" value="ER" ' . selected('ER', $value, false) . '>Eritrea</option>
<option label="Estonia" value="EE" ' . selected('EE', $value, false) . '>Estonia</option>
<option label="Ethiopia" value="ET" ' . selected('ET', $value, false) . '>Ethiopia</option>
<option label="Falkland Islands (Malvinas)" value="FK" ' . selected('FK', $value, false) . '>Falkland Islands (Malvinas)</option>
<option label="Faroe Islands" value="FO" ' . selected('FO', $value, false) . '>Faroe Islands</option>
<option label="Fiji" value="FJ" ' . selected('FJ', $value, false) . '>Fiji</option>
<option label="Finland" value="FI" ' . selected('FI', $value, false) . '>Finland</option>
<option label="France" value="FR" ' . selected('FR', $value, false) . '>France</option>
<option label="France, Metropolitan" value="FX" ' . selected('FX', $value, false) . '>France, Metropolitan</option>
<option label="French Guiana" value="GF" ' . selected('GF', $value, false) . '>French Guiana</option>
<option label="French Polynesia" value="PF" ' . selected('PF', $value, false) . '>French Polynesia</option>
<option label="French Southern Territories" value="TF" ' . selected('TF', $value, false) . '>French Southern Territories</option>
<option label="Gabon" value="GA" ' . selected('GA', $value, false) . '>Gabon</option>
<option label="Gambia" value="GM" ' . selected('GM', $value, false) . '>Gambia</option>
<option label="Georgia" value="GE" ' . selected('GE', $value, false) . '>Georgia</option>
<option label="Germany" value="DE" ' . selected('DE', $value, false) . '>Germany</option>
<option label="Ghana" value="GH" ' . selected('GH', $value, false) . '>Ghana</option>
<option label="Gibraltar" value="GI" ' . selected('GI', $value, false) . '>Gibraltar</option>
<option label="Greece" value="GR" ' . selected('GR', $value, false) . '>Greece</option>
<option label="Greenland" value="GL" ' . selected('GL', $value, false) . '>Greenland</option>
<option label="Grenada" value="GD" ' . selected('GD', $value, false) . '>Grenada</option>
<option label="Guadeloupe" value="GP" ' . selected('GP', $value, false) . '>Guadeloupe</option>
<option label="Guam" value="GU" ' . selected('GU', $value, false) . '>Guam</option>
<option label="Guatemala" value="GT" ' . selected('GT', $value, false) . '>Guatemala</option>
<option label="Guinea" value="GN" ' . selected('GN', $value, false) . '>Guinea</option>
<option label="Guinea-Bissau" value="GW" ' . selected('GW', $value, false) . '>Guinea-Bissau</option>
<option label="Guyana" value="GY" ' . selected('GY', $value, false) . '>Guyana</option>
<option label="Haiti" value="HT" ' . selected('HT', $value, false) . '>Haiti</option>
<option label="Heard And McDonald Islands" value="HM" ' . selected('HM', $value, false) . '>Heard And McDonald Islands</option>
<option label="Holy See (Vatican City State)" value="VA" ' . selected('VA', $value, false) . '>Holy See (Vatican City State)</option>
<option label="Honduras" value="HN" ' . selected('HN', $value, false) . '>Honduras</option>
<option label="Hong Kong" value="HK" ' . selected('HK', $value, false) . '>Hong Kong</option>
<option label="Hungary" value="HU" ' . selected('HU', $value, false) . '>Hungary</option>
<option label="Iceland" value="IS" ' . selected('IS', $value, false) . '>Iceland</option>
<option label="India" value="IN" ' . selected('IN', $value, false) . '>India</option>
<option label="Indonesia" value="ID" ' . selected('ID', $value, false) . '>Indonesia</option>
<option label="Iran (Islamic Republic Of)" value="IR" ' . selected('IR', $value, false) . '>Iran (Islamic Republic Of)</option>
<option label="Iraq" value="IQ" ' . selected('IQ', $value, false) . '>Iraq</option>
<option label="Ireland" value="IE" ' . selected('IE', $value, false) . '>Ireland</option>
<option label="Israel" value="IL" ' . selected('IL', $value, false) . '>Israel</option>
<option label="Italy" value="IT" ' . selected('IT', $value, false) . '>Italy</option>
<option label="Jamaica" value="JM" ' . selected('JM', $value, false) . '>Jamaica</option>
<option label="Japan" value="JP" ' . selected('JP', $value, false) . '>Japan</option>
<option label="Jordan" value="JO" ' . selected('JO', $value, false) . '>Jordan</option>
<option label="Kazakhstan" value="KZ" ' . selected('KZ', $value, false) . '>Kazakhstan</option>
<option label="Kenya" value="KE" ' . selected('KE', $value, false) . '>Kenya</option>
<option label="Kiribati" value="KI" ' . selected('KI', $value, false) . '>Kiribati</option>
<option label="Korea, Democratic People' . "'" . 's Republic Of" value="KP" ' . selected('KP', $value, false) . '>Korea, Democratic People' . "'" . 's Republic Of</option>
<option label="Korea, Republic Of" value="KR" ' . selected('KR', $value, false) . '>Korea, Republic Of</option>
<option label="Kuwait" value="KW" ' . selected('KW', $value, false) . '>Kuwait</option>
<option label="Kyrgyzstan" value="KG" ' . selected('KG', $value, false) . '>Kyrgyzstan</option>
<option label="Lao People' . "'" . 's Democratic Republic" value="LA" ' . selected('LA', $value, false) . '>Lao People' . "'" . 's Democratic Republic</option>
<option label="Latvia" value="LV" ' . selected('LV', $value, false) . '>Latvia</option>
<option label="Lebanon" value="LB" ' . selected('LB', $value, false) . '>Lebanon</option>
<option label="Lesotho" value="LS" ' . selected('LS', $value, false) . '>Lesotho</option>
<option label="Liberia" value="LR" ' . selected('LR', $value, false) . '>Liberia</option>
<option label="Libyan Arab Jamahiriya" value="LY" ' . selected('LY', $value, false) . '>Libyan Arab Jamahiriya</option>
<option label="Liechtenstein" value="LI" ' . selected('LI', $value, false) . '>Liechtenstein</option>
<option label="Lithuania" value="LT" ' . selected('LT', $value, false) . '>Lithuania</option>
<option label="Luxembourg" value="LU" ' . selected('LU', $value, false) . '>Luxembourg</option>
<option label="Macau" value="MO" ' . selected('MO', $value, false) . '>Macau</option>
<option label="Macedonia, Former Yugoslav Republic Of" value="MK" ' . selected('MK', $value, false) . '>Macedonia, Former Yugoslav Republic Of</option>
<option label="Madagascar" value="MG" ' . selected('MG', $value, false) . '>Madagascar</option>
<option label="Malawi" value="MW" ' . selected('MW', $value, false) . '>Malawi</option>
<option label="Malaysia" value="MY" ' . selected('MY', $value, false) . '>Malaysia</option>
<option label="Maldives" value="MV" ' . selected('MV', $value, false) . '>Maldives</option>
<option label="Mali" value="ML" ' . selected('ML', $value, false) . '>Mali</option>
<option label="Malta" value="MT" ' . selected('MT', $value, false) . '>Malta</option>
<option label="Marshall Islands" value="MH" ' . selected('MH', $value, false) . '>Marshall Islands</option>
<option label="Martinique" value="MQ" ' . selected('MQ', $value, false) . '>Martinique</option>
<option label="Mauritania" value="MR" ' . selected('MR', $value, false) . '>Mauritania</option>
<option label="Mauritius" value="MU" ' . selected('MU', $value, false) . '>Mauritius</option>
<option label="Mayotte" value="YT" ' . selected('YT', $value, false) . '>Mayotte</option>
<option label="Mexico" value="MX" ' . selected('MX', $value, false) . '>Mexico</option>
<option label="Micronesia, Federated States Of" value="FM" ' . selected('FM', $value, false) . '>Micronesia, Federated States Of</option>
<option label="Moldova, Republic Of" value="MD" ' . selected('MD', $value, false) . '>Moldova, Republic Of</option>
<option label="Monaco" value="MC" ' . selected('MC', $value, false) . '>Monaco</option>
<option label="Mongolia" value="MN" ' . selected('MN', $value, false) . '>Mongolia</option>
<option label="Montserrat" value="MS" ' . selected('MS', $value, false) . '>Montserrat</option>
<option label="Morocco" value="MA" ' . selected('MA', $value, false) . '>Morocco</option>
<option label="Mozambique" value="MZ" ' . selected('MZ', $value, false) . '>Mozambique</option>
<option label="Myanmar" value="MM" ' . selected('MM', $value, false) . '>Myanmar</option>
<option label="Namibia" value="NA" ' . selected('NA', $value, false) . '>Namibia</option>
<option label="Nauru" value="NR" ' . selected('NR', $value, false) . '>Nauru</option>
<option label="Nepal" value="NP" ' . selected('NP', $value, false) . '>Nepal</option>
<option label="Netherlands" value="NL" ' . selected('NL', $value, false) . '>Netherlands</option>
<option label="Netherlands Antilles" value="AN" ' . selected('AN', $value, false) . '>Netherlands Antilles</option>
<option label="New Caledonia" value="NC" ' . selected('NC', $value, false) . '>New Caledonia</option>
<option label="New Zealand" value="NZ" ' . selected('NZ', $value, false) . '>New Zealand</option>
<option label="Nicaragua" value="NI" ' . selected('NI', $value, false) . '>Nicaragua</option>
<option label="Niger" value="NE" ' . selected('NE', $value, false) . '>Niger</option>
<option label="Nigeria" value="NG" ' . selected('NG', $value, false) . '>Nigeria</option>
<option label="Niue" value="NU" ' . selected('NU', $value, false) . '>Niue</option>
<option label="Norfolk Island" value="NF" ' . selected('NF', $value, false) . '>Norfolk Island</option>
<option label="Northern Mariana Islands" value="MP" ' . selected('MP', $value, false) . '>Northern Mariana Islands</option>
<option label="Norway" value="NO" ' . selected('NO', $value, false) . '>Norway</option>
<option label="Oman" value="OM" ' . selected('OM', $value, false) . '>Oman</option>
<option label="Pakistan" value="PK" ' . selected('PK', $value, false) . '>Pakistan</option>
<option label="Palau" value="PW" ' . selected('PW', $value, false) . '>Palau</option>
<option label="Panama" value="PA" ' . selected('PA', $value, false) . '>Panama</option>
<option label="Papua New Guinea" value="PG" ' . selected('PG', $value, false) . '>Papua New Guinea</option>
<option label="Paraguay" value="PY" ' . selected('PY', $value, false) . '>Paraguay</option>
<option label="Peru" value="PE" ' . selected('PE', $value, false) . '>Peru</option>
<option label="Philippines" value="PH" ' . selected('PH', $value, false) . '>Philippines</option>
<option label="Pitcairn" value="PN" ' . selected('PN', $value, false) . '>Pitcairn</option>
<option label="Poland" value="PL" ' . selected('PL', $value, false) . '>Poland</option>
<option label="Portugal" value="PT" ' . selected('PT', $value, false) . '>Portugal</option>
<option label="Qatar" value="QA" ' . selected('QA', $value, false) . '>Qatar</option>
<option label="Reunion" value="RE" ' . selected('RE', $value, false) . '>Reunion</option>
<option label="Romania" value="RO" ' . selected('RO', $value, false) . '>Romania</option>
<option label="Russian Federation" value="RU" ' . selected('RU', $value, false) . '>Russian Federation</option>
<option label="Rwanda" value="RW" ' . selected('RW', $value, false) . '>Rwanda</option>
<option label="Saint Kitts And Nevis" value="KN" ' . selected('KN', $value, false) . '>Saint Kitts And Nevis</option>
<option label="Saint Lucia" value="LC" ' . selected('LC', $value, false) . '>Saint Lucia</option>
<option label="Saint Vincent And The Grenadines" value="VC" ' . selected('VC', $value, false) . '>Saint Vincent And The Grenadines</option>
<option label="Samoa" value="WS" ' . selected('WS', $value, false) . '>Samoa</option>
<option label="San Marino" value="SM" ' . selected('SM', $value, false) . '>San Marino</option>
<option label="Sao Tome And Principe" value="ST" ' . selected('ST', $value, false) . '>Sao Tome And Principe</option>
<option label="Saudi Arabia" value="SA" ' . selected('SA', $value, false) . '>Saudi Arabia</option>
<option label="Senegal" value="SN" ' . selected('SN', $value, false) . '>Senegal</option>
<option label="Seychelles" value="SC" ' . selected('SC', $value, false) . '>Seychelles</option>
<option label="Sierra Leone" value="SL" ' . selected('SL', $value, false) . '>Sierra Leone</option>
<option label="Singapore" value="SG" ' . selected('SG', $value, false) . '>Singapore</option>
<option label="Slovakia (Slovak Republic)" value="SK" ' . selected('SK', $value, false) . '>Slovakia (Slovak Republic)</option>
<option label="Slovenia" value="SI" ' . selected('SI', $value, false) . '>Slovenia</option>
<option label="Solomon Islands" value="SB" ' . selected('SB', $value, false) . '>Solomon Islands</option>
<option label="Somalia" value="SO" ' . selected('SO', $value, false) . '>Somalia</option>
<option label="South Africa" value="ZA" ' . selected('ZA', $value, false) . '>South Africa</option>
<option label="South Georgia, South Sandwich Islands" value="GS" ' . selected('GS', $value, false) . '>South Georgia, South Sandwich Islands</option>
<option label="Spain" value="ES" ' . selected('ES', $value, false) . '>Spain</option>
<option label="Sri Lanka" value="LK" ' . selected('LK', $value, false) . '>Sri Lanka</option>
<option label="St. Helena" value="SH" ' . selected('SH', $value, false) . '>St. Helena</option>
<option label="St. Pierre And Miquelon" value="PM" ' . selected('PM', $value, false) . '>St. Pierre And Miquelon</option>
<option label="Sudan" value="SD" ' . selected('SD', $value, false) . '>Sudan</option>
<option label="Suriname" value="SR" ' . selected('SR', $value, false) . '>Suriname</option>
<option label="Svalbard And Jan Mayen Islands" value="SJ" ' . selected('SJ', $value, false) . '>Svalbard And Jan Mayen Islands</option>
<option label="Swaziland" value="SZ" ' . selected('SZ', $value, false) . '>Swaziland</option>
<option label="Sweden" value="SE" ' . selected('SE', $value, false) . '>Sweden</option>
<option label="Switzerland" value="CH" ' . selected('CH', $value, false) . '>Switzerland</option>
<option label="Syrian Arab Republic" value="SY" ' . selected('SY', $value, false) . '>Syrian Arab Republic</option>
<option label="Taiwan" value="TW" ' . selected('TW', $value, false) . '>Taiwan</option>
<option label="Tajikistan" value="TJ" ' . selected('TJ', $value, false) . '>Tajikistan</option>
<option label="Tanzania, United Republic Of" value="TZ" ' . selected('TZ', $value, false) . '>Tanzania, United Republic Of</option>
<option label="Thailand" value="TH" ' . selected('TH', $value, false) . '>Thailand</option>
<option label="Togo" value="TG" ' . selected('TG', $value, false) . '>Togo</option>
<option label="Tokelau" value="TK" ' . selected('TK', $value, false) . '>Tokelau</option>
<option label="Tonga" value="TO" ' . selected('TO', $value, false) . '>Tonga</option>
<option label="Trinidad And Tobago" value="TT" ' . selected('TT', $value, false) . '>Trinidad And Tobago</option>
<option label="Tunisia" value="TN" ' . selected('TN', $value, false) . '>Tunisia</option>
<option label="Turkey" value="TR" ' . selected('TR', $value, false) . '>Turkey</option>
<option label="Turkmenistan" value="TM" ' . selected('TM', $value, false) . '>Turkmenistan</option>
<option label="Turks And Caicos Islands" value="TC" ' . selected('TC', $value, false) . '>Turks And Caicos Islands</option>
<option label="Tuvalu" value="TV" ' . selected('TV', $value, false) . '>Tuvalu</option>
<option label="Uganda" value="UG" ' . selected('UG', $value, false) . '>Uganda</option>
<option label="Ukraine" value="UA" ' . selected('UA', $value, false) . '>Ukraine</option>
<option label="United Arab Emirates" value="AE" ' . selected('AE', $value, false) . '>United Arab Emirates</option>
<option label="United Kingdom" value="GB" ' . selected('GB', $value, false) . '>United Kingdom</option>
<option label="United States Minor Outlying Islands" value="UM" ' . selected('UM', $value, false) . '>United States Minor Outlying Islands</option>
<option label="Uruguay" value="UY" ' . selected('UY', $value, false) . '>Uruguay</option>
<option label="Uzbekistan" value="UZ" ' . selected('UZ', $value, false) . '>Uzbekistan</option>
<option label="Vanuatu" value="VU" ' . selected('VU', $value, false) . '>Vanuatu</option>
<option label="Venezuela" value="VE" ' . selected('VE', $value, false) . '>Venezuela</option>
<option label="Viet Nam" value="VN" ' . selected('VN', $value, false) . '>Viet Nam</option>
<option label="Virgin Islands (British)" value="VG" ' . selected('VG', $value, false) . '>Virgin Islands (British)</option>
<option label="Virgin Islands (U.S.)" value="VI" ' . selected('VI', $value, false) . '>Virgin Islands (U.S.)</option>
<option label="Wallis And Futuna Islands" value="WF" ' . selected('WF', $value, false) . '>Wallis And Futuna Islands</option>
<option label="Western Sahara" value="EH" ' . selected('EH', $value, false) . '>Western Sahara</option>
<option label="Yemen" value="YE" ' . selected('YE', $value, false) . '>Yemen</option>
<option label="Yugoslavia" value="YU" ' . selected('YU', $value, false) . '>Yugoslavia</option>
<option label="Zambia" value="ZM" ' . selected('ZM', $value, false) . '>Zambia</option>
<option label="Zimbabwe" value="ZW" ' . selected('ZW', $value, false) . '>Zimbabwe</option>
';
    }
}

?>