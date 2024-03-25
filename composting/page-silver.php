<?php 

/*

Template Name: Silver Anniversary

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

           

		<?php } elseif  (is_page('189') ) { ?>

          <?php include(TEMPLATEPATH . '/pages/sta.php'); ?>

        <?php the_content(); ?>

      
   

         <?php } elseif  (is_page('75') ) { ?>

		 <?php include(TEMPLATEPATH . '/pages/directory.php'); ?>

        

        

        

        

        <?php } elseif  (is_page('1850') ) { ?>

         

         

         

         <?php

$post_id = 3348;

$queried_post = get_post($post_id);

$title = $queried_post->post_title;

echo $queried_post->post_content;

?>





        <?php the_content(); ?>

        

        

        

        

        

		<?php } elseif  (is_page('229') ) { ?>

		

		<? include TEMPLATEPATH."/login_form.php"; ?> 

        

        

		<?php } elseif  (is_page('5') ) { ?>

		<?php the_content(); ?>

        

        

        

        

        <?php } elseif  (is_page('79') ) { ?>

		

		<?php the_content(); ?>

        

       

        <?php } else{?>

        

        <?php the_content(); ?>

          

      

          

          

          

          <div id="blue-line"></div>



        <div class="comments-box">		

<?php comments_template( '/includes/comments.php'); ?>

</div><!--end comments-box-->
 
 <p style="font-size: 16px; font-family: 'Montserrat', sans-serif; color: #000000">This project generously underwritten by:</p>

<table width="200" border="1">
  <tbody>
    <tr>
      <td><a href="http://www.harvestpower.com/home/" target="_blank"><img style="margin-bottom: 20px;" src="https://compostingcouncil.org/wp-content/uploads/2017/09/Harvest-Logo.png" width="220" height="100" alt=""/></a></td>
      <td><a href="http://www.alexassoc.net/" target="_blank"><img src="https://compostingcouncil.org/wp-content/uploads/2017/02/ron-alexander-logo.jpg" width="163" height="133" alt=""/></a></td>
      <td><a href="https://www.mcgillcompost.com/" target="_blank"><img src="https://compostingcouncil.org/wp-content/uploads/2017/07/mcgill.png" width="220" height="110" alt=""/></a></td>
    </tr>
  </tbody>
</table> 
 
 <hr>

 <p style="font-size: 14px; font-family: 'Montserrat', sans-serif; color: #000000"><em>History compiled by Linda Norris-Waldt, USCC communications manager</em></p>
 
 <hr>
 
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
<p style="font-family: 'Helvetica Neue LT Std',Helvetica,Arial,sans-serif; font-size: 18px; font-weight: bolder; text-align: center;  line-height: 24px;"><a href="https://youtu.be/jc78AbMjWDQ?list=PLlotznzK3pOPfZPZ5PzumP4G0ZoxXDFl8" target="_blank"><img style="border:1px solid #bfdfeb; padding:2px;"
 src="https://compostingcouncil.org/wp-content/uploads/2017/08/see-movie.jpg" width="220" height="52" alt=""/></a></p>
 
 <a href="#unique-identifier"><img style="border:1px solid #bfdfeb; padding:2px;" src="https://compostingcouncil.org/wp-content/uploads/2017/09/blog-banner.jpg" width="220" height="92" alt=""/></a> 
 </div>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>











<?php } ?>