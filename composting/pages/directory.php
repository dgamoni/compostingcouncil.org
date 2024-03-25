



<?php the_content(); ?>





<?php











if (isset($_POST['category'])) {

    if ($_POST['category'] == "all") {

        $d = "";

    } else {

        $d = "`category` = '" . mysql_escape_string($_POST['category']) . "' AND ";

    }

    if ($_POST['region']) {

        $sq = mysql_query("select * from amember_region where name_region = '" . mysql_escape_string($_POST['region']) . "'");

        while ($mes = mysql_fetch_array($sq)) {

            $p .= "`state` = '" . $mes['name_state'] . "' OR ";

        }

    }

    if ($_POST['state']) {

        foreach ($_POST['state'] as $state) {

            $p .= "`state` = '" . mysql_escape_string($state) . "' OR ";

        }

        $a = $p;

        $p = substr($a, -3, 2);

        if ($p == 'OR') {

            $strp = strlen($a);

            $a = substr($a, 0, $strp - 3);

            $a = "(" . $a . ") AND";

        }

    } elseif ($p) {

        $a = $p;

        $p = substr($a, -3, 2);

        if ($p == 'OR') {

            $strp = strlen($a);

            $a = substr($a, 0, $strp - 3);

            $a = "(" . $a . ") AND";

        }

    }

    if ($_POST['country'] != '') {

        $b = "`country` = '" . mysql_escape_string($_POST['country']) . "' AND ";

    }

    if ($_POST['product_category']) {

        $c = "`product_category` like '%\"" . mysql_escape_string($_POST['product_category']) . "\"%' AND ";

    }

    if ($_POST['company'] != '') {

        $e = "`organization` like '%" . mysql_escape_string($_POST['company']) . "%' AND ";

    }

    if ($_POST['name_f']) {

        $name_f = "`name_f` like '%" . mysql_escape_string($_POST['name_f']) . "%' AND ";

    }

    if ($_POST['name_l']) {

        $name_l = "`name_l` like '%" . mysql_escape_string($_POST['name_l']) . "%' AND ";

    }


    $sql = "SELECT * FROM amember_members   m
	inner JOIN amember_payments p on  m.member_id=p.member_id
	WHERE " . $a . $b . $c . $d . $e . $name_f . $name_l . " p.product_id>41

AND  ADDDATE(p.expire_date, 90)>now()

	"; //hardcode

//    echo $sql;

    $strsql = strlen($sql);

    $strand = substr($sql, -4, 3);


    if ($strand == "AND") {

        $sql = substr($sql, 0, $strsql - 4);

    }


    $sql = $sql . "group by m.member_id  order by category";

//    echo $sql;

    $result = mysql_query($sql);

    $num = mysql_num_rows($result);
    if ($_POST['category'] != "all") {
        $sqlCat = "select name from amember_categories where id='" . $_POST['category'] . "' ";
        $resCat = mysql_query($sqlCat) or die(mysql_error() . $sqlCat);
        $arrCat = mysql_fetch_array($resCat);
    }
}


$sqlPCat = "select * from compos_amember.amember_product_categories  order by title asc";
$resPCat = mysql_query($sqlPCat) or die(mysql_error() . $sqlPCat);

?>


















<? if ($result) { ?>
<div style="text-decoration: underline; cursor: pointer;"

     id="show_search">Show Search
</div>
<br/>
<div id="form_search" style="display: none;">
<? } else { ?>
<div id="form_search">
  <? } ?>
<form action="" method="post">
<dl>
<dt>Category</dt>
<dd>
    <select name="category" id="category">
        <!--          <option value="all">All</option>-->
        <option value="2">Consultants</option>
        <option value="3">Equipment Manufacturer / Product Supplier</option>
        <option value="4">Testing Laboratories</option>
        <option value="12">Hauler</option>
    </select>
