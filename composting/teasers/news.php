
<div id="sub-back-wrapper" style="" >  
   <div id="sub-back">
<div id="member-box-title" style="color:#284460; margin-bottom:5px;"> Recent News  
    </div>
    
    

     <?php wp_reset_query(); ?>
	<!-- News Teaser -->
	<?php $loop = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 3 ) );
	while ( $loop->have_posts() ) : $loop->the_post();
	if ('News'==get_post_meta($id,'news_type',true)) { 
	?>
		
        
	<a title="View Full" href="<?php the_permalink(); ?>">
   <div id="member-line" style=" margin:0px; border-top:1px solid #BFDFEB; background-color:#F1F7FA;"></div>
    <div class="homenews" style=" padding-top:4px; padding-bottom:3px; font-size:11px;">
	<div style=" font-size:12px; line-height:16px;"><?php the_title(); ?></div>

		
	<div style="font-size:11px; margin-top:-1px; color:#6BB6D1;  font-style:italic;" ><?php the_date(); ?></div>
	
	</div>
    </a>
	
	
	<?php } endwhile; ?>
    <!-- end of news -->
  </div></div>
