
<!-- News -->
  
    <div id="middle-header">News</div>
	<!-- News Teaser -->
	<?php $loop = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 10 ) );
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
     <a style="float:right;" href="<?php bloginfo('url'); ?>/?page_id=206"> View All News &gt;</a>
  <div id="clear"></div>
   
   <br />


   
   
   
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
     <a style="float:right;" href="<?php bloginfo('url'); ?>/?page_id=48"> View All Press &gt;</a>
 <div id="clear"></div>
 <br />

 
 
 
 
  <div id="middle-header">Events</div>
 <?php 
	if (isset($_GET['new'])) 
		$loop = new WP_Query( array( 'post_type' => 'events',
			'page_id' => esc_attr($_GET['new']),
			'post_status' => 'any',
			 ) );
	else $loop = new WP_Query( array( 'post_type' => 'events',
			'nopaging' => true,
			'post_status' => 'publish',
			'meta_key' => 'start',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'suppress_filters'=> false,						
			 ) );
		while ( $loop->have_posts() ) : $loop->the_post(); { 
		?>

      
        
<a title="View Full" href="<?php the_permalink(); ?>">
<div id="middleside">
	<div id="middle-date"><?php the_title(); ?></div>
		<div id="middle-main">
    <div id="middle-title" ></div>
    
  <?php   
			echo "Location: ".get_post_meta($post->ID,'location',true)."<br>";
			echo "Start Date: ".date("F j, Y",strtotime(get_post_meta($post->ID,'start',true)))."<br>";
			echo "End Date: ".date("F j, Y",strtotime(get_post_meta($post->ID,'deadline',true)))."<br>";
	
			echo "Category: ".get_post_meta($post->ID,'category',true)."<br>";
			

     ?>

	<?php the_excerpt(); ?>
    </div> 
    <div id="clear"></div>
</div></a>
    
	<?php } endwhile; ?>
    <!-- end of news -->


  
    <a style="float:right;" href="<?php bloginfo('url'); ?>/?page_id=46"> View All Events &gt;</a>
  
  
  <br />

  
  
  
  
  

  
  
  
  
  
