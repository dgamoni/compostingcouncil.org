<?php the_content(); ?>



<noscript>



<div class="alert"> JavaScript must be enabled to register online.</div>



</noscript>



<div id="member-box-wrapper" style="margin-top:15px;" >



	<div id="member-box">







<?php //prepare for conditions



	$discount_date = get_option('discount_date');



	$post_data=array(); $post->post_title='';



	if (isset($_GET['get_data_from']) && $_GET['get_data_from']) {



		$loop = new WP_Query( array( 'post_type' => 'register',



			'page_id' => esc_attr($_GET['get_data_from']),



			'post_status' => 'any',



			 ) );



		if ($loop->have_posts()) {



			$loop->the_post();



			$post_data = get_post_meta($post->ID, 'post_data', true);



		}



	} elseif (is_user_logged_in()) {



		$user_data = wp_get_current_user();



		$post->post_title = get_user_meta($user_data->ID,'first_name',true).' '.get_user_meta($user_data->ID,'last_name',true);



		$post_data['email'] = $user_data->user_email;



		$post_data['website'] = $user_data->user_url;





		global $amember_api;

		if ($amember_api && $user_data->_amember_id && ($amember_api->connection_tested || !($err = $amember_api->connect()))) {

			$amember_user = $amember_api->get_user($user_data->_amember_id);

			//echo "user data: {}"; var_export($amember_user);

			$post->post_title = "{$amember_user['name_f']} {$amember_user['name_l']}";

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







	if (!$post_data['registration_option'] && !$post_data['exam'] && !$post_data['workshop_rate']) {



		$post_data['registration_option']='full';



		$post_data['exam']='no';



		if (is_user_logged_in()) {



			$post_data['rate']='member';



			$post_data['workshop_rate']='member';



		} else {



			$post_data['rate']='nonmember';



			$post_data['workshop_rate']='nonmember';







		}



	}



?>







<form id="registration" action="/admin/wp-content/themes/composting/post_custom.php" method="post" enctype="multipart/form-data">



    <input name="post_type" type="hidden" value="register" />



    <input name="post_status" type="hidden" value="pending" />



    <input type="hidden" name="action" value="post" />



    <input type="hidden" name="_register_http_referer" value="cart" />



    <?php echo wp_nonce_field('add-register','_wpnonce', false , false ); ?>







    <h2>Registrant</h2>



    <dl>



    <dt><span class="required">*</span> <label for="name">Name</label></dt>



        <dd><input type="text" name="post_title" id="name" value="<?php echo esc_attr( htmlspecialchars( $post->post_title ) ); ?>" class="fill required w150" /></dd>



    <dt><span class="required">*</span> <label for="phone">Phone</label></dt>



        <dd><input type="text" name="phone" id="phone" value="<?php echo esc_attr( htmlspecialchars( $post_data['phone'] ) ); ?>" class="fill required w50" /></dd>



    <dt><label for="fax">Fax</label></dt>



        <dd><input type="text" name="fax" id="fax" value="<?php echo esc_attr( htmlspecialchars( $post_data['fax'] ) ); ?>" class="fill w50" /></dd>



    <dt><span class="required">*</span> <label for="company">Company</label></dt>



        <dd><input type="text" name="company" id="company" value="<?php echo esc_attr( htmlspecialchars( $post_data['company'] ) ); ?>" class="fill  required" /></dd>



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



    <dt><span class="required">*</span> <label for="email">E-mail</label></dt>



        <dd><input type="text" name="email" id="email" value="<?php echo esc_attr( htmlspecialchars( $post_data['email'] ) ); ?>" class="fill required" /></dd>



    <dt><label for="website">Website</label></dt>



        <dd><input type="text" name="website" id="website" value="<?php echo esc_attr( htmlspecialchars( $post_data['website'] ) ); ?>" class="fill" /></dd>



    </dl>







    <h2>Emergency Contact Information</h2>



    <dl>



    <dt><label for="emergency_name">Name</label></dt>



        <dd><input type="text" name="emergency_name" id="emergency_name" value="<?php echo esc_attr( htmlspecialchars( $post_data['emergency_name'] ) ); ?>" class="fill" /></dd>



    <dt><label for="emergency_phone">Phone</label></dt>



        <dd><input type="text" name="emergency_phone" id="emergency_phone" value="<?php echo esc_attr( htmlspecialchars( $post_data['emergency_phone'] ) ); ?>" class="fill w50" /></dd>



    </dl>







    <table cellpadding="0" cellspacing="0" width="100%" style="font-size: 135%">



    <tr valign="top">



        <td><input type="radio" id="registration_option_full" name="registration_option" value="full" <?php checked($post_data['registration_option'],'full'); ?>/></td>



        <td>



            <h2><label for="registration_option_full">Full Conference Registration</label></h2>



            <em>Includes sessions and session abstracts, exhibits, breakfasts, refreshment breaks, receptions &amp; equipment demonstrations &amp; tours</em>



        </td>



    </tr>



    <tr valign="top">



        <td></td>



        <td class="if-full">



            <h3><span>Prior to <?php echo display_discount_date(); ?></span></h3>



            <table>



            <tr>



				<td width="22"><?php if (time()<strtotime($discount_date)): ?><input type="radio" id="full-member" name="rate" value="member" onclick="recalculate(this, 375);" class="<?php if (!is_user_logged_in()) echo '" disabled="disabled'; else echo 'registration_option_full' ?>" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'],'member'); ?>  /><?php endif; ?></td>



                <th width="150" align="left"><label for="full-member">Member</label></th>



                <td>$375 <?php if (time()<strtotime($discount_date) && !is_user_logged_in()) echo "<span class='loggin_warning'>Must be a member to select option (<a href='http://www.compostingcouncil.org/registration.php'>Register</a>)</span>"; ?></td>



            </tr>



			<?php if (!is_user_logged_in()): ?>



            <tr>



                <td><?php if (time()<strtotime($discount_date)): ?><input type="radio" id="full-nonmember" name="rate" value="nonmember" onclick="recalculate(this, 445);" class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'],'nonmember'); ?> /><?php endif; ?></td>



                <th align="left"><label for="full-nonmember">Non-Member</label></th>



                <td>$445</td>



            </tr>



			<?php endif; ?>



            <tr>



                <td><?php if (time()<strtotime($discount_date)): ?><input type="radio" id="full-speaker" name="rate" value="speaker" onclick="recalculate(this, 250);" class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'],'speaker'); ?> /><?php endif; ?></td>



                <th align="left"><label for="full-speaker">Conference Speaker</label></th>



                <td>$250</td>



            </tr>



            </table>







            <h3><span>After <?php echo display_discount_date(); ?></span></h3>



            <table>



            <tr>



                <td width="22"><?php if (time()>strtotime($discount_date)): ?><input type="radio" id="full-member" name="rate" value="member" onclick="recalculate(this, 395);" class="<?php if (!is_user_logged_in()) echo '" disabled="disabled'; else echo 'registration_option_full' ?>" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'],'member'); ?>  /><?php endif; ?></td>



                <th width="150" align="left"><label for="full-member">Member</label></th>



                <td>$395 <?php if (time()>strtotime($discount_date) && !is_user_logged_in()) echo "<span class='loggin_warning'>Must be a member to select option (<a href='http://www.compostingcouncil.org/registration.php'>Register</a>)</span>"; ?></td>



            </tr>



			<?php if (!is_user_logged_in()): ?>



            <tr>



                <td><?php if (time()>strtotime($discount_date)): ?><input type="radio" id="full-nonmember" name="rate" value="nonmember" onclick="recalculate(this, 495);" class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'],'nonmember'); ?>  /><?php endif; ?></td>



                <th align="left"><label for="full-nonmember">Non-Member</label></th>



                <td>$495</td>



            </tr>



			<?php endif; ?>



            <tr>



                <td><?php if (time()>strtotime($discount_date)): ?><input type="radio" id="full-speaker" name="rate" value="speaker" onclick="recalculate(this, 250);" class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['rate'],'speaker'); ?> /><?php endif; ?></td>



                <th align="left"><label for="full-speaker">Conference Speaker</label></th>



                <td>$250</td>



            </tr>



            </table>







            <h3><span>Facility Tours</span></h3>



            <table>



            <tr valign="top">



                <td><input type="checkbox" id="tours" name="tour" value="yes" class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['tour'],'yes'); ?> /></td>



                <th align="left"><label for="tours">Attending Composting Equipment Demonstrations &amp; Tour</label></th>



                <td>(Included)</td>



            </tr>



            </table>







            <h3><span>Receptions (included)</span></h3>



            <table width="452">



            <tr>



                <td width="22"><input type="checkbox" id="reception" value="yes" name="reception" class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['reception'],'yes'); ?> /></td>



                <th width="350" align="left"><label for="reception">Exhibitors Reception | Monday January 24</label></th>



                <td width="53">&nbsp;</td>



            </tr>



            <tr>



                <td width="22"><input type="checkbox" id="reception2" value="yes" name="reception2" class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['reception2'],'yes'); ?> /></td>



                <th width="350" align="left"><label for="reception2">BPI Reception | Tuesday January 25</label></th>



                <td width="53">&nbsp;</td>



            </tr>



    </table>







    <h3>Awards Luncheon | Tuesday, Jan 25</h3>



    <table>



    <tr valign="top">



        <td width="22"><input type="checkbox" id="luncheon" name="luncheon" value="yes" onclick="recalculate(this, 25);" class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['luncheon'],'yes'); ?>  /></td>



        <th width="150" align="left"><label for="luncheon">Awards Luncheon</label></th>



        <td>$25</td>



    </tr>



    <tr valign="top">



        <td><input type="checkbox" id="vegetarian" name="vegetarian" value="yes" class="registration_option_full" <?php if ('full' == $post_data['registration_option']) checked($post_data['vegetarian'],'yes'); ?> /></td>



        <th align="left"><label for="vegetarian">Vegetarian Luncheon?</label></th>



        <td></td>



    </tr>



    </table>



        </td>



    </tr>







    <tr valign="top">



        <td><input type="radio" id="registration_option_one-day" name="registration_option" value="one-day" <?php checked($post_data['registration_option'],'one-day'); ?> /></td>



        <td>



            <h2><label for="registration_option_one-day">Conference Registration 1 Day</label></h2>



            <em>Includes sessions and session abstracts, exhibits, breakfasts, refreshment breaks &amp; receptions</em>



        </td>



    </tr>



    <tr valign="top">



        <td></td>



        <td class="if-one-day">



            <h3><span>One Day Pass</span></h3>



            <table>



            <tr>



                <td width="22"><input type="radio" id="one-day-1" name="day" value="1" class="registration_option_one-day" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['day'],'1'); ?> /></td>



                <th width="150" align="left"><label for="one-day-1">Monday, January 24</label></th>



            </tr>



            <tr>



                <td><input type="radio" id="one-day-2" name="day" value="2" class="registration_option_one-day" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['day'],'2'); ?> /></td>



                <th align="left"><label for="one-day-2">Tuesday, January 25</label></th>



            </tr>



            </table>







            <h3><span>Prior to <?php echo display_discount_date(); ?></span></h3>



            <table>



            <tr>



                <td width="22"><?php if (time()<strtotime($discount_date)): ?><input type="radio" id="one-day-member" name="rate" value="one-day-member" onclick="recalculate(this, 225);" class="<?php if (!is_user_logged_in()) echo '" disabled="disabled'; else echo 'registration_option_one-day' ?>" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['rate'],'one-day-member'); ?> /><?php endif; ?></td>



                <th width="150" align="left"><label for="one-day-member">Member</label></th>



                <td>$225 <?php if (time()<strtotime($discount_date) && !is_user_logged_in()) echo "<span class='loggin_warning'>Must be a member to select option (<a href='http://www.compostingcouncil.org/registration.php'>Register</a>)</span>"; ?></td>



            </tr>



			<?php if (!is_user_logged_in()): ?>



            <tr>



                <td><?php if (time()<strtotime($discount_date)): ?><input type="radio" id="one-day-nonmember" name="rate" value="one-day-nonmember" onclick="recalculate(this, 255);" class="registration_option_one-day" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['rate'],'one-day-nonmember'); ?> /><?php endif; ?></td>



                <th align="left"><label for="one-day-nonmember">Non-Member</label></th>



                <td>$255</td>



            </tr>



			<?php endif; ?>



            </table>







            <h3><span>After <?php echo display_discount_date(); ?></span></h3>



            <table>



            <tr>



                <td width="22"><?php if (time()>strtotime($discount_date)): ?><input type="radio" id="one-day-member" name="rate" value="one-day-member" onclick="recalculate(this, 245);" class="<?php if (!is_user_logged_in()) echo '" disabled="disabled'; else echo 'registration_option_one-day'; ?>" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['rate'],'one-day-member'); ?> /><?php endif; ?></td>



                <th width="150" align="left"><label for="one-day-member">Member</label></th>



                <td>$245 <?php if (time()>strtotime($discount_date) && !is_user_logged_in()) echo "<span class='loggin_warning'>Must be a member to select option (<a href='http://www.compostingcouncil.org/registration.php'>Register</a>)</span>"; ?></td>



            </tr>



			<?php if (!is_user_logged_in()): ?>



            <tr>



                <td><?php if (time()>strtotime($discount_date)): ?><input type="radio" id="one-day-nonmember" name="rate" value="one-day-nonmember" onclick="recalculate(this, 280);" class="registration_option_one-day" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['rate'],'one-day-nonmember'); ?> /><?php endif; ?></td>



                <th align="left"><label for="one-day-nonmember">Non-Member</label></th>



                <td>$280</td>



            </tr>



			<?php endif; ?>



            </table>







            <h3><span>Receptions (included)</span></h3>



            <table width="450">



            <tr>



                <td width="29"><input type="checkbox" id="reception" name="reception" value="yes" class="registration_option_one-day one-day-1" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['reception'],'yes'); ?> /></td>



                <th width="330" align="left"><label for="reception">Exhibitors Reception | Monday, January 24</label></th>



                <td width="75">&nbsp;</td>



            </tr>



            <tr>



                <td width="29"><input type="checkbox" id="reception2"  name="reception2" value="yes" class="registration_option_one-day one-day-2" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['reception2'],'yes'); ?> /></td>



                <th width="330" align="left"><label for="reception2">BPI Reception | Tuesday, January 25</label></th>



                <td width="75">&nbsp;</td>



            </tr>



            </table>







            <h3><span>Facility Tour</span></h3>



            <table width="450">



            <tr>



                <td width="29"><input type="checkbox" id="facility-tour" name="facility-tour" value="yes" class="registration_option_one-day" onclick="recalculate(this, 55);" <?php if ('one-day' == $post_data['registration_option']) checked($post_data['facility-tour'],'yes'); ?> /></td>



                <th width="330" align="left"><label for="facility-tour">Equipment Demonstrations &amp; Facility Tour</label></th>



                <td width="75">$55</td>



            </tr>



            </table>



        </td>



    </tr>







    <tr valign="top">



        <td><input type="radio" id="registration_option_tour" name="registration_option" value="tour" <?php checked($post_data['registration_option'],'tour'); ?> /></td>



        <td>



            <h2>



              <label for="registration_option_tour">Equipment Demonstrations &amp; Facility Tour Only | Jan 26</label></h2>



			<em>For TOUR ONLY, includes transportation, equipment demonstrations, lunch &amp; facility tour.</em><br />



			<em>NOTE that the facility tour is INCLUDED in conference registration fees</em>



        </td>



    </tr>



    <tr valign="top" class="if-tour">



        <td></td>



        <td>



            <table>



            <tr>



                <td width="22"><input type="radio" id="rate-tour-only" name="rate" value="tour-only" onclick="recalculate(this, 55);" class="registration_option_tour" <?php if ('tour' == $post_data['registration_option']) checked($post_data['rate'],'tour-only'); ?> /></td>



                <th width="150" align="left"><label for="rate-tour-only">Equipment Demonstrations &amp; Facility Tour</label></th>



                <td>$55</td>



            </tr>



            </table>



        </td>



    </tr>







    <tr valign="top">



        <td><input type="radio" id="registration_option_tradeshow" name="registration_option" value="tradeshow" <?php checked($post_data['registration_option'],'tradeshow'); ?> /></td>



        <td>



            <h2><label for="registration_option_tradeshow">Trade Show Only</label></h2>



            <em>Includes program guide, exhibits, refreshment breaks &amp; receptions</em>



        </td>



    </tr>



    <tr valign="top" class="if-tradeshow">



        <td></td>



        <td>



            <table>



            <tr>



                <td width="22"><input type="radio" id="rate-tradeshow-one" name="rate" value="tradeshow-one" onclick="recalculate(this, 85);" class="registration_option_tradeshow" <?php if ('tradeshow' == $post_data['registration_option']) checked($post_data['rate'],'tradeshow-one'); ?> /></td>



                <th width="150" align="left"><label for="rate-tradeshow-one">One day pass</label></th>



                <td>$85</td>



            </tr>



            </table>







            <table>



            <tr>



                <td width="22"></td>



                <td width="22"><input type="radio" id="tradeshow-day-1" name="day" value="1" class="registration_option_tradeshow rate-tradeshow-one" <?php if (('tradeshow' == $post_data['registration_option']) && ('tradeshow-one' == $post_data['rate'])) checked($post_data['day'],'1'); ?> /></td>



                <th width="150" align="left"><label for="tradeshow-day-1">Monday, January 24</label></th>



            </tr>



            <tr>



                <td width="22"></td>



                <td><input type="radio" id="tradeshow-day-2" name="day" value="2" class="registration_option_tradeshow rate-tradeshow-one" <?php if (('tradeshow' == $post_data['registration_option']) && ('tradeshow-one' == $post_data['rate'])) checked($post_data['day'],'2'); ?> /></td>



                <th align="left"><label for="tradeshow-day-2">Tuesday, January 25</label></th>



            </tr>



            </table>







            <table>



            <tr>



                <td width="22"><input type="radio" id="rate-tradeshow-two" name="rate" value="tradeshow-two" onclick="recalculate(this, 170);" class="registration_option_tradeshow" <?php if ('tradeshow' == $post_data['registration_option']) checked($post_data['rate'],'tradeshow-two'); ?> /></td>



                <th width="150" align="left"><label for="rate-tradeshow-two">Two day pass</label></th>



                <td>$170</td>



            </tr>



            </table>







            <h3><span>Receptions (included)</span></h3>



            <table width="446">



            <tr>



                <td width="22"><input type="checkbox" id="reception" name="reception" value="yes" class="registration_option_tradeshow" <?php if ('tradeshow' == $post_data['registration_option']) checked($post_data['reception'],'yes'); ?> /></td>



                <th width="375" align="left"><label for="reception">Exhibitors Reception | Monday, January 24</label></th>



                <td width="33"></td>



            </tr>



            <tr>



                <td width="22"><input type="checkbox" id="reception2" name="reception2" value="yes" class="registration_option_tradeshow" <?php if ('tradeshow' == $post_data['registration_option']) checked($post_data['reception2'],'yes'); ?> /></td>



                <th width="375" align="left"><label for="reception2">BPI Reception | Tuesday, January 25</label></th>



                <td width="33"></td>



            </tr>



            </table>



        </td>



    </tr>



    </table>















    <h2>Certification Exam | Tuesday Jan 25</h2>



        <strong>Certification Exam for Manager of Compost Programs</strong>(3:30 - 6:30 PM)



    <table>



    <tr valign="top">



        <td width="22"><input type="radio" name="exam" value="no" onclick="recalculate(this, 0);" <?php checked($post_data['exam'],'no'); ?> /></td>



        <th width="150" align="left">None</th>



        <td></td>



    </tr>



    <tr valign="top">



        <td><input type="radio" name="exam" value="member" onclick="recalculate(this, 175);" <?php if (!is_user_logged_in()) echo 'disabled="disabled"' ?> <?php checked($post_data['exam'],'member'); ?> /></td>



        <th align="left">USCC or SWANA Member</th>



        <td>$175 <?php if (!is_user_logged_in()) echo "<span class='loggin_warning'>Must be a member to select option (<a href='http://www.compostingcouncil.org/registration.php'>Register</a>)</span>"; ?></td>



    </tr>



	<?php if (!is_user_logged_in()): ?>



    <tr valign="top">



        <td><input type="radio" name="exam" value="nonmember" onclick="recalculate(this, 300);" <?php checked($post_data['exam'],'nonmember'); ?> /></td>



        <th align="left">Non-Member</th>



        <td>$300</td>



    </tr>



	<?php endif; ?>



    </table>







	<h2>Pre-Conference Training &amp; Workshops | Sunday Jan 23</h2>



    <table id="workshops">



    <tr>



        <th colspan="2"></th>



        <th align="right" style="white-space:nowrap;"><label><input type="radio" id="workshop_rate_memeber" name="workshop_rate" value="member" <?php if (!is_user_logged_in()) echo 'disabled="disabled"' ?> <?php checked($post_data['workshop_rate'],'member'); ?> /> Member</label></th>



        <th align="right" style="white-space:nowrap;">



			<?php if (!is_user_logged_in()): ?>



			<label><input type="radio" id="workshop_rate_nonmemeber" name="workshop_rate" value="nonmember" <?php checked($post_data['workshop_rate'],'nonmember'); ?> /> Non-Member</label>



			<?php endif; ?>



		</th>



    </tr>



    <?php echo display_workshops($post_data); ?>



    </table>







    <h2>Total</h2>



    <p id="total-display">$0</p>







    <input id="btnSubmit2" onclick="return validate('registration')" name="submitted" type="submit" value="SUBMIT AND COMPLETE MORE REGISTRATIONS" />



	<input id="btnSubmit" onclick="return validate('registration')" name="submitted" type="submit" value="SUBMIT REGISTRATION AND CONTINUE TO PAYMENT" />



</form>







	</div>



</div>