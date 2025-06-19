<?php 
include_once('../../_common.php');

if($is_guest) alert('권한이 없습니다.', G5_URL);


$sql_common = "
work_id = '$work_id',
ns_date = '$ns_date',
ns_wather = '$ns_wather',
ns_today_his = '$ns_today_his',
ns_tomorrow_his = '$ns_tomorrow_his',
ns_persent = '$ns_persent',
ns_etc = '$ns_etc'

";


if($w == '') {
	
	$sql = " insert into {$none['smart_list']} set {$sql_common},  ns_datetime = '".G5_TIME_YMDHIS."', ns_ip = '".$_SERVER['REMOTE_ADDR']."'";
	sql_query($sql);
	
	$ns_id = sql_insert_id();

	//임시로 업로드 된 파일 uid 변경
	for($i=0; $i<count($_POST['file_list']); $i++) {
		sql_query("update {$g5['board_file_table']} set wr_id = '$ns_id', bf_no = '{$i}' where bf_change_id = {$_POST['uid']} and bo_table = 'smart'");
	}

	$msg = "스마트일보가 등록 되었습니다.";
	$url = "/_worksite/list/menu3_list.php";
		
} else if($w == 'u') {
	
	$sql = " update {$none['smart_list']} set {$sql_common}, ns_updatetime = '".G5_TIME_YMDHIS."', ns_ip = '".$_SERVER['REMOTE_ADDR']."' where seq = '$seq'";
	sql_query($sql, true);
	$ns_id = $seq;

	//임시로 업로드 된 파일 uid 변경
	for($i=0; $i<count($_POST['file_list']); $i++) {
		sql_query("update {$g5['board_file_table']} set wr_id = '$seq' where bf_change_id = {$seq} and bo_table = 'smart'");
	}
	
	$msg = "스마트일보가 수정 되었습니다.";
	$url = "";
} else if($w == 'd') {
	
	
	
	$sql = "delete from {$none['smart_list']} where seq = '$seq'";
	sql_query($sql);
	
	//기타 db삭제 
	sql_query("delete from {$none['smart_jajae']} where ns_id = '$ns_id'");
	sql_query("delete from {$none['smart_gongjong']} where ns_id = '$ns_id'");
	sql_query("delete from {$none['smart_machine']} where ns_id = '$ns_id'");
	
	
	alert('스마트일보가 삭제되었습니다.');
}



if($w == '' || $w == 'u') {
	
	//일단 모두 삭제 
	sql_query("delete from {$none['smart_jajae']} where ns_id = '$ns_id'");
	sql_query("delete from {$none['smart_gongjong']} where ns_id = '$ns_id'");
	sql_query("delete from {$none['smart_machine']} where ns_id = '$ns_id'");
	
	//자재반입 입력
	for($i=0; $i<count($_POST['k']); $i++) {
		
		$v = $_POST['k'][$i]; //실제번호 입력
		
		if($_POST['rowspan'][$v] == 1) {

			$sql = "insert into {$none['smart_jajae']} set 
			
			ns_id = '$ns_id',
			ns_name = '{$_POST['jajae_name'][$v]}',
			ns_option = '{$_POST['jajae_option'][$v]}',
			ns_dan = '{$_POST['jajae_dan'][$v]}',
			ns_ycnt = '{$_POST['jajae_ycnt'][$v]}',
			ns_tcnt = '{$_POST['jajae_tcnt'][$v]}',
			ns_stotal = '{$_POST['jajae_stotal'][$v]}',
			ns_etc = '{$_POST['jajae_etc'][$v]}'

			";
			
			sql_query($sql, true);
		} else {
			
			for($z=0; $z<count($_POST['jajae_option'][$v]); $z++) {
				 
				$sql = "insert into {$none['smart_jajae']} set 
			
				ns_id = '$ns_id',
				ns_name = '{$_POST['jajae_name'][$v]}',
				ns_option = '{$_POST['jajae_option'][$v][$z]}',
				ns_dan = '{$_POST['jajae_dan'][$v]}',
				ns_ycnt = '{$_POST['jajae_ycnt'][$v][$z]}',
				ns_tcnt = '{$_POST['jajae_tcnt'][$v][$z]}',
				ns_stotal = '{$_POST['jajae_stotal'][$v][$z]}',
				ns_etc = '{$_POST['jajae_etc'][$v][$z]}'
				";
				sql_query($sql, true);
			}
		}
		
		
	}
	
	//장비 입력
	for($i=0; $i<count($_POST['machine_name']); $i++) {
		
			$sql = "insert into {$none['smart_machine']} set 
		
			ns_id = '$ns_id',
			ns_name = '{$_POST['machine_name'][$i]}',
			ns_option = '{$_POST['machine_option'][$i]}',
			ns_ycnt = '{$_POST['machine_ycnt'][$i]}',
			ns_tcnt = '{$_POST['machine_tcnt'][$i]}',
			ns_stotal = '{$_POST['machine_stotal'][$i]}'
			";
			sql_query($sql, true);

	}
	
	//공종 입력
	for($i=0; $i<count($_POST['gongjong']); $i++) {
		
			$sql = "insert into {$none['smart_gongjong']} set 
		
			ns_id = '$ns_id',
			ns_name = '{$_POST['gongjong'][$i]}',
		
			ns_ycnt = '{$_POST['gongjong_ycnt'][$i]}',
			ns_tcnt = '{$_POST['gongjong_tcnt'][$i]}',
			ns_stotal = '{$_POST['gongjong_stotal'][$i]}'
			";
			
			sql_query($sql, true);

	}
} else if($w == 'd') {
	//자재, 공종, 장비 모든 데이터 삭제
	sql_query("delete from {$none['smart_jajae']} where ns_id = '$ns_id'");
	sql_query("delete from {$none['smart_gongjong']} where ns_id = '$ns_id'");
	sql_query("delete from {$none['smart_machine']} where ns_id = '$ns_id'");
}

alert($msg, $url);