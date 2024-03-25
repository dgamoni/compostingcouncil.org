<!-- Events -->
 <div id="middle-header">ICAW Events</div>
	
	
	
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
			'order' => 'DESC',
			'suppress_filters'=> false,						
			 ) );
		while ( $loop->have_posts() ) : $loop->the_post(); 
		if ('ICAW'==get_post_meta($id,'category',true)) { 
		?>

      
        
<a title="View Full" href="<?php the_permalink(); ?>">
<div id="middleside">
	<div id="middle-date"><?php the_title(); ?></div>
		<div id="middle-main">
    <div id="middle-title" ></div>
    
  <?php   
			echo "Location: ".get_post_meta($post->ID,'location',true)."<br>";
			echo "Start Date: ".date("F j Y",strtotime(get_post_meta($post->ID,'start',true)))."<br>";
			echo "End Date: ".date("F j Y",strtotime(get_post_meta($post->ID,'deadline',true)))."<br>";
	
			echo "Category: ".get_post_meta($post->ID,'category',true)."<br>";
			

     ?>

	<?php the_excerpt(); ?>
    </div> 
    <div id="clear"></div>
</div></a>
    
	<?php } endwhile; ?>
    <!-- end of news -->






<br />
<br />

<?php if (is_user_logged_in()){ ?>
<div id="warning-box-wrapper"><div id="warning-box"><a href="<?php get_bloginfo('url') ?>/?page_id=22584">Add New Event</a></div></div>


<?php } else { ?>
<div id="warning-box-wrapper"><div id="warning-box"><a href="http://compostingcouncil.org/add-icaw-event/" title="Add Event" style="font-size: 14px"> Add Event Here</a></div></div>

<?php }; ?>