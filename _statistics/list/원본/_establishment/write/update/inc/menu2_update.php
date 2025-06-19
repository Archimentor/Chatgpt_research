<?php 
include_once('../../../../_common.php');

if($mode1 == '') {
	for($i=0; $i<count($_POST['s1_name']); $i++) {
		
		if(!$_POST['s1_name'][$i]) continue;
		
		$sql = "insert into {$none['est_jungsan']} set 
		nw_code = '$nw_code',
		mb_id = '{$member['mb_id']}',
		ne_type = '{$_POST['ne_type'][$i]}',
		ne_date = '$ne_date',
		ne_name = '{$_POST['s1_name'][$i]}',
		ne_gongjong = '{$_POST['s1_gongjong'][$i]}',
		ne_sdate = '{$_POST['s1_sdate'][$i]}',
		ne_edate = '{$_POST['s1_edate'][$i]}',
		ne_price1 = '{$_POST['s1_price1'][$i]}',
		ne_price2 = '{$_POST['s1_price2'][$i]}',
		ne_price3 = '{$_POST['s1_price3'][$i]}',
		ne_price4 = '{$_POST['s1_price4'][$i]}',
		ne_price5 = '{$_POST['s1_price5'][$i]}',
	
		
		
		ne_price18 = '{$_POST['s1_price18'][$i]}',
		ne_bank = '{$_POST['s1_bank'][$i]}',
		ne_account = '{$_POST['s1_account'][$i]}',
		ne_accname = '{$_POST['s1_accname'][$i]}',
		ne_ceo = '{$_POST['s1_ceo'][$i]}',
		ne_etc = '{$_POST['s1_etc'][$i]}',
		
		
		ne_datetime = '".G5_TIME_YMDHIS."'
		
		";
		
		sql_query($sql, true);
		$id = sql_insert_id();
		$sql = "insert into {$none['est_jungsan_price']} set 
		parent_id = '{$id}',
		nw_code = '$nw_code',
		ne_date = '$ne_date',
		ne_price9 = '{$_POST['s1_price9'][$i]}',
		ne_price10 = '{$_POST['s1_price10'][$i]}',
		ne_price11 = '{$_POST['s1_price11'][$i]}',
		ne_price12 = '{$_POST['s1_price12'][$i]}',
		ne_price13 = '{$_POST['s1_price13'][$i]}',
		ne_price14 = '{$_POST['s1_price14'][$i]}'
		
		";
		sql_query($sql, true);
		
	}
	
	$msg = "등록";

} else if($mode1 == 'u') {
	
	for($i=0; $i<count($_POST['s1_name']); $i++) {
		
		if(!$_POST['s1_seq'][$i]){
			
			$sql = "insert into {$none['est_jungsan']} set 
			nw_code = '$nw_code',
			mb_id = '{$member['mb_id']}',
			ne_type = '1',
			ne_date = '$ne_date',
			ne_name = '{$_POST['s1_name'][$i]}',
			ne_gongjong = '{$_POST['s1_gongjong'][$i]}',
			ne_sdate = '{$_POST['s1_sdate'][$i]}',
			ne_edate = '{$_POST['s1_edate'][$i]}',
			ne_price1 = '{$_POST['s1_price1'][$i]}',
			ne_price2 = '{$_POST['s1_price2'][$i]}',
			ne_price3 = '{$_POST['s1_price3'][$i]}',
			ne_price4 = '{$_POST['s1_price4'][$i]}',
			ne_price5 = '{$_POST['s1_price5'][$i]}',
			
			
			
			ne_price18 = '{$_POST['s1_price18'][$i]}',
			ne_bank = '{$_POST['s1_bank'][$i]}',
			ne_account = '{$_POST['s1_account'][$i]}',
			ne_accname = '{$_POST['s1_accname'][$i]}',
			ne_ceo = '{$_POST['s1_ceo'][$i]}',
			ne_etc = '{$_POST['s1_etc'][$i]}',
			
			
			ne_datetime = '".G5_TIME_YMDHIS."'
			
			";
			
			sql_query($sql, true);
			$id = sql_insert_id();
			$sql = "insert into {$none['est_jungsan_price']} set 
			parent_id = '{$id}',
			nw_code = '$nw_code',
			ne_date = '$ne_date',
			ne_price9 = '{$_POST['s1_price9'][$i]}',
			ne_price10 = '{$_POST['s1_price10'][$i]}',
			ne_price11 = '{$_POST['s1_price11'][$i]}',
			ne_price12 = '{$_POST['s1_price12'][$i]}',
			ne_price13 = '{$_POST['s1_price13'][$i]}',
			ne_price14 = '{$_POST['s1_price14'][$i]}'
			
			";
			sql_query($sql, true);
			
		} else if($_POST['s1_name'][$i]) {
		
		
			$sql = "update {$none['est_jungsan']} set 
			ne_name = '{$_POST['s1_name'][$i]}',
			ne_gongjong = '{$_POST['s1_gongjong'][$i]}',
			ne_sdate = '{$_POST['s1_sdate'][$i]}',
			ne_edate = '{$_POST['s1_edate'][$i]}',
			ne_price1 = '{$_POST['s1_price1'][$i]}',
			ne_price2 = '{$_POST['s1_price2'][$i]}',
			ne_price3 = '{$_POST['s1_price3'][$i]}',
			ne_price4 = '{$_POST['s1_price4'][$i]}',
			ne_price5 = '{$_POST['s1_price5'][$i]}',
			
			
			
			
			ne_price18 = '{$_POST['s1_price18'][$i]}',
			ne_bank = '{$_POST['s1_bank'][$i]}',
			ne_account = '{$_POST['s1_account'][$i]}',
			ne_accname = '{$_POST['s1_accname'][$i]}',
			ne_ceo = '{$_POST['s1_ceo'][$i]}',
			ne_etc = '{$_POST['s1_etc'][$i]}',
			
			
			ne_datetime = '".G5_TIME_YMDHIS."'
			
			where seq = '{$_POST['s1_seq'][$i]}'
			";
			
			sql_query($sql);
			sql_query("delete from {$none['est_jungsan_price']} where parent_id ='{$_POST['s1_seq'][$i]}' and ne_date = '$ne_date'");
		
			$sql = "insert into {$none['est_jungsan_price']} set 
			parent_id = '{$_POST['s1_seq'][$i]}',
			nw_code = '$nw_code',
			ne_date = '$ne_date',
			ne_price9 = '{$_POST['s1_price9'][$i]}',
			ne_price10 = '{$_POST['s1_price10'][$i]}',
			ne_price11 = '{$_POST['s1_price11'][$i]}',
			ne_price12 = '{$_POST['s1_price12'][$i]}',
			ne_price13 = '{$_POST['s1_price13'][$i]}',
			ne_price14 = '{$_POST['s1_price14'][$i]}'
			
			";
			sql_query($sql, true);
			
			
		}
		
		
	}
	$msg = "수정";
}

