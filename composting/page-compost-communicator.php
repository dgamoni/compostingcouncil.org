<?php 

/*

Template Name: Compost Communicator Media Kit
 
*/

?>



<?php



if (is_page('2') ) { ?>

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

        <?php } elseif  (is_page('64') ) { ?>

        <?php include(TEMPLATEPATH . '/pages/submit-job-wanted.php'); ?>
        

        <?php } else{?>


        <?php the_content(); ?>

          

          <div id="blue-line"></div>

 		 <?php include(TEMPLATEPATH . '/sidebar/social.php'); ?>

        <?php } ?>

      </div>

    </div>

    <?php endwhile; ?>

	<?php if (is_page(explode(',','18,28,22,57'))): ?>

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
<p> <a href="<?php bloginfo('url'); ?>/contact/"><img src="<?php bloginfo('url'); ?>/wp/wp-content/uploads/2014/05/Advertise-with-us-button.gif"  margin-bottom:10px;" /></a></p>
  </div>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>











<?php } ?>