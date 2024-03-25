<?php 
/*
Template Name: Fall Communicator 2016
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
    <div style="margin-left: 31px;">
    <img src="http://compostingcouncil.org/wp/wp-content/uploads/2016/11/USCC-CC-Fall-2016_Final-1.jpg" alt="uscc-cc-fall-2016_final-1" width="923" height="1192" class="alignnone size-medium wp-image-27657" />
    <hr>
     <img src="http://compostingcouncil.org/wp/wp-content/uploads/2016/11/USCC-CC-Fall-2016_Final-2.jpg" alt="uscc-cc-fall-2016_final-1" width="923" height="1201" class="alignnone size-medium wp-image-27657" />
    <hr>
     <img src="http://compostingcouncil.org/wp/wp-content/uploads/2016/11/USCC-CC-Fall-2016_Final-3.jpg" alt="uscc-cc-fall-2016_final-1" width="923" height="1215" class="alignnone size-medium wp-image-27657" />
    <hr>
     <img src="http://compostingcouncil.org/wp/wp-content/uploads/2016/11/USCC-CC-Fall-2016_Final-4.jpg" alt="uscc-cc-fall-2016_final-1" width="923" height="1199" class="alignnone size-medium wp-image-27657" />
    
    
     </div>       
            
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