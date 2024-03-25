<?php get_header(); ?>

<div id="container">

<h1 class="entry-title"><?php the_title(); ?></h1>


  <div id="side-left" class="widget-area" style="height:739px;">
  

	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('events_sidebar') ) : ?>
	<?php endif; ?>
 
  
  </div>
 
 
 
  <!--MIDDLE SECTION-->
	<div id="content">

	<?php
	$loop = get_posts(array(
			'post_type' => 'events',
			'numberposts' => -1,
			'post_status' => 'publish',
			'meta_key' => 'start',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'suppress_filters'=> false,
			));
	if ($loop) {
		foreach ($loop as $post) {
			echo '<div class="entry-content">';
			echo "Location: ".get_post_meta($post->ID,'location',true)."<br>";
			echo "Start Date: ".get_post_meta($post->ID,'start',true)."<br>";
			echo "End Date: ".get_post_meta($post->ID,'deadline',true)."<br>";
			echo "Contact: ".get_post_meta($post->ID,'contact',true)."<br>";
			echo "Training: ".get_post_meta($post->ID,'training',true)."<br>";
			echo "Category: ".get_post_meta($post->ID,'category',true)."<br>";
			
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
