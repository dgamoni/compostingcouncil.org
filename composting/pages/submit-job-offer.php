<?php the_content(); ?>
<br />
<br />


<?php if (is_user_logged_in()){ ?>


<div id="member-box-wrapper" style="margin-top:12px;"> 
  <div id="member-box"> 
<h2>Submit Job Offer</h2>
<div style="font-size:13px;">

<form id="post" action="/admin/wp-content/themes/composting/post_custom.php" method="post" enctype="multipart/form-data"> 
<input name="post_type" type="hidden" value="joboffers" /> 
<input name="post_status" type="hidden" value="pending" /> 
<input type="hidden" name="action" value="post" />
<input type="hidden" name="_joboffers_http_referer" value="/joboffers/" />

<?php echo wp_nonce_field('add-joboffers','_wpnonce', false , false ); ?>


<label><span><strong>Posted</strong></span><br />
<span id="timestamp"><input id="posted" name="posted" size="10" value="<?php echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( current_time('mysql') ) );?>" tabindex="2" /></span> </label><div id="formspacer"></div>

<label><span><strong>Deadline</strong></span><br />
<span id="timestamp"><input id="deadline" name="deadline" size="10" value="<?php echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( current_time('mysql') ) );?>" tabindex="3" /></span> </label><div id="formspacer"></div>

<label><span><strong>Company</strong></span> <br><input id="company" name="company" size="50" type="text" tabindex="4"/> </label> <div id="formspacer"></div>

<label><span><strong>Job Title</strong></span><br> <input id="title" name="post_title" size="50" type="text" tabindex="5" /></label><div id="formspacer"></div>

<label><span><strong>Job Description</strong></span> <br>
<textarea id="content-text" class="theEditor" cols="60" rows="5" name="content" tabindex="6"></textarea> </label><div id="formspacer"></div> <br />


<label><span><strong>Location</strong></span> <br />
<input id="location" name="location" size="50" type="text" tabindex="7"/> </label> <div id="formspacer"></div>

<label><span><strong>Contact Info</strong></span> <br>
<textarea id="contactinfo" class="theEditor" cols="60" rows="5" name="contactinfo" tabindex="8"></textarea> </label><div id="formspacer"></div> <br />


<label><span>File Upload</span><br />
 <input type="file" name="userfile" size="40" id="userfile" tabindex="9"/> </label> <div id="formspacer"></div>

<label><span>File Description</span> <br />
<input id="filedesc" name="filedesc" size="40" type="text" tabindex="5"/> </label> <div id="formspacer"></div><br />


<input type="submit" name="save" id="save-post" class="button-primary" tabindex="11" accesskey="p" value="Add Job Offer" />

</form>


</div></div></div>
<?php } else { ?>
<div id="warning-box-wrapper"><div id="warning-box">Only members add Jobs. If you are a member, please log in.</div></div>

<?php }; ?>






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
