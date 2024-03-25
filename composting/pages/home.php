
<!-- News -->
   <div id="middle-header">Events</div>
  
  <?php $loop = new WP_Query( array( 'post_type' => 'events', 'posts_per_page' => 3 ) );
	while ( $loop->have_posts() ) : $loop->the_post();
	?>
		
        
	 <a title="View Full" href="<?php the_permalink(); ?>">
	 <div id="middleside">
	<div id="middle-date"><?php echo "".date("F j, Y",strtotime(get_post_meta($post->ID,'start',true))).""; ?></div>
		<div id="middle-main">
    <div id="middle-title" ><?php the_title(); ?></div>
	<?php the_excerpt(); ?>
    </div> 
    <div id="clear"></div>
	</div></a>
    
	<?php  endwhile; ?>
    <!-- end of news -->
     <a id="morelink" href="<?php bloginfo('url'); ?>/?page_id=46"> View All Events &gt;</a>
  <div id="clear"></div>

  
   
    
    
    
    
     <div id="middle-header">Press Releases</div>
    <?php $loop = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 10 ) );
	while ( $loop->have_posts() ) : $loop->the_post();
	if ('Press Release'==get_post_meta($id,'news_type',true)) { 
	?>
		
        
	 <a title="View Full" href="<?php the_permalink(); ?>">
	 <div id="middleside">
	<div id="middle-date"><?php the_date(); ?></div>
		<div id="middle-main">
    <div id="middle-title" ><?php the_title(); ?></div>
	<?php the_excerpt(); ?>
    </div> 
    <div id="clear"></div>
	</div></a>
    
	<?php } endwhile; ?>
    <!-- end of news -->
   <a id="morelink"  href="<?php bloginfo('url'); ?>/?page_id=48"> View All Press &gt;</a>
    <div id="clear"></div>
 
 
 
 
 <div id="middle-header">News</div>
	<!-- News Teaser -->
	<?php $loop = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 3 ) );
	while ( $loop->have_posts() ) : $loop->the_post();
	if ('News'==get_post_meta($id,'news_type',true)) { 
	?>
	
    <a title="View Full" href="<?php the_permalink(); ?>">
	 <div id="middleside">
	<div id="middle-date"><?php the_date(); ?></div>
	<div id="middle-main">
    <div id="middle-title" ><?php the_title(); ?></div>
	<?php the_excerpt(); ?>
    </div> 
    <div id="clear"></div>
	</div></a>
    
	<?php } endwhile; ?>
    <!-- end of news -->
    <a id="morelink" href="<?php bloginfo('url'); ?>/?page_id=206"> View All News &gt;
    </a>
    <div id="clear"></div>
    
 
 