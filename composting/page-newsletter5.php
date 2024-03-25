<style type="text/css">

.sfd {

	background-color: #99cc66;

	margin-bottom: 15px;

	padding: 11px;

	font-size: 12px;

}

	</style>

	<?php 

/*

Template Name: Newsletter 5

*/

?>



<?php 

if (is_page(explode(',','674,62,64'))) {

	wp_enqueue_script('datepicker',get_bloginfo('template_directory').'/js/ui.datepicker.min.js',array('jquery-ui-core'),'1.7.3');

	wp_enqueue_style('jquery-ui-lightness',get_bloginfo('template_directory').'/js/'.JQUERY_UI_THEME.'/jquery-ui-1.7.3.custom.css');

}

if (is_page(explode(',','18,22,24,28'))) {

	wp_enqueue_style('forms_styles', get_template_directory_uri().'/form.css');

	wp_enqueue_script('forms_scrypt', get_template_directory_uri().'/js/forms.js');

}

get_header(); 

?>



<div id="container">

  <div id="clear"></div>

  <h1 class="entry-title">

    <?php the_title(); ?>

  </h1>

 

  <!--MIDDLE SECTION-->

  <div id="content" style="width:710px;">

  

  

  

  

  

  

    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <div id="post">

      <div class="entry-content" style="">

      

      



           

           

           

         <div id="side-right" class="widget-area" style="float:right; margin-right:-58px; margin-left:10px;">

    <?php  include("sidebar/sidebar-right-over.php"); ?>

  </div>

      

      

      

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

		

		<?php } elseif  (is_page('229') ) { ?>

		

		<? include TEMPLATEPATH."/login_form.php"; ?> 

        

        

		<?php } elseif  (is_page('5') ) { ?>

		<?php the_content(); ?>

        

          <?php } elseif  (is_page('1850') ) { ?>



<?php

query_posts('page_id=3348');

if (have_posts()) : while (have_posts()) : the_post();

	?>

    <?php the_content(''); ?>

	<?php

endwhile; endif;

wp_reset_query();

?>









        <?php the_content(); ?>

        

        

        

        

        <?php } elseif  (is_page('79') ) { ?>

		<?php the_content(); ?>

        

        <?php } else{?>

        

        <?php the_content(); ?>

   

        

        



        



          <div id="blue-line"></div>

		 <?php include(TEMPLATEPATH . '/sidebar/social.php'); ?>

        <?php }?>

        

      

        

      </div>

      

      

      

      

      

    </div>

    <?php endwhile; ?>

	<?php if (is_page(explode(',','18,28,22'))): ?>

	<script type="text/javascript">

	//<![CDATA[

	(function($) {

	$(document).ready(function() {

		forms_init('registration');

	});

	})(jQuery);

	//]]>

	</script>

	<?php endif; ?>

  </div>

  <!--MIDDLE SECTION-->

<div id="side-right" class="widget-area">

    <?php  include("sidebar/sidebar-right-noad.php"); ?>

<div class="sfd"><h3><strong>New Members, Second Quarter: Welcome!</strong></h3>

<hr>

Chandler Cummins<br>

<strong>Advanced Composting Technologies LLC</strong><br>

Kacy Cronan<br>

<strong> Ag-Green</strong><br>

Blake Walker<br>

<strong>All American Stone and Turf</strong><br>

Mark Medearis<br>

<strong>American Wood Fibers </strong><br>

Edward Hyle<br>

<strong>Appalachian State University</strong><br>

Bruce Singleton<br>

<strong>Applied Sciences LLC </strong><br>

Michael Croissant<br>

<strong>B.O.S.S. Compost Inc. </strong><br>

Jason Todaro<br>

          <strong>Blue Ridge Services, Inc.</strong><br>

Jim Gish<br>

          <strong>Brigham Young University</strong><br>

Lisa Grau<br>

          <strong>Cal Poly</strong><br>

James Beck <br>

          <strong>Cardia Bioplastics USA</strong><br>

Bernard Bigham<br>

          <strong>Chesapeake Environmental Group</strong><br>

Maria Francesca DiMeglio<br>

          <strong>City of Alameda </strong><br>

Matthew Krupp <br>

          <strong>City of Palo Alto </strong><br>

John Ortolano <br>

          <strong>Columbia University </strong><br>

Joshua Fookes <br>

          <strong>Commercial Waste &amp; Recycling, LLC </strong><br>

Mary Ryther <br>

          <strong>Compost With Me </strong><br>

Louis Darrouzet<br>

          <strong>CycleWood Solutions </strong><br>

Alan Smith <br>

          <strong>Daddypetes Plant Pleaser </strong><br>

Debra Darby <br>

          <strong>Darby Marketing </strong><br>

Darym Alden <br>

          <strong>Earth Matter </strong><br>

Clay Ezell <br>

          <strong>EarthMatter</strong><br>

