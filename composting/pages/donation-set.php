<?php the_content(); ?>
<!-- News -->
  
   
	
<form style="margin-bottom:7px;" action="https://www.paypal.com/cgi-bin/webscr" method="post" name="formPayPal" target="_blank" id="formPayPal" onSubmit="donateType();"> 
          
		<div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" id="DonateText"> 
            </font> 
			
  <table width="100%" border="0" cellspacing="0" cellpadding="0"> 
                <tr> 
                 
                  <td height="1" valign="top"><table  border="0" cellspacing="0" cellpadding="2"> 
                      <tr> 
                        <td > 
<script type="text/javascript"> 
 
  function donateType () 
  {
  if (document.formPayPal.t3.value == "0") 
 	{
		document.formPayPal.cmd.value = '_xclick';
		document.formPayPal.item_name.value = '';
		}else{
		document.formPayPal.cmd.value = '_xclick-subscriptions';
		document.formPayPal.a3.value = document.formPayPal.amount.value;
		document.formPayPal.item_name.value = "Reoccurring Donation";
	}
  }
</script> 
 
 
    <select name="amount"> 
                        <option selected="selected" value="Select">Select Amount</option> 
                        <option value="25.00">25.00</option> 
                        <option value="50.00">50.00</option> 
                        <option value="75.00">75.00</option> 
                         <option value="100.00">100.00</option> 
                 
                      </select> </td> 
                        <td > 
                        
                        
              <select name="os0"> 
    <option selected="selected" value="Select">Select</option> 
    <option  value="General Fund">General Fund</option> 
    <option value="Capital Campaign">Capital Campaign</option> 
    <option value="Youth Ministry">Youth Ministry</option> 
    </select>           
                        
                        
                        </td><td> 
<select name="t3" class="sField" id="DonateField"> 
    <option value="0" selected="selected">One Time</option> 
    <option value="W">Weekly</option> 
    <option value="M">Monthly</option> 
    <option value="Y">Annual</option> 
 </select> 
 </td><td> 
 
<input name="submit" type="image" src="http://cslkc.org/images/buttons/cone.gif" alt="Make donations with PayPal" > 
 
</td> 
                        
                      </tr> 
                  </table></td> 
                </tr> 
              </table> 
               <input type="hidden" name="cmd" value="_xclick"> 
              <input type="hidden" name="currency_code" value="USD"> 
 
             
          <input type="hidden" name="business" value="admin@compostingcouncil.org"> 
          <input type="hidden" name="return" value="http://compostingcouncil.org"> 
          <input type="hidden" name="cancel_return" value="http://compostingcouncil.org"> 
          <input type="hidden" name="on0" value="Area"> 
              <input type="hidden" name="no_note" value="1"> 
              <input type="hidden" name="tax" value="0"> 
			<input type="hidden" name="a3" value="0" title="total"> 
				<input type="hidden" name="p3" value="1" > 
				<input type="hidden" name="src" value="1"> 
				<input type="hidden" name="sra" value="1"> 
				<input type="hidden" name="item_name" value=""> 
		
<script language="JavaScript"> 
document.formPayPal.amount.focus()
  </script> 
        </div> 
      </form> 
 
      <p><a href="5_contribute_new2.html" style="color:#F90">If you would like to enter your own amount click here.</a><br /> 
        <br /> 
<br /> 
 
 
 
 
 
 
 
 
 
 
 
 
 

 


 

	


    
    
    

  
   
   

   