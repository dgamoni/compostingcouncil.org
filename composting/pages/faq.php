<?php the_content(); ?>




<!--FAQs Categories List-->



<!--Resource Content-->
<?php

$url = preg_replace('/&category=[^&]*/','',$_SERVER['REQUEST_URI']);
$cats = get_terms('faq_category','hide_empty=1');
foreach($cats as $c) {
	echo "<a href='?category=all&category={$c->slug}' >{$c->name}</a><br />";
}
echo "<br />";

if (isset($_GET['category'])) {
	$cats = array(0 => get_term_by('slug',esc_attr($_GET['category']), 'faq_category'));
}

foreach($cats as $c):
	echo "<div id=\"middle-header\"><a href='$url&category={$c->slug}' >{$c->name}</a></div>";

	$query_vars = array(
		'post_type' => 'faq',
		'posts_per_page' => 100,
		'taxonomy' => 'faq_category',
		'term' => $c->slug,
	);
	$loop = new WP_Query( $query_vars );

    
	while ( $loop->have_posts() ) : $loop->the_post(); { ?>
		<br />

			
 		<div id="middleside">
		<div style="width:425px; float:left;">
    	<div id="middle-title" ><?php the_title(); ?></div>
		<?php the_content(); ?>
    	</div> 
    	<div id="clear"></div>
		</div>
    
	<?php } endwhile; ?>
    <!-- end of news -->
 <?php endforeach; ?>
 
 