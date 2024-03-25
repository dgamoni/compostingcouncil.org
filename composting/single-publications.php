<?php


get_header(); ?>

<div id="container">

<h1 class="entry-title"><?php the_title(); ?>
</h1>


  <div id="side-left" class="widget-area">
  
 <?php  include("sidebar/cart.php"); ?>
	   <? include TEMPLATEPATH."/login_form.php"; ?> 
 
  
  </div>
 
 
 
  <!--MIDDLE SECTION-->
	<div id="content">
  <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	
    <div id="post">
      <div class="entry-content">
	
 <div id="side-right" class="widget-area" style="float:right; margin-right:-58px; margin-left:10px;">
    <?php  include("sidebar/sidebar-right-over.php"); ?>
  </div>



	<?php // here an example for all custom type posts:

	switch ($post->post_type) {
		
		case 'publications':
			$post_categories = wp_get_object_terms($id, 'publications_category');
			echo "Category: ";
				foreach($post_categories as $c) echo $c->name;
			echo "<br>";
			echo "Member price: $".get_post_meta($id,'member',true)."<br>";
			echo "Non-Member price: $".get_post_meta($id,'non_member',true)."<br>";
			$product_id = get_post_meta($id,'memeber_product_id',true);
			if ($product_id) { ?>
				<form id='product_<?php echo $product_id; ?>' name='product_<?php echo $product_id; ?>' method='post' action='<?php echo get_option('product_list_url'); ?>' onsubmit='submitform(this);return false;' >
				<input type='hidden' value='add_to_cart' name='wpsc_ajax_action' />
				<input type='hidden' value='1' name='quantity' />
				<input type='hidden' value='<?php echo $product_id; ?>' name='product_id'/>
				<input type='submit' style="margin:10px;" id='product_<?php echo $product_id; ?>_submit_button' class='wpsc_buy_button' name='Buy' value='<?php echo __('Buy for memebers').' - '.get_post_meta($id,'member',true); ?>'  />
				</form>
			<?php
			}
			$product_id = get_post_meta($id,'non_memeber_product_id',true);
			if ($product_id) { ?>
				<form id='product_<?php echo $product_id; ?>' name='product_<?php echo $product_id; ?>' method='post' action='<?php echo get_option('product_list_url'); ?>' onsubmit='submitform(this);return false;' >
				<input type='hidden' value='add_to_cart' name='wpsc_ajax_action' />
				<input type='hidden' value='1' name='quantity' />
				<input type='hidden' value='<?php echo $product_id; ?>' name='product_id'/>
				<input type='submit' style="margin:10px;clear:both;" id='product_<?php echo $product_id; ?>_submit_button' class='wpsc_buy_button' name='Buy' value='<?php echo __('Buy for non-memebers').' - '.get_post_meta($id,'non_member',true); ?>'  />
				</form>
				&nbsp;
			<?php
			
			}
			?>
				<br/>
				<div id='loadingindicator'>
					<img title="Loading" alt="Loading" src="<?php echo WPSC_URL ;?>/images/indicator.gif" id="loadingimage" />
				<?php _e('Updating cart...', 'wpsc'); ?>
				</div>
				<br/>
			<?php
			break;

		default: break;
	}

	// attahcments
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

	?>

		<?php
			echo "<h3 style='margin-top:12px;'>"; the_title();
			echo "</h3>";
			echo "<h3>"; the_content();
			echo "</h3><br/>";
		?>
	

        
	
        
        
        
        
      </div>
    </div>
    <?php endwhile; ?>
</div>
  <!--MIDDLE SECTION-->

  
  
   
  
  
  
  
  
  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>




        
	