

<div id="subpage-list">
<ul>
<li><a href="<?php bloginfo('url');?>/?page_id=43">News and Events</a></li>
<li><a href="<?php bloginfo('url');?>/?page_id=206">Latest News</a>
<li><a href="<?php bloginfo('url');?>/?page_id=213">Newsletters</a></li>
<li><a href="<?php bloginfo('url');?>/?page_id=48">Press Releases</a></li>
<li><a href="<?php bloginfo('url');?>/?page_id=46">Event Calendar</a></li>
</ul>
</div>

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('events_sidebar') ) : ?>
<?php endif; ?>


