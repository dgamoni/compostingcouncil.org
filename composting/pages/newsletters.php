<div id="middle-header">Newsletter</div>
 
  


<?php $loop = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 300 ) );
		
	while ( $loop->have_posts() ) : $loop->the_post();
	if ('Newsletter'==get_post_meta($id,'news_type',true)) { ?>
		
		 
		
     <a title="Download PDF" href="<?php  $args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $id
			);
		
		$attachments = get_posts($args);
		if ($attachments) {
			
			foreach ($attachments as $attachment) { 
			echo wp_get_attachment_url($attachment->ID, true );
			
		} } ?>" target="_blank">		   
	
	 <div id="middleside" style="padding:7px 0px 2px 0px" >
	<div id="middle-date" style="width:30px;">
    
      <img src="<?php echo get_template_directory(); ?>/images/icons/pdf.png" width="13" height="15" /></div>
	<div id="middle-main">
    <div id="middle-title" style="margin-bottom:5px;" ><?php the_title(); ?></div>
    
    </div> 
    <div id="clear"></div>
	</div></a>
    
	<?php } endwhile; ?>
    <!-- end of news -->
  
  
  
  
  
  
  

    
  
 