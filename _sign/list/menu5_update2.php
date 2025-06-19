<?php 
include_once('../../_common.php');
define('menu_sign', true);

if($member['mb_level2'] == 3) $is_admin = true; 

if(!$is_admin) alert('권한이 없습니다.');

	
sql_query("update  {$none['sign_line']} set ns_id1 = '$ns_id1', ns_id2 = '$ns_id2', ns_id3 = '$ns_id3', ns_id4 = '$ns_id4', ns_id5 = '$ns_id5', ns_datetime = '".G5_TIME_YMDHIS."'");



alert('결재라인 설정이 일괄변경 되었습니다.');
?>