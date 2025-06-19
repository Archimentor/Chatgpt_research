<?php 
include_once('../../../../_common.php');

if($is_guest) alert('로그인 후 이용바랍니다.');

echo count($_POST['nw_subject']);

for($i=0; $i<count($_POST['nw_subject']); $i++) {
	
		
	
	$ne_detail_arr = array();
	//기성현황
	for($e=0; $e<25; $e++) {
		
		if(!$_POST['ne_detail_date'][$e][$i]) continue;
		
		$_POST['ne_detail_danga'][$e][$i] = str_replace(',', '', $_POST['ne_detail_danga'][$e][$i]);
		$_POST['ne_detail_price'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price'][$e][$i]);
		$_POST['ne_detail_vat'][$e][$i] = str_replace(',', '', $_POST['ne_detail_vat'][$e][$i]);
		$_POST['ne_detail_total'][$e][$i] = str_replace(',', '', $_POST['ne_detail_total'][$e][$i]);
		
		//문자열조합
		$ne_detail_arr[] = $_POST['ne_detail_date'][$e][$i]."^". $_POST['ne_detail_name'][$e][$i]."^". $_POST['ne_detail_standard'][$e][$i]."^". $_POST['ne_detail_unit'][$e][$i]."^". $_POST['ne_detail_qty'][$e][$i]."^". $_POST['ne_detail_danga'][$e][$i]."^". $_POST['ne_detail_price'][$e][$i]."^". $_POST['ne_detail_vat'][$e][$i]."^". $_POST['ne_detail_total'][$e][$i]."^". $_POST['ne_detail_etc'][$e][$i];
	}
		
	$ne_detail_info = @implode('|', $ne_detail_arr);
	
	$sql_common = "
	mb_id = '{$member['mb_id']}',
	nw_code = '{$nw_code}',
	ne_detail = '{$ne_detail_info}',
	ne_file1 = '{$_POST['ne_file1'][$i]}',
	ne_file2 = '{$_POST['ne_file2'][$i]}',
	ne_file3 = '{$_POST['ne_file3'][$i]}',
	ne_etc = '{$_POST['ne_etc'][$i]}',
	ne_datetime = '".G5_TIME_YMDHIS."',
	ne_ip = '".$_SERVER['REMOTE_ADDR']."'
	";
	
	if($_POST['seq'][$i]) {
		$sql = "update {$none['est_etc']}  set {$sql_common} where seq = '{$_POST['seq'][$i]}'";
		sql_query($sql, true);
	} else {
		$sql = "insert into {$none['est_etc']}  set ne_date = '{$ne_date}', {$sql_common}";
		sql_query($sql, true);
	}
	
	$ne_detail_arr = "";
	$ne_detail_info = "";
}
alert('집행내역서(기타경비)가 업데이트 되었습니다.');