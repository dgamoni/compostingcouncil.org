<!-- Events -->

<iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=compostingcouncil%40gmail.com&amp;color=%23182C57&amp;ctz=America%2FNew_York" style=" border-width:0 " width="750" height="400" frameborder="0" scrolling="no"></iframe>



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

//echo __FILE__.__LINE__.'<br/>';
while ( $loop->have_posts() ) : $loop->the_post(); {
//            echo __FILE__.__LINE__.'<br/>';
		?>

      



 <?php  $expirationtime = get_post_custom_values('deadline');

//    print_r(  $expirationtime);
         if (is_array($expirationtime)) {
             $expirestring = implode($expirationtime);
         }

//    echo $expirestring;

         $secondsbetween = strtotime($expirestring)-strtotime(date('y-m-d'));
         if ( $secondsbetween >= 0 ) {
//             echo 'ss' ;
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

            <br />
            <br />



            <div id="hot-download-icon"><img src="<?php bloginfo("template_url") ?>/images/icons/com-download.png" /></div>
			<a href='<?php bloginfo('url'); ?>/admin/wp-content/plugins/as-pdf/generate.php?post=<?=$post->ID?>' target="_blank">
        	<span id="hot-download" style="line-height:14px;"><?php the_title(); ?><br />
<span style="font-size:9px; line-height:14px;">Download PDF</span></span>
        	</a>
<br />
<br />
<br />

    </div>

    <div id="clear"></div>
</div></a>
    
    
    
    <?php }  ?>
    
    
    
	<?php } endwhile; ?>
    <!-- end of news -->






<br />
<br />


<div id="warning-box-wrapper"><div id="warning-box"><a href="<?php get_bloginfo('url') ?>/admin/?page_id=674">Add New Event</a></div></div>