</dd>
<div style="display: none;" id="product_categories">
    <dt>Product Category</dt>
    <dd>
        <select name="product_category" id="product_category" class="fill w75">
            <option value="">-- Please Select --</option>

        <?php while ($prodcategory = mysql_fetch_array($resPCat)) { ?>

            <option label="<?=$prodcategory['title']?>"
                    value="<?=$prodcategory['code']?>"><?=$prodcategory['title']?></option>

        <?php } ?>
        </select>
    </dd>
</div>
<dt>Country</dt>
<dd>
<select name="country" id="country" class="fill w50 required">
<option label="United States" value="US">United States</option>
<option label="Canada" value="CA">Canada</option>
<option label="Afghanistan" value="AF">Afghanistan</option>
<option label="Albania" value="AL">Albania</option>
<option label="Algeria" value="DZ">Algeria</option>
<option label="American Samoa" value="AS">American Samoa</option>
<option label="Andorra" value="AD">Andorra</option>
<option label="Angola" value="AO">Angola</option>
<option label="Anguilla" value="AI">Anguilla</option>
<option label="Antarctica" value="AQ">Antarctica</option>
<option label="Antigua And Barbuda" value="AG">Antigua And Barbuda</option>
<option label="Argentina" value="AR">Argentina</option>
<option label="Armenia" value="AM">Armenia</option>
<option label="Aruba" value="AW">Aruba</option>
<option label="Australia" value="AU">Australia</option>
<option label="Austria" value="AT">Austria</option>
<option label="Azerbaijan" value="AZ">Azerbaijan</option>
<option label="Bahamas" value="BS">Bahamas</option>
<option label="Bahrain" value="BH">Bahrain</option>
<option label="Bangladesh" value="BD">Bangladesh</option>
<option label="Barbados" value="BB">Barbados</option>
<option label="Belarus" value="BY">Belarus</option>
<option label="Belgium" value="BE">Belgium</option>
<option label="Belize" value="BZ">Belize</option>
<option label="Benin" value="BJ">Benin</option>
<option label="Bermuda" value="BM">Bermuda</option>
<option label="Bhutan" value="BT">Bhutan</option>
<option label="Bolivia" value="BO">Bolivia</option>
<option label="Bosnia And Herzegowina" value="BA">Bosnia And

    Herzegowina
</option>
<option label="Botswana" value="BW">Botswana</option>
<option label="Bouvet Island" value="BV">Bouvet Island</option>
<option label="Brazil" value="BR">Brazil</option>
<option label="British Indian Ocean Territory" value="IO">British

    Indian Ocean Territory
</option>
<option label="Brunei Darussalam" value="BN">Brunei Darussalam</option>
<option label="Bulgaria" value="BG">Bulgaria</option>
<option label="Burkina Faso" value="BF">Burkina Faso</option>
<option label="Burundi" value="BI">Burundi</option>
<option label="Cambodia" value="KH">Cambodia</option>
<option label="Cameroon" value="CM">Cameroon</option>
<option label="Cape Verde" value="CV">Cape Verde</option>
<option label="Cayman Islands" value="KY">Cayman Islands</option>
<option label="Central African Republic" value="CF">Central African

    Republic
</option>
<option label="Chad" value="TD">Chad</option>
<option label="Chile" value="CL">Chile</option>
<option label="China" value="CN">China</option>
<option label="Christmas Island" value="CX">Christmas Island</option>
<option label="Cocos (Keeling) Islands" value="CC">Cocos (Keeling)

    Islands
</option>
<option label="Colombia" value="CO">Colombia</option>
<option label="Comoros" value="KM">Comoros</option>
<option label="Congo" value="CG">Congo</option>
<option label="Congo, The Democratic Republic Of The" value="CD">Congo,

    The Democratic Republic Of The
