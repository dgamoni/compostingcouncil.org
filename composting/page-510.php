<?php 
/* 
Template Name: Products Page
*/
?>

<?php 
get_header(); 
?>

<div id="container">
  <div id="clear"></div>
  <h1 class="entry-title">
    <?php the_title(); ?>test
  </h1>
  <div id="side-left" class="widget-area">
  <?php  include("sidebar/backtocart.php"); ?>
    <?php  include("sidebar/subpages.php"); ?>
  </div>
  
  
  <!--MIDDLE SECTION-->
  <div id="content" style="width:710px;">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post">
      <div class="entry-content" style="">
     
        <?php the_content(); ?>
      </div>
      <?php endwhile; ?>
    </div>
    <!--MIDDLE SECTION--> 
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