//자재비
if($mode2 == '') {
	for($i=0; $i<count($_POST['s2_name']); $i++) {
		
		if(!$_POST['s2_name'][$i]) continue;
		
		$sql = "insert into {$none['est_jungsan']} set 
		nw_code = '$nw_code',
		mb_id = '{$member['mb_id']}',
		ne_type = '2',
		ne_date = '$ne_date',
		ne_name = '{$_POST['s2_name'][$i]}',
		ne_gongjong = '{$_POST['s2_gongjong'][$i]}',
		ne_sdate = '{$_POST['s2_sdate'][$i]}',
		ne_edate = '{$_POST['s2_edate'][$i]}',
		ne_price1 = '{$_POST['s2_price1'][$i]}',
		ne_price2 = '{$_POST['s2_price2'][$i]}',
		ne_price3 = '{$_POST['s2_price3'][$i]}',
		ne_price4 = '{$_POST['s2_price4'][$i]}',
		ne_price5 = '{$_POST['s2_price5'][$i]}',
		
		
		
		ne_price18 = '{$_POST['s2_price18'][$i]}',
		ne_bank = '{$_POST['s2_bank'][$i]}',
		ne_account = '{$_POST['s2_account'][$i]}',
		ne_accname = '{$_POST['s2_accname'][$i]}',
		ne_ceo = '{$_POST['s2_ceo'][$i]}',
		ne_etc = '{$_POST['s2_etc'][$i]}',
		
		
		ne_datetime = '".G5_TIME_YMDHIS."'
		
		";
		
		sql_query($sql);
		$id = sql_insert_id();
		$sql = "insert into {$none['est_jungsan_price']} set 
		parent_id = '{$id}',
		nw_code = '$nw_code',
		ne_date = '$ne_date',
		ne_price9 = '{$_POST['s2_price9'][$i]}',
		ne_price10 = '{$_POST['s2_price10'][$i]}',
		ne_price11 = '{$_POST['s2_price11'][$i]}',
		ne_price12 = '{$_POST['s2_price12'][$i]}',
		ne_price13 = '{$_POST['s2_price13'][$i]}',
		ne_price14 = '{$_POST['s2_price14'][$i]}'
		
		";
		sql_query($sql, true);
	}
	
	$msg = "등록";

} else if($mode2 == 'u') {
	
	for($i=0; $i<count($_POST['s2_name']); $i++) {
		
		if(!$_POST['s2_seq'][$i]){
			
			$sql = "insert into {$none['est_jungsan']} set 
			nw_code = '$nw_code',
			mb_id = '{$member['mb_id']}',
			ne_type = '2',
			ne_date = '$ne_date',
			ne_name = '{$_POST['s2_name'][$i]}',
			ne_gongjong = '{$_POST['s2_gongjong'][$i]}',
			ne_sdate = '{$_POST['s2_sdate'][$i]}',
			ne_edate = '{$_POST['s2_edate'][$i]}',
			ne_price1 = '{$_POST['s2_price1'][$i]}',
			ne_price2 = '{$_POST['s2_price2'][$i]}',
			ne_price3 = '{$_POST['s2_price3'][$i]}',
			ne_price4 = '{$_POST['s2_price4'][$i]}',
			ne_price5 = '{$_POST['s2_price5'][$i]}',
		
			
			
			ne_price18 = '{$_POST['s2_price18'][$i]}',
			ne_bank = '{$_POST['s2_bank'][$i]}',
			ne_account = '{$_POST['s2_account'][$i]}',
			ne_accname = '{$_POST['s2_accname'][$i]}',
			ne_ceo = '{$_POST['s2_ceo'][$i]}',
			ne_etc = '{$_POST['s2_etc'][$i]}',
			
			
			ne_datetime = '".G5_TIME_YMDHIS."'
			
			";
			
			sql_query($sql);
			$id = sql_insert_id();
			$sql = "insert into {$none['est_jungsan_price']} set 
			parent_id = '{$id}',
			nw_code = '$nw_code',
			ne_date = '$ne_date',
			ne_price9 = '{$_POST['s2_price9'][$i]}',
			ne_price10 = '{$_POST['s2_price10'][$i]}',
			ne_price11 = '{$_POST['s2_price11'][$i]}',
			ne_price12 = '{$_POST['s2_price12'][$i]}',
			ne_price13 = '{$_POST['s2_price13'][$i]}',
			ne_price14 = '{$_POST['s2_price14'][$i]}'
			
			";
			sql_query($sql, true);
			
		} else if($_POST['s2_name'][$i]) {
		
		
			$sql = "update {$none['est_jungsan']} set 
			ne_name = '{$_POST['s2_name'][$i]}',
			ne_gongjong = '{$_POST['s2_gongjong'][$i]}',
			ne_sdate = '{$_POST['s2_sdate'][$i]}',
			ne_edate = '{$_POST['s2_edate'][$i]}',
			ne_price1 = '{$_POST['s2_price1'][$i]}',
			ne_price2 = '{$_POST['s2_price2'][$i]}',
			ne_price3 = '{$_POST['s2_price3'][$i]}',
			ne_price4 = '{$_POST['s2_price4'][$i]}',
			ne_price5 = '{$_POST['s2_price5'][$i]}',
			
			
			ne_price18 = '{$_POST['s2_price18'][$i]}',
			ne_bank = '{$_POST['s2_bank'][$i]}',
			ne_account = '{$_POST['s2_account'][$i]}',
			ne_accname = '{$_POST['s2_accname'][$i]}',
			ne_ceo = '{$_POST['s2_ceo'][$i]}',
			ne_etc = '{$_POST['s2_etc'][$i]}',
			
			
			ne_datetime = '".G5_TIME_YMDHIS."'
			
			where seq = '{$_POST['s2_seq'][$i]}'
			";
			
			sql_query($sql);
			sql_query("delete from {$none['est_jungsan_price']} where parent_id ='{$_POST['s2_seq'][$i]}' and ne_date = '$ne_date'");
		
			$sql = "insert into {$none['est_jungsan_price']} set 
			parent_id = '{$_POST['s2_seq'][$i]}',
			nw_code = '$nw_code',
			ne_date = '$ne_date',
			ne_price9 = '{$_POST['s2_price9'][$i]}',
			ne_price10 = '{$_POST['s2_price10'][$i]}',
			ne_price11 = '{$_POST['s2_price11'][$i]}',
			ne_price12 = '{$_POST['s2_price12'][$i]}',
			ne_price13 = '{$_POST['s2_price13'][$i]}',
			ne_price14 = '{$_POST['s2_price14'][$i]}'
			
			";
			sql_query($sql, true);
		
		}
		
		
	}
	$msg = "수정";
}