</option>
<option label="Cook Islands" value="CK">Cook Islands</option>
<option label="Costa Rica" value="CR">Costa Rica</option>
<option label="Cote D'Ivoire" value="CI">Cote D'Ivoire</option>
<option label="Croatia (Hrvatska)" value="HR">Croatia (Hrvatska)</option>
<option label="Cuba" value="CU">Cuba</option>
<option label="Cyprus" value="CY">Cyprus</option>
<option label="Czech Republic" value="CZ">Czech Republic</option>
<option label="Denmark" value="DK">Denmark</option>
<option label="Djibouti" value="DJ">Djibouti</option>
<option label="Dominica" value="DM">Dominica</option>
<option label="Dominican Republic" value="DO">Dominican Republic</option>
<option label="East Timor" value="TP">East Timor</option>
<option label="Ecuador" value="EC">Ecuador</option>
<option label="Egypt" value="EG">Egypt</option>
<option label="El Salvador" value="SV">El Salvador</option>
<option label="Equatorial Guinea" value="GQ">Equatorial Guinea</option>
<option label="Eritrea" value="ER">Eritrea</option>
<option label="Estonia" value="EE">Estonia</option>
<option label="Ethiopia" value="ET">Ethiopia</option>
<option label="Falkland Islands (Malvinas)" value="FK">Falkland

    Islands (Malvinas)
</option>
<option label="Faroe Islands" value="FO">Faroe Islands</option>
<option label="Fiji" value="FJ">Fiji</option>
<option label="Finland" value="FI">Finland</option>
<option label="France" value="FR">France</option>
<option label="France, Metropolitan" value="FX">France, Metropolitan</option>
<option label="French Guiana" value="GF">French Guiana</option>
<option label="French Polynesia" value="PF">French Polynesia</option>
<option label="French Southern Territories" value="TF">French Southern

    Territories
</option>
<option label="Gabon" value="GA">Gabon</option>
<option label="Gambia" value="GM">Gambia</option>
<option label="Georgia" value="GE">Georgia</option>
<option label="Germany" value="DE">Germany</option>
<option label="Ghana" value="GH">Ghana</option>
<option label="Gibraltar" value="GI">Gibraltar</option>
<option label="Greece" value="GR">Greece</option>
<option label="Greenland" value="GL">Greenland</option>
<option label="Grenada" value="GD">Grenada</option>
<option label="Guadeloupe" value="GP">Guadeloupe</option>
<option label="Guam" value="GU">Guam</option>
<option label="Guatemala" value="GT">Guatemala</option>
<option label="Guinea" value="GN">Guinea</option>
<option label="Guinea-Bissau" value="GW">Guinea-Bissau</option>
<option label="Guyana" value="GY">Guyana</option>
<option label="Haiti" value="HT">Haiti</option>
<option label="Heard And McDonald Islands" value="HM">Heard And

    McDonald Islands
</option>
<option label="Holy See (Vatican City State)" value="VA">Holy See

    (Vatican City State)
</option>
<option label="Honduras" value="HN">Honduras</option>
<option label="Hong Kong" value="HK">Hong Kong</option>
<option label="Hungary" value="HU">Hungary</option>
<option label="Iceland" value="IS">Iceland</option>
<option label="India" value="IN">India</option>
<option label="Indonesia" value="ID">Indonesia</option>
<option label="Iran (Islamic Republic Of)" value="IR">Iran (Islamic

    Republic Of)
</option>
<option label="Iraq" value="IQ">Iraq</option>
<option label="Ireland" value="IE">Ireland</option>
<option label="Israel" value="IL">Israel</option>
<option label="Italy" value="IT">Italy</option>
<option label="Jamaica" value="JM">Jamaica</option>
<option label="Japan" value="JP">Japan</option>
<option label="Jordan" value="JO">Jordan</option>
<option label="Kazakhstan" value="KZ">Kazakhstan</option>
<option label="Kenya" value="KE">Kenya</option>
<option label="Kiribati" value="KI">Kiribati</option>
<option label="Korea, Democratic People's Republic Of" value="KP">Korea,

    Democratic People's Republic Of
</option>
<option label="Korea, Republic Of" value="KR">Korea, Republic Of</option>
<option label="Kuwait" value="KW">Kuwait</option>
<option label="Kyrgyzstan" value="KG">Kyrgyzstan</option>
<option label="Lao People's Democratic Republic" value="LA">Lao

    People's Democratic Republic
