

<div id="subpage-list">
<ul>
<li><a href="<?php bloginfo('url');?>/?page_id=83">About Us</a></li>
<li><a href="<?php bloginfo('url');?>/?page_id=92">Mission</a>
<li><a href="<?php bloginfo('url');?>/?page_id=90">Bylaws</a></li>
	

<li><a href="<?php bloginfo('url');?>/?page_id=88">Board Members</a></li>
<li><a href="<?php bloginfo('url');?>/?page_id=86">Committee</a></li>
</ul>
</div>

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('events_sidebar') ) : ?>
<?php endif; ?>


