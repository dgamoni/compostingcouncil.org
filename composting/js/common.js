//var ccontact = 2;





jQuery(function ($) {

    // IE < 7

    if (jQuery.browser.msie && jQuery.browser.version < 7) {

        jQuery("span.required + label").addClass("required");

    }


    // Alternate row colours

    jQuery("table.enhancedtable tr:even").addClass("even");


    // Menu hover

    jQuery("#navigation li.section").hoverIntent(

        {

            timeout:500,

            over:function () {

                jQuery(this).addClass("reduced");

                jQuery("ul", this).slideDown();

            },

            out:function () {

                jQuery(this).removeClass("reduced");

                jQuery("ul", this).slideUp();

            }

        }

    );


    // Hide elements

    jQuery(".jshide").hide();


    //Enable submit button, disabled for users with JavaScript disabled

    jQuery("#btnSubmit").attr("disabled", false);


    jQuery("input:password").val("");

    jQuery(":input[type=radio]").click(function () {

        recalcTotal(this);

    });

    recalcTotal();


    jQuery("select[name=category]").change(CategorySelected);

    CategorySelected();


    $('#subm_button').click(function () {

        var error = false;

        var error_message = '';


        if (!$('#organization').val()) {

            error_message += 'Organization name is required field.\n';

            error = true;

        }


        if (!$('#street').val()) {

            error_message += 'Street is required field.\n';

            error = true;

        }


        if (!$('#city').val()) {

            error_message += 'City is required field.\n';

            error = true;

        }


        if (!$('#state').val()) {

            error_message += 'State is required field.\n';

            error = true;

        }


        if (!$('#zipcode').val()) {

            error_message += 'Zipcode is required field.\n';

            error = true;

        }


        $('.name_f').each(function (i, el) {

            if (!$(this).val()) {

                error_message += 'First name is required field.\n';

                error = true;

                return;

            }

        });


        $('.name_l').each(function (i, el) {

            if (!$(this).val()) {

                error_message += 'Last name is required field.\n';

                error = true;

                return;

            }

        });


        $('.phone').each(function (i, el) {

            if (!$(this).val()) {

                error_message += 'Phone is required field.\n';

                error = true;

                return;

            }

        });


        $('.email').each(function (i, el) {

            if (!$(this).val()) {

                error_message += 'Email is required field.\n';

                error = true;

                return;

            }

        });


        if (!error) {

//			$('#ccontact').val(ccontact);

            $('#membership').submit();

        } else {

            alert(error_message);

        }

    });


});


//function recalcTotal(ele) {

//    var level           = jQuery(":input[name=product_id][checked]").val();

//    var level_prices    = {

//		15: 10000,

//		14: 5000,

//		13: 2500,

//		12: 1000,

//		11: 500,

//		10: 500,

//		9: 250,

//		8: 250,

//		7: 250,

//		6: 250,

//		5: 100,

//		4: 50

//	};

//    var level_cost      = level_prices[level];

//

//    if (ele && ele.name == "level") {

//        jQuery("input[name=storefront]").removeAttr('checked');

//        if (level_cost > 9999) {

//            jQuery("input[name=storefront][value=3]").attr('checked', 'checked');

//        } else if (level_cost > 999) {

//            jQuery("input[name=storefront][value=2]").attr('checked', 'checked');

//        } else if (level_cost > 499) {

//            jQuery("input[name=storefront][value=1]").attr('checked', 'checked');

//        } else {

//            jQuery("input[name=storefront][value=0]").attr('checked', 'checked');

//        }

//    }

//    if (level_cost > 9999) {

//        var storefront_prices = [0, 0, 0, 0];

//    } else if (level_cost > 999) {

//        var storefront_prices = [0, 0, 0, 250];

//    } else if (level_cost > 499) {

//        var storefront_prices = [0, 0, 250, 500];

//    } else {

//        var storefront_prices = [0, 250, 500, 750];

//    }

//

//    var storefront      = jQuery(":input[name=storefront][checked]").val();

