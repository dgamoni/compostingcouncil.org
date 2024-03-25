jQuery(document).ready(function ($) {
    $('#enter_uscc').click(function () {
        if ($('#usccnumber').val() != '') {
            $.get("/amember/apply-sta-get-uscc.php", {'uscc':$('#usccnumber').val()}, function (data) {
                if (!data) {
                    $(".member_sta").show();

                    return;
                }

                $(".member_sta").show();

                $('#organization').val(data['organization']);
                $('#email').val(data['email']);
                $('#name_f').val(data['name_f']);
                $('#name_l').val(data['name_l']);
                $('#street').val(data['street']);
                $('#state').val(data['state']);
                $('#city').val(data['city']);
                $('#pobox').val(data['pobox']);
                $('#zipcode').val(data['zip']);
                $('#country').val(data['country']);
                $('#phone').val(data['phone']);
                $('#fax').val(data['fax']);
                $('#phone_ex').val(data['phone_ex']);
                $('#website').val(data['website']);

                var category = data['category'];
                $('#category').val(category);

                if (category == 3) {
                    var product_category = data['product_category'];
                    if (product_category != '') {
                        jQuery("#product_categories").show();

                        var product_category_arr = $.parseJSON(product_category);
                        for (var i = 0; i < product_category_arr.length; i++) {
//                            alert(product_category_arr[i]);
                            var pc = product_category_arr[i];
                            var desc = getSubcategoryDescripttion($, pc);

                            var temp = '<tr valign="top"><td>' + desc
                                + '<input type="hidden" name="member_products[]" value="' + pc + '" /></td>' +
                                '<td width="24" align="right">' +
                                '<img src="/admin/wp-content/themes/composting/images/delete.png" width="16" height="16" alt="Delete" title="Delete" ' +
                                'class="button" onclick="jQuery(this).parent().parent(\'tr\').remove();" />' +
                                '</td></tr> ';

//                            alert(temp);
                            $('.add').before(temp);
                        }
                    }
                }//////////////

                $("#description").val(data['description']);

                var logo = data['logo'];

                deleteLogoStaApply();

                var temp = '<img id="upload_img" src="/amember/upload/' + logo + '" alt="" width="200" />';


                temp += '<span id="xlogo" onclick="deleteLogoStaApply();" style="cursor:pointer">X</span>' +
                    '<input type=hidden name=logo value="{$u.logo|escape}" size=8 maxlength=8>';

                $('.qq-upload-button').hide();
                $('#logo_uploader').after(temp);

                //primary contact
                var contacts = data['contacts'];
                var contacts_arr = $.parseJSON(contacts);
//                alert(contacts_arr);
                var primary = contacts_arr[0];

                var name_prefix = primary['name_prefix'];
                var name_first = primary['name_first'];
                var name_middle = primary['name_middle'];
                var name_l = primary['name_last'];
                var name_s = primary['name_suffix'];
                var c_title = primary['title'];
                var c_phone = primary['phone'];
                var c_phone_ex = primary['phone_ex'];
                var c_fax = primary['fax'];
                var c_email = primary['email'];
                var c_street = primary['street'];
                var c_city = primary['city'];
                var c_state = primary['state'];
                var c_country = primary['country'];
                var c_zip = primary['zip'];

                $('#name_prefix0').val(name_prefix);
                $('#name_first2').val(name_first);
                $('#name_middle2').val(name_middle);
                $('#name_last2').val(name_l);
                $('#name_suffix2').val(name_s);

                $('#title_0').val(c_title);
                $('#c_phone').val(c_phone);
                $('#c_phone_ext').val(c_phone_ex);
                $('#c_fax').val(c_fax);
                $('#email_0').val(c_email);

                $('#c_street').val(c_street);
                $('#c_city').val(c_city);
                $('#c_state').val(c_state);
                $('#c_zipcode').val(c_zip);
                $('#c_country').val(c_country);

//                alert(name_first);


            }, 'json');
        }
    });
});

function getSubcategoryDescripttion($, key) {

    var desc = "";
    $('#product_category option').each(function (v) {
//        alert($(this).html());
//        alert($(this).val());
        if ($(this).val() == key) {
            desc = ($(this).html());
            return false;
        }

    });
    return desc;
}

function deleteLogoStaApply() {

    jQuery('.qq-upload-list').html('');
    jQuery('.qq-upload-button').show();
    jQuery('input[name=logo]').val('');
    jQuery('#upload_img').attr("src", "").hide();
    jQuery('#xlogo').remove();


}