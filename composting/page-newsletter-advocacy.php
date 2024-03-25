<?php 
/*
Template Name: Newsletter Advocacy
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
  <div id="content" style="width:750px;">
  
  
  
  
  
  
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post-wide">
      <div class="entry-content" style="">
      
      

           
           
           
        
      
      
      
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
    <h3><strong><a href="http://compostingcouncil.org/state-compost-regulations-map/" target="_blank">Visit our updated STATE REGULATIONS PAGE</a></strong></h3>
Find the latest in regulations, legislation and agency contacts refreshed from a summer of research. Look up and print out your state and keep it on hand!
<br>
<a href="http://compostingcouncil.org/state-compost-regulations-map/" target="_blank">Visit here</a>
<p style="text-align: center;"><a href="http://compostingcouncil.org/state-compost-regulations-map/" target="_blank"><img class="size-full wp-image-17603 aligncenter" title="map" src="http://compostingcouncil.org/admin/wp-content/uploads/2014/10/map1.jpg" alt="" width="180" height="125" /></a></p>
    <?php  include("sidebar/sidebar-right-noad.php"); ?>

   
     <?php  include("sidebar/subpages.php"); ?>     
  </div>  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php } ?>