//    var storefront_cost = storefront_prices[storefront];

//

//    var total = level_cost + storefront_cost;

//    jQuery("#total-display").html("$" + total);

//}

//

//function CategorySelected()

//{

//	var category = jQuery("#category option:selected").text();

//	if(category == "Equipment Manufacturer / Product Supplier")

//	{

//		jQuery("#product_categories").show();

//	} else {

//		jQuery("#product_categories").hide();

//	}

//}


function recalcTotal(ele) {

    var level = jQuery(":input[name=product_id][checked]").val();


//        var level_prices = [10000, 5000, 2500, 1000, 500, 500, 250, 250, 250, 250, 200,100, 25,25];

//        alert('input[name=product_price_'+level+"]");

    var level_cost = jQuery('input[name=product_price_' + level + "]").val();


    if (ele && ele.name == "product_id") {

        if (level_cost >= 2500) {

            jQuery("input[name=included_in_dir]").attr('checked', 'true');

            jQuery("input[name=storefront_input]").val('0');

            jQuery("input[name=storefront_input_hidden]").val('0');

        } else {

            jQuery("input[name=included_in_dir]").removeAttr('checked');

            jQuery("input[name=storefront_input]").val('0');

            jQuery("input[name=storefront_input_hidden]").val('0');

        }


        //        if (level_cost > 9999) {

        //            jQuery("input[name=storefront][value=3]").attr('checked', 'checked');

        //        } else if (level_cost > 999) {

        //            jQuery("input[name=storefront][value=2]").attr('checked', 'checked');

        //        } else if (level_cost > 499) {

        //            jQuery("input[name=storefront][value=1]").attr('checked', 'checked');

        //        } else {

        //           jQuery("input[name=storefront][value=0]").attr('checked', 'checked');

        //        }

    }


    if (ele && ele.name == "included_in_dir") {

        if (jQuery(ele).attr('checked') == true && level_cost < 2500) {

//                alert('sss');

            jQuery("input[name=storefront_input]").val('200');

            jQuery("input[name=storefront_input_hidden]").val('200');

        } else {

            jQuery("input[name=storefront_input]").val('0');

            jQuery("input[name=storefront_input_hidden]").val('0');

        }

    }


    if (ele && ele.name == "focused_contributions") {

        if (jQuery(ele).attr('checked') == true) {

        } else {

            index = jQuery(ele).val();

            jQuery("input[name=focused_contributions_" + index + "]").val('0');


        }

    }


    //    if (level_cost > 9999) {

    //        var storefront_prices = [0, 0, 0, 0];

    //    } else if (level_cost > 999) {

    //        var storefront_prices = [0, 0, 0, 250];

    //    } else if (level_cost > 499) {

    //        var storefront_prices = [0, 0, 250, 500];

    //    } else {

    //        var storefront_prices = [0, 250, 500, 750];

    //    }

    //

    //    var storefront      = jQuery(":input[name=storefront][checked]").val();


    var storefront_cost = jQuery("input[name=storefront_input]").val();


    focused_contributions_cost = 0;

    jQuery("input[name=focused_contributions]").each(function (k, v) {


        if (jQuery(v).attr('checked') == true) {

            index = jQuery(v).val();

            temp_cost = jQuery("input[name=focused_contributions_" + index + "]").val();

            if (temp_cost != '') {

                focused_contributions_cost += parseInt(temp_cost);

            }

        }


    });

    if (storefront_cost == undefined)storefront_cost = 0;
    if (focused_contributions_cost == undefined)storefront_cost = 0;


    var total = parseInt(level_cost) + parseInt(storefront_cost) + focused_contributions_cost;


    jQuery("#total-display").html("$" + total);


    jQuery("input[name=total]").val(total);


}


function CategorySelected() {

    var category = jQuery("#category option:selected").text();

    if (category == "Equipment Manufacturer / Product Supplier") {

        jQuery("#product_categories").show();

    } else {

        jQuery("#product_categories").hide();

    }

}


