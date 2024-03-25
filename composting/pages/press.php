 <div id="middle-header">Press Releases</div>
    <?php $loop = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 100 ) );
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
  
 