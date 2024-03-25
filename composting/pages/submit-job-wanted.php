<?php the_content(); ?>


<?php if (is_user_logged_in()){ ?>

<div id="member-box-wrapper" style="margin-top:12px;"> 
  <div id="member-box"> 
<h2>Submit Job Wanted</h2>

<div style="font-size:13px;">

<form id="post" action="/admin/wp-content/themes/composting/post_custom.php" method="post" enctype="multipart/form-data"> 
<input name="post_type" type="hidden" value="jobswanted" /> 
<input name="post_status" type="hidden" value="pending" /> 
<input type="hidden" name="action" value="post" />
<input type="hidden" name="_jobswanted_http_referer" value="/jobswanted/" />

<?php wp_nonce_field('add-jobswanted','_wpnonce', false , false ); ?>


<label><span><strong>Posted </strong></span><span id="timestamp"><input id="posted" name="posted" size="10" value="<?php echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( current_time('mysql') ) );?>" tabindex="1" /></span> </label><div id="formspacer"></div>

<label><span><strong>Deadline </strong></span><span id="timestamp"><input id="deadline" name="deadline" size="10" value="<?php echo date_i18n( OUTPUT_DATE_FORMAT, strtotime( current_time('mysql') ) );?>" tabindex="2" /></span> </label>
<div id="formspacer"></div>

<label><span><strong>Company</strong></span><br />

  <input id="company" name="company" size="50" type="text" tabindex="3"/> 
  </label> <div id="formspacer"></div>

<label><span><strong>Job Title</strong></span> <br />
<input id="title" name="post_title" size="50" type="text" tabindex="4" /></label><div id="formspacer"></div>

<label><span><strong>Job Description</strong></span> <br>
<textarea id="content-text" class="theEditor" cols="60" rows="5" name="content" tabindex="5"></textarea> </label><div id="formspacer"></div><br />


<label><span><strong>Location</strong></span><br />
 <input id="location" name="location" size="50" type="text" tabindex="6"/> </label><div id="formspacer"></div>

<label><span><strong>Contact Info</strong></span> <br>
<textarea id="contactinfo" class="theEditor" cols="60" rows="5" name="contactinfo" tabindex="7"></textarea></label><div id="formspacer"></div><br />


<label><span><strong>File Upload</strong></span><br />
 <input type="file" name="userfile" size="40" id="userfile" tabindex="8"/></label> <br>

<label><span><strong>File Description</strong></span> <br />
<input id="filedesc" name="filedesc" size="50" type="text" tabindex="9"/></label> <div id="formspacer"></div>

<input type="submit" name="save" id="save-post" class="button-primary" tabindex="10" accesskey="p" value="Add Job Wanted" />

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
