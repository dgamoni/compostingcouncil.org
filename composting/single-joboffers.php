<?php get_header(); ?>

<div id="container">
  <h1 class="entry-title">Job Offers Page</h1>
  <div id="side-left" class="widget-area">

        <?php  include("sidebar/network.php"); ?>

  </div>
  <!--MIDDLE SECTION-->
  <div id="content">
   <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <div id="post">
      <div class="entry-content">
        
         
   
        
        
        
         <h1><?php the_title(); ?></h1>
        <div style="font-size:14px; margin-bottom:14px;">
           <strong>Posted:</strong>  <?php the_time('F j, Y') ?><br />
          <?php  echo "<strong>Deadline:</strong> ".date("F j, Y",strtotime(get_post_meta($post->ID,'deadline',true)))."<br>"; ?>
          <?php echo "<strong>Company:</strong> ".get_post_meta($id,'company',true)."<br>"; ?> <?php echo "<strong>Location:</strong> ".get_post_meta($id,'location',true)."<br>"; ?> </div>
       
       
        <?php the_content(); ?>
         <?php  echo "Reference #: ".get_post_meta($id,'refnum',true)."<br>"; ?>
        <br />
        
        
        <?php echo "<strong>Contact Info:</strong> ".get_post_meta($id,'contactinfo',true)."<br>"; ?>
        
        
        
        
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
        <br />
        <br />
        <div id="hot-download-icon"><img src="<?php bloginfo("template_url") ?>/images/icons/com-download.png" /></div>
        <a href="<?php echo wp_get_attachment_url($attachment->ID, true ); ?>" target="_blank"> <span id="hot-download" style="line-height:14px;"><?php echo $attachment->post_content; ?><br />
        <span style="font-size:9px; line-height:14px;">download attachment</span></span> </a><br />
        <?php	
				}
			}
		?>
        <!--end attachment-->
	 </div>
    </div>
    <?php endwhile; ?>
  </div>
  <!--MIDDLE SECTION-->
        
        
        
        
        
        
        
        
        
        
    
  
  <!--MIDDLE SECTION-->
  <div id="side-right" class="widget-area">
    <?php  include("sidebar/sidebar-right-noad.php"); ?>
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
