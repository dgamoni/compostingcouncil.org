<style type="text/css">
.sfd {
	background-color: #99cc66;
	margin-bottom: 15px;
	padding: 11px;
	font-size: 12px;
	border: 1px solid #fff;
}
	</style>
	<?php 
/*
Template Name: Newsletter Education
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
    <?php  include("sidebar/sidebar-right-noad.php"); ?>
<div class="sfd">
<h3><strong style="color: steelblue; font-size:16px;">2015 COTC <br>
  Dates and Locations</strong></h3>
<hr>
<span style="color: #000000;"><strong>March 2-6</strong>, Cal Poly Pomona, Pomona, CA
</span> <span style="color: #000000;"><strong><br>
July 20-24</strong>, Chantilly, VA
</span> <span style="color: #000000;"><strong><br>
Sept 14-18</strong>, NCSU, Raleigh, NC
</span> <span style="color: #000000;"><strong><br>
Nov 16-20</strong>, Vista Organics, <br>
Apopka, FL</span>
<br>
<br> 
Visit
<a href="http://compostingcouncil.org/training" target="_blank"> www.compostingcouncil.org/training</a> for registration and more details.
</div>
     <?php  include("sidebar/subpages.php"); ?>     
  </div>  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

                <br />
                </ul>