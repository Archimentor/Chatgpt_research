<?php 
include_once('../../../../_common.php');

if($is_guest) alert('로그인 후 이용바랍니다.');


//전부 삭제
@sql_query("delete from {$none['est_imprest']} where nw_code = '{$nw_code}' and ne_date = '{$ne_date}'");


for($i=0; $i<count($_POST['ne_trade_date']); $i++) {
	
	
	//if(!$_POST['ne_trade_date'][$i]) continue;
	
	//콤마 모두제거
	$_POST['ne_cash'][$i] = str_replace(',', '', $_POST['ne_cash'][$i]);
	$_POST['ne_card'][$i] = str_replace(',', '', $_POST['ne_card'][$i]);
	$_POST['ne_total'][$i] = str_replace(',', '', $_POST['ne_total'][$i]);
	$_POST['ne_expenses'] = str_replace(',', '', $_POST['ne_expenses']);
	$_POST['ne_deposit'] = str_replace(',', '', $_POST['ne_deposit']);
	$_POST['ne_balance'] = str_replace(',', '', $_POST['ne_balance']);
	
	$sql = "insert into {$none['est_imprest']}  set

	mb_id = '{$member['mb_id']}',
	nw_code = '{$nw_code}',
	ne_date = '{$ne_date}',
	ne_trade_date = '{$_POST['ne_trade_date'][$i]}',
	ne_account_name = '{$_POST['ne_account_name'][$i]}',
	ne_summary = '{$_POST['ne_summary'][$i]}',
	ne_user = '{$_POST['ne_user'][$i]}',
	ne_cash = '{$_POST['ne_cash'][$i]}',
	ne_card = '{$_POST['ne_card'][$i]}',
	ne_total = '{$_POST['ne_total'][$i]}',
	ne_expenses = '{$_POST['ne_expenses']}',
	ne_deposit = '{$_POST['ne_deposit']}',
	ne_balance = '{$_POST['ne_balance']}',
	ne_etc = '{$_POST['ne_etc'][$i]}',
	ne_datetime = '".G5_TIME_YMDHIS."',
	ne_ip = '".$_SERVER['REMOTE_ADDR']."'

	";

	sql_query($sql, true);
	
}

alert('전도금 정산서가 업데이트 되었습니다.');