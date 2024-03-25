<?php get_header(); ?>
<div id="container">

<h1 class="entry-title">News</h1>

<div id="side-left" class="widget-area">
  <?php  include("sidebar/home.php"); ?>
 </div>
 
 
 
  <!--MIDDLE SECTION-->
	<div id="content">
  <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
    <div id="post">
      <div class="entry-content">
	

<h1 style="font-size:20px; margin-bottom:0px"><?php the_title(); ?></h1>
<div id="news-date"><?php the_date();  ?></div>	
      <?php the_content(); ?>  
	
<?php
	echo get_post_meta($post->ID, 'url', true).'<br/>';
	echo get_post_meta($post->ID, 'teaser', true).'<br/>';
?>
    
     	
 <!--attachment-->	
        <?php  $args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $id
			);
		
		$attachments = get_posts($args);
		if ($attachments) {
			
			foreach ($attachments as $attachment) { ?>
				



			<div id="hot-download-icon"><img src="<?php bloginfo("template_url") ?>/images/icons/com-download.png" /></div>
			<a href="<?php echo wp_get_attachment_url($attachment->ID, true ); ?>" target="_blank">		
        	<span id="hot-download" style="line-height:14px;"><?php echo $attachment->post_content; ?><br />
<span style="font-size:9px; line-height:14px;">download attachment</span></span>
        	</a>
        
<?php	
				}
			}
		?>
		<!--end attachment-->
<div id="clear"></div><br />
<br />
<br />

        <div id="blue-line" style="margin-top:20px;"></div>
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
