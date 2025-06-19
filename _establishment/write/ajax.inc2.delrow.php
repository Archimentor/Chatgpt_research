<?php 
include_once('../../_common.php');


if(empty($_POST['seq'])) exit;

if($is_guest) exit;

$sql = "delete from {$none['est_jungsan']} where seq = '$seq'";
$sql2 = "delete from {$none['est_jungsan_price']} where seq = '$seq'";

if(sql_query($sql) && sql_query($sql2)) {
	die('y');
} else {
	die('query-error');
}