<?php 
include_once('../../_common.php');
define('menu_statistics', true);

if($is_guest) alert('권한이 없습니다.', G5_URL);


if(!isset($_POST['type']) || !isset($_POST['ns_id'])) die('n');

$mb_name = $member['mb_name']." ".get_mposition_txt($member['mb_3']);
if($w == '') {
	
	
	$sql = "insert into {$none['sign_draft_comment']} set 
	
	ns_id = '$ns_id',
	ns_type = '$type',
	mb_name = '{$mb_name}',
	mb_id = '{$member['mb_id']}',
	ns_comment = '$comment',
	ns_datetime = '".G5_TIME_YMDHIS."',
	ns_ip = '".$_SERVER['REMOTE_ADDR']."'
	
	";
	
	if(sql_query($sql)) {
		die('y');
	} else {
		die('query-error');
	}
} else if($w == 'u') {
	
} else if($w == 'd') {
	
}