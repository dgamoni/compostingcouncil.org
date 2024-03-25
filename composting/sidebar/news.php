

<div id="subpage-list">
<div id="sub-back-wrapper" >
<div id="sub-back">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("sidebar2") ) : ?>
<?php endif; ?>
<ul>
<li <?php if(is_page(206)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=206">Latest News</a>
<li <?php if(is_page(213)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=213">Newsletters</a></li>
<li <?php if(is_page(48)) { ?>class="s-active"<?php }?> ><a href="<?php bloginfo('url');?>/?page_id=48">Press Releases</a></li>
<li <?php if(is_page(46)) { ?>class="s-active"<?php }?> id="lastlist"><a href="<?php bloginfo('url');?>/?page_id=46">Upcoming Events</a></li>
</ul>
</div>
</div>
</div>

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('events_sidebar') ) : ?>
<?php endif; ?>





