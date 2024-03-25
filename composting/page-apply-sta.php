<?php



get_header();

$cone = mysql_connect('localhost', 'compos_amember', 'fjY45ou35t_glkj');

if (!$cone) {

    die('not');
}
mysql_select_db('compos_amember', $cone) or die(mysql_error());


$sqlC = "select * from compos_amember.amember_categories Where id!= 11 order by name asc";
$resC = mysql_query($sqlC, $cone) or die(mysql_error() . $sqlC);

$sqlCountry = "select * from compos_amember.amember_countries";
$resCountry0 = $resCountry1 = $resCountry = mysql_query($sqlCountry, $cone) or die(mysql_error() . $sqlCountry);

$sqlPCat = "select * from compos_amember.amember_product_categories  order by title asc";
$resPCat = mysql_query($sqlPCat, $cone) or die(mysql_error() . $sqlPCat);

$sqlMemberLevel = "SELECT * FROM  amember_products where product_id in (43,44,45,46) order by price desc";
$resMemberLevel = mysql_query($sqlMemberLevel, $cone) or die(mysql_error() . $sqlPCat);

?>
<link rel="stylesheet" type="text/css" href="<? bloginfo('wpurl') ?>/wp-content/themes/composting/screen.css">
<link rel="stylesheet" type="text/css" href="<? bloginfo('wpurl') ?>/wp-content/themes/composting/fileuploader.css">
<script type="text/javascript" src="<? bloginfo('wpurl') ?>/wp-content/themes/composting/js/sifr.js"></script>
<script type="text/javascript" src="<? bloginfo('wpurl') ?>/wp-content/themes/composting/js/fontsizer.js"></script>
<script type="text/javascript"
        src="<? bloginfo('wpurl') ?>/wp-content/themes/composting/js/jquery.hoverintent.js"></script>
<script type="text/javascript" src="<? bloginfo('wpurl') ?>/wp-content/themes/composting/js/common.js"></script>
<script type="text/javascript" src="<? bloginfo('wpurl') ?>/wp-content/themes/composting/js/shared.js"></script>
<script type="text/javascript" src="<? bloginfo('wpurl') ?>/wp-content/themes/composting/js/fileuploader.js"></script>
<script type="text/javascript" src="<? bloginfo('wpurl') ?>/wp-content/themes/composting/js/apply-sta.js"></script>

<div id="container">
<h1 class="entry-title">
    STA Membership Application
</h1>


<div id="content" style="width:100%">
<div id="member-box-wrapper" style="margin-left:20px;">
<div id="member-box">
<table id="main" cellspacing="0" cellpadding="0" border="0">
<tbody width="100%" >
<tr>
<td>
<div class="with-subnav with-sidebar">

<strong>Complete the form below to apply and pay for an STA Membership.</strong><br/>

<p><em>Fields marked with an asterisk <span class="required">*</span> are required. </em></p>


<form id="membership" method="post" action="../amember/signup_sta.php">

<h2>Do You Have An Existing Membership?</h2>
<!-- Instructions      We need a little submit form here, not sure to do in the form or above like, change around so that it works best... So if they enter a valid uscc membership the whole form will be populated with the existing info from the uscc membership, but extra contacts not needed.   -->

<div style="height:100px;">
    <dt>
        <label style="padding-left:0px;">Please enter your existing USCC Membership number, or leave blank and continue
            if you do not have an existing USCC membership</label>
    </dt>
    <dd>
<!--        <input type="text" name="usccnumber" id="usccnumber" value="110002" class="fill w50"/>-->
        <input type="text" name="usccnumber" id="usccnumber" value="" class="fill w50"/>
    </dd>
</div>
<input type="button" id="enter_uscc" value="Enter Membership">

<br/>