Kathleen Langan <br>

          <strong>Eco Recycling </strong><br>

Dimitri Homatidis<br>

          <strong>Ecological Recycling Society</strong><br>

Brian Parker <br>

          <strong>Environmental Solutions Group </strong><br>

Anthony Cialone<br>

          <strong>Environmental Turnkey Soultions, LLC </strong><br>

Ray Colasacco<br>

          <strong>EverGreen Organic Recycling </strong><br>

Zach Bagley <br>

          <strong>GO Compost </strong><br>

Kelvin Okamoto<br>

          <strong>Green Bottom Line, Inc. </strong><br>

Abby Stec <br>

          <strong>Green Leaf Distribution </strong><br>

Lawrence Schillinger <br>

          <strong>Green Recycled Organics LLC </strong><br>

Jerry Phares <br>

          <strong>Hallco Industries, Inc.</strong><br>

Kathryn Walsh <br>

          <strong>Harvey &amp; Company </strong><br>

Sierra Halverson <br>

          <strong>Illinois State </strong><br>

Kim Eger<br>

          <strong>Integrated Waste Solutions - IWS</strong><br>

Chad Cheatham<br> 

          <strong>Interval Equipment Solutions, Inc.</strong><br>

Alexandria Bombard<br> 

          <strong>J&amp;B brothers excavating </strong><br>

Jessica Jones <br>

          <strong>JK Jones Consulting &amp; Engineering </strong><br>

Timothy Johnson <br>

          <strong>Johnson Livestock Farms </strong><br>

A.G. Lenamond <br>

          <strong>Just Wood &amp; Mulch </strong><br>

Ben Fehrer <br>

          <strong>Kewanna Screen Printing </strong><br>

Carey West <br>

          <strong>Loadscan Ltd</strong><br>

Monica Bourdens <br>

          <strong>Mass Wiggle</strong><br>

Andrea McIntosh <br>

          <strong>Messiah University</strong><br>

Nancy Schneider <br>

          <strong>Monaghan Mushrooms Ltd.</strong><br>

Denise Houghtaling <br>

          <strong>MW Horticulture Recycling Facility, Inc. </strong><br>

Diedre Tubb <br>

          <strong>Northern California Recycling Association </strong><br>

Yonara Acevedo <br>

          <strong>Oasis Design </strong><br>

Mary Proctor <br>

          <strong>P&amp;S Excavating, LLC/Cayuga Compost </strong><br>

Jim McNelly <br>

          <strong>Renewable Carbon Management LLC </strong><br>

Mark Smallwood <br>

          <strong>Rodale Institute </strong><br>

Ronny Navarro<br>

          <strong>Ronnys Inc</strong><br>

Robert Hettinger <br>

          <strong>S &amp; H Manure LLC </strong><br>

David Johnson <br>

          <strong>Second Harvest Farms </strong><br>

Andy Harpenau <br>

          <strong>Soil Dynamics </strong><br>

Kristine  Amendt <br>

          <strong>Sol et Ciel </strong><br>

Stacy Thaggard <br>

          <strong>Southern Compost Solutions LLC </strong><br>

Brandon Moffatt<br>

          <strong>StormFisher </strong><br>

Krista Greene <br>

          <strong>SUNY Stonybrook </strong><br>

Jamie Accetta <br>

          <strong>Sustainable Solutions </strong><br>

David van Over <br>

          <strong>Synergetics Group, LLC </strong><br>

Tamara Shulman <br>

          <strong>Tamara Shulman </strong><br>

Megan Holmes <br>

          <strong>Texas State </strong><br>

Bonita Lowry <br>

          <strong>The Ohio State University </strong><br>

Ingrid Behrsin <br>

          <strong>UC Davis </strong><br>

Alexandra DeBose-Scarlett<br> 

          <strong>University of Florida </strong><br>

Guy Guan <br>

          <strong>University of Southern California </strong><br>

Kimberly Whitlock <br>

          <strong>University of Tennessee Entomology &amp; Plant Pathology </strong><br>

Lynn Fang <br>

          <strong>University of Vermont</strong><br>

Daniel Keeney <br>

          <strong>University of Vermont</strong><br>

Suellen Witham <br>

          <strong>Westside Spreading, LLC </strong><br>

Kelly Ligas <br>

          <strong>Wood Waste Recycling, LLC </strong><br>

Derek Riley <br>

          <strong>Yield Energy Inc </strong><br>

<br><u>Individual</u><br>

Karen Taylor <br>

Michael Sevener <br>

Nizar Jetha <br>

Jonathan Hunt <br>

Nicole Cousino <br>

Grant Ligon <br>

Meredith Dean <br>

Tim Scott <br>

Ryan Tarbell <br>

Chaz Miller <br>

David Crohn <br>

Angela Welty<br>

Mandira Ramalakshmi <br>

Emily Creegan <br>   

</div>

     <?php  include("sidebar/subpages.php"); ?>     

  </div>  

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

