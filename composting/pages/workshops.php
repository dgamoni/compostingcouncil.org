


<?php the_content(); ?>









<!--Resource Content-->

    
	<?php $loop = new WP_Query( array( 'post_type' => 'workshops', 'posts_per_page' => 20 ) );
	while ( $loop->have_posts() ) : $loop->the_post(); { ?>
		<br />


		
		   
		
			
 		<div id="middleside">
		<div style="width:425px; float:left;">
    	<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
        
        	<div id="dotline"></div>
        <div style="float:left; width:190px; font-size:11px;">
        
      
        	 <?php echo "<strong>Start Time:</strong> ".get_post_meta($id,'start_time',true)."<br>"; ?> 
         <?php echo "<strong>End Time:</strong> ".get_post_meta($id,'end_time',true)."<br>"; ?> 
            <?php echo "<strong>Max Attendees: </strong>".get_post_meta($id,'attends',true)."<br>"; ?> 
         
        </div>
        
        
        <div style="float:left; width:190px;font-size:11px;">

           <?php echo "<strong>Member Price:</strong> $".get_post_meta($id,'member',true)."<br>"; ?> 
         <?php echo "<strong>Non-Member Price:</strong> $".get_post_meta($id,'non_member',true)."<br>"; ?> 
        </div>

<div id="dotline"></div>



          <em><p> <?php echo "<strong>Instructor(s):</strong> ".get_post_meta($id,'bios',true)."<br>"; ?> </p></em>
		 
	<br />

         
     
  
        
    	</div> 
    	<div id="clear"></div>
		</div>
    
	<?php } endwhile; ?>
    <!-- end of news -->
  
 
 

 
 
 