
<?php get_header(); ?>

<div id="container">
<div id="clear"></div>
<h1 class="entry-title">Search</h1>


  <div id="side-left" class="widget-area">
  

	<?php  include("sidebar/subpages.php"); ?>
 
  
  </div>
 
 
 
  <!--MIDDLE SECTION-->
	<div id="content">

	
    <div id="post">
      <div class="entry-content">
	
	










			


           <div id="middle-header">      <?php printf( __( 'Search Results for: %s', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?></DIV><br />




<?php if ( have_posts() ) : ?>    
 
<?php while ( have_posts() ) : the_post() ?>
<?php global $wp_query; $total_results = $wp_query->found_posts; ?>


  
	 <a title="View Full" href="<?php the_permalink(); ?>">
	 <div id="middleside">
	
	<div style="float:left;">
    <div id="middle-title" ><?php the_title(); ?></div>
	<?php the_excerpt(); ?>
    </div> 
    <div id="clear"></div>
	</div></a>
    






<?php endwhile; ?>
 
<?php else : ?>
 
<div id="post-0" class="post no-results not-found">
					<h1><?php _e( 'Nothing Found', 'twentyten' ); ?></h1>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
 
<?php endif; ?>   



		
	


                
                 
 
  

		
    



        
	
        
        
        
        
      </div>
    </div>

</div>
  <!--MIDDLE SECTION-->
<div id="side-right" class="widget-area">

<?php  include("sidebar/sidebar-right.php"); ?>

</div>
  
  
  
   
  
  
  
  
  
  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>

