</option>
<option label="Latvia" value="LV">Latvia</option>
<option label="Lebanon" value="LB">Lebanon</option>
<option label="Lesotho" value="LS">Lesotho</option>
<option label="Liberia" value="LR">Liberia</option>
<option label="Libyan Arab Jamahiriya" value="LY">Libyan Arab

    Jamahiriya
</option>
<option label="Liechtenstein" value="LI">Liechtenstein</option>
<option label="Lithuania" value="LT">Lithuania</option>
<option label="Luxembourg" value="LU">Luxembourg</option>
<option label="Macau" value="MO">Macau</option>
<option label="Macedonia, Former Yugoslav Republic Of" value="MK">Macedonia,

    Former Yugoslav Republic Of
</option>
<option label="Madagascar" value="MG">Madagascar</option>
<option label="Malawi" value="MW">Malawi</option>
<option label="Malaysia" value="MY">Malaysia</option>
<option label="Maldives" value="MV">Maldives</option>
<option label="Mali" value="ML">Mali</option>
<option label="Malta" value="MT">Malta</option>
<option label="Marshall Islands" value="MH">Marshall Islands</option>
<option label="Martinique" value="MQ">Martinique</option>
<option label="Mauritania" value="MR">Mauritania</option>
<option label="Mauritius" value="MU">Mauritius</option>
<option label="Mayotte" value="YT">Mayotte</option>
<option label="Mexico" value="MX">Mexico</option>
<option label="Micronesia, Federated States Of" value="FM">Micronesia,

    Federated States Of
</option>
<option label="Moldova, Republic Of" value="MD">Moldova, Republic Of</option>
<option label="Monaco" value="MC">Monaco</option>
<option label="Mongolia" value="MN">Mongolia</option>
<option label="Montserrat" value="MS">Montserrat</option>
<option label="Morocco" value="MA">Morocco</option>
<option label="Mozambique" value="MZ">Mozambique</option>
<option label="Myanmar" value="MM">Myanmar</option>
<option label="Namibia" value="NA">Namibia</option>
<option label="Nauru" value="NR">Nauru</option>
<option label="Nepal" value="NP">Nepal</option>
<option label="Netherlands" value="NL">Netherlands</option>
<option label="Netherlands Antilles" value="AN">Netherlands Antilles</option>
<option label="New Caledonia" value="NC">New Caledonia</option>
<option label="New Zealand" value="NZ">New Zealand</option>
<option label="Nicaragua" value="NI">Nicaragua</option>
<option label="Niger" value="NE">Niger</option>
<option label="Nigeria" value="NG">Nigeria</option>
<option label="Niue" value="NU">Niue</option>
<option label="Norfolk Island" value="NF">Norfolk Island</option>
<option label="Northern Mariana Islands" value="MP">Northern Mariana

    Islands
</option>
<option label="Norway" value="NO">Norway</option>
<option label="Oman" value="OM">Oman</option>
<option label="Pakistan" value="PK">Pakistan</option>
<option label="Palau" value="PW">Palau</option>
<option label="Panama" value="PA">Panama</option>
<option label="Papua New Guinea" value="PG">Papua New Guinea</option>
<option label="Paraguay" value="PY">Paraguay</option>
<option label="Peru" value="PE">Peru</option>
<option label="Philippines" value="PH">Philippines</option>
<option label="Pitcairn" value="PN">Pitcairn</option>
<option label="Poland" value="PL">Poland</option>
<option label="Portugal" value="PT">Portugal</option>
<option label="Qatar" value="QA">Qatar</option>
<option label="Reunion" value="RE">Reunion</option>
<option label="Romania" value="RO">Romania</option>
<option label="Russian Federation" value="RU">Russian Federation</option>
<option label="Rwanda" value="RW">Rwanda</option>
<option label="Saint Kitts And Nevis" value="KN">Saint Kitts And Nevis</option>
<option label="Saint Lucia" value="LC">Saint Lucia</option>
<option label="Saint Vincent And The Grenadines" value="VC">Saint

    Vincent And The Grenadines
