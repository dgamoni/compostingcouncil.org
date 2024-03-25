<?php get_header(); ?>

<div id="container" style="margin-top:135px;">

  <div id="side-left" class="widget-area" >



     <?php wp_reset_query(); ?>

    <?php  include("sidebar/home.php"); ?>

  </div>

  <!--MIDDLE SECTION-->

  <div id="content">

    <div id="post">

      <div class="entry-content">

        <!-- News Teaser -->

       

       

 <?php $loop = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 9 ) );

		while ( $loop->have_posts() ) : $loop->the_post();

		if ('Homepage'==get_post_meta($id,'news_type',true)) { 

		?>

       

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

		

        <img style="border:1px solid #bfdfeb;padding:2px; float:left " src="<?php echo wp_get_attachment_url($attachment->ID, true ); ?>" width="180" />

		<?php	} } ?>

        

        

        

        <div style=" float:right; width:290px; font-size:11px; line-height:16px;">

          <h1 style=" line-height:16px; font-size:14px; margin-bottom:4px;">

            <?php the_title(); ?>

          </h1>

          <?php the_content(); ?>

        </div>

        <div id="clear" style="height:26px;"></div>

        <?php } endwhile; ?>

        <!-- end of news -->

        <?php wp_reset_query(); ?>

           <?php the_content(); ?>

      </div>

    </div>

  </div>

</div>

</div>

<!--MIDDLE SECTION-->

<div id="side-right" class="widget-area">
  <?php  include("sidebar/sidebar-right.php"); ?>

</div>

</div>

<?php get_footer(); ?>