<?php the_content(); ?>
<br />
<br />




<div style="font-size:13px;">

<form id="post" action="/admin/wp-admin/post.php" method="post">
<input name="post_type" type="hidden" value="events" />
<input name="post_status" type="hidden" value="pending" />
<input type="hidden" name="action" value="post" />
<input type="hidden" name="_event_http_referer" value="events" />
<?php echo wp_nonce_field('add-events','_wpnonce', false , false ); ?>

<label><span><strong>Title</strong></span><br />
<input id="title" name="post_title" size="50" type="text" tabindex="1" /></label> 
<br />
<span><strong>Category</strong></span> <br />
<input id="category-conference" checked="checked" name="category" type="radio" value="conference" /> <label class="selectit" for="category-conference">conference</label>
<input id="category-training" name="category" type="radio" value="training" /> <label class="selectit" for="category-training">training</label>
<input id="category-ICAW" name="category" type="radio" value="ICAW" /> <label class="selectit" for="category-ICAW">ICAW</label>
<input id="category-meetings" name="category" type="radio" value="meetings" /> <label class="selectit" for="category-meetings">meetings</label>
<br />
<label><span><strong>Location</strong></span><br />
<input id="location" name="location" size="50" type="text" tabindex="2"/> </label>
<br />
<label><span><strong>Start Date</strong></span><span id="timestamp"><br />
<input id="start" name="start" size="10" value="2010-09-08" tabindex="3" /></span> </label> 
<br />
<label><span><strong>End Date</strong></span><span id="timestamp"><br />
<input id="deadline" name="deadline" size="10" value="2010-09-15" tabindex="4" /></span> </label>
<br />
<label><span><strong>Details</strong></span> <br />
<textarea id="contenttext" class="theEditor" cols="60" rows="5" name="content" tabindex="5"></textarea> </label>
<br /><br />

<label><span><strong>Contact</strong></span><br />
<textarea id="contacttext" cols="60" rows="4" name="contact" tabindex="6"></textarea> </label> 
<br /><br />

<span><strong>Training</strong></span> 
<input id="type-radio-training-no" checked="checked" name="training" type="radio" value="No" /> <label class="selectit" for="type-radio-training-no">No</label>
<input id="type-radio-training-yes" name="training" type="radio" value="Yes" /> <label class="selectit" for="type-radio-training-yes">Yes</label>
<br />
<br />

<input type="submit" name="save" id="save-post" class="button-primary" tabindex="7" accesskey="p" value="Add Event" />
</form>












</div>
<script type="text/javascript">
//<![CDATA[
(function($) {
$(document).ready(function() {
	$("#posted").datepicker({ dateFormat: '<?php echo JS_DATE_FORMAT; ?>' });
	$("#deadline").datepicker({ dateFormat: '<?php echo JS_DATE_FORMAT; ?>' });
});
})(jQuery);
//]]>
</script>
