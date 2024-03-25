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

    <input name="post_type" type="hidden" value="exhibitors" />

    <input name="post_status" type="hidden" value="pending" />

    <input type="hidden" name="action" value="post" />

    <input type="hidden" name="_exhibitors_http_referer" value="cart" />



    <?php echo wp_nonce_field('add-exhibitors','_wpnonce', false , false ); ?>



    <h2>Exhibitor Registration</h2>

    <dl>

    <dt><span class="required">*</span> <label for="company">Company</label></dt>

        <dd><input type="text" name="post_title" id="company" value="<?php echo esc_attr( htmlspecialchars( $post_data['organization'] ) ); ?>" class="fill  required" /></dd>

    <dt><span class="required">*</span> <label for="address">Address</label></dt>

        <dd><input type="text" name="address" id="address" value="<?php echo esc_attr( htmlspecialchars( $post_data['address'] ) ); ?>" class="fill required" /></dd>

    <dt><span class="required">*</span> <label for="city">City</label></dt>

        <dd><input type="text" name="city" id="city" value="<?php echo esc_attr( htmlspecialchars( $post_data['city'] ) ); ?>" class="fill required w50" /></dd>

    <dt><span class="required">*</span> <label for="state">State</label></dt>

        <dd>

            <select name="state" id="state" class="fill required w50">

            <option label="-- Please Select --" value="">-- Please Select --</option>

            <?php echo get_options_for_forms(array('id'=>'state','value'=>$post_data['state'])); ?>

            </select>

        </dd>

    <dt><span class="required">*</span> <label for="zipcode">Zip Code</label></dt>

        <dd><input type="text" name="zipcode" id="zipcode" value="<?php echo esc_attr( htmlspecialchars( $post_data['zipcode'] ) ); ?>" class="fill required w25" maxlength="7" /></dd>

    <dt><span class="required">*</span> <label for="country">Country</label></dt>

        <dd>

            <select name="country" id="country" class="fill required w50">

            <?php echo get_options_for_forms(array('id'=>'country','value'=>$post_data['country'])); ?>

            </select>

        </dd>

    <dt><span class="required">*</span> <label for="phone">Phone</label></dt>

        <dd><input type="text" name="phone" id="phone" value="" class="fill required w50" /></dd>

    <dt><label for="fax">Fax</label></dt>

        <dd><input type="text" name="fax" id="fax" value="" class="fill w50" /></dd>

    <dt><span class="required">*</span> <label for="email">E-mail</label></dt>

        <dd><input type="text" name="email" id="email" value="<?php echo esc_attr( htmlspecialchars( $post_data['email'] ) ); ?>" class="fill required" /></dd>

    <dt><label for="description">Website</label></dt>

        <dd><input type="text" name="website" id="website" value="<?php echo esc_attr( htmlspecialchars( $post_data['website'] ) ); ?>" class="fill" /></dd>

    <dt><label for="description">Description</label></dt>

        <dd><textarea name="content" id="description" cols="50" rows="5" class="fill"></textarea></dd>

    </dl>



    <h2>Company Rep #1</h2>

    <dl>

    <dt><span class="required">*</span> <label for="rep1_name">Name</label></dt>

        <dd><input type="text" name="rep1_name" id="rep1_name" value="<?php echo esc_attr( htmlspecialchars( $post_data['name'] ) ); ?>" class="fill required" /></dd>

    <dt><span class="required">*</span> <label for="rep1_email">E-mail</label></dt>

        <dd><input type="text" name="rep1_email" id="rep1_email" value="<?php echo esc_attr( htmlspecialchars( $post_data['email'] ) ); ?>" class="fill required" /></dd>

    <dt><span class="required">*</span> <label for="rep1_phone">Phone</label></dt>

        <dd><input type="text" name="rep1_phone" id="rep1_phone" value="" class="fill required w50" /></dd>

    <dt>&nbsp;</dt>

        <dd><label><input type="checkbox" name="rep1_reception" value="1" /> Exhibitor Reception</label></dd>

    <dt>&nbsp;</dt>

        <dd><label><input type="checkbox" name="rep1_tour" value="1" /> Tour &amp; Equipment Demonstrations</label></dd>

    </dl>



    <h2>Company Rep #2</h2>

    <dl>

    <dt><label for="rep2_name">Name</label></dt>

        <dd><input type="text" name="rep2_name" id="rep2_name" value="" class="fill" /></dd>

    <dt><label for="rep2_email">E-mail</label></dt>

        <dd><input type="text" name="rep2_email" id="rep2_email" value="" class="fill" /></dd>

    <dt><label for="rep2_phone">Phone</label></dt>

        <dd><input type="text" name="rep2_phone" id="rep2_phone" value="" class="fill w50" /></dd>

    <dt>&nbsp;</dt>

        <dd><label><input type="checkbox" name="rep2_reception" value="1" /> Exhibitor Reception</label></dd>

    <dt>&nbsp;</dt>

        <dd><label><input type="checkbox" name="rep2_tour" value="1" /> Tour &amp; Equipment Demonstrations</label></dd>

    </dl>



    <h2>Company Rep #3</h2>

    <dl>

    <dt><label for="rep3_name">Name</label></dt>

        <dd><input type="text" name="rep3_name" id="rep3_name" value="" class="fill" /></dd>

    <dt><label for="rep3_email">E-mail</label></dt>

        <dd><input type="text" name="rep3_email" id="rep3_email" value="" class="fill" /></dd>

    <dt><label for="rep3_phone">Phone</label></dt>

        <dd><input type="text" name="rep3_phone" id="rep3_phone" value="" class="fill w50" /></dd>

    <dt>&nbsp;</dt>

        <dd><label><input type="checkbox" name="rep3_reception" value="1" /> Exhibitor Reception</label></dd>

    <dt>&nbsp;</dt>

        <dd><label><input type="checkbox" name="rep3_tour" value="1" /> Tour &amp; Equipment Demonstrations</label></dd>

    </dl>



    <h2>Display Type &amp; Prices</h2>

    <p><em>Registration fee includes exhibit space, sessions and program book, breakfast, refreshment breaks, and the Exhibitors Reception.</em></p>



    <h3><span>Floor Display</span></h3>

    <p><em>Each 8' x 10' includes 2 free attendees, draped cloth 6' table, 2 chairs, &amp; wastebasket</em></p>

    <dl class="full">

        <dd>

		    <table>

		    <tr>

		        <th width="100" align="center">8' x 10'</th>

		        <td width="22"><input id="display_type_3" type="radio" name="display_type" value="3" class="required" <?php if (!is_user_logged_in()) echo 'disabled="disabled"'; ?> /></td>

		        <th width="150" align="left"><label for="display_type_3">Member</label><?php if (!is_user_logged_in()) echo "<br/><span style='font-weight:normal;' class='loggin_warning'>Must be a member to select option (<a href='http://www.compostingcouncil.org/registration.php'>Register</a>)</span>"; ?></th>

		        <td>$1075</td>

                <td>x <select id="display_type_3_mult" name="display_type_3_mult" maxlength="4" rel="1075" class="recalc_multiple display_type_3" disabled="disabled">

                        <option value="1">1</option>

                        <option value="2">2</option>

                        <option value="3">3</option>

                        <option value="4">4</option>

                        <option value="5">5</option>

                        <option value="6">6</option>

                        <option value="7">7</option>

                        <option value="8">8</option>

                        <option value="9">9</option>

                        <option value="10">10</option>

                      </select>

                </td>

		    </tr>

			<?php if (!is_user_logged_in()): ?>

		    <tr>

		        <th></th>

		        <td><input type="radio" id="display_type_4" name="display_type" value="4" class="required"/></td>

		        <th align="left"><label for="display_type_4">Non-Member</label></th>

		        <td>$1345</td>

                <td>x <select id="display_type_4_mult" name="display_type_4_mult" maxlength="4" rel="1345" class="recalc_multiple display_type_4" disabled="disabled">

                        <option value="1">1</option>

                        <option value="2">2</option>

                        <option value="3">3</option>

                        <option value="4">4</option>

                        <option value="5">5</option>

                        <option value="6">6</option>

                        <option value="7">7</option>

                        <option value="8">8</option>

                        <option value="9">9</option>

                        <option value="10">10</option>

                      </select>

                 </td>

		    </tr>

			<?php endif; ?>

		    </table>

        </dd>

    </dl>



    <h3><span>Additional</span></h3>

    <table>

    <tr>

        <td width="22"><input id="electrical" type="checkbox" name="electrical" value="1" onclick="recalculate(this, 75);" /></td>

        <th align="left"><label for="electrical">Electrical Hookup</label></th>

        <td>$75</td>

        <td></td>

    </tr>

    <tr>

        <td></td>

        <th align="left"><label for="additional_reps">Additional Firm Representatives</label></th>

        <td>$250 each</td>

        <td>x <input type="text" id="additional_reps" name="additional_reps" value="250" maxlength="4" class="fill w12h recalc_multiple" /></td>

    </tr>

    <tr>

        <td></td>

        <th align="left"><label for="luncheon">Attending Awards Luncheon</label></th>

        <td>$25 each</td>

        <td>x <input type="text" id="luncheon" name="luncheon" value="25" maxlength="4" class="fill w12h recalc_multiple" /></td>

    </tr>

    <tr>

        <td></td>

        <th align="left"><label for="vegetarian">Number of vegetarian meals</label></th>

        <td colspan="2"><input type="text" id="vegetarian" name="vegetarian" value="" maxlength="4" class="fill w12h" /></td>

    </tr>

    </table>



    <h2>Insurance Note</h2>

    <p>The Hotel is not responsible for property brought onto or stored on the Hotel's premises by exhibitors, and it is the responsibility of the exhibitor to obtain and maintain any insurance coverage on such property. Exhibitors must also abide by the hotel's guidelines for use of convention space.</p>



    <h2>Total</h2>

    <p id="total-display">$0</p>



    <p><input id="btnSubmit" type="submit" name="submitted" value="Continue to Payment" onclick="return validate('registration')" disabled/></p>

</form>





	</div>

</div>