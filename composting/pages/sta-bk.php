<?php
//die('her1e');
include(ABSPATH . '/../amember/config.inc.php');
$t = & new_smarty();
$t->assign('config', $config);

$current_url = $_SERVER["REQUEST_URI"];

$state = $_REQUEST['state'];
$members = get_sta_member_by_state($state);

$last_state = null;
$content_html = '';

$states_show = $state;
$states_show_manipulated = $state;
$index = 0;

foreach ($members as $m) {
    $m_state = $m['state'];

    if ($m_state != $last_state && count($states_show) > 0) {
        //        print_r($states_show);

        foreach ($states_show as $k => $v) {
            if ($m_state != $v) {
                $last_state = $v;
                $last_state_name = get_state_name($last_state);
                $content_html .= "<h2>$last_state_name</h2>";
                $content_html .= "<h3><em>STA participants coming soon!</em></h3>";
                $index++;

                unset($states_show_manipulated[$k]);
            } else {
                unset($states_show_manipulated[$k]);

                break;
            }
        }

        $states_show = $states_show_manipulated;

    }


    if ($m_state != $last_state) {
        if ($index > 1) {
            $content_html .= '<a href="#uscc">Back to Top</a></p>';

        }

        $last_state = $m_state;
        $last_state_name = get_state_name($last_state);
        $content_html .= "<h2>$last_state_name</h2>";
        $index++;

    }

    $t_html="";
    if(!empty($m['phone'])){
        $t_html=" T: {$m['phone']}<br/>";
    }

    $f="";
     if(!empty($m['fax'])){
        $f=" F: {$m['fax']}<br/>";
    }

    $content_html .= "<h3><span style='color: rgb(0, 128, 0);'>
    <strong>{$m['organization']}</strong></span></h3>

            <p>{$m['street']}<br/>
                {$m['city']}, {$m['state']} {$m['zip']}<br/>
                Contact: {$m['name_f']} {$m['name_l']} <br/>
                $t_html
                $f

                <a href='mailto:{$m['email']}'>{$m['email']}</a><br/>
                <a href='" . getWebsiteWithHttp($m['website']) . "'>" . getWebsiteWithHttp($m['website']) . "</a><br/>
            </p>

            ";


    $content_html .= getContactsHtml($m);

}

if ($index > 1) {
    $content_html .= '<a href="#uscc">Back to Top</a></p>';

}

if (count($states_show_manipulated) > 0) {
    foreach ($states_show_manipulated as $s) {
        $last_state = $s;
        $last_state_name = get_state_name($last_state);
        $content_html .= "<h2>$last_state_name</h2>";
        $content_html .= "<h3><em>STA participants coming soon!</em></h3>";
        $index++;

        if ($index > 1) {
            $content_html .= '<a href="#uscc">Back to Top</a></p>';

        }
    }
}


function getContactsHtml($user) {
    global $db, $t;
    $contacts_temp = $user['contacts'];
    $contacts = json_decode($contacts_temp);
    ////////////////////////////////////contact
    $contact_info_html = '';

    for ($i = 1; $i < count($contacts); $i++) {

        if ($contacts[$i]) {
            $contact_temp = $contacts[$i];
            $u_temp = array();
            $u_temp["name_prefix_1"] = $contact_temp->name_prefix;

            if(empty( $contact_temp->name_first))continue;

            $u_temp["name_f_1"] = $contact_temp->name_first;
            $u_temp["name_middle_1"] = $contact_temp->name_middle;
            $u_temp["name_l_1"] = $contact_temp->name_last;
            $u_temp["name_suffix_1"] = $contact_temp->name_suffix;
            $u_temp["title_1"] = $contact_temp->title;
            $u_temp["phone_1"] = $contact_temp->phone;
            $u_temp["phone_ex_1"] = $contact_temp->phone_ex;
            $u_temp["fax_1"] = $contact_temp->fax;
            $u_temp["email_1"] = $contact_temp->email;
            $u_temp["street_1"] = $contact_temp->street;
            $u_temp["city_1"] = $contact_temp->city;
            $u_temp["state_1"] = $contact_temp->state;
            $u_temp["country_1"] = $contact_temp->country;
            $u_temp["zipcode_1"] = $contact_temp->zip;

            $index=$i+1;

            $t->assign('user_temp', $u_temp);
            $t->assign('contact_info_index', $index);
            $contact_info_html .= $t->fetch("contact_info_template_sta.html");

            $contact_info_html = preg_replace("/_1/", "_$index", $contact_info_html);
        } else {
            break;
        }
    }

    return $contact_info_html;

}

