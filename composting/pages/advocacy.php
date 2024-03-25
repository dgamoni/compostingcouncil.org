
<?php the_content(); ?>





<!--Resource Content-->
<?php

$url = preg_replace('/&category=[^&]*/','',$_SERVER['REQUEST_URI']);
$cats = get_terms('advocacy_category','hide_empty=1');
foreach($cats as $c) {
	echo "<a href='?category=all&category={$c->slug}' >{$c->name}</a><br />";
}
echo "<br />";

if (isset($_GET['category'])) {
	$cats = array(0 => get_term_by('slug',esc_attr($_GET['category']), 'advocacy_category'));
}

foreach($cats as $c):
	echo "<div id=\"middle-header\"><a href='$url&category={$c->slug}' >{$c->name}</a></div>";

	$query_vars = array(
		'post_type' => 'advocacy',
		'posts_per_page' => 100,
		'taxonomy' => 'advocacy_category',
		'term' => $c->slug,
	);
	if (!is_user_logged_in()){
		$query_vars['meta_key']='access';
		$query_vars['meta_value']='Public';
	}
	$loop = new WP_Query( $query_vars );
	while ( $loop->have_posts() ) : $loop->the_post(); { ?>
		<br />

        
	
	 <div id="middleside" style="">
	<div id="middle-date" style="float:right;">
	
    
       
    
       
    <!--attachment-->	
        <?php  $args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => $id ); 
		$attachments = get_posts($args);
		if ($attachments) {
		foreach ($attachments as $attachment) { ?>
        <!--styleing-->
		<div id="hot-download-icon"><img src="<?php bloginfo("template_url") ?>/images/icons/com-download.png" /></div>
        
        <a href="<?php echo wp_get_attachment_url($attachment->ID, true ); ?>" target="_blank">		
        
        <span id="hot-download" style="line-height:11px; padding-right:17px; margin-right:2px;">
		<span style="font-size:9px;">download <br />
attachment</span></span></a>
        <!--styleing-->
		<?php	} } ?>
		<!--end attachment-->	
	
	</div>
		<div id="middle-main">
    <div id="middle-title" ><?php the_title(); ?></div>
	<?php the_content(); ?>
    </div> 
    <div id="clear"></div>
	</div>
    
	<?php } endwhile; ?>
    <!-- end of news -->
<?php endforeach; ?>
 