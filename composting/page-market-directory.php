<?php 
/*
Template Name: Market Directory
*/
?>



<?php if (is_page('2') ) { ?>
<?php include(TEMPLATEPATH . '/index.php'); ?>
<?php } else{?>


<?php 
if (is_page(explode(',','674,62,64'))) {
	wp_enqueue_script('datepicker',get_bloginfo('template_directory').'/js/ui.datepicker.min.js',array('jquery-ui-core'),'1.7.3');
	wp_enqueue_style('jquery-ui-lightness',get_bloginfo('template_directory').'/js/'.JQUERY_UI_THEME.'/jquery-ui-1.7.3.custom.css');
}
if (is_page(explode(',','18,22,24,28'))) {
	wp_enqueue_style('forms_styles', get_template_directory_uri().'/form.css');
	wp_enqueue_script('forms_scrypt', get_template_directory_uri().'/js/forms.js');
}
get_header(); 
?>


<div id="container">
  <div id="clear"></div>
  <h1 class="entry-title">
    <?php the_title(); ?>
  </h1>
  
  <!--MIDDLE SECTION-->
  <div>
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div>
      <div> <a  title="Products and Services Directory" href="http://portal.compostingcouncil.org/Portal/Product_Services_Directory.aspx"><img style="margin-bottom: 20px; margin-left: 88px; border:1px solid #bfdfeb;padding:2px;" align="center" class=" size-medium wp-image-27591 aligncenter" src="http://compostingcouncil.org/wp/wp-content/uploads/2016/11/USCC-P-and-S-directory-header.jpg" alt="uscc-p-and-s-directory-header" width="800" height="202" /></a>
        <div style="text-align: left; width: 800px; margin-left: 88px; line-height: 1.3; margin-bottom: 20px;"> <h2 style="color: #046E03; font-size: 21px;"> <strong>Here is your one-stop shop to a wide array of what the compost manufacturing industry needs to be successful.</strong></h2></div>
         
         
           
		  <div style="text-align: center;"> <a href="http://portal.compostingcouncil.org/Portal/Product_Services_Directory.aspx"><img style="margin-bottom: 40px; margin-top: 20px;" class="aligncenter  wp-image-27589" src="http://compostingcouncil.org/wp/wp-content/uploads/2016/11/shop_button-800x215.jpg" alt="shop_button" width="198" height="50" /></a> </div>
             
             
		  <div style="text-align: left; width: 800px; margin-left: 88px; color: #000000; line-height: 1.3;"><h2 style="color: #000000; margin-bottom: 25px;"> Categories of products and services you’ll find include: </h2>

		  <div style="margin-left: 88px; font-size: 16px; font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial,' sans-serif'">  
<table width="700" border="0" align="center">
  <tbody>
    <tr>
<td width="350" valign="top">Aeration Equipment/Floors<br>
Air Separation Equipment<br>
Anaerobic Digestion<br>
Backyard Composting<br>
Bagging Equipment<br>
Biosolids Management<br>
Catalysts/Inoculants<br>
Collection/Compost Containers<br>
Compost Pile Covers<br>
Composting Systems<br>
Composting Tea Equipment<br>
Compost Turners<br>
Compost Application Equipment<br>
Compost/Mulch Manufacturer/Supplier<br>	
Consultant<br>
Dust Control<br>
Equipment Leasing/Financing<br></td>   
<td valign="top">Erosion Control Products<br>
Grinding/Shredding Equipment<br>
Hauler<br>
Industry Publications<br>
In-Vessel Composting Systems<br>
Materials Handling<br>
Mixing Equipment and Services<br>
Monitering Equipment <br>
Netting/Litter Control<br>
Non-Profit Organization<br>
Odor Control<br>
Parts & Supplies for Composting<br>
Process Control<br>
Rolling Stock: payloaders, dozers, trucks<br>
Screening Equipment<br>
Structures, Insulation<br>
Testing Laboratories <br></td>
    </tr>
  </tbody>
</table>
		    </div>           
 		  <div style="text-align: center;"> <a href="http://portal.compostingcouncil.org/Portal/Product_Services_Directory.aspx"><img style="margin-bottom: 20px; margin-top: 35px;" class="aligncenter  wp-image-27589" src="http://compostingcouncil.org/wp/wp-content/uploads/2016/11/shop_button-800x215.jpg" alt="shop_button" width="198" height="50" /></a> </div>  
                                    
			 

                                     
                                                                                                         
           
        </div>
  <hr>          
      <div style="text-align: left; width: 800px; margin-left: 42px; line-height: 1.3; margin-bottom: 20px;"> <h1 style="color: #000000; margin-bottom: 25px;"><strong>Featured Vendors!</strong></h1>
<table width="900px" border="0" cellspacing="5" style="margin-bottom: 20px;">
  <tbody>
    <tr>
		   	<td width="300"  style="background-color: 
		   	#DEFDB2;">
     		<a href="http://actionconveyors.com/home/" target="_blank"><img style="border:1px solid #bfdfeb;padding:2px; margin-left: 12px; margin-top: 12px; margin-bottom: 5px;" src="https://compostingcouncil.org/wp-content/uploads/2018/03/action.jpg" width="212" height="110" alt=""/></a> <br>
			<div style="text-align: left; margin-left: 12px; margin-right: 12px; margin-bottom: 12px; font-size: 16px;"><strong>Action Equipment Company, Inc.</strong>  manufactures heavy duty vibratory screening and processing equipment for the efficient handling of bulk materials. <a href="http://actionconveyors.com/home/" target="_blank"><img style="border:1px solid #bfdfeb;padding:2px; margin-top: 10px;" src="https://compostingcouncil.org/wp-content/uploads/2018/03/DD-VIBRA-SNAP-Screen-280w.jpg" width="280" height="186" alt=""/></a> </div></td>
       
          <td width="300" style="background-color: #E5E6E5;">
          <a href="https://coastofmaine.com/" target="_blank"><img style="border:1px solid #bfdfeb;padding:2px; margin-left: 12px; margin-top: 12px; margin-bottom: 5px;" src="https://compostingcouncil.org/wp-content/uploads/2018/02/CoastOfMaine-logo280w3.jpg" width="280" height="110" alt=""/></a> <br>
          <div style="text-align: left; margin-left: 12px; margin-right: 12px; margin-bottom: 12px; font-size: 16px;"><strong>Coast of Maine Organic Products, inc.</strong> is a company founded in Maine that has been producing truly exceptional, organically approved, compost-based soils, enriching mulches, soil supplements and liquid fertilizers, for more than 20 years.  Designed to enhance and support healthy soil biology, they compost residuals sourced locally in Maine and New Brunswick, such as shellfish (lobster & crab), salmon, wild blueberries, and cow manure. Additional local ingredients include: tree bark, worm castings, and seaweed. The company distributes their organic retail bagged goods to independent garden centers along the Northeast and Mid-Atlantic.
            <a href="https://coastofmaine.com/" target="_blank"><img style="border:1px solid #bfdfeb;padding:2px; margin-top: 10px;" src="https://compostingcouncil.org/wp-content/uploads/2018/02/US-Compost-council-site-image-280x373.jpg" width="280" height="373" alt=""/></a> </div></td>
     
          <td width="300" style="background-color: #CAF9D4;"> 
<a href="https://kooima.com/" target="_blank"><img style="border:1px solid #bfdfeb;padding:2px; margin-left: 12px; margin-top: 12px; margin-bottom: 5px" src="https://compostingcouncil.org/wp-content/uploads/2018/02/kooima-company-logo280w.jpg" alt="" width="280" height="110"></a> <br>
<div style="text-align: left; margin-left: 12px; margin-right: 12px; margin-bottom: 12px; font-size: 16px;"><strong>Trner</strong> is a composter specifically designed for use in high volume cattle manure applications. The product was designed to specifically fulfill the demanding needs of the feedlot and or dairy producer.
  <a href="https://kooima.com/" target="_blank"><img style="border:1px solid #bfdfeb;padding:2px; margin-top: 10px;" src="https://compostingcouncil.org/wp-content/uploads/2018/02/Kooima-Trner-Composter.jpg" alt="" width="280" height="110"></a> </div></td>
    </tr>
  </tbody>
</table>
       
        
       
	    <p><em>You must be a USCC member to be featured in the Directory; (<a href="http://www.compostingcouncil.org/membership" target="_blank">www.compostingcouncil.org/membership</a>); to learn more, dial 301.897.2715, X2 or email <a href="mailto:memership@compostingcouncil.org" target="_blank">memership@compostingcouncil.org</a>. </em></p></div>       
            
          <!--content redirections -->
          <?php if (is_page('1') ) { ?>
          <?php include(TEMPLATEPATH . '/content-pages/sample.php'); ?>
         
            
            
            
          <?php } elseif  (is_page('79') ) { ?>
            
          <?php the_content(); ?>
            
            
          <?php } else{?>
            
          <?php the_content(); ?>
            
            
            
            
            
        
        <div id="blue-line"></div>
          
          
        <?php include(TEMPLATEPATH . '/sidebar/social.php'); ?>
        <?php }?>
      
    </div>
    <?php endwhile; ?>
	<?php if (is_page(explode(',','18,28,22'))): ?>
	<script type="text/javascript">
	//<![CDATA[
	(function($) {
	$(document).ready(function() {
		forms_init('registration');
	});
	})(jQuery);
	//]]>
	</script>
	<?php endif; ?>
  </div>
  <!--MIDDLE SECTION-->
  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>





<?php } ?>