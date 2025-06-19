<?php
include_once('../_common.php');

if($is_guest)
	alert('로그인 후 이용바랍니다.');



$file = sql_fetch("select * from {$g5['board_file_table']} where seq = '$seq'");

if(!$file) alert('삭제할 파일이 존재 하지 않습니다.');


//파일삭제
$dest_file = NONE_PATH.'/_data/draft/'.$file['bf_file'];
@unlink($dest_file);

//db삭제
@sql_query("delete from {$g5['board_file_table']} where seq = '$seq'");

alert('첨부파일이 삭제되었습니다.');