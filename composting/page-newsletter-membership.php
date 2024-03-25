<style type="text/css">
.sfd {
	background-color: #99cc66;
	margin-bottom: 15px;
	padding: 11px;
	font-size: 12px;
}

.sfq {
	background-color: #FFFFFF;
	margin-bottom: 15px;
	border: 2px solid #54eab3;
	padding: 11px;
	font-size: 14px;
	text-align:left;
}

	</style>
	<?php 
/*
Template Name: Newsletter Membership
*/
?>

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
  <div id="content" style="width:710px;">
  
  
  
  
  
  
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post">
      <div class="entry-content" style="">
      
      

           
           
           
         <div id="side-right" class="widget-area" style="float:right; margin-right:-58px; margin-left:10px;">
    <?php  include("sidebar/sidebar-right-over.php"); ?>
  </div>
      
      
      
        <!--content redirections -->
        <?php if (is_page('1') ) { ?>
        <?php include(TEMPLATEPATH . '/content-pages/sample.php'); ?>
        <?php } elseif  (is_page('43') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/news_events.php'); ?>
        <?php } elseif  (is_page('206') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/news.php'); ?>
        <?php } elseif  (is_page('48') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/press.php'); ?>
        <?php } elseif  (is_page('213') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/newsletters.php'); ?>
        <?php } elseif  (is_page('46') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/events.php'); ?>
        <?php } elseif  (is_page('55') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/resources.php'); ?>
        <?php } elseif  (is_page('107') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/faq.php'); ?>
        <?php } elseif  (is_page('674') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/add-event.php'); ?>
        <?php } elseif  (is_page('62') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/submit-job-offer.php'); ?>
        <?php } elseif  (is_page('64') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/submit-job-wanted.php'); ?>
        <?php } elseif  (is_page('204') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/posters.php'); ?>
        <?php } elseif  (is_page('81') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/job-area.php'); ?>
        <?php } elseif  (is_page('77') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/links.php'); ?>
         <?php } elseif  (is_page('105') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/feedback.php'); ?>
        
         <?php } elseif  (is_page('166') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/workshops.php'); ?>
        
        <?php } elseif  (is_page('18') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/c-registration.php'); ?>
       
         <?php } elseif  (is_page('28') ) { ?>
		 <?php include(TEMPLATEPATH . '/pages/c-abstract.php'); ?>
         
         
        <?php } elseif  (is_page('57') ) { ?>
		 <?php include(TEMPLATEPATH . '/pages/publications.php'); ?>
         
        
        <?php } elseif  (is_page('22') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/c-exhibitors.php'); ?>
        
        <?php } elseif  (is_page('24') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/c-sponsors.php'); ?>
          <?php } elseif  (is_page('2804') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/donation-icaw.php'); ?>
        
          <?php } elseif  (is_page('97') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/donation-ccref.php'); ?>
        
          <?php } elseif  (is_page('1290') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/donation-support.php'); ?>
        
          <?php } elseif  (is_page('1292') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/advocacy.php'); ?>
        
         <?php } elseif  (is_page('1523') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/events-icaw.php'); ?>
        
		<?php } elseif  (is_page('1310') ) { ?>
        <?php the_content(); ?>
        <?php include(TEMPLATEPATH . '/pages/events-training.php'); ?>
		
		<?php } elseif  (is_page('229') ) { ?>
		
		<? include TEMPLATEPATH."/login_form.php"; ?> 
        
        
		<?php } elseif  (is_page('5') ) { ?>
		<?php the_content(); ?>
        
          <?php } elseif  (is_page('1850') ) { ?>

<?php
query_posts('page_id=3348');
if (have_posts()) : while (have_posts()) : the_post();
	?>
    <?php the_content(''); ?>
	<?php
endwhile; endif;
wp_reset_query();
?>




        <?php the_content(); ?>
        
        
        
        
        <?php } elseif  (is_page('79') ) { ?>
		<?php the_content(); ?>
        
        <?php } else{?>
        
        <?php the_content(); ?>
   
        
        

        

          <div id="blue-line"></div>
		 <?php include(TEMPLATEPATH . '/sidebar/social.php'); ?>
        <?php }?>
        
      
        
      </div>
      
      
      
      
      
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
<div id="side-right" class="widget-area">
 <br>
<div class="sfq"><h3><strong style="color: steelblue; font-size:16px;">Restructuring  Update:  Fall  2014</strong></h3>
  <span style="font-size: 12px">The  USCC  Board  of  Directors  appointed  a  Transition  Committee  to  develop  a  comprehensive  
restructuring  plan  for  the  USCC.  The  Committee  includes  USCC  Board  members,  staff  and  other  
stakeholders,  and  has  been  meeting  every  other  week  since  its  inception  in  J
uly.  “The  USCC  has  
experienced  significant  growth  and  change  in  recent  years,  and  it’s  time  that  we  took  a  fresh  
look  at  how  we  do  business,”  said  Lorrie  Loder,  USCC  President.  The  Committee  is  reviewing  
roles  and  expectations  of  its  staff  and  leadership,  
and  evaluating  several  options  to  determine  
the  best  way  to  operate  moving  forward</span>.<br>
<a href="http://compostingcouncil.org/wp/wp-content/uploads/2014/11/restructuring-update.pdf" target="_blank"><strong style="font-size: 12px">Click here for more</strong></a>
      
    </div>
    
   
<div class="sfd">
<h3><strong style="color: steelblue; font-size:16px;">New Members, <br>
  July - October: Welcome!</strong></h3>
<hr>
Ohio EPA<br>
Sean D. OToole<br> 
Natures Earth of Memphis<br> 
University of Alabama at Birmingham<br>
US EPA Region 4<br> 
CB Industries - Delta, Inc<br> 
Cecil Patterson<br> 
GWS<br> 
HAMMEL New York, LLC<br> 
Draper Aden Associates<br> 
Let Us Compost<br>
Nikoo S.K<br>
Dakota Compost, Inc.<br>
Benzaco Scientific Odor Control<br> 
TTI Environmental Laboratories<br> 
PLB Bio Green Sdn Bhd<br> 
Wetland and Wildlife Consulting, Inc.<br> 
Premium Services Inc<br>  
Thomas J. Gehring<br> 
Matt Lyum<br> 
Prema LLC<br> 
Carbon Solutions Group<br> 
Monika Roy<br> 
Grupo Simplex<br> 
S & S Processing, Inc.<br> 
Royal Oak Farm LLC<br> 
Mississippi Department of Environmental Quality<br> 
Tompkins County Solid Waste Management<br> 
BB Wood Products, LLC<br> 
Green Mountain Compost/Chittenden Solid Waste District<br> 
Aschl Compost Software<br> 
Continental Biomass Industries (CBI)<br> 
Anna Hanchett<br> 
Bruno Vaes<br> 
Manetech US, LLC<br> 
Organic Technologies, Inc<br> 
Sevier Solid Waste, Inc.<br> 
Space Research L3C<br> 
Bison Compost, LLP 
 <br>   
</div>

<?php  include("sidebar/sidebar-right-noad.php"); ?>
     <?php  include("sidebar/subpages.php"); ?>     
  </div>  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

                <br />
                </ul>