//장비비
if($mode3 == '') {
	for($i=0; $i<count($_POST['s3_name']); $i++) {
		
		if(!$_POST['s3_name'][$i]) continue;
		
		$sql = "insert into {$none['est_jungsan']} set 
		nw_code = '$nw_code',
		mb_id = '{$member['mb_id']}',
		ne_type = '3',
		ne_date = '$ne_date',
		ne_name = '{$_POST['s3_name'][$i]}',
		ne_gongjong = '{$_POST['s3_gongjong'][$i]}',
		ne_sdate = '{$_POST['s3_sdate'][$i]}',
		ne_edate = '{$_POST['s3_edate'][$i]}',
		ne_price1 = '{$_POST['s3_price1'][$i]}',
		ne_price2 = '{$_POST['s3_price2'][$i]}',
		ne_price3 = '{$_POST['s3_price3'][$i]}',
		ne_price4 = '{$_POST['s3_price4'][$i]}',
		ne_price5 = '{$_POST['s3_price5'][$i]}',
	
		
		
		ne_price18 = '{$_POST['s3_price18'][$i]}',
		ne_bank = '{$_POST['s3_bank'][$i]}',
		ne_account = '{$_POST['s3_account'][$i]}',
		ne_accname = '{$_POST['s3_accname'][$i]}',
		ne_ceo = '{$_POST['s3_ceo'][$i]}',
		ne_etc = '{$_POST['s3_etc'][$i]}',
		
		
		ne_datetime = '".G5_TIME_YMDHIS."'
		
		";
		
		sql_query($sql);
		$id = sql_insert_id();
		$sql = "insert into {$none['est_jungsan_price']} set 
		parent_id = '{$id}',
		nw_code = '$nw_code',
		ne_date = '$ne_date',
		ne_price9 = '{$_POST['s3_price9'][$i]}',
		ne_price10 = '{$_POST['s3_price10'][$i]}',
		ne_price11 = '{$_POST['s3_price11'][$i]}',
		ne_price12 = '{$_POST['s3_price12'][$i]}',
		ne_price13 = '{$_POST['s3_price13'][$i]}',
		ne_price14 = '{$_POST['s3_price14'][$i]}'
		
		";
		sql_query($sql, true);
	}
	
	$msg = "등록";

} else if($mode3 == 'u') {
	
	for($i=0; $i<count($_POST['s3_name']); $i++) {
		
		if(!$_POST['s3_seq'][$i]){
			
			if(!$_POST['s3_name'][$i]) continue;
				
			$sql = "insert into {$none['est_jungsan']} set 
			nw_code = '$nw_code',
			mb_id = '{$member['mb_id']}',
			ne_type = '3',
			ne_date = '$ne_date',
			ne_name = '{$_POST['s3_name'][$i]}',
			ne_gongjong = '{$_POST['s3_gongjong'][$i]}',
			ne_sdate = '{$_POST['s3_sdate'][$i]}',
			ne_edate = '{$_POST['s3_edate'][$i]}',
			ne_price1 = '{$_POST['s3_price1'][$i]}',
			ne_price2 = '{$_POST['s3_price2'][$i]}',
			ne_price3 = '{$_POST['s3_price3'][$i]}',
			ne_price4 = '{$_POST['s3_price4'][$i]}',
			ne_price5 = '{$_POST['s3_price5'][$i]}',
			
	
			
			
			ne_price18 = '{$_POST['s3_price18'][$i]}',
			ne_bank = '{$_POST['s3_bank'][$i]}',
			ne_account = '{$_POST['s3_account'][$i]}',
			ne_accname = '{$_POST['s3_accname'][$i]}',
			ne_ceo = '{$_POST['s3_ceo'][$i]}',
			ne_etc = '{$_POST['s3_etc'][$i]}',
			
			
			ne_datetime = '".G5_TIME_YMDHIS."'
			
			";
			
			sql_query($sql);
			$id = sql_insert_id();
			$sql = "insert into {$none['est_jungsan_price']} set 
			parent_id = '{$id}',
			nw_code = '$nw_code',
			ne_date = '$ne_date',
			ne_price9 = '{$_POST['s3_price9'][$i]}',
			ne_price10 = '{$_POST['s3_price10'][$i]}',
			ne_price11 = '{$_POST['s3_price11'][$i]}',
			ne_price12 = '{$_POST['s3_price12'][$i]}',
			ne_price13 = '{$_POST['s3_price13'][$i]}',
			ne_price14 = '{$_POST['s3_price14'][$i]}'
			
			";
			sql_query($sql, true);
			
		} else if($_POST['s3_name'][$i]) {
		
			
			
			$sql = "update {$none['est_jungsan']} set 
			ne_name = '{$_POST['s3_name'][$i]}',
			ne_gongjong = '{$_POST['s3_gongjong'][$i]}',
			ne_sdate = '{$_POST['s3_sdate'][$i]}',
			ne_edate = '{$_POST['s3_edate'][$i]}',
			ne_price1 = '{$_POST['s3_price1'][$i]}',
			ne_price2 = '{$_POST['s3_price2'][$i]}',
			ne_price3 = '{$_POST['s3_price3'][$i]}',
			ne_price4 = '{$_POST['s3_price4'][$i]}',
			ne_price5 = '{$_POST['s3_price5'][$i]}',
		
		
		
			
			ne_price18 = '{$_POST['s3_price18'][$i]}',
			ne_bank = '{$_POST['s3_bank'][$i]}',
			ne_account = '{$_POST['s3_account'][$i]}',
			ne_accname = '{$_POST['s3_accname'][$i]}',
			ne_ceo = '{$_POST['s3_ceo'][$i]}',
			ne_etc = '{$_POST['s3_etc'][$i]}',
			
			
			ne_datetime = '".G5_TIME_YMDHIS."'
			
			where seq = '{$_POST['s3_seq'][$i]}'
			";
			
			sql_query($sql);
			sql_query("delete from {$none['est_jungsan_price']} where parent_id ='{$_POST['s3_seq'][$i]}' and ne_date = '$ne_date'");
		
			$sql = "insert into {$none['est_jungsan_price']} set 
			parent_id = '{$_POST['s3_seq'][$i]}',
			nw_code = '$nw_code',
			ne_date = '$ne_date',
			ne_price9 = '{$_POST['s3_price9'][$i]}',
			ne_price10 = '{$_POST['s3_price10'][$i]}',
			ne_price11 = '{$_POST['s3_price11'][$i]}',
			ne_price12 = '{$_POST['s3_price12'][$i]}',
			ne_price13 = '{$_POST['s3_price13'][$i]}',
			ne_price14 = '{$_POST['s3_price14'][$i]}'
			
			";
			sql_query($sql, true);
		
		}
		
		
	}
	$msg = "수정";
}

