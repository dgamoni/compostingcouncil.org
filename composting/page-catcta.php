<?php

define('ABSPATH', dirname(__FILE__) . '/');


$a = rand(0, 9);
$b = rand(0, 9);
$str = "$a + $b = ?";
session_start();
$_SESSION['catcta'] = $a + $b;
$_SESSION['catcta1'] = "sssssssss";


$im = ImageCreateTrueColor(130, 40);
$col[1] = ImageColorAllocate($im, 192, 223, 235);
$col[2] = ImageColorAllocate($im, 192, 223, 235);

$black = ImageColorAllocate($im, 0, 0, 0);

for ($i = 1; $i < 39; $i++) {

    $j = ($i % 2 == 0) ? 1 : 2;
    ImageLine($im, 1, $i, 128, $i, $col[$j]);

}
//for

$size = 16;
$x = 24;
$y = 28;

ImageTTFText($im, $size, 0, $x, $y, $black, ABSPATH . "/wp-includes/fonts/code.ttf", $str);

Header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
Header("Cache-Control: no-cache, must-revalidate");
Header("Pragma: no-cache");

ImageGif($im);

?>