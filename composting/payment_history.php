<?php
function wp_title($a, $b, $c) {
	echo "Payment History";
}

include '../amember/dbconf.php';
if (!file_exists('wp-config.php')) die ('wp-config.php not found');
require_once('wp-config.php');
global $wpdb;
get_header();
$id = (int) $_GET['uid'];

$connection = @mysql_connect($pc['host'],$pc['user'],$pc['pass'])or die("Could not connect: " . mysql_error());
$db = mysql_select_db($pc['db'], $connection) or die ('wtf');

$res = mysql_query("select t1.*, t2.*, t3.* from amember_payments as t1, amember_products as t2, amember_members as t3 where t1.product_id = t2.product_id and t1.member_id = t3.member_id and t3.uscc = ".$id." order by t1.product_id");
?>

<div id="content">
<table style="text-align: center">
	<tr>
		<td>Begin date</td>
		<td>Expire date</td>
		<td>Product</td>
		<td>Price</td>
	</tr>

	<?php while ($r = mysql_fetch_object($res)){
		echo '<tr>';
		echo '<td>';
		echo "$r->begin_date\n";
		echo '</td>';
		echo '<td>';
		echo "$r->expire_date\n";
		echo '</td>';
		echo '<td>';
		echo "$r->title\n";
		echo '</td>';
		echo '<td>';
		echo '$'."$r->price\n";
		echo '</td>';
		echo "\n";
		echo '<tr>';
	} ?>
</table>

</div>
	<?php
	get_sidebar();
	get_footer();
	?>