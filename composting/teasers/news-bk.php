  
  
  
  <!-- News -->
    <?php
	$loop = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 10 ) );
	while ( $loop->have_posts() ) : $loop->the_post();
	
		$type = get_post_meta($id,'news_type',true); if (!$type) $type="News";

		echo $type.':'; the_title();
		echo '<div class="entry-content">';
		 the_date(); 
		the_content();

		$args = array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $id
			);
		$attachments = get_posts($args);
		if ($attachments) {
			
			foreach ($attachments as $attachment) {
				echo "<div class='alignleft' style='margin:10px'><div class='alignleft'>";
				
				the_attachment_link($attachment->ID, false);
				echo "</div><span class='clear alignleft'>{$attachment->post_content}</span>";
				 
				

				echo "</div>";
			}
			echo "<div class='clear'></div>";
		}

		echo '</div>';
	
	
	endwhile;
	?>
    <!-- end of news -->