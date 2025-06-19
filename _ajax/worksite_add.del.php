<?php 
include_once('../_common.php');

if($is_guest)
	alert('로그인 후 이용바랍니다.');
	
if(!isset($_POST['seq'])) die('no');

$sql = " delete from {$none['worksite_add']} where seq = '$seq' limit 1";

if(sql_query($sql)) {
	die('y');
} else {
	die('n');
}