<h2>Company / Organization</h2>
<dl>


    <dt><span class="required">*</span>
        <label for="organization">Member Company/Organization</label>
    </dt>
    <dd>
        <input type="text" name="organization" id="organization" value="" class="fill required"/>
    </dd>
    <dt><span class="required">*</span>
        <label for="street">Street Address: </label>
    </dt>
    <dd>
        <input type="text" name="street" id="street" value="" class="fill required"/>
    </dd>
    <dt>
        <label for="pobox">PO Box or RR</label>
    </dt>
    <dd>
        <input type="text" name="pobox" id="pobox" value="" class="fill w50"/>
    </dd>
    <dt><span class="required">*</span>
        <label for="city">City</label>
    </dt>
    <dd>
        <input type="text" name="city" id="city" value="" class="fill required w50"/>
    </dd>
    <dt><span class="required">*</span>
        <label for="state">State/Province</label>
    </dt>
    <dd>
        <select name="state" id="state" class="fill w50 required">
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
            <optgroup label="Canada">
                <option label="Alberta" value="AB">Alberta</option>
                <option label="British Columbia" value="BC">British Columbia</option>
                <option label="Manitoba" value="MB">Manitoba</option>
                <option label="New Brunswick" value="NB">New Brunswick</option>
                <option label="Newfoundland and Labrador" value="NL">Newfoundland and Labrador</option>
                <option label="Northwest Territories" value="NT">Northwest Territories</option>
                <option label="Nova Scotia" value="NS">Nova Scotia</option>
                <option label="Nunavut" value="NU">Nunavut</option>
                <option label="Ontario" value="ON">Ontario</option>
                <option label="Prince Edward Island" value="PE">Prince Edward Island</option>
                <option label="Quebec" value="QC">Quebec</option>
                <option label="Saskatchewan" value="SK">Saskatchewan</option>
                <option label="Yukon" value="YT">Yukon</option>
            </optgroup>
            <option label="Other / N/A" value="NA">Other / N/A</option>
        </select>
    </dd>
    <dt><span class="required">*</span>
        <label for="zip">Zip/Postal Code</label>
    </dt>
    <dd>
        <input type="text" name="zipcode" id="zipcode" value="" class="fill required w25"/>
    </dd>
    <dt><span class="required">*</span>
        <label for="country">Country</label>
    </dt>
    <dd>
        <select name="country" id="country" class="fill w50 required">
            <?php


            $countries = '';
            while ($countryarr = mysql_fetch_array($resCountry)) {

                $countries .= "  <option label='{$countryarr['title']}'
                    value='{$countryarr['country']}'>{$countryarr['title']}</option>   ";

            }
            echo $countries;
            ?>
        </select>
    </dd>

    <dt><span class="required">*</span>
        <label for="phone">Phone</label>
    </dt>
    <dd>
        <input type="text" name="phone" id="phone" value="" class="fill required w50 phone"/>
        <label for="phone_ext">Ext.</label>
        <input type="text" name="phone_ex" id="phone_ex" maxlength="5" value="" class="fill w12h phone_ex"/>
    </dd>
    <dt>
        <label for="fax">Fax</label>
    </dt>
    <dd>
        <input type="text" name="fax" id="fax" value="" class="fill w50 fax"/>
    </dd>


    <dt>
        <label for="website">Website</label>
    </dt>
    <dd>
        <input type="text" name="website" id="website" value="http://" class="fill"/>
    </dd>

</dl>

<h2 style="margin-top:7px;">STA Membership Level</h2>
<table class="enhancedtable" cellpadding="4" cellspacing="0" width="100%">


    <!-- Instructions      We need this to populate this area with the 4 sta memberships, show only 43 and 44 membership as default, if they put in a valid uscc membership then show only 45 46   -->




    <?php
    $index = 1;
    while ($memberLevelArr = mysql_fetch_array($resMemberLevel)) {
        $check = '';
        if ($index == 1) {
            $check = 'checked="checked"';
        }

        $class = "";
        if ($index % 2 != 0) {
            $class = "even ";
        } else {
            $class = "member_sta ";
        }
        $index++;
        ?>


        <tr class="<?=$class?>">
            <td><input type="radio" name="product_id" value="<?=$memberLevelArr['product_id']?>" <?=$check?>/>
            </td>
            <th align="left"><?=$memberLevelArr['title']?></th>
            <td><?=$memberLevelArr['price']?> &nbsp;</td>
            <td>&nbsp;<?=$memberLevelArr['description']?>        <input type="hidden"
                                                                        name="product_price_<?=$memberLevelArr['product_id']?>"
                                                                        value="<?=$memberLevelArr['price']?>"/>
            </td>
        </tr>

        <?php } ?>

</table>

