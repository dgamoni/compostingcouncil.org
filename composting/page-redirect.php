   
        <!--content redirections -->
        <?php if (is_page('1') ) { ?>
        <?php include(TEMPLATEPATH . '/content-pages/sample.php'); ?>
        <?php } elseif  (is_page('43') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/news_events.php'); ?>
        <?php } elseif  (is_page('206') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/news.php'); ?>
        <?php } elseif  (is_page('48') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/press.php'); ?>
        <?php } elseif  (is_page('213') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/newsletters.php'); ?>
        <?php } elseif  (is_page('46') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/events.php'); ?>
        <?php } elseif  (is_page('55') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/resources.php'); ?>
        <?php } elseif  (is_page('107') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/faq.php'); ?>
        <?php } elseif  (is_page('674') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/add-event.php'); ?>
        <?php } elseif  (is_page('62') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/submit-job-offer.php'); ?>
        <?php } elseif  (is_page('64') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/submit-job-wanted.php'); ?>
        <?php } elseif  (is_page('204') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/posters.php'); ?>
        <?php } elseif  (is_page('81') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/job-area.php'); ?>
        <?php } elseif  (is_page('77') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/links.php'); ?>
         <?php } elseif  (is_page('105') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/feedback.php'); ?>
        
         <?php } elseif  (is_page('166') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/workshops.php'); ?>
        
        <?php } elseif  (is_page('18') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/c-registration.php'); ?>
       
         <?php } elseif  (is_page('28') ) { ?>
		 <?php include(TEMPLATEPATH . '/pages/c-abstract.php'); ?>
         
         
        <?php } elseif  (is_page('57') ) { ?>
		 <?php include(TEMPLATEPATH . '/pages/publications.php'); ?>
         
        
        <?php } elseif  (is_page('22') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/c-exhibitors.php'); ?>
        
        <?php } elseif  (is_page('24') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/c-sponsors.php'); ?>
        
          <?php } elseif  (is_page('2804') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/donation-icaw.php'); ?>
        
          <?php } elseif  (is_page('97') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/donation-ccref.php'); ?>
        
          <?php } elseif  (is_page('1290') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/donation-support.php'); ?>
        
        
        
          <?php } elseif  (is_page('1292') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/advocacy.php'); ?>
        
         <?php } elseif  (is_page('1523') ) { ?>
        <?php include(TEMPLATEPATH . '/pages/events-icaw.php'); ?>
        
		<?php } elseif  (is_page('1310') ) { ?>
        <?php the_content(); ?>
        <?php include(TEMPLATEPATH . '/pages/events-training.php'); ?>
		
        
           
		<?php } elseif  (is_page('189') ) { ?>
          <?php include(TEMPLATEPATH . '/pages/sta.php'); ?>
        <?php the_content(); ?>
      
        
        
        <?php } elseif  (is_page('1850') ) { ?>
         
         
         
         <?php
$post_id = 3348;
$queried_post = get_post($post_id);
$title = $queried_post->post_title;
echo $queried_post->post_content;
?>

        <?php the_content(); ?>
        
        
        
        
        
		<?php } elseif  (is_page('229') ) { ?>
		
		<? include TEMPLATEPATH."/login_form.php"; ?> 
        
        
		<?php } elseif  (is_page('5') ) { ?>
		<?php the_content(); ?>
        
        
        
        
        <?php } elseif  (is_page('79') ) { ?>
		<?php the_content(); ?>
        
        <?php } else{?>
        
        <?php the_content(); ?>
          
          