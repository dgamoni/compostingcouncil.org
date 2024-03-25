
<?php
if ( is_front_page() ) {?>
   
  
 <?php 
} 
  
?>






<div id="subpage-list">
<div id="sub-back-wrapper" >
<div id="sub-back">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("homesub") ) : ?>
<?php endif; ?>

</div>
</div>
</div>





