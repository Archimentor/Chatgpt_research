<?php 
include_once('../../_common.php');

if(empty($_GET['date']) || empty($_GET['step']) || empty($_GET['code'])) exit;


if($step == 1) {
	//현장
	sql_query("delete from {$none['est_nomu_confirm']} where nw_code = '{$code}' and nw_date = '{$date}'");
	
	sql_query("insert into {$none['est_nomu_confirm']} set nw_code = '{$code}', nw_date = '{$date}', confirm1 = 1, confirm2 = 0, nw_datetime = '".G5_TIME_YMDHIS."', nw_ip = '".$_SERVER['REMOTE_ADDR']."' ");
	
	
} else if($step == 2) {
	//본사
	sql_query("delete from {$none['est_nomu_confirm']} where nw_code = '{$code}' and nw_date = '{$date}'");
	
	sql_query("insert into {$none['est_nomu_confirm']} set nw_code = '{$code}', nw_date = '{$date}', confirm1 = 2, confirm2 = 1, nw_datetime = '".G5_TIME_YMDHIS."', nw_ip = '".$_SERVER['REMOTE_ADDR']."' ");
}

else if($step == 3) {
	//본사
	sql_query("delete from {$none['est_nomu_confirm']} where nw_code = '{$code}' and nw_date = '{$date}'");
	
	sql_query("insert into {$none['est_nomu_confirm']} set nw_code = '{$code}', nw_date = '{$date}', confirm3 = 1, confirm4 = 0, nw_datetime = '".G5_TIME_YMDHIS."', nw_ip = '".$_SERVER['REMOTE_ADDR']."' ");
}

else if($step == 4) {
	//본사
	sql_query("delete from {$none['est_nomu_confirm']} where nw_code = '{$code}' and nw_date = '{$date}'");
	
	sql_query("insert into {$none['est_nomu_confirm']} set nw_code = '{$code}', nw_date = '{$date}', confirm3 = 2, confirm4 = 1, nw_datetime = '".G5_TIME_YMDHIS."', nw_ip = '".$_SERVER['REMOTE_ADDR']."' ");
}



alert('상태가 업데이트 되었습니다.');


?>