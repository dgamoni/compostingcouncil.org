

<div id="subpage-list">
<div id="sub-back-wrapper" >
<div id="sub-back">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("sidebar2") ) : ?>
<?php endif; ?>

</div>
</div>
</div>






<!--news -->
<?php if(is_page(array(43,46,48,213))   ) {   ?> 
<?php include('news.php'); ?>

<!--about-->
<?php } elseif (is_page(array(83,92,90,88,86)) ) {	?>
<?php include('about.php'); ?>

<!--contact-->
<?php } elseif (is_page(array(101,105)) ) {	?>
<?php include('contact.php'); ?>


<!--Main Menu-->




<!--Confernce-->
<?php } elseif (is_page(array(5,18,20,166,168,171,173,175,223,22,220,224,26,28,177,179,24)) ) {	?>
<?php include('confer.php'); ?>

 <?php } elseif  (is_page('57') ) { ?>
		 <?php include('cart.php'); ?>

<!--Edu-->
<?php } elseif (is_page(array(50,53,1310,1313)) ) {	?>
<?php include('edu.php'); ?>




<!--advo-->
<?php } elseif (is_page(array(1288,1290,1292)) ) {	?>
<?php include('advo.php'); ?>





<!--Programs-->
<?php } elseif (is_page(array(29,32,183,185,187,191,193,195,197,34,36,39,41,200,202,204)) ) {	?>
<?php include('programs.php'); ?>


<!--Resources-->
<?php } elseif (is_page(array(1319,1330,1324,1328,77,72,81,79,55,57,107)) ) {	?>
<?php include('resources.php'); ?>


<!--Foundation-->
<?php } elseif (is_page(array(94,99,97)) ) {	?>
<?php include('foundation.php'); ?>

<!--Membership -->
<?php } elseif (is_page(array(59,66,64,62)) ) {	?>
<?php include('membership.php'); ?>




<?php } else { ?>

<?php include('all.php'); ?>

 
<?php  } ?>





     
      

<? include TEMPLATEPATH."/login_form.php"; ?> 




