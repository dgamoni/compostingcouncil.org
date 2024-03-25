<?php 

wp_enqueue_style('forms_styles', get_template_directory_uri().'/form.css');
wp_enqueue_script('forms_scrypt', get_template_directory_uri().'/js/forms.js');
get_header(); ?>

<div id="container">
<div id="clear"></div>
<h1 class="entry-title"><?php the_title(); ?></h1>


  <div id="side-left" class="widget-area">
  

	<?php  include("sidebar/subpages.php"); ?>
 
  
  </div>
 
 
 
  <!--MIDDLE SECTION-->
	<div id="content">
  <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
    <div id="post">
      <div class="entry-content">
	
	
	<!--content redirections -->
		<?php echo do_shortcode($post->post_content); ?>
        
      </div>
    </div>
    <?php endwhile; ?>
	<script type="text/javascript">
	//<![CDATA[
	(function($) {
	$(document).ready(function() {
		forms_init('registration');
	});
	})(jQuery);
	//]]>
	</script>

</div>
  <!--MIDDLE SECTION-->
<div id="side-right" class="widget-area">

<?php  include("sidebar/sidebar-right.php"); ?>

</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
