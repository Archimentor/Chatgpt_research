<?php 
include_once('../../_common.php');

if(!$num || !$seq ) exit;


$chk = sql_fetch("select * from none_sign_draft2_chk  where seq = '$seq'");

if($chk) {
	$sql = "update none_sign_draft2_chk set 
	ns_chk{$num} = $set
	
	where seq = '$seq'
	";
	
} else {
	
	$sql = "insert into none_sign_draft2_chk set 
	seq = '$seq',
	ns_chk{$num} = $set
	
	
	";
}

echo $sql;

sql_query($sql, true);