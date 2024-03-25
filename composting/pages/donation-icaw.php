<?php the_content(); ?>
<!-- News -->
  
   	
 <form style="margin-bottom:0px;" action="https://www.paypal.com/cgi-bin/webscr" method="post" name="formPayPal" target="_blank" id="formPayPal" onSubmit="donateType();"> 
        <div align="left"> 
          <table style="margin-bottom:0px; width:423px;" border="0" cellspacing="0" cellpadding="0"> 
            <tr> 
              <td height="1" valign="top"><table  border="0" cellspacing="0" cellpadding="2"> 
                  <tr> 
                    <td style="width:145px; "><script type="text/javascript"> 
 
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
                      &nbsp; <span id="donate_symbol_currency" class="sField"></span>&nbsp;
                  
                    <select name="amount"> 
                        <option selected="selected" value="Select">Select Amount</option> 
                        <option value="25.00">$25.00</option> 
                        <option value="50.00">$50.00</option> 
                        <option value="100.00">$100.00</option> 
                         <option value="250.00">$250.00</option> 
                          <option value="500.00">$500.00</option> 
                 
                      </select> </td> 
                       
                    <td ><select name="os0">
                        
                <option value="ICAW ">ICAW </option>
                          
                        </select></td>
                   
                   
                   
                   
                   
                    <td style="width:90px; "><select name="t3" class="sField" id="DonateField"> 
                        <option value="0" selected="selected">One Time</option> 
                        <option value="W">Weekly</option> 
                        <option value="M">Monthly</option> 
                        <option value="Y">Annual</option> 
                      </select></td> 
                    <td  style="width:100px;">
                    <input type="submit" style="padding:0px;" value="Submit Donation"></td> 
              
                   <td>
               
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
      
      
      
	<h4>Or enter your own amount.</h4>
    
 <form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="formPayPal" target="_blank" id="formPayPal" onSubmit="donateType();"> 
        <div align="left"> 
          <table style=" width:420px;" border="0" cellspacing="0" cellpadding="0"> 
            <tr> 
              <td height="1" valign="top"><table  border="0" cellspacing="0" cellpadding="2"> 
                  <tr> 
                    <td style="width:120px; "><script type="text/javascript"> 
 
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
                      &nbsp; <span id="donate_symbol_currency" class="sField">$</span>&nbsp;
                      <input name="amount" type="text"  size="8" class="sField" id="DonateField" ></td> 
                   
                   
                
                     <td ><select name="os0">
                        
                <option value="ICAW ">ICAW </option>
                          
                        </select></td>
                   
                   
                   
                    <td style="width:90px; "><select name="t3" class="sField" id="DonateField"> 
                        <option value="0" selected="selected">One Time</option> 
                        <option value="W">Weekly</option> 
                        <option value="M">Monthly</option> 
                        <option value="Y">Annual</option> 
                      </select></td> 
                    <td  style="width:100px;">
                    <input type="submit" style="padding:0px;" value="Submit Donation"></td> 
              
                   <td>
               
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