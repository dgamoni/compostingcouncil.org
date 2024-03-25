<?php the_content(); ?>






<?php

$url = preg_replace('/&category=[^&]*/','',$_SERVER['REQUEST_URI']);
$cats = get_terms('publications_category','hide_empty=1&orderby=slug&order=ASC');
foreach($cats as $c) {
	echo "<a href='?category=all&category={$c->slug}' >{$c->name}</a><br />";
}
echo "<br />";

if (isset($_GET['category'])) {
	$cats = array(0 => get_term_by('slug',esc_attr($_GET['category']), 'publications_category'));
}

foreach($cats as $c):
	echo "<div id=\"middle-header\"><a href='$url&category={$c->slug}' >{$c->name}</a></div>";

	$query_vars = array(
		'post_type' => 'publications',
		'posts_per_page' => 100,
		'taxonomy' => 'publications_category',
		'term' => $c->slug,
	);
	$loop = new WP_Query( $query_vars );

    
	while ( $loop->have_posts() ) : $loop->the_post(); { ?>

<br />



<div id="middleside">

<?php
 		$args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,
		'post_status' => null,
		'post_parent' => $id
		);
		$attachments = get_posts($args);
	    if ($attachments) {
		foreach ($attachments as $attachment) { 
		?>
		
        <img style="border:1px solid #bfdfeb;padding:2px; float:left " src="<?php echo wp_get_attachment_url($attachment->ID, true ); ?>" width="150" />
		<?php	} } ?>
 

 	<?php if ($attachments) { ?>
	<div id="middle-main2" style="float:right; width:310px;">
	<?php	} else { ?>
	<div id="middle-main2" style=" margin-left:5px; width:480px;">
	<?php	} ?>
 
  
  
    <div id="middle-title" >
      <?php the_title(); ?>
    </div>
    <?php the_content(); ?>
    <br />
    
    
    
    
    
    
         <?php if (is_user_logged_in() && (current_user_can('administrator'))){ ?>


	 <?php } else {
            ?>
     
       <div id="member-box-wrapper" style="width:190px;float:right; text-align:right;">
  <div id="member-box" style="height:45px; ">
  
        <div id="clear"></div>
    <?php $product_id = get_post_meta($id,'non_memeber_product_id',true);  ?>
    <?php	if ($product_id) { ?>
    <form id='product_<?php echo $product_id; ?>' name='product_<?php echo $product_id; ?>' method='post' action='<?php echo get_option('product_list_url'); ?>' onsubmit='submitform(this);return false;' >
      <input type='hidden' value='add_to_cart' name='wpsc_ajax_action' />
      <input type='hidden' value='1' name='quantity' />
      <input type='hidden' value='<?php echo $product_id; ?>' name='product_id'/>
      <?php echo "<div style=''><strong>Non-Member price: </strong> $".get_post_meta($id,'non_member',true)." </div>"; ?>
      <input type='submit' style=" float:right;" id='product_<?php echo $product_id; ?>_submit_button' class='wpsc_buy_button' name='Buy' value='Add to Cart' />
    </form>
    
    <?php
  } ?>
    
    
    </div></div>
    
     <?php  }  ?>
     
     
     
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <?php if (is_user_logged_in() && (current_user_can('administrator'))){

            ?>

      <div id="member-box-wrapper" style="width:190px;float:right; text-align:right;">
  <div id="member-box" style="height:45px; ">
      
	  <?php $product_id = get_post_meta($id,'memeber_product_id',true);  ?>
 <?php	if ($product_id) { ?>
    <form id='product_<?php echo $product_id; ?>' name='product_<?php echo $product_id; ?>' method='post' action='<?php echo get_option('product_list_url'); ?>' onsubmit='submitform(this);return false;' >
      <?php   echo "<div style=''><strong>Member price: </strong> $".get_post_meta($id,'member',true)."</div> "; ?>
      <input type='hidden' value='add_to_cart' name='wpsc_ajax_action' />
      <input type='hidden' value='1' name='quantity' />
      <input type='hidden' value='<?php echo $product_id; ?>' name='product_id'/>
     
      <input type='submit' style="float:right;" id='product_<?php echo $product_id; ?>_submit_button' class='wpsc_buy_button' name='Buy' value='Add to Cart'  />
    </form>
  



    </div>
</div>
    
     <?php  }  ?>
      <?php } else { ?>
      

  <div  style="width:190px;float:right; text-align:right; clear:both; margin-top:8px; margin-right:10px;">
  <div style="height:45px; ">
  
	  <?php $product_id = get_post_meta($id,'memeber_product_id',true);  ?>
 <?php	if ($product_id) { ?>
    <form id='product_<?php echo $product_id; ?>' name='product_<?php echo $product_id; ?>' method='post' action='<?php echo get_option('product_list_url'); ?>' onsubmit='submitform(this);return false;' >
      <?php   echo "<div style=' '><strong>Members pay </strong> $".get_post_meta($id,'member',true)."</div> "; ?>
      <input type='hidden' value='add_to_cart' name='wpsc_ajax_action' />
      <input type='hidden' value='1' name='quantity' />
      <input type='hidden' value='<?php echo $product_id; ?>' name='product_id'/>
  
    </form>

   <div class='loggin_warning'>(please login or register to enable)</div>
 <?php  }  ?>


</div></div>
 <?php  }  ?>
    
    
    

    
    
    
    
  </div>
  <div id="clear"></div>
</div>
<?php } endwhile; ?>
<!-- end of news -->
<?php endforeach; ?>