</option>
<option label="Samoa" value="WS">Samoa</option>
<option label="San Marino" value="SM">San Marino</option>
<option label="Sao Tome And Principe" value="ST">Sao Tome And Principe</option>
<option label="Saudi Arabia" value="SA">Saudi Arabia</option>
<option label="Senegal" value="SN">Senegal</option>
<option label="Seychelles" value="SC">Seychelles</option>
<option label="Sierra Leone" value="SL">Sierra Leone</option>
<option label="Singapore" value="SG">Singapore</option>
<option label="Slovakia (Slovak Republic)" value="SK">Slovakia (Slovak

    Republic)
</option>
<option label="Slovenia" value="SI">Slovenia</option>
<option label="Solomon Islands" value="SB">Solomon Islands</option>
<option label="Somalia" value="SO">Somalia</option>
<option label="South Africa" value="ZA">South Africa</option>
<option label="South Georgia, South Sandwich Islands" value="GS">South

    Georgia, South Sandwich Islands
</option>
<option label="Spain" value="ES">Spain</option>
<option label="Sri Lanka" value="LK">Sri Lanka</option>
<option label="St. Helena" value="SH">St. Helena</option>
<option label="St. Pierre And Miquelon" value="PM">St. Pierre And

    Miquelon
</option>
<option label="Sudan" value="SD">Sudan</option>
<option label="Suriname" value="SR">Suriname</option>
<option label="Svalbard And Jan Mayen Islands" value="SJ">Svalbard And

    Jan Mayen Islands
</option>
<option label="Swaziland" value="SZ">Swaziland</option>
<option label="Sweden" value="SE">Sweden</option>
<option label="Switzerland" value="CH">Switzerland</option>
<option label="Syrian Arab Republic" value="SY">Syrian Arab Republic</option>
<option label="Taiwan" value="TW">Taiwan</option>
<option label="Tajikistan" value="TJ">Tajikistan</option>
<option label="Tanzania, United Republic Of" value="TZ">Tanzania,

    United Republic Of
</option>
<option label="Thailand" value="TH">Thailand</option>
<option label="Togo" value="TG">Togo</option>
<option label="Tokelau" value="TK">Tokelau</option>
<option label="Tonga" value="TO">Tonga</option>
<option label="Trinidad And Tobago" value="TT">Trinidad And Tobago</option>
<option label="Tunisia" value="TN">Tunisia</option>
<option label="Turkey" value="TR">Turkey</option>
<option label="Turkmenistan" value="TM">Turkmenistan</option>
<option label="Turks And Caicos Islands" value="TC">Turks And Caicos

    Islands
</option>
<option label="Tuvalu" value="TV">Tuvalu</option>
<option label="Uganda" value="UG">Uganda</option>
<option label="Ukraine" value="UA">Ukraine</option>
<option label="United Arab Emirates" value="AE">United Arab Emirates</option>
<option label="United Kingdom" value="GB">United Kingdom</option>
<option label="United States Minor Outlying Islands" value="UM">United

    States Minor Outlying Islands
</option>
<option label="Uruguay" value="UY">Uruguay</option>
<option label="Uzbekistan" value="UZ">Uzbekistan</option>
<option label="Vanuatu" value="VU">Vanuatu</option>
<option label="Venezuela" value="VE">Venezuela</option>
<option label="Viet Nam" value="VN">Viet Nam</option>
<option label="Virgin Islands (British)" value="VG">Virgin Islands

    (British)
</option>
<option label="Virgin Islands (U.S.)" value="VI">Virgin Islands (U.S.)</option>
<option label="Wallis And Futuna Islands" value="WF">Wallis And Futuna

    Islands