function createUploader() {

    var uploader = new qq.FileUploader({

        element:document.getElementById('logo_uploader'),

        action:'/admin/logo_upload.php',

        allowedExtensions:['jpg', 'jpeg', 'png', 'gif'],

        onSubmit:function (id, fileName) {

            jQuery('.qq-upload-button').hide();

            jQuery('input[name=logo_path]').val('');

        },

        onCancel:function (id, fileName) {

            jQuery('.qq-upload-button').show();


        },


        onComplete:function (id, fileName, responseJSON) {

//                alert(fileName);

            fileName = responseJSON.filename;

            jQuery('.deletelogo').show();


            jQuery('input[name=logo_path]').val(fileName);

        },


        debug:false

    });

}


function deleteLogo() {


    jQuery('.qq-upload-list').html('');

    jQuery('.qq-upload-button').show();

    jQuery('input[name=logo_path]').val('');

}


function imposeMaxLength(event, Object, MaxLen) {

    if (event.keyCode == 8) {

        return true;

    }

    return (Object.value.length <= MaxLen);

}


function addFile(ele) {

    var clone = jQuery(ele).parents("tr.document").clone();

    if (jQuery("a.delete_file", clone).length < 1) {

        var add = jQuery("a.add_file", clone);

        add.after('<a class="delete_file" onclick="deleteFile(this)"><img src="/admin/images/delete.gif" width="16" height="16" alt="Delete" title="Delete" /></a>');

        add.remove();

    }

    jQuery(ele).parents("tr.document").after(clone);

    return clone;

}

function deleteFile(ele) {

    jQuery(ele).parents("tr.document").remove();

}

function resetAndHide(ele) {

    jQuery("dd.mandatory").remove();

    jQuery(ele).parents("form").hide();

}

function setFiles() {

    jQuery("tr.document").each(function (i) {

        jQuery(":input", this).attr('name', function () {
            return  this.name + i;
        });

    });

}

function setImage() {

    var img = jQuery(":input[@name=image]").val();

    if (img.length > 0) {

        jQuery(":input[@name=image_h]").val(img);

    }

}

function setToggle(fieldName) {

    var fieldObj = jQuery(":input[@name=" + fieldName + "]");


    if (fieldObj.fieldValue() > 0) {

        jQuery(".if-" + fieldName).show();

    } else {

        jQuery(".if-" + fieldName).hide();

    }

}

// Form validation

function validate(form) {

    var valid = true;

    jQuery("dd.mandatory").remove();

    jQuery("#" + form + " :input.required").each(function () {

        if (jQuery(this).attr("type") == "radio") {

            var name = jQuery(this).attr("name");

            var checked = jQuery(":input[@name=" + name + "]:checked");

            if (checked.length < 1) {

                if (valid) {

                    // Give focus to the first invalid item

                    jQuery(this).focus();

                }

                jQuery(this).parents("dd").after("<dd class='mandatory'>This is a required field</dd>");

                valid = false;

            }

        } else {

            if (jQuery(this).val() === "") {

                if (valid) {

                    // Give focus to the first invalid item

                    jQuery(this).focus();

                }

                jQuery(this).parents("dd").after("<dd class='mandatory'>This is a required field</dd>");

                valid = false;

            }

        }

    });

    jQuery("#" + form + " :input.elserequired").each(function () {

        var elserequired = false;

        var dd = jQuery(this).parents("dd");

        jQuery(":input.elserequired", dd).each(function () {

            elserequired = elserequired || validateRequired(this);

        });

        if (!elserequired) {

            if (valid) {

                // Give focus to the first invalid item

                jQuery(this).focus();

            }

            jQuery(this).parents("dd").after("<dd class='mandatory'>This is a required field</dd>");

            valid = false;

        }

    });

    jQuery("#" + form + " :input.email").each(function () {

        if (jQuery(this).val() !== "") {

            var isEmail = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*(\+[_a-z0-9-]+)?@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})jQuery/i.test(jQuery(this).val());

            if (!isEmail) {

                if (valid) {

                    // Give focus to the first invalid item

                    jQuery(this).focus();

                }

                jQuery(this).parents("dd").after("<dd class='mandatory'>Please input a valid e-mail address</dd>");

                valid = false;

            }

        }

    });

    var i = 0;

    var last = null;

    jQuery("#" + form + " :input.match-email").each(function () {

        var val = jQuery(this).val();

        if (i > 0 && val != last) {

            if (valid) {

                // Give focus to the first invalid item

                jQuery(this).focus();

            }

            jQuery(this).parents("dd").after("<dd class='mandatory'>Values entered do not match</dd>");

            valid = false;

        }

        last = val;

        i++;

    });

    var i = 0;

    var last = null;

    jQuery("#" + form + " :input.match").each(function () {

        var val = jQuery(this).val();

        if (i > 0 && val != last) {

            if (valid) {

                // Give focus to the first invalid item

                jQuery(this).focus();

            }

            jQuery(this).parents("dd").after("<dd class='mandatory'>Values entered do not match</dd>");

            valid = false;

        }

        last = val;

        i++;

    });

    jQuery("dd.mandatory+dd.mandatory").remove();

    return valid;

}