<div>
    <h2 style="margin-top:20px;">Category</h2>

    <dt><span class="required">*</span>
        <label for="category">Category<br/>
            <span id="small">Please indicate ONLY one</span><br/>
        </label>
    </dt>

    <dd>
        <select name="category" id="category" class="fill required">
            <?php while ($categoryarr = mysql_fetch_array($resC)) {

            ?>

            <option label="<?=$categoryarr['name']?>" value="<?=$categoryarr['id']?>"><?=$categoryarr['name']?></option>

            <?php } ?>

            <option label="Other" value="11">Other</option>

        </select>
    </dd>


    <div id="product_categories" style="margin-left:120px;">
        <dt>
            <label for="category"></label>
        </dt>
        <dd>
            <div id="small">If you checked Equipment Manufacturer / Product Supplier, please add ALL that apply</div>
            <table id="workshops">
                <tr class="add">
                    <td>
                        <select name="product_category" id="product_category" class="fill w75">
                            <option value="">-- Please Select --</option>

                            <?php while ($prodcategory = mysql_fetch_array($resPCat)) { ?>

                            <option label="<?=$prodcategory['title']?>"
                                    value="<?=$prodcategory['code']?>"><?=$prodcategory['title']?></option>

                            <?php } ?>
                        </select>
                    </td>
                    <td align="right"><img src="wp-content/themes/composting/images/add.png" width="16" height="16"
                                           alt="Add" title="Add" class="button" onclick="addMemberProduct();"/></td>
                </tr>
            </table>

        </dd>

        <br/>
        <br/>

    </div>
</div>
<div id="clear"></div>


<h2 style="margin-top:10px;">Description</h2>
<dt>
<div id="small">Please describe your company or your organization (not to exceed 75 words)</div>
<label for="description"></label>
</dt>
<dd>

    <textarea name="description" id="description" cols="50" rows="5" class="fill"
              onkeypress="return imposeMaxLength(event,this, 250);"></textarea>
</dd>

<h2 style="margin-top:10px;">Upload Your Logo</h2>

<input type="hidden" name="logo_path" value=""/>

<div id="logo_uploader">
    <noscript>
        <p>Please enable JavaScript to use file uploader.</p>
        <!-- or put a simple form for upload here -->
    </noscript>
</div>

<!--contact_0-->
<div class="contact" style="margin-top:10px;">
<h2>Primary Contact information</h2>
<dl>
<dt style="width:60px;"><span class="required">*</span>
    <label for="">Name</label>
</dt>
<dd>
    <table cellpadding="0" cellspacing="0" class="name">
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" class="name">
                    <tr>
                        <th>Prefix</th>
                        <th><span class="required">*</span>First</th>
                        <th>Middle</th>
                        <th><span class="required">*</span>Last</th>
                        <th>Suffix</th>
                    </tr>
                    <tr>
                        <td style="padding-right:0px"><input type="text" name="name_prefix_0" id="name_prefix0"
                                                             value="" class="fill w12h name_prefix"/></td>
                        <td><input type="text" name="name_f_0" id="name_first2" value=""
                                   class="fill w25 required name_f"/></td>
                        <td><input type="text" name="name_middle_0" id="name_middle2" value=""
                                   class="fill w12h name_middle"/></td>
                        <td><input type="text" name="name_l_0" id="name_last2" value=""
                                   class="fill w25 required name_l"/></td>
                        <td><input type="text" name="name_suffix_0" id="name_suffix2" value=""
                                   class="fill w12h name_suffix"/></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</dd>
<dt>
    <label for="title">Title</label>
</dt>
<dd>
    <input type="text" name="title_0" id="title_0" value="" class=" title"/>
</dd>
<dt>
    <label for="phone">Phone</label>
</dt>
<dd>
    <input type="text" name="c_phone" id="c_phone" value="" class="     "/>
    <label for="c_phone_ext">Ext.</label>
    <input type="text" name="phone_ex_0" id="c_phone_ext" maxlength="5" value="" class="    "/>
</dd>
<dt>
    <label for="fax">Fax</label>
</dt>
<dd>
    <input type="text" name="c_fax" id="c_fax" value="" class=" w50 fax"/>
</dd>
<dt>
    <label for="email_0"><span class="required">*</span>E-mail</label>
