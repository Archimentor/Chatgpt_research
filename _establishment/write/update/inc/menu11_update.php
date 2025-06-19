<?php 
include_once('../../../../_common.php');

if($is_guest) alert('로그인 후 이용바랍니다.');



for($i=0; $i<count($_POST['ne_upche']); $i++) {
	
		
	if(!$_POST['ne_upche'][$i]) continue;
	$ne_detail_arr = array();
	//기성현황
	for($e=0; $e<10; $e++) {
		
		if(!$_POST['ne_detail_price1'][$e][$i]) continue;
		
		$_POST['ne_detail_price1'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price1'][$e][$i]);
		$_POST['ne_detail_price2'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price2'][$e][$i]);
		$_POST['ne_detail_price3'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price3'][$e][$i]);
		$_POST['ne_detail_price4'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price4'][$e][$i]);
		$_POST['ne_detail_price5'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price5'][$e][$i]);
		$_POST['ne_detail_price6'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price6'][$e][$i]);
		$_POST['ne_detail_price7'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price7'][$e][$i]);
		$_POST['ne_detail_price8'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price8'][$e][$i]);
		$_POST['ne_detail_price9'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price9'][$e][$i]);
		
		//문자열조합
		$ne_detail_arr[] = $_POST['ne_detail_gubun'][$e][$i]."^".$_POST['ne_detail_gongjong'][$e][$i]."^".$_POST['ne_detail_price1'][$e][$i]."^".$_POST['ne_detail_price2'][$e][$i]."^".$_POST['ne_detail_price3'][$e][$i]."^".$_POST['ne_detail_price4'][$e][$i]."^".$_POST['ne_detail_price5'][$e][$i]."^".$_POST['ne_detail_price6'][$e][$i]."^".$_POST['ne_detail_price7'][$e][$i]."^".$_POST['ne_detail_price8'][$e][$i]."^".$_POST['ne_detail_price9'][$e][$i]."^".$_POST['ne_detail_etc'][$e][$i] ;
	}
		
	$ne_detail_info = @implode('|', $ne_detail_arr);
	
	$sql_common = "
	mb_id = '{$member['mb_id']}',
	nw_code = '{$nw_code}',
	ne_upche = '{$_POST['ne_upche'][$i]}',
	ne_gongjong = '{$_POST['ne_gongjong'][$i]}',
	ne_detail = '{$ne_detail_info}',
	
	ne_etc = '{$_POST['ne_etc'][$i]}',
	ne_datetime = '".G5_TIME_YMDHIS."',
	ne_ip = '".$_SERVER['REMOTE_ADDR']."'
	";
	
	if($_POST['seq'][$i]) {
		$sql = "update {$none['est_nomu']}  set {$sql_common} where seq = '{$_POST['seq'][$i]}'";
		sql_query($sql, true);
	} else {
		$sql = "insert into {$none['est_nomu']}  set ne_date = '{$ne_date}', {$sql_common}";
		sql_query($sql, true);
	}
	
	$ne_detail_arr = "";
	$ne_detail_info = "";
}
alert('집행내역서(노무비)가 업데이트 되었습니다.');