</option>
<option label="Western Sahara" value="EH">Western Sahara</option>
<option label="Yemen" value="YE">Yemen</option>
<option label="Yugoslavia" value="YU">Yugoslavia</option>
<option label="Zambia" value="ZM">Zambia</option>
<option label="Zimbabwe" value="ZW">Zimbabwe</option>
</select>
<dt>State</dt>
<dd>
    <select name="state[]" id="state" class="fill w50 required"

            multiple>
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
</dd>

<dt>Region</dt>
<dd>
    <select name="region">
        <option value=""></option>
    <?php

    $sql_reg = "SELECT name_region FROM amember_region WHERE name_region != '' GROUP BY name_region";

    $g = mysql_query($sql_reg);

    while ($mes = mysql_fetch_array($g)) {

        print " <option value=\"" . $mes['name_region'] . "\">" . $mes['name_region'] . "</option>";

    }

    ?>
    </select>
</dd>

<dt></dt>
<dd><strong>Contact:</strong></dd>


<dt>First Name, Second Name</dt>
<dd>
    <input name="name_f" type="text">
    <input name="name_l" type="text">
</dd>

<dt></dt>
<dt>Company</dt>
<dd>
    <!--        <select name="company">-->
    <!--          <option value=""></option>-->
<?php
//
//		while ($res = mysql_fetch_array($s)){
//
//			print " <option  value=\"".$res['organization']."\">".$res['organization']."</option>";
//
//		}
//
//		?>
    <!--        </select>-->
    <input type="text" size="40" name="company"/>
</dd>

<dd>
    <input value="View" type="submit">
    <input value="Clear" type="reset">
</dd>
</dl>
</form>
</div>
<?php

