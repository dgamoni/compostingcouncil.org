<?php get_header(); ?>

<div id="container">

<h1 class="entry-title"><?php the_title(); ?></h1>


  <div id="side-left" class="widget-area">
  

	<?php  include("sidebar/subpages.php"); ?>
 
  
  </div>
 
 
 
  <!--MIDDLE SECTION-->
	<div id="content">
  <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
    <div id="post">
      <div class="entry-content">
	
	default sinlgle page

		<?php the_content(); ?>
	

        
	
        
        
        
          <div>		
		// wordpress function that loads the comments template "comments.php" 
<?php comments_template( '/includes/comments.php'); ?>

</div><!--end inner_box-->

      </div>
    </div>
    <?php endwhile; ?>
</div>
  <!--MIDDLE SECTION-->
<div id="side-right" class="widget-area">

<?php  include("sidebar/sidebar-right.php"); ?>

</div>
  
  
  
   
  
  
  
  
  
  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
