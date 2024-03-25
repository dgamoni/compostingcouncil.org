<?php get_header(); ?>

<div id="container">

<h1 class="entry-title"><?php the_title(); ?></h1>


  <div id="side-left" class="widget-area" style="height:739px;">
  

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('resources_sidebar') ) : ?>
	<?php endif; ?>
 
  
  </div>
 
 
 
  <!--MIDDLE SECTION-->
	<div id="content">

	<?php
	$loop_args = array(
			'post_type' => 'resources',
			'numberposts' => -1,
			'post_status' => 'publish',
//			'meta_key' => 'start',
//			'orderby' => 'meta_value',
//			'order' => 'ASC',
			'suppress_filters'=> false,
			);
	if (isset($_REQUEST['resources_category'])) {
		$loop_args['tag'] = esc_attr($_REQUEST['resources_category']);
	}
	if (isset($_REQUEST['cat'])) {
		$loop_args['tag__in'] = array(esc_attr($_REQUEST['cat']));
	}
	$loop = get_posts($loop_args);
	if ($loop) {
		foreach ($loop as $post) {
			$id = $post->ID;

			echo '<div class="entry-content">';
			echo "Access: ".get_post_meta($post->ID,'access',true)."<br>";
			$post_categories = wp_get_object_terms($post->ID, 'resources_category');
			echo "Category: ";
				foreach($post_categories as $c) echo $c->name."<br>";
			
			// attahcments
			$args = array(
				'post_type' => 'attachment',
				'numberposts' => -1,
				'post_status' => null,
				'post_parent' => $post->ID
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

			echo "<br>title:".$post->post_title;
			echo "<br>content:".$post->post_content;

			echo '</div>';
		}
	}
	?>
	</div>
  <!--MIDDLE SECTION-->
<div id="side-right" class="widget-area">

<? include TEMPLATEPATH."/login_form.php"; ?>

<ul>
	<li id="search" class="widget-container widget_search">
		<?php get_search_form(); ?>
	</li>
</ul>

</div>
  
  
  
   
  
  
  
  
  
  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