?>



            <form action="<?=$current_url?>" method="post">
               
                <dd>
                    <select name="state[]" id="state" class="fill w50 required" select>
                        <option label="-- Please Select --" value="">-- Please Select --</option>
                        <optgroup label="United States">
                            <option label="Alabama" value="AL">Alabama</option>
                            <option label="Alaska" value="AK">Alaska</option>
                            <option label="Arizona" value="AZ">Arizona</option>
                            <option label="Arkansas" value="AR">Arkansas</option>
                            <option label="California" value="CA">California</option>
                            <option label="Colorado" value="CO">Colorado</option>
                            <option label="Connecticut" value="CT">Connecticut</option>
                            <option label="Delaware" value="DE">Delaware</option>
                            <option label="District of Columbia" value="DC">District of Columbia</option>
                            <option label="Florida" value="FL">Florida</option>
                            <option label="Georgia" value="GA">Georgia</option>
                            <option label="Hawaii" value="HI">Hawaii</option>
                            <option label="Idaho" value="ID">Idaho</option>
                            <option label="Illinois" value="IL">Illinois</option>
                            <option label="Indiana" value="IN">Indiana</option>
                            <option label="Iowa" value="IA">Iowa</option>
                            <option label="Kansas" value="KS">Kansas</option>
                            <option label="Kentucky" value="KY">Kentucky</option>
                            <option label="Louisiana" value="LA">Louisiana</option>
                            <option label="Maine" value="ME">Maine</option>
                            <option label="Maryland" value="MD">Maryland</option>
                            <option label="Massachusetts" value="MA">Massachusetts</option>
                            <option label="Michigan" value="MI">Michigan</option>
                            <option label="Minnesota" value="MN">Minnesota</option>
                            <option label="Mississippi" value="MS">Mississippi</option>
                            <option label="Missouri" value="MO">Missouri</option>
                            <option label="Montana" value="MT">Montana</option>
                            <option label="Nebraska" value="NE">Nebraska</option>
                            <option label="Nevada" value="NV">Nevada</option>
                            <option label="New Hampshire" value="NH">New Hampshire</option>
                            <option label="New Jersey" value="NJ">New Jersey</option>
                            <option label="New Mexico" value="NM">New Mexico</option>
                            <option label="New York" value="NY">New York</option>
                            <option label="North Carolina" value="NC">North Carolina</option>
                            <option label="North Dakota" value="ND">North Dakota</option>
                            <option label="Ohio" value="OH">Ohio</option>
                            <option label="Oklahoma" value="OK">Oklahoma</option>
                            <option label="Oregon" value="OR">Oregon</option>
                            <option label="Pennsylvania" value="PA">Pennsylvania</option>
                            <option label="Puerto Rico" value="PR">Puerto Rico</option>
                            <option label="Rhode Island" value="RI">Rhode Island</option>
                            <option label="South Carolina" value="SC">South Carolina</option>
                            <option label="South Dakota" value="SD">South Dakota</option>
                            <option label="Tennessee" value="TN">Tennessee</option>
                            <option label="Texas" value="TX">Texas</option>
                            <option label="Utah" value="UT">Utah</option>
                            <option label="Vermont" value="VT">Vermont</option>
                            <option label="Virginia" value="VA">Virginia</option>
                            <option label="Washington" value="WA">Washington</option>
                            <option label="West Virginia" value="WV">West Virginia</option>
                            <option label="Wisconsin" value="WI">Wisconsin</option>
                            <option label="Wyoming" value="WY">Wyoming</option>
                            <option label="Virgin Islands" value="VI">Virgin Islands</option>
                        </optgroup>


                    </select>
               
                <input type="submit" value="Search"/>
 </dd>
            </form>
            
            
        <?=$content_html?>

      