</dt>
<dd>
    <input type="text" name="email_0" id="email_0" value="" class="  fill  required  email "/>
</dd>

<dt>
    <label for="street">Street Address: </label>
</dt>
<dd>
    <input type="text" name="c_street" id="c_street" value="" class=" "/>
</dd>

<dt>
    <label for="city">City</label>
</dt>
<dd>
    <input type="text" name="c_city" id="c_city" value="" class="  w50"/>
</dd>
<dt>
    <label for="state">State/Province</label>
</dt>
<dd>
    <select name="c_state" id="c_state" class=" w50 ">
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
        <optgroup label="Canada">
            <option label="Alberta" value="AB">Alberta</option>
            <option label="British Columbia" value="BC">British Columbia</option>
            <option label="Manitoba" value="MB">Manitoba</option>
            <option label="New Brunswick" value="NB">New Brunswick</option>
            <option label="Newfoundland and Labrador" value="NL">Newfoundland and Labrador</option>
            <option label="Northwest Territories" value="NT">Northwest Territories</option>
            <option label="Nova Scotia" value="NS">Nova Scotia</option>
            <option label="Nunavut" value="NU">Nunavut</option>
            <option label="Ontario" value="ON">Ontario</option>
            <option label="Prince Edward Island" value="PE">Prince Edward Island</option>
            <option label="Quebec" value="QC">Quebec</option>
            <option label="Saskatchewan" value="SK">Saskatchewan</option>
            <option label="Yukon" value="YT">Yukon</option>
        </optgroup>
        <option label="Other / N/A" value="NA">Other / N/A</option>
    </select>
</dd>
<dt>
    <label for="zipcode">Zip/Postal Code</label>
</dt>
<dd>
    <input type="text" name="c_zipcode" id="c_zipcode" value="" class="  w25"/>
</dd>
<dt>
    <label for="country">Country</label>
</dt>
<dd>
    <select name="c_country" id="c_country" class=" w50 ">
        <?php  echo $countries; ?>
    </select>
</dd>


<!-- Instructions  I removed this extra contact area and focused contributions, I dont think they want extra contacts for sta members, and probably not focused contributions  -->


<h2>Total</h2>
<input type="hidden" name="sta_signup" value="1"/>
<input type="hidden" name="total" value="0"/>

<p id="total-display" style="font-size:20px;">$0</p>

<br/>


<input type="button" id="subm_button" value="Proceed to Payment">


<br/>
<br/>

<p style="font-size:11px; color: #333;">
    Membership Dues payments may be deductible by members as an ordinary and necessary business expense to the extent
    permitted by law. <br/>

    <br/>
    The Composting Council Research and Education Foundation is an affiliated, but separate 501(c)(3) organization. When
    you make your payment to the United States Composting Council, we allocate the indicated amount to the Composting
    Council Research and Education Foundation. That allocated amount is deductible as a charitable contribution to the
    extent permitted by law. Any portion of your Membership Dues allocated to the United States Composting Council are
    not deductible as charitable contributions for federal income tax purposes but may be deductible by members as an
    ordinary and necessary business expense to the extent permitted by law. The USCC estimates that 10% of your
    membership dues are allocable to lobbying activities of the USCC, and therefore are not deductible for income tax
    purposes as ordinary and necessary business expenses.
</p>

<input type="hidden" id="ccontact" name="ccontact" value="1">


</form>
</div>

</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>


<script type="text/javascript">
    jQuery(function () {
        //Enable submit button, disabled for users with JavaScript disabled
        jQuery(".member_sta").hide();

        jQuery("#btnSubmit").attr("disabled", false);

        jQuery("input:password").val("");

        jQuery(":input[type=radio]").click(function () {
            recalcTotal(this);
        });

        recalcTotal();

        jQuery("input[name=included_in_dir]").click(function () {
            recalcTotal(this);
        });

        jQuery("input[name=focused_contributions]").click(function () {
            recalcTotal(this);
        });

        jQuery(".focused_contributions").keyup(function () {

            recalcTotal(this);
        });

        jQuery("select[name=category]").change(CategorySelected);
        CategorySelected();

        createUploader();
    });


</script>

</div>

<?php get_footer(); ?>
