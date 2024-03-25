<?php get_header(); ?>
<div id="container">

<h1 class="entry-title">Resources</h1>

<div id="side-left" class="widget-area">
  <div id="subpage-list">
<div id="sub-back-wrapper" >
<div id="sub-back">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("homesub") ) : ?>
<?php endif; ?>

</div>
</div>
</div>


 </div>
 
  <!--MIDDLE SECTION-->
	<div id="content">
  <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
    <div id="post">
      <div class="entry-content">
	



        
        
        <div id="middle-header"><?php $post_categories = wp_get_object_terms($id, 'resources_category');
					foreach($post_categories as $c) echo $c->name;?></div>
		<?php get_post_meta($id,'access',true); ?>
		   
		
			
	 <div id="middleside">
	<div id="middle-date" style="float:right;">
	
    
           
    <!--attachment-->	
        <?php  $args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $id ); 
		$attachments = get_posts($args);
		if ($attachments) {
		foreach ($attachments as $attachment) { ?>
        <!--styleing-->
		<div id="hot-download-icon"><img src="<?php bloginfo("template_url") ?>/images/icons/com-download.png" /></div>
        
        <a href="<?php echo wp_get_attachment_url($attachment->ID, true ); ?>" target="_blank">		
        
        <span id="hot-download" style="line-height:11px; padding-right:17px; margin-right:2px;">
		<span style="font-size:9px;">download <br />
attachment</span></span></a>
        <!--styleing-->
		<?php	} } ?>
		<!--end attachment-->	
	
	</div>
		<div id="middle-main">
    <div id="middle-title" ><?php the_title(); ?></div>
	<?php the_content(); ?>
    
 
    </div> 
    <div id="clear"></div>
	</div>





 
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