// Dynamic contact rows

function addContact(ele) {

//    var clone = jQuery(ele).parents("div.contact").clone();

//    jQuery(":input:not([type=checkbox])", clone).val("");

//    jQuery(":input", clone).removeAttr("checked");

//    if (jQuery("a.delete", clone).length < 1) {

//        var add = jQuery("a.add", clone);

//        add.after(' <a class="delete" onclick="deleteContact(this)">Delete this contact<\/a>');

//    }

//    jQuery("div.contact:last").after(clone);

//

//	jQuery('.name_prefix:last').attr('name', 'name_prefix_'+ccontact);

//	jQuery('.name_f:last').attr('name', 'name_f_'+ccontact);

//	jQuery('.name_middle:last').attr('name', 'name_middle_'+ccontact);

//	jQuery('.name_l:last').attr('name', 'name_l_'+ccontact);

//	jQuery('.title:last').attr('name', 'title_'+ccontact);

//	jQuery('.phone:last').attr('name', 'phone_'+ccontact);

//	jQuery('.phone_ext:last').attr('name', 'phone_ext_'+ccontact);

//	jQuery('.fax:last').attr('name', 'fax_'+ccontact);

//	jQuery('.email:last').attr('name', 'email_'+ccontact);

//

//	ccontact++;

//    return clone;

    jQuery('.contact1').show();

//    jQuery('#add_more_contact').hide();

    jQuery('.addContact').hide();

    jQuery('#ccontact').val('2');


}

function deleteContact(ele) {

//    jQuery(ele).parents("div.contact").remove();

    jQuery('.contact1').hide();

    jQuery('.addContact').show();

    jQuery('#ccontact').val('1');


}

// Contacts

