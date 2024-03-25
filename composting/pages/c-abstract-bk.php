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

			$post_data['company'] = $amember_user['organization'];

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

    <input name="post_type" type="hidden" value="abstracts" />

    <input name="post_status" type="hidden" value="pending" />

    <input type="hidden" name="action" value="post" />

    <input type="hidden" name="_abstracts_http_referer" value="frontend" />



    <?php echo wp_nonce_field('add-abstracts','_wpnonce', false , false ); ?>



    <p><em>Fields marked with an asterisk <span class="required">*</span> are required.</em></p>

    <dl>

    <dt><span class="required">*</span><label for="abstract_title">Presentation Title</label></dt>

        <dd><input type="text" id="abstract_title" name="post_title" class="fill required" value="" /></dd>

    <dt><span class="required">*</span><label for="contact">Author</label></dt>

        <dd><input type="text" id="contact" name="contact" class="fill required" value="<?php echo esc_attr( htmlspecialchars( $post_data['name'] ) ); ?>" /></dd>

    <dt><label for="affiliation">Affiliation</label></dt>

        <dd><input type="text" id="affiliation" name="affiliation" class="fill" value="<?php echo esc_attr( htmlspecialchars( $post_data['company'] ) ); ?>" /></dd>

    <dt><span class="required">*</span> <label for="phone">Phone</label></dt>

        <dd><input type="text" id="phone" name="phone" class="fill w50 required" value="" /></dd>

    <dt><label for="fax">Fax</label></dt>

        <dd><input type="text" id="fax" name="fax" class="fill w50" value="" /></dd>

    <dt><span class="required">*</span> <label for="email">E-mail</label></dt>

        <dd><input type="text" id="email" name="email" class="fill required" value="<?php echo esc_attr( htmlspecialchars( $post_data['email'] ) ); ?>" /></dd>

    <dt><span class="required">*</span> <label for="address">Address</label></dt>

        <dd><input type="text" id="address" name="address" class="fill required" value="<?php echo esc_attr( htmlspecialchars( $post_data['address'] ) ); ?>" /></dd>

    <dt><span class="required">*</span> <label for="city">City</label></dt>

        <dd><input type="text" id="city" name="city" class="fill w50 required" value="<?php echo esc_attr( htmlspecialchars( $post_data['city'] ) ); ?>" /></dd>

    <dt><span class="required">*</span> <label for="state">State</label></dt>

        <dd>

            <select name="state" id="state" class="fill required w50">

            <option label="-- Please Select --" value="">-- Please Select --</option>

            <?php echo get_options_for_forms(array('id'=>'state','value'=>$post_data['state'])); ?>

            </select>

        </dd>

    <dt><span class="required">*</span> <label for="zipcode">Zip Code</label></dt>

        <dd><input type="text" id="zipcode" name="zipcode" class="fill w25 required" value="<?php echo esc_attr( htmlspecialchars( $post_data['zipcode'] ) ); ?>" /></dd>

    <dt><span class="required">*</span> <label for="country">Country</label></dt>

        <dd>

            <select name="country" id="country" class="fill required w50">

            <?php echo get_options_for_forms(array('id'=>'country','value'=>$post_data['country'])); ?>

            </select>

        </dd>

    <dt ><label>Additional authors and their emails</label></dt>

        <dd><textarea rows="4" cols="40" id="authors" name="additional" class="fill"></textarea></dd>
   <div style="clear:both; height:7px;"></div>
  <dt style="width:250px; margin-right:10px;" > <label style="f" >**Would you like your paper to be considered for
 publication in a  Peer-reviewed publication?</label></dt>

        <dd>

            <label><input type="radio" name="consider" value="1" /> Yes</label>

            <label><input type="radio" name="consider" value="0" /> No</label>

        </dd>
        <div style="clear:both; height:10px;"></div>

    <dt style="width:200px; margin-right:10px;"><label>How do you wish to present?</label></dt>

        <dd>

            <select name="present" id="present" class="fill w50">

                <option label="-- Please Select --" value="">-- Please Select --</option>

                <option label="Oral only" value="oral">Oral only</option>

                <option label="Poster only" value="poster">Poster only</option>

                <option label="Oral &amp; Poster" value="both">Oral &amp; Poster</option>

            </select>

        </dd>
<dt><label>BRIEF Presenter bio <br />
 <span style="font-size:10px; font-style:italic">75 word limit.  <br />
 May be provided as an attachment</span></label></dt>
<dd><textarea rows="5" cols="45" name="content" class="fill"></textarea></dd>




    <dt><label for="abstract">Upload BRIEF</label>
    </dt>

        <dd>

            <input type="file" id="file" name="file" class="fill" />

        </dd>

    <dt><span class="required">*</span> <label for="security_code">Security Code</label></dt>

        <dd>

          <table style="margin:0">

          <tr>

          <td>

          <img src="<?php bloginfo('url'); ?>/admin/wp-content/captcha/CaptchaSecurityImages.php?width=150&amp;height=40&amp;characters=5" width="150" height="40" /><br />

          <input id="security_code" name="security_code" type="text" class="required fill" style="width:150px" />

          </td>

          <td>Please re-type the characters shown in the image. Characters are case-sensitive.</td>

          </tr>

          </table>

        </dd>

        <dd class="submit"><input type="submit" name="submitted" value="Submit Abstract" onclick="return validate('registration')" /></dd>

    </dl>

</form>



	</div>

</div>