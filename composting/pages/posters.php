
<?php the_content(); ?>


















<div id="middle-header">Posters</div>
   
   
   
   
   
   
   
   
<?php $loop = new WP_Query( array( 'post_type' => 'poster', 'posts_per_page' => 10 ) );
	while ( $loop->have_posts() ) : $loop->the_post();
	 
	?>
		
        

	 <div id="middleside" style="width:140px; background-color: #EAF1F2; border: 1px solid #E1EAEC; padding:5px; margin:5px; height:280px; float:left;">
		
		
		
		
		<?php   // attahcments
	$args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,
		'post_status' => null,
		'post_parent' => $id
		);
	$attachments = get_posts($args);
	if ($attachments) { 
	foreach ($attachments as $attachment) { 
	
	?>
       <a rel="lightbox" href="<?php echo wp_get_attachment_url($attachment->ID, true ); ?>"><img style="border:1px solid #D9E2E6; padding:0px "  src=" <?php echo wp_get_attachment_url($attachment->ID, true ); ?>" width="140" /></a>
	
<?php
		
		}
	}
    ?>
    

    
	<div id="middle-title" style="margin-top:4px; margin-bottom:0px;" ><?php the_title(); ?></div>

	<div style="font-size:11px; line-height:13px;" ><?php the_excerpt(); ?></div>

   
   </div><?php  endwhile; ?>
    <!-- end of news -->
  
 
 
 
 
   <div id="blue-line"></div>
        <?php include(TEMPLATEPATH . '/sidebar/social.php'); ?>
 
 
 
 
 
 