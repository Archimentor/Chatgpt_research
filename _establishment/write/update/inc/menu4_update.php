<?php 
include_once('../../../../_common.php');

ini_set('display_error;s', 1);
error_reporting(E_ALL);

if($is_guest) alert('로그인 후 이용바랍니다.');

if($mode == 'd') {
	@sql_query("delete from {$none['est_noim2']} where nw_code = '{$_GET['nw_code']}' and ne_date = '{$_GET['ne_date']}'");
	
	alert('노임대장이 초기화 되었습니다.');
} else {

//기입력 된 db초기화 후 재입력 
@sql_query("delete from {$none['est_noim2']} where ne_sort = 1 and nw_code = '{$_POST['nw_code']}' and ne_date = '{$_POST['ne_date']}'");
@sql_query("delete from {$none['est_noim2']} where ne_sort = 2 and nw_code = '{$_POST['nw_code']}' and ne_date = '{$_POST['ne_date']}'");
@sql_query("delete from {$none['est_noim2']} where ne_sort = 3 and nw_code = '{$_POST['nw_code']}' and ne_date = '{$_POST['ne_date']}'");

for($i=1; $i<=15; $i++) {
	$v = $i-1;
	$ne_day = array();
	for($a=1; $a<=31; $a++) {
		$neday = $_POST['ne_day'.$a][$v];
		
		if(!$neday) $neday = 0;
		
		$ne_day[] = $neday;
	}
	$ne_day2 = implode('|', $ne_day);

	if(isset($_POST['ne_gisan'][1][$v])) 
		$ne_gisan = 1;
	else 
		$ne_gisan = 0;
		
	$sql_common = "
ne_sort = '1',
nw_code = '{$_POST['nw_code']}',
ne_date = '{$_POST['ne_date']}',
ne_name = '{$_POST['ne_name'][$v]}',
ne_gongjong = '{$_POST['ne_gongjong'][$v]}',
ne_num = '{$_POST['ne_num'][$v]}',
ne_hp = '{$_POST['ne_hp'][$v]}',
ne_addr1 = '{$_POST['ne_addr1'][$v]}',
ne_addr2 = '{$_POST['ne_addr2'][$v]}',
ne_day = '{$ne_day2}',
ne_day_total = '{$_POST['ne_day_total'][$v]}',
ne_gongsu = '{$_POST['ne_gongsu'][$v]}',
ne_danga = '{$_POST['ne_danga'][$v]}',
ne_mny_total = '{$_POST['ne_mny_total'][$v]}',
ne_tax1 = '{$_POST['ne_tax1'][$v]}',
ne_tax2 = '{$_POST['ne_tax2'][$v]}',
ne_tax3 = '{$_POST['ne_tax3'][$v]}',
ne_tax4 = '{$_POST['ne_tax4'][$v]}',
ne_tax5 = '{$_POST['ne_tax5'][$v]}',
ne_tax6 = '{$_POST['ne_tax6'][$v]}',
ne_tax_total = '{$_POST['ne_tax_total'][$v]}',
ne_mny_last = '{$_POST['ne_mny_last'][$v]}',
ne_bank = '{$_POST['ne_bank'][$v]}',
ne_account = '{$_POST['ne_account'][$v]}',
ne_accname = '{$_POST['ne_accname'][$v]}',
ne_etc = '{$_POST['ne_etc'][$v]}',
ne_company = '{$_POST['ne_company'][$v]}',
ne_gisan = '{$ne_gisan}',
ne_datetime = '".G5_TIME_YMDHIS."',
ne_ip = '".$_SERVER['REMOTE_ADDR']."'
";

	$sql = "insert into {$none['est_noim2']} set {$sql_common}";
	sql_query($sql);
	
	$ne_day2 = "";
}
unset($i);
unset($sql);


for($i=16; $i<=30; $i++) {
	$v = $i-1;
	$c = $v-15;
	$ne_day = array();
	for($a=1; $a<=31; $a++) {
		$neday = $_POST['ne_day'.$a][$v];
		
		if(!$neday) $neday = 0;
		
		$ne_day[] = $neday;
	}
	$ne_day2 = implode('|', $ne_day);


	if(isset($_POST['ne_gisan'][2][$c])) 
		$ne_gisan = 1;
	else 
		$ne_gisan = 0;
	
	$sql_common = "
ne_sort = '2',
nw_code = '{$_POST['nw_code']}',
ne_date = '{$_POST['ne_date']}',
ne_name = '{$_POST['ne_name'][$v]}',
ne_gongjong = '{$_POST['ne_gongjong'][$v]}',
ne_num = '{$_POST['ne_num'][$v]}',
ne_hp = '{$_POST['ne_hp'][$v]}',
ne_addr1 = '{$_POST['ne_addr1'][$v]}',
ne_addr2 = '{$_POST['ne_addr2'][$v]}',
ne_day = '{$ne_day2}',
ne_day_total = '{$_POST['ne_day_total'][$v]}',
ne_gongsu = '{$_POST['ne_gongsu'][$v]}',
ne_danga = '{$_POST['ne_danga'][$v]}',
ne_mny_total = '{$_POST['ne_mny_total'][$v]}',
ne_tax1 = '{$_POST['ne_tax1'][$v]}',
ne_tax2 = '{$_POST['ne_tax2'][$v]}',
ne_tax3 = '{$_POST['ne_tax3'][$v]}',
ne_tax4 = '{$_POST['ne_tax4'][$v]}',
ne_tax5 = '{$_POST['ne_tax5'][$v]}',
ne_tax6 = '{$_POST['ne_tax6'][$v]}',
ne_tax_total = '{$_POST['ne_tax_total'][$v]}',
ne_mny_last = '{$_POST['ne_mny_last'][$v]}',
ne_bank = '{$_POST['ne_bank'][$v]}',
ne_account = '{$_POST['ne_account'][$v]}',
ne_accname = '{$_POST['ne_accname'][$v]}',
ne_etc = '{$_POST['ne_etc'][$v]}',
ne_company = '{$_POST['ne_company'][$v]}',
ne_gisan = '{$ne_gisan}',
ne_datetime = '".G5_TIME_YMDHIS."',
ne_ip = '".$_SERVER['REMOTE_ADDR']."'
";

	$sql = "insert into {$none['est_noim2']} set {$sql_common}";
	sql_query($sql);
	
	$ne_day2 = "";
}


for($i=31; $i<=45; $i++) {
	$v = $i-1;
	$c = $v-30;
	$ne_day = array();
	for($a=1; $a<=31; $a++) {
		$neday = $_POST['ne_day'.$a][$v];
		
		if(!$neday) $neday = 0;
		
		$ne_day[] = $neday;
	}
	$ne_day2 = implode('|', $ne_day);

	if(isset($_POST['ne_gisan'][3][$c])) 
		$ne_gisan = 1;
	else 
		$ne_gisan = 0;
	
	$sql_common = "
ne_sort = '3',
nw_code = '{$_POST['nw_code']}',
ne_date = '{$_POST['ne_date']}',
ne_name = '{$_POST['ne_name'][$v]}',
ne_gongjong = '{$_POST['ne_gongjong'][$v]}',
ne_num = '{$_POST['ne_num'][$v]}',
ne_hp = '{$_POST['ne_hp'][$v]}',
ne_addr1 = '{$_POST['ne_addr1'][$v]}',
ne_addr2 = '{$_POST['ne_addr2'][$v]}',
ne_day = '{$ne_day2}',
ne_day_total = '{$_POST['ne_day_total'][$v]}',
ne_gongsu = '{$_POST['ne_gongsu'][$v]}',
ne_danga = '{$_POST['ne_danga'][$v]}',
ne_mny_total = '{$_POST['ne_mny_total'][$v]}',
ne_tax1 = '{$_POST['ne_tax1'][$v]}',
ne_tax2 = '{$_POST['ne_tax2'][$v]}',
ne_tax3 = '{$_POST['ne_tax3'][$v]}',
ne_tax4 = '{$_POST['ne_tax4'][$v]}',
ne_tax5 = '{$_POST['ne_tax5'][$v]}',
ne_tax6 = '{$_POST['ne_tax6'][$v]}',
ne_tax_total = '{$_POST['ne_tax_total'][$v]}',
ne_mny_last = '{$_POST['ne_mny_last'][$v]}',
ne_bank = '{$_POST['ne_bank'][$v]}',
ne_account = '{$_POST['ne_account'][$v]}',
ne_accname = '{$_POST['ne_accname'][$v]}',
ne_etc = '{$_POST['ne_etc'][$v]}',
ne_company = '{$_POST['ne_company'][$v]}',
ne_gisan = '{$ne_gisan}',
ne_datetime = '".G5_TIME_YMDHIS."',
ne_ip = '".$_SERVER['REMOTE_ADDR']."'
";

	$sql = "insert into {$none['est_noim2']} set {$sql_common}";
	sql_query($sql);
	
	$ne_day2 = "";
}

alert('노임대장이 업데이트 되었습니다.');

}