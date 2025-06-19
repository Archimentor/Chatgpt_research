<?php 
include_once('../../_common.php');
define('menu_sign', true);

if($member['mb_level2'] == 3) $is_admin = true; 

if(!$is_admin) alert('권한이 없습니다.');


for($i=0; $i<=count($_POST['seq']); $i++) {
	$seq = $_POST['seq'][$i];
	$ns_id1 = $_POST['ns_id1'][$i];
	$ns_id2 = $_POST['ns_id2'][$i];
	$ns_id3 = $_POST['ns_id3'][$i];
	$ns_id4 = $_POST['ns_id4'][$i];
	$ns_id5 = $_POST['ns_id5'][$i];
	
	if(!$seq) continue;
	
sql_query("update  {$none['sign_line']} set ns_id1 = '$ns_id1', ns_id2 = '$ns_id2', ns_id3 = '$ns_id3', ns_id4 = '$ns_id4', ns_id5 = '$ns_id5', ns_datetime = '".G5_TIME_YMDHIS."' where seq = '$seq'");

}


alert('결재라인 설정이 변경 되었습니다.');
?>