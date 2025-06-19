<?php 
include_once('../../../../_common.php');

if($is_guest) alert('로그인 후 이용바랍니다.');

for($i=0; $i<count($_POST['ne_name']); $i++) {
	
	// --- 추가된 부분 ---
	$seq = $_POST['seq'][$i];
	$delete_flag = $_POST['delete_flag'][$i];

	// 삭제 플래그가 '1'이고, seq 값이 있는 기존 데이터일 경우 DB에서 삭제
	if ($delete_flag == '1' && !empty($seq)) {
		// est_concrete_price 테이블에서 관련 데이터 먼저 삭제
		$sql_delete_price = "delete from {$none['est_concrete_price']} where concrete_id = '{$seq}'";
		sql_query($sql_delete_price, true);

		// est_concrete 테이블에서 메인 데이터 삭제
		$sql_delete_main = "delete from {$none['est_concrete']} where seq = '{$seq}'";
		sql_query($sql_delete_main, true);
		
		continue; // 삭제 처리 후 다음 루프로 넘어감
	}
	// --- 여기까지 ---

	if(!$_POST['ne_name'][$i]) continue;
	
	// 콤마 제거
	$_POST['ne_qty1'][$i] = str_replace(',', '', $_POST['ne_qty1'][$i]);
	$_POST['ne_qty2'][$i] = str_replace(',', '', $_POST['ne_qty2'][$i]);
	$_POST['ne_qty3'][$i] = str_replace(',', '', $_POST['ne_qty3'][$i]);
	$_POST['ne_qty4'][$i] = str_replace(',', '', $_POST['ne_qty4'][$i]);
	$_POST['ne_price1'][$i] = str_replace(',', '', $_POST['ne_price1'][$i]);
	$_POST['ne_price2'][$i] = str_replace(',', '', $_POST['ne_price2'][$i]);
	$_POST['ne_price3'][$i] = str_replace(',', '', $_POST['ne_price3'][$i]);
	$_POST['ne_price4'][$i] = str_replace(',', '', $_POST['ne_price4'][$i]);
	$_POST['ne_danga1'][$i] = str_replace(',', '', $_POST['ne_danga1'][$i]);
	$_POST['ne_danga2'][$i] = str_replace(',', '', $_POST['ne_danga2'][$i]);
	
	$sql_common = "
		mb_id = '{$member['mb_id']}',
		nw_code = '{$nw_code}',
		ne_type = '{$_POST['ne_type'][$i]}',
		ne_name = '{$_POST['ne_name'][$i]}',
		ne_standard = '{$_POST['ne_standard'][$i]}',
		ne_unit = '{$_POST['ne_unit'][$i]}',
		ne_qty1 = '{$_POST['ne_qty1'][$i]}',
		ne_qty4 = '{$_POST['ne_qty4'][$i]}',
		ne_danga1 = '{$_POST['ne_danga1'][$i]}',
		ne_price1 = '{$_POST['ne_price1'][$i]}',
		ne_price4 = '{$_POST['ne_price4'][$i]}',
		ne_etc = '{$_POST['ne_etc'][$i]}',
		ne_datetime = '".G5_TIME_YMDHIS."',
		ne_ip = '".$_SERVER['REMOTE_ADDR']."'
	";

	if($_POST['seq'][$i]) { // 기존 데이터 업데이트
		$sql = "update {$none['est_concrete']} set {$sql_common} where seq = '{$_POST['seq'][$i]}'";
		sql_query($sql, true);
		
		@sql_query("delete from {$none['est_concrete_price']} where concrete_id = '{$_POST['seq'][$i]}' and ne_date = '{$ne_date}'");
		
		$sql2 = "insert into {$none['est_concrete_price']} set 
			concrete_id = '{$_POST['seq'][$i]}',
			mb_id = '{$member['mb_id']}',
			nw_code = '{$nw_code}',
			ne_date = '{$ne_date}',
			ne_qty2 = '{$_POST['ne_qty2'][$i]}',
			ne_qty3 = '{$_POST['ne_qty3'][$i]}',
			ne_danga2 = '{$_POST['ne_danga2'][$i]}',
			ne_price2 = '{$_POST['ne_price2'][$i]}',
			ne_price3 = '{$_POST['ne_price3'][$i]}',
			ne_datetime = '".G5_TIME_YMDHIS."',
			ne_ip = '".$_SERVER['REMOTE_ADDR']."'
		";
		sql_query($sql2, true);

	} else { // 신규 데이터 추가
		$sql = "insert into {$none['est_concrete']} set ne_date = '{$ne_date}', {$sql_common}";
		sql_query($sql, true);
		
		$eid = sql_insert_id();
		
		$sql2 = "insert into {$none['est_concrete_price']} set 
			concrete_id = '{$eid}',
			mb_id = '{$member['mb_id']}',
			nw_code = '{$nw_code}',
			ne_date = '{$ne_date}',
			ne_qty2 = '{$_POST['ne_qty2'][$i]}',
			ne_qty3 = '{$_POST['ne_qty3'][$i]}',
			ne_danga2 = '{$_POST['ne_danga2'][$i]}',
			ne_price2 = '{$_POST['ne_price2'][$i]}',
			ne_price3 = '{$_POST['ne_price3'][$i]}',
			ne_datetime = '".G5_TIME_YMDHIS."',
			ne_ip = '".$_SERVER['REMOTE_ADDR']."'
		";
		sql_query($sql2, true);
	}
}

alert('철근/레미콘 현황이 업데이트 되었습니다.');