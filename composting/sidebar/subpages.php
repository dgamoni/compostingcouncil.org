<?php if(is_page(array(57))   ) {   ?> 
<?php include('cart.php'); ?>


<?php } else { ?>
<?php  } ?>


<!--news -->
<?php if(is_page(array(43,46,48,213,101,105, 206))   ) {   ?> 
<div id="subpage-list">
<div id="sub-back-wrapper" >
<div id="sub-back">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("topsub") ) : ?>
<?php endif; ?>
</div>
</div>
</div>

<?php } elseif (is_page(array( 674, 802)) ) {	?>


<?php } elseif (is_page(array( 229)) ) {	?>
<div id="subpage-list">
<div id="sub-back-wrapper" >
<div id="sub-back">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("homesub") ) : ?>
<?php endif; ?>

</div>
</div>
</div>



<?php } elseif (is_page(array(153,152)) ) {	?>
<div id="subpage-list">
<div id="sub-back-wrapper" >
<div id="sub-back">
<div class="submenu-widget submenu-widget-"><ul id="menu-home-sub-menu" class="menu"><li id="menu-item-1410" class="menu-item menu-item-type-custom menu-item-1410"><a href="http://www.compostingcouncil.org/?page_id=206">News</a></li> 
<li id="menu-item-1411" class="menu-item menu-item-type-custom menu-item-1411"><a href="http://www.compostingcouncil.org/?page_id=213">Newsletters</a></li> 
<li id="menu-item-1412" class="menu-item menu-item-type-custom menu-item-1412"><a href="http://www.compostingcouncil.org/?page_id=48">Press Releases</a></li> 
</ul></div> 
</div>
</div>
</div>




<?php } else { ?>

<div id="subpage-list">
<div id="sub-back-wrapper" >
<div id="sub-back">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("mainsub") ) : ?>
<?php endif; ?>


</div>
</div>
</div>

 
<?php  } ?>









<?php if (is_page('229') ) { ?>




<?php } else{?>
<? include TEMPLATEPATH."/login_form.php"; ?> 

<?php } ?>

