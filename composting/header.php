<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title>
<?php wp_title( '|', true, 'right' ); ?>
US Composting Council</title>

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">


<?php wp_head(); ?>


<meta name="description" content="US Composting Council" />
<meta name="keywords" content="US Composting Council" />
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" type="image/x-icon" />

<!-- Hotjar Tracking Code for http://compostingcouncil.org/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:545317,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
</script>

</head>
<body <?php body_class(); ?>>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-20471414-1', 'auto');
  ga('send', 'pageview');

</script>

<div id="wrapper" class="hfeed">
<div id="header">
  <div id="headertop">
  
  <div style="float:left; margin-left:10px; text-align:left; width:150px; color:#e6dfcf;">Follow us:
 <a style=" margin-right:4px; margin-left:4px; color:#e6dfcf;" href="https://www.facebook.com/USCompostingCouncil" ><i class="fa fa-facebook"></i></a>
  <a style=" margin-right:4px; color:#e6dfcf;" href="http://www.linkedin.com/company/us-composting-council" ><i class="fa fa-linkedin"></i></a>
   <a style=" margin-right:4px; color:#e6dfcf;" href="https://twitter.com/USCompostingcou" ><i class="fa fa-twitter"></i></a> 
  </div>
  
    <ul id="topmenu">
  
      <?php wp_nav_menu( array('menu' => 'Top Menu', 'fallback_cb' => false) ); ?>
   

    </ul>
  </div>
  <div id="headermain">
    <div id="logo" style="z-index:99999; width:300px; position:absolute; height:115px; overflow:hidden;" ><a href="<?php bloginfo('url'); ?>/"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" width="370" height="155"></a> </div>
    
    <!-- #branding -->
    
    <div id="access" role="navigation">
      <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
      <div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>">
        <?php _e( 'Skip to content', 'twentyten' ); ?>
        </a></div>
      <?php // wp_nav_menu( array('menu' => 'Main Menu', 'fallback_cb' => false  )); ?>
       <?php
if( function_exists( 'uberMenu_direct' ) ){
  uberMenu_direct( 'Main Menu' );
}?>
    </div>
    
    <!-- #access --> 
    
  </div>
  
  <!-- #masthead -->
  
  <?php if (is_page('2') ) { ?>
  <div id="calltoaction" >
    <?php $walker = new Menu_With_Description; ?>

   <?php wp_nav_menu( array('menu' => 'Call to Actions', 'fallback_cb' => false, 'walker' => $walker ) ); ?>
   
    
    
    
    
  </div>
  
  
  <div class="newhomeheader"> <a href="<?php bloginfo('url'); ?>/aboutus/"><img src="<?php bloginfo('template_url'); ?>/images/home-header.jpg" width="981" height="241"></a>
  </div>

  
  <!--Programs-->
  
  <?php } elseif (is_page(array(18,20,168,171,223,224,26)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar6.png" width="996" height="129"> 

<?php } elseif (is_page(array(41)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-icaw.png" width="996" height="129"> 
  
  <!--Programs-->
  
  <?php } elseif (is_page(array(50,53,55,57,107,14805,14840,14869,14914,14956,14985,15000,15217,15275,15350,22878,24876)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar2.png" width="996" height="129"> 
  
  <!--Networks-->
  
  <?php } elseif (is_page(array(29,32,183,185,187,191,193,195,197,34,36,39,200,202,204)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar3.png" width="996" height="129">
  <?php } elseif (is_page(array(72,81,79,77,24229,28203,28479,8753,29002)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar4.png" width="996" height="129">
  <?php } elseif (is_page(array(94,99,97,22915,29526)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar5.png" width="996" height="129">
<?php } elseif (is_page(array(25956)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-25.png" width="996" height="129">
  <?php } elseif (is_page(array(11167,13235,13397,9629,22079,22723,24585)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-conference-2016.png" width="996" height="129">
 <?php } elseif (is_page(array(6291,175,166,6707,23844,25538,23223,23869,21630,26258,26081,26340,26405,26558,26597,27076,27335,27376,27409,27452,27733,27837)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-conference-2017.png" width="996" height="129">
<?php } elseif (is_page(array(27911,22,5,28162,16889,28613,7769,24,21057,179,28,177,21676,28523,21065,6525,25421,173,13200,220,7427)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-conference-2018.png" width="996" height="129">
  <?php } elseif (is_page(array(15855,16082,16139,16148,16215,16275,16307,16352,16449,17555,17657,17754,20871,20887,20899,20977,20986,20990,23124,24035,24948,25013,26802)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-newsletter.png" width="996" height="129">
<?php } elseif (is_page(array(22104,25450)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-winter-newsletter.png" width="996" height="129">
<?php } elseif (is_page(array(26985)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-collage.png" width="996" height="129">
<?php } elseif (is_page(array(26266)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-compost-conference-2017.png" width="996" height="129">
  <?php } elseif (is_page(array(26524,27827)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-conference-2017-2.png" width="996" height="129">
  <?php } elseif (is_page(array(26760,26782,26883,26942)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-member-reconnect.png" width="996" height="129">
  <?php } elseif (is_page(array(21053,26847,28853,28510)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-member-soilbuilder.png" width="996" height="129">
    <?php } elseif (is_page(array(29564,29599)) ) {	?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-uscc-bowl2.png" width="996" height="129">
  <?php } else { ?>
  <img  style="margin-left:-5px;"src="<?php bloginfo('template_url'); ?>/images/middle-bar-soil.png" width="996" height="129">
  <?php } ?>
</div>

<!-- #header -->

<div id="main">
