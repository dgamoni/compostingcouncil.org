
<div id="subpage-list">
<div id="sub-back-wrapper" >
<div id="sub-back">

<ul >
<li <?php if(is_page(5)) { ?>class="s-active"<?php }?> id="firstlist" ><a href="<?php bloginfo('url');?>/?page_id=5">Conference</a></li>
<li <?php if(is_page(18)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=18">Registration</a></li>
<li <?php if(is_page(20)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=20">Event Info</a>



<?php if(is_page(array(20,166,168,171,173,175,223))   ) {   ?> 

<ul>
	<li <?php if(is_page(168)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=168">Program</a></li>
	<li <?php if(is_page(166)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=166">Workshops</a></li>

	<li <?php if(is_page(171)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=171">Speakers</a></li>
	<li <?php if(is_page(173)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=173">Equipment Demonstrations</a></li>
	<li <?php if(is_page(175)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=175">Venue</a></li>
	<li <?php if(is_page(223)) { ?>class="s-active"<?php }?>  ><a href="<?php bloginfo('url');?>/?page_id=223">Conference FAQ</a></li>
</ul>

</li>
<?php } else { ?>
</li>
 <?php  } ?>





<li <?php if(is_page(22)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=22">Exhibitors</a>

<?php if(is_page(array(22,220))   ) {   ?> 
<ul>
	<li <?php if(is_page(220)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=220">Equipment Demonstration</a></li>
</ul>
</li>
<?php } else { ?>
</li>
 <?php  } ?>



<li <?php if(is_page(24)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=24">Sponsorship</a></li>
<li <?php if(is_page(26)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=26">Awards</a></li>
<li <?php if(is_page(179)) { ?>class="s-active"<?php }?> id="lastlist" ><a href="<?php bloginfo('url');?>/?page_id=179">Speak / Submit Abstracts</a>
<?php if(is_page(array(28,177,179))   ) {   ?> 
<ul>
	<li <?php if(is_page(177)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=177">Abstract Guidelines</a></li>
	<li <?php if(is_page(28)) { ?>class="s-active"<?php }?> id="lastlist"><a href="<?php bloginfo('url');?>/?page_id=28">Submission Form</a></li>
</ul>
</li>
<?php } else { ?>
</li>
 <?php  } ?>






</ul>

</div>
</div>
</div>




