<?php 
include_once('../../_common.php');
define('menu_homepage', true);

if(!isset($_GET['seq']) ) exit;

$state = urldecode($_GET['state']);

if($w == 'u') {
	
	if(!isset($_GET['state']) ) exit;

	$sql = "update {$none['home_recruit']}  set  wr_state = '$state' where seq = '$seq' ";
	sql_query($sql, true);

	alert($state.'처리 되었습니다.');
	
} else if($w == 'd') {
	
	//파일삭제
	$file = sql_fetch("select * from {$none['home_recruit']} where seq = '$seq'");
	
	$dir = G5_DATA_PATH."/recruit/";
	for($i=1; $i<=5; $i++) {
		@unlink($dir.$file['wr_file'.$i]);
	}
	
	$sql = "delete from {$none['home_recruit']} where seq = '$seq' ";
	sql_query($sql, true);

	alert('입사지원서가 삭제 되었습니다.');
	
}