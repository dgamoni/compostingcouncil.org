<?php get_header(); ?>

<div id="container">

<h1 class="entry-title">Events</h1>

<div id="side-left" class="widget-area">
  <?php  include("sidebar/news.php"); ?>
 </div>
 
  <!--MIDDLE SECTION-->
	<div id="content">
  <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
    <div id="post">
      <div class="entry-content">
	

<h2><?php the_title(); ?></h2>

		




  
      
        



    
  <?php   
			echo "<strong>Location:</strong> ".get_post_meta($post->ID,'location',true)."<br>";
			echo "<strong>Start Date:</strong> ".date("F j Y",strtotime(get_post_meta($post->ID,'start',true)))."<br>";
			echo "<strong>End Date:</strong> ".date("F j Y",strtotime(get_post_meta($post->ID,'deadline',true)))."<br>";
			echo "<strong>Contact:</strong> ".get_post_meta($post->ID,'contact',true)."<br>";
			echo "<strong>Category:</strong> ".get_post_meta($post->ID,'category',true)."<br>";
			
			

     ?>




<br />

	<?php the_content(); ?>
   
         	
        
        
<div id="hot-download-icon"><img src="<?php bloginfo("template_url") ?>/images/icons/com-download.png" /></div>
			<a href="<?php echo get_post_meta($post->ID, 'url', true); ?>" target="_blank">		
        	<span id="hot-download" style="line-height:14px;"><?php echo get_post_meta($post->ID, 'teaser', true) ?><br />
<span style="font-size:9px; line-height:14px;">event link</span></span>
        	</a>
        <br />
<br />


		<!--end attachment-->	
        <div id="blue-line" style="margin-top:10px;"></div>
      <?php include(TEMPLATEPATH . '/sidebar/social.php'); ?>
        
      </div>
    </div>
    <?php endwhile; ?>
</div>
  <!--MIDDLE SECTION-->
<div id="side-right" class="widget-area">

 <?php  include("sidebar/sidebar-right-noad.php"); ?>

</div>
  
  
  
   
  
  
  
  
  
  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
