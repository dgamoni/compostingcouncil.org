<? $userdata = wp_get_current_user(); if($userdata->ID) { ?>
<div id="member-box-wrapper" <?php if (is_page('229') ) { ?><?php } else{ ?>style="margin-top:12px;" <?php }?>>
  <div id="member-box">
    <div id="member-box-title">Hello,
      <?=$userdata->user_login?>
    </div>
    <div id="member-line"></div>
    <!--Master options-->
    <?php if (current_user_can('edit_post', $post->ID)) { ?>
    <div><?php edit_post_link('Edit Page '); ?>
    <?php echo $post->ID;?>   </div>
    <a href="<?php echo site_url(); ?>/wp-login.php?action=logout">Logout</a>
    <?php } else { ?>
    <!--member options-->
    <div id="member-top">
      <ul>
        <li><a href="http://compostingcouncil.org//amember/member.php">Your Profile</a></li>
        <li><a href="http://compostingcouncil.org/wp/wp-login.php?action=logout">Logout</a></li><br />
        <li><a href="http://compostingcouncil.org/amember/member.php?tab=add_renew">Renew</a></li>
      </ul>
    </div> 
    <?php }	?>
  </div>
</div>
<?	 } else { ?>
<div id="member-box-wrapper">
  <div id="member-box">
    <div id="member-box-title" >Admin Login</div>
    <div id="member-line"></div>
    <ul>
      <li style=" list-style:none;">
        <form name="loginform" id="loginform"  action="/wp/wp-login.php" method="post">
          <label>Username</label>
          <input name="log" type="text" size="25">
          <br />
          <label>Password</label>
          <input name="pwd" type="password" size="25">
          <div style="height:3px;"></div>
          <input class="newbutton" type="submit" name="wp-submit" value="Login"/>
          <input type="hidden" name="testcookie" value="1" />
    
        </form>
        
      </li>
    </ul>
  </div>
</div>
<? } ?>