function setContacts(contacts) {

    if (contacts.length > 0) {

        var first = jQuery("div.contact :input").get(0);


        contact = contacts.shift();

        jQuery(":input[@name=c_id]").val(contact.contact_id);

        if (contact.status > 0) {

            jQuery(":input[@name=c_status]").click();

        }

        jQuery(":input[@name=c_email]").val(contact.email);

        jQuery(":input[@name=c_name_prefix]").val(contact.name_prefix);

        jQuery(":input[@name=c_name_first]").val(contact.name_first);

        jQuery(":input[@name=c_name_middle]").val(contact.name_middle);

        jQuery(":input[@name=c_name_last]").val(contact.name_last);

        jQuery(":input[@name=c_name_suffix]").val(contact.name_suffix);

        jQuery(":input[@name=c_title]").val(contact.title);

        jQuery(":input[@name=c_street]").val(contact.street);

        jQuery(":input[@name=c_pobox]").val(contact.po_box);

        // jQuery(":input[@name=c_mailing]").val(contact.address_mailing);

        jQuery(":input[@name=c_city]").val(contact.city);

        jQuery(":input[@name=c_state]").val(contact.state);

        jQuery(":input[@name=c_zipcode]").val(contact.zipcode);

        jQuery(":input[@name=c_country]").val(contact.country);

        jQuery(":input[@name=c_phone]").val(contact.phone);

        jQuery(":input[@name=c_phone_ext]").val(contact.phone_ext);

        jQuery(":input[@name=c_fax]").val(contact.fax);


        while (contact = contacts.shift()) {

            var newRow = addClone(first, 'contact', 'div.contact');

            jQuery(":input[@name=c_id]", newRow).val(contact.contact_id);

            if (contact.status > 0) {

                jQuery(":input[@name=c_status]", newRow).click();

            }

            jQuery(":input[@name=c_email]", newRow).val(contact.email);

            jQuery(":input[@name=c_name_prefix]", newRow).val(contact.name_prefix);

            jQuery(":input[@name=c_name_first]", newRow).val(contact.name_first);

            jQuery(":input[@name=c_name_middle]", newRow).val(contact.name_middle);

            jQuery(":input[@name=c_name_last]", newRow).val(contact.name_last);

            jQuery(":input[@name=c_name_suffix]", newRow).val(contact.name_suffix);

            jQuery(":input[@name=c_title]", newRow).val(contact.title);

            jQuery(":input[@name=c_street]", newRow).val(contact.street);

            jQuery(":input[@name=c_pobox]", newRow).val(contact.po_box);

            // jQuery(":input[@name=c_mailing]", newRow).val(contact.address_mailing);

            jQuery(":input[@name=c_city]", newRow).val(contact.city);

            jQuery(":input[@name=c_state]", newRow).val(contact.state);

            jQuery(":input[@name=c_zipcode]", newRow).val(contact.zipcode);

            jQuery(":input[@name=c_country]", newRow).val(contact.country);

            jQuery(":input[@name=c_phone]", newRow).val(contact.phone);

            jQuery(":input[@name=c_phone_ext]", newRow).val(contact.phone_ext);

            jQuery(":input[@name=c_fax]", newRow).val(contact.fax);

        }

    }

}


// Dynamic form rows

function addClone(ele, type, selector) {

    var clone = jQuery(ele).parents(selector).clone();

    if (jQuery("a.delete_" + type, clone).length < 1) {

        var add = jQuery("a.add_" + type, clone);

        add.after('<a class="delete delete_' + type + '" onclick="deleteClone(this, \'' + selector + '\')">Delete</a>');

        add.remove();

    }

    jQuery(":input", clone).val("");

    jQuery("dd.mandatory", clone).remove();

    jQuery(ele).parents(selector).after(clone);

    return clone;

}

function deleteClone(ele, selector) {

    jQuery(ele).parents(selector).remove();

}

function addRow(ele, type) {

    var clone = jQuery(ele).parents("tr").clone();

    if (jQuery("a.delete_" + type, clone).length < 1) {

        var add = jQuery("a.add_" + type, clone);

        add.after('<a class="delete_' + type + '" onclick="deleteRow(this)"><img src="wp-content/themes/composting/images/delete.png" width="16" height="16" alt="Delete" title="Delete" /></a>');

        add.remove();

    }

    jQuery(":input", clone).val("");

    jQuery("td.fee span", clone).text("0");

    jQuery(ele).parents("tr").after(clone);

    return clone;

}

function deleteRow(ele) {

    jQuery(ele).parents("tr").remove();

}

function setRows(type) {

    jQuery("tr." + type).each(function (i) {

        jQuery(":input", this).attr('name', function () {
            return  this.name + i;
        });

    });

}

function setNames(selector) {

    jQuery(selector).each(function (i) {

        jQuery(":input", this).attr('name', function () {

            var parts = this.name.split("_");

            if (i == parts.pop()) {

                return this.name;

            } else {

                return this.name + "_" + i;

            }

        });

    });

}

