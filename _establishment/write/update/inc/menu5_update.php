<?php 
include_once('../../../../_common.php');

if($is_guest) alert('로그인 후 이용바랍니다.');


//전부 삭제
@sql_query("delete from {$none['est_foodcost']} where nw_code = '{$nw_code}' and ne_date = '{$ne_date}'");


$ne_data = "";
for($i=0; $i<count($_POST['ne_trade_date']); $i++) {

	$ne_data .= $_POST['ne_trade_date'][$i];
	$ne_data .= "^".$_POST['ne_food1_qty'][$i];
	$ne_data .= "^".$_POST['ne_food1_danga'][$i];
	$ne_data .= "^".$_POST['ne_food1_price'][$i];
	
	$ne_data .= "|".$_POST['ne_food2_qty'][$i];
	$ne_data .= "^".$_POST['ne_food2_danga'][$i];
	$ne_data .= "^".$_POST['ne_food2_price'][$i];
	
	$ne_data .= "|".$_POST['ne_food3_qty'][$i];
	$ne_data .= "^".$_POST['ne_food3_danga'][$i];
	$ne_data .= "^".$_POST['ne_food3_price'][$i];
	
	$ne_data .= "|".$_POST['ne_food4_qty'][$i];
	$ne_data .= "^".$_POST['ne_food4_danga'][$i];
	$ne_data .= "^".$_POST['ne_food4_price'][$i];
	
	$ne_data .= "|".$_POST['ne_food5_qty'][$i];
	$ne_data .= "^".$_POST['ne_food5_danga'][$i];
	$ne_data .= "^".$_POST['ne_food5_price'][$i];
	
	$ne_data .= "|".$_POST['ne_food6_qty'][$i];
	$ne_data .= "^".$_POST['ne_food6_price'][$i];
	
	$ne_data .= "|".$_POST['ne_etc'][$i];
	
	
	$sql = "insert into {$none['est_foodcost']}  set

	mb_id = '{$member['mb_id']}',
	nw_code = '{$nw_code}',
	ne_date = '{$ne_date}',
	ne_name = '{$ne_name}',
	ne_bank = '{$ne_bank}',
	ne_account = '{$ne_account}',
	ne_holder = '{$ne_holder}',
	ne_data = '{$ne_data}',
	ne_datetime = '".G5_TIME_YMDHIS."',
	ne_ip = '".$_SERVER['REMOTE_ADDR']."'

	";

	sql_query($sql, true);
	
	unset($ne_data);
}





alert('식대 정보가 업데이트 되었습니다.');
