
<?php get_header(); ?>

<div id="container">

<h1 class="entry-title"><?php the_title(); ?></h1>


  <div id="side-left" class="widget-area">
  

	<?php  include("sidebar/subpages.php"); ?>
 
  
  </div>
 
 
 
  <!--MIDDLE SECTION-->
	<div id="content">
		<?php $members = new tern_members;$members->members(array('search'=>true,'pagination'=>true,'sort'=>true));?>
	</div>
  <!--MIDDLE SECTION-->
<div id="side-right" class="widget-area">

<?php  include("sidebar/sidebar-right.php"); ?>

</div>
  
  
  
   
  
  
  
  
  
  
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>




        
	