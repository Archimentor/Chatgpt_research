<?php 
include_once('./_common.php');


$mbSql = "select mb_name, mb_hp from g5_member where mb_level = 10 and (mb_2 = 3) and mb_id != 'admin'  and mb_level2 != 4";
$mbRst = sql_query($mbSql);
for($i=1; $mb = sql_fetch_array($mbRst); $i++) {
	$_variables['receiver_'.$i] = $mb['mb_hp'];
	$_variables['recvname_'.$i] = $mb['mb_name'];
	$_variables['subject_'.$i] = '대금결제 알림';
	$_variables['message_'.$i] = $message;
}