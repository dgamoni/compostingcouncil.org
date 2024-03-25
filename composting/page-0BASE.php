<?php 
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
  <div id="content" style="width:710px;">
    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post">
      <div class="entry-content" style="">
        <div id="side-right" class="widget-area" style="float:right; margin-right:-58px; margin-left:10px;">
          <?php  include("sidebar/sidebar-right-over.php"); ?>
        </div>
        <?php the_content(); ?>
      </div>
      <?php endwhile; ?>
    </div>
    <!--MIDDLE SECTION--> 
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
