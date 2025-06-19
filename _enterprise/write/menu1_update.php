<?php 
include_once('../../_common.php');

if($is_guest) alert('권한이 없습니다.', G5_URL);


$sql_common ="
no_id_1 = '$no_id_1',
no_id_2 = '$no_id_2',
no_id_3 = '$no_id_3',
no_category = '$no_category',
no_company = '$no_company',
no_bname = '$no_bname',
no_bnum = '$no_bnum',
no_gongjong = '$no_gongjong',
no_btel = '$no_btel',
no_bfax = '$no_bfax',
no_bemail = '$no_bemail',
no_homepage = '$no_homepage',
no_baddr = '$no_baddr',
no_bank = '$no_bank',
no_account = '$no_account',
no_acc_holder = '$no_acc_holder',
no_name = '$no_name',
no_tel = '$no_tel',
no_hp = '$no_hp',
no_email = '$no_email',
no_position = '$no_position',
no_memo = '$no_memo'


";

if($w == '') {
	
	$sql = "insert into {$none['enterprise_list']} set {$sql_common}, no_datetime = '".G5_TIME_YMDHIS."', no_ip = '".$_SERVER['REMOTE_ADDR']."'";
	
	sql_query($sql, true);
	
	alert('업체 정보가 추가되었습니다.', '/_enterprise/list/menu1_list.php');
	
} else if($w == 'u') {
	
	$sql = "update {$none['enterprise_list']} set {$sql_common} where seq = '$seq'";
	
	sql_query($sql);
	
	alert('업체 정보가 수정되었습니다.');
	
} else if($w == 'd') {
	
	$sql = "delete from {$none['enterprise_list']} where seq = '$seq'";
	
	sql_query($sql);
	
	alert('업체 정보가 삭제되었습니다.');
}

?>