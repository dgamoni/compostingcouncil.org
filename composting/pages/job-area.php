 	
<?php the_content(); ?>


<!--Job Offers-->
 	<div id="middle-header">Positions Available</div>

	
<!--start loop-->
    
	<?php $loop = new WP_Query( array( 'post_type' => 'joboffers', 'posts_per_page' => 10 ) );
	while ( $loop->have_posts() ) : $loop->the_post(); { ?>


	

		<a title="View Full" href="<?php the_permalink(); ?>">	
 		<div id="middleside" style="padding-bottom:10px;" >
		  <div style="width:425px; float:left;">
    	<div id="middle-title"  style="margin-bottom:7px;"  ><?php the_title(); ?></div>
        
		<div style="width:200px; margin-right:20px; float:left;" >
        
       <strong>Posted:</strong>  <?php the_time('F j, Y') ?><br />

          <?php  echo "<strong>Deadline:</strong> ".date("F j, Y",strtotime(get_post_meta($post->ID,'deadline',true)))."<br>";  ?>
          </div>
          
          <div style="width:200px; float:left;">
          <?php echo "<strong>Company:</strong> ".get_post_meta($id,'company',true)."<br>"; ?> <?php echo "<strong>Location:</strong> ".get_post_meta($id,'location',true)."<br>"; ?> </div>
          
          </div>
        
        
    	
    	<div id="clear"></div>
		</div>
    </a>
		<?php } endwhile; ?>
    
   

    
    <!-- end of job -->
  
  
  



<!--Job Wanted-->
 	<div id="middle-header" style="margin-top:7px;">Positions Sought</div>

	
<!--start loop-->
    
	<?php $loop = new WP_Query( array( 'post_type' => 'jobswanted', 'posts_per_page' => 10 ) );
	while ( $loop->have_posts() ) : $loop->the_post(); { ?>



	
		   <a title="View Full" href="<?php the_permalink(); ?>">	
 		<div id="middleside" style="padding-bottom:10px;" >
		  <div style="width:425px; float:left;">
    	<div id="middle-title" style="margin-bottom:15px;" ><?php the_title(); ?></div>
        
        
		

		
        <div style="width:200px; margin-right:20px; float:left;">
		 <strong>Posted:</strong>  <?php the_time('F j, Y') ?><br />
		<?php  echo "<strong>Deadline:</strong> ".date("F, j Y",strtotime(get_post_meta($post->ID,'deadline',true)))."<br>"; ?>
		</div>
          
		<div style="width:200px;float:left;">
		<?php echo "<strong>Company:</strong> ".get_post_meta($id,'company',true)."<br>"; ?> <?php echo "<strong>Location:</strong> ".get_post_meta($id,'location',true)."<br>"; ?> </div>
        </div>
        
    	
    	<div id="clear"></div>
		</div>
    </a>
	<?php } endwhile; ?>
    <!-- end of job -->
 
 
 
 
<div id="warning-box-wrapper"><div id="warning-box">
<a href="http://compostingcouncil.org/job-bank-form/" target="_blank">Post a Job Wanted Ad</a><br />

<a href="http://compostingcouncil.org/job-bank-form/" target="_blank">Post a Job Offer Ad</a></div></div> 