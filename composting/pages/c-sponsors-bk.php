<?php the_content(); ?>

<noscript>
<div class="alert"> JavaScript must be enabled to register online.</div>
</noscript>
<div id="member-box-wrapper" style="margin-top:15px;" >
  <div id="member-box">
    <?php

$post_data = array();

if (is_user_logged_in()) {

		$user_data = wp_get_current_user();

		$post_data['name'] = get_user_meta($user_data->ID,'first_name',true).' '.get_user_meta($user_data->ID,'last_name',true);

		$post_data['email'] = $user_data->user_email;

		$post_data['website'] = $user_data->user_url;



		global $amember_api;

		if ($amember_api && $user_data->_amember_id && ($amember_api->connection_tested || !($err = $amember_api->connect()))) {

			$amember_user = $amember_api->get_user($user_data->_amember_id);

			//echo "user data: {}"; var_export($amember_user);

			$post_data['name'] = "{$amember_user['name_f']} {$amember_user['name_l']}";

			$post->post_title = $amember_user['organization'];

			$post_data['email'] = $amember_user['email'];

			$post_data['address'] = $amember_user['street'];

			$post_data['city'] = $amember_user['city'];

			$post_data['state'] = $amember_user['state'];

			$post_data['zipcode'] = $amember_user['zip'];

			$post_data['country'] = $amember_user['country'];

			$post_data['website'] = $amember_user['website'];

		}

}

