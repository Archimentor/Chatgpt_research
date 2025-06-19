<?php 
include_once('../../_common.php');

if($is_guest) alert('권한이 없습니다.', G5_URL);


$sql_common = "
wr_answer = '$wr_answer'
";

if($w == 'u') {
	
	$sql = " update {$none['home_board']} set {$sql_common} where seq = '$seq' and bo_table = 'board7'";
	sql_query($sql);
	
	alert('답변이 작성 되었습니다.');
	
} else if($w == 'd') {
	if(!$is_admin) alert('권한이 없습니다.');
	
	$sql = " delete from {$none['home_board']} where seq = '$seq' and bo_table = 'board7'";
	sql_query($sql);
	
	alert('게시글이 삭제 되었습니다.', '/_worksite/list/menu6_list.php');
}