//노무비
if($mode4 == '') {
	for($i=0; $i<count($_POST['s4_name']); $i++) {
		
		if(!$_POST['s4_name'][$i]) continue;
		
		$sql = "insert into {$none['est_jungsan']} set 
		nw_code = '$nw_code',
		mb_id = '{$member['mb_id']}',
		ne_type = '4',
		ne_date = '$ne_date',
		ne_name = '{$_POST['s4_name'][$i]}',
		ne_gongjong = '{$_POST['s4_gongjong'][$i]}',
		ne_sdate = '{$_POST['s4_sdate'][$i]}',
		ne_edate = '{$_POST['s4_edate'][$i]}',
		ne_price1 = '{$_POST['s4_price1'][$i]}',
		ne_price2 = '{$_POST['s4_price2'][$i]}',
		ne_price3 = '{$_POST['s4_price3'][$i]}',
		ne_price4 = '{$_POST['s4_price4'][$i]}',
		ne_price5 = '{$_POST['s4_price5'][$i]}',
		
	
		
		ne_price18 = '{$_POST['s4_price18'][$i]}',
		ne_bank = '{$_POST['s4_bank'][$i]}',
		ne_account = '{$_POST['s4_account'][$i]}',
		ne_accname = '{$_POST['s4_accname'][$i]}',
		ne_ceo = '{$_POST['s4_ceo'][$i]}',
		ne_etc = '{$_POST['s4_etc'][$i]}',
		
		
		ne_datetime = '".G5_TIME_YMDHIS."'
		
		";
		
		sql_query($sql);
		$id = sql_insert_id();
		$sql = "insert into {$none['est_jungsan_price']} set 
		parent_id = '{$id}',
		nw_code = '$nw_code',
		ne_date = '$ne_date',
		ne_price9 = '{$_POST['s4_price9'][$i]}',
		ne_price10 = '{$_POST['s4_price10'][$i]}',
		ne_price11 = '{$_POST['s4_price11'][$i]}',
		ne_price12 = '{$_POST['s4_price12'][$i]}',
		ne_price13 = '{$_POST['s4_price13'][$i]}',
		ne_price14 = '{$_POST['s4_price14'][$i]}'
		
		";
		sql_query($sql, true);
	}
	
	$msg = "등록";

} else if($mode4 == 'u') {
	
	for($i=0; $i<count($_POST['s4_name']); $i++) {
		
		if(!$_POST['s4_seq'][$i]){
			
			if(!$_POST['s4_name'][$i]) continue;
				
			$sql = "insert into {$none['est_jungsan']} set 
			nw_code = '$nw_code',
			mb_id = '{$member['mb_id']}',
			ne_type = '4',
			ne_date = '$ne_date',
			ne_name = '{$_POST['s4_name'][$i]}',
			ne_gongjong = '{$_POST['s4_gongjong'][$i]}',
			ne_sdate = '{$_POST['s4_sdate'][$i]}',
			ne_edate = '{$_POST['s4_edate'][$i]}',
			ne_price1 = '{$_POST['s4_price1'][$i]}',
			ne_price2 = '{$_POST['s4_price2'][$i]}',
			ne_price3 = '{$_POST['s4_price3'][$i]}',
			ne_price4 = '{$_POST['s4_price4'][$i]}',
			
			ne_price5 = '{$_POST['s4_price5'][$i]}',
		
			
			
			
			ne_price18 = '{$_POST['s4_price18'][$i]}',
			ne_bank = '{$_POST['s4_bank'][$i]}',
			ne_account = '{$_POST['s4_account'][$i]}',
			ne_accname = '{$_POST['s4_accname'][$i]}',
			ne_ceo = '{$_POST['s4_ceo'][$i]}',
			ne_etc = '{$_POST['s4_etc'][$i]}',
			
			
			ne_datetime = '".G5_TIME_YMDHIS."'
			
			";
			
			sql_query($sql, true);
			$id = sql_insert_id();
			$sql = "insert into {$none['est_jungsan_price']} set 
			parent_id = '{$id}',
			nw_code = '$nw_code',
			ne_date = '$ne_date',
			ne_price9 = '{$_POST['s4_price9'][$i]}',
			ne_price10 = '{$_POST['s4_price10'][$i]}',
			ne_price11 = '{$_POST['s4_price11'][$i]}',
			ne_price12 = '{$_POST['s4_price12'][$i]}',
			ne_price13 = '{$_POST['s4_price13'][$i]}',
			ne_price14 = '{$_POST['s4_price14'][$i]}'
			
			";
			sql_query($sql, true);
			
		} else if($_POST['s4_name'][$i]) {
		
		
			$sql = "update {$none['est_jungsan']} set 
			ne_name = '{$_POST['s4_name'][$i]}',
			ne_gongjong = '{$_POST['s4_gongjong'][$i]}',
			ne_sdate = '{$_POST['s4_sdate'][$i]}',
			ne_edate = '{$_POST['s4_edate'][$i]}',
			ne_price1 = '{$_POST['s4_price1'][$i]}',
			ne_price2 = '{$_POST['s4_price2'][$i]}',
			ne_price3 = '{$_POST['s4_price3'][$i]}',
			ne_price4 = '{$_POST['s4_price4'][$i]}',
			
			ne_price5 = '{$_POST['s4_price5'][$i]}',
			
			
			
			ne_price18 = '{$_POST['s4_price18'][$i]}',
			ne_bank = '{$_POST['s4_bank'][$i]}',
			ne_account = '{$_POST['s4_account'][$i]}',
			ne_accname = '{$_POST['s4_accname'][$i]}',
			ne_ceo = '{$_POST['s4_ceo'][$i]}',
			ne_etc = '{$_POST['s4_etc'][$i]}',
			
			
			ne_datetime = '".G5_TIME_YMDHIS."'
			
			where seq = '{$_POST['s4_seq'][$i]}'
			";
			
			sql_query($sql, true);
			
			sql_query("delete from {$none['est_jungsan_price']} where parent_id ='{$_POST['s4_seq'][$i]}' and ne_date = '$ne_date'");
		
			$sql = "insert into {$none['est_jungsan_price']} set 
			parent_id = '{$_POST['s4_seq'][$i]}',
			nw_code = '$nw_code',
			ne_date = '$ne_date',
			ne_price9 = '{$_POST['s4_price9'][$i]}',
			ne_price10 = '{$_POST['s4_price10'][$i]}',
			ne_price11 = '{$_POST['s4_price11'][$i]}',
			ne_price12 = '{$_POST['s4_price12'][$i]}',
			ne_price13 = '{$_POST['s4_price13'][$i]}',
			ne_price14 = '{$_POST['s4_price14'][$i]}'
			
			";
			sql_query($sql, true);
		
		}
		
		
	}
	$msg = "수정";
}