?>
    <form id="registration" action="/admin/wp-content/themes/composting/post_custom.php" method="post" enctype="multipart/form-data">
      <input name="post_type" type="hidden" value="sponsorship" />
      <input name="post_status" type="hidden" value="pending" />
      <input type="hidden" name="action" value="post" />
      <input type="hidden" name="_sponsorship_http_referer" value="cart" />
      <?php echo wp_nonce_field('add-sponsorship','_wpnonce', false , false ); ?>
      <h2>Sponsorship Agreement</h2>
      <dl>
        <dt><span class="required">*</span>
          <label for="company">Company</label>
        </dt>
        <dd>
          <input type="text" name="post_title" id="company" value="<?php echo esc_attr( htmlspecialchars( $post_data['company'] ) ); ?>" class="fill required" />
        </dd>
        <dt><span class="required">*</span>
          <label for="name">Authorizing Name</label>
        </dt>
        <dd>
          <input type="text" name="name" id="name" value="<?php echo esc_attr( htmlspecialchars( $post_data['name'] ) ); ?>" class="fill required" />
        </dd>
        <dt>
          <label for="title">Authorizing Title</label>
        </dt>
        <dd>
          <input type="text" name="title" id="title" value="" class="fill" />
        </dd>
        <dt><span class="required">*</span>
          <label for="address">Address</label>
        </dt>
        <dd>
          <input type="text" name="address" id="address" value="<?php echo esc_attr( htmlspecialchars( $post_data['address'] ) ); ?>" class="fill required" />
        </dd>
        <dt><span class="required">*</span>
          <label for="city">City</label>
        </dt>
        <dd>
          <input type="text" name="city" id="city" value="<?php echo esc_attr( htmlspecialchars( $post_data['city'] ) ); ?>" class="fill required w50" />
        </dd>
        <dt><span class="required">*</span>
          <label for="state">State</label>
        </dt>
        <dd>
          <select name="state" id="state" class="fill required w50">
            <option label="-- Please Select --" value="">-- Please Select --</option>
            <?php echo get_options_for_forms(array('id'=>'state','value'=>$post_data['state'])); ?>
          </select>
        </dd>
        <dt><span class="required">*</span>
          <label for="zipcode">Zip Code</label>
        </dt>
        <dd>
          <input type="text" name="zipcode" id="zipcode" value="<?php echo esc_attr( htmlspecialchars( $post_data['zipcode'] ) ); ?>" class="fill required w25" maxlength="7" />
        </dd>
        <dt><span class="required">*</span>
          <label for="country">Country</label>
        </dt>
        <dd>
          <select name="country" id="country" class="fill required w50">
            <?php echo get_options_for_forms(array('id'=>'country','value'=>$post_data['country'])); ?>
          </select>
        </dd>
        <dt><span class="required">*</span>
          <label for="phone">Phone</label>
        </dt>
        <dd>
          <input type="text" name="phone" id="phone" value="" class="fill required w50" />
        </dd>
        <dt>
          <label for="fax">Fax</label>
        </dt>
        <dd>
          <input type="text" name="fax" id="fax" value="" class="fill w50" />
        </dd>
        <dt><span class="required">*</span>
          <label for="email">E-mail</label>
        </dt>
        <dd>
          <input type="text" name="email" id="email" value="<?php echo esc_attr( htmlspecialchars( $post_data['email'] ) ); ?>" class="fill required" />
        </dd>
        <dt>
          <label for="website">Website</label>
        </dt>
        <dd>
          <input type="text" name="website" id="website" value="<?php echo esc_attr( htmlspecialchars( $post_data['website'] ) ); ?>" class="fill" />
        </dd>
        <dt><span class="required">*</span>
          <label for="description">Description</label>
        </dt>
        <dd>
          <textarea name="content" id="description" cols="50" rows="5" class="fill required"></textarea>
        </dd>
        <dt>
          <label for="image">Company Logo</label>
        </dt>
        <dd>
          <input type="file" id="image" name="image" />
        </dd>
      </dl>
      <h2>Sponsorship Agreement</h2>
      <table>
        <tr>
          <td> Please enter your company name as you wish to appear in promotional materials related to the Conference </td>
        </tr>
        <tr>
          <td><input type="text" name="promo_name" id="promo_name" value="" class="fill" /></td>
        </tr>
        <tr>
          <td> hereby agrees to contribute the sum of
            
            $
            <input type="text" name="promo_sum" id="promo_sum" value="" class="fill w12h" />
            payable to the US Composting Council to become a "sponsor" of the Annual Conference to be held January 24-27, 2010, in Orlando, Florida. </td>
        </tr>
      </table>
      <h2>Sponsorship Levels</h2>
      <dl class="full">
        <dd>
          <table>
           <tr>
              <td width="22"><input type="radio" id="level_1" name="level" value="1" /></td>
              <th width="200" align="left"><label for="level_1">Double Diamond </label></th>
              <td class="nowrap pad-right">Contribution of</td>
              <td class="nowrap">$25,000 or more </td>
            </tr>
          
          
            <tr>
              <td width="22"><input type="radio" id="level_2" name="level" value="2" /></td>
              <th width="200" align="left"><label for="level_2">Double Platinum</label></th>
              <td class="nowrap pad-right">Contribution between</td>
              <td class="nowrap">t$20,000-$24,999</td>
            </tr>
            <tr>
              <td><input type="radio" id="level_3" name="level" value="3"/></td>
              <th align="left"><label for="level_3">Double Gold</label></th>
              <td class="nowrap pad-right">Contribution between</td>
              <td class="nowrap">$15,000-$19,999</td>
            </tr>
              <tr>
              <td><input type="radio" id="level_4" name="level" value="4"/></td>
              <th align="left"><label for="level_4">Diamond Sponsor</label></th>
              <td class="nowrap pad-right">Contribution between</td>
              <td class="nowrap">$10,000-$14,999</td>
            </tr>
            
            <tr>
              <td><input type="radio" id="level_5" name="level" value="5" /></td>
              <th align="left"><label for="level_5">Platinum Sponsor</label></th>
              <td class="nowrap pad-right">Contribution between</td>
              <td class="nowrap">$7,500 and $9,999</td>
            </tr>
            <tr>
              <td><input type="radio" id="level_6" name="level" value="6" /></td>
              <th align="left"><label for="level_6">Gold Sponsor</label></th>
              <td class="nowrap pad-right">Contribution between</td>
              <td class="nowrap">$5,000 and $7,499</td>
            </tr>
            <tr>
              <td><input type="radio" id="level_7" name="level" value="7" /></td>
              <th align="left"><label for="level_7">Silver Sponsor</label></th>
              <td class="nowrap pad-right">Contribution between</td>
              <td class="nowrap">$2,500 and $4,999</td>
            </tr>
            <tr>
              <td><input type="radio" id="level_8" name="level" value="8" /></td>
              <th align="left"><label for="level_8">Bronze Sponsor</label></th>
              <td class="nowrap pad-right">Contribution between</td>
              <td class="nowrap">$1,000 and $2,499</td>
            </tr>
            <tr>
              <td><input type="radio" id="level_9" name="level" value="9" /></td>
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
          <td width="22"><input id="event_1" type="checkbox" name="event_1" value="1"  /></td>
          <th align="left"><label for="event_1">Welcome Reception</label></th>
          <td width="85">$10,000*</td>
          <td width="65"></td>
        </tr>
        <tr>
          <td><input id="event_2" type="checkbox" name="event_2" value="1"  /></td>
          <th align="left"><label for="event_2">Exhibitors Reception</label></th>
          <td>$15,000*</td>
          <td></td>
        </tr>
        <tr>
          <td><input id="event_3" type="checkbox" name="event_3" value="1"  /></td>
          <th align="left"><label for="event_3">Awards Luncheon</label></th>
          <td>$12,500*</td>
          <td></td>
        </tr>
        <tr>
          <td><input id="event_4" type="checkbox" name="event_4" value="1"  /></td>
          <th align="left"><label for="event_4">Conference Breakfasts in Exhibit Hall</label></th>
          <td>$4,500 each**</td>
          <td>x
            <input type="text" id="event_4_quantity" name="event_4_quantity" value="" maxlength="4" class="fill w12h event_4" disabled="disabled" /></td>
        </tr>
        <tr>
          <td><input id="event_5" type="checkbox" name="event_5" value="1"  /></td>
          <th align="left"><label for="event_5">Conference Breaks in Exhibit Hall</label></th>
          <td>$4,500 each**</td>
          <td>x
            <input type="text" id="event_5_quantity" name="event_5_quantity" value="" maxlength="4" class="fill w12h event_5" disabled="disabled" /></td>
        </tr>
        <tr>
          <td><input id="event_6" type="checkbox" name="event_6" value="1"  /></td>
          <th align="left"><label for="event_6">Keynote Speaker</label></th>
          <td>$5,000</td>
          <td></td>
        </tr>
        <tr>
          <td><input id="event_7" type="checkbox" name="event_7" value="1"  /></td>
          <th align="left"><label for="event_7">Networking Breakfasts</label></th>
          <td>$1,500 each<sup>&dagger;</sup></td>
          <td>x
            <input type="text" id="event_7_quantity" name="event_7_quantity" value="" maxlength="4" class="fill w12h event_7" disabled="disabled" /></td>
        </tr>
        <tr>
          <td><input id="event_8" type="checkbox" name="event_8" value="1"  /></td>
          <th align="left"><label for="event_8">Pre-conference Training Courses &amp; Workshops</label></th>
          <td>$2,500 each<sup>&dagger;&dagger;</sup></td>
          <td>x
            <input type="text" id="event_8_quantity" name="event_8_quantity" value="" maxlength="4" class="fill w12h event_8" disabled="disabled" /></td>
        </tr>
        <tr>
          <td><input id="event_9" type="checkbox" name="event_9" value="1"  /></td>
          <th align="left"><label for="event_9">Conference Attache</label></th>
          <td>$5,000</td>
          <td></td>
        </tr>
      </table>
      <br />
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
          <td>10 Training courses: <a href="<?php bloginfo('url'); ?>/workshops/" target="_blank">www.compostingcouncil.org/workshops </a></td>
        </tr>
      </table>
      <h2>Equipment Demonstration Sponsorships</h2>
      <table id="equipment" width="100%">
        <tr>
          <td width="22"><input id="equipment_1" type="checkbox" name="equipment_1" value="1"  /></td>
          <th align="left"><label for="equipment_1">Luncheon at Host Compost Facility</label></th>
          <td width="85">$5,000*</td>
          <td width="55"></td>
        </tr>
        <tr>
          <td><input id="equipment_2" type="checkbox" name="equipment_2" value="1"  /></td>
          <th align="left"><label for="equipment_2">Transportation (buses for attendees)</label></th>
          <td>$3,500*</td>
          <td></td>
        </tr>
        <tr>
          <td><input id="equipment_3" type="checkbox" name="equipment_3" value="1"  /></td>
          <th align="left"><label for="equipment_3">Tent, tables and chairs</label></th>
          <td>$2,500*</td>
          <td></td>
        </tr>
        <tr>
          <td><input id="equipment_4" type="checkbox" name="equipment_4" value="1"  /></td>
          <th align="left"><label for="equipment_4">Hard Hats</label></th>
          <td>$2,000*</td>
          <td></td>
        </tr>
        <tr>
          <td><input id="equipment_5" type="checkbox" name="equipment_5" value="1"  /></td>
          <th align="left"><label for="equipment_5">Morning Refreshments (coffee, pastries, etc.)</label></th>
          <td>$1,000</td>
          <td></td>
        </tr>
        <tr>
          <td><input id="equipment_6" type="checkbox" name="equipment_6" value="1" /></td>
          <th align="left"><label for="equipment_6">Bottled Water</label></th>
          <td>$1,000</td>
          <td></td>
        </tr>
      </table>
      <br />
      <p>
        <input type="submit" name="submitted" value="Register" onclick="return ValidateSponsor();" />
      </p>
    </form>
    <script type="text/javascript">

//<![CDATA[

(function($) {

$(document).ready(function() {

	window['ValidateSponsor'] = function()	{

		if(!validate('registration'))

		{

			return false;

		}

		var no_promo_name = $("#promo_name").val() == "";

		var no_promo_sum = $("#promo_sum").val() == "";

		var no_sponsorship_level = $("#registration input[name=level]:checked").val() == undefined;

		if(no_sponsorship_level || no_promo_name || no_promo_sum)

		{

			alert('Please fill out either Sponsorship Agreement or Sponsorship Level');

			return false;

		}

		return true;

	}



});

})(jQuery);

//]]>

</script>
  </div>
</div>