if ($result && $num >= 1) {
    ?>
<div id="content">
    <div id="list">
      <div style="float:left;width:735px;">
        <div class="listings expanded">
            <h2>Search Results
            <?=$arrCat['name']?>
            </h2>
        <?php
                            $arr = array();
        while ($row = mysql_fetch_array($result)) {

            $arr = json_decode($row['contacts']);

            //check sta
            $sql_comp = "SELECT SUBSTR(GROUP_CONCAT(p.product_id order by p.product_id) from 1) as p_product_id
 FROM amember_members m
  LEFT JOIN amember_payments p

ON p.member_id=m.member_id

where 1 AND m.member_id=" . $row['member_id'] . " group by m.member_id";

            $p_product_id_r = mysql_query($sql_comp);

            $p_product_id_row = mysql_fetch_array($p_product_id_r);

            $sta_product = array("43", "44", "45", "46");

            $product_id = $p_product_id_row['p_product_id'];

            $products = explode(",", $product_id);

            $is_sta = false;
            foreach ($sta_product as $sp) {

                if (in_array($sp, $products)) {
                    $is_sta = true;
                    break;
                }
            }

            $sta_image = "";
            if ($is_sta) {
                $sta_imag = "<img src='/admin/wp-content/themes/composting/images/yellow-dot.png'/>";
            }

            //check sta END

            $sql_id = "SELECT `id` FROM `" . $wpdb->prefix . "users" . "` WHERE `uscc` = '" . $row['uscc'] . "'";

            $id = $wpdb->get_row($sql_id, ARRAY_A);
            ///////////////////////////////category///////////////////////////
            $category_html = '';
            $category = $row['category'];
            $product_category = $row['product_category'];

            $sqlC = "select * from compos_amember.amember_categories where id='$category' ";
//    echo $sqlC;
            $resC = mysql_query($sqlC);
            $categoryarr = mysql_fetch_array($resC);

            $category_html = $categoryarr['name'];


            /////////////////////sub category///////////
            $sub_category_html = '';
            $sqlPCat = "select * from compos_amember.amember_product_categories ";
            $resC = mysql_query($sqlPCat);

            while ($categoryarr = mysql_fetch_array($resC)) {
                $product_cats[$categoryarr['code']] = $categoryarr['title'];
            }

            if (!empty($product_category)) {
                $sub_cat = json_decode($product_category);
                $exits_sub_cat = '';
                if (count($sub_cat) > 0) {
                    foreach ($sub_cat as $i) {
                        $k = $i;
                        $v = $product_cats[$i];

                        $exits_sub_cat .= $v . "<br/>";

                    }
                    $sub_category_html = "<div style='margin-left:20px;'>$exits_sub_cat</div>";
                }
            }

            //get contacts
            $data = $row['contacts'];
            $contacts = json_decode($data);
//            echo "<pre>";
//            print_r($contacts);
//            echo "</pre>";

            $contacts_html = "";
            for ($i = 1; $i < count($contacts); $i++) {

                $name = $contacts[$i]->name_first . " " . $contacts[$i]->name_last;
                $country = $contacts[$i]->country;
                $city = $contacts[$i]->city;


                $state = $contacts[$i]->state;
                $phone = $contacts[$i]->phone;

                $contact_temp = trim("$name $city $state $country $phone");
                if (empty($contact_temp))continue;

                $contacts_html .= " <br/><br/>Contact $i:<br/> $contact_temp";
            }

            ?>
                <div style="width:230px; float:left">
                <?php if (!empty($row['logo'])) { ?>
                    <img id="upload_img" src="/amember/upload/<?=$row['logo']?>" alt="" width="200"
                         style="padding:5px; border:1px solid  #E3E3DD"/>
                <?php } ?>
                </div>
                <div style="width:300px; margin-right:12px; float:left">
                   <?=$sta_imag?> <h1 style="font-size:16px;"><? echo $row['organization']?></h1>

                    <div style="margin-top:-10px;"><em>
                    <?=$category_html?>
                    </em></div>

                    <span style="font-size:11px;">  <?=$sub_category_html?></span>
                    <br/>

<span style="font-size:11px;">
            <div>
            <?=$row['street']?>
            </div>
            <div>
            <?=$row['city']?>
            <?=$row['state']?>
            <?=$row['zip']?>
            <?=$row['country']?>
            </div>
            <div>
            <?=$row['phone']?>
            <?=$row['phone_ex']?>
            </div>
          <div>Website:<br/>
              <a href="<?=getWebsiteWithHttp($row['website'])?>">
              <?=getWebsiteWithHttp($row['website'])?>
              </a>

              <div>Description:<br/>

              <?=$row['description']?>
              </div>
          </div>
</span>
                </div>
                <div style="font-size:11px; width:140px; float:left;">
                    <h3 style="font-size:12px;">Contact Person</h3>
                <? echo $row['name_f'] . " " . $row['name_l']?>
                    <div><a href="mailto:<?=$row['email']?>">
                    <?=$row['email']?>
                    </a></div>


                    <div>
                    <?=$contacts_html;?>
                    </div>

                </div>
                <br style="clear:both;"/>
                <div style="height:10px;"></div>
                <hr/>


            <? }    ?>

        </div>




    <?

/* 		while($sss = mysql_fetch_array($result)) {

            $sql_id = "SELECT `id` FROM `".$wpdb->prefix."users"."` WHERE `uscc` = '".$sss['uscc']."'";



            $id = $wpdb->get_row($sql_id, ARRAY_A);

            print "<tr><td>".$sss['organization']."</td><td>".$sss['name_f']." ".$sss['name_l']."</td><td><a href =\" ../admin/storefront.php?uid=".$id['id']."\">".$sss['name_f']."</a></td></tr>";

        } */

    ?>

    <?
} elseif (isset($_POST['category'])) {

    print "Search doesn't have results";

} ?>
</div>
<script type="text/javascript">


    jQuery(function($) {

        $("select[name=category]").change(CategorySelected);

        CategorySelected();


        $('#show_search').click(function() {

            $('#form_search').fadeIn();

        });

    });


    function CategorySelected() {

        var category = jQuery("#category option:selected").text();

        if (category == "Equipment Manufacturer / Product Supplier") {

            jQuery("#product_categories").show();

        } else {

            jQuery("#product_categories").hide();

        }

    }


</script>
<div style="clear:both"></div>
<p style="float:right"><a href="#content"> Back to Top</a></p>
</div>
</div></div>


   
   
   