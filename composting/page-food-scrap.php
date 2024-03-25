<?php 
/*
Template Name: Food Scrap Composting
*/
?>



<?php if (is_page('15854') ) { ?>
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
  <div id="side-left" class="widget-area">
    <?php  include("sidebar/subpages.php"); ?>
  </div>
  <!--MIDDLE SECTION-->
  <div id="content">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post">
      <div class="entry-content">
      
      
      
      
           
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
  <img style="border:1px solid #bfdfeb;padding:2px;   margin-bottom: -5px;" src="http://compostingcouncil.org/wp/wp-content/uploads/2016/10/booker-staff.jpg" width="220" height="238" alt=""/>
  <p style="font-size: 10px; line-height: 12px; margin-bottom: 18px; text-align: justify; padding:2px;">USCC Executive Director Frank Franciosi met October 19th with the staff of US Rep Cory Booker-NJ (left to right, Paloma Aguirre, Frank Franciosi, Adam Zipkin and Matt Thomson) to discuss the <a href="https://www.congress.gov/bill/114th-congress/senate-bill/3108/committees" target="_blank">Food Recovery Act</a> of which Rep Booker is a co-sponsor, and the role of compost infrastructure and compost use in the legislation.</p>
  <?php  include("sidebar/sidebar-right-noad.php"); ?>
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>





<?php } ?>