//기타경비

if($mode5 == '') {
	for($i=0; $i<count($_POST['s5_name']); $i++) {
		
		if(!$_POST['s5_name'][$i]) continue;
		
		if($_POST['s5_name'][$i] == "본사") 
			$admin_chk = 1;
		else
			$admin_chk = 0;
				
		$sql = "insert into {$none['est_jungsan']} set 
		nw_code = '$nw_code',
		mb_id = '{$member['mb_id']}',
		ne_type = '5',
		ne_date = '$ne_date',
		ne_name = '{$_POST['s5_name'][$i]}',
		ne_admin = '{$admin_chk}',
		ne_gongjong = '{$_POST['s5_gongjong'][$i]}',
		ne_sdate = '{$_POST['s5_sdate'][$i]}',
		ne_edate = '{$_POST['s5_edate'][$i]}',
		ne_price1 = '{$_POST['s5_price1'][$i]}',
		ne_price2 = '{$_POST['s5_price2'][$i]}',
		ne_price3 = '{$_POST['s5_price3'][$i]}',
		ne_price4 = '{$_POST['s5_price4'][$i]}',
		ne_price5 = '{$_POST['s5_price5'][$i]}',
		
		
		
		ne_price18 = '{$_POST['s5_price18'][$i]}',
		ne_bank = '{$_POST['s5_bank'][$i]}',
		ne_account = '{$_POST['s5_account'][$i]}',
		ne_accname = '{$_POST['s5_accname'][$i]}',
		ne_ceo = '{$_POST['s5_ceo'][$i]}',
		ne_etc = '{$_POST['s5_etc'][$i]}',
		
		
		ne_datetime = '".G5_TIME_YMDHIS."'
		
		";
		
		sql_query($sql, true);
		$id = sql_insert_id();
		$sql = "insert into {$none['est_jungsan_price']} set 
		parent_id = '{$id}',
		nw_code = '$nw_code',
		ne_date = '$ne_date',
		ne_price9 = '{$_POST['s5_price9'][$i]}',
		ne_price10 = '{$_POST['s5_price10'][$i]}',
		ne_price11 = '{$_POST['s5_price11'][$i]}',
		ne_price12 = '{$_POST['s5_price12'][$i]}',
		ne_price13 = '{$_POST['s5_price13'][$i]}',
		ne_price14 = '{$_POST['s5_price14'][$i]}'
		
		";
		sql_query($sql, true);
		
	}
	
	$msg = "등록";

} else if($mode5 == 'u') {
	
	for($i=0; $i<count($_POST['s5_name']); $i++) {
		
		if(!$_POST['s5_seq'][$i]){
			
			if(!$_POST['s5_name'][$i]) continue;
			
			if($_POST['s5_name'][$i] == "본사") 
				$admin_chk = 1;
			else
				$admin_chk = 0;
				
			$sql = "insert into {$none['est_jungsan']} set 
			nw_code = '$nw_code',
			mb_id = '{$member['mb_id']}',
			ne_type = '5',
			ne_date = '$ne_date',
			ne_name = '{$_POST['s5_name'][$i]}',
			ne_admin = '{$admin_chk}',
			ne_gongjong = '{$_POST['s5_gongjong'][$i]}',
			ne_sdate = '{$_POST['s5_sdate'][$i]}',
			ne_edate = '{$_POST['s5_edate'][$i]}',
			ne_price1 = '{$_POST['s5_price1'][$i]}',
			ne_price2 = '{$_POST['s5_price2'][$i]}',
			ne_price3 = '{$_POST['s5_price3'][$i]}',
			ne_price4 = '{$_POST['s5_price4'][$i]}',
			
			ne_price5 = '{$_POST['s5_price5'][$i]}',
			
			
			
			
			ne_price18 = '{$_POST['s5_price18'][$i]}',
			ne_bank = '{$_POST['s5_bank'][$i]}',
			ne_account = '{$_POST['s5_account'][$i]}',
			ne_accname = '{$_POST['s5_accname'][$i]}',
			ne_ceo = '{$_POST['s5_ceo'][$i]}',
			ne_etc = '{$_POST['s5_etc'][$i]}',
			
			
			ne_datetime = '".G5_TIME_YMDHIS."'
			
			";
			
			sql_query($sql, true);
			
			$id = sql_insert_id();
			$sql = "insert into {$none['est_jungsan_price']} set 
			parent_id = '{$id}',
			nw_code = '$nw_code',
			ne_date = '$ne_date',
			ne_price9 = '{$_POST['s5_price9'][$i]}',
			ne_price10 = '{$_POST['s5_price10'][$i]}',
			ne_price11 = '{$_POST['s5_price11'][$i]}',
			ne_price12 = '{$_POST['s5_price12'][$i]}',
			ne_price13 = '{$_POST['s5_price13'][$i]}',
			ne_price14 = '{$_POST['s5_price14'][$i]}'
			
			";
			sql_query($sql, true);
			
		} else if($_POST['s5_name'][$i]) {
		
			if($_POST['s5_name'][$i] == "본사") 
				$admin_chk = 1;
			else
				$admin_chk = 0;
			
			$sql = "update {$none['est_jungsan']} set 
			ne_name = '{$_POST['s5_name'][$i]}',
			ne_admin = '{$admin_chk}',
			ne_gongjong = '{$_POST['s5_gongjong'][$i]}',
			ne_sdate = '{$_POST['s5_sdate'][$i]}',
			ne_edate = '{$_POST['s5_edate'][$i]}',
			ne_price1 = '{$_POST['s5_price1'][$i]}',
			ne_price2 = '{$_POST['s5_price2'][$i]}',
			ne_price3 = '{$_POST['s5_price3'][$i]}',
			ne_price4 = '{$_POST['s5_price4'][$i]}',
			ne_price5 = '{$_POST['s5_price5'][$i]}',
			ne_price18 = '{$_POST['s5_price18'][$i]}',
			ne_bank = '{$_POST['s5_bank'][$i]}',
			ne_account = '{$_POST['s5_account'][$i]}',
			ne_accname = '{$_POST['s5_accname'][$i]}',
			ne_ceo = '{$_POST['s5_ceo'][$i]}',
			ne_etc = '{$_POST['s5_etc'][$i]}',
			ne_datetime = '".G5_TIME_YMDHIS."'
			
			where seq = '{$_POST['s5_seq'][$i]}'
			";
			
			sql_query($sql, true);
			
			sql_query("delete from {$none['est_jungsan_price']} where parent_id ='{$_POST['s5_seq'][$i]}' and ne_date = '$ne_date'", true);
			
			$sql = "insert into {$none['est_jungsan_price']} set 
			parent_id = '{$_POST['s5_seq'][$i]}',
			nw_code = '{$nw_code}',
			ne_date = '{$ne_date}',
			ne_price9 = '{$_POST['s5_price9'][$i]}',
			ne_price10 = '{$_POST['s5_price10'][$i]}',
			ne_price11 = '{$_POST['s5_price11'][$i]}',
			ne_price12 = '{$_POST['s5_price12'][$i]}',
			ne_price13 = '{$_POST['s5_price13'][$i]}',
			ne_price14 = '{$_POST['s5_price14'][$i]}'
			
			";
			sql_query($sql, true);
		}
		
		
	}
	$msg = "수정";
}
alert('정산서 업데이트가 완료되었습니다.');