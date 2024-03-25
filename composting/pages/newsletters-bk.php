<div id="middle-header">Current Newsletter</div>
 <?php if (is_user_logged_in()){ ?>


  
<?php $loop = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 1 ) );
	while ( $loop->have_posts() ) : $loop->the_post();
	if ('Newsletter'==get_post_meta($id,'news_type',true)) 
	{ ?>
		
        
	 <a title="View Full" href="<?php the_permalink(); ?>">
	 
     <div id="middleside">
		<div id="middle-date"><?php the_date(); ?></div>
		<div id="middle-main">
    		<div id="middle-title" ><?php the_title(); ?></div>
			<?php the_excerpt(); ?>
    	</div> 
    	<div id="clear"></div>
	</div>
    </a>
    <div id="spacer-add"></div>
	<?php } endwhile; ?>
    <!-- end of news -->
  

<?php } else { ?>
<div id="warning-box-wrapper"><div id="warning-box">Only members may view the current newsletter. If you are a member, please log in.</div></div>

<?php }; ?>
  
<div id="clear"></div>





<div id="middle-header">Archived Newsletters</div>


<?php $loop = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 100, 'offset' => '1' ) );
		
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
	
	 <div id="middleside">
	<div id="middle-date"><?php the_date(); ?></div>
	<div id="middle-main">
    <div id="middle-title" style="margin-bottom:5px;" ><?php the_title(); ?></div>
    
    </div> 
    <div id="clear"></div>
	</div></a>
    
	<?php } endwhile; ?>
    <!-- end of news -->
  
  
  
  
  
  
  

    
  
 