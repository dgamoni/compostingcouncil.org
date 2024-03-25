




// Member products
function addMemberProduct() {
    var ele         = jQuery("#product_category").get(0);
    var code        = jQuery("#product_category option:selected").val();
    var category    = jQuery("#product_category option:selected").text();
    if (code != "") {
        var exists = false;
        jQuery(":input[name='member_products[]']").each(function() {
            if (code == this.value) {
                exists = true;
            }
        });
        if (exists) {
            alert("You have already added this product category.");
        } else {
            var new_option = '<tr valign="top"><td>' + category + '<input type="hidden" name="member_products[]" value="' + code + '" \/><\/td><td width="24" align="right"><img src="wp-content/themes/composting/images/delete.png" width="16" height="16" alt="Delete" title="Delete" class="button" onclick="jQuery(this).parent().parent(\'tr\').remove();" \/><\/td><\/tr>';
            jQuery("#product_categories tr.add").before(new_option);
            ele.selectedIndex = 0;
        }
    }
}


	var reps = new Array();
	function make_reps_mandatory()
	{
		jQuery("input[name=rep2_name]").change(check_reps);
		jQuery("input[name=rep2_phone]").change(check_reps);
		jQuery("input[name=rep2_email]").change(check_reps);
		jQuery("input[name=rep3_name]").change(check_reps);
		jQuery("input[name=rep3_phone]").change(check_reps);
		jQuery("input[name=rep3_email]").change(check_reps);
		check_reps();
	}
	
	function check_reps()
	{
		set_mandatory('rep2', !check_empty('rep2'));
		set_mandatory('rep3', !check_empty('rep3'));
	}
	
	
	function set_mandatory(rep, mandatory)
	{
		if(reps[rep] == mandatory) return;
		reps[rep] = mandatory;
		if(mandatory)
		{
			jQuery("label[for=" + rep + "_name]").before('<span class="required">*</span> ');
			jQuery("label[for=" + rep + "_phone]").before('<span class="required">*</span> ');
			jQuery("label[for=" + rep + "_email]").before('<span class="required">*</span> ');
			jQuery("input[name=" + rep + "_name]").addClass("required");
			jQuery("input[name=" + rep + "_phone]").addClass("required");
			jQuery("input[name=" + rep + "_email]").addClass("required");
		} else {
			jQuery("label[for=" + rep + "_name]").prev().remove();
			jQuery("label[for=" + rep + "_phone]").prev().remove();
			jQuery("label[for=" + rep + "_email]").prev().remove();
			jQuery("input[name=" + rep + "_name]").removeClass("required");
			jQuery("input[name=" + rep + "_phone]").removeClass("required");
			jQuery("input[name=" + rep + "_email]").removeClass("required");
		}
	}

	function check_empty(rep)
	{
		if(jQuery("input[name=" + rep + "_name]").val() != "") return false;
		if(jQuery("input[name=" + rep + "_email]").val() != "") return false;
		if(jQuery("input[name=" + rep + "_phone]").val() != "") return false;
		return true;
	}
