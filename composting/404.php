<?php

//Simple Redirect for WordPress. 
//Christopher Carey
//301 Redirect for Wordpress
//http://wwww.noheat.com

header("HTTP/1.1 301 Moved Permanently");
header("Location: ".get_bloginfo('url'));

exit();

