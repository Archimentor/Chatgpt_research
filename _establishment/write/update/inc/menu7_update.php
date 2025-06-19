<?php 
include_once('../../../../_common.php');

if($is_guest) alert('로그인 후 이용바랍니다.');


//전부 삭제
//@sql_query("delete from {$none['est_execution']} where nw_code = '{$nw_code}' and ne_date = '{$ne_date}'");


for($i=0; $i<count($_POST['ns_upche']); $i++) {
	
	
	if(!$_POST['ns_upche'][$i]) continue;
	
	$ne_name_type = 0;

	//업체 직접입력일 경우
	if($_POST['ns_upche'][$i] == "add" || !is_numeric($_POST['ns_upche'][$i]) ) {
		$ne_name = $_POST['ns_upche_txt'][$i];
		$ne_name_type = 1;
	} else {
		$ne_name = $_POST['ns_upche'][$i];
	}
	
	//콤마 모두제거
	$_POST['ne_price1'][$i] = str_replace(',', '', $_POST['ne_price1'][$i]);
	$_POST['ne_price2'][$i] = str_replace(',', '', $_POST['ne_price2'][$i]);
	$_POST['ne_price3'][$i] = str_replace(',', '', $_POST['ne_price3'][$i]);
	$_POST['ne_price4'][$i] = str_replace(',', '', $_POST['ne_price4'][$i]);
	$_POST['ne_price5'][$i] = str_replace(',', '', $_POST['ne_price5'][$i]);
	$_POST['ne_price6'][$i] = str_replace(',', '', $_POST['ne_price6'][$i]);
	$_POST['vat1'][$i] = str_replace(',', '', $_POST['vat1'][$i]);
	$_POST['vat2'][$i] = str_replace(',', '', $_POST['vat2'][$i]);
	$_POST['vat3'][$i] = str_replace(',', '', $_POST['vat3'][$i]);
	$_POST['ne_total_price1'][$i] = str_replace(',', '', $_POST['ne_total_price1'][$i]);
	$_POST['ne_total_price2'][$i] = str_replace(',', '', $_POST['ne_total_price2'][$i]);
	$_POST['ne_total_price3'][$i] = str_replace(',', '', $_POST['ne_total_price3'][$i]);
	
	//기성현황
	for($e=1; $e<=10; $e++) {
		
		if(!$_POST['ne_detail_date'][$e][$i]) continue;
		
		$_POST['ne_detail_price1'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price1'][$e][$i]);
		$_POST['ne_detail_price2'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price2'][$e][$i]);
		$_POST['ne_detail_price3'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price3'][$e][$i]);
		$_POST['ne_detail_price4'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price4'][$e][$i]);
		$_POST['ne_detail_price5'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price5'][$e][$i]);
		$_POST['ne_detail_price6'][$e][$i] = str_replace(',', '', $_POST['ne_detail_price6'][$e][$i]);
		
		//문자열조합
		${'ne_detail_info'.$e} = $_POST['ne_detail_date'][$e][$i]."^".$_POST['ne_detail_price1'][$e][$i]."^".$_POST['ne_detail_price2'][$e][$i]."^".$_POST['ne_detail_price3'][$e][$i]."^".$_POST['ne_detail_price4'][$e][$i]."^".$_POST['ne_detail_price5'][$e][$i]."^".$_POST['ne_detail_price6'][$e][$i];
	}
	
	
	$sql_common = "
	mb_id = '{$member['mb_id']}',
	nw_code = '{$nw_code}',
	
	ne_name = '{$ne_name}',
	ne_name_type = '{$ne_name_type}',
	ne_gongjong = '{$_POST['ne_gongjong'][$i]}',
	ne_price1 = '{$_POST['ne_price1'][$i]}',
	ne_price2 = '{$_POST['ne_price2'][$i]}',
	ne_price3 = '{$_POST['ne_price3'][$i]}',
	ne_price4 = '{$_POST['ne_price4'][$i]}',
	ne_price5 = '{$_POST['ne_price5'][$i]}',
	ne_price6 = '{$_POST['ne_price6'][$i]}',
	ne_vat1 = '{$_POST['vat1'][$i]}',
	ne_vat2 = '{$_POST['vat2'][$i]}',
	ne_vat3 = '{$_POST['vat3'][$i]}',
	ne_total_price1 = '{$_POST['ne_total_price1'][$i]}',
	ne_total_price2 = '{$_POST['ne_total_price2'][$i]}',
	ne_total_price3 = '{$_POST['ne_total_price3'][$i]}',
	
	ne_detail_price1 = '{$ne_detail_info1}',
	ne_detail_price2 = '{$ne_detail_info2}',
	ne_detail_price3 = '{$ne_detail_info3}',
	ne_detail_price4 = '{$ne_detail_info4}',
	ne_detail_price5 = '{$ne_detail_info5}',
	ne_detail_price6 = '{$ne_detail_info6}',
	ne_detail_price7 = '{$ne_detail_info7}',
	ne_detail_price8 = '{$ne_detail_info8}',
	ne_detail_price9 = '{$ne_detail_info9}',
	ne_detail_price10 = '{$ne_detail_info10}',
	
	ne_datetime = '".G5_TIME_YMDHIS."',
	ne_ip = '".$_SERVER['REMOTE_ADDR']."'
	";
	
	if($_POST['seq'][$i]) {
		$sql = "update {$none['est_execution']}  set {$sql_common} where seq = '{$_POST['seq'][$i]}'";
		sql_query($sql, true);
		
		@sql_query("delete from {$none['est_execution_txt']} where execution_id = '{$_POST['seq'][$i]}' and ne_date = '{$ne_date}'");
		
		
			$sql2 = "insert {$none['est_execution_txt']} set 
			mb_id = '{$member['mb_id']}',
			nw_code = '{$nw_code}',
			ne_date = '{$ne_date}',
			execution_id = '{$_POST['seq'][$i]}',
			ne_txt1 = '{$_POST['ne_txt1'][$i]}',
			ne_txt2 = '{$_POST['ne_txt2'][$i]}',
			ne_txt3 = '{$_POST['ne_txt3'][$i]}',
			ne_txt4 = '{$_POST['ne_txt4'][$i]}',
			ne_txt5 = '{$_POST['ne_txt5'][$i]}',
			ne_txt6 = '{$_POST['ne_txt6'][$i]}',
			ne_txt7 = '{$_POST['ne_txt7'][$i]}',
			ne_txt8 = '{$_POST['ne_txt8'][$i]}',
			ne_txt9 = '{$_POST['ne_txt9'][$i]}',
			ne_txt10 = '{$_POST['ne_txt10'][$i]}',
			ne_txt11 = '{$_POST['ne_txt11'][$i]}',
			ne_txt12 = '{$_POST['ne_txt12'][$i]}',
			ne_txt13 = '{$_POST['ne_txt13'][$i]}',
			ne_txt14 = '{$_POST['ne_txt14'][$i]}',
			ne_etc = '{$_POST['ne_etc'][$i]}',
			ne_datetime = '".G5_TIME_YMDHIS."',
			ne_ip = '".$_SERVER['REMOTE_ADDR']."'
			
			";
		
		sql_query($sql2, true);
		
	} else {
		$sql = "insert into {$none['est_execution']}  set ne_date = '{$ne_date}', {$sql_common}";
		sql_query($sql, true);
		
		$eid = sql_insert_id();
		
		$sql2 = "insert {$none['est_execution_txt']} set 
		mb_id = '{$member['mb_id']}',
		nw_code = '{$nw_code}',
		ne_date = '{$ne_date}',
		execution_id = '{$eid}',
		ne_txt1 = '{$_POST['ne_txt1'][$i]}',
		ne_txt2 = '{$_POST['ne_txt2'][$i]}',
		ne_txt3 = '{$_POST['ne_txt3'][$i]}',
		ne_txt4 = '{$_POST['ne_txt4'][$i]}',
		ne_txt5 = '{$_POST['ne_txt5'][$i]}',
		ne_txt6 = '{$_POST['ne_txt6'][$i]}',
		ne_txt7 = '{$_POST['ne_txt7'][$i]}',
		ne_txt8 = '{$_POST['ne_txt8'][$i]}',
		ne_txt9 = '{$_POST['ne_txt9'][$i]}',
		ne_txt10 = '{$_POST['ne_txt10'][$i]}',
		ne_txt11 = '{$_POST['ne_txt11'][$i]}',
		ne_txt12 = '{$_POST['ne_txt12'][$i]}',
		ne_txt13 = '{$_POST['ne_txt13'][$i]}',
		ne_txt14 = '{$_POST['ne_txt14'][$i]}',
		ne_etc = '{$_POST['ne_etc'][$i]}',
		ne_datetime = '".G5_TIME_YMDHIS."',
		ne_ip = '".$_SERVER['REMOTE_ADDR']."'
		";
		
		sql_query($sql2, true);
	}
	
	
	//문자열 변수초기화
	$ne_detail_info1 = "";
	$ne_detail_info2 = "";
	$ne_detail_info3 = "";
	$ne_detail_info4 = "";
	$ne_detail_info5 = "";
	$ne_detail_info6 = "";
	$ne_detail_info7 = "";
	$ne_detail_info8 = "";
	$ne_detail_info9 = "";
	$ne_detail_info10 = "";
}

alert('집행내역서(외주)가 업데이트 되었습니다.');