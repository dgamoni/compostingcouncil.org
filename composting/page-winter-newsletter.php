<?php 
/*
Template Name: Winter2015 Newsletter
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
      
     
         <?php } elseif  (is_page('105') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/feedback.php'); ?>
        
         <?php } elseif  (is_page('166') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/workshops.php'); ?>
        
        <?php } elseif  (is_page('18') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/c-registration.php'); ?>
      
        
       
		
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
    <?php  include("sidebar/sidebar-right-noad.php"); ?>
<a href="http://wasteadvantagemag.com/" target="_blank"><img class="aligncenter wp-image-22118 size-full" src="http://compostingcouncil.org/wp/wp-content/uploads/2015/01/Wambutton_120x90.png" alt="WasteAdvantage" width="120" height="90" /></a><br>
    <br>
    <a href="http://www.rimbach.com/cgi-bin/fronts/pen/frontpendisplay.idc" target="_blank"><img class="aligncenter wp-image-22118 size-full" src="http://compostingcouncil.org/wp/wp-content/uploads/2015/01/Pollution-equipment-news.jpg" alt="WasteAdvantage" width="220" height="165" /></a><br>
    <br>
<?php  include("sidebar/subpages.php"); ?> 
  <br>
  <strong>Member submissions for Compost Communicator can be emailed to Linda Norris-Waldt at: <a href="mailto:lnorriswaldt@compostingcouncil.org">lnorriswaldt@compostingcouncil.org</a> </strong></div>  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php } ?>