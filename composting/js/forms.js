/* 
 *  (c) 2010 Wott (http://wott.net.ru/ , wott@gmail.com)
 */


String.prototype.capitalize = function(){ //v1.0
    return this.replace(/\w+/g, function(a){
        return a.charAt(0).toUpperCase() + a.substr(1).toLowerCase();
    });
};

function forms_init(form_id) {
    var $=jQuery;
    
    var cost = [];
    window['recalculate'] = function(obj, amount) {
        //alert($(obj).attr('id')+' called ->'+amount);
		if (typeof amount == 'object') {
			var workshop_rate = $("input[name=workshop_rate]:checked").val();
			if (workshop_rate == 'member') {
				amount = amount.member;
			} else {
				amount = amount.nonmember;
			}
		}
        if (('radio'==$(obj).attr('type') || 'checkbox'==$(obj).attr('type')) && !$(obj).attr('checked')) amount=0;

        cost[$(obj).attr('id')] = amount;

        var key,total=0;
        for (key in cost)
            if (typeof(cost[key])=='number') total+=cost[key];

        $("#total-display").html('$' + total);
    }

    // add recalc_multiple to text inputs with price multiplier
    $('#'+form_id+' input.recalc_multiple').each(function() {
        var val = $(this).val();
        var price = Number(val.replace(/(\d+)(\*)?(.*)/,'$1'));
        $(this).val(val.replace(/(\d+)(\*)?(.*)/,'$3'));
        // alert($(this).attr('id')+' set=>'+price);
        $(this).change(function(){
            // alert($(this).attr('id')+' call '+this.value+'=>'+price);
            recalculate(this,this.value*price);
        });
        
    });

    $('#'+form_id+' select.recalc_multiple').each(function() {
        var price=Number($(this).attr('rel'));
        // alert('Select '+$(this).attr('id')+' price '+price);
        $(this).change(function(){
            //alert($(this).attr('id')+' call '+$(this).val()+'=>'+price);
            var val = Number($(this).val());
            if ($(this).attr('disabled')) val=0;
            recalculate(this,val*price);
        });
    });

    // init calc
    $('#'+form_id+' input:checked').each(function() {
        $(this).click();
        if ('checkbox' == $(this).attr('type')) $(this).attr('checked','checked');
    });
    $('#'+form_id+' .recalc_multiple').each(function() {
        $(this).change();
    });

	function change_workshop_membership(){
		$('#workshops input[type=checkbox]').each(function(){
			$(this).click();
			if ($(this).attr('checked')) $(this).removeAttr('checked');
			else $(this).attr('checked','checked');
		});
	}

	$('#'+form_id+' input[name=workshop_rate]').click(change_workshop_membership);


    $('#'+form_id+' input').change(function(){
        var id = $(this).attr('id');
        //alert(id+'='+$(this).attr('checked'));
        if ($(this).attr('checked')) {
            $('.'+id).removeAttr('disabled').change();
            if ($(this).attr('type')=='radio') $('input[name='+$(this).attr('name')+']').not('#'+id).change();
        } else {
//            alert('ss');
//			$('.'+id).attr('disabled','disabled').removeAttr('checked').change().val('');
			$('.'+id).attr('disabled','disabled').removeAttr('checked').change();
			if ('radio'==$(this).attr('type') || 'checkbox'==$(this).attr('type')) recalculate(this,0);
		}
    });

    $('#'+form_id+' input[name=registration_option]:checked').change();

	$('#'+form_id+' input[name=rate]').click(function() {
		var id=$(this).attr('id');
		if (id.indexOf('nonmember')>-1) {
			if (!$('#workshop_rate_nonmemeber').attr('checked')) {
				$('#workshop_rate_nonmemeber').attr('checked','checked');
				change_workshop_membership();
			}

		} else {
			if (id.indexOf('member')>-1) {
				if (!$('#workshop_rate_memeber').attr('checked')) {
					$('#workshop_rate_memeber').attr('checked','checked');
					change_workshop_membership();
				}
			}
		}
	});

	$("#btnSubmit").removeAttr("disabled");
	$("#btnSubmit2").removeAttr("disabled").click(function(){
        $('#'+form_id+' input[name=_register_http_referer]').val('back')
    });

    $('#'+form_id+' input.member_warning').change(function() {
        if ($(this).attr('checked'))
            alert('Please login in order to take advantage of the membership prices');
    })

    window['validate'] = function(form_name) {
		var required_fields = [];
		$('#'+form_name+' input.required').each(function() {
			var name = $(this).attr('name');
			if (name=='post_title') name='name';
			if (!$(this).val()) required_fields.push(name.capitalize());
		});
		$('#'+form_name+' select.required').each(function() {
			if (!$(this).val()) required_fields.push($(this).attr('name').capitalize());
		});
		$('#'+form_name+' textarea.required').each(function() {
			if (!$(this).val()) required_fields.push($(this).attr('name').capitalize());
		});

        if ($('#'+form_name+' input.member_warning:checked').length>0) {
            alert('Please login in order to take advantage of the membership prices');
            return false;
        }

		if (required_fields.length) {
			alert('You have to fill all required fields: '+required_fields.toString());
			return false;
		}

		return true;
	}

	$('#'+form_id).submit(function() {
		var rate            = $('#'+form_id+' input[name=rate]:checked').val();
		var exam            = $('#'+form_id+' input[name=exam]:checked').val();
		var workshop_rate   = $('#'+form_id+' input[name=workshop_rate]:checked').val();
		if (((rate == 'member' || rate == 'one-day-member') && exam == 'nonmember') || ((rate == 'nonmember' || rate == 'one-day-nonmember') && exam == 'member')) {
			return confirm('You have specified a different membership status for the conference and exam fees. Is this correct?');
		}
		if (((rate == 'member' || rate == 'one-day-member') && workshop_rate == 'nonmember') || ((rate == 'nonmember' || rate == 'one-day-nonmember') && workshop_rate == 'member')) {
			return confirm('You have specified a different membership status for the conference and workshops. Is this correct?');
		}
	});

}
