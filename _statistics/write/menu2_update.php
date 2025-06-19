<?php 
include_once('../../_common.php');

if($is_guest) alert('권한이 없습니다.', G5_URL);

$sql_common = "
nw_code = '$nw_code',
ns_type = '$ns_type',
ns_date = '$ns_date',
ns_price = '$ns_price',
ns_vat = '$ns_vat',
ns_total_price = '$ns_total_price',
ns_account = '$ns_account',
ns_memo = '$ns_memo'

";

if($w == '') {
	
	$sql = " insert into {$none['sales_list']} set {$sql_common},  mb_id = '{$member['mb_id']}', ns_datetime = '".G5_TIME_YMDHIS."', ns_ip = '".$_SERVER['REMOTE_ADDR']."'";
	sql_query($sql);

	$msg = "매출현황이 등록 되었습니다.";
	$url = "/_statistics/list/menu2_list.php";
		
} else if($w == 'u') {
	
	$sql = " update {$none['sales_list']} set {$sql_common}, ns_updatetime = '".G5_TIME_YMDHIS."', ns_ip = '".$_SERVER['REMOTE_ADDR']."' where seq = '$seq'";
	sql_query($sql, true);

	
	$msg = "매출현황이 수정 되었습니다.";
	$url = "";
} else if($w == 'd') {
	
	$sql = " delete from {$none['sales_list']} where seq = '$seq'";
	sql_query($sql, true);

	
	$msg = "매출현황이 삭제 되었습니다.";
	$url = "";
}

alert($msg, $url);